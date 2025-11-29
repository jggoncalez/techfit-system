import serial
import json
import mysql.connector
from datetime import datetime
import time

# Configurações do banco de dados
DB_CONFIG = {
    'host': 'localhost',
    'user': 'seu_usuario',
    'password': 'sua_senha',
    'database': 'seu_banco'
}

# Configuração da porta serial
PORTA_SERIAL = 'COM3'  # Windows: COM3, Linux: /dev/ttyUSB0
BAUD_RATE = 9600

def conectar_banco():
    """Conecta ao banco de dados MySQL"""
    try:
        return mysql.connector.connect(**DB_CONFIG)
    except mysql.connector.Error as e:
        print(f"Erro ao conectar ao banco: {e}")
        return None

def verificar_rfid(rfid_code):
    """Verifica se o RFID está cadastrado e ativo"""
    conn = conectar_banco()
    if not conn:
        return None, "Erro de conexão"
    
    cursor = conn.cursor(dictionary=True)
    
    query = """
        SELECT r.RFID_ID, r.US_ID, r.RFID_STATUS, r.RFID_DATA_EXPIRACAO,
               u.US_NOME
        FROM RFID_TAGS r
        INNER JOIN USUARIOS u ON r.US_ID = u.US_ID
        WHERE r.RFID_TAG_CODE = %s
    """
    
    cursor.execute(query, (rfid_code,))
    resultado = cursor.fetchone()
    
    cursor.close()
    conn.close()
    
    if not resultado:
        return None, "RFID não cadastrado"
    
    if resultado['RFID_STATUS'] != 'ATIVO':
        return None, f"RFID {resultado['RFID_STATUS']}"
    
    if resultado['RFID_DATA_EXPIRACAO']:
        if resultado['RFID_DATA_EXPIRACAO'] < datetime.now().date():
            return None, "RFID expirado"
    
    return resultado, "OK"

def registrar_entrada(us_id, rfid_id, status, motivo=None):
    """Registra a entrada no banco de dados"""
    conn = conectar_banco()
    if not conn:
        return False
    
    cursor = conn.cursor()
    
    query = """
        INSERT INTO REGISTRO_ENTRADAS 
        (US_ID, RFID_ID, RE_TIPO_ENTRADA, RE_STATUS, RE_MOTIVO_NEGACAO, RE_LOCALIZACAO)
        VALUES (%s, %s, 'RFID', %s, %s, 'Entrada Principal')
    """
    
    try:
        cursor.execute(query, (us_id, rfid_id, status, motivo))
        conn.commit()
        print(f"✓ Entrada registrada: {status}")
        return True
    except mysql.connector.Error as e:
        print(f"✗ Erro ao registrar: {e}")
        return False
    finally:
        cursor.close()
        conn.close()

def processar_leitura(rfid_code):
    """Processa a leitura do RFID"""
    print(f"\n{'='*50}")
    print(f"RFID Detectado: {rfid_code}")
    
    usuario, mensagem = verificar_rfid(rfid_code)
    
    if usuario:
        print(f"✓ Acesso PERMITIDO")
        print(f"  Usuário: {usuario['US_NOME']}")
        registrar_entrada(
            usuario['US_ID'], 
            usuario['RFID_ID'], 
            'PERMITIDO'
        )
    else:
        print(f"✗ Acesso NEGADO")
        print(f"  Motivo: {mensagem}")
        registrar_entrada(None, None, 'NEGADO', mensagem)
    
    print(f"{'='*50}\n")

def main():
    """Função principal"""
    print("Iniciando sistema de controle de acesso...")
    
    try:
        arduino = serial.Serial(PORTA_SERIAL, BAUD_RATE, timeout=1)
        time.sleep(2)
        print(f"✓ Conectado à porta {PORTA_SERIAL}")
        print("Aguardando leituras RFID...\n")
        
        while True:
            if arduino.in_waiting > 0:
                linha = arduino.readline().decode('utf-8').strip()
                
                try:
                    # Tenta fazer parse JSON
                    dados = json.loads(linha)
                    rfid_code = dados.get('rfid')
                    
                    if rfid_code:
                        processar_leitura(rfid_code)
                        
                except json.JSONDecodeError:
                    # Se não for JSON, ignora (mensagens de debug do Arduino)
                    if linha and not linha.startswith("Sistema"):
                        print(f"Debug: {linha}")
            
            time.sleep(0.1)
    
    except serial.SerialException as e:
        print(f"✗ Erro na porta serial: {e}")
    except KeyboardInterrupt:
        print("\n\nEncerrando sistema...")
    finally:
        if 'arduino' in locals():
            arduino.close()
            print("Porta serial fechada.")

if __name__ == "__main__":
    main()
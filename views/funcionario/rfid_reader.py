import serial
import json
import mysql.connector
from datetime import datetime

# Configurações
DB_CONFIG = {
    'host': 'localhost',
    'user': 'root',
    'password': 'senaisp',
    'database': 'TechFitDatabase',
    'auth_plugin': 'mysql_native_password'
}
PORTA_SERIAL = 'COM3'
BAUD_RATE = 9600

def executar_query(query, params=None, fetch=False):
    """Executa query no banco de dados"""
    try:
        conn = mysql.connector.connect(**DB_CONFIG)
        cursor = conn.cursor(dictionary=True)
        cursor.execute(query, params or ())
        
        if fetch:
            resultado = cursor.fetchone()
        else:
            conn.commit()
            resultado = True
            
        cursor.close()
        conn.close()
        return resultado
    except mysql.connector.Error as e:
        print(f"Erro BD: {e}")
        return None

def verificar_rfid(rfid_code):
    """Verifica RFID e retorna dados do usuário"""
    query = """
        SELECT r.RFID_ID, r.US_ID, r.RFID_STATUS, r.RFID_DATA_EXPIRACAO, u.US_NOME
        FROM RFID_TAGS r
        INNER JOIN USUARIOS u ON r.US_ID = u.US_ID
        WHERE r.RFID_TAG_CODE = %s
    """
    resultado = executar_query(query, (rfid_code,), fetch=True)
    
    if not resultado:
        return None, "RFID não cadastrado"
    if resultado['RFID_STATUS'] != 'ATIVO':
        return None, f"RFID {resultado['RFID_STATUS']}"
    if resultado['RFID_DATA_EXPIRACAO'] and resultado['RFID_DATA_EXPIRACAO'] < datetime.now().date():
        return None, "RFID expirado"
    
    return resultado, "OK"

def registrar_entrada(us_id, rfid_id, status, motivo=None):
    """Registra entrada no banco"""
    query = """
        INSERT INTO REGISTRO_ENTRADAS 
        (US_ID, RFID_ID, RE_TIPO_ENTRADA, RE_STATUS, RE_MOTIVO_NEGACAO, RE_LOCALIZACAO)
        VALUES (%s, %s, 'RFID', %s, %s, 'Entrada Principal')
    """
    sucesso = executar_query(query, (us_id, rfid_id, status, motivo))
    print(f"{'✓' if sucesso else '✗'} Registro: {status}")

def processar_leitura(rfid_code):
    """Processa leitura RFID"""
    print(f"\n{'='*50}\nRFID: {rfid_code}")
    
    usuario, mensagem = verificar_rfid(rfid_code)
    
    if usuario:
        print(f"✓ PERMITIDO - {usuario['US_NOME']}")
        registrar_entrada(usuario['US_ID'], usuario['RFID_ID'], 'PERMITIDO')
    else:
        print(f"✗ NEGADO - {mensagem}")
        registrar_entrada(None, None, 'NEGADO', mensagem)
    
    print(f"{'='*50}\n")

def main():
    """Loop principal"""
    print("Iniciando sistema RFID...")
    
    try:
        arduino = serial.Serial(PORTA_SERIAL, BAUD_RATE, timeout=1)
        print(f"✓ Conectado em {PORTA_SERIAL}\nAguardando leituras...\n")
        
        while True:
            if arduino.in_waiting:
                linha = arduino.readline().decode('utf-8').strip()
                
                try:
                    dados = json.loads(linha)
                    if dados.get('rfid'):
                        processar_leitura(dados['rfid'])
                except json.JSONDecodeError:
                    if linha and not linha.startswith("Sistema"):
                        print(f"Debug: {linha}")
    
    except serial.SerialException as e:
        print(f"✗ Erro serial: {e}")
    except KeyboardInterrupt:
        print("\nEncerrando...")
    finally:
        if 'arduino' in locals():
            arduino.close()

if __name__ == "__main__":
    main()
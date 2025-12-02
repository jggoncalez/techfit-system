<?php

namespace models\acesso;

use config\Database;
use PDO;

class RegistroEntrada
{
    private $pdo;
    private $table = 'REGISTRO_ENTRADAS';

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
    }

    /**
     * Executar query com preparação automática
     */
    private function executar($sql, $params = [], $fetch = false)
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $fetch ? $stmt->fetchAll(PDO::FETCH_ASSOC) : true;
        } catch (\PDOException $e) {
            throw new \Exception("Erro no banco: " . $e->getMessage());
        }
    }

    /**
     * Criar registro de entrada
     */
    public function criar($usId, $rfidId, $tipoEntrada, $status, $motivo = null, $localizacao = null)
    {
        $sql = "INSERT INTO {$this->table} 
                (US_ID, RFID_ID, RE_TIPO_ENTRADA, RE_STATUS, RE_MOTIVO_NEGACAO, RE_LOCALIZACAO) 
                VALUES (?, ?, ?, ?, ?, ?)";
        
        return $this->executar($sql, [$usId, $rfidId, $tipoEntrada, $status, $motivo, $localizacao]);
    }

    /**
     * Obter registros com joins
     */
    public function obterTodos($limit = 50)
    {
        $sql = "SELECT re.*, u.US_NOME, u.US_EMAIL, r.RFID_TAG_CODE
                FROM {$this->table} re
                LEFT JOIN USUARIOS u ON re.US_ID = u.US_ID
                LEFT JOIN RFID_TAGS r ON re.RFID_ID = r.RFID_ID
                ORDER BY re.RE_DATA_HORA DESC
                LIMIT ?";
        
        return $this->executar($sql, [$limit], true);
    }

    /**
     * Obter por data
     */
    public function obterPorData($data)
    {
        $sql = "SELECT re.*, u.US_NOME, r.RFID_TAG_CODE
                FROM {$this->table} re
                LEFT JOIN USUARIOS u ON re.US_ID = u.US_ID
                LEFT JOIN RFID_TAGS r ON re.RFID_ID = r.RFID_ID
                WHERE DATE(re.RE_DATA_HORA) = ?
                ORDER BY re.RE_DATA_HORA DESC";
        
        return $this->executar($sql, [$data], true);
    }

    /**
     * Obter por usuário
     */
    public function obterPorUsuario($usId, $limit = 50)
    {
        $sql = "SELECT re.*, u.US_NOME, r.RFID_TAG_CODE
                FROM {$this->table} re
                LEFT JOIN USUARIOS u ON re.US_ID = u.US_ID
                LEFT JOIN RFID_TAGS r ON re.RFID_ID = r.RFID_ID
                WHERE re.US_ID = ?
                ORDER BY re.RE_DATA_HORA DESC
                LIMIT ?";
        
        return $this->executar($sql, [$usId, $limit], true);
    }

    /**
     * Obter por ID
     */
    public function obterPorId($reId)
    {
        $sql = "SELECT re.*, u.US_NOME, r.RFID_TAG_CODE
                FROM {$this->table} re
                LEFT JOIN USUARIOS u ON re.US_ID = u.US_ID
                LEFT JOIN RFID_TAGS r ON re.RFID_ID = r.RFID_ID
                WHERE re.RE_ID = ?";
        
        $result = $this->executar($sql, [$reId], true);
        return $result[0] ?? null;
    }

    /**
     * Contar registros por status
     */
    public function contar($status, $data = null)
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE RE_STATUS = ?";
        $params = [$status];
        
        if ($data) {
            $sql .= " AND DATE(RE_DATA_HORA) = ?";
            $params[] = $data;
        }
        
        $result = $this->executar($sql, $params, true);
        return $result[0]['total'] ?? 0;
    }

    /**
     * Atalhos para contagem
     */
    public function contarPermitidos($data = null)
    {
        return $this->contar('PERMITIDO', $data);
    }

    public function contarNegados($data = null)
    {
        return $this->contar('NEGADO', $data);
    }
}
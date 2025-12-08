<?php


namespace controllers\acesso;

require_once __DIR__ . "/../../models/acesso/RegistroEntrada.php";

use models\acesso\RegistroEntrada;

class RegistroEntradaController
{
    private $dao;

    public function __construct()
    {
        $this->dao = new RegistroEntrada();
    }

    // ==========================================
    // Criar novo registro de entrada
    // ==========================================
    public function criar($usId, $rfidId, $tipoEntrada, $status, $motivo = null, $localizacao = null)
    {
        return $this->dao->criar($usId, $rfidId, $tipoEntrada, $status, $motivo, $localizacao);
    }

    // ==========================================
    // Obter todos os registros (limit)
    // ==========================================
    public function obterTodos($limit = 50)
    {
        return $this->dao->obterTodos($limit);
    }

    // ==========================================
    // Obter registros por data
    // ==========================================
    public function obterPorData($data)
    {
        return $this->dao->obterPorData($data);
    }

    // ==========================================
    // Obter registros por usuário
    // ==========================================
    public function obterPorUsuario($usId, $limit = 50)
    {
        return $this->dao->obterPorUsuario($usId, $limit);
    }

    // ==========================================
    // Obter registro por ID
    // ==========================================
    public function obterPorId($reId)
    {
        return $this->dao->obterPorId($reId);
    }

    // ==========================================
    // Contagem de registros
    // ==========================================
    public function contar($status, $data = null)
    {
        return $this->dao->contar($status, $data);
    }

    public function contarPermitidos($data = null)
    {
        return $this->dao->contarPermitidos($data);
    }

    public function contarNegados($data = null)
    {
        return $this->dao->contarNegados($data);
    }
}


?>
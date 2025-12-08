<?php

namespace controllers;

require_once __DIR__ . "\\..\\models\\Funcionario.php";
require_once __DIR__ . "\\..\\config\\Database.php";

use config\Database;
use models\Funcionario;

class FuncionarioController
{
    public $FU_ID;
    public $FU_GENERO;
    public $FU_NIVEL_ACESSO;
    public $FU_SENHA;
    public $FU_NOME;
    public $FU_SALARIO;
    public $FU_DATA_ADMISSAO;

    private $dao;
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
        $this->dao = new Funcionario($this->db);
    }

    // ==========================================
    // CREATE
    // ==========================================
    public function create()
    {
        $this->dao->FU_GENERO       = $this->FU_GENERO;
        $this->dao->FU_NIVEL_ACESSO = $this->FU_NIVEL_ACESSO;
        $this->dao->FU_SENHA        = $this->FU_SENHA;
        $this->dao->FU_NOME         = $this->FU_NOME;
        $this->dao->FU_SALARIO      = $this->FU_SALARIO;
        $this->dao->FU_DATA_ADMISSAO= $this->FU_DATA_ADMISSAO;

        return $this->dao->create();;
    }

    // ==========================================
    // READ BY ID
    // ==========================================
    public function searchID()
    {
        $this->dao->FU_ID = $this->FU_ID;
        return $this->dao->searchID();
    }

    // ==========================================
    // LIST ALL
    // ==========================================
    public function list()
    {
        return $this->dao->list();
    }

    // ==========================================
    // UPDATE
    // ==========================================
    public function update()
    {
        $this->dao->FU_ID           = $this->FU_ID;
        $this->dao->FU_GENERO       = $this->FU_GENERO;
        $this->dao->FU_NIVEL_ACESSO = $this->FU_NIVEL_ACESSO;
        $this->dao->FU_SENHA        = $this->FU_SENHA;
        $this->dao->FU_NOME         = $this->FU_NOME;
        $this->dao->FU_SALARIO      = $this->FU_SALARIO;
        $this->dao->FU_DATA_ADMISSAO= $this->FU_DATA_ADMISSAO;

        return $this->dao->update();
    }

    // ==========================================
    // DELETE
    // ==========================================
    public function delete()
    {
        $this->dao->FU_ID = $this->FU_ID;
        return $this->dao->delete();
    }
}
?>
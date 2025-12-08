<?php

namespace controllers\sagef;
require_once __DIR__. "\\..\\..\\models\\sagef\\Treino.php";
require_once __DIR__ ."\\..\\..\\config\\Database.php";

use models\sagef\Treino;

use config\Database;

class TreinoController
{
    public $TR_ID;
    public $TR_NOME;
    public $TR_DATA_CRIACAO;
    public $US_ID;
    public $TR_DURACAO_ESTIMADA;
    public $TR_STATUS;
    public $TR_OBSERVACOES;
    private $db;
    private $dao;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
        $this->dao = new Treino($this->db);
    }

    public function create() {
    $this->dao->TR_NOME = $this->TR_NOME;
    $this->dao->TR_DATA_CRIACAO = $this->TR_DATA_CRIACAO;
    $this->dao->US_ID = $this->US_ID;
    $this->dao->TR_DURACAO_ESTIMADA = $this->TR_DURACAO_ESTIMADA;
    $this->dao->TR_STATUS = $this->TR_STATUS;
    $this->dao->TR_OBSERVACOES = $this->TR_OBSERVACOES;
        return $this->dao->create();
    }

    public function searchID() {
       return  $this->dao->searchID();
    }

    public function list() {
        return $this->dao->list();
    }

    public function update() {
        return $this->dao->update();
    }

    public function delete() {
       return  $this->dao->delete();
    }

    public function buscarUsuarios($usuarioSelecionado = null) {
        return $this->dao->buscarUsuarios($usuarioSelecionado);
    }

} ?>
<?php

namespace controllers\agendamento;
require_once __DIR__ . "\\..\\..\\models\\agendamento\\Aula.php";
require_once __DIR__ . "\\..\\..\\config\\Database.php";

use models\agendamento\Aula;
use config\Database;

class AulaController
{
    public $AU_ID;
    public $FU_ID;
    public $AU_NOME;
    public $AU_DATA;
    public $AU_HORA_INICIO;
    public $AU_HORA_FIM;
    public $AU_VAGAS_DISPONIVEIS;
    public $AU_VAGAS_TOTAIS;
    public $AU_SALA;
    public $AU_STATUS;
    public $AU_OBSERVACOES;

    private $db;
    private $dao;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
        $this->dao = new Aula($this->db);
    }

    public function create() {
        $this->dao->FU_ID = $this->FU_ID;
        $this->dao->AU_NOME = $this->AU_NOME;
        $this->dao->AU_DATA = $this->AU_DATA;
        $this->dao->AU_HORA_INICIO = $this->AU_HORA_INICIO;
        $this->dao->AU_HORA_FIM = $this->AU_HORA_FIM;
        $this->dao->AU_VAGAS_DISPONIVEIS = $this->AU_VAGAS_DISPONIVEIS;
        $this->dao->AU_VAGAS_TOTAIS = $this->AU_VAGAS_TOTAIS;
        $this->dao->AU_SALA = $this->AU_SALA;
        $this->dao->AU_STATUS = $this->AU_STATUS;
        $this->dao->AU_OBSERVACOES = $this->AU_OBSERVACOES;

        return $this->dao->create();
    }

    public function searchID() {
        return $this->dao->searchID();
    }

    public function list() {
        return $this->dao->list();
    }

    public function update() {
        return $this->dao->update();
    }

    public function delete() {
        return $this->dao->delete();
    }

    public function buscarFuncionarios($funcionarioSelecionado = null) {
        return $this->dao->buscarFuncionarios($funcionarioSelecionado);
    }
}
?>

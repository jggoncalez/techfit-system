<?php

namespace controllers\agendamento;
require_once __DIR__ . "\\..\\..\\models\\agendamento\\ParticipacoesAula.php";
require_once __DIR__ . "\\..\\..\\config\\Database.php";

use models\agendamento\ParticipacoesAula;
use config\Database;

class ParticipacoesAulaController
{
    public $PA_ID;
    public $AU_ID;
    public $US_ID;
    public $PA_DATA_INSCRICAO;
    public $PA_STATUS;
    public $PA_AVALIACAO;
    public $PA_COMENTARIO;

    private $db;
    private $dao;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
        $this->dao = new ParticipacoesAula($this->db);
    }

    public function create() {
        $this->dao->AU_ID = $this->AU_ID;
        $this->dao->US_ID = $this->US_ID;
        $this->dao->PA_DATA_INSCRICAO = $this->PA_DATA_INSCRICAO;
        $this->dao->PA_STATUS = $this->PA_STATUS;
        $this->dao->PA_AVALIACAO = $this->PA_AVALIACAO;
        $this->dao->PA_COMENTARIO = $this->PA_COMENTARIO;

        return $this->dao->create();
    }

    public function searchID() {
        $this->dao->PA_ID = $this->PA_ID;
        return $this->dao->searchID();
    }

    public function list() {
        return $this->dao->list();
    }

    public function update() {
        $this->dao->PA_ID = $this->PA_ID;
        $this->dao->AU_ID = $this->AU_ID;
        $this->dao->US_ID = $this->US_ID;
        $this->dao->PA_DATA_INSCRICAO = $this->PA_DATA_INSCRICAO;
        $this->dao->PA_STATUS = $this->PA_STATUS;
        $this->dao->PA_AVALIACAO = $this->PA_AVALIACAO;
        $this->dao->PA_COMENTARIO = $this->PA_COMENTARIO;
        return $this->dao->update();
    }

    public function delete() {
         $this->dao->PA_ID = $this->PA_ID;
        return $this->dao->delete();
    }

    public function buscarAvaliacoes() {
         $this->dao->PA_ID = $this->PA_ID;
        return $this->dao->buscarAvaliações();
    }

    public function atualizarVagasDisponiveis($aulaId) {
        return $this->dao->atualizarVagasDisponiveis($aulaId);
    }
}
?>

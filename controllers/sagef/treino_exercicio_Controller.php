<?php

namespace controllers\sagef;
require_once __DIR__ ."\\..\\..\\models\\sagef\\TreinoExercicios.php";
require_once __DIR__ ."\\..\\..\\config\\Database.php";

use config\Database;
use models\sagef\TreinoExercicios;

class TreinoExercicioController
{
    public $TE_ID;
    public $TR_ID;
    public $EX_ID;
    public $TE_ORDEM;
    public $TE_SERIES;
    public $TE_REPETICOES;
    public $TE_CARGA;
    public $TE_TEMPO_DESCANSO;
    public $TE_OBSERVACOES;
    public $TE_CONCLUIDO;
    private $dao; 
    private $db;
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
        $this->dao = new TreinoExercicios($this->db);

    }

    public function create() {
        $this->dao->TR_ID           = $this->TR_ID;
        $this->dao->EX_ID           = $this->EX_ID;
        $this->dao->TE_ORDEM        = $this->TE_ORDEM;
        $this->dao->TE_SERIES       = $this->TE_SERIES;
        $this->dao->TE_REPETICOES   = $this->TE_REPETICOES;
        $this->dao->TE_CARGA        = $this->TE_CARGA;
        $this->dao->TE_TEMPO_DESCANSO = $this->TE_TEMPO_DESCANSO;
        $this->dao->TE_OBSERVACOES  = $this->TE_OBSERVACOES;
        $this->dao->TE_CONCLUIDO    = $this->TE_CONCLUIDO;

        return $this->dao->create();
    }

    public function searchID(){
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
} ?>
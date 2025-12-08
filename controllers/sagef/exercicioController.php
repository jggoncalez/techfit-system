<?php

namespace controllers\sagef;
require_once __DIR__ ."\\..\\..\\models\\sagef\\Exercicio.php";
require_once __DIR__ ."\\..\\..\\config\\Database.php";

use config\Database;
use models\sagef\Exercicio;
class ExercicioController
{
    public $EX_ID;
    public $EX_NOME;
    public $EX_DESCRICAO;
    public $EX_TIPO;
    public $EX_DIFICULDADE;
    public $EX_EQUIPAMENTO;
    public $EX_MIN_REPETICOES;
    public $EX_MAX_REPETICOES;
    public $EX_TEMPO_DESCANSO;
    public $EX_PONTUACAO;
    private $db;
    private $dao;

    public function __construct()
    {
        $this-> db  = Database::getInstance()->getConnection();
        $this-> dao = new Exercicio($this->db);
    }

    public function create() {
        $this->EX_ID = $this->dao->EX_ID;
        $this->EX_NOME = $this->dao->EX_NOME;
        $this->EX_DESCRICAO = $this->dao->EX_DESCRICAO;
        $this->EX_TIPO = $this->dao->EX_TIPO;
        $this->EX_DIFICULDADE = $this->dao->EX_DIFICULDADE;
        $this->EX_EQUIPAMENTO = $this->dao->EX_EQUIPAMENTO;
        $this->EX_MIN_REPETICOES = $this->dao->EX_MIN_REPETICOES;
        $this->EX_MAX_REPETICOES = $this->dao->EX_MAX_REPETICOES;
        $this->EX_TEMPO_DESCANSO = $this->dao->EX_TEMPO_DESCANSO;
        $this->EX_PONTUACAO = $this->dao->EX_PONTUACAO;
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
} ?>
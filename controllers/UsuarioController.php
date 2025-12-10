<?php

namespace controllers;

require_once __DIR__ . "\\..\\models\\Usuario.php";
require_once __DIR__ . "\\..\\config\\Database.php";

use config\Database;
use models\Usuario;

class UsuarioController
{
    public $US_ID;
    public $US_NOME;
    public $US_GENERO;
    public $US_DATA_NASCIMENTO;
    public $US_ALTURA;
    public $US_PESO;
    public $US_OBJETIVO;
    public $US_TREINO_ANTERIOR;
    public $US_TEMPO_TREINOANT;
    public $US_ENDERECO;
    public $US_DISPONIBILIDADE;
    public $PL_ID;
    public $US_STATUS_PAGAMENTO;
    public $US_SENHA;

    private $dao;
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
        $this->dao = new Usuario($this->db);
    }

    // ==========================================
    // CREATE
    // ==========================================
    public function create()
    {
        $this->dao->US_NOME              = $this->US_NOME;
        $this->dao->US_GENERO            = $this->US_GENERO;
        $this->dao->US_DATA_NASCIMENTO   = $this->US_DATA_NASCIMENTO;
        $this->dao->US_ALTURA            = $this->US_ALTURA;
        $this->dao->US_PESO              = $this->US_PESO;
        $this->dao->US_OBJETIVO          = $this->US_OBJETIVO;
        $this->dao->US_TREINO_ANTERIOR   = $this->US_TREINO_ANTERIOR;
        $this->dao->US_TEMPO_TREINOANT   = $this->US_TEMPO_TREINOANT;
        $this->dao->US_ENDERECO          = $this->US_ENDERECO;
        $this->dao->US_DISPONIBILIDADE   = $this->US_DISPONIBILIDADE;
        $this->dao->PL_ID                = $this->PL_ID;
        $this->dao->US_STATUS_PAGAMENTO  = $this->US_STATUS_PAGAMENTO;

        return $this->dao->create();

    }

    // ==========================================
    // READ BY ID
    // ==========================================
 public function searchID()
{
    // 1. Passa o ID do Controller para o DAO para ele saber quem buscar
    $this->dao->US_ID = $this->US_ID;

    // 2. Manda o DAO buscar no banco
    $result = $this->dao->searchID();

    // 3. Se encontrou, copia TODOS os dados do DAO de volta para este Controller
    if ($result) {
        $this->US_NOME              = $this->dao->US_NOME;
        $this->US_GENERO            = $this->dao->US_GENERO;
        $this->US_DATA_NASCIMENTO   = $this->dao->US_DATA_NASCIMENTO;
        $this->US_ALTURA            = $this->dao->US_ALTURA;
        $this->US_PESO              = $this->dao->US_PESO;
        $this->US_OBJETIVO          = $this->dao->US_OBJETIVO;
        $this->US_TREINO_ANTERIOR   = $this->dao->US_TREINO_ANTERIOR;
        $this->US_TEMPO_TREINOANT   = $this->dao->US_TEMPO_TREINOANT;
        $this->US_ENDERECO          = $this->dao->US_ENDERECO;
        $this->US_DISPONIBILIDADE   = $this->dao->US_DISPONIBILIDADE;
        $this->PL_ID                = $this->dao->PL_ID;
        $this->US_STATUS_PAGAMENTO  = $this->dao->US_STATUS_PAGAMENTO;
        $this->US_SENHA             = $this->dao->US_SENHA; // Essencial para a troca de senha
        
        return true;
    }

    return false;
}

    // ==========================================
    // READ BY NAME
    // ==========================================
    public function searchNAME()
    {
        $this->dao->US_NOME = $this->US_NOME;
         $result = $this->dao->searchNAME();
    // 3. Se encontrou, copia TODOS os dados do DAO de volta para este Controller
    if ($result) {
        $this->US_ID             = $this->dao->US_ID;
        $this->US_GENERO            = $this->dao->US_GENERO;
        $this->US_DATA_NASCIMENTO   = $this->dao->US_DATA_NASCIMENTO;
        $this->US_ALTURA            = $this->dao->US_ALTURA;
        $this->US_PESO              = $this->dao->US_PESO;
        $this->US_OBJETIVO          = $this->dao->US_OBJETIVO;
        $this->US_TREINO_ANTERIOR   = $this->dao->US_TREINO_ANTERIOR;
        $this->US_TEMPO_TREINOANT   = $this->dao->US_TEMPO_TREINOANT;
        $this->US_ENDERECO          = $this->dao->US_ENDERECO;
        $this->US_DISPONIBILIDADE   = $this->dao->US_DISPONIBILIDADE;
        $this->PL_ID                = $this->dao->PL_ID;
        $this->US_STATUS_PAGAMENTO  = $this->dao->US_STATUS_PAGAMENTO;
        $this->US_SENHA             = $this->dao->US_SENHA; // Essencial para a troca de senha
        
        return true;
    }

    return false;
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
        $this->dao->US_ID                = $this->US_ID;
        $this->dao->US_NOME              = $this->US_NOME;
        $this->dao->US_GENERO            = $this->US_GENERO;
        $this->dao->US_DATA_NASCIMENTO   = $this->US_DATA_NASCIMENTO;
        $this->dao->US_ALTURA            = $this->US_ALTURA;
        $this->dao->US_PESO              = $this->US_PESO;
        $this->dao->US_OBJETIVO          = $this->US_OBJETIVO;
        $this->dao->US_TREINO_ANTERIOR   = $this->US_TREINO_ANTERIOR;
        $this->dao->US_TEMPO_TREINOANT   = $this->US_TEMPO_TREINOANT;
        $this->dao->US_ENDERECO          = $this->US_ENDERECO;
        $this->dao->US_DISPONIBILIDADE   = $this->US_DISPONIBILIDADE;
        $this->dao->PL_ID                = $this->PL_ID;
        $this->dao->US_STATUS_PAGAMENTO  = $this->US_STATUS_PAGAMENTO;

        return $this->dao->update();
    }

    // ==========================================
    // DELETE
    // ==========================================
    public function delete()
    {
        $this->dao->US_ID = $this->US_ID;
        return $this->dao->delete();
    }

    // ==========================================
    // DELETE RFID
    // ==========================================
    public function deleteRFID()
    {
        $this->dao->US_ID = $this->US_ID;
        return $this->dao->deleteRFID();
    }

    // ==========================================
    // ALTERAR SENHA
    // ==========================================
    public function trocarSenha($novaSenha)
    {
        $this->dao->US_ID   = $this->US_ID;
        return $this->dao->trocarSenha($novaSenha);
    }

    // ==========================================
    // TREINOS / AGENDAMENTOS / PARTICIPAÇÕES
    // (saem direto do model)
    // ==========================================
    public function buscarTreinos()
    {
        $this->dao->US_ID = $this->US_ID;
        return $this->dao->buscarTreinos();
    }

    public function buscarAgendamentos()
    {
        $this->dao->US_ID = $this->US_ID;
        return $this->dao->buscarAgendamentos();
    }

    public function buscarParticipacoes()
    {
        $this->dao->US_ID = $this->US_ID;
        return $this->dao->buscarParticipacoes();
    }

    public function buscarPlanos() {
        $this->dao->US_ID = $this->US_ID;
        return $this->dao->buscarPlanos();
    }
 }?>
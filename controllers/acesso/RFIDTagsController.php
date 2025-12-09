<?php
namespace controllers\acesso;

require_once __DIR__ . "/../../models/acesso/RFIDTags.php";
require_once __DIR__ . "\\..\\..\\config\\Database.php";

use models\acesso\RFIDTags;
use config\Database;

class RFIDTagsController
{
    private $db;
    private $model;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
        $this->model = new RFIDTags($this->db);
    }

    // ==========================================
    // Criar nova tag RFID
    // ==========================================
    public function criar($tagCode, $usId, $status, $dataEmissao, $dataExpiracao)
    {
        $this->model->RFID_TAG_CODE = $tagCode;
        $this->model->US_ID = $usId;
        $this->model->RFID_STATUS = $status;
        $this->model->RFID_DATA_EMISSAO = $dataEmissao;
        $this->model->RFID_DATA_EXPIRACAO = $dataExpiracao;

        return $this->model->create();
    }

    // ==========================================
    // Obter tag por ID
    // ==========================================
    public function obterPorId($rfidId)
    {
        $this->model->RFID_ID = $rfidId;
        if($this->model->searchID()) {
            return [
                'RFID_ID' => $this->model->RFID_ID,
                'RFID_TAG_CODE' => $this->model->RFID_TAG_CODE,
                'US_ID' => $this->model->US_ID,
                'RFID_STATUS' => $this->model->RFID_STATUS,
                'RFID_DATA_EMISSAO' => $this->model->RFID_DATA_EMISSAO,
                'RFID_DATA_EXPIRACAO' => $this->model->RFID_DATA_EXPIRACAO
            ];
        }
        return null;
    }

    // ==========================================
    // Listar todas as tags
    // ==========================================
    public function listar()
    {
        return $this->model->list()->fetchAll(\PDO::FETCH_ASSOC);
    }

    // ==========================================
    // Atualizar tag RFID
    // ==========================================
    public function atualizar($rfidId, $tagCode, $usId, $status, $dataEmissao, $dataExpiracao)
    {
        $this->model->RFID_ID = $rfidId;
        $this->model->RFID_TAG_CODE = $tagCode;
        $this->model->US_ID = $usId;
        $this->model->RFID_STATUS = $status;
        $this->model->RFID_DATA_EMISSAO = $dataEmissao;
        $this->model->RFID_DATA_EXPIRACAO = $dataExpiracao;

        return $this->model->update();
    }

    // ==========================================
    // Deletar tag RFID
    // ==========================================
    public function deletar($rfidId)
    {
        $this->model->RFID_ID = $rfidId;
        return $this->model->delete();
    }
}

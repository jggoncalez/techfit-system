<?php
    namespace models\acesso;

    use PDO;
    class RFIDTags{
        // Conexão
        private $conn;
        private $table = "RFID_TAGS";

        public $RFID_ID;
        public $RFID_TAG_CODE;
        public $US_ID;
        public $RFID_STATUS;
        public $RFID_DATA_EMISSAO;
        public $RFID_DATA_EXPIRACAO;

        public function __construct($db){
            $this -> conn = $db;
        }


        public function create(){
            $query = "INSERT INTO " . $this->table . " (RFID_TAG_CODE, US_ID, RFID_STATUS, RFID_DATA_EMISSAO, RFID_DATA_EXPIRACAO) VALUES (:rfid_tag_code, :us_id, :rfid_status, :rfid_data_emissao, :rfid_data_expiracao)";
            $stmt = $this->conn->prepare($query);

            $stmt -> bindParam(':rfid_tag_code', $this->RFID_TAG_CODE);
            $stmt -> bindParam(':us_id', $this->US_ID);
            $stmt -> bindParam(':rfid_status', $this->RFID_STATUS);
            $stmt -> bindParam(':rfid_data_emissao', $this->RFID_DATA_EMISSAO);
            $stmt -> bindParam(':rfid_data_expiracao', $this->RFID_DATA_EXPIRACAO);

            $stmt -> execute();
            return $stmt;
        }

        public function searchID() {
            $query = "SELECT * FROM " . $this->table . " WHERE RFID_ID = :rfid_id LIMIT 1";

            $stmt = $this -> conn -> prepare($query);
            $stmt -> bindParam(':rfid_id', $this->RFID_ID);
            $stmt -> execute();

            $row = $stmt -> fetch(PDO::FETCH_ASSOC);

            if($row) {
                $this->RFID_TAG_CODE = $row['RFID_TAG_CODE'];
                $this->US_ID = $row['US_ID'];
                $this->RFID_STATUS = $row['RFID_STATUS'];
                $this->RFID_DATA_EMISSAO = $row['RFID_DATA_EMISSAO'];
                $this->RFID_DATA_EXPIRACAO = $row['RFID_DATA_EXPIRACAO'];
                return true;
            }

            return false;
        }

        public function list(){
            $query = "SELECT * FROM " .  $this->table;
            $stmt = $this->conn->prepare($query);
            
            $stmt -> execute();

            return $stmt;
        }

        public function update(){
            $query = "UPDATE {$this->table} SET
                RFID_TAG_CODE = :rfid_tag_code, 
                US_ID = :us_id,
                RFID_STATUS = :rfid_status,
                RFID_DATA_EMISSAO = :rfid_data_emissao,
                RFID_DATA_EXPIRACAO = :rfid_data_expiracao
                WHERE RFID_ID = :rfid_id";
            $stmt = $this->conn->prepare($query);
            
            $stmt -> bindParam(':rfid_tag_code', $this->RFID_TAG_CODE);
            $stmt -> bindParam(':us_id', $this->US_ID);
            $stmt -> bindParam(':rfid_status', $this->RFID_STATUS);
            $stmt -> bindParam(':rfid_data_emissao', $this->RFID_DATA_EMISSAO);
            $stmt -> bindParam(':rfid_data_expiracao', $this->RFID_DATA_EXPIRACAO);
            $stmt -> bindParam(':rfid_id', $this->RFID_ID);
            
            $stmt->execute();

            return $stmt;
        }

        public function delete(){
            $query = "DELETE FROM " . $this -> table . " WHERE RFID_ID = :rfid_id";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':rfid_id', $this->RFID_ID);

            $stmt -> execute();

            return $stmt;
        }  
    }

<?php
    namespace models\acesso;

    use PDO;
    class RegistroEntrada{
        // Conexão
        private $conn;
        private $table = "REGISTRO_ENTRADA";

        public $RE_ID;
        public $US_ID;
        public $RFID_ID;
        public $RE_DATA_HORA;
        public $RE_TIPO_ENTRADA;
        public $RE_STATUS;
        public $RE_MOTIVO_NEGACAO;
        public $RE_LOCALIZACAO;

        public function __construct($db){
            $this -> conn = $db;
        }


        public function create(){
            $query = "INSERT INTO " . $this->table . " (US_ID, RFID_ID, RE_DATA_HORA, RE_TIPO_ENTRADA, RE_STATUS, RE_MOTIVO_NEGACAO, RE_LOCALIZACAO) VALUES (:us_id, :rfid_id, :re_data_hora, :re_tipo_entrada, :re_status, :re_motivo_negacao, :re_localizacao)";
            $stmt = $this->conn->prepare($query);

            $stmt -> bindParam(':us_id', $this->US_ID);
            $stmt -> bindParam(':rfid_id', $this->RFID_ID);
            $stmt -> bindParam(':re_data_hora', $this->RE_DATA_HORA);
            $stmt -> bindParam(':re_tipo_entrada', $this->RE_TIPO_ENTRADA);
            $stmt -> bindParam(':re_status', $this->RE_STATUS);
            $stmt -> bindParam(':re_motivo_negacao', $this->RE_MOTIVO_NEGACAO);
            $stmt -> bindParam(':re_localizacao', $this->RE_LOCALIZACAO);

            $stmt -> execute();
            return $stmt;
        }

        public function searchID() {
            $query = "SELECT * FROM " . $this->table . " WHERE RE_ID = :re_id LIMIT 1";

            $stmt = $this -> conn -> prepare($query);
            $stmt -> bindParam(':re_id', $this->RE_ID);
            $stmt -> execute();

            $row = $stmt -> fetch(PDO::FETCH_ASSOC);

            if($row) {
                $this->US_ID = $row['US_ID'];
                $this->RFID_ID = $row['RFID_ID'];
                $this->RE_DATA_HORA = $row['RE_DATA_HORA'];
                $this->RE_TIPO_ENTRADA = $row['RE_TIPO_ENTRADA'];
                $this->RE_STATUS = $row['RE_STATUS'];
                $this->RE_MOTIVO_NEGACAO = $row['RE_MOTIVO_NEGACAO'];
                $this->RE_LOCALIZACAO = $row['RE_LOCALIZACAO'];
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
                US_ID = :us_id, 
                RFID_ID = :rfid_id,
                RE_DATA_HORA = :re_data_hora,
                RE_TIPO_ENTRADA = :re_tipo_entrada,
                RE_STATUS = :re_status,
                RE_MOTIVO_NEGACAO = :re_motivo_negacao,
                RE_LOCALIZACAO = :re_localizacao
                WHERE RE_ID = :re_id";
            $stmt = $this->conn->prepare($query);
            
            $stmt -> bindParam(':us_id', $this->US_ID);
            $stmt -> bindParam(':rfid_id', $this->RFID_ID);
            $stmt -> bindParam(':re_data_hora', $this->RE_DATA_HORA);
            $stmt -> bindParam(':re_tipo_entrada', $this->RE_TIPO_ENTRADA);
            $stmt -> bindParam(':re_status', $this->RE_STATUS);
            $stmt -> bindParam(':re_motivo_negacao', $this->RE_MOTIVO_NEGACAO);
            $stmt -> bindParam(':re_localizacao', $this->RE_LOCALIZACAO);
            $stmt -> bindParam(':re_id', $this->RE_ID);
            
            $stmt->execute();

            return $stmt;
        }

        public function delete(){
            $query = "DELETE FROM " . $this -> table . " WHERE RE_ID = :re_id";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':re_id', $this->RE_ID);

            $stmt -> execute();

            return $stmt;
        }  
    }
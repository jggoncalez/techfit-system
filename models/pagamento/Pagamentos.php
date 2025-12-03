<?php
    namespace models\pagamento;

    use PDO;
    class Pagamentos{
        // Conexão
        private $conn;
        private $table = "PAGAMENTO";

        public $PG_ID;
        public $US_ID;
        public $PL_ID;
        public $PG_VALOR;
        public $PG_DATA_VENCIMENTO;
        public $PG_DATA_PAGAMENTO;
        public $PG_STATUS;
        public $PG_METODO_PAGAMENTO;
        public $PG_OBSERVACOES;

        public function __construct($db){
            $this -> conn = $db;
        }


        public function create(){
            $query = "INSERT INTO " . $this->table . " (US_ID, PL_ID, PG_VALOR, PG_DATA_VENCIMENTO, PG_DATA_PAGAMENTO, PG_STATUS, PG_METODO_PAGAMENTO, PG_OBSERVACOES) VALUES (:us_id, :pl_id, :pg_valor, :pg_data_vencimento, :pg_data_pagamento, :pg_status, :pg_metodo_pagamento, :pg_observacoes)";
            $stmt = $this->conn->prepare($query);

            $stmt -> bindParam(':us_id', $this->US_ID);
            $stmt -> bindParam(':pl_id', $this->PL_ID);
            $stmt -> bindParam(':pg_valor', $this->PG_VALOR);
            $stmt -> bindParam(':pg_data_vencimento', $this->PG_DATA_VENCIMENTO);
            $stmt -> bindParam(':pg_data_pagamento', $this->PG_DATA_PAGAMENTO);
            $stmt -> bindParam(':pg_status', $this->PG_STATUS);
            $stmt -> bindParam(':pg_metodo_pagamento', $this->PG_METODO_PAGAMENTO);
            $stmt -> bindParam(':pg_observacoes', $this->PG_OBSERVACOES);

            $stmt -> execute();
            return $stmt;
        }

        public function searchID() {
            $query = "SELECT * FROM " . $this->table . " WHERE PG_ID = :pg_id LIMIT 1";

            $stmt = $this -> conn -> prepare($query);
            $stmt -> bindParam(':pg_id', $this->PG_ID);
            $stmt -> execute();

            $row = $stmt -> fetch(PDO::FETCH_ASSOC);

            if($row) {
                $this->US_ID = $row['US_ID'];
                $this->PL_ID = $row['PL_ID'];
                $this->PG_VALOR = $row['PG_VALOR'];
                $this->PG_DATA_VENCIMENTO = $row['PG_DATA_VENCIMENTO'];
                $this->PG_DATA_PAGAMENTO = $row['PG_DATA_PAGAMENTO'];
                $this->PG_STATUS = $row['PG_STATUS'];
                $this->PG_METODO_PAGAMENTO = $row['PG_METODO_PAGAMENTO'];
                $this->PG_OBSERVACOES = $row['PG_OBSERVACOES'];
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
                PL_ID = :pl_id,
                PG_VALOR = :pg_valor,
                PG_DATA_VENCIMENTO = :pg_data_vencimento,
                PG_DATA_PAGAMENTO = :pg_data_pagamento,
                PG_STATUS = :pg_status,
                PG_METODO_PAGAMENTO = :pg_metodo_pagamento,
                PG_OBSERVACOES = :pg_observacoes
                WHERE PG_ID = :pg_id";
            $stmt = $this->conn->prepare($query);
            
            $stmt -> bindParam(':us_id', $this->US_ID);
            $stmt -> bindParam(':pl_id', $this->PL_ID);
            $stmt -> bindParam(':pg_valor', $this->PG_VALOR);
            $stmt -> bindParam(':pg_data_vencimento', $this->PG_DATA_VENCIMENTO);
            $stmt -> bindParam(':pg_data_pagamento', $this->PG_DATA_PAGAMENTO);
            $stmt -> bindParam(':pg_status', $this->PG_STATUS);
            $stmt -> bindParam(':pg_metodo_pagamento', $this->PG_METODO_PAGAMENTO);
            $stmt -> bindParam(':pg_observacoes', $this->PG_OBSERVACOES);
            $stmt -> bindParam(':pg_id', $this->PG_ID);
            
            $stmt->execute();

            return $stmt;
        }

        public function delete(){
            $query = "DELETE FROM " . $this -> table . " WHERE PG_ID = :pg_id";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':pg_id', $this->PG_ID);

            $stmt -> execute();

            return $stmt;
        }  
    }

<?php
    namespace models\pagamento;

    use PDO;
    class Planos{
        // Conexão
        private $conn;
        private $table = "PLANOS";

        public $PL_ID;
        public $PL_NOME;
        public $PL_BENEFICIOS;
        public $PL_ATIVO;
        public $PL_DATA_CRIACAO;

        public function __construct($db){
            $this -> conn = $db;
        }


        public function create(){
            $query = "INSERT INTO " . $this->table . " (PL_NOME, PL_BENEFICIOS, PL_ATIVO, PL_DATA_CRIACAO) VALUES (:pl_nome, :pl_beneficios, :pl_ativo, :pl_data_criacao)";
            $stmt = $this->conn->prepare($query);

            $stmt -> bindParam(':pl_nome', $this->PL_NOME);
            $stmt -> bindParam(':pl_beneficios', $this->PL_BENEFICIOS);
            $stmt -> bindParam(':pl_ativo', $this->PL_ATIVO);
            $stmt -> bindParam(':pl_data_criacao', $this->PL_DATA_CRIACAO);

            $stmt -> execute();
            return $stmt;
        }

        public function searchID() {
            $query = "SELECT * FROM " . $this->table . " WHERE PL_ID = :pl_id LIMIT 1";

            $stmt = $this -> conn -> prepare($query);
            $stmt -> bindParam(':pl_id', $this->PL_ID);
            $stmt -> execute();

            $row = $stmt -> fetch(PDO::FETCH_ASSOC);

            if($row) {
                $this->PL_NOME = $row['PL_NOME'];
                $this->PL_BENEFICIOS = $row['PL_BENEFICIOS'];
                $this->PL_ATIVO = $row['PL_ATIVO'];
                $this->PL_DATA_CRIACAO = $row['PL_DATA_CRIACAO'];
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
                PL_NOME = :pl_nome,
                PL_BENEFICIOS = :pl_beneficios,
                PL_ATIVO = :pl_ativo,
                PL_DATA_CRIACAO = :pl_data_criacao
                WHERE PL_ID = :pl_id";
            $stmt = $this->conn->prepare($query);
            
            $stmt -> bindParam(':pl_nome', $this->PL_NOME);
            $stmt -> bindParam(':pl_beneficios', $this->PL_BENEFICIOS);
            $stmt -> bindParam(':pl_ativo', $this->PL_ATIVO);
            $stmt -> bindParam(':pl_data_criacao', $this->PL_DATA_CRIACAO);
            $stmt -> bindParam(':pl_id', $this->PL_ID);
            
            $stmt->execute();

            return $stmt;
        }

        public function delete(){
            $query = "DELETE FROM " . $this -> table . " WHERE PL_ID = :pl_id";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':pl_id', $this->PL_ID);

            $stmt -> execute();

            return $stmt;
        }  
    }

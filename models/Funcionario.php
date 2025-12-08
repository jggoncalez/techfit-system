<?php
    namespace models;

    use PDO;
    class Funcionario {
        // Conexão
        private $conn;
        private $table = "FUNCIONARIOS";

        public $FU_ID;
        public $FU_GENERO;
        public $FU_NIVEL_ACESSO;
        public $FU_SENHA;
        public $FU_NOME;
        public $FU_SALARIO;
        public $FU_DATA_ADMISSAO;

        public function __construct($db){
            $this -> conn = $db;
        }


        public function create(){
            $query = "INSERT INTO " . $this->table . " (FU_GENERO, FU_NIVEL_ACESSO, FU_SENHA, FU_NOME, FU_SALARIO, FU_DATA_ADMISSAO) VALUES (:fu_genero, :fu_nivel_acesso, :fu_senha, :fu_nome, :fu_salario, :fu_data_admissao)";
            $stmt = $this->conn->prepare($query);

            $stmt -> bindParam(':fu_genero', $this->FU_GENERO);
            $stmt -> bindParam(':fu_nivel_acesso', $this->FU_NIVEL_ACESSO);
            $stmt -> bindParam(':fu_senha', $this->FU_SENHA);
            $stmt -> bindParam(':fu_nome', $this->FU_NOME);
            $stmt -> bindParam(':fu_salario', $this->FU_SALARIO);
            $stmt -> bindParam(':fu_data_admissao', $this->FU_DATA_ADMISSAO);

            $stmt -> execute();
            return $stmt;
        }

        public function searchID() {
            $query = "SELECT * FROM " . $this->table . " WHERE FU_ID = :fu_id LIMIT 1";

            $stmt = $this -> conn -> prepare($query);
            $stmt -> bindParam(':fu_id', $this->FU_ID);
            $stmt -> execute();

            $row = $stmt -> fetch(PDO::FETCH_ASSOC);

            if($row) {
                $this->FU_GENERO = $row['FU_GENERO'];
                $this->FU_NIVEL_ACESSO = $row['FU_NIVEL_ACESSO'];
                $this->FU_SENHA = $row['FU_SENHA'];
                $this->FU_NOME = $row['FU_NOME'];
                $this->FU_SALARIO = $row['FU_SALARIO'];
                $this->FU_DATA_ADMISSAO = $row['FU_DATA_ADMISSAO'];
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
                FU_GENERO = :fu_genero, 
                FU_NIVEL_ACESSO = :fu_nivel_acesso,
                FU_SENHA = :fu_senha,
                FU_NOME = :fu_nome,
                FU_SALARIO = :fu_salario,
                FU_DATA_ADMISSAO = :fu_data_admissao
                WHERE FU_ID = :fu_id";
            $stmt = $this->conn->prepare($query);
            
            $stmt -> bindParam(':fu_genero', $this->FU_GENERO);
            $stmt -> bindParam(':fu_nivel_acesso', $this->FU_NIVEL_ACESSO);
            $stmt -> bindParam(':fu_senha', $this->FU_SENHA);
            $stmt -> bindParam(':fu_nome', $this->FU_NOME);
            $stmt -> bindParam(':fu_salario', $this->FU_SALARIO);
            $stmt -> bindParam(':fu_data_admissao', $this->FU_DATA_ADMISSAO);
            $stmt -> bindParam(':fu_id', $this->FU_ID);
            
            $stmt->execute();

            return $stmt;
        }

        public function delete(){
            $query = "DELETE FROM " . $this -> table . " WHERE FU_ID = :fu_id";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':fu_id', $this->FU_ID);

            $stmt -> execute();

            return $stmt;
        }  
    }

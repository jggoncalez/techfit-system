<?php
    namespace models;

    use PDO;
    class Usuario{
        // Conexão
        private $conn;
        private $table = "usuarios";

        public $US_ID;
        public $US_NOME;
        public $US_GENERO;
        public $US_DATA_NASCIMENTO;
        public $US_IDADE;
        public $US_ALTURA;
        public $US_PESO;
        public $US_OBJETIVO;
        public $US_PORC_MASSA_MAGRA;
        public $US_TREINO_ANTERIOR;
        public $US_TEMPO_TREINOANT;
        public $US_ENDERECO;
        public $US_DISPONIBILIDADE;
        public $PL_ID;
        public $US_STATUS_PAGAMENTO;

        public function __construct($db){
            $this -> conn = $db;
        }


        public function create(){
            $query = "INSERT INTO " . $this->table . " (US_NOME, US_GENERO, US_DATA_NASCIMENTO, US_IDADE, US_ALTURA, US_PESO, US_OBJETIVO, US_PORC_MASSA_MAGRA, US_TREINO_ANTERIOR, US_TEMPO_TREINOANT, US_ENDERECO, US_DISPONIBILIDADE, PL_ID,US_STATUS_PAGAMENTO) VALUES (:us_nome, :us_genero, :us_data_nascimento, :us_idade, :us_altura, :us_peso, :us_objetivo, :us_porc_massa_magra, :us_treino_anterior, :us_tempo_treinoant, :us_endereco, :us_disponibilidade, :pl_id, :us_status_pagamento)";
            $stmt = $this->conn->prepare($query);

            $stmt -> bindParam(':us_nome', $this->US_NOME);
            $stmt -> bindParam(':us_genero', $this->US_GENERO);
            $stmt -> bindParam(':us_data_nascimento', $this->US_DATA_NASCIMENTO);
            $stmt -> bindParam(':us_idade', $this->US_IDADE);
            $stmt -> bindParam(':us_altura', $this->US_ALTURA);
            $stmt -> bindParam(':us_peso', $this->US_PESO);
            $stmt -> bindParam(':us_objetivo', $this->US_OBJETIVO);
            $stmt -> bindParam(':us_porc_massa_magra', $this->US_PORC_MASSA_MAGRA);
            $stmt -> bindParam(':us_treino_anterior', $this->US_TREINO_ANTERIOR);
            $stmt -> bindParam(':us_tempo_treinoant', $this->US_TEMPO_TREINOANT);
            $stmt -> bindParam(':us_endereco', $this->US_ENDERECO);
            $stmt -> bindParam(':us_disponibilidade', $this->US_DISPONIBILIDADE);
            $stmt -> bindParam(':pl_id', $this->PL_ID);
            $stmt -> bindParam(':us_status_pagamento', $this->US_STATUS_PAGAMENTO);
            $stmt -> execute();
            return $stmt;
        }

        public function searchID() {
            $query = "SELECT * FROM " . $this->table . " WHERE US_ID = :us_id LIMIT 1";

            $stmt = $this -> conn -> prepare($query);
            $stmt -> bindParam(':us_id', $this->US_ID);
            $stmt -> execute();

            $row = $stmt -> fetch(PDO::FETCH_ASSOC);

            if($row) {
                $this->US_NOME = $row['US_NOME'];
                $this->US_GENERO = $row['US_GENERO'];
                $this->US_DATA_NASCIMENTO = $row['US_DATA_NASCIMENTO'];
                $this->US_IDADE = $row['US_IDADE'];
                $this->US_ALTURA = $row['US_ALTURA'];
                $this->US_PESO = $row['US_PESO'];
                $this->US_OBJETIVO = $row['US_OBJETIVO'];
                $this->US_PORC_MASSA_MAGRA = $row['US_PORC_MASSA_MAGRA'];
                $this->US_TREINO_ANTERIOR = $row['US_TREINO_ANTERIOR'];
                $this->US_TEMPO_TREINOANT = $row['US_TEMPO_TREINOANT'];
                $this->US_ENDERECO = $row['US_ENDERECO'];
                $this->US_DISPONIBILIDADE = $row['US_DISPONIBILIDADE'];
                $this->PL_ID = $row['PL_ID'];
                $this->US_STATUS_PAGAMENTO = $row['US_STATUS_PAGAMENTO'];
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
                US_NOME = :us_nome,
                US_GENERO = :us_genero,
                US_DATA_NASCIMENTO = :us_data_nascimento,
                US_IDADE = :us_idade,
                US_ALTURA = :us_altura,
                US_PESO = :us_peso,
                US_OBJETIVO = :us_objetivo,
                US_PORC_MASSA_MAGRA = :us_porc_massa_magra,
                US_TREINO_ANTERIOR = :us_treino_anterior,
                US_TEMPO_TREINOANT = :us_tempo_treinoant,
                US_ENDERECO = :us_endereco,
                US_DISPONIBILIDADE = :us_disponibilidade,
                PL_ID = :pl_id,
                US_STATUS_PAGAMENTO = :us_status_pagamento
                WHERE US_ID = :us_id";
            $stmt = $this->conn->prepare($query);
            
            $stmt -> bindParam(':us_nome', $this->US_NOME);
            $stmt -> bindParam(':us_genero', $this->US_GENERO);
            $stmt -> bindParam(':us_data_nascimento', $this->US_DATA_NASCIMENTO);
            $stmt -> bindParam(':us_idade', $this->US_IDADE);
            $stmt -> bindParam(':us_altura', $this->US_ALTURA);
            $stmt -> bindParam(':us_peso', $this->US_PESO);
            $stmt -> bindParam(':us_objetivo', $this->US_OBJETIVO);
            $stmt -> bindParam(':us_porc_massa_magra', $this->US_PORC_MASSA_MAGRA);
            $stmt -> bindParam(':us_treino_anterior', $this->US_TREINO_ANTERIOR);
            $stmt -> bindParam(':us_tempo_treinoant', $this->US_TEMPO_TREINOANT);
            $stmt -> bindParam(':us_endereco', $this->US_ENDERECO);
            $stmt -> bindParam(':us_disponibilidade', $this->US_DISPONIBILIDADE);
            $stmt -> bindParam(':pl_id', $this->PL_ID);
            $stmt -> bindParam(':us_status_pagamento', $this->US_STATUS_PAGAMENTO);
            $stmt -> bindParam(':us_id', $this->US_ID);
            
            $stmt->execute();

            return $stmt;
        }

        public function delete(){
            $query = "DELETE FROM " . $this -> table . " WHERE US_ID = :us_id";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':us_id', $this->US_ID);

            $stmt -> execute();

            return $stmt;
        }  

        public function buscarPlanos() {
             $result = $this->conn->query("SELECT PL_ID, PL_NOME from Planos ORDER BY PL_NOME");

            while ($row = $result->fetch(PDO::FETCH_ASSOC)){
                 echo "<option value='{$row['PL_ID']}'>
                        {$row['PL_NOME']}
                     </option>";
            }
        }
    }
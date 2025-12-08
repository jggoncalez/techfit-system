<?php
    namespace models\sagef;

    use PDO;
    class Treino{
        // Conexão
        private $conn;
        private $table = "TREINOS";
        public $TR_ID;
        public $TR_NOME;
        public $TR_DATA_CRIACAO;
        public $US_ID;
        public $TR_DURACAO_ESTIMADA;
        public $TR_STATUS;
        public $TR_OBSERVACOES;

        public function __construct($db){
            $this -> conn = $db;
        }


        public function create(){
            $query = "INSERT INTO " . $this->table . " (TR_NOME, TR_DATA_CRIACAO, US_ID, TR_DURACAO_ESTIMADA, TR_STATUS, TR_OBSERVACOES) VALUES (:tr_nome, :tR_data_criacao, :us_id, :tr_duracao_estimada, :tr_status, :tr_observacoes)";
            $stmt = $this->conn->prepare($query);

            $stmt -> bindParam(':tr_nome', $this->TR_NOME);
            $stmt -> bindParam(':tR_data_criacao', $this->TR_DATA_CRIACAO);
            $stmt -> bindParam(':us_id', $this->US_ID);
            $stmt -> bindParam(':tr_duracao_estimada', $this->TR_DURACAO_ESTIMADA);
            $stmt -> bindParam(':tr_status', $this->TR_STATUS);
            $stmt -> bindParam(':tr_observacoes', $this->TR_OBSERVACOES);

            $stmt -> execute();
            return $this->conn->lastInsertId();
        }

        public function searchID() {
            $query = "SELECT * FROM " . $this->table . " WHERE TR_ID = :tr_id LIMIT 1";

            $stmt = $this -> conn -> prepare($query);
            $stmt -> bindParam(':tr_id', $this->TR_ID);
            $stmt -> execute();

            $row = $stmt -> fetch(PDO::FETCH_ASSOC);

            if($row) {
                $this->TR_NOME = $row['TR_NOME'];
                $this->TR_DATA_CRIACAO = $row['TR_DATA_CRIACAO'];
                $this->US_ID = $row['US_ID'];
                $this->TR_DURACAO_ESTIMADA = $row['TR_DURACAO_ESTIMADA'];
                $this->TR_STATUS = $row['TR_STATUS'];
                $this->TR_OBSERVACOES = $row['TR_OBSERVACOES'];
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
                TR_NOME = :tr_nome,
                TR_DATA_CRIACAO = :tr_data_criacao, 
                US_ID = :us_id,
                TR_DURACAO_ESTIMADA = :tr_duracao_estimada,
                TR_STATUS = :tr_status,
                TR_OBSERVACOES = :tr_observacoes
                WHERE TR_ID = :tr_id";
            $stmt = $this->conn->prepare($query);
            
            $stmt -> bindParam(':tr_nome', $this->TR_NOME);
            $stmt -> bindParam(':tr_data_criacao', $this->TR_DATA_CRIACAO);
            $stmt -> bindParam(':us_id', $this->US_ID);
            $stmt -> bindParam(':tr_duracao_estimada', $this->TR_DURACAO_ESTIMADA);
            $stmt -> bindParam(':tr_status', $this->TR_STATUS);
            $stmt -> bindParam(':tr_observacoes', $this->TR_OBSERVACOES);
            $stmt -> bindParam(':tr_id', $this->TR_ID);
            
            $stmt->execute();

            return $stmt;
        }

        public function delete(){
            $stmt = $this->conn->prepare("DELETE FROM treino_exercicios WHERE TR_ID = ?");
            $stmt->execute([$this->TR_ID]);
            $query = "DELETE FROM " . $this -> table . " WHERE TR_ID = :tr_id";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':tr_id', $this->TR_ID);

            $stmt -> execute();
   
            return $stmt;
        }  

        public function buscarUsuarios($usuarioSelecionado = null)
        {
        $result = $this->conn->query("SELECT US_ID, US_NOME from Usuarios ORDER BY US_NOME");
        $options = '';

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $selected = ($usuarioSelecionado && $row['US_ID'] == $usuarioSelecionado) ? 'selected' : '';
            $options .= "<option value='{$row['US_ID']}' {$selected}>{$row['US_NOME']}</option>";
        }
            return $options;
        }
    }

<?php
    namespace models\sagef;

    use PDO;
    class Pontuacao{
        // Conexão
        private $conn;
        private $table = "PONTUACAO";

        public $PT_ID;
        public $PT_MUSCULO;
        public $PT_GRUPO_MUSCULAR;
        public $PT_PONTOS;
        public $TR_ID;
        public $US_ID;

        public function __construct($db){
            $this -> conn = $db;
        }


        public function create(){
            $query = "INSERT INTO " . $this->table . " (PT_MUSCULO, PT_GRUPO_MUSCULAR, PT_PONTOS, TR_ID, US_ID) VALUES (:pt_musculo, :pt_grupo_muscular, :pt_pontos, :tr_id, :us_id)";
            $stmt = $this->conn->prepare($query);

            $stmt -> bindParam(':pt_musculo', $this->PT_MUSCULO);
            $stmt -> bindParam(':pt_grupo_muscular', $this->PT_GRUPO_MUSCULAR);
            $stmt -> bindParam(':pt_pontos', $this->PT_PONTOS);
            $stmt -> bindParam(':tr_id', $this->TR_ID);
            $stmt -> bindParam(':us_id', $this->US_ID);

            $stmt -> execute();
            return $stmt;
        }

        public function searchID() {
            $query = "SELECT * FROM " . $this->table . " WHERE PT_ID = :pt_id LIMIT 1";

            $stmt = $this -> conn -> prepare($query);
            $stmt -> bindParam(':pt_id', $this->PT_ID);
            $stmt -> execute();

            $row = $stmt -> fetch(PDO::FETCH_ASSOC);

            if($row) {
                $this->PT_MUSCULO = $row['PT_MUSCULO'];
                $this->PT_GRUPO_MUSCULAR = $row['PT_GRUPO_MUSCULAR'];
                $this->PT_PONTOS = $row['PT_PONTOS'];
                $this->TR_ID = $row['TR_ID'];
                $this->US_ID = $row['US_ID'];
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
                PT_MUSCULO = :pt_musculo, 
                PT_GRUPO_MUSCULAR = :pt_grupo_muscular,
                PT_PONTOS = :pt_pontos,
                TR_ID = :tr_id,
                US_ID = :us_id
                WHERE PT_ID = :pt_id";
            $stmt = $this->conn->prepare($query);
            
            $stmt -> bindParam(':pt_musculo', $this->PT_MUSCULO);
            $stmt -> bindParam(':pt_grupo_muscular', $this->PT_GRUPO_MUSCULAR);
            $stmt -> bindParam(':pt_pontos', $this->PT_PONTOS);
            $stmt -> bindParam(':tr_id', $this->TR_ID);
            $stmt -> bindParam(':us_id', $this->US_ID);
            $stmt -> bindParam(':pt_id', $this->PT_ID);
            
            $stmt->execute();

            return $stmt;
        }

        public function delete(){
            $query = "DELETE FROM " . $this -> table . " WHERE PT_ID = :pt_id";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':pt_id', $this->PT_ID);

            $stmt -> execute();

            return $stmt;
        }  
    }

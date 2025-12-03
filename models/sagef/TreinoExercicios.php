<?php
    namespace models\sagef;

    use PDO;
    class TreinoExercicios{
        // Conexão
        private $conn;
        private $table = "TREINO_EXERCICIOS";

        public $TE_ID;
        public $TR_ID;
        public $EX_ID;
        public $TE_ORDEM;
        public $TE_SERIES;
        public $TE_REPETICOES;
        public $TE_CARGA;
        public $TE_TEMPO_DESCANSO;
        public $TE_OBSERVACOES;
        public $TE_CONCLUIDO;

        public function __construct($db){
            $this -> conn = $db;
        }


        public function create(){
            $query = "INSERT INTO " . $this->table . " (TR_ID, EX_ID, TE_ORDEM, TE_SERIES, TE_REPETICOES, TE_CARGA, TE_TEMPO_DESCANSO, TE_OBSERVACOES, TE_CONCLUIDO) VALUES (:tr_id, :ex_id, :te_ordem, :te_series, :te_repeticoes, :te_carga, :te_tempo_descanso, :te_observacoes, :te_concluido)";
            $stmt = $this->conn->prepare($query);

            $stmt -> bindParam(':tr_id', $this->TR_ID);
            $stmt -> bindParam(':ex_id', $this->EX_ID);
            $stmt -> bindParam(':te_ordem', $this->TE_ORDEM);
            $stmt -> bindParam(':te_series', $this->TE_SERIES);
            $stmt -> bindParam(':te_repeticoes', $this->TE_REPETICOES);
            $stmt -> bindParam(':te_carga', $this->TE_CARGA);
            $stmt -> bindParam(':te_tempo_descanso', $this->TE_TEMPO_DESCANSO);
            $stmt -> bindParam(':te_observacoes', $this->TE_OBSERVACOES);
            $stmt -> bindParam(':te_concluido', $this->TE_CONCLUIDO);

            $stmt -> execute();
            return $stmt;
        }

        public function searchID() {
            $query = "SELECT * FROM " . $this->table . " WHERE TE_ID = :te_id LIMIT 1";

            $stmt = $this -> conn -> prepare($query);
            $stmt -> bindParam(':te_id', $this->TE_ID);
            $stmt -> execute();

            $row = $stmt -> fetch(PDO::FETCH_ASSOC);

            if($row) {
                $this->TR_ID = $row['TR_ID'];
                $this->EX_ID = $row['EX_ID'];
                $this->TE_ORDEM = $row['TE_ORDEM'];
                $this->TE_SERIES = $row['TE_SERIES'];
                $this->TE_REPETICOES = $row['TE_REPETICOES'];
                $this->TE_CARGA = $row['TE_CARGA'];
                $this->TE_TEMPO_DESCANSO = $row['TE_TEMPO_DESCANSO'];
                $this->TE_OBSERVACOES = $row['TE_OBSERVACOES'];
                $this->TE_CONCLUIDO = $row['TE_CONCLUIDO'];
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
                TR_ID = :tr_id, 
                EX_ID = :ex_id,
                TE_ORDEM = :te_ordem,
                TE_SERIES = :te_series,
                TE_REPETICOES = :te_repeticoes,
                TE_CARGA = :te_carga,
                TE_TEMPO_DESCANSO = :te_tempo_descanso,
                TE_OBSERVACOES = :te_observacoes,
                TE_CONCLUIDO = :te_concluido
                WHERE TE_ID = :te_id";
            $stmt = $this->conn->prepare($query);
            
            $stmt -> bindParam(':tr_id', $this->TR_ID);
            $stmt -> bindParam(':ex_id', $this->EX_ID);
            $stmt -> bindParam(':te_ordem', $this->TE_ORDEM);
            $stmt -> bindParam(':te_series', $this->TE_SERIES);
            $stmt -> bindParam(':te_repeticoes', $this->TE_REPETICOES);
            $stmt -> bindParam(':te_carga', $this->TE_CARGA);
            $stmt -> bindParam(':te_tempo_descanso', $this->TE_TEMPO_DESCANSO);
            $stmt -> bindParam(':te_observacoes', $this->TE_OBSERVACOES);
            $stmt -> bindParam(':te_concluido', $this->TE_CONCLUIDO);
            $stmt -> bindParam(':te_id', $this->TE_ID);
            
            $stmt->execute();

            return $stmt;
        }

        public function delete(){
            $query = "DELETE FROM " . $this -> table . " WHERE TE_ID = :te_id";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':te_id', $this->TE_ID);

            $stmt -> execute();

            return $stmt;
        }  
    }

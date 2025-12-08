<?php
    namespace models\agendamento;

    use PDO;
    class ParticipacoesAula{
        // Conexão
        private $conn;
        private $table = "PARTICIPACOES_AULA";

        public $PA_ID;
        public $AU_ID;
        public $US_ID;
        public $PA_DATA_INSCRICAO;
        public $PA_STATUS;
        public $PA_AVALIACAO;
        public $PA_COMENTARIO;

        public function __construct($db){
            $this -> conn = $db;
        }


        public function create(){
            $query = "INSERT INTO " . $this->table . " (AU_ID, US_ID, PA_DATA_INSCRICAO, PA_STATUS, PA_AVALIACAO, PA_COMENTARIO) VALUES (:au_id, :us_id, :pa_data_inscricao, :pa_status, :pa_avaliacao, :pa_comentario)";
            $stmt = $this->conn->prepare($query);

            $stmt -> bindParam(':au_id', $this->AU_ID);
            $stmt -> bindParam(':us_id', $this->US_ID);
            $stmt -> bindParam(':pa_data_inscricao', $this->PA_DATA_INSCRICAO);
            $stmt -> bindParam(':pa_status', $this->PA_STATUS);
            $stmt -> bindParam(':pa_avaliacao', $this->PA_AVALIACAO);
            $stmt -> bindParam(':pa_comentario', $this->PA_COMENTARIO);

            $stmt -> execute();
            return $stmt;
        }
        public function buscarAvaliações() {
            $query = "SELECT p.PA_AVALIACAO, p.PA_COMENTARIO, a.AU_NOME, u.US_NOME 
            FROM " . $this->table . " p 
            JOIN AULAS a ON a.AU_ID = p.AU_ID 
            JOIN USUARIOS u ON u.US_ID = p.US_ID";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt;
        }
        public function searchID() {
            $query = "SELECT * FROM " . $this->table . " WHERE PA_ID = :pa_id LIMIT 1";

            $stmt = $this -> conn -> prepare($query);
            $stmt -> bindParam(':pa_id', $this->PA_ID);
            $stmt -> execute();

            $row = $stmt -> fetch(PDO::FETCH_ASSOC);

            if($row) {
                $this->AU_ID = $row['AU_ID'];
                $this->US_ID = $row['US_ID'];
                $this->PA_DATA_INSCRICAO = $row['PA_DATA_INSCRICAO'];
                $this->PA_STATUS = $row['PA_STATUS'];
                $this->PA_AVALIACAO = $row['PA_AVALIACAO'];
                $this->PA_COMENTARIO = $row['PA_COMENTARIO'];
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
                AU_ID = :au_id, 
                US_ID = :us_id,
                PA_DATA_INSCRICAO = :pa_data_inscricao,
                PA_STATUS = :pa_status,
                PA_AVALIACAO = :pa_avaliacao,
                PA_COMENTARIO = :pa_comentario
                WHERE PA_ID = :pa_id";
            $stmt = $this->conn->prepare($query);
            
            $stmt -> bindParam(':au_id', $this->AU_ID);
            $stmt -> bindParam(':us_id', $this->US_ID);
            $stmt -> bindParam(':pa_data_inscricao', $this->PA_DATA_INSCRICAO);
            $stmt -> bindParam(':pa_status', $this->PA_STATUS);
            $stmt -> bindParam(':pa_avaliacao', $this->PA_AVALIACAO);
            $stmt -> bindParam(':pa_comentario', $this->PA_COMENTARIO);
            $stmt -> bindParam(':pa_id', $this->PA_ID);
            
            $stmt->execute();

            return $stmt;
        }

        public function delete(){
            $query = "DELETE FROM " . $this -> table . " WHERE PA_ID = :pa_id";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':pa_id', $this->PA_ID);

            $stmt -> execute();

            return $stmt;
        }  

        // Método alternativo mais simples
        public function atualizarVagasDisponiveis($aulaId) {
            $query = "UPDATE AULAS A
                    SET A.AU_VAGAS_DISPONIVEIS = A.AU_VAGAS_TOTAIS - (
                        SELECT COUNT(*) 
                        FROM PARTICIPACOES_AULA PA
                        WHERE PA.AU_ID = A.AU_ID 
                        AND PA.PA_STATUS IN ('INSCRITO', 'PRESENTE')
                    )
                    WHERE A.AU_ID = :au_id";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':au_id', $aulaId);
            $stmt->execute();
            
            return $stmt;
        }
    }

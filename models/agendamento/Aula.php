<?php
    namespace models\agendamento;

    use PDO;
    class Aula{
        // Conexão
        private $conn;
        private $table = "AULA";

        public $AU_ID;
        public $TA_ID;
        public $FU_ID;
        public $AU_NOME;
        public $AU_DATA;
        public $AU_HORA_INICIO;
        public $AU_HORA_FIM;
        public $AU_VAGAS_DISPONIVEIS;
        public $AU_VAGAS_TOTAIS;
        public $AU_SALA;
        public $AU_STATUS;
        public $AU_OBSERVACOES;

        public function __construct($db){
            $this -> conn = $db;
        }


        public function create(){
            $query = "INSERT INTO " . $this->table . " (TA_ID, FU_ID, AU_NOME, AU_DATA, AU_HORA_INICIO, AU_HORA_FIM, AU_VAGAS_DISPONIVEIS, AU_VAGAS_TOTAIS, AU_SALA, AU_STATUS, AU_OBSERVACOES) VALUES (:ta_id, :fu_id, :au_nome, :au_data, :au_hora_inicio, :au_hora_fim, :au_vagas_disponiveis, :au_vagas_totais, :au_sala, :au_status, :au_observacoes)";
            $stmt = $this->conn->prepare($query);

            $stmt -> bindParam(':ta_id', $this->TA_ID);
            $stmt -> bindParam(':fu_id', $this->FU_ID);
            $stmt -> bindParam(':au_nome', $this->AU_NOME);
            $stmt -> bindParam(':au_data', $this->AU_DATA);
            $stmt -> bindParam(':au_hora_inicio', $this->AU_HORA_INICIO);
            $stmt -> bindParam(':au_hora_fim', $this->AU_HORA_FIM);
            $stmt -> bindParam(':au_vagas_disponiveis', $this->AU_VAGAS_DISPONIVEIS);
            $stmt -> bindParam(':au_vagas_totais', $this->AU_VAGAS_TOTAIS);
            $stmt -> bindParam(':au_sala', $this->AU_SALA);
            $stmt -> bindParam(':au_status', $this->AU_STATUS);
            $stmt -> bindParam(':au_observacoes', $this->AU_OBSERVACOES);

            $stmt -> execute();
            return $stmt;
        }

        public function searchID() {
            $query = "SELECT * FROM " . $this->table . " WHERE AU_ID = :au_id LIMIT 1";

            $stmt = $this -> conn -> prepare($query);
            $stmt -> bindParam(':au_id', $this->AU_ID);
            $stmt -> execute();

            $row = $stmt -> fetch(PDO::FETCH_ASSOC);

            if($row) {
                $this->TA_ID = $row['TA_ID'];
                $this->FU_ID = $row['FU_ID'];
                $this->AU_NOME = $row['AU_NOME'];
                $this->AU_DATA = $row['AU_DATA'];
                $this->AU_HORA_INICIO = $row['AU_HORA_INICIO'];
                $this->AU_HORA_FIM = $row['AU_HORA_FIM'];
                $this->AU_VAGAS_DISPONIVEIS = $row['AU_VAGAS_DISPONIVEIS'];
                $this->AU_VAGAS_TOTAIS = $row['AU_VAGAS_TOTAIS'];
                $this->AU_SALA = $row['AU_SALA'];
                $this->AU_STATUS = $row['AU_STATUS'];
                $this->AU_OBSERVACOES = $row['AU_OBSERVACOES'];
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
                TA_ID = :ta_id, 
                FU_ID = :fu_id,
                AU_NOME = :au_nome,
                AU_DATA = :au_data,
                AU_HORA_INICIO = :au_hora_inicio,
                AU_HORA_FIM = :au_hora_fim,
                AU_VAGAS_DISPONIVEIS = :au_vagas_disponiveis,
                AU_VAGAS_TOTAIS = :au_vagas_totais,
                AU_SALA = :au_sala,
                AU_STATUS = :au_status,
                AU_OBSERVACOES = :au_observacoes
                WHERE AU_ID = :au_id";
            $stmt = $this->conn->prepare($query);
            
            $stmt -> bindParam(':ta_id', $this->TA_ID);
            $stmt -> bindParam(':fu_id', $this->FU_ID);
            $stmt -> bindParam(':au_nome', $this->AU_NOME);
            $stmt -> bindParam(':au_data', $this->AU_DATA);
            $stmt -> bindParam(':au_hora_inicio', $this->AU_HORA_INICIO);
            $stmt -> bindParam(':au_hora_fim', $this->AU_HORA_FIM);
            $stmt -> bindParam(':au_vagas_disponiveis', $this->AU_VAGAS_DISPONIVEIS);
            $stmt -> bindParam(':au_vagas_totais', $this->AU_VAGAS_TOTAIS);
            $stmt -> bindParam(':au_sala', $this->AU_SALA);
            $stmt -> bindParam(':au_status', $this->AU_STATUS);
            $stmt -> bindParam(':au_observacoes', $this->AU_OBSERVACOES);
            $stmt -> bindParam(':au_id', $this->AU_ID);
            
            $stmt->execute();

            return $stmt;
        }

        public function delete(){
            $query = "DELETE FROM " . $this -> table . " WHERE AU_ID = :au_id";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':au_id', $this->AU_ID);

            $stmt -> execute();

            return $stmt;
        }  
    }
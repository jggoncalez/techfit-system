<?php
    namespace models\sagef;

    use PDO;
    class Exercicio{
        // Conexão
        private $conn;
        private $table = "EXERCICIOS";

        public $EX_ID;
        public $EX_NOME;
        public $EX_DESCRICAO;
        public $EX_TIPO;
        public $EX_DIFICULDADE;
        public $EX_EQUIPAMENTO;
        public $EX_MIN_VALOR;
        public $EX_MAX_VALOR;
        public $EX_MIN_REPETICOES;
        public $EX_MAX_REPETICOES;
        public $EX_TEMPO_DESCANSO;
        public $EX_PONTUACAO;

        public function __construct($db){
            $this -> conn = $db;
        }


        public function create(){
            $query = "INSERT INTO " . $this->table . " (EX_NOME, EX_DESCRICAO, EX_TIPO, EX_DIFICULDADE, EX_EQUIPAMENTO, EX_MIN_VALOR, EX_MAX_VALOR, EX_MIN_REPETICOES, EX_MAX_REPETICOES, EX_TEMPO_DESCANSO, EX_PONTUACAO) VALUES (:ex_nome, :ex_descricao, :ex_tipo, :ex_dificuldade, :ex_equipamento, :ex_min_valor, :ex_max_valor, :ex_min_repeticoes, :ex_max_repeticoes, :ex_tempo_descanso, :ex_pontuacao)";
            $stmt = $this->conn->prepare($query);

            $stmt -> bindParam(':ex_nome', $this->EX_NOME);
            $stmt -> bindParam(':ex_descricao', $this->EX_DESCRICAO);
            $stmt -> bindParam(':ex_tipo', $this->EX_TIPO);
            $stmt -> bindParam(':ex_dificuldade', $this->EX_DIFICULDADE);
            $stmt -> bindParam(':ex_equipamento', $this->EX_EQUIPAMENTO);
            $stmt -> bindParam(':ex_min_valor', $this->EX_MIN_VALOR);
            $stmt -> bindParam(':ex_max_valor', $this->EX_MAX_VALOR);
            $stmt -> bindParam(':ex_min_repeticoes', $this->EX_MIN_REPETICOES);
            $stmt -> bindParam(':ex_max_repeticoes', $this->EX_MAX_REPETICOES);
            $stmt -> bindParam(':ex_tempo_descanso', $this->EX_TEMPO_DESCANSO);
            $stmt -> bindParam(':ex_pontuacao', $this->EX_PONTUACAO);

            $stmt -> execute();
            return $stmt;
        }

        public function searchID() {
            $query = "SELECT * FROM " . $this->table . " WHERE EX_ID = :ex_id LIMIT 1";

            $stmt = $this -> conn -> prepare($query);
            $stmt -> bindParam(':ex_id', $this->EX_ID);
            $stmt -> execute();

            $row = $stmt -> fetch(PDO::FETCH_ASSOC);

            if($row) {
                $this->EX_NOME = $row['EX_NOME'];
                $this->EX_DESCRICAO = $row['EX_DESCRICAO'];
                $this->EX_TIPO = $row['EX_TIPO'];
                $this->EX_DIFICULDADE = $row['EX_DIFICULDADE'];
                $this->EX_EQUIPAMENTO = $row['EX_EQUIPAMENTO'];
                $this->EX_MIN_VALOR = $row['EX_MIN_VALOR'];
                $this->EX_MAX_VALOR = $row['EX_MAX_VALOR'];
                $this->EX_MIN_REPETICOES = $row['EX_MIN_REPETICOES'];
                $this->EX_MAX_REPETICOES = $row['EX_MAX_REPETICOES'];
                $this->EX_TEMPO_DESCANSO = $row['EX_TEMPO_DESCANSO'];
                $this->EX_PONTUACAO = $row['EX_PONTUACAO'];
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
                EX_NOME = :ex_nome,
                EX_DESCRICAO = :ex_descricao,
                EX_TIPO = :ex_tipo,
                EX_DIFICULDADE = :ex_dificuldade,
                EX_EQUIPAMENTO = :ex_equipamento,
                EX_MIN_VALOR = :ex_min_valor,
                EX_MAX_VALOR = :ex_max_valor,
                EX_MIN_REPETICOES = :ex_min_repeticoes,
                EX_MAX_REPETICOES = :ex_max_repeticoes,
                EX_TEMPO_DESCANSO = :ex_tempo_descanso,
                EX_PONTUACAO = :ex_pontuacao
                WHERE EX_ID = :ex_id";
            $stmt = $this->conn->prepare($query);
            
            $stmt -> bindParam(':ex_nome', $this->EX_NOME);
            $stmt -> bindParam(':ex_descricao', $this->EX_DESCRICAO);
            $stmt -> bindParam(':ex_tipo', $this->EX_TIPO);
            $stmt -> bindParam(':ex_dificuldade', $this->EX_DIFICULDADE);
            $stmt -> bindParam(':ex_equipamento', $this->EX_EQUIPAMENTO);
            $stmt -> bindParam(':ex_min_valor', $this->EX_MIN_VALOR);
            $stmt -> bindParam(':ex_max_valor', $this->EX_MAX_VALOR);
            $stmt -> bindParam(':ex_min_repeticoes', $this->EX_MIN_REPETICOES);
            $stmt -> bindParam(':ex_max_repeticoes', $this->EX_MAX_REPETICOES);
            $stmt -> bindParam(':ex_tempo_descanso', $this->EX_TEMPO_DESCANSO);
            $stmt -> bindParam(':ex_pontuacao', $this->EX_PONTUACAO);
            $stmt -> bindParam(':ex_id', $this->EX_ID);
            
            $stmt->execute();

            return $stmt;
        }

        public function delete(){
            $query = "DELETE FROM " . $this -> table . " WHERE EX_ID = :ex_id";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':ex_id', $this->EX_ID);

            $stmt -> execute();

            return $stmt;
        }  
    }
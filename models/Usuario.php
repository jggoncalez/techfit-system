<?php
namespace models;

use PDO;
class Usuario
{
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

    public $US_SENHA;
    public function __construct($db)
    {
        $this->conn = $db;
    }


    public function create()
    {
        $query = "INSERT INTO " . $this->table . " (US_NOME, US_GENERO, US_DATA_NASCIMENTO, US_IDADE, US_ALTURA, US_PESO, US_OBJETIVO, US_PORC_MASSA_MAGRA, US_TREINO_ANTERIOR, US_TEMPO_TREINOANT, US_ENDERECO, US_DISPONIBILIDADE, PL_ID,US_STATUS_PAGAMENTO) VALUES (:us_nome, :us_genero, :us_data_nascimento, :us_idade, :us_altura, :us_peso, :us_objetivo, :us_porc_massa_magra, :us_treino_anterior, :us_tempo_treinoant, :us_endereco, :us_disponibilidade, :pl_id, :us_status_pagamento)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':us_nome', $this->US_NOME);
        $stmt->bindParam(':us_genero', $this->US_GENERO);
        $stmt->bindParam(':us_data_nascimento', $this->US_DATA_NASCIMENTO);
        $stmt->bindParam(':us_idade', $this->US_IDADE);
        $stmt->bindParam(':us_altura', $this->US_ALTURA);
        $stmt->bindParam(':us_peso', $this->US_PESO);
        $stmt->bindParam(':us_objetivo', $this->US_OBJETIVO);
        $stmt->bindParam(':us_porc_massa_magra', $this->US_PORC_MASSA_MAGRA);
        $stmt->bindParam(':us_treino_anterior', $this->US_TREINO_ANTERIOR);
        $stmt->bindParam(':us_tempo_treinoant', $this->US_TEMPO_TREINOANT);
        $stmt->bindParam(':us_endereco', $this->US_ENDERECO);
        $stmt->bindParam(':us_disponibilidade', $this->US_DISPONIBILIDADE);
        $stmt->bindParam(':pl_id', $this->PL_ID);
        $stmt->bindParam(':us_status_pagamento', $this->US_STATUS_PAGAMENTO);
        $stmt->execute();
        return $stmt;
    }

    public function searchID()
    {
        $query = "SELECT * FROM " . $this->table . " WHERE US_ID = :us_id LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':us_id', $this->US_ID);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
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
            $this->US_SENHA = $row['US_SENHA'];
            return true;
        }

        return false;
    }
    public function searchNAME()
    {
        $query = "SELECT * FROM " . $this->table . " WHERE US_NOME = :us_nome LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':us_nome', $this->US_ID);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
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
            $this->US_SENHA = $row['US_SENHA'];
            return true;
        }

        return false;
    }

    public function list()
    {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    public function update()
    {
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

        $stmt->bindParam(':us_nome', $this->US_NOME);
        $stmt->bindParam(':us_genero', $this->US_GENERO);
        $stmt->bindParam(':us_data_nascimento', $this->US_DATA_NASCIMENTO);
        $stmt->bindParam(':us_idade', $this->US_IDADE);
        $stmt->bindParam(':us_altura', $this->US_ALTURA);
        $stmt->bindParam(':us_peso', $this->US_PESO);
        $stmt->bindParam(':us_objetivo', $this->US_OBJETIVO);
        $stmt->bindParam(':us_porc_massa_magra', $this->US_PORC_MASSA_MAGRA);
        $stmt->bindParam(':us_treino_anterior', $this->US_TREINO_ANTERIOR);
        $stmt->bindParam(':us_tempo_treinoant', $this->US_TEMPO_TREINOANT);
        $stmt->bindParam(':us_endereco', $this->US_ENDERECO);
        $stmt->bindParam(':us_disponibilidade', $this->US_DISPONIBILIDADE);
        $stmt->bindParam(':pl_id', $this->PL_ID);
        $stmt->bindParam(':us_status_pagamento', $this->US_STATUS_PAGAMENTO);
        $stmt->bindParam(':us_id', $this->US_ID);

        $stmt->execute();

        return $stmt;
    }

    public function delete()
    {

             $stmt = $this->conn->prepare("SELECT TR_ID FROM treinos WHERE US_ID = ?");
        $stmt->execute([$this->US_ID]);
        $treinoIds = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        // 2. Deletar todos os exercícios desses treinos
        if (!empty($treinoIds)) {
            $placeholders = str_repeat('?,', count($treinoIds) - 1) . '?';
            $stmt = $this->conn->prepare("DELETE FROM treino_exercicios WHERE TR_ID IN ($placeholders)");
            $stmt->execute($treinoIds);
        }
        
            // 3. Deletar todos os treinos do usuário
            $stmt = $this->conn->prepare("DELETE FROM treinos WHERE US_ID = ?");
            $stmt->execute([$this->US_ID]);
            
            // 4. Deletar todas as participações em aulas
            $stmt = $this->conn->prepare("DELETE FROM participacoes_aula WHERE US_ID = ?");
            $stmt->execute([$this->US_ID]);
            
            // 5. Finalmente deletar o usuário
            $stmt = $this->conn->prepare("DELETE FROM usuarios WHERE US_ID = ?");
            $stmt->execute([$this->US_ID]);
        return $stmt;
    }

    public function buscarPlanos()
    {
        $result = $this->conn->query("SELECT PL_ID, PL_NOME from Planos ORDER BY PL_NOME");

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='{$row['PL_ID']}'>
                        {$row['PL_NOME']}
                     </option>";
        }
    }

    public function trocarSenha($senhanova) {
        $this->conn->query("UPDATE {$this->table} set US_SENHA= {$senhanova} where US_ID = {$this->US_ID} ");
    }

    public function buscarTreinos()
    {
        $result = $this->conn->query("SELECT * FROM TREINOS WHERE US_ID = {$this->US_ID}");
       
   
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $modalId = "modal-treino" . $row['TR_ID'];
            $resultEx = $this->conn->query("       SELECT 
                                                    TE.TE_ID,
                                                    TE.TE_ORDEM,
                                                    TE.TE_SERIES,
                                                    TE.TE_REPETICOES,
                                                    TE.TE_CONCLUIDO,
                                                    EX.EX_NOME
                                                FROM TREINO_EXERCICIOS TE
                                                JOIN EXERCICIOS EX ON EX.EX_ID = TE.EX_ID
                                                WHERE TE.TR_ID = {$row['TR_ID']}
                                                ORDER BY TE.TE_ORDEM");
            $exercicios = $resultEx->fetchAll(PDO::FETCH_ASSOC);
            echo "
                    <div class='card mb-3' style='max-width: 540px;'>
                    <div class='row no-gutters'>
                    <div class='col-md-4 d-flex flex-column justify-content-center p-3'>
                    <h2 class='h5'>{$row['TR_NOME']}#{$row['TR_ID']}</h2>
                    </div>
                    <div class='col-md-8'>
                    <div class='card-body'>
                    <p class='card-text'>Status: <strong>{$row['TR_STATUS']}</strong></p>
                    <p class='card-text'>Data de Criação: <strong>" . date('d/m/Y', strtotime($row['TR_DATA_CRIACAO'])) . "</strong></p>
                    <p class='card-text'>Duração Estimada: <strong>{$row['TR_DURACAO_ESTIMADA']} min</strong></p>


                    <button class='btn text-white' data-toggle='modal' data-target='#{$modalId}' style='background-color:#e35c38;'>Ver Mais</button>
                    </div>
                    </div>
                    </div>
                    </div>


                    <!-- Modal Detalhes do Treino -->
                    <div class='modal fade' id='{$modalId}' tabindex='-1' aria-hidden='true'>
                    <div class='modal-dialog modal-lg'>
                    <div class='modal-content'>
                    <div class='modal-header'>
                    <h5 class='modal-title'>{$row['TR_NOME']}#{$row['TR_ID']} - Detalhes</h5>
                    <button type='button' class='close' data-dismiss='modal'><span>&times;</span></button>
                    </div>


                    <div class='modal-body'>
                    <h5 class='mb-3'>Informações do Treino</h5>
                    <p><strong>Observações:</strong> " . (!empty($row['TR_OBSERVACOES']) ? $row['TR_OBSERVACOES'] : 'Nenhuma') . "</p>


                    <hr>


                    <h5 class='mb-3'>Exercícios do Treino</h5>


                    <table class='table table-striped table-bordered'>
                    <thead>
                    <tr>
                    <th>Ordem</th>
                    <th>Exercício</th>
                    <th>Séries</th>
                    <th>Repetições</th>
                    </tr>
                    </thead>
                    <tbody>
                    ";


            // Loop dos exercícios
            foreach ($exercicios as $ex) {
                echo "
                    <tr>
                    <td>{$ex['TE_ORDEM']}</td>
                    <td>{$ex['EX_NOME']}</td>
                    <td>{$ex['TE_SERIES']}</td>
                    <td>{$ex['TE_REPETICOES']}</td>
                    </tr>
                    ";
            }


            echo "
                    </tbody>
                    </table>
                    </div>


                    <div class='modal-footer'>
                    <button class='btn btn-secondary' data-dismiss='modal'>Fechar</button>
                    </div>
                    </div>
                    </div>
                    </div>
";
        }

    }

    public function buscarAgendamentos() {
        $result = $this->conn->query("
                        SELECT * 
                        FROM AULAS 
                         WHERE AU_ID NOT IN (
            SELECT AU_ID 
            FROM PARTICIPACOES_AULA
            WHERE US_ID = {$this->US_ID}
        )
");


        foreach ($result->fetchAll(PDO::FETCH_ASSOC) as $row){
            $modalId = "modal-aula" . $row['AU_ID'];
            echo "
            <div class='card' style='width: 18rem;'>
            <div class='card-body'>
                <h5 class='card-title'>{$row['AU_NOME']}</h5>
                <h6 class='card-subtitle mb-2 text-body-secondary'>{$row['AU_VAGAS_DISPONIVEIS']}/{$row['AU_VAGAS_TOTAIS']} Vagas Disponiveis</h6>
                <p class='card-text'>Data: ". date('d/m/Y', strtotime($row['AU_DATA'])) . "</p>
                <p class='card-text'>Inicio: {$row['AU_HORA_INICIO']}</p>
                <p class='card-text'>Fim: {$row['AU_HORA_FIM']}</p>
                <button class='btn text-white' data-toggle='modal' data-target='#{$modalId}' style='background-color:#e35c38;'>Ver Mais</button>
            </div>
            </div>

            <div class='modal fade' id='{$modalId}' tabindex='-1' aria-hidden='true'>
                    <div class='modal-dialog modal-lg'>
                    <div class='modal-content'>
                    <div class='modal-header'>
                    <h5 class='modal-title'>{$row['AU_NOME']} - Detalhes</h5>
                    <button type='button' class='close' data-dismiss='modal'><span>&times;</span></button>
                    </div>


                    <div class='modal-body'>
                    <h5 class='mb-3'>Informações da Aula</h5>
                    <p><strong>Observações:</strong> " . (!empty($row['AU_OBSERVACOES']) ? $row['AU_OBSERVACOES'] : 'Nenhuma') . "</p>


                    <hr>


                    <table class='table table-striped table-bordered'>
                    <thead>
                    <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Inicio</th>
                    <th>Fim</th>
                    <th>Vagas Disponiveis</th>
                    <th>Vagas Totais</th>
                    <th>Sala</th>
                    <th>Clique para Participar</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                    <td>{$row['AU_ID']}</td>
                    <td>{$row['AU_NOME']}</td>
                    <td>{$row['AU_HORA_INICIO']}</td>
                    <td>{$row['AU_HORA_FIM']}</td>
                    <td>{$row['AU_VAGAS_DISPONIVEIS']}</td>
                    <td>{$row['AU_VAGAS_TOTAIS']}</td>
                    <td>{$row['AU_SALA']}</td>
                <td>
    <form method='POST'> 
        <input type='hidden' name='acao' value='participar'>
        <input type='hidden' name='AU_ID' value='{$row['AU_ID']}'>
        <button type='submit' class='btn btn-sm text-white' style='background-color:#e35c38;' " . ($row['AU_VAGAS_DISPONIVEIS'] <= 0 ? 'disabled' : '') . ">
            " . ($row['AU_VAGAS_DISPONIVEIS'] > 0 ? 'Participar' : 'Sem Vagas') . "
        </button>
    </form>
</td>
                    </tr>
                    </tbody>
                    </table>
                    </div>


                    <div class='modal-footer'>
                    <button class='btn btn-secondary' data-dismiss='modal'>Fechar</button>
                    </div>
                    </div>
                    </div>
                    </div>
            ";
        } 
        }
    public function buscarParticipacoes()
{
    $sql = "
        SELECT PA.*, A.AU_NOME, A.AU_DATA, A.AU_HORA_INICIO, A.AU_HORA_FIM, A.AU_SALA
        FROM PARTICIPACOES_AULA PA
        INNER JOIN AULAS A ON A.AU_ID = PA.AU_ID
        WHERE PA.US_ID = {$this->US_ID}
    ";

    $result = $this->conn->query($sql);

    foreach ($result->fetchAll(PDO::FETCH_ASSOC) as $row) {

        $modalId = "modal-participacao" . $row['PA_ID'];

        echo "
        <div class='card mb-3' style='max-width: 540px;'>
            <div class='card-body'>
                <h5 class='card-title'>{$row['AU_NOME']}</h5>
                <p class='card-text'>Status: <strong>{$row['PA_STATUS']}</strong></p>
                <p class='card-text'>Data: <strong>" . date('d/m/Y', strtotime($row['AU_DATA'])) . "</strong></p>
                <button class='btn text-white' data-bs-toggle='modal' data-bs-target='#{$modalId}' style='background-color:#e35c38;'>Ver Mais</button>
            </div>
        </div>

        <!-- Modal -->
        <div class='modal fade' id='{$modalId}' tabindex='-1' aria-hidden='true'>
            <div class='modal-dialog modal-lg'>
                <div class='modal-content'>

                    <div class='modal-header'>
                        <h5 class='modal-title'>Participação na Aula: {$row['AU_NOME']}</h5>
                        <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                    </div>

                    <div class='modal-body'>
                        <h5>Informações da Aula</h5>
                        <p><strong>Data:</strong> " . date('d/m/Y', strtotime($row['AU_DATA'])) . "</p>
                        <p><strong>Início:</strong> {$row['AU_HORA_INICIO']}</p>
                        <p><strong>Fim:</strong> {$row['AU_HORA_FIM']}</p>
                        <p><strong>Sala:</strong> {$row['AU_SALA']}</p>

                        <hr>

                        <h5>Sua Participação</h5>
                        <p><strong>Status:</strong> {$row['PA_STATUS']}</p>
                        <p><strong>Avaliação:</strong> " . ($row['PA_AVALIACAO'] ?: 'Nenhuma') . "</p>
                        <p><strong>Comentário:</strong> " . ($row['PA_COMENTARIO'] ?: 'Nenhum') . "</p>

                        <hr>

                        <!-- Formulário de Avaliação -->
                        <form method='POST' class='mb-3'>
                            <input type='hidden' name='acao' value='avaliar_participacao'>
                            <input type='hidden' name='PA_ID' value='{$row['PA_ID']}'>

                            <label class='form-label'>Avaliação (0 a 10)</label>
                            <input type='number' class='form-control' name='PA_AVALIACAO' min='0' max='10' value='{$row['PA_AVALIACAO']}'>

                            <label class='form-label mt-2'>Comentário</label>
                            <textarea class='form-control' name='PA_COMENTARIO' rows='3'>{$row['PA_COMENTARIO']}</textarea>

                            <button type='submit' class='btn text-white mt-3' style='background-color:#e35c38;'>Salvar Avaliação</button>
                        </form>

                        <hr>

                        <!-- Cancelar participação -->
                        <form method='POST'>
                            <input type='hidden' name='acao' value='cancelar_participacao'>
                            <input type='hidden' name='PA_ID' value='{$row['PA_ID']}'>
                            <button type='submit' class='btn btn-danger'>Cancelar Participação</button>
                        </form>

                    </div>

                    <div class='modal-footer'>
                        <button class='btn btn-secondary' data-bs-dismiss='modal'>Fechar</button>
                    </div>

                </div>
            </div>
        </div>
        ";
    }
}
    public function deleteRFID() {
        $query = "DELETE FROM RFID_TAGS  WHERE US_ID = :us_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':us_id', $this->US_ID);

        $stmt->execute();
        
        return $stmt;
    }
 }

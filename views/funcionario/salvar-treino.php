<?php
session_start();

use config\Database;
use models\sagef\Treino;
use models\sagef\TreinoExercicios;

require_once __DIR__ . "/../../config/Database.php";
require_once __DIR__ . "/../../models/sagef/Treino.php";
require_once __DIR__ . "/../../models/sagef/TreinoExercicios.php";

// =====================================
// 1. VERIFICAR SE TREINO TEM EXERCÍCIOS
// =====================================
if (!isset($_SESSION["treino_exercicios"]) || count($_SESSION["treino_exercicios"]) === 0) {
    die("Nenhum exercício foi adicionado ao treino.");
}

// =====================================
// 2. CONEXÃO E MODELS
// =====================================
$db = Database::getInstance()->getConnection();
$treino = new Treino($db);
$treinoEx = new TreinoExercicios($db);

// =====================================
// 3. RECEBE OS DADOS DO FORMULÁRIO
// =====================================
$treino->TR_NOME             = $_POST["TR_NOME"];
$treino->TR_DATA_CRIACAO     = $_POST["TR_DATA_CRIACAO"];
$treino->US_ID               = $_POST["US_ID"];
$treino->TR_DURACAO_ESTIMADA = $_POST["TR_DURACAO_ESTIMADA"];
$treino->TR_STATUS           = "ATIVO"; // se quiser deixar fixo ou trocar depois
$treino->TR_OBSERVACOES      = $_POST["TR_OBSERVACOES"];

// =====================================
// 4. CRIA O TREINO
// =====================================
$stmt = $treino->create();

if (!$stmt) {
    die("Erro ao cadastrar o treino.");
}

// pega o ID gerado automaticamente
$treinoID = $db->lastInsertId();
$ordem = 1;
// =====================================
// 5. SALVAR CADA EXERCÍCIO NO TREINO_EXERCICIOS
// =====================================
foreach ($_SESSION["treino_exercicios"] as $item) {

    $treinoEx->TR_ID         = $treinoID;
    $treinoEx->EX_ID         = $item["EX_ID"];
    $treinoEx->TE_SERIES     = $item["TE_SERIES"];
    $treinoEx->TE_REPETICOES = $item["TE_REPETICOES"];
    $treinoEx->TE_ORDEM      = $ordem;
    $treinoEx->create();
    $ordem++;
}

// =====================================
// 6. LIMPAR A SESSÃO
// =====================================
unset($_SESSION["treino_exercicios"]);

// =====================================
// 7. REDIRECIONAR
// =====================================
header("Location: register/treino?sucesso=1");
exit;


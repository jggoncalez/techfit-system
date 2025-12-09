<?php
session_start();
require_once __DIR__. "\\..\\..\\controllers\\sagef\\treinoController.php";
require_once __DIR__ ."\\..\\..\\controllers\\sagef\\treino_exercicio_Controller.php";

use controllers\sagef\TreinoExercicioController;
use controllers\sagef\TreinoController;

// Verificar se tem exercícios
if (!isset($_SESSION["treino_exercicios"]) || count($_SESSION["treino_exercicios"]) === 0) {
    die("❌ Nenhum exercício foi adicionado ao treino.");
}

// Instanciar controllers
$treino = new TreinoController();
$treinoEx = new TreinoExercicioController();

// Dados do treino
$treino->TR_NOME             = $_POST["TR_NOME"];
$treino->TR_DATA_CRIACAO     = $_POST["TR_DATA_CRIACAO"];
$treino->US_ID               = $_POST["US_ID"];
$treino->TR_DURACAO_ESTIMADA = $_POST["TR_DURACAO_ESTIMADA"];
$treino->TR_STATUS           = "ATIVO";
$treino->TR_OBSERVACOES      = $_POST["TR_OBSERVACOES"] ?? '';

// Criar o treino
$ultimoID = $treino->create();

if (!$ultimoID) {
    die("❌ Erro ao cadastrar o treino no banco de dados.");
}

// Salvar exercícios
$ordem = 1;
foreach ($_SESSION["treino_exercicios"] as $item) {
    // Pular exercícios vazios (proteção)
    if (empty($item["EX_ID"])) {
        continue;
    }
    
    $treinoEx->TR_ID         = $ultimoID;
    $treinoEx->EX_ID         = $item["EX_ID"];
    $treinoEx->TE_SERIES     = $item["TE_SERIES"];
    $treinoEx->TE_REPETICOES = $item["TE_REPETICOES"];
    $treinoEx->TE_ORDEM      = $ordem;
    
    $treinoEx->create();
    $ordem++;
}

// Limpar sessão
unset($_SESSION["treino_exercicios"]);

// Redirecionar
header("Location: /funcionario/register/treino?sucesso=1");
exit;
?>
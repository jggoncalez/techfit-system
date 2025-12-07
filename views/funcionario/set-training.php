<?php
session_start();

require_once __DIR__ ."\\..\\..\\config\\Database.php";
require_once __DIR__ ."\\..\\..\\models\\sagef\\Exercicio.php";
require_once __DIR__. "\\..\\..\\models\\sagef\\Treino.php";
require_once __DIR__ ."\\..\\..\\models\\sagef\\TreinoExercicios.php";

use config\Database;
use models\sagef\Exercicio;
use models\sagef\Treino;
use models\sagef\TreinoExercicios;

$db = Database::getInstance()->getConnection();

$controllerEx = new Exercicio($db);
$controllerTr = new Treino($db);
$controllerTE = new TreinoExercicios($db);

if (!isset($_SESSION["treino_exercicios"])) {
    $_SESSION["treino_exercicios"] = [];
}

/* ADICIONAR EXERCÍCIO */
if (isset($_POST["adicionar_exercicio"])) {
    $controllerEx->EX_ID = $_POST['EX_ID'];
    $dados = $controllerEx->searchID(); // agora retorna array

    $_SESSION["treino_exercicios"][] = [
    "EX_ID" => $dados["EX_ID"],
    "EX_NOME" => $dados["EX_NOME"],
    "TE_SERIES" => $_POST["TE_SERIES"],
    "TE_REPETICOES" => $_POST["TE_REPETICOES"]
    ];


    header("Location: /funcionario/register/treino");
    exit;
}

/* REMOVER */
if (isset($_GET["remover"])) {
    unset($_SESSION["treino_exercicios"][ $_GET["remover"] ]);
    $_SESSION["treino_exercicios"] = array_values($_SESSION["treino_exercicios"]);
    header("Location: /funcionario/register/treino");
    exit;
}

/* DELETAR TREINO */
if (isset($_POST["deletar_treino"])) {
    $controllerTr->TR_ID = $_POST["TR_ID"];
    $controllerTr->delete();
    header("Location: /funcionario/register/treino");
    exit;
}

/* ATUALIZAR TREINO */
if (isset($_POST["atualizar_treino"])) {
    $controllerTr->TR_ID = $_POST["TR_ID"];
    $controllerTr->TR_NOME = $_POST["TR_NOME"];
    $controllerTr->TR_DATA_CRIACAO = $_POST["TR_DATA_CRIACAO"];
    $controllerTr->US_ID = $_POST["US_ID"];
    $controllerTr->TR_DURACAO_ESTIMADA = $_POST["TR_DURACAO_ESTIMADA"];
    $controllerTr->TR_STATUS = $_POST["TR_STATUS"];
    $controllerTr->TR_OBSERVACOES = $_POST["TR_OBSERVACOES"];
    $controllerTr->update();
    header("Location: /funcionario/register/treino");
    exit;
}

$listaEx = $controllerEx->list(); // pega todos os exercícios
$listaTreinos = $controllerTr->list(); // pega todos os treinos


?>
<!doctype html>
<html lang="pt-br">
<head>
    <title>TechFit</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="shortcut icon" href="/Assets/images/TechFit-icon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <link rel="stylesheet" href="../../Assets/style/style.css">
</head>

<body>

<div class="d-flex" style="height:100vh;">
    
    <div class="d-flex" style="height: 100vh; overflow-y: auto; order:1;">
   <!-- Barra lateral -->
        <div class="sidebar d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 280px;">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                <img src="../../public/images/logo-fixed.webp" class="img-fluid mb-2" alt="TechFit Logo" style="max-width: 150px;">
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="/funcionario" class="nav-link link-dark">
                        <i class="bi bi-speedometer2 me-2"></i>Menu
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/funcionario/register/exercicios" class="nav-link link-dark">
                        <i class="bi bi-plus-circle me-2"></i>Exercícios
                    </a>
                </li>
                <li>
                    <a href="/funcionario/register/estudantes" class="nav-link link-dark">
                        <i class="bi bi-person-plus me-2"></i>Alunos
                    </a>
                </li>
                <li>
                    <a href="/funcionario/register/classes" class="nav-link link-dark">
                        <i class="bi bi-calendar-plus me-2"></i>Aulas
                    </a>
                </li>
                <li>
                    <a href="/funcionario/register/treino" class="nav-link active text-white" style="background-color: #e35c38;" aria-current="page">
                        <i class="bi bi-clipboard-plus me-2"></i>Treinos
                    </a>
                </li>
                <li>
                    <a href="/funcionario/RFID" class="nav-link link-dark">
                        <i class="bi bi-box-arrow-in-up-left"></i>
                          Acessos
                    </a>
                </li>
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" 
                   id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://placehold.co/32x32" alt="" width="32" height="32" class="rounded-circle me-2">
                    <strong id="user-name-sidebar">User</strong>
                </a>
                <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                    <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Perfil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-box-arrow-right me-2"></i>Sair</a></li>
                </ul>
            </div>
        </div>
    </main>
</div>


<!-- MODAL PARA ADICIONAR EXERCÍCIO -->
<div class="modal fade" id="modalExercicio">
  <div class="modal-dialog">
    <div class="modal-content">

      <form method="POST">

        <div class="modal-header">
          <h5 class="modal-title">Adicionar Exercício</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">

            <label class="form-label">Exercício</label>
            <select name="EX_ID" class="form-select" required>
                <option value="">Selecione</option>

                <?php foreach ($listaEx as $ex): ?>
                    <option value="<?= $ex['EX_ID'] ?>">
                        <?= $ex['EX_NOME'] ?>
                    </option>
                <?php endforeach; ?>

            </select>

            <label class="form-label mt-3">Séries</label>
            <input type="number" name="TE_SERIES" class="form-control" value="3" required>

            <label class="form-label mt-3">Repetições</label>
            <input type="number" name="TE_REPETICOES" class="form-control" value="10" required>

        </div>

        <div class="modal-footer">
          <button class="btn btn-primary" name="adicionar_exercicio">Adicionar</button>
        </div>

      </form>

    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

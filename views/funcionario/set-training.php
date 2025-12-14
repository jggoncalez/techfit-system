<?php
session_start();

require_once __DIR__ ."\\..\\..\\controllers\\sagef\\exercicioController.php";
require_once __DIR__. "\\..\\..\\controllers\\sagef\\treinoController.php";
require_once __DIR__ ."\\..\\..\\controllers\\sagef\\treino_exercicio_Controller.php";

use controllers\sagef\TreinoExercicioController;
use controllers\sagef\ExercicioController;
use controllers\sagef\TreinoController;
require_once __DIR__ . "\\..\\..\\controllers\\UsuarioController.php";
use controllers\UsuarioController;

$controllerUS = new UsuarioController();
$controllerEx = new ExercicioController();
$controllerTr = new TreinoController();
$controllerTE = new TreinoExercicioController();

$controllerUS->US_ID = $controllerTr->US_ID;
$stmt = $controllerUS->searchID();
require_once __DIR__ . "\\..\\..\\controllers\\FuncionarioController.php";
use controllers\FuncionarioController;
$controllerFun = new FuncionarioController();
$controllerFun->FU_ID = $_SESSION['user_ID'];
$controllerFun->searchID();
// Verifica se está logado
if (!isset($_SESSION['user_ID'])) {
    header("Location: /public/login.php");
    exit();
}
if (!isset($_SESSION["treino_exercicios"])) {
    $_SESSION["treino_exercicios"] = [];
}

/* ADICIONAR EXERCÍCIO */
if (isset($_POST["adicionar_exercicio"])) {
    $exercicioId = $_POST['EX_ID'] ?? '';
    
    if (empty($exercicioId)) {
        die("❌ ERRO: Nenhum exercício foi selecionado!");
    }
    
    $controllerEx->EX_ID = $exercicioId;
    $dados = $controllerEx->searchID();
    
    if (!$dados || !is_array($dados)) {
        die("❌ ERRO: Exercício não encontrado!");
    }

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
    <meta charset="UTF-8">
    <title>Montar Treino</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../Assets/style/style.css">
</head>

<body>

<div class="d-flex min-vh-100">
    
    <!-- SIDEBAR -->
    <div class="sidebar d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 280px;">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                <img src="../../public/images/logo-fixed.webp" class="img-fluid mb-2" alt="TechFit Logo"
                    style="max-width: 150px;">
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
                    <a href="/funcionario/register/admin" class="nav-link link-dark">
                        <i class="bi bi-people-fill me-2"></i>Funcionários
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
                    <img src="../../public/images/pfp_placeholder.webp" alt="" width="32" height="32" class="rounded-circle me-2">
                    <strong id="user-name-sidebar"><?php echo $controllerFun->FU_NOME ?></strong>
                </a>
                <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                    <li><a class="dropdown-item" href="/funcionario/profile"><i class="bi bi-person me-2"></i>Perfil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="/core/Session.php?action=logout"><i class="bi bi-box-arrow-right me-2"></i>Sair</a></li>
                </ul>
            </div>
        </div>

    <!-- CONTEÚDO -->
    <main class="p-4 flex-grow-1">
    
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Montar Treino</h2>
    </div>


        <form action="/funcionario/salvar" method="POST" class="row g-3">

            <div class="col-md-4">
                <label class="form-label">Nome do Treino</label>
                <input type="text" name="TR_NOME" class="form-control" required>
            </div>

            <div class="col-md-3">
                <label class="form-label">Data</label>
                <input type="date" name="TR_DATA_CRIACAO" class="form-control" min="<?php echo date('Y-m-d'); ?>" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Usuário</label>
                <select name="US_ID" class="form-select" required>
                    <option value="">Selecione</option>
                    <?= $controllerTr->buscarUsuarios() ?>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Duração (min)</label>
                <input type="number" name="TR_DURACAO_ESTIMADA" class="form-control" required>
            </div>

            <div class="col-md-12">
                <label class="form-label">Observações</label>
                <textarea name="TR_OBSERVACOES" class="form-control"></textarea>
            </div>

            <hr>

            <h4>Exercícios do Treino</h4>

            <button type="button" class="btn btn-secondary mb-3" data-bs-toggle="modal" data-bs-target="#modalExercicio">
                Adicionar Exercício
            </button>

            <?php if (!empty($_SESSION["treino_exercicios"])): ?>
                <ul class="list-group">
                    <?php foreach ($_SESSION["treino_exercicios"] as $i => $item): ?>
                        <li class="list-group-item d-flex justify-content-between">
                            <?= $item["EX_NOME"] ?> —
                            <?= $item["TE_SERIES"] ?> séries —
                            <?= $item["TE_REPETICOES"] ?> repetições

                            <a href="/funcionario/register/treino?remover=<?= $i ?>" class="btn btn-danger btn-sm">X</a>

                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <div class="col-12 mt-4">
                <button type="submit" class="btn btn-success">Salvar Treino</button>
            </div>

        </form>

        <!-- LISTA DE TREINOS -->
        <div class="mt-5">
            <h3>Treinos Cadastrados</h3>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Data</th>
                            <th>Usuário</th>
                            <th>Duração (min)</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $dados = $listaTreinos->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($dados as $treino): 
                            $modalId = "modal-treino-" . $treino['TR_ID'];
                            $statusClass = match($treino['TR_STATUS']) {
                                'ATIVO' => 'bg-success',
                                'INATIVO' => 'bg-secondary',
                                'CONCLUIDO' => 'bg-primary',
                                default => 'bg-warning'
                            };
                        ?>
                            <tr>
                                <td><?= $treino['TR_ID'] ?></td>
                                <td><?= $treino['TR_NOME'] ?></td>
                                <td><?= date('d/m/Y', strtotime($treino['TR_DATA_CRIACAO'])) ?></td>
                                <td><?php $controllerUS->US_ID =  $treino['US_ID']; $controllerUS->searchID(); echo $controllerUS->US_NOME?></td>
                                <td><?= $treino['TR_DURACAO_ESTIMADA'] ?></td>
                                <td><span class="badge <?= $statusClass ?>"><?= $treino['TR_STATUS'] ?></span></td>
                                <td>
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#<?= $modalId ?>">Editar</button>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="deletar_treino" value="1">
                                        <input type="hidden" name="TR_ID" value="<?= $treino['TR_ID'] ?>">
                                        <button class="btn btn-sm btn-danger" type="submit">Deletar</button>
                                    </form>
                                </td>
                            </tr>

                            <!-- MODAL EDITAR TREINO -->
                            <div class="modal fade" id="<?= $modalId ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Editar Treino #<?= $treino['TR_ID'] ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST">
                                                <input type="hidden" name="atualizar_treino" value="1">
                                                <input type="hidden" name="TR_ID" value="<?= $treino['TR_ID'] ?>">

                                                <div class="mb-3">
                                                    <label class="form-label">Nome do Treino</label>
                                                    <input type="text" name="TR_NOME" class="form-control" value="<?= $treino['TR_NOME'] ?>" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Data</label>
                                                    <input type="date" name="TR_DATA_CRIACAO" class="form-control" min="<?php echo date('Y-m-d'); ?>" value="<?= $treino['TR_DATA_CRIACAO'] ?>" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Usuário</label>
                                                    <select name="US_ID" class="form-select" required>
                                                        <?= $controllerTr->buscarUsuarios($treino['US_ID']) ?>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Duração (min)</label>
                                                    <input type="number" name="TR_DURACAO_ESTIMADA" class="form-control" value="<?= $treino['TR_DURACAO_ESTIMADA'] ?>" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Status</label>
                                                    <select name="TR_STATUS" class="form-select" required>
                                                        <option value="ATIVO" <?= $treino['TR_STATUS'] == 'ATIVO' ? 'selected' : '' ?>>Ativo</option>
                                                        <option value="INATIVO" <?= $treino['TR_STATUS'] == 'INATIVO' ? 'selected' : '' ?>>Inativo</option>
                                                        <option value="CONCLUIDO" <?= $treino['TR_STATUS'] == 'CONCLUIDO' ? 'selected' : '' ?>>Concluído</option>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Observações</label>
                                                    <textarea name="TR_OBSERVACOES" class="form-control" rows="3"><?= $treino['TR_OBSERVACOES'] ?></textarea>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <button type="submit" class="btn btn-primary text-white">Atualizar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </tbody>
                </table>
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
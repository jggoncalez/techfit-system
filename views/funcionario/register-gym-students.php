<!doctype html>
<html lang="pt-br">
<head>
    <title>TechFit</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="shortcut icon" href="public/images/TechFit-icon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../Assets/style/style.css">
</head>

<?php
require_once __DIR__ . '\\..\\..\\controllers\\UsuarioController.php';
require_once __DIR__ . "\\..\\..\\controllers\\FuncionarioController.php";
use controllers\FuncionarioController;
session_start();

// Verifica se está logado
if (!isset($_SESSION['user_ID'])) {
    header("Location: /public/login.php");
    exit();
}
use controllers\UsuarioController;
$controllerFun = new FuncionarioController();
$controllerFun->FU_ID = $_SESSION['user_ID'];
$controllerFun->searchID();
$controller = new UsuarioController();
$stmt = $controller->list();

// Processar ações do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';

    if ($acao === 'criar') {
        $controller->US_NOME = $_POST['US_NOME'];
        $controller->US_IDADE = $_POST['US_IDADE'];
        $controller->US_GENERO = $_POST['US_GENERO'];
        $controller->US_DATA_NASCIMENTO = $_POST['US_DATA_NASCIMENTO'];
        $controller->US_ALTURA = $_POST['US_ALTURA'];
        $controller->US_PESO = $_POST['US_PESO'];
        $controller->US_OBJETIVO = $_POST['US_OBJETIVO'] ?? '';
        $controller->US_PORC_MASSA_MAGRA = $_POST['US_PORC_MASSA_MAGRA'];
        $controller->US_TREINO_ANTERIOR = $_POST['US_TREINO_ANTERIOR'];
        $controller->US_TEMPO_TREINOANT = $_POST['US_TEMPO_TREINOANT'] ?? null;
        $controller->US_ENDERECO = $_POST['US_ENDERECO'];
        $controller->US_DISPONIBILIDADE = json_encode($_POST['US_DISPONIBILIDADE'] ?? [], JSON_UNESCAPED_UNICODE);
        $controller->PL_ID = $_POST['PL_ID'];
        $controller->US_STATUS_PAGAMENTO = $_POST['US_STATUS_PAGAMENTO'] ?? 'EM_DIA';
        
        $controller->create();
        header("Location: /funcionario/register/estudantes");
        exit;
    }

    if ($acao === 'atualizar') {
        $controller->US_ID = $_POST['US_ID'];
        $controller->US_NOME = $_POST['US_NOME'];
        $controller->US_IDADE = $_POST['US_IDADE'];
        $controller->US_GENERO = $_POST['US_GENERO'];
        $controller->US_DATA_NASCIMENTO = $_POST['US_DATA_NASCIMENTO'];
        $controller->US_ALTURA = $_POST['US_ALTURA'];
        $controller->US_PESO = $_POST['US_PESO'];
        $controller->US_OBJETIVO = $_POST['US_OBJETIVO'] ?? '';
        $controller->US_PORC_MASSA_MAGRA = $_POST['US_PORC_MASSA_MAGRA'];
        $controller->US_TREINO_ANTERIOR = $_POST['US_TREINO_ANTERIOR'];
        $controller->US_TEMPO_TREINOANT = $_POST['US_TEMPO_TREINOANT'] ?? null;
        $controller->US_ENDERECO = $_POST['US_ENDERECO'];
        $controller->US_DISPONIBILIDADE = json_encode($_POST['US_DISPONIBILIDADE'] ?? [], JSON_UNESCAPED_UNICODE);
        $controller->PL_ID = $_POST['PL_ID'];
        $controller->US_STATUS_PAGAMENTO = $_POST['US_STATUS_PAGAMENTO'] ?? 'EM_DIA';
        
        $controller->update();
        header("Location: /funcionario/register/estudantes");
        exit;
    }

    if ($acao === 'deletar') {
        $controller->US_ID = $_POST['US_ID'];
        $controller->deleteRFID();
        $controller->delete();
        header("Location: /funcionario/register/estudantes");
        exit;
    }
}
?>

<body>
    <div class="d-flex">
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
                    <a href="/funcionario/register/estudantes" class="nav-link active text-white" style="background-color: #e35c38;" aria-current="page">
                        <i class="bi bi-person-plus me-2"></i>Alunos
                    </a>
                </li>
                <li>
                    <a href="/funcionario/register/classes" class="nav-link link-dark">
                        <i class="bi bi-calendar-plus me-2"></i>Aulas
                    </a>
                </li>
                <li>
                    <a href="/funcionario/register/treino" class="nav-link link-dark">
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
                    <img src="https://placehold.co/32x32" alt="" width="32" height="32" class="rounded-circle me-2">
                    <strong id="user-name-sidebar"><?php echo $controllerFun->FU_NOME ?></strong>
                </a>
                <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                    <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Perfil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="/core/Session.php?action=logout"><i class="bi bi-box-arrow-right me-2"></i>Sair</a></li>
                </ul>
            </div>
        </div>

        <main class="flex-grow-1 p-4" style="overflow-y: auto;">
            <h2 class="mb-4">Cadastrar Usuário</h2>

            <form method="POST" class="row g-3">
                <input type="hidden" name="acao" value="criar">

                <!-- US_NOME -->
                <div class="col-md-6">
                    <label class="form-label">Nome *</label>
                    <input type="text" class="form-control" name="US_NOME" maxlength="25" required>
                </div>

                <!-- US_GENERO -->
                <div class="col-md-3">
                    <label class="form-label">Gênero *</label>
                    <select class="form-select" name="US_GENERO" required>
                        <option value="M">Masculino</option>
                        <option value="F">Feminino</option>
                        <option value="O">Outro</option>
                    </select>
                </div>

                <!-- US_DATA_NASCIMENTO -->
                <div class="col-md-3">
                    <label class="form-label">Data de Nascimento *</label>
                    <input type="date" class="form-control" name="US_DATA_NASCIMENTO" required>
                </div>

                <!-- US_IDADE -->
                <div class="col-md-2">
                    <label class="form-label">Idade *</label>
                    <input type="number" class="form-control" name="US_IDADE" required>
                </div>

                <!-- US_ALTURA -->
                <div class="col-md-2">
                    <label class="form-label">Altura (cm) *</label>
                    <input type="number" class="form-control" name="US_ALTURA" required>
                </div>

                <!-- US_PESO -->
                <div class="col-md-2">
                    <label class="form-label">Peso (kg) *</label>
                    <input type="number" step="0.01" class="form-control" name="US_PESO" required>
                </div>

                <!-- US_PORC_MASSA_MAGRA -->
                <div class="col-md-2">
                    <label class="form-label">% Massa Magra *</label>
                    <input type="number" step="0.01" class="form-control" name="US_PORC_MASSA_MAGRA" required>
                </div>

                <!-- US_OBJETIVO -->
                <div class="col-md-4">
                    <label class="form-label">Objetivo</label>
                    <select class="form-select" name="US_OBJETIVO">
                        <option value="">Selecione...</option>
                        <option value="EMAGRECER">Emagrecer</option>
                        <option value="PERDER PESO">Ganhar Peso</option>
                        <option value="SAÚDE">Saúde</option>
                    </select>
                </div>

                <!-- US_TREINO_ANTERIOR -->
                <div class="col-md-3">
                    <label class="form-label">Já treinou antes? *</label>
                    <select class="form-select" name="US_TREINO_ANTERIOR" required>
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                    </select>
                </div>

                <!-- US_TEMPO_TREINOANT -->
                <div class="col-md-3">
                    <label class="form-label">Tempo de treino (meses)</label>
                    <input type="number" class="form-control" name="US_TEMPO_TREINOANT" value = 0>
                </div>

                <!-- PL_ID -->
                <div class="col-md-3">
                    <label class="form-label">Plano *</label>
                    <select class="form-select" name="PL_ID" required>
                        <option value="">Selecione...</option>
                        <?php echo $controller->buscarPlanos(); ?>
                    </select>
                </div>

                <!-- US_STATUS_PAGAMENTO -->
                <div class="col-md-3">
                    <label class="form-label">Status do Pagamento</label>
                    <select class="form-select" name="US_STATUS_PAGAMENTO">
                        <option value="EM_DIA">Em dia</option>
                        <option value="ATRASADO">Atrasado</option>
                        <option value="CANCELADO">Cancelado</option>
                    </select>
                </div>

                <!-- US_ENDERECO -->
                <div class="col-md-12">
                    <label class="form-label">Endereço *</label>
                    <input type="text" class="form-control" name="US_ENDERECO" maxlength="255" required>
                </div>

                <!-- US_DISPONIBILIDADE -->
                <div class="col-md-12">
                    <label class="form-label">Disponibilidade *</label>
                    <div class="d-flex flex-wrap gap-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="US_DISPONIBILIDADE[]" value="segunda" id="segunda">
                            <label class="form-check-label" for="segunda">Segunda</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="US_DISPONIBILIDADE[]" value="terça" id="terça">
                            <label class="form-check-label" for="terça">Terça</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="US_DISPONIBILIDADE[]" value="quarta" id="quarta">
                            <label class="form-check-label" for="quarta">Quarta</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="US_DISPONIBILIDADE[]" value="quinta" id="quinta">
                            <label class="form-check-label" for="quinta">Quinta</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="US_DISPONIBILIDADE[]" value="sexta" id="sexta">
                            <label class="form-check-label" for="sexta">Sexta</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="US_DISPONIBILIDADE[]" value="sábado" id="sábado">
                            <label class="form-check-label" for="sábado">Sábado</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="US_DISPONIBILIDADE[]" value="domingo" id="domingo">
                            <label class="form-check-label" for="domingo">Domingo</label>
                        </div>
                    </div>
                </div>

                <div class="col-12 mt-3">
                    <button type="submit" class="btn text-white" style="background-color: #e35c38;">
                        Salvar Usuário
                    </button>
                </div>
            </form>

            <!-- Tabela de Usuários -->
            <div class="table-responsive mt-5">
                <h3 class="mb-3">Usuários Cadastrados</h3>
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Idade</th>
                            <th>Peso</th>
                            <th>Altura</th>
                            <th>Plano</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($dados as $row) {
                            $modalId = "modal-usuario-" . $row['US_ID'];
                            
                            $statusClass = match ($row['US_STATUS_PAGAMENTO']) {
                                'EM_DIA' => 'bg-success',
                                'ATRASADO' => 'bg-warning',
                                'CANCELADO' => 'bg-danger',
                                default => 'bg-secondary'
                            };
                            
                            echo "
                            <tr>
                                <td>{$row['US_ID']}</td>
                                <td>{$row['US_NOME']}</td>
                                <td>{$row['US_IDADE']}</td>
                                <td>{$row['US_PESO']} kg</td>
                                <td>{$row['US_ALTURA']} cm</td>
                                <td>Plano {$row['PL_ID']}</td>
                                <td><span class='badge {$statusClass}'>{$row['US_STATUS_PAGAMENTO']}</span></td>
                                <td>
                                    <button class='btn btn-sm btn-warning' data-bs-toggle='modal' data-bs-target='#{$modalId}'>Editar</button>
                                    <form method='POST' style='display:inline;'>
                                        <input type='hidden' name='acao' value='deletar'>
                                        <input type='hidden' name='US_ID' value='{$row['US_ID']}'>
                                        <button class='btn btn-sm btn-danger' type='submit' onclick='return confirm(\"Tem certeza que deseja deletar este usuário?\")'>Deletar</button>
                                    </form>
                                </td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- Modals de Edição -->
    <?php foreach ($dados as $row):
        $modalId = "modal-usuario-" . $row['US_ID'];
        $disponibilidade = json_decode($row['US_DISPONIBILIDADE'], true) ?? [];
    ?>
        <div class='modal fade' id='<?= $modalId ?>' tabindex='-1' aria-hidden='true'>
            <div class='modal-dialog modal-xl'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h5 class='modal-title'>Editar Usuário: <?= htmlspecialchars($row['US_NOME']) ?></h5>
                        <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                    </div>
                    <div class='modal-body'>
                        <form method='POST'>
                            <input type='hidden' name='acao' value='atualizar'>
                            <input type='hidden' name='US_ID' value='<?= $row['US_ID'] ?>'>
                            
                            <div class='row g-3'>
                                <div class='col-md-6'>
                                    <label class='form-label'>Nome</label>
                                    <input type='text' class='form-control' name='US_NOME' value='<?= htmlspecialchars($row['US_NOME']) ?>' required>
                                </div>
                                
                                <div class='col-md-3'>
                                    <label class='form-label'>Gênero</label>
                                    <select class='form-select' name='US_GENERO' required>
                                        <option value='M' <?= $row['US_GENERO'] == 'M' ? 'selected' : '' ?>>Masculino</option>
                                        <option value='F' <?= $row['US_GENERO'] == 'F' ? 'selected' : '' ?>>Feminino</option>
                                        <option value='O' <?= $row['US_GENERO'] == 'O' ? 'selected' : '' ?>>Outro</option>
                                    </select>
                                </div>
                                
                                <div class='col-md-3'>
                                    <label class='form-label'>Data de Nascimento</label>
                                    <input type='date' class='form-control' name='US_DATA_NASCIMENTO' value='<?= $row['US_DATA_NASCIMENTO'] ?>' required>
                                </div>
                                
                                <div class='col-md-2'>
                                    <label class='form-label'>Idade</label>
                                    <input type='number' class='form-control' name='US_IDADE' value='<?= $row['US_IDADE'] ?>' required>
                                </div>
                                
                                <div class='col-md-2'>
                                    <label class='form-label'>Altura (cm)</label>
                                    <input type='number' class='form-control' name='US_ALTURA' value='<?= $row['US_ALTURA'] ?>' required>
                                </div>
                                
                                <div class='col-md-2'>
                                    <label class='form-label'>Peso (kg)</label>
                                    <input type='number' step='0.01' class='form-control' name='US_PESO' value='<?= $row['US_PESO'] ?>' required>
                                </div>
                                
                                <div class='col-md-2'>
                                    <label class='form-label'>% Massa Magra</label>
                                    <input type='number' step='0.01' class='form-control' name='US_PORC_MASSA_MAGRA' value='<?= $row['US_PORC_MASSA_MAGRA'] ?>' required>
                                </div>
                                
                                <div class='col-md-4'>
                                    <label class='form-label'>Objetivo</label>
                                    <select class='form-select' name='US_OBJETIVO'>
                                        <option value=''>Selecione...</option>
                                        <option value='EMAGRECER' <?= $row['US_OBJETIVO'] == 'EMAGRECER' ? 'selected' : '' ?>>Emagrecer</option>
                                        <option value='PERDER PESO' <?= $row['US_OBJETIVO'] == 'GANHAR PESO' ? 'selected' : '' ?>>Perder Peso</option>
                                        <option value='SAÚDE' <?= $row['US_OBJETIVO'] == 'SAÚDE' ? 'selected' : '' ?>>Saúde</option>
                                    </select>
                                </div>
                                
                                <div class='col-md-3'>
                                    <label class='form-label'>Já treinou antes?</label>
                                    <select class='form-select' name='US_TREINO_ANTERIOR' required>
                                        <option value='1' <?= $row['US_TREINO_ANTERIOR'] == 1 ? 'selected' : '' ?>>Sim</option>
                                        <option value='0' <?= $row['US_TREINO_ANTERIOR'] == 0 ? 'selected' : '' ?>>Não</option>
                                    </select>
                                </div>
                                
                                <div class='col-md-3'>
                                    <label class='form-label'>Tempo de treino (meses)</label>
                                    <input type='number' class='form-control' name='US_TEMPO_TREINOANT' value='<?= $row['US_TEMPO_TREINOANT'] ?>'>
                                </div>
                                
                                <div class='col-md-3'>
                                    <label class='form-label'>Plano</label>
                                    <select class='form-select' name='PL_ID' required>
                                        <option value=''>Selecione...</option>
                                        <?php echo $controller->buscarPlanos(); ?>
                                    </select>
                                </div>
                                
                                <div class='col-md-3'>
                                    <label class='form-label'>Status Pagamento</label>
                                    <select class='form-select' name='US_STATUS_PAGAMENTO'>
                                        <option value='EM_DIA' <?= $row['US_STATUS_PAGAMENTO'] == 'EM_DIA' ? 'selected' : '' ?>>Em dia</option>
                                        <option value='ATRASADO' <?= $row['US_STATUS_PAGAMENTO'] == 'ATRASADO' ? 'selected' : '' ?>>Atrasado</option>
                                        <option value='CANCELADO' <?= $row['US_STATUS_PAGAMENTO'] == 'CANCELADO' ? 'selected' : '' ?>>Cancelado</option>
                                    </select>
                                </div>
                                
                                <div class='col-md-12'>
                                    <label class='form-label'>Endereço</label>
                                    <input type='text' class='form-control' name='US_ENDERECO' value='<?= htmlspecialchars($row['US_ENDERECO']) ?>' required>
                                </div>
                                
                                <div class='col-md-12'>
                                    <label class='form-label'>Disponibilidade</label>
                                    <div class='d-flex flex-wrap gap-3'>
                                        <?php
                                        $diasSemana = ['segunda', 'terça', 'quarta', 'quinta', 'sexta', 'sábado', 'domingo'];
                                        foreach ($diasSemana as $dia):
                                            $checked = in_array($dia, $disponibilidade) ? 'checked' : '';
                                            $inputId = "edit-{$dia}-{$row['US_ID']}";
                                        ?>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='checkbox' name='US_DISPONIBILIDADE[]' 
                                                       value='<?= $dia ?>' id='<?= $inputId ?>' <?= $checked ?>>
                                                <label class='form-check-label' for='<?= $inputId ?>'><?= ucfirst($dia) ?></label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                                <button type='submit' class='btn text-white' style='background-color: #e35c38;'>Atualizar Usuário</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
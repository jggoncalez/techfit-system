<?php
session_start();

// Verifica autenticação
if (!isset($_SESSION['user_ID'])) {
    header("Location: /public/login.php");
    exit();
}

require_once __DIR__ . '/../../controllers/UsuarioController.php';
require_once __DIR__ . '/../../controllers/FuncionarioController.php';

use controllers\FuncionarioController;
use controllers\UsuarioController;

// Inicializa controladores
$controllerFun = new FuncionarioController();
$controllerFun->FU_ID = $_SESSION['user_ID'];
$controllerFun->searchID();

$controller = new UsuarioController();

// Funções auxiliares
function formatStatus($status) {
    return match ($status) {
        'EM_DIA' => 'Em dia',
        'ATRASADO' => 'Atrasado',
        'CANCELADO' => 'Cancelado',
        default => 'Desconhecido'
    };
}

function getStatusClass($status) {
    return match ($status) {
        'EM_DIA' => 'bg-success',
        'ATRASADO' => 'bg-warning text-dark',
        'CANCELADO' => 'bg-danger',
        default => 'bg-secondary'
    };
}

// Processamento de formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';

    // Captura e sanitiza dados básicos (com valores padrão para evitar null)
    $controller->US_NOME = filter_input(INPUT_POST, 'US_NOME', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
    $controller->US_GENERO = filter_input(INPUT_POST, 'US_GENERO', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
    $controller->US_DATA_NASCIMENTO = filter_input(INPUT_POST, 'US_DATA_NASCIMENTO', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
    $controller->US_ALTURA = filter_input(INPUT_POST, 'US_ALTURA', FILTER_VALIDATE_INT) ?? 0;
    $controller->US_PESO = filter_input(INPUT_POST, 'US_PESO', FILTER_VALIDATE_FLOAT) ?? 0.0;
    $controller->US_OBJETIVO = filter_input(INPUT_POST, 'US_OBJETIVO', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
    $controller->US_TREINO_ANTERIOR = filter_input(INPUT_POST, 'US_TREINO_ANTERIOR', FILTER_VALIDATE_INT) ?? 0;
    $controller->US_TEMPO_TREINOANT = filter_input(INPUT_POST, 'US_TEMPO_TREINOANT', FILTER_VALIDATE_INT) ?? 0;
    $controller->US_ENDERECO = filter_input(INPUT_POST, 'US_ENDERECO', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
    $controller->PL_ID = filter_input(INPUT_POST, 'PL_ID', FILTER_VALIDATE_INT) ?? 0;
    $controller->US_STATUS_PAGAMENTO = filter_input(INPUT_POST, 'US_STATUS_PAGAMENTO', FILTER_SANITIZE_SPECIAL_CHARS) ?? 'EM_DIA';
    
    // Processa disponibilidade (checkbox)
    $disponibilidade = $_POST['US_DISPONIBILIDADE'] ?? [];
    $controller->US_DISPONIBILIDADE = json_encode($disponibilidade, JSON_UNESCAPED_UNICODE) ?: '[]';

    // Executa ação
    if ($acao === 'criar') {
        $controller->create();
        header("Location: /funcionario/register/estudantes");
        exit;
    }

    if ($acao === 'atualizar') {
        $controller->US_ID = filter_input(INPUT_POST, 'US_ID', FILTER_VALIDATE_INT);
        $controller->update();
        header("Location: /funcionario/register/estudantes");
        exit;
    }

    if ($acao === 'deletar') {
        $controller->US_ID = filter_input(INPUT_POST, 'US_ID', FILTER_VALIDATE_INT);
        $controller->deleteRFID();
        $controller->delete();
        header("Location: /funcionario/register/estudantes");
        exit;
    }
}

// Busca dados
$stmt = $controller->list();
$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Captura HTML dos planos usando output buffering
ob_start();
$controller->buscarPlanos();
$planosHtml = ob_get_clean();

// Mapeia planos para exibição na tabela
$planosMap = [];
if (preg_match_all('/<option value=\'(\d+)\'>(.*?)<\/option>/', $planosHtml, $matches)) {
    $planosMap = array_combine($matches[1], $matches[2]);
}
?>
<!doctype html>
<html lang="pt-br">
<head>
    <title>TechFit - Cadastro de Alunos</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="shortcut icon" href="/public/images/TechFit-icon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../Assets/style/style.css"> 
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar d-flex flex-column flex-shrink-0 p-3 bg-light">
            <a href="/funcionario" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                <img src="/public/images/logo-fixed.webp" class="img-fluid mb-2" alt="TechFit Logo" style="max-width: 150px;">
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
                    <a href="/funcionario/register/estudantes" class="nav-link active text-white techfit-bg" aria-current="page">
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
                        <i class="bi bi-box-arrow-in-up-left me-2"></i>Acessos
                    </a>
                </li>
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" 
                    id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="/public/images/pfp_placeholder.webp" alt="" width="32" height="32" class="rounded-circle me-2">
                    <strong><?= htmlspecialchars($controllerFun->FU_NOME ?? 'Funcionário') ?></strong>
                </a>
                <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                    <li><a class="dropdown-item" href="/funcionario/profile"><i class="bi bi-person me-2"></i>Perfil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="/core/Session.php?action=logout"><i class="bi bi-box-arrow-right me-2"></i>Sair</a></li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <main class="flex-grow-1 p-4" style="overflow-y: auto;">
            <h2 class="mb-4">Cadastrar Aluno</h2>
            <form method="POST" class="row g-3">
                <input type="hidden" name="acao" value="criar">

                            <div class="col-md-6">
                                <label class="form-label">Nome *</label>
                                <input type="text" class="form-control" name="US_NOME" maxlength="50" required>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Gênero *</label>
                                <select class="form-select" name="US_GENERO" required>
                                    <option value="M">Masculino</option>
                                    <option value="F">Feminino</option>
                                    <option value="O">Outro</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Data de Nascimento *</label>
                                <input type="date" class="form-control" name="US_DATA_NASCIMENTO" max="<?= date('Y-m-d') ?>" required>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Altura (cm) *</label>
                                <input type="number" class="form-control" name="US_ALTURA" min="50" max="300" required>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Peso (kg) *</label>
                                <input type="number" step="0.01" class="form-control" name="US_PESO" min="1" max="500" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Objetivo</label>
                                <select class="form-select" name="US_OBJETIVO">
                                    <option value="">Selecione...</option>
                                    <option value="EMAGRECER">Emagrecer</option>
                                    <option value="GANHAR PESO">Ganhar Massa</option>
                                    <option value="SAÚDE">Saúde e Bem-estar</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Já treinou antes? *</label>
                                <select class="form-select" name="US_TREINO_ANTERIOR" required>
                                    <option value="0" selected>Não</option>
                                    <option value="1">Sim</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Tempo de treino (meses)</label>
                                <input type="number" class="form-control" name="US_TEMPO_TREINOANT" min="0" value="0">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Plano *</label>
                                <select class="form-select" name="PL_ID" required>
                                    <option value="">Selecione...</option>
                                    <?= $planosHtml ?>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Status do Pagamento</label>
                                <select class="form-select" name="US_STATUS_PAGAMENTO">
                                    <option value="EM_DIA">Em dia</option>
                                    <option value="ATRASADO">Atrasado</option>
                                    <option value="CANCELADO">Cancelado</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Endereço *</label>
                                <input type="text" class="form-control" name="US_ENDERECO" maxlength="255" required>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Disponibilidade de Treino *</label>
                                <div class="d-flex flex-wrap gap-3 p-2 border rounded">
                                    <?php 
                                        $diasSemana = ['segunda' => 'Segunda', 'terça' => 'Terça', 'quarta' => 'Quarta', 
                                                       'quinta' => 'Quinta', 'sexta' => 'Sexta', 'sábado' => 'Sábado', 'domingo' => 'Domingo'];
                                        foreach ($diasSemana as $value => $label):
                                    ?>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="US_DISPONIBILIDADE[]" value="<?= $value ?>" id="<?= $value ?>">
                                            <label class="form-check-label" for="<?= $value ?>"><?= $label ?></label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <button type="submit" class="btn text-white" style="background-color: #e35c38;">
                                    Salvar Aluno
                                </button>
                            </div>
                        </form>

                        <!-- Tabela de Alunos -->
                        <div class="table-responsive mt-5">
                            <h3 class="mb-3">Alunos Cadastrados</h3>
                
                <?php if (empty($dados)): ?>
                    <div class="alert alert-info text-center" role="alert">
                        Nenhum aluno cadastrado.
                    </div>
                <?php else: ?>
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Nascimento</th>
                            <th>Peso</th>
                            <th>Altura</th>
                            <th>Plano</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php foreach ($dados as $row):
                                $modalId = "modal-usuario-" . $row['US_ID'];
                                $statusClass = getStatusClass($row['US_STATUS_PAGAMENTO']);
                                $statusFormatado = formatStatus($row['US_STATUS_PAGAMENTO']);
                                $nomePlano = $planosMap[$row['PL_ID']] ?? "Plano {$row['PL_ID']}";
                                $nomeEscapado = htmlspecialchars($row['US_NOME'], ENT_QUOTES, 'UTF-8');
                            ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['US_ID']) ?></td>
                                    <td><?= $nomeEscapado ?></td>
                                    <td><?= date('d/m/Y', strtotime($row['US_DATA_NASCIMENTO'])) ?></td>
                                    <td><?= number_format($row['US_PESO'], 2, ',', '.') ?> kg</td>
                                    <td><?= htmlspecialchars($row['US_ALTURA']) ?> cm</td>
                                    <td><?= htmlspecialchars($nomePlano) ?></td>
                                    <td><span class="badge <?= $statusClass ?>"><?= $statusFormatado ?></span></td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#<?= $modalId ?>">Editar</button>
                                        <form method="POST" style="display:inline;">
                                            <input type="hidden" name="acao" value="deletar">
                                            <input type="hidden" name="US_ID" value="<?= $row['US_ID'] ?>">
                                            <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('Tem certeza que deseja deletar <?= $nomeEscapado ?>?')">Deletar</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>

            </div>
        </main>
    </div>

    <!-- Modais de Edição -->
    <?php foreach ($dados as $row):
        $modalId = "modal-usuario-" . $row['US_ID'];
        $dispJson = $row['US_DISPONIBILIDADE'] ?? '[]';
        $disponibilidade = is_string($dispJson) ? (json_decode($dispJson, true) ?? []) : [];
        $nomeEscapado = htmlspecialchars($row['US_NOME'], ENT_QUOTES, 'UTF-8');
    ?>
        <div class="modal fade" id="<?= $modalId ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Aluno: <?= $nomeEscapado ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST">
                            <input type="hidden" name="acao" value="atualizar">
                            <input type="hidden" name="US_ID" value="<?= $row['US_ID'] ?>">
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nome *</label>
                                    <input type="text" class="form-control" name="US_NOME" value="<?= $nomeEscapado ?>" required>
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="form-label">Gênero *</label>
                                    <select class="form-select" name="US_GENERO" required>
                                        <option value="M" <?= $row['US_GENERO'] == 'M' ? 'selected' : '' ?>>Masculino</option>
                                        <option value="F" <?= $row['US_GENERO'] == 'F' ? 'selected' : '' ?>>Feminino</option>
                                        <option value="O" <?= $row['US_GENERO'] == 'O' ? 'selected' : '' ?>>Outro</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="form-label">Data de Nascimento *</label>
                                    <input type="date" class="form-control" name="US_DATA_NASCIMENTO" 
                                           value="<?= htmlspecialchars($row['US_DATA_NASCIMENTO']) ?>" 
                                           max="<?= date('Y-m-d') ?>" required>
                                </div>
                                
                                <div class="col-md-2">
                                    <label class="form-label">Altura (cm) *</label>
                                    <input type="number" class="form-control" name="US_ALTURA" 
                                           value="<?= htmlspecialchars($row['US_ALTURA']) ?>" 
                                           min="50" max="300" required>
                                </div>
                                
                                <div class="col-md-2">
                                    <label class="form-label">Peso (kg) *</label>
                                    <input type="number" step="0.01" class="form-control" name="US_PESO" 
                                           value="<?= htmlspecialchars($row['US_PESO']) ?>" 
                                           min="1" max="500" required>
                                </div>
                                
                                <div class="col-md-4">
                                    <label class="form-label">Objetivo</label>
                                    <select class="form-select" name="US_OBJETIVO">
                                        <option value="">Selecione...</option>
                                        <option value="EMAGRECER" <?= $row['US_OBJETIVO'] == 'EMAGRECER' ? 'selected' : '' ?>>Emagrecer</option>
                                        <option value="GANHAR PESO" <?= $row['US_OBJETIVO'] == 'GANHAR PESO' ? 'selected' : '' ?>>Ganhar Massa</option>
                                        <option value="SAÚDE" <?= $row['US_OBJETIVO'] == 'SAÚDE' ? 'selected' : '' ?>>Saúde e Bem-estar</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-2">
                                    <label class="form-label">Já treinou? *</label>
                                    <select class="form-select" name="US_TREINO_ANTERIOR" required>
                                        <option value="0" <?= $row['US_TREINO_ANTERIOR'] == 0 ? 'selected' : '' ?>>Não</option>
                                        <option value="1" <?= $row['US_TREINO_ANTERIOR'] == 1 ? 'selected' : '' ?>>Sim</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-2">
                                    <label class="form-label">Tempo treino (meses)</label>
                                    <input type="number" class="form-control" name="US_TEMPO_TREINOANT" 
                                           value="<?= htmlspecialchars($row['US_TEMPO_TREINOANT'] ?? 0) ?>" min="0">
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="form-label">Plano *</label>
                                    <select class="form-select" name="PL_ID" required>
                                        <option value="">Selecione...</option>
                                        <?= str_replace("value='{$row['PL_ID']}'", "value='{$row['PL_ID']}' selected", $planosHtml) ?>
                                    </select>
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="form-label">Status Pagamento</label>
                                    <select class="form-select" name="US_STATUS_PAGAMENTO">
                                        <option value="EM_DIA" <?= $row['US_STATUS_PAGAMENTO'] == 'EM_DIA' ? 'selected' : '' ?>>Em dia</option>
                                        <option value="ATRASADO" <?= $row['US_STATUS_PAGAMENTO'] == 'ATRASADO' ? 'selected' : '' ?>>Atrasado</option>
                                        <option value="CANCELADO" <?= $row['US_STATUS_PAGAMENTO'] == 'CANCELADO' ? 'selected' : '' ?>>Cancelado</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Endereço *</label>
                                    <input type="text" class="form-control" name="US_ENDERECO" 
                                           value="<?= htmlspecialchars($row['US_ENDERECO']) ?>" required>
                                </div>
                                
                                <div class="col-md-12">
                                    <label class="form-label">Disponibilidade de Treino *</label>
                                    <div class="d-flex flex-wrap gap-3 p-2 border rounded">
                                        <?php
                                            $diasSemana = ['segunda' => 'Segunda', 'terça' => 'Terça', 'quarta' => 'Quarta', 
                                                           'quinta' => 'Quinta', 'sexta' => 'Sexta', 'sábado' => 'Sábado', 'domingo' => 'Domingo'];
                                            foreach ($diasSemana as $value => $label):
                                                $checked = in_array($value, $disponibilidade) ? 'checked' : '';
                                        ?>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="US_DISPONIBILIDADE[]" 
                                                       value="<?= $value ?>" id="edit-<?= $value ?>-<?= $row['US_ID'] ?>" <?= $checked ?>>
                                                <label class="form-check-label" for="edit-<?= $value ?>-<?= $row['US_ID'] ?>"><?= $label ?></label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="modal-footer mt-4">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn text-white" style="background-color: #e35c38;">Atualizar Aluno</button>
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
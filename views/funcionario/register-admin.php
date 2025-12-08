<!doctype html>
<html lang="pt-br">

<head>
    <title>TechFit - Funcionários</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="shortcut icon" href="../public/images/TechFit-icon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../Assets/style/style.css">
</head>

<?php
require_once __DIR__ . '\\..\\..\\config\\Database.php';
require_once __DIR__ . '\\..\\..\\models\\Funcionario.php';

use config\Database;
use models\Funcionario;

try {
    $db = Database::getInstance()->getConnection();
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
    exit;
}

$controller = new Funcionario($db);
$stmt = $controller->list();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';

    if ($acao === 'criar') {
        $controller->FU_NOME = $_POST['FU_NOME'];
        $controller->FU_GENERO = $_POST['FU_GENERO'];
        $controller->FU_SENHA = $_POST['FU_SENHA'];
        $controller->FU_NIVEL_ACESSO = $_POST['FU_NIVEL_ACESSO'];
        $controller->FU_SALARIO = $_POST['FU_SALARIO'];
        $controller->FU_DATA_ADMISSAO = $_POST['FU_DATA_ADMISSAO'];
        $controller->create();
        header("Location: /funcionario/register/admin");
        exit;
    }

    if ($acao === 'atualizar') {
        $controller->FU_ID = $_POST['FU_ID'];
        $controller->FU_NOME = $_POST['FU_NOME'];
        $controller->FU_GENERO = $_POST['FU_GENERO'];
        $controller->FU_NIVEL_ACESSO = $_POST['FU_NIVEL_ACESSO'];
        $controller->FU_SALARIO = $_POST['FU_SALARIO'];
        $controller->FU_DATA_ADMISSAO = $_POST['FU_DATA_ADMISSAO'];
        
        // Só atualiza a senha se foi fornecida uma nova
        if (!empty($_POST['FU_SENHA'])) {
            $controller->FU_SENHA = $_POST['FU_SENHA'];
        }
        
        $controller->update();
        header("Location: /funcionario/register/admin");
        exit;
    }

    if ($acao === 'deletar') {
        $controller->FU_ID = $_POST['FU_ID'];
        $controller->delete();
        header("Location: /funcionario/register/admin");
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
                    <a href="/funcionario/register/treino" class="nav-link link-dark">
                        <i class="bi bi-clipboard-plus me-2"></i>Treinos
                    </a>
                </li>
                <li>
                    <a href="/funcionario/register/admin" class="nav-link active text-white" style="background-color: #e35c38;" aria-current="page">
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
                    <strong id="user-name-sidebar">User</strong>
                </a>
                <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                    <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Perfil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="/core/Session.php?action=logout"><i class="bi bi-box-arrow-right me-2"></i>Sair</a></li>
                </ul>
            </div>
        </div>

        <main class="flex-grow-1 p-4" style="overflow-y: auto;">
            <h2 class="mb-4">Cadastrar Funcionário</h2>
            <form method="POST" class="row g-3">
                <input type="hidden" name="acao" value="criar">

                <!-- FU_NOME -->
                <div class="col-md-6">
                    <label class="form-label">Nome Completo *</label>
                    <input type="text" class="form-control" name="FU_NOME" required>
                </div>

                <!-- FU_GENERO -->
                <div class="col-md-3">
                    <label class="form-label">Gênero *</label>
                    <select class="form-select" name="FU_GENERO" required>
                        <option value="">Selecione...</option>
                        <option value="M" selected>Masculino</option>
                        <option value="F">Feminino</option>
                        <option value="O">Outro</option>
                    </select>
                </div>

                <!-- FU_NIVEL_ACESSO -->
                <div class="col-md-3">
                    <label class="form-label">Nível de Acesso *</label>
                    <select class="form-select" name="FU_NIVEL_ACESSO" required>
                        <option value="">Selecione...</option>
                        <option value="1" selected>Nível 1 - Básico</option>
                        <option value="2">Nível 2 - Intermediário</option>
                        <option value="3">Nível 3 - Administrador</option>
                    </select>
                </div>

                <!-- FU_SENHA -->
                <div class="col-md-4">
                    <label class="form-label">Senha *</label>
                    <input type="password" class="form-control" name="FU_SENHA" required minlength="4">
                    <small class="text-muted">Mínimo 4 caracteres</small>
                </div>

                <!-- FU_SALARIO -->
                <div class="col-md-4">
                    <label class="form-label">Salário (R$) *</label>
                    <input type="number" class="form-control" name="FU_SALARIO" step="0.01" min="0" required>
                </div>

                <!-- FU_DATA_ADMISSAO -->
                <div class="col-md-4">
                    <label class="form-label">Data de Admissão *</label>
                    <input type="date" class="form-control" name="FU_DATA_ADMISSAO" required>
                </div>

                <div class="col-12 mt-3">
                    <button type="submit" class="btn text-white" style="background-color: #e35c38;">
                        <i class="bi bi-save me-2"></i>Salvar Funcionário
                    </button>
                </div>
            </form>

            <!-- Tabela de Funcionários -->
            <div class="table-responsive mt-5">
                <h3 class="mb-3">Funcionários Cadastrados</h3>
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Gênero</th>
                            <th>Nível</th>
                            <th>Salário</th>
                            <th>Data Admissão</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($dados as $row) {
                            $modalId = "modal-funcionario-" . $row['FU_ID'];

                            // Badge de nível de acesso
                            $nivelClass = match ($row['FU_NIVEL_ACESSO']) {
                                1 => 'bg-info',
                                2 => 'bg-warning',
                                3 => 'bg-danger',
                                default => 'bg-secondary'
                            };

                            $nivelTexto = match ($row['FU_NIVEL_ACESSO']) {
                                1 => 'Básico',
                                2 => 'Intermediário',
                                3 => 'Admin',
                                default => 'N/A'
                            };

                            $generoTexto = match ($row['FU_GENERO']) {
                                'M' => 'Masculino',
                                'F' => 'Feminino',
                                'O' => 'Outro',
                                default => $row['FU_GENERO']
                            };

                            echo "
                            <tr>
                                <td>{$row['FU_ID']}</td>
                                <td>{$row['FU_NOME']}</td>
                                <td>{$generoTexto}</td>
                                <td><span class='badge {$nivelClass}'>{$nivelTexto}</span></td>
                                <td>R$ " . number_format($row['FU_SALARIO'], 2, ',', '.') . "</td>
                                <td>" . date('d/m/Y', strtotime($row['FU_DATA_ADMISSAO'])) . "</td>
                                <td>
                                    <button class='btn btn-sm btn-warning' data-bs-toggle='modal' data-bs-target='#{$modalId}'>
                                        <i class='bi bi-pencil'></i> Editar
                                    </button>
                                    <form method='POST' style='display:inline;' onsubmit='return confirm(\"Tem certeza que deseja deletar este funcionário?\");'>
                                        <input type='hidden' name='acao' value='deletar'>
                                        <input type='hidden' name='FU_ID' value='{$row['FU_ID']}'>
                                        <button class='btn btn-sm btn-danger' type='submit'>
                                            <i class='bi bi-trash'></i> Deletar
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal Editar -->
                            <div class='modal fade' id='{$modalId}' tabindex='-1' aria-hidden='true'>
                                <div class='modal-dialog modal-lg'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h5 class='modal-title'>Editar Funcionário: {$row['FU_NOME']}</h5>
                                            <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                        </div>
                                        <div class='modal-body'>
                                            <form method='POST'>
                                                <input type='hidden' name='acao' value='atualizar'>
                                                <input type='hidden' name='FU_ID' value='{$row['FU_ID']}'>
                                                
                                                <div class='row g-3'>
                                                    <div class='col-md-12'>
                                                        <label class='form-label'>Nome Completo</label>
                                                        <input type='text' class='form-control' name='FU_NOME' value='{$row['FU_NOME']}' required>
                                                    </div>
                                                
                                                    <div class='col-md-6'>
                                                        <label class='form-label'>Gênero</label>
                                                        <select class='form-select' name='FU_GENERO' required>
                                                            <option value='M' " . ($row['FU_GENERO'] == 'M' ? 'selected' : '') . ">Masculino</option>
                                                            <option value='F' " . ($row['FU_GENERO'] == 'F' ? 'selected' : '') . ">Feminino</option>
                                                            <option value='O' " . ($row['FU_GENERO'] == 'O' ? 'selected' : '') . ">Outro</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class='col-md-6'>
                                                        <label class='form-label'>Nível de Acesso</label>
                                                        <select class='form-select' name='FU_NIVEL_ACESSO' required>
                                                            <option value='1' " . ($row['FU_NIVEL_ACESSO'] == 1 ? 'selected' : '') . ">Nível 1 - Básico</option>
                                                            <option value='2' " . ($row['FU_NIVEL_ACESSO'] == 2 ? 'selected' : '') . ">Nível 2 - Intermediário</option>
                                                            <option value='3' " . ($row['FU_NIVEL_ACESSO'] == 3 ? 'selected' : '') . ">Nível 3 - Admin</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class='col-md-6'>
                                                        <label class='form-label'>Nova Senha</label>
                                                        <input type='password' class='form-control' name='FU_SENHA' minlength='4'>
                                                        <small class='text-muted'>Deixe em branco para manter a senha atual</small>
                                                    </div>
                                                    
                                                    <div class='col-md-6'>
                                                        <label class='form-label'>Salário (R$)</label>
                                                        <input type='number' class='form-control' name='FU_SALARIO' value='{$row['FU_SALARIO']}' step='0.01' required>
                                                    </div>
                                                    
                                                    <div class='col-md-12'>
                                                        <label class='form-label'>Data de Admissão</label>
                                                        <input type='date' class='form-control' name='FU_DATA_ADMISSAO' value='{$row['FU_DATA_ADMISSAO']}' required>
                                                    </div>
                                                </div>
                                                
                                                <div class='modal-footer'>
                                                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                                                    <button type='submit' class='btn text-white' style='background-color: #e35c38;'>
                                                        <i class='bi bi-save me-2'></i>Atualizar Funcionário
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            ";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
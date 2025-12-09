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
<?php
require_once __DIR__ . '\\..\\..\\controllers\\sagef\\ExercicioController.php';

use controllers\sagef\ExercicioController;

$controller = new ExercicioController();
$stmt = $controller->list();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';
    if ($acao === 'criar') {
        $controller->EX_DESCRICAO = $_POST['EX_DESCRICAO'];
        $controller->EX_DIFICULDADE = $_POST['EX_DIFICULDADE'];
        $controller->EX_EQUIPAMENTO = $_POST['EX_EQUIPAMENTO'];
        $controller->EX_MAX_REPETICOES = $_POST['EX_MAX_REPETICOES'];
        $controller->EX_MIN_REPETICOES = $_POST['EX_MIN_REPETICOES'];
        $controller->EX_NOME = $_POST['EX_NOME'];
        $controller->EX_PONTUACAO = $_POST['EX_PONTUACAO'];
        $controller->EX_TEMPO_DESCANSO = $_POST['EX_TEMPO_DESCANSO'];
        $controller->EX_TIPO = $_POST['EX_TIPO'];
        $controller->create();
        header("Location: /funcionario/register/exercicios");
        exit;
    } 
    if ($acao === 'atualizar') {
        $controller->EX_ID = $_POST['EX_ID'];
        $controller->EX_DESCRICAO = $_POST['EX_DESCRICAO'];
        $controller->EX_DIFICULDADE = $_POST['EX_DIFICULDADE'];
        $controller->EX_EQUIPAMENTO = $_POST['EX_EQUIPAMENTO'];
        $controller->EX_MAX_REPETICOES = $_POST['EX_MAX_REPETICOES'];
        $controller->EX_MIN_REPETICOES = $_POST['EX_MIN_REPETICOES'];
        $controller->EX_NOME = $_POST['EX_NOME'];
        $controller->EX_PONTUACAO = $_POST['EX_PONTUACAO'];
        $controller->EX_TEMPO_DESCANSO = $_POST['EX_TEMPO_DESCANSO'];
        $controller->EX_TIPO = $_POST['EX_TIPO'];
        $controller->update();
        header("Location: /funcionario/register/exercicios");
        exit;
    }
    if ($acao === 'deletar'){
        $controller->EX_ID = $_POST['EX_ID'];
        $controller->delete();
        header("Location: /funcionario/register/exercicios");
        exit;
    }
 }
?>

<body>

    <div class="d-flex" style="height: 100vh;">
        <div class="d-flex">
       <!-- Barra lateral -->
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
                    <a href="/funcionario/register/exercicios" class="nav-link active text-white" style="background-color: #e35c38;" aria-current="page">
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
            <h2 class="mb-4">Cadastrar Exercício</h2>
            <form method="POST" class="row g-3">
                <input type="hidden" name="acao" value='criar'>
                <!-- EX_NOME -->
                <div class="col-md-6">
                    <label class="form-label">Nome do Exercício *</label>
                    <input type="text" class="form-control" name="EX_NOME" required>
                </div>

                <!-- EX_DIFICULDADE -->
                <div class="col-md-3">
                    <label class="form-label">Dificuldade *</label>
                    <input type="number" class="form-control" name="EX_DIFICULDADE" min="1" max="10" required>
                </div>

                <!-- EX_TIPO -->
                <div class="col-md-3">
                    <label class="form-label">Tipo *</label>
                    <select class="form-select" name="EX_TIPO" required>
                        <option value="">Selecione...</option>
                        <option value="PEITO">Peito</option>
                        <option value="COSTAS">Costas</option>
                        <option value="PERNAS">Pernas</option>
                        <option value="OMBROS">Ombros</option>
                        <option value="BRACOS">Braços</option>
                        <option value="ABDOMEN">Abdômen</option>
                        <option value="CARDIO">Cardio</option>
                        <option value="FUNCIONAL">Funcional</option>
                    </select>
                </div>

                <!-- EX_MIN_REPETICOES -->
                <div class="col-md-3">
                    <label class="form-label">Repetições Mínimas *</label>
                    <input type="number" class="form-control" name="EX_MIN_REPETICOES" value="8" required>
                </div>

                <!-- EX_MAX_REPETICOES -->
                <div class="col-md-3">
                    <label class="form-label">Repetições Máximas *</label>
                    <input type="number" class="form-control" name="EX_MAX_REPETICOES" value="20" required>
                </div>

                <!-- EX_PONTUACAO -->
                <div class="col-md-3">
                    <label class="form-label">Pontuação</label>
                    <input type="number" class="form-control" name="EX_PONTUACAO" value="10">
                </div>

                <!-- EX_TEMPO_DESCANSO -->
                <div class="col-md-3">
                    <label class="form-label">Tempo de Descanso (segundos)</label>
                    <input type="number" class="form-control" name="EX_TEMPO_DESCANSO" value="60">
                </div>

                <!-- EX_EQUIPAMENTO -->
                <div class="col-md-6">
                    <label class="form-label">Equipamento Necessário</label>
                    <input type="text" class="form-control" name="EX_EQUIPAMENTO"
                        placeholder="Ex: Halteres, Máquina X, Barra...">
                </div>

                <!-- EX_DESCRICAO -->
                <div class="col-md-12">
                    <label class="form-label">Descrição do Exercício</label>
                    <textarea class="form-control" name="EX_DESCRICAO" rows="4"></textarea>
                </div>

                <div class="col-12 mt-3">
                    <button type="submit" class="btn text-white" style="background-color: #e35c38;">
                        Salvar Exercício
                    </button>
                </div>

            </form>
            <!-- Tabela de Exercícios -->
            <div class='table-responsive mt-5'>
                <h3 class="mb-3">Exercícios Cadastrados</h3>
                <table class='table table-striped table-hover'>
                    <thead class='table-dark'>
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Tipo</th>
                            <th>Dificuldade</th>
                            <th>Equipamento</th>
                            <th>Repetições</th>
                            <th>Descanso (s)</th>
                            <th>Pontuação</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($dados as $row) {
                            $modalId = "modal-exercicio-" . $row['EX_ID'];
                            echo "
                            <tr>
                                <td>{$row['EX_ID']}</td>
                                <td>{$row['EX_NOME']}</td>
                                <td>{$row['EX_TIPO']}</td>
                                <td>{$row['EX_DIFICULDADE']}</td>
                                <td>{$row['EX_EQUIPAMENTO']}</td>
                                <td>{$row['EX_MIN_REPETICOES']} - {$row['EX_MAX_REPETICOES']}</td>
                                <td>{$row['EX_TEMPO_DESCANSO']}</td>
                                <td><span class='badge bg-info'>{$row['EX_PONTUACAO']}</span></td>
                                <td>
                                    <button class='btn btn-sm btn-warning' data-bs-toggle='modal' data-bs-target='#{$modalId}'>Editar</button>
                                    <form method='POST' style='display:inline;'> 
                                        <input type='hidden' name='acao' value='deletar'>
                                        <input type='hidden' name='EX_ID' value='{$row['EX_ID']}'>
                                        <button class='btn btn-sm btn-danger' type='submit'>Deletar</button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal para editar exercício -->
                            <div class='modal fade' id='{$modalId}' tabindex='-1' aria-hidden='true'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h5 class='modal-title'>Editar Exercício: {$row['EX_NOME']}</h5>
                                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                        </div>
                                        <div class='modal-body'>
                                            <form method='POST'>
                                                <input type='hidden' name='acao' value='atualizar'>
                                                <input type='hidden' name='EX_ID' value='{$row['EX_ID']}'>
                                                
                                                <div class='mb-3'>
                                                    <label class='form-label'>Nome do Exercício</label>
                                                    <input type='text' class='form-control' name='EX_NOME' value='{$row['EX_NOME']}' required>
                                                </div>
                                                
                                                <div class='mb-3'>
                                                    <label class='form-label'>Tipo</label>
                                                    <select class='form-select' name='EX_TIPO' required>
                                                        <option value='PEITO' " . ($row['EX_TIPO'] == 'PEITO' ? 'selected' : '') . ">Peito</option>
                                                        <option value='COSTAS' " . ($row['EX_TIPO'] == 'COSTAS' ? 'selected' : '') . ">Costas</option>
                                                        <option value='PERNAS' " . ($row['EX_TIPO'] == 'PERNAS' ? 'selected' : '') . ">Pernas</option>
                                                        <option value='OMBROS' " . ($row['EX_TIPO'] == 'OMBROS' ? 'selected' : '') . ">Ombros</option>
                                                        <option value='BRACOS' " . ($row['EX_TIPO'] == 'BRACOS' ? 'selected' : '') . ">Braços</option>
                                                        <option value='ABDOMEN' " . ($row['EX_TIPO'] == 'ABDOMEN' ? 'selected' : '') . ">Abdômen</option>
                                                        <option value='CARDIO' " . ($row['EX_TIPO'] == 'CARDIO' ? 'selected' : '') . ">Cardio</option>
                                                        <option value='FUNCIONAL' " . ($row['EX_TIPO'] == 'FUNCIONAL' ? 'selected' : '') . ">Funcional</option>
                                                    </select>
                                                </div>
                                                
                                                <div class='mb-3'>
                                                    <label class='form-label'>Dificuldade</label>
                                                    <input type='number' class='form-control' name='EX_DIFICULDADE' value='{$row['EX_DIFICULDADE']}' min='1' max='10' required>
                                                </div>
                                                
                                                <div class='mb-3'>
                                                    <label class='form-label'>Repetições Mínimas</label>
                                                    <input type='number' class='form-control' name='EX_MIN_REPETICOES' value='{$row['EX_MIN_REPETICOES']}' required>
                                                </div>
                                                
                                                <div class='mb-3'>
                                                    <label class='form-label'>Repetições Máximas</label>
                                                    <input type='number' class='form-control' name='EX_MAX_REPETICOES' value='{$row['EX_MAX_REPETICOES']}' required>
                                                </div>
                                                
                                                <div class='mb-3'>
                                                    <label class='form-label'>Tempo de Descanso (segundos)</label>
                                                    <input type='number' class='form-control' name='EX_TEMPO_DESCANSO' value='{$row['EX_TEMPO_DESCANSO']}' required>
                                                </div>
                                                
                                                <div class='mb-3'>
                                                    <label class='form-label'>Equipamento</label>
                                                    <input type='text' class='form-control' name='EX_EQUIPAMENTO' value='{$row['EX_EQUIPAMENTO']}'>
                                                </div>
                                                
                                                <div class='mb-3'>
                                                    <label class='form-label'>Pontuação</label>
                                                    <input type='number' class='form-control' name='EX_PONTUACAO' value='{$row['EX_PONTUACAO']}'>
                                                </div>
                                                
                                                <div class='mb-3'>
                                                    <label class='form-label'>Descrição</label>
                                                    <textarea class='form-control' name='EX_DESCRICAO' rows='3'>{$row['EX_DESCRICAO']}</textarea>
                                                </div>
                                                
                                                <div class='modal-footer'>
                                                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                                                    <button type='submit' class='btn text-white' style='background-color: #e35c38;'>Atualizar Exercício</button>
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

            <body></body>
        </main>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>
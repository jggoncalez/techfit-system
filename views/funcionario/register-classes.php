<!doctype html>
<html lang="pt-br">

<head>
    <title>TechFit</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="shortcut icon" href="/Assets/images/TechFit-icon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="../../Assets/style/style.css">
</head>

<?php
require_once __DIR__ . '\\..\\..\\config\\Database.php';
require_once __DIR__ . '\\..\\..\\models\\agendamento\\Aula.php';

use config\Database;
use models\agendamento\Aula;

try {
    $db = Database::getInstance()->getConnection();
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
    exit;
}

$controller = new Aula($db);
$stmt = $controller->list();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';

    if ($acao === 'criar') {
        $controller->AU_NOME = $_POST['AU_NOME'];
        $controller->AU_DATA = $_POST['AU_DATA'];
        $controller->AU_HORA_FIM = $_POST['AU_HORA_FIM'];
        $controller->AU_HORA_INICIO = $_POST['AU_HORA_INICIO'];
        $controller->AU_OBSERVACOES = $_POST['AU_OBSERVACOES'];
        $controller->AU_SALA = $_POST['AU_SALA'];
        $controller->AU_STATUS = $_POST['AU_STATUS'];
        $controller->AU_VAGAS_TOTAIS = $_POST['AU_VAGAS_TOTAIS'];
        $controller->AU_VAGAS_DISPONIVEIS = $_POST['AU_VAGAS_TOTAIS'];
        $controller->FU_ID = $_POST['FU_ID'];
        $controller->create();
        header("Location: /funcionario/register/classes");
        exit;
    }

    if ($acao === 'atualizar') {
        $controller->AU_ID = $_POST['AU_ID'];
        $controller->AU_NOME = $_POST['AU_NOME'];
        $controller->AU_DATA = $_POST['AU_DATA'];
        $controller->AU_HORA_FIM = $_POST['AU_HORA_FIM'];
        $controller->AU_HORA_INICIO = $_POST['AU_HORA_INICIO'];
        $controller->AU_OBSERVACOES = $_POST['AU_OBSERVACOES'];
        $controller->AU_SALA = $_POST['AU_SALA'];
        $controller->AU_STATUS = $_POST['AU_STATUS'];
        $controller->AU_VAGAS_TOTAIS = $_POST['AU_VAGAS_TOTAIS'];
        $controller->AU_VAGAS_DISPONIVEIS = $_POST['AU_VAGAS_DISPONIVEIS'];
        $controller->FU_ID = $_POST['FU_ID'];
        $controller->update();
        header("Location: /funcionario/register/classes");
        exit;
    }

    if ($acao === 'deletar') {
        $controller->AU_ID = $_POST['AU_ID'];
        $controller->delete();
        header("Location: /funcionario/register/classes");
        exit;
    }
}
?>

<body>
    <div class="d-flex" style="height: 100vh;">
        <!-- Sidebar -->
        <div class="sidebar d-flex flex-column flex-shrink-0 p-3 bg-light" style="height: 100vh; width: 280px;">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                <img src="../../public/images/logo-fixed.webp" class="img-fluid mb-2" alt="TechFit Logo" style="max-width: 150px;">
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="/funcionario" class="nav-link link-dark">Home</a>
                </li>
                <li class="nav-item">
                    <a href="/funcionario/register/exercicios" class="nav-link link-dark">Cadastrar Exercícios</a>
                </li>
                <li>
                    <a href="/funcionario/register/estudantes" class="nav-link link-dark">Cadastrar Alunos</a>
                </li>
                <li>
                    <a href="/funcionario/register/classes" class="nav-link active text-white" style="background-color: #e35c38;" aria-current="page">Cadastrar Aulas</a>
                </li>
                <li>
                    <a href="/funcionario/register/treino" class="nav-link link-dark">Montar Treinos</a>
                </li>
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://placehold.co/20x20" alt="" width="32" height="32" class="rounded-circle me-2">
                    <p id="user-name"><strong>User</strong></p>
                </a>
            </div>
        </div>

        <main class="flex-grow-1 p-4" style="overflow-y: auto;">
            <h2 class="mb-4">Cadastrar Aula</h2>
            <form method="POST" class="row g-3">
                <input type="hidden" name="acao" value="criar">

                <!-- AU_NOME -->
                <div class="col-md-6">
                    <label class="form-label">Nome da Aula *</label>
                    <input type="text" class="form-control" name="AU_NOME" required>
                </div>

                <!-- FU_ID -->
                <div class="col-md-3">
                    <label class="form-label">Funcionário *</label>
                    <select class="form-select" name="FU_ID" required>
                        <option value="">Selecione...</option>
                        <?php echo $controller->buscarFuncionarios(); ?>
                    </select>
                </div>

                <!-- AU_DATA -->
                <div class="col-md-3">
                    <label class="form-label">Data *</label>
                    <input type="date" class="form-control" name="AU_DATA" required>
                </div>

                <!-- AU_HORA_INICIO -->
                <div class="col-md-2">
                    <label class="form-label">Hora Início *</label>
                    <input type="time" class="form-control" name="AU_HORA_INICIO" required>
                </div>

                <!-- AU_HORA_FIM -->
                <div class="col-md-2">
                    <label class="form-label">Hora Fim *</label>
                    <input type="time" class="form-control" name="AU_HORA_FIM" required>
                </div>

                <!-- AU_SALA -->
                <div class="col-md-2">
                    <label class="form-label">Sala *</label>
                    <input type="text" class="form-control" name="AU_SALA" placeholder="Ex: Sala 1" required>
                </div>

                <!-- AU_VAGAS_TOTAIS -->
                <div class="col-md-3">
                    <label class="form-label">Vagas Totais *</label>
                    <input type="number" class="form-control" name="AU_VAGAS_TOTAIS" min="1" value="15" required>
                </div>

                <!-- AU_STATUS -->
                <div class="col-md-3">
                    <label class="form-label">Status *</label>
                    <select class="form-select" name="AU_STATUS" required>
                        <option value="AGENDADA" selected>Agendada</option>
                        <option value="EM_ANDAMENTO">Em Andamento</option>
                        <option value="CONCLUIDA">Concluída</option>
                        <option value="CANCELADA">Cancelada</option>
                    </select>
                </div>

                <!-- AU_OBSERVACOES -->
                <div class="col-md-12">
                    <label class="form-label">Observações</label>
                    <textarea class="form-control" name="AU_OBSERVACOES" rows="3"></textarea>
                </div>

                <div class="col-12 mt-3">
                    <button type="submit" class="btn text-white" style="background-color: #e35c38;">
                        Salvar Aula
                    </button>
                </div>
            </form>

            <!-- Tabela de Aulas -->
            <div class="table-responsive mt-5">
                <h3 class="mb-3">Aulas Cadastradas</h3>
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Data</th>
                            <th>Horário</th>
                            <th>Sala</th>
                            <th>Vagas</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($dados as $row) {
                            $modalId = "modal-aula-" . $row['AU_ID'];

                            // Badge de status
                            $statusClass = match ($row['AU_STATUS']) {
                                'AGENDADA' => 'bg-primary',
                                'EM_ANDAMENTO' => 'bg-warning',
                                'CONCLUIDA' => 'bg-success',
                                'CANCELADA' => 'bg-danger',
                                default => 'bg-secondary'
                            };

                            echo "
                            <tr>
                                <td>{$row['AU_ID']}</td>
                                <td>{$row['AU_NOME']}</td>
                                <td>" . date('d/m/Y', strtotime($row['AU_DATA'])) . "</td>
                                <td>" . date('H:i', strtotime($row['AU_HORA_INICIO'])) . " - " . date('H:i', strtotime($row['AU_HORA_FIM'])) . "</td>
                                <td>{$row['AU_SALA']}</td>
                                <td>{$row['AU_VAGAS_DISPONIVEIS']}/{$row['AU_VAGAS_TOTAIS']}</td>
                                <td><span class='badge {$statusClass}'>{$row['AU_STATUS']}</span></td>
                                <td>
                                    <button class='btn btn-sm btn-warning' data-bs-toggle='modal' data-bs-target='#{$modalId}'>Editar</button>
                                    <form method='POST' style='display:inline;'>
                                        <input type='hidden' name='acao' value='deletar'>
                                        <input type='hidden' name='AU_ID' value='{$row['AU_ID']}'>
                                        <button class='btn btn-sm btn-danger' type='submit')'>Deletar</button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal Editar -->
                            <div class='modal fade' id='{$modalId}' tabindex='-1' aria-hidden='true'>
                                <div class='modal-dialog modal-lg'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h5 class='modal-title'>Editar Aula: {$row['AU_NOME']}</h5>
                                            <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                        </div>
                                        <div class='modal-body'>
                                            <form method='POST'>
                                                <input type='hidden' name='acao' value='atualizar'>
                                                <input type='hidden' name='AU_ID' value='{$row['AU_ID']}'>
                                                
                                                <div class='row g-3'>
                                                    <div class='col-md-6'>
                                                        <label class='form-label'>Nome da Aula</label>
                                                        <input type='text' class='form-control' name='AU_NOME' value='{$row['AU_NOME']}' required>
                                                    </div>
                                                
                                                    <div class='col-md-4'>
                                                        <label class='form-label'>Data</label>
                                                        <input type='date' class='form-control' name='AU_DATA' value='{$row['AU_DATA']}' required>
                                                    </div>
                                                    
                                                    <div class='col-md-4'>
                                                        <label class='form-label'>Hora Início</label>
                                                        <input type='time' class='form-control' name='AU_HORA_INICIO' value='{$row['AU_HORA_INICIO']}' required>
                                                    </div>
                                                    
                                                    <div class='col-md-4'>
                                                        <label class='form-label'>Hora Fim</label>
                                                        <input type='time' class='form-control' name='AU_HORA_FIM' value='{$row['AU_HORA_FIM']}' required>
                                                    </div>
                                                    
                                                    <div class='col-md-4'>
                                                        <label class='form-label'>Sala</label>
                                                        <input type='text' class='form-control' name='AU_SALA' value='{$row['AU_SALA']}' required>
                                                    </div>
                                                    
                                                    <div class='col-md-4'>
                                                        <label class='form-label'>Vagas Disponíveis</label>
                                                        <input type='number' class='form-control' name='AU_VAGAS_DISPONIVEIS' value='{$row['AU_VAGAS_DISPONIVEIS']}' required>
                                                    </div>
                                                    
                                                    <div class='col-md-4'>
                                                        <label class='form-label'>Vagas Totais</label>
                                                        <input type='number' class='form-control' name='AU_VAGAS_TOTAIS' value='{$row['AU_VAGAS_TOTAIS']}' required>
                                                    </div>
                                                    
                                                    <div class='col-md-6'>
                                                        <label class='form-label'>Funcionário</label>
                                                        <select class='form-select' name='FU_ID' required>
                                                        <option value=''>Selecione...</option>
                                                        " . $controller->buscarFuncionarios($row['FU_ID']) . "
                                                    </select>
                                                    </div>
                                                    
                                                    <div class='col-md-6'>
                                                        <label class='form-label'>Status</label>
                                                        <select class='form-select' name='AU_STATUS' required>
                                                            <option value='AGENDADA' " . ($row['AU_STATUS'] == 'AGENDADA' ? 'selected' : '') . ">Agendada</option>
                                                            <option value='EM_ANDAMENTO' " . ($row['AU_STATUS'] == 'EM_ANDAMENTO' ? 'selected' : '') . ">Em Andamento</option>
                                                            <option value='CONCLUIDA' " . ($row['AU_STATUS'] == 'CONCLUIDA' ? 'selected' : '') . ">Concluída</option>
                                                            <option value='CANCELADA' " . ($row['AU_STATUS'] == 'CANCELADA' ? 'selected' : '') . ">Cancelada</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class='col-12'>
                                                        <label class='form-label'>Observações</label>
                                                        <textarea class='form-control' name='AU_OBSERVACOES' rows='3'>{$row['AU_OBSERVACOES']}</textarea>
                                                    </div>
                                                </div>
                                                
                                                <div class='modal-footer'>
                                                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                                                    <button type='submit' class='btn text-white' style='background-color: #e35c38;'>Atualizar Aula</button>
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
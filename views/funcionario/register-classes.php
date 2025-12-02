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
    echo "Ai " . $e->getMessage();
}
$controller = new Aula($db);

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
        $controller->FU_ID = $_POST['FU_ID'];
        $controller->create();
    }
}

?>

<body>

    <div class="d-flex" style="height: 100vh; overflow-y: auto;">
        <!-- Sidebar -->
        <div class="sidebar d-flex flex-column flex-shrink-0 p-3 bg-light" style="height: 100vh; width: 280px;">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                <img src="../../public/images/logo-fixed.webp" class="img-fluid mb-2" alt="TechFit Logo" style="max-width: 150px;">
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="/funcionario" class="nav-link link-dark">
                        Home
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/funcionario/register/exercicios" class="nav-link link-dark">
                        Cadastrar Exercícios
                    </a>
                </li>
                <li>
                    <a href="/funcionario/register/estudantes" class="nav-link link-dark">
                        Cadastrar Alunos
                    </a>
                </li>
                <li>
                    <a href="/funcionario/register/classes" class="nav-link active text-white" style="background-color: #e35c38;" aria-current="page">
                        Cadastrar Aulas
                    </a>
                </li>
                <li>
                    <a href="/funcionario/get/classes" class="nav-link link-dark">
                        Ver Aulas
                    </a>
                </li>
                <li>
                    <a href="/funcionario/get/estudantes" class="nav-link link-dark">
                        Ver Alunos
                    </a>
                </li>
                <li>
                    <a href="/funcionario/register/treino" class="nav-link link-dark">
                        Montar Treinos
                    </a>
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
            <h2 class="mb-4">Cadastrar Aulas</h2>
            <form method="POST" class="row g-3">
                <input type="hidden" name='acao' value='criar'>
                <!-- AU_NOME -->
                <div class="col-md-6">
                    <label class="form-label">Nome da Aula</label>
                    <input type="text" class="form-control" name="AU_NOME" required>
                </div>
                <!-- AU_TIPO -->
                <div class="col-md-3">
                    <label class="form-label">Tipo *</label>
                    <select class="form-select" name="AU_TIPO" required>
                        <option value="">Selecione...</option>
                        <option value="ZUMBA">ZUMBA</option>
                        <option value="CROSS-FIT">CROSS-FIT</option>
                        <option value="PILATES">PILATES</option>
                        <option value="YOGA">YOGA</option>
                    </select>
                </div>
                <!-- AU_DATA -->
                <div class="col-md-3">
                    <label class="form-label">Data *</label>
                    <input type="date" class="form-control" name="AU_DATA" required>
                </div>
                <!-- AU_HORA_INICIO -->
                <div class="col-md-3">
                    <label class="form-label">Hora Inicio *</label>
                    <input type="time" class="form-control" name="AU_HORA_INICIO" required>
                </div>
                <!-- AU_HORA_FIM -->
                <div class="col-md-3">
                    <label class="form-label">Hora Fim *</label>
                    <input type="time" class="form-control" name="AU_HORA_FIM" required>
                </div>
                <!-- AU_VAGAS_TOTAIS -->
                <div class="col-md-3">
                    <label class="form-label">Funcionario *</label>
                    <select class="form-control" name="FU_ID">
                        <option value="">Selecione um Funcionario</option>
                        <?php
                        $controller->buscarFuncionarios();
                        ?>
                    </select>
                </div>
                <!-- AU_SALA -->
                <div class="col-md-3">
                    <label class="form-label">Sala *</label>
                    <input type="number" class="form-control" name="AU_SALA" required>
                </div>
                <!-- AU_VAGAS_TOTAIS -->
                <div class="col-md-3">
                    <label class="form-label">Vagas Totais *</label>
                    <input type="number" class="form-control" name="AU_VAGAS_TOTAIS" required>
                </div>
                <!-- AU_STATUS -->
                <div class="col-md-3">
                    <label class="form-label">Staus *</label>
                    <select class="form-select" name="AU_STATUS" required>
                        <option value="">Selecione...</option>
                        <option value='AGENDADA'>Agendada</option>
                        <option value='CONCLUIDA'>Concluida</option>
                        <option value='EM_ANDAMENTO'>Em Andamento</option>
                        <option value='CANCELADA'>Cancelada</option>
                    </select>
                </div>


                <!-- AU_OBSEVAÇÕES -->
                <div class="col-md-12">
                    <label class="form-label">Observações</label>
                    <textarea class="form-control" name="AU_OBSERVACOES" rows="4"></textarea>
                </div>
                <div class="col-12 mt-3">
                    <button type="submit" class="btn text-white" style="background-color: #e35c38;">
                        Salvar Aula
                    </button>
                </div>
            </form>

        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
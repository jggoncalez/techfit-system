<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>TechFit</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="shortcut icon" href="../public/images/TechFit-icon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="../../Assets/style/style.css">
</head>

</html>
<?php
require_once __DIR__ . "\\..\\..\\controllers\\UsuarioController.php";
require_once __DIR__ . "\\..\\..\\config\\Database.php";
require_once __DIR__ . "\\..\\..\\controllers\\agendamento\\ParticipacoesAulaController.php";

use controllers\agendamento\ParticipacoesAulaController;
use controllers\UsuarioController;



session_start();
$controller = new UsuarioController();
$user = $_SESSION['user_ID'];
$controller->US_ID = $user;
$controller->searchID();
$controllerPart = new ParticipacoesAulaController();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $acao = $_POST['acao'] ?? '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $acao = $_POST['acao'] ?? '';

        if ($acao == 'participar') {
            $controllerPart->AU_ID = $_POST['AU_ID'];
            $controllerPart->US_ID = $user;
            $controllerPart->PA_DATA_INSCRICAO = date('Y-m-d H:i:s');
            $controllerPart->PA_STATUS = 'INSCRITO';

            $controllerPart->create();

            // Atualiza as vagas disponíveis
            $controllerPart->atualizarVagasDisponiveis($_POST['AU_ID']);
            header('Location: /usuario/user/schedule');
            exit();
        }

        if ($acao == 'avaliar_participacao') {
            $controllerPart->PA_ID = $_POST['PA_ID'];
            $controllerPart->searchID();
            $controllerPart->PA_AVALIACAO = $_POST['PA_AVALIACAO'];
            $controllerPart->PA_COMENTARIO = $_POST['PA_COMENTARIO'];

            $controllerPart->update();
            header('Location: /usuario/user/schedule');
            exit();
        }

        if ($acao == 'cancelar_participacao') {
            $controllerPart->PA_ID = $_POST['PA_ID'];

            // Busca o AU_ID antes de deletar
            $controllerPart->searchID();
            $aulaId = $controllerPart->AU_ID;

            $controllerPart->delete();

            // Atualiza as vagas disponíveis após cancelamento
            $controllerPart->atualizarVagasDisponiveis($aulaId);
            header('Location: /usuario/user/schedule');
            exit();
        }
    }
}
?>

<body>

    <div class="d-flex" style="height: 100vh; overflow-y: auto;">
        <!-- Sidebar -->
        <div class="sidebar d-flex flex-column flex-shrink-0 p-3 bg-light">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                <img src="../../public/images/logo-fixed.webp" class="img-fluid mb-2" alt="TechFit Logo" style="max-width: 150px;">
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="/usuario" class="nav-link link-dark">
                        Home
                    </a>
                </li>
                <li>
                    <a href="/usuario/profile" class="nav-link link-dark">
                        Meu Perfil
                    </a>
                </li>
                <li>
                    <a href="/usuario/user/training" class="nav-link link-dark">
                        Meus Treinos
                    </a>
                </li>
                <li>
                    <a href="/usuario/user/schedule" class="nav-link active" style="background-color: #e35c38;" aria-current="page">
                        Meus agendamentos
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link link-dark">
                        Sair
                    </a>
                </li>
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="../../public/images/pfp_placeholder.webp" alt="" width="32" height="32" class="rounded-circle me-2">
                    <p id="user-name"><strong><?php echo $controller->US_NOME; ?></strong></p>
                </a>
            </div>
        </div>

        <main class="flex-grow-1 p-3">
            <h2 class="mb-4">Aulas Disponiveis</h2>
            <div class="d-flex" style="gap:30px;">
                <?php $controller->buscarAgendamentos(); ?>
            </div>
            <h2 class="mt-4 mb-4">Aulas Participando</h2>
            <div>
                <?php $controller->buscarParticipacoes(); ?>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

</body>

</html>
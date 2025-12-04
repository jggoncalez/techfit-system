<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once '../../core/Session.php';
require_once '../../config/Database.php';

use config\Database;
use core\Session;

// Conecta ao banco
$db = Database::getInstance()->getConnection();

// Cria a sessão (já inicia automaticamente)
$session = new Session($db);

// Verifica se está logado
if (!$session->isLoggedIn()) {
    header('Location: login.php');
    exit;
}

// Pega os dados
$userID = $session->getUserID();
$userType = $session->getUserType();
$userName = $session->getUserName();
?>

<!doctype html>
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

<body onload="getUser(<?php echo $userID;?> )">
    
    <div class="d-flex" style="height: 100vh; overflow-y: auto;">
        <!-- Sidebar -->
        <div class="sidebar d-flex flex-column flex-shrink-0 p-3 bg-light">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                <img src="../../public/images/logo-fixed.webp" class="img-fluid mb-2" alt="TechFit Logo" style="max-width: 150px;">
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="/usuario" class="nav-link active" style="background-color: #e35c38;" aria-current="page">
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
                    <a href="/usuario/user/schedule" class="nav-link link-dark">
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
                    <p id="user-name"><strong><?php echo $userName ?></strong></p>
                </a>
            </div>
        </div>

        <main class="flex-grow-1">
            <div class="container mt-5">
                <h1 class="display-4">Seja bem-vindo <span id="user-name" class="text-primary"><?php echo $userName ?></span>!</h1>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

        <script src="../get-user.js"></script>
    </body>
</html>
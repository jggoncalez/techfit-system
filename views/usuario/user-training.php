<?php 
require_once __DIR__ . "\\..\\..\\controllers\\UsuarioController.php";
use controllers\UsuarioController;

// Inicie a sessão antes de qualquer HTML
session_start();
$controller = new UsuarioController();

// Verifica se existe sessão antes de tentar usar
if(isset($_SESSION['user_ID'])) {
    $user = $_SESSION['user_ID'];
    $controller->US_ID = $user;
    $controller->searchID();
} else {
    // Redirecionar para login se não houver sessão (opcional, mas recomendado)
    // header("Location: /login");
    // exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>TechFit - Meus Treinos</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="shortcut icon" href="../public/images/TechFit-icon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../Assets/style/style.css">
</head>

<body>
    <div class="d-flex" style="height: 100vh; overflow-y: auto;">
        <div class="sidebar d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 280px;">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                <img src="../../public/images/logo-fixed.webp" class="img-fluid mb-2" alt="TechFit Logo" style="max-width: 150px;">
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="/usuario" class="nav-link link-dark">
                        <i class="bi bi-house-door me-2"></i>Home
                    </a>
                </li>
                <li>
                    <a href="/usuario/user/training" class="nav-link active text-white" style="background-color: #e35c38;" aria-current="page">
                        <i class="bi bi-book me-2"></i>Meus Treinos
                    </a>
                </li>
                <li>
                    <a href="/usuario/user/schedule" class="nav-link link-dark">
                        <i class="bi bi-calendar-event me-2"></i>Meus agendamentos
                    </a>
                </li>
            </ul>
            <hr>
            
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" 
                   id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="../../public/images/pfp_placeholder.webp" alt="" width="32" height="32" class="rounded-circle me-2">
                    <strong><?php echo htmlspecialchars($controller->US_NOME ?? 'Usuário'); ?></strong>
                </a>
                <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                    <li><a class="dropdown-item" href="/usuario/profile"><i class="bi bi-person me-2"></i>Perfil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="/core/Session.php?action=logout"><i class="bi bi-box-arrow-right me-2"></i>Sair</a></li>
                </ul>
            </div>
        </div>

        <main class="flex-grow-1 p-3">
            <h2 class="mb-4">Meus Treinos</h2>
            <div class="d-flex flex-wrap" style="gap:30px;">
                <?php $controller->buscarTreinos(); ?>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>
</html>
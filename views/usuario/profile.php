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

<?php 
require_once __DIR__ . "\\..\\..\\models\\Usuario.php";
require_once __DIR__ . "\\..\\..\\config\\Database.php";
use models\Usuario;
use config\Database;

try {
     $db = Database::getInstance()->getConnection();
} catch (Exception $e) {
    echo $e;
}

session_start();
$controller = new Usuario($db);
$user = $_SESSION['user_ID'];
$controller->US_ID = $user;
$controller->searchID();

?>
<body>
    
    <div class="d-flex" style="height: 100vh; overflow-y: auto; width:100%;">
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
                    <a href="/usuario/profile"  class="nav-link active" style="background-color: #e35c38;" aria-current="page">
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
                    <p id="user-name"><strong><?php echo $controller->US_NOME?></strong></p>
                </a>
            </div>
        </div>

        <main class="d-flex align-items-center justify-content-center" style="width:100%;" >
            <div class ="profile-container">
            <div class="profile d-flex">
                    <h2>Informações Pessoais</h2>
                    <p>Nome: <?php echo $controller->US_NOME ?></p>
                    <p>Gênero: <?php $genero = $controller->US_GENERO ; 
                    if ($genero === 'M'){
                        echo "Masculino";
                    } else if ($genero === 'F') {
                        echo "Feminino";
                    } else if ($genero === 'O'){
                        echo "Outro";
                    } else {
                        echo "Erro";
                    }
                    ?></p>
                    <p>Idade: <?php  echo $controller->US_IDADE?></p>
                    <p>Endereco: <?php echo $controller->US_ENDERECO ?></p>
                    <p>Data de Nascimento: <?php echo $controller->US_DATA_NASCIMENTO?></p>
                    <p>Plano: <?php $plano =  $controller->PL_ID ;
                    switch ($plano) {
                        case 1:
                            echo "Starter";
                            break;
                        case 2:
                            echo "Basic";
                            break;
                        case 3: 
                            echo "Advanced";
                            break;
                        default:
                            echo "Erro";
                            break;
                    }
                    ?></p>
            </div>
            <div class="profile d-flex">
                    <h2>Informações Sobre seu Corpo</h2>
                    <p>%Massa Magra: <?php echo $controller->US_PORC_MASSA_MAGRA ?></p>
                    <p>Altura: <?php echo $controller->US_ALTURA?></p>
                    <p>Objetivo: <?php echo $controller->US_OBJETIVO?></p>
                    <p>Peso: <?php echo $controller->US_PESO?></p>
                    <p>Já treinou antes ?: <?php $treino = $controller->US_TREINO_ANTERIOR;
                    switch ($treino){
                        case 1:
                            echo "Sim, {$controller->US_TEMPO_TREINOANT} meses " ;
                            break;
                        case 2: 
                            echo "Não";
                            break;
                        default: 
                            echo "Erro";
                            break;
                    }
                    ?></p>
            </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
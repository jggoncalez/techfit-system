<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>TechFit - Perfil do Usuário</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="shortcut icon" href="../../public/images/TechFit-icon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="../../../Assets/style/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>

<?php

require_once __DIR__ . "\\..\\..\\controllers\\UsuarioController.php";
use controllers\UsuarioController;

session_start();

// Verifica se está logado antes de continuar
if (!isset($_SESSION['user_ID'])) {
    header("Location: /public/login.php");
    exit();
}

$controller = new UsuarioController();
$controller->US_ID = $_SESSION['user_ID'];

// Busca os dados do usuário
$controller->searchID();

// Variável para o formulário de troca de senha (necessária na seção PHP)
$user_id_form = $controller->US_ID; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';

    if ($acao === 'trocarsenha') {
        $senhaNova = $_POST['US_SENHA_NOVA'];
        $senhaConfirm = $_POST['US_SENHA_CONFIRM'];
        $senhaAntiga = $_POST['US_SENHA_ANTIGA'];
        
        // Verifica se a senha nova bate com a confirmação
        if ($senhaNova === $senhaConfirm) {
            
            // Verifica se a senha antiga digitada bate com a do banco
            if ($senhaAntiga === $controller->US_SENHA) {
                
                // Define a nova senha no controller e manda salvar
                $controller->trocarSenha($senhaNova);
                
                header("Location: /public/login.php");
                exit();
            } else {
                echo "<script>alert('A senha antiga está incorreta.');</script>";
            }
        } else {
            echo "<script>alert('A nova senha e a confirmação não conferem.');</script>";
        }
    }
}

?>

<body>

    <div class="d-flex" >
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
                    <a href="/usuario/user/training" class="nav-link link-dark">
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
                    <strong><?php echo $controller->US_NOME ?></strong>
                </a>
                <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                    <li><a class="dropdown-item active text-white" style="background-color: #e35c38;" href="/usuario/profile"><i class="bi bi-person me-2"></i>Perfil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="/core/Session.php?action=logout"><i class="bi bi-box-arrow-right me-2"></i>Sair</a></li>
                </ul>
            </div>
        </div>

        <main class=" main-content flex-grow-1 d-flex align-items-center justify-content-center" >
            <div class="profile-container">
                <h1 class="display-6 mb-4">
                    <i class="bi bi-person-circle me-2" style="color:#e35c38;"></i>
                    Meu Perfil
                </h1>

                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="bi bi-person-vcard me-2"></i>Informações Pessoais</h5>
                            </div>
                            <div class="card-body">
                                <p><span class="info-label">Nome:</span> <?php echo $controller->US_NOME ?></p>
                                <p><span class="info-label">Data de Nascimento:</span> <?php echo date('d/m/Y', strtotime($controller->US_DATA_NASCIMENTO )) ?></p>
                                <p><span class="info-label">Gênero:</span> 
                                    <?php 
                                    $genero = $controller->US_GENERO;
                                    switch ($genero) {
                                        case 'M': echo "Masculino"; break;
                                        case 'F': echo "Feminino"; break;
                                        case 'O': echo "Outro"; break;
                                        default: echo "Não Definido"; break;
                                    }
                                    ?>
                                </p>
                                <p><span class="info-label">Endereço:</span> <?php echo $controller->US_ENDERECO ?></p>
                                <p><span class="info-label">Plano:</span> 
                                    <?php 
                                    $plano = $controller->PL_ID;
                                    switch ($plano) {
                                        case 1: echo "Starter"; break;
                                        case 2: echo "Basic"; break;
                                        case 3: echo "Advanced"; break;
                                        default: echo "Erro / Não Definido"; break;
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0"><i class="bi bi-heart-pulse me-2"></i>Dados Fitness</h5>
                            </div>
                            <div class="card-body">
                                <p><span class="info-label">Objetivo:</span> <?php echo $controller->US_OBJETIVO ?></p>
                                <p><span class="info-label">Altura (m):</span> <?php echo $controller->US_ALTURA ?></p>
                                <p><span class="info-label">Peso (kg):</span> <?php echo $controller->US_PESO ?></p>
                                <p><span class="info-label">Já treinou antes?:</span> 
                                    <?php 
                                    $treino = $controller->US_TREINO_ANTERIOR;
                                    if ($treino == 1) {
                                        echo "Sim ({$controller->US_TEMPO_TREINOANT} meses)";
                                    } else {
                                        echo "Não";
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <button class='btn text-white mt-3' data-bs-toggle='modal' data-bs-target='#senhaModal' style='background-color:#e35c38;'>
                    <i class="bi bi-lock me-2"></i>Trocar Senha
                </button>
                
                <div class='modal fade' id='senhaModal' tabindex='-1' aria-labelledby='senhaModalLabel' aria-hidden='true'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='senhaModalLabel'><i class="bi bi-key me-2"></i>Trocar Senha</h5>
                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Fechar'></button>
                            </div>

                            <div class='modal-body'>
                                <form method="post">
                                    <input type="hidden" name="acao" value="trocarsenha">
                                    <input type="hidden" name="US_ID" value="<?php echo $user_id_form ?>">
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Senha Antiga*</label>
                                        <input type="password" class="form-control" name="US_SENHA_ANTIGA" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Senha Nova*</label>
                                        <input type="password" class="form-control" name="US_SENHA_NOVA" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Confirmação*</label>
                                        <input type="password" class="form-control" name="US_SENHA_CONFIRM" required>
                                    </div>
                                    
                                    <button type="submit" class="text-white btn" style="background-color:#e35c38;">Alterar Senha</button>
                                </form>
                            </div>

                            <div class='modal-footer'>
                                <button class='btn btn-secondary' data-bs-dismiss='modal'>Fechar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
                                        
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
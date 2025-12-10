<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../core/Session.php';
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../controllers/FuncionarioController.php';
require_once __DIR__ . '/../controllers/UsuarioController.php';

use controllers\UsuarioController;
use controllers\FuncionarioController;
use core\Session;
use config\Database;

$db = Database::getInstance()->getConnection();
$auth = new Session($db);

$ControllerFunc = new FuncionarioController();
$ControllerUS = new UsuarioController();

$erro = '';
$sucesso_msg = '';

// Processa o formulário de LOGIN
if(isset($_POST['login'])){
    $auth->user_name = $_POST['username'];
    $auth->user_pass = $_POST['password'];
    $login_sucesso = false;

    // 1. Tenta o login como Usuário (Cliente)
    if($auth->userLogin()){
        $login_sucesso = true;
        header("Location: /usuario?username={$_POST['username']}");
        exit;
    }
    
    // 2. Se não for um Usuário, tenta o login como Funcionário
    if(!$login_sucesso && $auth->funcLogin()){
        $login_sucesso = true;
        header("Location: /funcionario?username={$_POST['username']}");
        exit;
    }

    // 3. Se nenhuma das tentativas funcionou
    if(!$login_sucesso){
        $erro = "Usuário ou senha incorretos!";
    }
}

// Processa o formulário de TROCA DE SENHA
if (isset($_POST['acao']) && $_POST['acao'] === 'trocarsenha') {
    if (isset($_POST['user']) && isset($_POST['US_SENHA_NOVA']) && isset($_POST['US_SENHA_CONFIRM'])){
        
        // Verifica se as senhas coincidem
        if ($_POST['US_SENHA_NOVA'] !== $_POST['US_SENHA_CONFIRM']) {
            $erro = "As senhas não coincidem!";
        } else {
            $troca_sucesso = false;
            
            // Tenta trocar senha do Usuário
            $ControllerUS->US_NOME = $_POST['user'];
            if ($ControllerUS->searchNAME()){
                $ControllerUS->trocarSenha($_POST['US_SENHA_NOVA']);
                $troca_sucesso = true;
            }
            
            // Se não encontrou usuário, tenta trocar senha do Funcionário
            if (!$troca_sucesso) {
                $ControllerFunc->FU_EMAIL = $_POST['user'];
                if ($ControllerFunc->searchEMAIL()) {
                    $ControllerFunc->trocarSenha($_POST['US_SENHA_NOVA']);
                    $troca_sucesso = true;
                }
            }
            
            // Define mensagem apropriada
            if ($troca_sucesso) {
                $sucesso_msg = "Senha alterada com sucesso! Faça login com sua nova senha.";
            } else {
                $erro = "Usuário ou email não encontrado!";
            }
        }
    }
}
?>

<!doctype html>
<html lang="pt-br">

<head>
    <title>TechFit</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="shortcut icon" href="../Assets/images/TechFit-icon.ico" type="image/x-icon">
    <link rel="stylesheet" href="Assets/style/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css"/>
</head>

<body>

<?php
include_once 'include/header.php';
?>

<main class="form-signin w-100 m-auto d-flex align-items-center justify-content-center p-5">
    <form method="POST" style="height:auto; width:500px;"> 
        <h1 class="h3 mb-3 fw-normal text-center">LOGIN</h1>
        <h1 class="h6 mb-3 fw-normal text-center">Se possuir uma conta, insira seus dados</h1>
        
        <?php if($erro): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($erro); ?>
            </div>
        <?php endif; ?>
        
        <?php if($sucesso_msg): ?>
            <div class="alert alert-success" role="alert">
                <?php echo htmlspecialchars($sucesso_msg); ?>
            </div>
        <?php endif; ?>
        
        <div class="form-floating">
            <input type="text" name="username" class="form-control" 
                   style="border-bottom: #E35C38; border-width: 2px; border-style: solid;"
                   id="floatingInput" placeholder="name@example.com" required>
            <label for="floatingInput">Nome de Usuário ou Email</label>
        </div>
        
        <div class="form-floating">
            <input type="password" name="password" class="form-control" 
                   style="border-bottom: #E35C38; border-width: 2px; border-style: solid;"
                   id="floatingPassword" placeholder="Senha" required>
            <label for="floatingPassword">Senha</label>
        </div>
        
        <button class="btn text-white w-100 py-2 mt-5" name="login" type="submit" style="background-color: #E35C38;" >Acessar</button>
        
        <h1 class="h6 m-3 fw-normal text-center">
            É seu primeiro acesso como cliente ou não lembra a senha?
            <button type="button" class='btn btn-sm text-white mt-3' 
                    data-bs-toggle='modal' data-bs-target='#senhaModal' 
                    style='background-color:#e35c38;'>
                <i class="bi bi-lock me-2"></i>Trocar Senha
            </button>
            para cadastrar uma nova.
        </h1>
    </form>
</main>

<!-- Modal de Troca de Senha -->
<div class='modal fade' id='senhaModal' tabindex='-1' aria-labelledby='senhaModalLabel' aria-hidden='true'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h5 class='modal-title' id='senhaModalLabel'>
                    <i class="bi bi-key me-2"></i>Trocar Senha
                </h5>
                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Fechar'></button>
            </div>

            <div class='modal-body'>
                <form method="post">
                    <input type="hidden" name="acao" value="trocarsenha">
                    
                    <div class="mb-3">
                        <label class="form-label">Nome de Usuário ou Email*</label>
                        <input type="text" class="form-control" name="user" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Senha Nova*</label>
                        <input type="password" class="form-control" name="US_SENHA_NOVA" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Confirmação*</label>
                        <input type="password" class="form-control" name="US_SENHA_CONFIRM" required>
                    </div>
                    
                    <button type="submit" class="text-white btn" style="background-color:#e35c38;">
                        Alterar Senha
                    </button>
                </form>
            </div>

            <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Fechar</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<?php
require_once 'include/footer.php';
?>

</body>
</html>
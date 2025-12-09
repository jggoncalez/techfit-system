<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../core/Session.php';
require_once __DIR__ . '/../config/Database.php';

use core\Session;
use config\Database;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$db = Database::getInstance()->getConnection();
$auth = new Session($db);



if(isset($_POST['login'])){
    $auth->user_name = $_POST['username'];
    $auth->user_pass = $_POST['password'];
    $sucesso = false;

    // 1. Tenta o login como Usuário (Cliente)
    if($auth->userLogin()){
        $sucesso = true;
        // Redireciona para a área do Usuário
        header("Location: /usuario?username={$_POST['username']}");
        exit;
    }
    
    // 2. Se não for um Usuário, tenta o login como Funcionário
    if(!$sucesso && $auth->funcLogin()){
        $sucesso = true;
        // Redireciona para a área do Funcionário (Ajuste o caminho conforme necessário)
        // Por exemplo, para um painel de funcionário.
        header("Location: /funcionario?username={$_POST['username']}");
        exit;
    }

    // 3. Se nenhuma das tentativas funcionou
    if(!$sucesso){
        $erro = "Usuário ou senha incorretos!";
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
    <script src="../docs/5.3/assets/js/color-modes.js"></script>
    <link rel="stylesheet" href="../Assets/style/style.css">
</head>

<?php
include_once 'include/header.php';
?>

<main class="form-signin w-100 m-auto d-flex align-items-center justify-content-center p-5 ">
    <form  method=POST style="height:auto; width:500px;"> 
        <h1 class="h3 mb-3 fw-normal text-center" data-vivaldi-translated="" action="">LOGIN</h1>
        <h1 class="h6 mb-3 fw-normal text-center" data-vivaldi-translated="">Se possuir uma conta, insira seus dados</h1>
        <div class="form-floating" data-vivaldi-translated=""> <input type="text" name="username" class="form-control" style="border-bottom: #E35C38; border-width: 2px; border-style: solid;"
                id="floatingInput" placeholder="name@example.com" data-vivaldi-translated=""> <label for="floatingInput"
                data-vivaldi-translated="">Nome de Usuário ou Email</label> </div>
        <div class="form-floating" data-vivaldi-translated=""> <input type="password" name="password" class="form-control" style="border-bottom: #E35C38; border-width: 2px; border-style: solid;"
                id="floatingPassword" placeholder="Senha" data-vivaldi-translated=""> <label for="floatingPassword"
                data-vivaldi-translated="">Senha</label> </div>
        <button class="btn btn-primary w-100 py-2 mt-5" name="login" type="submit" data-vivaldi-translated="">Acessar</button>
        <h1 class="h6 m-3 fw-normal text-center" data-vivaldi-translated="">É seu primeiro acesso como cliente ou não lembra a senha? <a href="views/funcionario/main.php">Clique Aqui </a> para cadastrar uma nova.</h1>
    </form>
</main>

<?php
require_once 'include/footer.php';
?>

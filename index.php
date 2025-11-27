<?php
$request = $_SERVER['REQUEST_URI'];
$request = parse_url($request, PHP_URL_PATH);
$username = $_GET['username'];

switch($request) {
    case '/':
        require __DIR__ . '/public/home.php';
        break;
    case '/academias':
        require __DIR__ . '/public/academiasprox.php';
        break;
    case '/login':
        require __DIR__ . '/public/login.php';
        break;
    case '/funcionario':
        require __DIR__ . '/views/funcionario/main.php';
        break;
    case '/funcionario/treinos':
        require __DIR__ . '/views/funcionario/get-training.php';
        break;
    case '/funcionario/register/classes':
        require __DIR__ . '/views/funcionario/register-classes.php';
        break;
    case '/funcionario/register/exercicios':
        require __DIR__ . '/views/funcionario/register-exercises.php';
        break;
    case '/funcionario/register/estudantes':
        require __DIR__ . '/views/funcionario/register-gym-students.php';
        break;
    case '/funcionario/register/treino':
        require __DIR__ . '/views/funcionario/set-training.php';
        break;
    case '/usuario':
        require __DIR__  . '/views/usuario/main.php';
        break;
    case '/usuario/profile':
        require __DIR__  . '/views/usuario/profile.php';
        break;
    case '/usuario/user/schedule':
        require __DIR__  . '/views/usuario/user-schedule.php';
        break;
    case '/usuario/user/training':
        require __DIR__  . '/views/usuario/user-training.php';
        break;
    default:
        http_response_code(404);
        echo "Página não encontrada!";
}
?>
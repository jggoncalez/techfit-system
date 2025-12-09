<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>TechFit - Perfil do Funcionário</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="shortcut icon" href="../../public/images/TechFit-icon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="../../../Assets/style/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>

<?php

require_once __DIR__ . "\\..\\..\\controllers\\FuncionarioController.php";
use controllers\FuncionarioController;

session_start();

// Verifica se está logado
if (!isset($_SESSION['user_ID'])) {
    header("Location: /public/login.php");
    exit();
}

$controller = new FuncionarioController();
$controller->FU_ID = $_SESSION['user_ID'];

// Busca os dados do funcionário
$controller->searchID();

// Variavel para o formulário de troca de senha (necessária na seção PHP)
$user_id_form = $controller->FU_ID;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';

    if ($acao === 'trocarsenha') {
        $senhaNova = $_POST['FU_SENHA_NOVA'];
        $senhaConfirm = $_POST['FU_SENHA_CONFIRM'];
        $senhaAntiga = $_POST['FU_SENHA_ANTIGA'];
        
        if ($senhaNova === $senhaConfirm) {
            if ($senhaAntiga === $controller->FU_SENHA) {
                
                // Assumindo que o método trocarSenha() existe no FuncionarioController
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

    <div class="d-flex">
        
        <div class="sidebar d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 280px;">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                <img src="../../public/images/logo-fixed.webp" class="img-fluid mb-2" alt="TechFit Logo" style="max-width: 150px;">
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="/funcionario" class="nav-link link-dark">
                        <i class="bi bi-speedometer2 me-2"></i>Menu
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/funcionario/register/exercicios" class="nav-link link-dark">
                        <i class="bi bi-plus-circle me-2"></i>Exercícios
                    </a>
                </li>
                <li>
                    <a href="/funcionario/register/estudantes" class="nav-link link-dark">
                        <i class="bi bi-person-plus me-2"></i>Alunos
                    </a>
                </li>
                <li>
                    <a href="/funcionario/register/classes" class="nav-link link-dark">
                        <i class="bi bi-calendar-plus me-2"></i>Aulas
                    </a>
                </li>
                <li>
                    <a href="/funcionario/register/treino" class="nav-link link-dark">
                        <i class="bi bi-clipboard-plus me-2"></i>Treinos
                    </a>
                </li>
                <li>
                    <a href="/funcionario/register/admin" class="nav-link link-dark">
                        <i class="bi bi-people-fill me-2"></i>Funcionários
                    </a>
                </li>
                <li>
                    <a href="/funcionario/RFID" class="nav-link link-dark">
                        <i class="bi bi-box-arrow-in-up-left"></i> Acessos
                    </a>
                </li>
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" 
                    id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="../../public/images/pfp_placeholder.webp" alt="" width="32" height="32" class="rounded-circle me-2">
                    <p id="user-name"><strong><?php echo $controller->FU_NOME ?></strong></p>
                </a>
                <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                    <li><a class="dropdown-item active" style="background-color: #e35c38; color: white;" href="/funcionario/profile"><i class="bi bi-person me-2"></i>Perfil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="/core/Session.php?action=logout"><i class="bi bi-box-arrow-right me-2"></i>Sair</a></li>
                </ul>
            </div>
        </div>

        <main class="main-content flex-grow-1 d-flex align-items-center justify-content-center">
            <div class="profile-container">
                <h1 class="display-6 mb-4"><i class="bi bi-person me-2"></i>Meu Perfil</h1>

                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Informações Pessoais</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Nome:</strong> <?php echo $controller->FU_NOME ?></p>
                        <p><strong>Email:</strong> <?php echo $controller->FU_EMAIL ?></p>
                        <p><strong>Gênero:</strong> <?php 
                            $genero = $controller->FU_GENERO;
                            switch ($genero) {
                                case 'M': echo "Masculino"; break;
                                case 'F': echo "Feminino"; break;
                                case 'O': echo "Outro"; break;
                                default: echo "Não Definido"; break;
                            }
                            ?></p>
                    </div>
                </div>

                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Informações Profissionais</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Nível de Acesso:</strong> <?php echo $controller->FU_NIVEL_ACESSO ?></p>
                        <p><strong>Salário:</strong> R$ <?php echo number_format($controller->FU_SALARIO, 2, ',', '.') ?></p>
                        <p><strong>Data de Admissão:</strong> <?php echo $controller->FU_DATA_ADMISSAO ?></p>
                    </div>
                </div>
                
                <button class='btn text-white' data-bs-toggle='modal' data-bs-target='#senhaModal' style='background-color:#e35c38;'>
                    <i class="bi bi-lock me-2"></i>Trocar Senha
                </button>
                
                <div class='modal fade' id='senhaModal' tabindex='-1' aria-labelledby='senhaModalLabel' aria-hidden='true'>
                    <div class='modal-dialog modal-lg'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='senhaModalLabel'>Trocar Senha</h5>
                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Fechar'></button>
                            </div>

                            <div class='modal-body'>
                                <form method="post">
                                    <input type="hidden" name="acao" value="trocarsenha">
                                    <input type="hidden" name="FU_ID" value="<?php echo $user_id_form ?>">
                                    <div class="mb-3">
                                        <label class="form-label">Senha Antiga*</label>
                                        <input type="password" class="form-control" name="FU_SENHA_ANTIGA" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Senha Nova*</label>
                                        <input type="password" class="form-control" name="FU_SENHA_NOVA" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Confirmação*</label>
                                        <input type="password" class="form-control" name="FU_SENHA_CONFIRM" required>
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
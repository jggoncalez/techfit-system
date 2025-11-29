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
                    <img src="https://placehold.co/20x20" alt="" width="32" height="32" class="rounded-circle me-2">
                    <p id="user-name"><strong>User</strong></p>
                </a>
            </div>
        </div>

        <main class="flex-grow-1">
            <div class = "profile-container">
            <div class="profile d-flex">
                    <h2>Informações Pessoais</h2>
                    <p>Nome:</p>
                    <p>Gênero:</p>
                    <p>Idade:</p>
                    <p>Endereco:</p>
                    <p>Data de Nascimento:</p>
                    <p>Plano:</p>
            </div>
            <div class="profile d-flex">
                    <h2>Informações Sobre seu Corpo</h2>
                    <p>%Gordura:</p>
                    <p>Altura:</p>
                    <p>Objetivo:</p>
                    <p>Peso:</p>
                    <p>Já treinou antes ?:</p>
            </div>
</div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
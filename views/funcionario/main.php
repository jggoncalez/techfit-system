<!doctype html>
<html lang="pt-br">
<head>
    <title>TechFit - Dashboard Analytics</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="shortcut icon" href="../public/images/TechFit-icon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../Assets/style/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Estilos customizados */
        .stat-card {
            transition: transform 0.3s, box-shadow 0.3s;
            border-left: 4px solid #e35c38;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #e35c38;
        }
        
        .chart-container {
            position: relative;
            height: 300px;
            margin-bottom: 20px;
        }
        
        .table-container {
            max-height: 400px;
            overflow-y: auto;
        }
        
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
        }
        
        .status-permitido {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-negado {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .sidebar {
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }
        
        .main-content {
            margin-left: 280px;
            padding: 20px;
        }
        
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(227, 92, 56, 0.3);
            border-radius: 50%;
            border-top-color: #e35c38;
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        .refresh-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: #e35c38;
            color: white;
            border: none;
            box-shadow: 0 4px 12px rgba(227, 92, 56, 0.4);
            font-size: 1.5rem;
            cursor: pointer;
            transition: transform 0.3s;
            z-index: 1000;
        }
        
        .refresh-btn:hover {
            transform: scale(1.1);
        }
        
        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100% !important;
                height: auto;
            }
            
            .main-content {
                margin-left: 0;
            }
        }
    </style>

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

    ?>
</head>
<body>
    <div class="d-flex">
        <!-- Barra lateral -->
        <div class="sidebar d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 280px;">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                <img src="../../public/images/logo-fixed.webp" class="img-fluid mb-2" alt="TechFit Logo" style="max-width: 150px;">
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="/funcionario" class="nav-link active text-white" style="background-color: #e35c38;" aria-current="page">
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
                        <i class="bi bi-box-arrow-in-up-left"></i>
                          Acessos
                    </a>
                </li>
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" 
                   id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="../../public/images/pfp_placeholder.webp" alt="" width="32" height="32" class="rounded-circle me-2">
                    <strong id="user-name-sidebar"><?php echo $controller->FU_NOME ?></strong>
                </a>
                <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                    <li><a class="dropdown-item" href="/funcionario/profile"><i class="bi bi-person me-2"></i>Perfil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="/core/Session.php?action=logout"><i class="bi bi-box-arrow-right me-2"></i>Sair</a></li>
                </ul>
            </div>
        </div>

        <!-- Conteúdo Principal -->
        <main class="main-content flex-grow-1">
            <!-- Cabeçalho -->
            <div class="container-fluid">
                <div class="row mb-4">
                    <div class="col-12">
                        <h1 class="display-5">
                            <i class="bi bi-graph-up text-primary me-2"></i>
                            Dashboard Analytics
                        </h1>
                        <p class="lead text-muted">Seja bem-vindo, <span id="user-name-main" class="text-primary fw-bold"><?php echo $controller->FU_NOME ?></span>!</p>
                        <small class="text-muted">Última atualização: <span id="ultima-atualizacao">--:--</span></small>
                    </div>
                </div>

                <!-- Cards de Estatísticas -->
                <div class="row mb-4" id="stats-cards">
                    <div class="col-12 text-center">
                        <div class="loading-spinner"></div>
                        <p class="text-muted mt-2">Carregando estatísticas</p>
                    </div>
                </div>

                <!-- Linha de Gráficos -->
                <div class="row mb-4">
                    <!-- Distribuição de Planos -->
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="bi bi-pie-chart me-2"></i>Distribuição de Planos</h5>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="graficoPlanos"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Treinos por Mês -->
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0"><i class="bi bi-graph-up me-2"></i>Treinos por Mês</h5>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="graficoTreinos"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Grupos Musculares -->
                    <div class="col-lg-12 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header bg-warning text-dark">
                                <h5 class="mb-0"><i class="bi bi-bar-chart me-2"></i>Pontuação por Grupos Musculares</h5>
                            </div>
                            <div class="card-body">
                                <div class="chart-container" style="height: 250px;">
                                    <canvas id="graficoGrupos"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Linha de Tabelas -->
                <div class="row mb-4">
                    <!-- Últimos Acessos -->
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0"><i class="bi bi-door-open me-2"></i>Últimos Acessos</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-container" id="tabela-acessos">
                                    <div class="text-center p-4">
                                        <div class="loading-spinner"></div>
                                        <p class="text-muted mt-2">Carregando...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Exercícios Populares -->
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header bg-danger text-white">
                                <h5 class="mb-0"><i class="bi bi-star me-2"></i>Exercícios Mais Usados</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-container" id="tabela-exercicios">
                                    <div class="text-center p-4">
                                        <div class="loading-spinner"></div>
                                        <p class="text-muted mt-2">Carregando...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Usuários Mais Ativos -->
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header" style="background-color: #e35c38; color: white;">
                                <h5 class="mb-0"><i class="bi bi-trophy me-2"></i>Usuários Mais Ativos</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-container" id="tabela-usuarios">
                                    <div class="text-center p-4">
                                        <div class="loading-spinner"></div>
                                        <p class="text-muted mt-2">Carregando...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Próximas Aulas -->
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header bg-secondary text-white">
                                <h5 class="mb-0"><i class="bi bi-calendar-event me-2"></i>Próximas Aulas</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-container" id="tabela-aulas">
                                    <div class="text-center p-4">
                                        <div class="loading-spinner"></div>
                                        <p class="text-muted mt-2">Carregando...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Botão de Atualização -->
    <button class="refresh-btn" onclick="atualizarDashboard()" title="Atualizar">
        <i class="bi bi-arrow-clockwise"></i>
    </button>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    
    <!-- Script Customizado -->
    <script src="/Assets/js/dashboard.js"></script>
</body>
</html>
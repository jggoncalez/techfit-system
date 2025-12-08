<?php
// Configuração e conexão
$pdo = new PDO("mysql:host=localhost;dbname=TechFitDatabase;charset=utf8", "root", "7900");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Busca dados
$acessos = $pdo->query("
    SELECT re.*, u.US_NOME, r.RFID_TAG_CODE
    FROM REGISTRO_ENTRADAS re
    LEFT JOIN USUARIOS u ON re.US_ID = u.US_ID
    LEFT JOIN RFID_TAGS r ON re.RFID_ID = r.RFID_ID
    ORDER BY re.RE_DATA_HORA DESC
    LIMIT 50
")->fetchAll(PDO::FETCH_ASSOC);

$totalHoje = $pdo->query("SELECT COUNT(*) FROM REGISTRO_ENTRADAS WHERE DATE(RE_DATA_HORA) = CURDATE()")->fetchColumn();
$negadosHoje = $pdo->query("SELECT COUNT(*) FROM REGISTRO_ENTRADAS WHERE DATE(RE_DATA_HORA) = CURDATE() AND RE_STATUS = 'NEGADO'")->fetchColumn();
?>

<!doctype html>
<html lang="pt-br">
<head>
    <title>TechFit - Controle de Acesso</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/Assets/images/TechFit-icon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../Assets/style/style.css">
    <style>
        .badge-permitido { background-color: #28a745; }
        .badge-negado { background-color: #dc3545; }
    </style>
</head>
<body>
    <div class="d-flex" style="height: 100vh;">
        <!-- Barra lateral -->
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
                    <a href="/funcionario/RFID" class="nav-link active text-white" style="background-color: #e35c38;" aria-current="page">
                        <i class="bi bi-box-arrow-in-up-left"></i>
                          Acessos
                    </a>
                </li>
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" 
                   id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://placehold.co/32x32" alt="" width="32" height="32" class="rounded-circle me-2">
                    <strong id="user-name-sidebar">User</strong>
                </a>
                <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                    <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Perfil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-box-arrow-right me-2"></i>Sair</a></li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <main class="p-4 flex-grow-1" style="overflow-y: auto;">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="bi bi-door-open"></i> Acessos da Academia</h2>
                <div>
                    <span class="badge bg-primary">Atualização a cada 5s</span>
                    <button class="btn btn-sm btn-outline-primary" onclick="location.reload()">
                        <i class="bi bi-arrow-clockwise"></i> Atualizar
                    </button>
                </div>
            </div>

            <!-- Estatísticas -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total de Acessos Hoje</h5>
                            <h2 class="text-primary"><?= $totalHoje ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Acessos Negados Hoje</h5>
                            <h2 class="text-danger"><?= $negadosHoje ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabela -->
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Data/Hora</th>
                            <th>Nome</th>
                            <th>RFID</th>
                            <th>Tipo</th>
                            <th>Status</th>
                            <th>Observação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($acessos)): ?>
                            <tr>
                                <td colspan="7" class="text-center">
                                    <i class="bi bi-inbox"></i> Nenhum acesso registrado
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($acessos as $a): ?>
                                <tr>
                                    <th><?= $a['RE_ID'] ?></th>
                                    <td><?= date('d/m/Y H:i:s', strtotime($a['RE_DATA_HORA'])) ?></td>
                                    <td>
                                        <?= $a['US_NOME'] ? "<strong>".htmlspecialchars($a['US_NOME'])."</strong>" : "<span class='text-muted'>Não identificado</span>" ?>
                                    </td>
                                    <td><code><?= $a['RFID_TAG_CODE'] ?? 'N/A' ?></code></td>
                                    <td><span class="badge bg-secondary"><?= $a['RE_TIPO_ENTRADA'] ?></span></td>
                                    <td>
                                        <?php if ($a['RE_STATUS'] === 'PERMITIDO'): ?>
                                            <span class="badge badge-permitido">
                                                <i class="bi bi-check-circle"></i> PERMITIDO
                                            </span>
                                        <?php else: ?>
                                            <span class="badge badge-negado">
                                                <i class="bi bi-x-circle"></i> NEGADO
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?= $a['RE_MOTIVO_NEGACAO'] 
                                            ? "<small class='text-danger'><i class='bi bi-exclamation-triangle'></i> ".htmlspecialchars($a['RE_MOTIVO_NEGACAO'])."</small>"
                                            : "<small class='text-muted'>-</small>" ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-refresh
        setTimeout(() => location.reload(), 5000);
    </script>
</body>
</html>
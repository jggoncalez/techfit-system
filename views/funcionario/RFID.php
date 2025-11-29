<?php
// Configuração do banco de dados
$host = 'localhost';
$dbname = 'seu_banco';
$usuario = 'seu_usuario';
$senha = 'sua_senha';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}

// Busca os últimos 50 acessos
$query = "
    SELECT 
        re.RE_ID,
        re.RE_DATA_HORA,
        re.RE_STATUS,
        re.RE_TIPO_ENTRADA,
        re.RE_MOTIVO_NEGACAO,
        u.US_NOME,
        u.US_EMAIL,
        r.RFID_TAG_CODE
    FROM REGISTRO_ENTRADAS re
    LEFT JOIN USUARIOS u ON re.US_ID = u.US_ID
    LEFT JOIN RFID_TAGS r ON re.RFID_ID = r.RFID_ID
    ORDER BY re.RE_DATA_HORA DESC
    LIMIT 50
";

$stmt = $pdo->query($query);
$acessos = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>




<!doctype html>
<html lang="pt-br">

<head>
    <title>TechFit</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="shortcut icon" href="/Assets/images/TechFit-icon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="../../Assets/style/style.css">
</head>

<body>

    <div class="d-flex" style="height: 100vh; overflow-y: auto;">
        <!-- Sidebar -->
        <div class="sidebar d-flex flex-column flex-shrink-0 p-3 bg-light" style="height: 100vh; width: 280px;">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                <img src="../../public/images/logo-fixed.webp" class="img-fluid mb-2" alt="TechFit Logo" style="max-width: 150px;">
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="/funcionario" class="nav-link link-dark">
                        Home
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/funcionario/register/exercicios" class="nav-link link-dark"">
                        Cadastrar Exercícios
                    </a>
                </li>
                <li>
                    <a href=" /funcionario/register/estudantes" class="nav-link link-dark">
                        Cadastrar Alunos
                    </a>
                </li>
                <li>
                    <a href="/funcionario/register/classes" class="nav-link link-dark">
                        Cadastrar Aulas
                    </a>
                </li>
                <li>
                    <a href="/funcionario/register/treino" class="nav-link link-dark">
                        Montar Treinos
                    </a>
                </li>
                <li>
                    <a href="/funcionario/treinos" class="nav-link link-dark">
                        Ver Treinos Disponíveis
                    </a>
                </li>
                <li>
                    <a href="/funcionario/RFID" class="nav-link active text-white" style="background-color: #e35c38;" aria-current="page">
                        Acesso academia
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
<main class='p-3'>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="bi bi-door-open"></i> Acessos da Academia</h2>
                <div>
                    <span class="badge bg-primary">Atualização automática a cada 5s</span>
                    <button class="btn btn-sm btn-outline-primary" onclick="location.reload()">
                        <i class="bi bi-arrow-clockwise"></i> Atualizar
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Data/Hora</th>
                            <th scope="col">Nome</th>
                            <th scope="col">RFID</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Status</th>
                            <th scope="col">Observação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($acessos)): ?>
                            <tr>
                                <td colspan="7" class="text-center">
                                    <i class="bi bi-inbox"></i> Nenhum acesso registrado ainda
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($acessos as $acesso): ?>
                                <tr>
                                    <th scope="row"><?= $acesso['RE_ID'] ?></th>
                                    <td>
                                        <?= date('d/m/Y H:i:s', strtotime($acesso['RE_DATA_HORA'])) ?>
                                    </td>
                                    <td>
                                        <?php if ($acesso['US_NOME']): ?>
                                            <strong><?= htmlspecialchars($acesso['US_NOME']) ?></strong>
                                            <br><small class="text-muted"><?= htmlspecialchars($acesso['US_EMAIL']) ?></small>
                                        <?php else: ?>
                                            <span class="text-muted">Não identificado</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <code><?= $acesso['RFID_TAG_CODE'] ?? 'N/A' ?></code>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            <?= $acesso['RE_TIPO_ENTRADA'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($acesso['RE_STATUS'] === 'PERMITIDO'): ?>
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
                                        <?php if ($acesso['RE_MOTIVO_NEGACAO']): ?>
                                            <small class="text-danger">
                                                <i class="bi bi-exclamation-triangle"></i>
                                                <?= htmlspecialchars($acesso['RE_MOTIVO_NEGACAO']) ?>
                                            </small>
                                        <?php else: ?>
                                            <small class="text-muted">-</small>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Estatísticas -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total de Acessos Hoje</h5>
                            <h2 class="text-primary">
                                <?php
                                $stmt = $pdo->query("SELECT COUNT(*) FROM REGISTRO_ENTRADAS WHERE DATE(RE_DATA_HORA) = CURDATE()");
                                echo $stmt->fetchColumn();
                                ?>
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Acessos Negados Hoje</h5>
                            <h2 class="text-danger">
                                <?php
                                $stmt = $pdo->query("SELECT COUNT(*) FROM REGISTRO_ENTRADAS WHERE DATE(RE_DATA_HORA) = CURDATE() AND RE_STATUS = 'NEGADO'");
                                echo $stmt->fetchColumn();
                                ?>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Atualiza a página a cada 5 segundos
        setTimeout(function(){
            location.reload();
        }, 5000);
    </script>
</body>

</html>
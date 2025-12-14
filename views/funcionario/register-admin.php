<!doctype html>
<html lang="pt-br">

<head>
    <title>TechFit - Funcionários</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="shortcut icon" href="../public/images/TechFit-icon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../Assets/style/style.css">
</head>

<?php
// Inclui o controller e usa o namespace
require_once __DIR__ . '\\..\\..\\controllers\\FuncionarioController.php';

use controllers\FuncionarioController;

// Inicia a sessão (melhor estar no topo do script PHP)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verifica se está logado e redireciona se necessário
if (!isset($_SESSION['user_ID'])) {
    header("Location: /public/login.php");
    exit();
}

$controller = new FuncionarioController();
$controller->FU_ID = $_SESSION['user_ID'];

// Busca os dados do funcionário logado
$controller->searchID(); 

// Variável para armazenar a lista de funcionários
$stmt = $controller->list();

// =========================================================================
// TRATAMENTO DOS POSTS
// =========================================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Uso do operador de coalescência nula (??) para evitar "undefined index"
    $acao = filter_input(INPUT_POST, 'acao', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '';

    if ($acao === 'criar') {
        // Sanitização de entradas com htmlspecialchars e trim
        $controller->FU_NOME = htmlspecialchars(trim(filter_input(INPUT_POST, 'FU_NOME', FILTER_SANITIZE_FULL_SPECIAL_CHARS)));
        $controller->FU_GENERO = htmlspecialchars(trim(filter_input(INPUT_POST, 'FU_GENERO', FILTER_SANITIZE_FULL_SPECIAL_CHARS)));
        $controller->FU_SENHA = $_POST['FU_SENHA'] ?? ''; // Senha não sanitizada aqui, deve ser tratada no Controller antes do hash
        $controller->FU_NIVEL_ACESSO = filter_input(INPUT_POST, 'FU_NIVEL_ACESSO', FILTER_SANITIZE_NUMBER_INT);
        $controller->FU_SALARIO = filter_input(INPUT_POST, 'FU_SALARIO', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $controller->FU_DATA_ADMISSAO = filter_input(INPUT_POST, 'FU_DATA_ADMISSAO', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        $controller->create();
        // Redireciona para evitar reenvio do formulário (Post/Redirect/Get)
        header("Location: /funcionario/register/admin");
        exit;
    }

    if ($acao === 'atualizar') {
        // Captura e sanitiza todas as entradas
        $controller->FU_ID = filter_input(INPUT_POST, 'FU_ID', FILTER_SANITIZE_NUMBER_INT);
        $controller->FU_NOME = htmlspecialchars(trim(filter_input(INPUT_POST, 'FU_NOME', FILTER_SANITIZE_FULL_SPECIAL_CHARS)));
        $controller->FU_GENERO = htmlspecialchars(trim(filter_input(INPUT_POST, 'FU_GENERO', FILTER_SANITIZE_FULL_SPECIAL_CHARS)));
        $controller->FU_NIVEL_ACESSO = filter_input(INPUT_POST, 'FU_NIVEL_ACESSO', FILTER_SANITIZE_NUMBER_INT);
        $controller->FU_SALARIO = filter_input(INPUT_POST, 'FU_SALARIO', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $controller->FU_DATA_ADMISSAO = filter_input(INPUT_POST, 'FU_DATA_ADMISSAO', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        // Uso de filter_input com FILTER_SANITIZE_EMAIL
        $controller->FU_EMAIL = filter_input(INPUT_POST, 'FU_EMAIL', FILTER_SANITIZE_EMAIL);
        
        $nova_senha = $_POST['FU_SENHA'] ?? '';
        // Só atualiza a senha se foi fornecida uma nova
        if (!empty($nova_senha)) {
            $controller->FU_SENHA = $nova_senha;
        } else {
            // Garante que a senha não será alterada se não for fornecida
            unset($controller->FU_SENHA);
        }
        
        $controller->update();
        header("Location: /funcionario/register/admin");
        exit;
    }

    if ($acao === 'deletar') {
        $controller->FU_ID = filter_input(INPUT_POST, 'FU_ID', FILTER_SANITIZE_NUMBER_INT);
        $controller->delete();
        header("Location: /funcionario/register/admin");
        exit;
    }
}
?>

<body>

    <div class="d-flex">
        <div class="sidebar d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 280px;">
            <a href="/funcionario" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
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
                    <a href="/funcionario/register/admin" class="nav-link active text-white" style="background-color: #e35c38;" aria-current="page">
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
                    <img src="../../public/images/pfp_placeholder.webp" alt="Foto de Perfil" width="32" height="32" class="rounded-circle me-2">
                    <strong id="user-name-sidebar"><?php echo htmlspecialchars($controller->FU_NOME ?? 'Usuário'); ?></strong>
                </a>
                <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                    <li><a class="dropdown-item" href="/funcionario/profile"><i class="bi bi-person me-2"></i>Perfil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="/core/Session.php?action=logout"><i class="bi bi-box-arrow-right me-2"></i>Sair</a></li>
                </ul>
            </div>
        </div>

        <main class="flex-grow-1 p-4" style="overflow-y: auto;">
            <h2 class="mb-4">Cadastrar Novo Funcionário</h2>
            <form method="POST" class="row g-3 needs-validation" novalidate>
                <input type="hidden" name="acao" value="criar">

                <div class="col-md-6">
                    <label for="inputNome" class="form-label">Nome Completo *</label>
                    <input type="text" class="form-control" id="inputNome" name="FU_NOME" required 
                        maxlength="100" placeholder="Ex: João da Silva">
                    <div class="invalid-feedback">Por favor, insira o nome completo.</div>
                </div>

                <div class="col-md-3">
                    <label for="inputGenero" class="form-label">Gênero *</label>
                    <select class="form-select" id="inputGenero" name="FU_GENERO" required>
                        <option value="" disabled>Selecione...</option>
                        <option value="M" selected>Masculino</option>
                        <option value="F">Feminino</option>
                        <option value="O">Outro</option>
                    </select>
                    <div class="invalid-feedback">Por favor, selecione o gênero.</div>
                </div>

                <div class="col-md-3">
                    <label for="inputNivelAcesso" class="form-label">Nível de Acesso *</label>
                    <select class="form-select" id="inputNivelAcesso" name="FU_NIVEL_ACESSO" required>
                        <option value="" disabled>Selecione...</option>
                        <option value="1">Nível 1 - Básico</option>
                        <option value="2">Nível 2 - Intermediário</option>
                        <option value="3" selected>Nível 3 - Administrador</option>
                    </select>
                    <div class="invalid-feedback">Por favor, selecione o nível de acesso.</div>
                </div>

                <div class="col-md-4">
                    <label for="inputSenha" class="form-label">Senha *</label>
                    <input type="password" class="form-control" id="inputSenha" name="FU_SENHA" required minlength="4">
                    <small class="form-text text-muted">Mínimo 4 caracteres</small>
                    <div class="invalid-feedback">A senha deve ter no mínimo 4 caracteres.</div>
                </div>

                <div class="col-md-4">
                    <label for="inputSalario" class="form-label">Salário (R$) *</label>
                    <input type="number" class="form-control" id="inputSalario" name="FU_SALARIO" step="0.01" min="0" required
                        placeholder="Ex: 2500.50">
                    <div class="invalid-feedback">Por favor, insira um salário válido.</div>
                </div>

                <div class="col-md-4">
                    <label for="inputDataAdmissao" class="form-label">Data de Admissão *</label>
                    <input type="date" class="form-control" id="inputDataAdmissao" name="FU_DATA_ADMISSAO" required
                        max="<?php echo date('Y-m-d'); ?>"> <div class="invalid-feedback">Por favor, insira a data de admissão.</div>
                </div>

                <div class="col-12 mt-4">
                    <button type="submit" class="btn text-white" style="background-color: #e35c38;">
                        <i class="bi bi-save me-2"></i>Salvar Funcionário
                    </button>
                </div>
            </form>

            <hr class="my-5">

            <div class="table-responsive">
                <h3 class="mb-3">Funcionários Cadastrados</h3>
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Gênero</th>
                            <th>Nível</th>
                            <th>Salário</th>
                            <th>Data Admissão</th>
                            <th>Email</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Garante que $stmt existe e está pronto para ser percorrido
                        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        if (empty($dados)) {
                            echo '<tr><td colspan="8" class="text-center">Nenhum funcionário cadastrado.</td></tr>';
                        }
                        
                        foreach ($dados as $row) {
                            // Sanitização de Saída (htmlspecialchars) em todas as variáveis exibidas
                            $FU_ID = htmlspecialchars($row['FU_ID']);
                            $FU_NOME_RAW = htmlspecialchars($row['FU_NOME']);
                            $FU_GENERO_RAW = htmlspecialchars($row['FU_GENERO']);
                            $FU_NIVEL_ACESSO = htmlspecialchars($row['FU_NIVEL_ACESSO']);
                            $FU_SALARIO_RAW = htmlspecialchars($row['FU_SALARIO']);
                            $FU_DATA_ADMISSAO_RAW = htmlspecialchars($row['FU_DATA_ADMISSAO']);
                            $FU_EMAIL_RAW = htmlspecialchars($row['FU_EMAIL']);

                            $modalId = "modal-funcionario-" . $FU_ID;

                            // Formatação do Nível de Acesso
                            $nivelClass = match ((int)$FU_NIVEL_ACESSO) {
                                1 => 'bg-info',
                                2 => 'bg-warning',
                                3 => 'bg-danger',
                                default => 'bg-secondary'
                            };

                            $nivelTexto = match ((int)$FU_NIVEL_ACESSO) {
                                1 => 'Básico',
                                2 => 'Intermediário',
                                3 => 'Admin',
                                default => 'N/A'
                            };

                            // Tradução do Gênero
                            $generoTexto = match ($FU_GENERO_RAW) {
                                'M' => 'Masculino',
                                'F' => 'Feminino',
                                'O' => 'Outro',
                                default => $FU_GENERO_RAW
                            };

                            // **FORMATACAO: Capitalização do Nome para melhor leitura**
                            $nomeFormatado = ucwords(strtolower($FU_NOME_RAW));

                            // **FORMATACAO: Tratamento de Email Vazio**
                            $emailFormatado = !empty($FU_EMAIL_RAW) ? $FU_EMAIL_RAW : '<span class="text-muted">Não Informado</span>';
                            
                            // Formatação de Salário (R$ 1.234,56)
                            $salarioFormatado = "R$ " . number_format($FU_SALARIO_RAW, 2, ',', '.');
                            
                            // Formatação de Data (DD/MM/AAAA)
                            $dataAdmissaoFormatada = date('d/m/Y', strtotime($FU_DATA_ADMISSAO_RAW));

                            echo "
                            <tr>
                                <td>{$FU_ID}</td>
                                <td>{$nomeFormatado}</td>
                                <td>{$generoTexto}</td>
                                <td><span class='badge {$nivelClass}'>{$nivelTexto}</span></td>
                                <td>{$salarioFormatado}</td>
                                <td>{$dataAdmissaoFormatada}</td>
                                <td>{$emailFormatado}</td> 
                                <td>
                                    <button class='btn btn-sm btn-warning' data-bs-toggle='modal' data-bs-target='#{$modalId}'>
                                        Editar
                                    </button>
                                    
                                    <form method='POST' style='display:inline;' onsubmit='return confirm(\"Tem certeza que deseja deletar o funcionário **{$nomeFormatado}**?\");'>
                                        <input type='hidden' name='acao' value='deletar'>
                                        <input type='hidden' name='FU_ID' value='{$FU_ID}'>
                                        <button class='btn btn-sm btn-danger' type='submit'>
                                            <i class='bi bi-trash'></i> Deletar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            
                            <div class='modal fade' id='{$modalId}' tabindex='-1' aria-labelledby='{$modalId}Label' aria-hidden='true'>
                                <div class='modal-dialog modal-lg'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h5 class='modal-title' id='{$modalId}Label'> Editar Funcionário: {$nomeFormatado}</h5>
                                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Fechar'></button>
                                        </div>
                                        <div class='modal-body'>
                                            <form method='POST'>
                                                <input type='hidden' name='acao' value='atualizar'>
                                                <input type='hidden' name='FU_ID' value='{$FU_ID}'>
                                                
                                                <div class='row g-3'>
                                                    <div class='col-md-12'>
                                                        <label class='form-label'>Nome Completo</label>
                                                        <input type='text' class='form-control' name='FU_NOME' value='{$FU_NOME_RAW}' required maxlength='100'>
                                                    </div>
                                                    
                                                    <div class='col-md-6'>
                                                        <label class='form-label'>Gênero</label>
                                                        <select class='form-select' name='FU_GENERO' required>
                                                            <option value='M' " . ($FU_GENERO_RAW == 'M' ? 'selected' : '') . ">Masculino</option>
                                                            <option value='F' " . ($FU_GENERO_RAW == 'F' ? 'selected' : '') . ">Feminino</option>
                                                            <option value='O' " . ($FU_GENERO_RAW == 'O' ? 'selected' : '') . ">Outro</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class='col-md-6'>
                                                        <label class='form-label'>Nível de Acesso</label>
                                                        <select class='form-select' name='FU_NIVEL_ACESSO' required>
                                                            <option value='1' " . ($FU_NIVEL_ACESSO == 1 ? 'selected' : '') . ">Nível 1 - Básico</option>
                                                            <option value='2' " . ($FU_NIVEL_ACESSO == 2 ? 'selected' : '') . ">Nível 2 - Intermediário</option>
                                                            <option value='3' " . ($FU_NIVEL_ACESSO == 3 ? 'selected' : '') . ">Nível 3 - Admin</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class='col-md-6'>
                                                        <label class='form-label'>Nova Senha</label>
                                                        <input type='password' class='form-control' name='FU_SENHA' minlength='4' placeholder='****'>
                                                        <small class='form-text text-muted'>Deixe em branco para manter a senha atual. Mínimo 4 caracteres se for alterar.</small>
                                                    </div>
                                                    
                                                    <div class='col-md-6'>
                                                        <label class='form-label'>Email</label>
                                                        <input type='email' class='form-control' name='FU_EMAIL' value='{$FU_EMAIL_RAW}' placeholder='email@exemplo.com'>
                                                    </div>
                                                    
                                                    <div class='col-md-6'>
                                                        <label class='form-label'>Salário (R$)</label>
                                                        <input type='number' class='form-control' name='FU_SALARIO' value='{$FU_SALARIO_RAW}' step='0.01' min='0' required>
                                                    </div>
                                                    
                                                    <div class='col-md-6'>
                                                        <label class='form-label'>Data de Admissão</label>
                                                        <input type='date' class='form-control' name='FU_DATA_ADMISSAO' value='{$FU_DATA_ADMISSAO_RAW}' required>
                                                    </div>
                                                </div>
                                                
                                                <div class='modal-footer mt-4'>
                                                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                                                    <button type='submit' class='btn text-white' style='background-color: #e35c38;'>
                                                        Atualizar Funcionário
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            ";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
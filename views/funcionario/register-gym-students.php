<!doctype html>
<html lang="pt-br">
<head>
    <title>TechFit</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="shortcut icon" href="public/images/TechFit-icon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="../../Assets/style/style.css">
</head>
<?php
require_once __DIR__ . "..\\models\\Usuario.php";
$controller = new Usuario(); 
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $acao  = $_POST['acao'] ?? '';
    if($acao == 'criar'){
        $controller->US_NOME = $_POST['US_NOME'];
        $controller->US_IDADE = $_POST['US_IDADE'];
        $controller->US_GENERO = $_POST['US_GENERO'];
        $controller->US_DATA_NASCIMENTO = $_POST['US_DATA_NASCIMENTO'];
        $controller->US_ALTURA = $_POST['US_ALTURA'];
        $controller->US_PESO = $_POST['US_PESO'];
        $controller->US_OBJETIVO = $_POST['US_OBJETIVO'] ?? '';
        $controller->US_PORC_MASSA_MAGRA = $_POST['US_PORC_MASSA_MAGRA'];
        $controller->US_TREINO_ANTERIOR = $_POST['US_TREINO_ANTERIOR'];
        $controller->US_TEMPO_TREINOANT = $_POST['US_TEMPO_TREINOANT'] ?? null;
        $controller->US_ENDERECO = $_POST['US_ENDERECO'];
        $controller->US_DISPONIBILIDADE = implode(',', $_POST['US_DISPONIBILIDADE'] ?? []);
        $controller->PL_ID = $_POST['PL_ID'];
        $controller->US_DATA_VENCIMENTO = $_POST['US_DATA_VENCIMENTO'] ?? null;
        $controller->US_STATUS_PAGAMENTO = $_POST['US_STATUS_PAGAMENTO'] ?? 'EM_DIA';
    }
}
?>
<body>
    
    <div class="d-flex" style="height:100vh; overflow-y: auto;">
        <!-- Sidebar -->
        <div class="sidebar d-flex flex-column flex-shrink-0 p-3 bg-light" style="height: 100vh; width: 280px; order: 1; overflow-y: auto; ">
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
                    <a href="/funcionario/register/exercicios" class="nav-link link-dark" >
                        Cadastrar Exercícios
                    </a>
                </li>
                <li>
                    <a href="/funcionario/register/estudantes" class="nav-link active text-white" style="background-color: #e35c38;" aria-current="page">
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
                     <a href="/funcionario/treinos" class="nav-link link-dark">
                        Ver Treinos Disponíveis
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

      <main class="flex-grow-1 p-4" style="order:2; overflow-y: auto; overflow-y: auto;">

    <h2 class="mb-4">Cadastrar Usuário</h2>

    <form method="POST" class="row g-3">
        <input type="hidden" name="acao" value="criar">
        <!-- US_NOME -->
        <div class="col-md-6">
            <label class="form-label">Nome *</label>
            <input type="text" class="form-control" name="US_NOME" maxlength="25" required>
        </div>

        <!-- US_GENERO -->
        <div class="col-md-3">
            <label class="form-label">Gênero *</label>
            <select class="form-select" name="US_GENERO" required>
                <option value="M">Masculino (Padrão)</option>
                <option value="F">Feminino</option>
                <option value="O">Outro</option>
            </select>
        </div>

        <!-- US_DATA_NASCIMENTO -->
        <div class="col-md-3">
            <label class="form-label">Data de Nascimento *</label>
            <input type="date" class="form-control" name="US_DATA_NASCIMENTO" required>
        </div>

        <!-- US_IDADE -->
        <div class="col-md-3">
            <label class="form-label">Idade *</label>
            <input type="number" class="form-control" name="US_IDADE" required>
        </div>

        <!-- US_ALTURA -->
        <div class="col-md-3">
            <label class="form-label">Altura (cm) *</label>
            <input type="number" class="form-control" name="US_ALTURA" required>
        </div>

        <!-- US_PESO -->
        <div class="col-md-3">
            <label class="form-label">Peso (kg) *</label>
            <input type="number" step="0.01" class="form-control" name="US_PESO" required>
        </div>

        <!-- US_OBJETIVO -->
        <div class="col-md-3">
            <label class="form-label">Objetivo</label>
            <select class="form-select" name="US_OBJETIVO">
                <option value="">Nenhum</option>
                <option value="EMAGRECER">Emagrecer</option>
                <option value="PERDER PESO">Perder Peso</option>
                <option value="SAÙDE">Saúde</option>
            </select>
        </div>

        <!-- US_PORC_MASSA_MAGRA -->
        <div class="col-md-3">
            <label class="form-label">% Massa Magra *</label>
            <input type="number" step="0.01" class="form-control" name="US_PORC_MASSA_MAGRA" required>
        </div>

        <!-- US_TREINO_ANTERIOR -->
        <div class="col-md-3">
            <label class="form-label">Já treinou antes? *</label>
            <select class="form-select" name="US_TREINO_ANTERIOR" required>
                <option value="1">Sim</option>
                <option value="0">Não</option>
            </select>
        </div>

        <!-- US_TEMPO_TREINOANT -->
        <div class="col-md-3">
            <label class="form-label">Tempo de treino anterior (meses)</label>
            <input type="number" class="form-control" name="US_TEMPO_TREINOANT">
        </div>

        <!-- US_ENDERECO -->
        <div class="col-md-6">
            <label class="form-label">Endereço *</label>
            <input type="text" class="form-control" name="US_ENDERECO" maxlength="9" required>
        </div>

        <!-- US_DISPONIBILIDADE -->
        <div class="col-md-6">
            <label class="form-label">Disponibilidade *</label>
            <div class="d-flex flex-wrap gap-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="US_DISPONIBILIDADE[]" value="segunda" id="segunda">
                    <label class="form-check-label" for="segunda">Segunda</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="US_DISPONIBILIDADE[]" value="terça" id="terça">
                    <label class="form-check-label" for="terça">Terça</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="US_DISPONIBILIDADE[]" value="quarta" id="quarta">
                    <label class="form-check-label" for="quarta">Quarta</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="US_DISPONIBILIDADE[]" value="quinta" id="quinta">
                    <label class="form-check-label" for="quinta">Quinta</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="US_DISPONIBILIDADE[]" value="sexta" id="sexta">
                    <label class="form-check-label" for="sexta">Sexta</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="US_DISPONIBILIDADE[]" value="sábado" id="sábado">
                    <label class="form-check-label" for="sábado">Sábado</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="US_DISPONIBILIDADE[]" value="domingo" id="domingo">
                    <label class="form-check-label" for="domingo">Domingo</label>
                </div>
            </div>
        </div>

        <!-- PL_ID (FK PLANOS) -->
        <div class="col-md-3">
            <label class="form-label">Plano (ID) *</label>
            <input type="number" class="form-control" name="PL_ID" required>
        </div>

        <!-- US_DATA_VENCIMENTO -->
        <div class="col-md-3">
            <label class="form-label">Data de Vencimento</label>
            <input type="date" class="form-control" name="US_DATA_VENCIMENTO">
        </div>

        <!-- US_STATUS_PAGAMENTO -->
        <div class="col-md-3">
            <label class="form-label">Status do Pagamento</label>
            <select class="form-select" name="US_STATUS_PAGAMENTO">
                <option value="EM_DIA">Em dia</option>
                <option value="ATRASADO">Atrasado</option>
                <option value="CANCELADO">Cancelado</option>
            </select>
        </div>

        <div class="col-12 mt-3">
            <button type="submit" class="btn text-white" style="background-color: #e35c38;">
                Salvar Usuário
            </button>
        </div>

    </form>
    </div> 
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    
</body>
</html>
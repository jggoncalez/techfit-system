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
    
    <div class="d-flex" style="height: 100vh;">
        <!-- Sidebar -->
        <div class="sidebar d-flex flex-column flex-shrink-0 p-3 bg-light" style="height: 100vh; width: 280px;">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                <img src="/Assets/images/logo-fixed.webp" class="img-fluid mb-2" alt="TechFit Logo" style="max-width: 150px;">
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                    <a href="main.php" class="nav-link link-dark">
                        Home
                    </a>
                </li>
                <li class="nav-item">
                    <a href="register-exercises.php" class="nav-link link-dark" >
                        Cadastrar Exercícios
                    </a>
                </li>
                <li>
                    <a href="register-gym-students.php" class="nav-link active text-white" style="background-color: #e35c38;" aria-current="page">
                        Cadastrar Alunos
                    </a>
                </li>
                <li>
                    <a href="register-classes.php" class="nav-link link-dark">
                        Cadastrar Aulas
                    </a>
                </li>
                <li>
                    <a href="set-training.php" class="nav-link link-dark">
                        Montar Treinos
                    </a>
                     <a href="get-training.php" class="nav-link link-dark">
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

      <main class="flex-grow-1 p-4">

    <h2 class="mb-4">Cadastrar Usuário</h2>

    <form action="salvar-usuario.php" method="POST" class="row g-3">

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
            <label class="form-label">Disponibilidade (JSON) *</label>
            <textarea class="form-control" name="US_DISPONIBILIDADE" rows="3" required>
{"segunda": true, "terça": false}
            </textarea>
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
</main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
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
                    <a href="/funcionario/register/exercicios" class="nav-link active text-white" style="background-color: #e35c38;" aria-current="page">
                        Cadastrar Exercícios
                    </a>
                </li>
                <li>
                    <a href="/funcionario/register/estudantes" class="nav-link link-dark">
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
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://placehold.co/20x20" alt="" width="32" height="32" class="rounded-circle me-2">
                    <p id="user-name"><strong>User</strong></p>
                </a>
            </div>
        </div>
<main class="flex-grow-1 p-4" style="overflow-y: auto;">

    <h2 class="mb-4">Cadastrar Exercício</h2>
    <!-- action="salvar-exercicio.php" method="POST" -->
    <form  class="row g-3">

        <!-- EX_NOME -->
        <div class="col-md-6">
            <label class="form-label">Nome do Exercício *</label>
            <input type="text" class="form-control" name="EX_NOME" required>
        </div>

        <!-- EX_DIFICULDADE -->
        <div class="col-md-3">
            <label class="form-label">Dificuldade *</label>
            <input type="number" class="form-control" name="EX_DIFICULDADE" min="1" max="10" required>
        </div>

        <!-- EX_TIPO -->
        <div class="col-md-3">
            <label class="form-label">Tipo *</label>
            <select class="form-select" name="EX_TIPO" required>
                <option value="">Selecione...</option>
                <option value="PEITO">Peito</option>
                <option value="COSTAS">Costas</option>
                <option value="PERNAS">Pernas</option>
                <option value="OMBROS">Ombros</option>
                <option value="BRACOS">Braços</option>
                <option value="ABDOMEN">Abdômen</option>
                <option value="CARDIO">Cardio</option>
                <option value="FUNCIONAL">Funcional</option>
            </select>
        </div>

        <!-- EX_MIN_VALOR -->
        <div class="col-md-3">
            <label class="form-label">Valor Mínimo *</label>
            <input type="number" class="form-control" name="EX_MIN_VALOR" required>
        </div>

        <!-- EX_MAX_VALOR -->
        <div class="col-md-3">
            <label class="form-label">Valor Máximo *</label>
            <input type="number" class="form-control" name="EX_MAX_VALOR" value="999" required>
        </div>

        <!-- EX_MIN_REPETICOES -->
        <div class="col-md-3">
            <label class="form-label">Repetições Mínimas *</label>
            <input type="number" class="form-control" name="EX_MIN_REPETICOES" value="8" required>
        </div>

        <!-- EX_MAX_REPETICOES -->
        <div class="col-md-3">
            <label class="form-label">Repetições Máximas *</label>
            <input type="number" class="form-control" name="EX_MAX_REPETICOES" value="20" required>
        </div>

        <!-- EX_PONTUACAO -->
        <div class="col-md-3">
            <label class="form-label">Pontuação</label>
            <input type="number" class="form-control" name="EX_PONTUACAO" value="10">
        </div>

        <!-- EX_TEMPO_DESCANSO -->
        <div class="col-md-3">
            <label class="form-label">Tempo de Descanso (segundos)</label>
            <input type="number" class="form-control" name="EX_TEMPO_DESCANSO" value="60">
        </div>

        <!-- EX_EQUIPAMENTO -->
        <div class="col-md-6">
            <label class="form-label">Equipamento Necessário</label>
            <input type="text" class="form-control" name="EX_EQUIPAMENTO" placeholder="Ex: Halteres, Máquina X, Barra...">
        </div>

        <!-- EX_DESCRICAO -->
        <div class="col-md-12">
            <label class="form-label">Descrição do Exercício</label>
            <textarea class="form-control" name="EX_DESCRICAO" rows="4"></textarea>
        </div>

        <div class="col-12 mt-3">
            <button type="submit" class="btn text-white" style="background-color: #e35c38;">
                Salvar Exercício
            </button>
        </div>

    </form>
</main>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
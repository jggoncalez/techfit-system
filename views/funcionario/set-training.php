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
                    <a href="register-gym-students.php" class="nav-link link-dark">
                        Cadastrar Alunos
                    </a>
                </li>
                <li>
                    <a href="register-classes.php" class="nav-link link-dark">
                        Cadastrar Aulas
                    </a>
                </li>
                <li>
                    <a href="set-training.php" class="nav-link active text-white" style="background-color: #e35c38;" aria-current="page">
                        Montar Treinos
                    </a>
                     <a href="get-training.php" class="nav-link link-dark">
                        Ver Treinos Disponíveis
                    </a>
                </li>
            </ul>
            <hr>
        
        </div>

        <main class="flex-grow-1">
            
<form action="salvar-treino.php" method="POST" class="row g-3">

    <h3 class="mt-3">Cadastro de Treino</h3>

    <!-- TR_DATA_CRIACAO -->
    <div class="col-md-3">
        <label class="form-label">Data do Treino *</label>
        <input type="date" name="TR_DATA_CRIACAO" class="form-control" required>
    </div>

    <!-- US_ID -->
    <div class="col-md-6">
        <label class="form-label">Usuário *</label>
        <select name="US_ID" class="form-select" required>
            <option value="">Selecione</option>
            <?php foreach($usuarios as $u): ?>
                <option value="<?= $u['US_ID'] ?>"><?= $u['US_NOME'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- TR_DURACAO_ESTIMADA -->
    <div class="col-md-3">
        <label class="form-label">Duração Estimada (min)</label>
        <input type="number" name="TR_DURACAO_ESTIMADA" class="form-control" required>
    </div>

    <!-- TR_OBSERVACOES -->
    <div class="col-md-12">
        <label class="form-label">Observações</label>
        <textarea name="TR_OBSERVACOES" class="form-control"></textarea>
    </div>

    <hr>

    <h4>Exercícios do Treino</h4>

    <div id="lista-exercicios"></div>

    <button type="button" class="btn btn-secondary mt-2" onclick="addExercicio()">Adicionar Exercício</button>

    <div class="col-12 mt-4">
        <button type="submit" class="btn text-white" style="background-color:#e35c38;">Salvar Treino</button>
    </div>

</form>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
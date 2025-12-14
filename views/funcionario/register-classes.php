<?php
session_start();

// Verifica se está logado
if (!isset($_SESSION['user_ID'])) {
    header("Location: /public/login.php");
    exit();
}

require_once __DIR__ . '/../../controllers/agendamento/AulaController.php';
require_once __DIR__ . '/../../controllers/agendamento/ParticipacoesAulaController.php';
require_once __DIR__ . '/../../controllers/FuncionarioController.php';

use controllers\agendamento\AulaController;
use controllers\agendamento\ParticipacoesAulaController;
use controllers\FuncionarioController;

$controller = new AulaController();
$controllerPart = new ParticipacoesAulaController();
$controllerFun = new FuncionarioController();
$controllerFun->FU_ID = $_SESSION['user_ID'];
$controllerFun->searchID();

$stmt = $controller->list();
$dadosAulas = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmtPart = $controllerPart->buscarAvaliacoes();
$dadosAvaliacoes = $stmtPart->fetchAll(PDO::FETCH_ASSOC);

// Função para formatar o status em português
function formatarStatus($status) {
    return match ($status) {
        'AGENDADA' => 'Agendada',
        'EM_ANDAMENTO' => 'Em Andamento',
        'CONCLUIDA' => 'Concluída',
        'CANCELADA' => 'Cancelada',
        default => $status
    };
}

// Função para validar horários
function validarHorarios($horaInicio, $horaFim) {
    $inicio = strtotime($horaInicio);
    $fim = strtotime($horaFim);
    return $fim > $inicio;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';

    // Sanitização de dados
    $AU_NOME = filter_input(INPUT_POST, 'AU_NOME', FILTER_SANITIZE_SPECIAL_CHARS);
    $AU_DATA = filter_input(INPUT_POST, 'AU_DATA', FILTER_SANITIZE_SPECIAL_CHARS);
    $AU_HORA_INICIO = filter_input(INPUT_POST, 'AU_HORA_INICIO', FILTER_SANITIZE_SPECIAL_CHARS);
    $AU_HORA_FIM = filter_input(INPUT_POST, 'AU_HORA_FIM', FILTER_SANITIZE_SPECIAL_CHARS);
    $AU_SALA = filter_input(INPUT_POST, 'AU_SALA', FILTER_SANITIZE_SPECIAL_CHARS);
    $AU_VAGAS_TOTAIS = filter_input(INPUT_POST, 'AU_VAGAS_TOTAIS', FILTER_VALIDATE_INT);
    $AU_VAGAS_DISPONIVEIS = filter_input(INPUT_POST, 'AU_VAGAS_DISPONIVEIS', FILTER_VALIDATE_INT);
    $AU_STATUS = filter_input(INPUT_POST, 'AU_STATUS', FILTER_SANITIZE_SPECIAL_CHARS);
    $AU_OBSERVACOES = filter_input(INPUT_POST, 'AU_OBSERVACOES', FILTER_SANITIZE_SPECIAL_CHARS);
    $FU_ID = filter_input(INPUT_POST, 'FU_ID', FILTER_VALIDATE_INT);

    // Validação de horários
    if (!empty($AU_HORA_INICIO) && !empty($AU_HORA_FIM) && !validarHorarios($AU_HORA_INICIO, $AU_HORA_FIM)) {
        header("Location: /funcionario/register/classes");
        exit;
    } elseif ($acao === 'criar' && $AU_VAGAS_TOTAIS !== false && $FU_ID !== false) {
        $controller->AU_NOME = $AU_NOME;
        $controller->AU_DATA = $AU_DATA;
        $controller->AU_HORA_INICIO = $AU_HORA_INICIO;
        $controller->AU_HORA_FIM = $AU_HORA_FIM;
        $controller->AU_SALA = $AU_SALA;
        $controller->AU_VAGAS_TOTAIS = $AU_VAGAS_TOTAIS;
        $controller->AU_VAGAS_DISPONIVEIS = $AU_VAGAS_TOTAIS;
        $controller->AU_STATUS = $AU_STATUS;
        $controller->AU_OBSERVACOES = $AU_OBSERVACOES;
        $controller->FU_ID = $FU_ID;
        
        $controller->create();
        header("Location: /funcionario/register/classes");
        exit;
    } elseif ($acao === 'atualizar') {
        $AU_ID = filter_input(INPUT_POST, 'AU_ID', FILTER_VALIDATE_INT);

        if ($AU_ID !== false && $AU_VAGAS_TOTAIS !== false && $AU_VAGAS_DISPONIVEIS !== false && $FU_ID !== false) {
            // Validação: vagas disponíveis não pode ser maior que totais
            if ($AU_VAGAS_DISPONIVEIS > $AU_VAGAS_TOTAIS) {
                header("Location: /funcionario/register/classes");
                exit;
            }
            
            $controller->AU_ID = $AU_ID;
            $controller->AU_NOME = $AU_NOME;
            $controller->AU_DATA = $AU_DATA;
            $controller->AU_HORA_INICIO = $AU_HORA_INICIO;
            $controller->AU_HORA_FIM = $AU_HORA_FIM;
            $controller->AU_SALA = $AU_SALA;
            $controller->AU_VAGAS_TOTAIS = $AU_VAGAS_TOTAIS;
            $controller->AU_VAGAS_DISPONIVEIS = $AU_VAGAS_DISPONIVEIS;
            $controller->AU_STATUS = $AU_STATUS;
            $controller->AU_OBSERVACOES = $AU_OBSERVACOES;
            $controller->FU_ID = $FU_ID;
            
            $controller->update();
            header("Location: /funcionario/register/classes");
            exit;
        }
    } elseif ($acao === 'deletar') {
        $AU_ID = filter_input(INPUT_POST, 'AU_ID', FILTER_VALIDATE_INT);
        if ($AU_ID !== false) {
            $controller->AU_ID = $AU_ID;
            
            $controller->delete();
            header("Location: /funcionario/register/classes");
            exit;
        }
    }
}
?>
<!doctype html>
<html lang="pt-br">

<head>
    <title>TechFit - Cadastro de Aulas</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="shortcut icon" href="../public/images/TechFit-icon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../Assets/style/style.css">
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
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
                    <a href="/funcionario/register/classes" class="nav-link active text-white" style="background-color: #e35c38;" aria-current="page">
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
                        <i class="bi bi-box-arrow-in-up-left me-2"></i>Acessos
                    </a>
                </li>
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" 
                   id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="../../public/images/pfp_placeholder.webp" alt="" width="32" height="32" class="rounded-circle me-2">
                    <strong id="user-name-sidebar"><?php echo htmlspecialchars($controllerFun->FU_NOME ?? 'Usuário'); ?></strong>
                </a>
                <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                    <li><a class="dropdown-item" href="/funcionario/profile"><i class="bi bi-person me-2"></i>Perfil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="/core/Session.php?action=logout"><i class="bi bi-box-arrow-right me-2"></i>Sair</a></li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <main class="flex-grow-1 p-4" style="overflow-y: auto;">
            <h2 class="mb-4">Cadastrar Aula</h2>
            <form method="POST" class="row g-3" id="formCriarAula">
                <input type="hidden" name="acao" value="criar">

                <div class="col-md-6">
                    <label class="form-label">Nome da Aula <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="AU_NOME" required maxlength="100">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Funcionário <span class="text-danger">*</span></label>
                    <select class="form-select" name="FU_ID" required>
                        <option value="">Selecione...</option>
                        <?php echo $controller->buscarFuncionarios(); ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Data <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="AU_DATA" required min="<?php echo date('Y-m-d'); ?>">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Hora Início <span class="text-danger">*</span></label>
                    <input type="time" class="form-control" name="AU_HORA_INICIO" required id="horaInicio">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Hora Fim <span class="text-danger">*</span></label>
                    <input type="time" class="form-control" name="AU_HORA_FIM" required id="horaFim">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Sala <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="AU_SALA" placeholder="Ex: Sala 1" required maxlength="50">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Vagas Totais <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="AU_VAGAS_TOTAIS" min="1" max="100" value="15" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-select" name="AU_STATUS" required>
                        <option value="AGENDADA" selected>Agendada</option>
                        <option value="EM_ANDAMENTO">Em Andamento</option>
                        <option value="CONCLUIDA">Concluída</option>
                        <option value="CANCELADA">Cancelada</option>
                    </select>
                </div>

                <div class="col-md-12">
                    <label class="form-label">Observações</label>
                    <textarea class="form-control" name="AU_OBSERVACOES" rows="3" maxlength="255"></textarea>
                </div>

                <div class="col-12 mt-3">
                    <button type="submit" class="btn text-white" style="background-color: #e35c38;">
                        <i class="bi bi-floppy-fill me-2"></i>Salvar Aula
                    </button>
                </div>
            </form>

            <!-- Tabela de Aulas -->
            <div class="table-responsive mt-5">
                <h3 class="mb-3">Aulas Cadastradas</h3>
                <?php if (empty($dadosAulas)): ?>
                    <div class="alert alert-info" role="alert">
                        <i class="bi bi-info-circle me-2"></i>Nenhuma aula cadastrada.
                    </div>
                <?php else: ?>
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Data</th>
                            <th>Horário</th>
                            <th>Sala</th>
                            <th>Vagas</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($dadosAulas as $row) {
                            $modalId = "modal-aula-" . htmlspecialchars($row['AU_ID']);
                            $nomeEscapado = htmlspecialchars($row['AU_NOME'], ENT_QUOTES, 'UTF-8');

                            // Badge de status
                            $statusClass = match ($row['AU_STATUS']) {
                                'AGENDADA' => 'bg-primary',
                                'EM_ANDAMENTO' => 'bg-warning text-dark',
                                'CONCLUIDA' => 'bg-success',
                                'CANCELADA' => 'bg-danger',
                                default => 'bg-secondary'
                            };
                            $statusFormatado = formatarStatus($row['AU_STATUS']);
                            
                            // Formatação de Data e Hora
                            $dataFormatada = date('d/m/Y', strtotime($row['AU_DATA']));
                            $horaInicioFormatada = date('H:i', strtotime($row['AU_HORA_INICIO']));
                            $horaFimFormatada = date('H:i', strtotime($row['AU_HORA_FIM']));
                            $horarioCompleto = "{$horaInicioFormatada} - {$horaFimFormatada}";
                            
                            echo "
                            <tr>
                                <td>" . htmlspecialchars($row['AU_ID']) . "</td>
                                <td>{$nomeEscapado}</td>
                                <td>{$dataFormatada}</td>
                                <td>{$horarioCompleto}</td>
                                <td>" . htmlspecialchars($row['AU_SALA']) . "</td>
                                <td>" . htmlspecialchars($row['AU_VAGAS_DISPONIVEIS']) . "/" . htmlspecialchars($row['AU_VAGAS_TOTAIS']) . "</td>
                                <td><span class='badge {$statusClass}'>{$statusFormatado}</span></td>
                                <td>
                                    <button class='btn btn-sm btn-warning' data-bs-toggle='modal' data-bs-target='#{$modalId}' title='Editar Aula'>
                                            Editar
                                    </button>
                                    <form method='POST' style='display:inline;' onsubmit='return confirmarDelecao(\"{$nomeEscapado}\")'>
                                        <input type='hidden' name='acao' value='deletar'>
                                        <input type='hidden' name='AU_ID' value='" . htmlspecialchars($row['AU_ID']) . "'>
                                        <button class='btn btn-sm btn-danger' type='submit' title='Deletar Aula'>
                                            Deletar
                                        </button>
                                    </form>
                                </td>
                            </tr>";

                            // Modal de Edição
                            echo "
                            <div class='modal fade' id='{$modalId}' tabindex='-1' aria-hidden='true'>
                                <div class='modal-dialog modal-lg'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h5 class='modal-title'>Editar Aula: {$nomeEscapado}</h5>
                                            <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                        </div>
                                        <div class='modal-body'>
                                            <form method='POST' class='formEditarAula'>
                                                <input type='hidden' name='acao' value='atualizar'>
                                                <input type='hidden' name='AU_ID' value='" . htmlspecialchars($row['AU_ID']) . "'>
                                                
                                                <div class='row g-3'>
                                                    <div class='col-md-6'>
                                                        <label class='form-label'>Nome da Aula <span class='text-danger'>*</span></label>
                                                        <input type='text' class='form-control' name='AU_NOME' value='{$nomeEscapado}' required maxlength='100'>
                                                    </div>
                                                
                                                    <div class='col-md-6'>
                                                        <label class='form-label'>Data <span class='text-danger'>*</span></label>
                                                        <input type='date' class='form-control' name='AU_DATA' value='" . htmlspecialchars($row['AU_DATA']) . "' required>
                                                    </div>
                                                    
                                                    <div class='col-md-4'>
                                                        <label class='form-label'>Hora Início <span class='text-danger'>*</span></label>
                                                        <input type='time' class='form-control horaInicioEdit' name='AU_HORA_INICIO' value='" . htmlspecialchars(date('H:i', strtotime($row['AU_HORA_INICIO']))) . "' required>
                                                    </div>
                                                    
                                                    <div class='col-md-4'>
                                                        <label class='form-label'>Hora Fim <span class='text-danger'>*</span></label>
                                                        <input type='time' class='form-control horaFimEdit' name='AU_HORA_FIM' value='" . htmlspecialchars(date('H:i', strtotime($row['AU_HORA_FIM']))) . "' required>
                                                    </div>
                                                    
                                                    <div class='col-md-4'>
                                                        <label class='form-label'>Sala <span class='text-danger'>*</span></label>
                                                        <input type='text' class='form-control' name='AU_SALA' value='" . htmlspecialchars($row['AU_SALA']) . "' required maxlength='50'>
                                                    </div>
                                                    
                                                    <div class='col-md-4'>
                                                        <label class='form-label'>Vagas Disponíveis <span class='text-danger'>*</span></label>
                                                        <input type='number' class='form-control' name='AU_VAGAS_DISPONIVEIS' value='" . htmlspecialchars($row['AU_VAGAS_DISPONIVEIS']) . "' required min='0' max='" . htmlspecialchars($row['AU_VAGAS_TOTAIS']) . "'>
                                                    </div>
                                                    
                                                    <div class='col-md-4'>
                                                        <label class='form-label'>Vagas Totais <span class='text-danger'>*</span></label>
                                                        <input type='number' class='form-control' name='AU_VAGAS_TOTAIS' value='" . htmlspecialchars($row['AU_VAGAS_TOTAIS']) . "' required min='1' max='100'>
                                                    </div>
                                                    
                                                    <div class='col-md-4'>
                                                        <label class='form-label'>Funcionário <span class='text-danger'>*</span></label>
                                                        <select class='form-select' name='FU_ID' required>
                                                            <option value=''>Selecione...</option>
                                                            " . $controller->buscarFuncionarios($row['FU_ID']) . "
                                                        </select>
                                                    </div>
                                                    
                                                    <div class='col-md-12'>
                                                        <label class='form-label'>Status <span class='text-danger'>*</span></label>
                                                        <select class='form-select' name='AU_STATUS' required>
                                                            <option value='AGENDADA' " . ($row['AU_STATUS'] == 'AGENDADA' ? 'selected' : '') . ">Agendada</option>
                                                            <option value='EM_ANDAMENTO' " . ($row['AU_STATUS'] == 'EM_ANDAMENTO' ? 'selected' : '') . ">Em Andamento</option>
                                                            <option value='CONCLUIDA' " . ($row['AU_STATUS'] == 'CONCLUIDA' ? 'selected' : '') . ">Concluída</option>
                                                            <option value='CANCELADA' " . ($row['AU_STATUS'] == 'CANCELADA' ? 'selected' : '') . ">Cancelada</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class='col-12'>
                                                        <label class='form-label'>Observações</label>
                                                        <textarea class='form-control' name='AU_OBSERVACOES' rows='3' maxlength='255'>" . htmlspecialchars($row['AU_OBSERVACOES'] ?? '') . "</textarea>
                                                    </div>
                                                </div>
                                                
                                                <div class='modal-footer'>
                                                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                                                    <button type='submit' class='btn text-white' style='background-color: #e35c38;'>
                                                        Atualizar Aula
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>";
                        }
                        ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>

            <!-- Avaliações -->
            <h2 class="mb-4 mt-5">Avaliações Recebidas</h2>
            <div class="d-flex flex-wrap" style="gap:30px;">
                <?php 
                $avaliacoesValidas = array_filter($dadosAvaliacoes, fn($row) => !empty($row['PA_AVALIACAO']));
                
                if (empty($avaliacoesValidas)): ?>
                    <div class="alert alert-secondary" role="alert">
                        <i class="bi bi-info-circle me-2"></i>Nenhuma avaliação de aula foi registrada ainda.
                    </div>
                <?php else: 
                    foreach ($avaliacoesValidas as $row): 
                        $nota = intval($row['PA_AVALIACAO']);
                        $comentario = htmlspecialchars($row['PA_COMENTARIO'] ?? 'Sem comentário.');
                        $nomeAluno = htmlspecialchars($row['US_NOME'] ?? 'Aluno Desconhecido');
                        $nomeAula = htmlspecialchars($row['AU_NOME'] ?? 'Aula Desconhecida');
                        
                        // Cor do card baseada na nota
                        $badgeClass = '';
                        if ($nota >= 8) {
                            $badgeClass = 'bg-success';
                        } elseif ($nota >= 5) {
                            $badgeClass = 'bg-warning text-dark';
                        } else {
                            $badgeClass = 'bg-danger';
                        }
                        
                        $borderClass = str_replace('bg-', 'border-', $badgeClass);
                        
                        echo "
                        <div class='card {$borderClass}' style='width: 18rem; border-width: 2px;'>
                            <div class='card-body'>
                                <h5 class='card-title d-flex justify-content-between align-items-center'>
                                    {$nomeAluno}
                                    <span class='badge {$badgeClass}' style='font-size: 1.1em;'>{$nota}/10</span>
                                </h5>
                                <h6 class='card-subtitle mb-2 text-muted small'>Aula: {$nomeAula}</h6>
                                <hr>
                                <p class='card-text'><strong>Comentário:</strong> {$comentario}</p>
                            </div>
                        </div>";
                    endforeach; 
                endif; ?>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    
    <script>
        // Função para confirmar deleção
        function confirmarDelecao(nomeAula) {
            return confirm(`Tem certeza que deseja deletar a aula: ${nomeAula}?`);
        }

        // Validação de horários no formulário de criação
        document.getElementById('formCriarAula').addEventListener('submit', function(e) {
            const horaInicio = document.getElementById('horaInicio').value;
            const horaFim = document.getElementById('horaFim').value;
            
            if (horaInicio && horaFim && horaFim <= horaInicio) {
                e.preventDefault();
                alert('A hora de fim deve ser posterior à hora de início!');
                return false;
            }
        });

        // Validação de horários nos formulários de edição
        document.querySelectorAll('.formEditarAula').forEach(form => {
            form.addEventListener('submit', function(e) {
                const horaInicio = this.querySelector('.horaInicioEdit').value;
                const horaFim = this.querySelector('.horaFimEdit').value;
                
                if (horaInicio && horaFim && horaFim <= horaInicio) {
                    e.preventDefault();
                    alert('A hora de fim deve ser posterior à hora de início!');
                    return false;
                }
            });
        });
    </script>
</body>
</html>
// Configuração da API
const API_URL = '../../api/dashApi.php'; // ⚠️ Ajuste se necessário

// Modo debug
const DEBUG = true;

// Variáveis globais
let graficos = {};

// Função de log
function log(mensagem, tipo = 'info') {
    if (DEBUG) {
        const timestamp = new Date().toLocaleTimeString('pt-BR');
        const icones = {
            'info': 'ℹ️',
            'success': '✅',
            'warning': '⚠️',
            'error': '❌',
            'debug': '🔍'
        };
        console.log(`${icones[tipo] || 'ℹ️'} [${timestamp}] ${mensagem}`);
    }
}

// Inicialização
document.addEventListener('DOMContentLoaded', function() {
    log('📊 Dashboard DOM carregado - inicializando...', 'info');
    inicializarDashboard();
    atualizarHorario();
    setInterval(atualizarHorario, 60000); // 1 minuto
});

// Inicializar dashboard
async function inicializarDashboard() {
    log('🔄 Iniciando carregamento do dashboard...', 'info');
    
    try {
        // Testar conexão com API primeiro
        log(`🌐 Testando conexão: ${API_URL}?tipo=stats_gerais`, 'debug');
        
        const testeResposta = await fetch(`${API_URL}?tipo=stats_gerais`);
        log(`📡 Status HTTP: ${testeResposta.status}`, testeResposta.ok ? 'success' : 'error');
        
        if (!testeResposta.ok) {
            throw new Error(`Erro HTTP ${testeResposta.status}: ${testeResposta.statusText}`);
        }
        
        const testeData = await testeResposta.json();
        log('📦 Resposta da API recebida', 'success');
        log(JSON.stringify(testeData, null, 2), 'debug');
        
        if (!testeData.sucesso) {
            throw new Error(testeData.mensagem || 'API retornou erro sem mensagem');
        }
        
        // Carregar todos os componentes
        log('📊 Carregando componentes do dashboard...', 'info');
        await Promise.all([
            carregarStats(),
            carregarGraficos(),
            carregarTabelas()
        ]);
        
        atualizarUltimaAtualizacao();
        log('✅ Dashboard carregado com sucesso!', 'success');
        mostrarNotificacao('Sucesso!', 'Dashboard carregado com sucesso', 'success');
        
    } catch (erro) {
        log(`❌ ERRO CRÍTICO: ${erro.message}`, 'error');
        console.error('Detalhes do erro:', erro);
        mostrarErroNaTela(erro.message);
        mostrarNotificacao('Erro!', erro.message, 'error');
    }
}

// Exibir erro na tela
function mostrarErroNaTela(mensagem) {
    log('⚠️ Exibindo tela de erro', 'warning');
    
    const container = document.getElementById('stats-cards');
    if (!container) {
        log('❌ Container stats-cards não encontrado!', 'error');
        return;
    }
    
    container.innerHTML = `
        <div class="col-12">
            <div class="alert alert-danger shadow-sm" role="alert">
                <h4 class="alert-heading">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Erro Detectado!
                </h4>
                <p class="mb-3"><strong>Mensagem:</strong> ${mensagem}</p>
                <hr>
                <div class="mb-3">
                    <h5><i class="bi bi-list-check me-2"></i>Verificações:</h5>
                    <ol class="mb-0">
                        <li>O servidor PHP está rodando?</li>
                        <li>O caminho da API está correto?<br>
                            <code class="text-dark">${API_URL}</code>
                        </li>
                        <li>O banco de dados está configurado?</li>
                        <li>As tabelas existem no banco?</li>
                        <li>O arquivo de configuração existe?</li>
                    </ol>
                </div>
                <div class="d-grid gap-2 d-md-flex">
                    <button class="btn btn-primary" onclick="testarAPI()">
                        <i class="bi bi-lightning-fill me-2"></i>Testar API
                    </button>
                    <button class="btn btn-secondary" onclick="location.reload()">
                        <i class="bi bi-arrow-clockwise me-2"></i>Recarregar
                    </button>
                    <a href="${API_URL}?tipo=stats_gerais" target="_blank" class="btn btn-info">
                        <i class="bi bi-box-arrow-up-right me-2"></i>Abrir API
                    </a>
                </div>
            </div>
        </div>
    `;
}

// Testar API
async function testarAPI() {
    log('🧪 Executando teste manual da API...', 'info');
    
    try {
        mostrarNotificacao('Teste em andamento...', 'Testando conexão com API', 'info');
        
        const response = await fetch(`${API_URL}?tipo=stats_gerais`);
        const data = await response.json();
        
        log('📊 Resposta do teste:', 'debug');
        console.table(data);
        
        if (data.sucesso) {
            mostrarNotificacao('Sucesso!', 'API está funcionando corretamente!', 'success');
            alert('✅ API FUNCIONANDO!\n\n' + JSON.stringify(data, null, 2));
            inicializarDashboard(); // Tentar carregar novamente
        } else {
            mostrarNotificacao('Erro!', data.mensagem || 'API retornou erro', 'error');
            alert('❌ API retornou erro:\n\n' + (data.mensagem || 'Erro desconhecido'));
        }
    } catch (erro) {
        log(`❌ Falha no teste: ${erro.message}`, 'error');
        mostrarNotificacao('Erro!', 'Falha ao testar: ' + erro.message, 'error');
        alert('❌ Não foi possível conectar:\n\n' + erro.message);
    }
}

// Carregar estatísticas
async function carregarStats() {
    log('📊 Carregando estatísticas gerais...', 'info');
    
    try {
        const resposta = await fetch(`${API_URL}?tipo=stats_gerais`);
        
        if (!resposta.ok) {
            throw new Error(`HTTP ${resposta.status}: ${resposta.statusText}`);
        }
        
        const data = await resposta.json();
        log('✅ Estatísticas recebidas', 'success');
        
        if (data.sucesso && data.dados && data.dados.length > 0) {
            renderizarStats(data.dados[0]);
        } else if (data.erro) {
            throw new Error(data.mensagem || 'Erro desconhecido');
        } else {
            log('⚠️ Resposta sem dados', 'warning');
            renderizarStatsPadrao();
        }
        
    } catch (erro) {
        log(`❌ Erro ao carregar stats: ${erro.message}`, 'error');
        const container = document.getElementById('stats-cards');
        if (container) {
            container.innerHTML = `
                <div class="col-12">
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Erro ao carregar estatísticas: ${erro.message}
                    </div>
                </div>
            `;
        }
    }
}

// Exibir stats padrão
function renderizarStatsPadrao() {
    const stats = {
        usuarios_ativos: 0,
        treinos_ativos: 0,
        aulas_futuras: 0,
        pagamentos_atrasados: 0,
        receita_mes: 0
    };
    renderizarStats(stats);
}

// Renderizar estatísticas
function renderizarStats(stats) {
    log('🎨 Renderizando estatísticas na tela...', 'debug');
    
    const container = document.getElementById('stats-cards');
    if (!container) {
        log('❌ Container stats-cards não encontrado!', 'error');
        return;
    }
    
    const html = `
        <div class="col-lg col-md-6 mb-3">
            <div class="card stat-card shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-people-fill text-primary" style="font-size: 2rem;"></i>
                    <div class="stat-number">${stats.usuarios_ativos || 0}</div>
                    <h6 class="text-muted mb-0">Usuários Ativos</h6>
                </div>
            </div>
        </div>
        <div class="col-lg col-md-6 mb-3">
            <div class="card stat-card shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-lightning-fill text-warning" style="font-size: 2rem;"></i>
                    <div class="stat-number">${stats.treinos_ativos || 0}</div>
                    <h6 class="text-muted mb-0">Treinos Ativos</h6>
                </div>
            </div>
        </div>
        <div class="col-lg col-md-6 mb-3">
            <div class="card stat-card shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-calendar-event text-success" style="font-size: 2rem;"></i>
                    <div class="stat-number">${stats.aulas_futuras || 0}</div>
                    <h6 class="text-muted mb-0">Aulas Futuras</h6>
                </div>
            </div>
        </div>
        <div class="col-lg col-md-6 mb-3">
            <div class="card stat-card shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-exclamation-triangle-fill ${stats.pagamentos_atrasados > 0 ? 'text-danger' : 'text-success'}" style="font-size: 2rem;"></i>
                    <div class="stat-number" style="color: ${stats.pagamentos_atrasados > 0 ? '#dc3545' : '#28a745'}">
                        ${stats.pagamentos_atrasados || 0}
                    </div>
                    <h6 class="text-muted mb-0">Pagamentos Atrasados</h6>
                </div>
            </div>
        </div>
        <div class="col-lg col-md-6 mb-3">
            <div class="card stat-card shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-cash-stack text-success" style="font-size: 2rem;"></i>
                    <div class="stat-number" style="font-size: 1.8rem;">
                        R$ ${parseFloat(stats.receita_mes || 0).toFixed(2)}
                    </div>
                    <h6 class="text-muted mb-0">Receita do Mês</h6>
                </div>
            </div>
        </div>
    `;
    
    container.innerHTML = html;
    log('✅ Estatísticas renderizadas!', 'success');
}

// Carregar gráficos
async function carregarGraficos() {
    log('📈 Carregando gráficos...', 'info');
    
    await Promise.all([
        carregarGraficoPlanos(),
        carregarGraficoTreinos(),
        carregarGraficoGrupos()
    ]);
    
    log('✅ Gráficos carregados!', 'success');
}

// Gráfico de planos
async function carregarGraficoPlanos() {
    try {
        log('📊 Carregando gráfico de planos...', 'debug');
        const resposta = await fetch(`${API_URL}?tipo=planos_distribuicao`);
        const data = await resposta.json();
        
        if (data.sucesso && data.dados && data.dados.length > 0) {
            const labels = data.dados.map(d => d.plano);
            const valores = data.dados.map(d => parseInt(d.total));
            
            criarGraficoPizza('graficoPlanos', labels, valores);
            log('✅ Gráfico de planos criado', 'success');
        } else {
            log('⚠️ Sem dados para gráfico de planos', 'warning');
        }
    } catch (erro) {
        log(`❌ Erro no gráfico de planos: ${erro.message}`, 'error');
    }
}

// Gráfico de treinos
async function carregarGraficoTreinos() {
    try {
        log('📊 Carregando gráfico de treinos...', 'debug');
        const resposta = await fetch(`${API_URL}?tipo=treinos_mes&meses=6`);
        const data = await resposta.json();
        
        if (data.sucesso && data.dados && data.dados.length > 0) {
            const labels = data.dados.map(d => d.mes);
            const valores = data.dados.map(d => parseInt(d.total));
            
            criarGraficoLinha('graficoTreinos', labels, valores);
            log('✅ Gráfico de treinos criado', 'success');
        } else {
            log('⚠️ Sem dados para gráfico de treinos', 'warning');
        }
    } catch (erro) {
        log(`❌ Erro no gráfico de treinos: ${erro.message}`, 'error');
    }
}

// Gráfico de grupos musculares
async function carregarGraficoGrupos() {
    try {
        log('📊 Carregando gráfico de grupos musculares...', 'debug');
        const resposta = await fetch(`${API_URL}?tipo=grupos_musculares`);
        const data = await resposta.json();
        
        if (data.sucesso && data.dados && data.dados.length > 0) {
            const labels = data.dados.map(d => d.grupo);
            const valores = data.dados.map(d => parseInt(d.pontos_totais));
            
            criarGraficoBarra('graficoGrupos', labels, valores);
            log('✅ Gráfico de grupos musculares criado', 'success');
        } else {
            log('⚠️ Sem dados para gráfico de grupos', 'warning');
        }
    } catch (erro) {
        log(`❌ Erro no gráfico de grupos: ${erro.message}`, 'error');
    }
}

// Funções de criação de gráficos
function criarGraficoPizza(canvasId, labels, dados) {
    const ctx = document.getElementById(canvasId);
    if (!ctx) {
        log(`⚠️ Canvas ${canvasId} não encontrado`, 'warning');
        return;
    }
    
    if (graficos[canvasId]) {
        graficos[canvasId].destroy();
    }
    
    graficos[canvasId] = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: dados,
                backgroundColor: [
                    '#e35c38',
                    '#4CAF50',
                    '#2196F3',
                    '#FFC107',
                    '#9C27B0'
                ],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
}

function criarGraficoLinha(canvasId, labels, dados) {
    const ctx = document.getElementById(canvasId);
    if (!ctx) {
        log(`⚠️ Canvas ${canvasId} não encontrado`, 'warning');
        return;
    }
    
    if (graficos[canvasId]) {
        graficos[canvasId].destroy();
    }
    
    graficos[canvasId] = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total de Treinos',
                data: dados,
                borderColor: '#4CAF50',
                backgroundColor: 'rgba(76, 175, 80, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
}

function criarGraficoBarra(canvasId, labels, dados) {
    const ctx = document.getElementById(canvasId);
    if (!ctx) {
        log(`⚠️ Canvas ${canvasId} não encontrado`, 'warning');
        return;
    }
    
    if (graficos[canvasId]) {
        graficos[canvasId].destroy();
    }
    
    graficos[canvasId] = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Pontos Totais',
                data: dados,
                backgroundColor: '#e35c38',
                borderColor: '#c44a2c',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

// Carregar tabelas
async function carregarTabelas() {
    log('📋 Carregando tabelas...', 'info');
    
    await Promise.all([
        carregarTabelaAcessos(),
        carregarTabelaExercicios(),
        carregarTabelaUsuarios(),
        carregarTabelaAulas()
    ]);
    
    log('✅ Tabelas carregadas!', 'success');
}

async function carregarTabelaAcessos() {
    try {
        log('📋 Carregando tabela de acessos...', 'debug');
        const resposta = await fetch(`${API_URL}?tipo=ultimos_acessos&limite=10`);
        const data = await resposta.json();
        
        if (data.sucesso && data.dados) {
            const html = criarTabela(data.dados, [
                { campo: 'nome', titulo: 'Nome' },
                { campo: 'data_hora', titulo: 'Data/Hora', formato: formatarDataHora },
                { campo: 'tipo', titulo: 'Tipo' },
                { campo: 'status', titulo: 'Status', formato: formatarStatus }
            ]);
            
            document.getElementById('tabela-acessos').innerHTML = html;
            log('✅ Tabela de acessos carregada', 'success');
        }
    } catch (erro) {
        log(`❌ Erro na tabela de acessos: ${erro.message}`, 'error');
        document.getElementById('tabela-acessos').innerHTML = '<div class="p-3 text-center text-muted">Erro ao carregar</div>';
    }
}

async function carregarTabelaExercicios() {
    try {
        log('📋 Carregando tabela de exercícios...', 'debug');
        const resposta = await fetch(`${API_URL}?tipo=exercicios_populares&limite=10`);
        const data = await resposta.json();
        
        if (data.sucesso && data.dados) {
            const html = criarTabela(data.dados, [
                { campo: 'exercicio', titulo: 'Exercício' },
                { campo: 'tipo', titulo: 'Tipo' },
                { campo: 'vezes_usado', titulo: 'Usos', formato: (v) => `<span class="badge bg-primary">${v}</span>` }
            ]);
            
            document.getElementById('tabela-exercicios').innerHTML = html;
            log('✅ Tabela de exercícios carregada', 'success');
        }
    } catch (erro) {
        log(`❌ Erro na tabela de exercícios: ${erro.message}`, 'error');
        document.getElementById('tabela-exercicios').innerHTML = '<div class="p-3 text-center text-muted">Erro ao carregar</div>';
    }
}

async function carregarTabelaUsuarios() {
    try {
        log('📋 Carregando tabela de usuários...', 'debug');
        const resposta = await fetch(`${API_URL}?tipo=usuarios_ativos&limite=10`);
        const data = await resposta.json();
        
        if (data.sucesso && data.dados) {
            const html = criarTabela(data.dados, [
                { campo: 'nome', titulo: 'Nome' },
                { campo: 'plano', titulo: 'Plano' },
                { campo: 'treinos_feitos', titulo: 'Treinos', formato: (v) => `<span class="badge" style="background-color: #e35c38;">${v}</span>` }
            ]);
            
            document.getElementById('tabela-usuarios').innerHTML = html;
            log('✅ Tabela de usuários carregada', 'success');
        }
    } catch (erro) {
        log(`❌ Erro na tabela de usuários: ${erro.message}`, 'error');
        document.getElementById('tabela-usuarios').innerHTML = '<div class="p-3 text-center text-muted">Erro ao carregar</div>';
    }
}

async function carregarTabelaAulas() {
    try {
        log('📋 Carregando tabela de aulas...', 'debug');
        const resposta = await fetch(`${API_URL}?tipo=aulas_proximas&limite=8`);
        const data = await resposta.json();
        
        if (data.sucesso && data.dados) {
            const html = criarTabela(data.dados, [
                { campo: 'aula', titulo: 'Aula' },
                { campo: 'tipo', titulo: 'Tipo' },
                { campo: 'data', titulo: 'Data', formato: formatarData },
                { campo: 'hora', titulo: 'Hora' },
                { campo: 'vagas', titulo: 'Vagas', formato: (v) => `<span class="badge bg-info">${v}</span>` }
            ]);
            
            document.getElementById('tabela-aulas').innerHTML = html;
            log('✅ Tabela de aulas carregada', 'success');
        }
    } catch (erro) {
        log(`❌ Erro na tabela de aulas: ${erro.message}`, 'error');
        document.getElementById('tabela-aulas').innerHTML = '<div class="p-3 text-center text-muted">Erro ao carregar</div>';
    }
}

// Criar tabela
function criarTabela(dados, colunas) {
    if (!dados || dados.length === 0) {
        return '<div class="text-center p-4"><p class="text-muted">Sem dados disponíveis</p></div>';
    }
    
    let html = '<table class="table table-hover table-sm mb-0"><thead class="table-light"><tr>';
    
    colunas.forEach(col => {
        html += `<th>${col.titulo}</th>`;
    });
    
    html += '</tr></thead><tbody>';
    
    dados.forEach(row => {
        html += '<tr>';
        colunas.forEach(col => {
            let valor = row[col.campo];
            if (col.formato) {
                valor = col.formato(valor);
            }
            html += `<td>${valor || '--'}</td>`;
        });
        html += '</tr>';
    });
    
    html += '</tbody></table>';
    return html;
}

// Funções de formatação
function formatarDataHora(valor) {
    if (!valor) return '--';
    try {
        const data = new Date(valor);
        return data.toLocaleString('pt-BR');
    } catch (e) {
        return valor;
    }
}

function formatarData(valor) {
    if (!valor) return '--';
    try {
        const data = new Date(valor);
        return data.toLocaleDateString('pt-BR');
    } catch (e) {
        return valor;
    }
}

function formatarStatus(valor) {
    if (!valor) return '--';
    const classe = valor === 'PERMITIDO' ? 'status-permitido' : 'status-negado';
    return `<span class="status-badge ${classe}">${valor}</span>`;
}

// Funções utilitárias
function atualizarDashboard() {
    log('🔄 Atualizando dashboard...', 'info');
    mostrarNotificacao('Atualização em andamento...', 'Recarregando dados', 'info');
    inicializarDashboard();
}

function atualizarUltimaAtualizacao() {
    const agora = new Date();
    const elemento = document.getElementById('ultima-atualizacao');
    if (elemento) {
        elemento.textContent = agora.toLocaleTimeString('pt-BR');
    }
}

function atualizarHorario() {
    atualizarUltimaAtualizacao();
}

function mostrarNotificacao(titulo = 'Notificação', mensagem = '', tipo = 'info') {
    // Validação robusta
    if (!tipo || typeof tipo !== 'string') tipo = 'info';
    if (!titulo) titulo = 'Notificação';
    if (!mensagem) mensagem = '';
    
    const tipoUpper = tipo.toUpperCase();
    const icones = {
        'SUCCESS': '✅',
        'ERROR': '❌',
        'WARNING': '⚠️',
        'INFO': 'ℹ️'
    };
    
    const icone = icones[tipoUpper] || 'ℹ️';
    console.log(`${icone} [${tipoUpper}] ${titulo}: ${mensagem}`);
}

// Exportar funções para uso global
window.inicializarDashboard = inicializarDashboard;
window.atualizarDashboard = atualizarDashboard;
window.testarAPI = testarAPI;

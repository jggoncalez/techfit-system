// API設定 (API settei - Configuração da API)
const API_URL = '../../api/dashApi.php';

// グローバル変数 (gurōbaru hensu - Variáveis globais)
let graficos = {};

// 初期化 (shokika - Inicialização)
document.addEventListener('DOMContentLoaded', function() {
    inicializarDashboard();
    atualizarHorario();
    setInterval(atualizarHorario, 60000); // 1分ごと (1 minuto)
});

// ダッシュボード初期化 (dasshubōdo shokika - Inicializar dashboard)
async function inicializarDashboard() {
    console.log("Inicializando dashboard")
    try {
        await Promise.all([
            carregarStats(),
            carregarGraficos(),
            carregarTabelas()
        ]);
        
        atualizarUltimaAtualizacao();
        mostrarNotificacao('成功! (Sucesso!)', 'Dashboard carregado com sucesso', 'success');
    } catch (erro) {
        console.error('エラー! (Erro!):', erro);
        mostrarNotificacao('エラー! (Erro!)', 'Falha ao carregar dashboard', 'danger');
    }
}

// 統計読み込み (tōkei yomikomi - Carregar estatísticas)
async function carregarStats() {
    try {
        const resposta = await fetch(`${API_URL}?tipo=stats_gerais`);
        const data = await resposta.json();
        
        if (data.sucesso && data.dados && data.dados.length > 0) {
            const stats = data.dados[0];
            renderizarStats(stats);
        }
    } catch (erro) {
        console.error('Stats エラー:', erro);
    }
}

// 統計表示 (tōkei hyōji - Renderizar estatísticas)
function renderizarStats(stats) {
    const container = document.getElementById('stats-cards');
    
    const html = `
        <div class="col-lg col-md-6 mb-3">
            <div class="card stat-card shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-people-fill text-primary" style="font-size: 2rem;"></i>
                    <div class="stat-number">${stats.usuarios_ativos || 0}</div>
                    <h6 class="text-muted mb-0">Usuários Ativos</h6>
                    <small class="text-muted">アクティブユーザー</small>
                </div>
            </div>
        </div>
        <div class="col-lg col-md-6 mb-3">
            <div class="card stat-card shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-lightning-fill text-warning" style="font-size: 2rem;"></i>
                    <div class="stat-number">${stats.treinos_ativos || 0}</div>
                    <h6 class="text-muted mb-0">Treinos Ativos</h6>
                    <small class="text-muted">アクティブトレーニング</small>
                </div>
            </div>
        </div>
        <div class="col-lg col-md-6 mb-3">
            <div class="card stat-card shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-calendar-event text-success" style="font-size: 2rem;"></i>
                    <div class="stat-number">${stats.aulas_futuras || 0}</div>
                    <h6 class="text-muted mb-0">Aulas Futuras</h6>
                    <small class="text-muted">今後のクラス</small>
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
                    <small class="text-muted">遅延支払い</small>
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
                    <small class="text-muted">月収</small>
                </div>
            </div>
        </div>
    `;
    
    container.innerHTML = html;
}

// グラフ読み込み (gurafu yomikomi - Carregar gráficos)
async function carregarGraficos() {
    await Promise.all([
        carregarGraficoPlanos(),
        carregarGraficoTreinos(),
        carregarGraficoGrupos()
    ]);
}

// プラングラフ (puran gurafu - Gráfico de planos)
async function carregarGraficoPlanos() {
    try {
        const resposta = await fetch(`${API_URL}?tipo=planos_distribuicao`);
        const data = await resposta.json();
        
        if (data.sucesso && data.dados) {
            const labels = data.dados.map(d => d.plano);
            const valores = data.dados.map(d => d.total);
            
            criarGraficoPizza('graficoPlanos', labels, valores);
        }
    } catch (erro) {
        console.error('Planos エラー:', erro);
    }
}

// トレーニンググラフ (torēningu gurafu - Gráfico de treinos)
async function carregarGraficoTreinos() {
    try {
        const resposta = await fetch(`${API_URL}?tipo=treinos_mes&meses=6`);
        const data = await resposta.json();
        
        if (data.sucesso && data.dados) {
            const labels = data.dados.map(d => d.mes);
            const valores = data.dados.map(d => d.total);
            
            criarGraficoLinha('graficoTreinos', labels, valores);
        }
    } catch (erro) {
        console.error('Treinos エラー:', erro);
    }
}

// 筋肉グループグラフ (kiniku gurūpu gurafu - Gráfico de grupos musculares)
async function carregarGraficoGrupos() {
    try {
        const resposta = await fetch(`${API_URL}?tipo=grupos_musculares`);
        const data = await resposta.json();
        
        if (data.sucesso && data.dados) {
            const labels = data.dados.map(d => d.grupo);
            const valores = data.dados.map(d => d.pontos_totais);
            
            criarGraficoBarra('graficoGrupos', labels, valores);
        }
    } catch (erro) {
        console.error('Grupos エラー:', erro);
    }
}

// グラフ作成関数 (gurafu sakusei kansū - Funções de criação de gráficos)
function criarGraficoPizza(canvasId, labels, dados) {
    const ctx = document.getElementById(canvasId);
    if (!ctx) return;
    
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
    if (!ctx) return;
    
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
    if (!ctx) return;
    
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

// テーブル読み込み (tēburu yomikomi - Carregar tabelas)
async function carregarTabelas() {
    await Promise.all([
        carregarTabelaAcessos(),
        carregarTabelaExercicios(),
        carregarTabelaUsuarios(),
        carregarTabelaAulas()
    ]);
}

async function carregarTabelaAcessos() {
    try {
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
        }
    } catch (erro) {
        console.error('Acessos エラー:', erro);
    }
}

async function carregarTabelaExercicios() {
    try {
        const resposta = await fetch(`${API_URL}?tipo=exercicios_populares&limite=10`);
        const data = await resposta.json();
        
        if (data.sucesso && data.dados) {
            const html = criarTabela(data.dados, [
                { campo: 'exercicio', titulo: 'Exercício' },
                { campo: 'tipo', titulo: 'Tipo' },
                { campo: 'vezes_usado', titulo: 'Usos', formato: (v) => `<span class="badge bg-primary">${v}</span>` }
            ]);
            
            document.getElementById('tabela-exercicios').innerHTML = html;
        }
    } catch (erro) {
        console.error('Exercícios エラー:', erro);
    }
}

async function carregarTabelaUsuarios() {
    try {
        const resposta = await fetch(`${API_URL}?tipo=usuarios_ativos&limite=10`);
        const data = await resposta.json();
        
        if (data.sucesso && data.dados) {
            const html = criarTabela(data.dados, [
                { campo: 'nome', titulo: 'Nome' },
                { campo: 'plano', titulo: 'Plano' },
                { campo: 'treinos_feitos', titulo: 'Treinos', formato: (v) => `<span class="badge" style="background-color: #e35c38;">${v}</span>` }
            ]);
            
            document.getElementById('tabela-usuarios').innerHTML = html;
        }
    } catch (erro) {
        console.error('Usuários エラー:', erro);
    }
}

async function carregarTabelaAulas() {
    try {
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
        }
    } catch (erro) {
        console.error('Aulas エラー:', erro);
    }
}

// テーブル作成 (tēburu sakusei - Criar tabela)
function criarTabela(dados, colunas) {
    if (!dados || dados.length === 0) {
        return '<div class="text-center p-4"><p class="text-muted">データなし (Sem dados disponíveis)</p></div>';
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
            html += `<td>${valor}</td>`;
        });
        html += '</tr>';
    });
    
    html += '</tbody></table>';
    return html;
}

// フォーマット関数 (fōmatto kansū - Funções de formatação)
function formatarDataHora(valor) {
    if (!valor) return '--';
    const data = new Date(valor);
    return data.toLocaleString('pt-BR');
}

function formatarData(valor) {
    if (!valor) return '--';
    const data = new Date(valor);
    return data.toLocaleDateString('pt-BR');
}

function formatarStatus(valor) {
    const classe = valor === 'PERMITIDO' ? 'status-permitido' : 'status-negado';
    return `<span class="status-badge ${classe}">${valor}</span>`;
}

// ユーティリティ関数 (yūtiriti kansū - Funções utilitárias)
function atualizarDashboard() {
    mostrarNotificacao('更新中... (Atualizando...)', 'Recarregando dados do dashboard', 'info');
    inicializarDashboard();
}

function atualizarUltimaAtualizacao() {
    const agora = new Date();
    document.getElementById('ultima-atualizacao').textContent = agora.toLocaleTimeString('pt-BR');
}

function atualizarHorario() {
    atualizarUltimaAtualizacao();
}

function mostrarNotificacao(titulo, mensagem, tipo) {
    // Bootstrap toast implementation (opcional)
    console.log(`[${tipo.toUpperCase()}] ${titulo}: ${mensagem}`);
}
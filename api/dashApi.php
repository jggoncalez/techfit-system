<?php
// Configuração de cabeçalhos
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Processar requisição OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Incluir arquivos necessários
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/dashboard/DashboardModel.php';

use config\Database;
use models\dashboard\DashboardModel;

try {
    // Obter conexão singleton
    $database = Database::getInstance();
    $db = $database->getConnection();
    
    // Inicializar model
    $dashboardModel = new DashboardModel($db);
    
    // Obter parâmetros
    $tipo = $_GET['tipo'] ?? '';
    $limite = isset($_GET['limite']) ? (int)$_GET['limite'] : 10;
    
    // Array de resposta
    $response = array();
    $stmt = null;
    
    // Roteamento
    switch($tipo) {
        case 'ultimos_acessos':
            $stmt = $dashboardModel->getUltimosAcessos($limite);
            break;
            
        case 'exercicios_populares':
            $stmt = $dashboardModel->getExerciciosPopulares($limite);
            break;
            
        case 'usuarios_ativos':
            $stmt = $dashboardModel->getUsuariosAtivos($limite);
            break;
            
        case 'aulas_proximas':
            $stmt = $dashboardModel->getAulasProximas($limite);
            break;
            
        case 'stats_gerais':
            $stmt = $dashboardModel->getStatsGerais();
            break;
            
        case 'planos_distribuicao':
            $stmt = $dashboardModel->getPlanosDistribuicao();
            break;
            
        case 'treinos_mes':
            $meses = isset($_GET['meses']) ? (int)$_GET['meses'] : 6;
            $stmt = $dashboardModel->getTreinosPorMes($meses);
            break;
            
        case 'grupos_musculares':
            $stmt = $dashboardModel->getGruposMusculares();
            break;
            
        case 'stats_periodo':
            $dataInicio = $_GET['data_inicio'] ?? date('Y-m-01');
            $dataFim = $_GET['data_fim'] ?? date('Y-m-d');
            $stmt = $dashboardModel->getStatsPorPeriodo($dataInicio, $dataFim);
            break;
            
        case 'planos_receita':
            $stmt = $dashboardModel->getPlanosReceita();
            break;
            
        case 'relatorio_completo':
            // Relatório completo
            $response = array(
                'sucesso' => true,
                'timestamp' => date('Y-m-d H:i:s'),
                'dados' => array(
                    'stats_gerais' => $dashboardModel->getStatsGerais()->fetch(PDO::FETCH_ASSOC),
                    'planos' => $dashboardModel->getPlanosDistribuicao()->fetchAll(PDO::FETCH_ASSOC),
                    'exercicios_top' => $dashboardModel->getExerciciosPopulares(5)->fetchAll(PDO::FETCH_ASSOC),
                    'usuarios_top' => $dashboardModel->getUsuariosAtivos(5)->fetchAll(PDO::FETCH_ASSOC),
                    'aulas_proximas' => $dashboardModel->getAulasProximas(5)->fetchAll(PDO::FETCH_ASSOC),
                    'planos_receita' => $dashboardModel->getPlanosReceita()->fetchAll(PDO::FETCH_ASSOC)
                )
            );
            
            http_response_code(200);
            echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            exit();
            
        default:
            http_response_code(400);
            echo json_encode(array(
                "sucesso" => false,
                "erro" => "Parâmetro inválido",
                "mensagem" => "Tipo '{$tipo}' não reconhecido",
                "tipos_disponiveis" => [
                    'ultimos_acessos',
                    'exercicios_populares', 
                    'usuarios_ativos',
                    'aulas_proximas',
                    'stats_gerais',
                    'planos_distribuicao',
                    'treinos_mes',
                    'grupos_musculares',
                    'stats_periodo',
                    'planos_receita',
                    'relatorio_completo'
                ]
            ), JSON_UNESCAPED_UNICODE);
            exit();
    }
    
    // Processar dados
    if($stmt !== null) {
        $dados = array();
        
        if($stmt->rowCount() > 0) {
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $dados[] = $row;
            }
            
            // Resposta de sucesso
            $response = array(
                'sucesso' => true,
                'total' => count($dados),
                'dados' => $dados
            );
            
            http_response_code(200);
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
        } else {
            // Sem dados
            http_response_code(200);
            echo json_encode(array(
                'sucesso' => true,
                'total' => 0,
                'dados' => array(),
                'mensagem' => 'Nenhum dado encontrado'
            ), JSON_UNESCAPED_UNICODE);
        }
    }
    
} catch(\PDOException $e) {
    // Erro de banco de dados
    http_response_code(500);
    echo json_encode(array(
        "sucesso" => false,
        "erro" => "Erro de banco de dados",
        "mensagem" => $e->getMessage()
    ), JSON_UNESCAPED_UNICODE);
    
} catch(\Exception $e) {
    // Erro geral
    http_response_code(500);
    echo json_encode(array(
        "sucesso" => false,
        "erro" => "Erro no servidor",
        "mensagem" => $e->getMessage()
    ), JSON_UNESCAPED_UNICODE);
}
?>
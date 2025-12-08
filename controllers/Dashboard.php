<?php

namespace controllers\sagef;

require_once __DIR__ . "\\..\\..\\models\\Dashboard.php";
require_once __DIR__ . "\\..\\..\\config\\Database.php";

use models\Dashboard;
use config\Database;

class DashboardController
{
    private $db;
    private $dao;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
        $this->dao = new Dashboard($this->db);
    }

    // Obter últimos acessos
    public function getUltimosAcessos($limite = 10)
    {
        return $this->dao->getUltimosAcessos($limite);
    }

    // Obter exercícios populares
    public function getExerciciosPopulares($limite = 10)
    {
        return $this->dao->getExerciciosPopulares($limite);
    }

    // Obter usuários ativos
    public function getUsuariosAtivos($limite = 10)
    {
        return $this->dao->getUsuariosAtivos($limite);
    }

    // Obter próximas aulas
    public function getAulasProximas($limite = 8)
    {
        return $this->dao->getAulasProximas($limite);
    }

    // Obter estatísticas gerais
    public function getStatsGerais()
    {
        return $this->dao->getStatsGerais();
    }

    // Obter distribuição de planos
    public function getPlanosDistribuicao()
    {
        return $this->dao->getPlanosDistribuicao();
    }

    // Obter treinos por mês
    public function getTreinosPorMes($meses = 6)
    {
        return $this->dao->getTreinosPorMes($meses);
    }

    // Obter grupos musculares
    public function getGruposMusculares()
    {
        return $this->dao->getGruposMusculares();
    }

    // Estatísticas com filtro de período
    public function getStatsPorPeriodo($dataInicio, $dataFim)
    {
        return $this->dao->getStatsPorPeriodo($dataInicio, $dataFim);
    }

    // Planos com maior receita
    public function getPlanosReceita()
    {
        return $this->dao->getPlanosReceita();
    }

    // Lista com paginação
    public function getAcessosPaginados($pagina = 1, $itensPorPagina = 10)
    {
        return $this->dao->getAcessosPaginados($pagina, $itensPorPagina);
    }

    // Estatísticas por tipo de exercício
    public function getExerciciosPorTipo()
    {
        return $this->dao->getExerciciosPorTipo();
    }

    // Situação de pagamentos
    public function getPagamentosPorStatus()
    {
        return $this->dao->getPagamentosPorStatus();
    }

    // Taxa de conclusão de treinos
    public function getTreinosCompletados()
    {
        return $this->dao->getTreinosCompletados();
    }

    // Tipos de aulas mais populares
    public function getAulasMaisPopulares()
    {
        return $this->dao->getAulasMaisPopulares();
    }

    // Estatísticas de instrutores
    public function getInstrutoresMaisAtivos()
    {
        return $this->dao->getInstrutoresMaisAtivos();
    }

    // Método auxiliar para formatar dados de estatísticas gerais
    public function getStatsGeraisFormatado()
    {
        $stmt = $this->getStatsGerais();
        $stats = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if ($stats) {
            return [
                'usuarios_ativos' => (int)$stats['usuarios_ativos'],
                'aulas_futuras' => (int)$stats['aulas_futuras'],
                'treinos_ativos' => (int)$stats['treinos_ativos'],
                'pagamentos_atrasados' => (int)$stats['pagamentos_atrasados'],
                'receita_mes' => number_format((float)$stats['receita_mes'], 2, ',', '.')
            ];
        }
        
        return null;
    }

    // Método auxiliar para obter dados formatados para gráficos
    public function getDadosGraficoTreinos($meses = 6)
    {
        $stmt = $this->getTreinosPorMes($meses);
        $dados = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        $labels = [];
        $values = [];
        
        foreach ($dados as $row) {
            $labels[] = date('M/Y', strtotime($row['mes'] . '-01'));
            $values[] = (int)$row['total'];
        }
        
        return [
            'labels' => $labels,
            'values' => $values
        ];
    }

    // Método auxiliar para obter dados formatados de planos
    public function getDadosGraficoPlanos()
    {
        $stmt = $this->getPlanosDistribuicao();
        $dados = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        $labels = [];
        $values = [];
        
        foreach ($dados as $row) {
            $labels[] = $row['plano'];
            $values[] = (int)$row['total'];
        }
        
        return [
            'labels' => $labels,
            'values' => $values
        ];
    }
}

?>
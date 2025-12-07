<?php
namespace models;
use PDO;

class Dashboard {
    // Conexão do banco de dados
    private $conn;
    
    // Construtor
    public function __construct(PDO $db) {
        $this->conn = $db;
    }
    
    // Obter últimos acessos
    public function getUltimosAcessos(int $limite = 10) {
        $query = "SELECT 
                    u.US_NOME as nome,
                    re.RE_DATA_HORA as data_hora,
                    re.RE_TIPO_ENTRADA as tipo,
                    re.RE_STATUS as status
                FROM registro_entradas re
                INNER JOIN usuarios u ON re.US_ID = u.US_ID
                ORDER BY re.RE_DATA_HORA DESC
                LIMIT :limite";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt;
    }
    
    // Obter exercícios populares
    public function getExerciciosPopulares(int $limite = 10) {
        $query = "SELECT 
                    e.EX_NOME as exercicio,
                    e.EX_TIPO as tipo,
                    COUNT(te.TE_ID) as vezes_usado
                FROM treino_exercicios te
                INNER JOIN exercicios e ON te.EX_ID = e.EX_ID
                GROUP BY e.EX_ID, e.EX_NOME, e.EX_TIPO
                ORDER BY vezes_usado DESC
                LIMIT :limite";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt;
    }
    
    // Obter usuários ativos
    public function getUsuariosAtivos(int $limite = 10) {
        $query = "SELECT 
                    u.US_NOME as nome,
                    p.PL_NOME as plano,
                    COUNT(t.TR_ID) as treinos_feitos
                FROM usuarios u
                INNER JOIN planos p ON u.PL_ID = p.PL_ID
                LEFT JOIN treinos t ON u.US_ID = t.US_ID
                WHERE u.US_STATUS_PAGAMENTO = 'EM_DIA'
                GROUP BY u.US_ID, u.US_NOME, p.PL_NOME
                ORDER BY treinos_feitos DESC
                LIMIT :limite";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt;
    }
    
    // Obter próximas aulas
    public function getAulasProximas(int $limite = 8) {
        $query = "SELECT 
                    a.AU_NOME as aula,
                    a.AU_TIPO as tipo,
                    a.AU_DATA as data,
                    a.AU_HORA_INICIO as hora,
                    a.AU_VAGAS_DISPONIVEIS as vagas,
                    f.FU_NOME as instrutor
                FROM aulas a
                INNER JOIN funcionarios f ON a.FU_ID = f.FU_ID
                WHERE a.AU_DATA >= CURDATE() AND a.AU_STATUS = 'AGENDADA'
                ORDER BY a.AU_DATA, a.AU_HORA_INICIO
                LIMIT :limite";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt;
    }
    
    // Obter estatísticas gerais
    public function getStatsGerais() {
        $query = "SELECT 
                    (SELECT COUNT(*) FROM usuarios WHERE US_STATUS_PAGAMENTO = 'EM_DIA') as usuarios_ativos,
                    (SELECT COUNT(*) FROM aulas WHERE AU_DATA >= CURDATE()) as aulas_futuras,
                    (SELECT COUNT(*) FROM pagamentos WHERE PG_STATUS = 'ATRASADO') as pagamentos_atrasados,
                    (SELECT COALESCE(SUM(PG_VALOR), 0) FROM pagamentos 
                     WHERE PG_STATUS = 'PAGO' 
                     AND MONTH(PG_DATA_PAGAMENTO) = MONTH(CURDATE())
                     AND YEAR(PG_DATA_PAGAMENTO) = YEAR(CURDATE())) as receita_mes";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }
    
    // Obter distribuição de planos
    public function getPlanosDistribuicao() {
        $query = "SELECT 
                    p.PL_NOME as plano, 
                    COUNT(u.US_ID) as total
                FROM planos p
                LEFT JOIN usuarios u ON p.PL_ID = u.PL_ID
                GROUP BY p.PL_ID, p.PL_NOME
                ORDER BY total DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }
    
    // Obter treinos por mês
    public function getTreinosPorMes(int $meses = 6) {
        $query = "SELECT 
                    DATE_FORMAT(TR_DATA_CRIACAO, '%Y-%m') as mes,
                    COUNT(*) as total
                FROM treinos
                WHERE TR_DATA_CRIACAO >= DATE_SUB(CURDATE(), INTERVAL :meses MONTH)
                GROUP BY mes
                ORDER BY mes";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':meses', $meses, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt;
    }
    
    // Obter grupos musculares
    public function getGruposMusculares() {
        $query = "SELECT 
                    PT_GRUPO_MUSCULAR as grupo,
                    SUM(PT_PONTOS) as pontos_totais
                FROM pontuacao
                GROUP BY PT_GRUPO_MUSCULAR
                ORDER BY pontos_totais DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }
    
    // Estatísticas com filtro de período
    public function getStatsPorPeriodo(string $dataInicio, string $dataFim) {
        $query = "SELECT 
                    DATE(RE_DATA_HORA) as data,
                    COUNT(*) as total_acessos,
                    COUNT(DISTINCT US_ID) as usuarios_unicos
                FROM registro_entradas
                WHERE RE_DATA_HORA BETWEEN :data_inicio AND :data_fim
                AND RE_STATUS = 'PERMITIDO'
                GROUP BY DATE(RE_DATA_HORA)
                ORDER BY data";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':data_inicio', $dataInicio);
        $stmt->bindParam(':data_fim', $dataFim);
        $stmt->execute();
        
        return $stmt;
    }
    
    // Planos com maior receita
    public function getPlanosReceita() {
        $query = "SELECT 
                    pl.PL_NOME as plano,
                    pl.PL_PRECO as preco,
                    COUNT(u.US_ID) as total_usuarios,
                    (pl.PL_PRECO * COUNT(u.US_ID)) as receita_potencial
                FROM planos pl
                LEFT JOIN usuarios u ON pl.PL_ID = u.PL_ID
                WHERE u.US_STATUS_PAGAMENTO = 'EM_DIA'
                GROUP BY pl.PL_ID, pl.PL_NOME, pl.PL_PRECO
                ORDER BY receita_potencial DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }
    
    // Lista com paginação
    public function getAcessosPaginados(int $pagina = 1, int $itensPorPagina = 10) {
        $offset = ($pagina - 1) * $itensPorPagina;
        
        $query = "SELECT 
                    u.US_NOME as nome,
                    re.RE_DATA_HORA as data_hora,
                    re.RE_TIPO_ENTRADA as tipo,
                    re.RE_STATUS as status
                FROM registro_entradas re
                INNER JOIN usuarios u ON re.US_ID = u.US_ID
                ORDER BY re.RE_DATA_HORA DESC
                LIMIT :limite OFFSET :offset";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limite', $itensPorPagina, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt;
    }
    
    // Estatísticas por tipo de exercício
    public function getExerciciosPorTipo() {
        $query = "SELECT 
                    EX_TIPO as tipo,
                    COUNT(*) as total,
                    AVG(EX_DIFICULDADE) as dificuldade_media
                FROM exercicios
                GROUP BY EX_TIPO
                ORDER BY total DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }
    
    // Situação de pagamentos
    public function getPagamentosPorStatus() {
        $query = "SELECT 
                    PG_STATUS as status,
                    COUNT(*) as total,
                    SUM(PG_VALOR) as valor_total
                FROM pagamentos
                GROUP BY PG_STATUS
                ORDER BY total DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }
    
    // Taxa de conclusão de treinos
    public function getTreinosCompletados() {
        $query = "SELECT 
                    TR_STATUS as status,
                    COUNT(*) as total,
                    ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM treinos)), 2) as percentual
                FROM treinos
                GROUP BY TR_STATUS
                ORDER BY total DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }
    
    // Tipos de aulas mais populares
    public function getAulasMaisPopulares() {
        $query = "SELECT 
                    AU_TIPO as tipo,
                    COUNT(*) as total_aulas,
                    SUM(AU_VAGAS_TOTAIS - AU_VAGAS_DISPONIVEIS) as total_inscricoes,
                    ROUND(AVG((AU_VAGAS_TOTAIS - AU_VAGAS_DISPONIVEIS) * 100.0 / AU_VAGAS_TOTAIS), 2) as taxa_ocupacao
                FROM aulas
                WHERE AU_DATA >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
                GROUP BY AU_TIPO
                ORDER BY taxa_ocupacao DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }
    
    // Estatísticas de instrutores
    public function getInstrutoresMaisAtivos() {
        $query = "SELECT 
                    f.FU_NOME as instrutor,
                    COUNT(a.AU_ID) as total_aulas,
                    SUM(a.AU_VAGAS_TOTAIS - a.AU_VAGAS_DISPONIVEIS) as total_alunos
                FROM funcionarios f
                INNER JOIN aulas a ON f.FU_ID = a.FU_ID
                WHERE a.AU_DATA >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
                GROUP BY f.FU_ID, f.FU_NOME
                ORDER BY total_aulas DESC
                LIMIT 10";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }
}
?>
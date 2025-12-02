<?php
namespace models\dashboard;
use PDO;

class DashboardModel {
    // データベース接続 (dētabēsu setsuzoku - conexão do banco)
    private $conn;
    
    // コンストラクタ (konsutorakuta - construtor)
    public function __construct(PDO $db) {
        $this->conn = $db;
    }
    
    // 最新アクセス取得 (saishin akusesu shutoku - obter últimos acessos)
    public function getUltimosAcessos(int $limite = 10) {
        $query = "SELECT 
                    u.US_NOME as nome,
                    re.RE_DATA_HORA as data_hora,
                    re.RE_TIPO_ENTRADA as tipo,
                    re.RE_STATUS as status
                FROM REGISTRO_ENTRADAS re
                INNER JOIN USUARIOS u ON re.US_ID = u.US_ID
                ORDER BY re.RE_DATA_HORA DESC
                LIMIT :limite";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt;
    }
    
    // 人気エクササイズ取得 (ninki ekusasaizu shutoku - obter exercícios populares)
    public function getExerciciosPopulares(int $limite = 10) {
        $query = "SELECT 
                    e.EX_NOME as exercicio,
                    e.EX_TIPO as tipo,
                    COUNT(te.TE_ID) as vezes_usado
                FROM TREINO_EXERCICIOS te
                INNER JOIN EXERCICIOS e ON te.EX_ID = e.EX_ID
                GROUP BY e.EX_ID, e.EX_NOME, e.EX_TIPO
                ORDER BY vezes_usado DESC
                LIMIT :limite";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt;
    }
    
    // アクティブユーザー取得 (akutibu yūzā shutoku - obter usuários ativos)
    public function getUsuariosAtivos(int $limite = 10) {
        $query = "SELECT 
                    u.US_NOME as nome,
                    p.PL_NOME as plano,
                    COUNT(t.TR_ID) as treinos_feitos
                FROM USUARIOS u
                INNER JOIN PLANOS p ON u.PL_ID = p.PL_ID
                LEFT JOIN TREINOS t ON u.US_ID = t.US_ID
                WHERE u.US_STATUS_PAGAMENTO = 'EM_DIA'
                GROUP BY u.US_ID, u.US_NOME, p.PL_NOME
                ORDER BY treinos_feitos DESC
                LIMIT :limite";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt;
    }
    
    // 今後のクラス取得 (kongo no kurasu shutoku - obter próximas aulas)
    public function getAulasProximas(int $limite = 8) {
        $query = "SELECT 
                    a.AU_NOME as aula,
                    a.AU_TIPO as tipo,
                    a.AU_DATA as data,
                    a.AU_HORA_INICIO as hora,
                    a.AU_VAGAS_DISPONIVEIS as vagas,
                    f.FU_NOME as instrutor
                FROM AULAS a
                INNER JOIN FUNCIONARIOS f ON a.FU_ID = f.FU_ID
                WHERE a.AU_DATA >= CURDATE() AND a.AU_STATUS = 'AGENDADA'
                ORDER BY a.AU_DATA, a.AU_HORA_INICIO
                LIMIT :limite";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt;
    }
    
    // 統計取得 (tōkei shutoku - obter estatísticas gerais)
    public function getStatsGerais() {
        $query = "SELECT 
                    (SELECT COUNT(*) FROM USUARIOS WHERE US_STATUS_PAGAMENTO = 'EM_DIA') as usuarios_ativos,
                    (SELECT COUNT(*) FROM TREINOS WHERE TR_STATUS = 'ATIVO') as treinos_ativos,
                    (SELECT COUNT(*) FROM AULAS WHERE AU_DATA >= CURDATE()) as aulas_futuras,
                    (SELECT COUNT(*) FROM PAGAMENTOS WHERE PG_STATUS = 'ATRASADO') as pagamentos_atrasados,
                    (SELECT COALESCE(SUM(PG_VALOR), 0) FROM PAGAMENTOS 
                     WHERE PG_STATUS = 'PAGO' 
                     AND MONTH(PG_DATA_PAGAMENTO) = MONTH(CURDATE())
                     AND YEAR(PG_DATA_PAGAMENTO) = YEAR(CURDATE())) as receita_mes";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }
    
    // プラン分布取得 (puran bunpu shutoku - obter distribuição de planos)
    public function getPlanosDistribuicao() {
        $query = "SELECT 
                    p.PL_NOME as plano, 
                    COUNT(u.US_ID) as total
                FROM PLANOS p
                LEFT JOIN USUARIOS u ON p.PL_ID = u.PL_ID
                GROUP BY p.PL_ID, p.PL_NOME
                ORDER BY total DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }
    
    // 月別トレーニング取得 (tsukibetsu torēningu shutoku - obter treinos por mês)
    public function getTreinosPorMes(int $meses = 6) {
        $query = "SELECT 
                    DATE_FORMAT(TR_DATA_CRIACAO, '%Y-%m') as mes,
                    COUNT(*) as total
                FROM TREINOS
                WHERE TR_DATA_CRIACAO >= DATE_SUB(CURDATE(), INTERVAL :meses MONTH)
                GROUP BY mes
                ORDER BY mes";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':meses', $meses, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt;
    }
    
    // 筋肉グループ取得 (kiniku gurūpu shutoku - obter grupos musculares)
    public function getGruposMusculares() {
        $query = "SELECT 
                    PT_GRUPO_MUSCULAR as grupo,
                    SUM(PT_PONTOS) as pontos_totais
                FROM PONTUACAO
                GROUP BY PT_GRUPO_MUSCULAR
                ORDER BY pontos_totais DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }
    
    // 期間フィルター付き統計 (kikan firutā tsuki tōkei - estatísticas com filtro de período)
    public function getStatsPorPeriodo(string $dataInicio, string $dataFim) {
        $query = "SELECT 
                    DATE(RE_DATA_HORA) as data,
                    COUNT(*) as total_acessos,
                    COUNT(DISTINCT US_ID) as usuarios_unicos
                FROM REGISTRO_ENTRADAS
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
    
    // トップ収益プラン (toppu shūeki puran - planos com maior receita)
    public function getPlanosReceita() {
        $query = "SELECT 
                    pl.PL_NOME as plano,
                    pl.PL_PRECO as preco,
                    COUNT(u.US_ID) as total_usuarios,
                    (pl.PL_PRECO * COUNT(u.US_ID)) as receita_potencial
                FROM PLANOS pl
                LEFT JOIN USUARIOS u ON pl.PL_ID = u.PL_ID
                WHERE u.US_STATUS_PAGAMENTO = 'EM_DIA'
                GROUP BY pl.PL_ID, pl.PL_NOME, pl.PL_PRECO
                ORDER BY receita_potencial DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }
}
?>
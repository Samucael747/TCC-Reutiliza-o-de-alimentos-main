<?php
session_start();

if (!isset($_SESSION['nome'])) {
    header('Location: ../entrar.php?error=Voce+precisa+logar+primeiro');
    exit;
}

require_once __DIR__ . '/includes/conexao.php';

$paginaAtiva = 'conquistas';
$pageTitle   = 'Conquistas | FomeOff';
$extra_head  = <<<'HTML'
    <link rel="stylesheet" href="../css/home.css" />
    <style>
        .rank-hero {
            padding: 48px 0 24px;
        }
        .rank-hero h1 {
            font-size: clamp(2.5rem, 4vw, 3.5rem);
            margin-bottom: 18px;
        }
        .rank-hero p {
            max-width: 760px;
            line-height: 1.8;
            color: #4B5563;
            margin-bottom: 28px;
        }

        .rank-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 24px;
            margin-top: 18px;
        }

        .rank-card {
            background: white;
            border-radius: 32px;
            padding: 28px;
            box-shadow: 0 28px 70px rgba(15, 23, 42, 0.08);
            border: 1px solid rgba(243, 244, 246, 0.9);
        }

        .rank-card h3 {
            margin: 0 0 8px;
            font-size: 1.4rem;
            color: #111827;
        }

        .rank-card .position {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            border-radius: 16px;
            background: #fef3c7;
            color: #92400e;
            font-weight: 800;
            margin-bottom: 16px;
        }

        .rank-card .score {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin: 18px 0;
            padding: 18px;
            border-radius: 24px;
            background: #f8fafc;
            color: #0f172a;
            font-weight: 700;
        }

        .metric-list {
            list-style: none;
            margin: 0;
            padding: 0;
            display: grid;
            gap: 10px;
        }

        .metric-list li {
            display: flex;
            justify-content: space-between;
            color: #475569;
            font-size: 0.97rem;
        }

        .badge-list {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
            margin-top: 30px;
        }

        .badge-card {
            background: #fff7ed;
            border-radius: 24px;
            padding: 22px;
            border: 1px solid rgba(251, 191, 36, 0.25);
        }

        .badge-card h4 {
            margin: 0 0 10px;
            font-size: 1.05rem;
            color: #c2410c;
        }

        .badge-card p {
            margin: 0;
            color: #92400e;
            line-height: 1.7;
            font-size: 0.96rem;
        }

        .rank-empty {
            background: white;
            border-radius: 32px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 28px 70px rgba(15, 23, 42, 0.08);
            color: #475569;
        }

        .rank-empty h2 {
            margin-bottom: 14px;
            color: #0f172a;
        }

        .rank-empty a {
            display: inline-flex;
            margin-top: 18px;
            padding: 14px 24px;
            border-radius: 999px;
            background: #ffedd5;
            color: #c2410c;
            font-weight: 700;
            text-decoration: none;
        }

        @media (max-width: 960px) {
            .rank-grid,
            .badge-list {
                grid-template-columns: 1fr;
            }
        }
    </style>
HTML;

$companies = [];
try {
    $stmt = $pdo->prepare(
        'SELECT d.empresa,
                d.total_doado,
                d.total_doacoes,
                COALESCE(s.total_solicitacoes, 0) AS total_solicitacoes,
                COALESCE(a.media_avaliacao, 0) AS media_avaliacao,
                COALESCE(a.total_avaliacoes, 0) AS total_avaliacoes
         FROM (
             SELECT empresa, SUM(quantidade) AS total_doado, COUNT(*) AS total_doacoes
             FROM doacoes
             GROUP BY empresa
         ) d
         LEFT JOIN (
             SELECT p.empresa, COUNT(s.id) AS total_solicitacoes
             FROM solicitacoes s
             JOIN produtos p ON p.id = s.produto_id
             GROUP BY p.empresa
         ) s ON s.empresa = d.empresa
         LEFT JOIN (
             SELECT empresa, AVG(nota) AS media_avaliacao, COUNT(*) AS total_avaliacoes
             FROM avaliacoes
             GROUP BY empresa
         ) a ON a.empresa = d.empresa
         ORDER BY d.total_doado DESC, COALESCE(a.media_avaliacao, 0) DESC, COALESCE(s.total_solicitacoes, 0) DESC'
    );
    $stmt->execute();
    $companies = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $companies = [];
}

foreach ($companies as &$company) {
    $company['media_avaliacao'] = $company['media_avaliacao'] ? round($company['media_avaliacao'], 1) : 0;
    $company['score'] = ($company['total_doado'] * 1.8) + ($company['media_avaliacao'] * 18) + ($company['total_solicitacoes'] * 1.2);
}

unset($company);
?>
<!DOCTYPE html>
<html lang="pt-br">
<?php include __DIR__ . '/includes/head.php'; ?>
<body>
    <?php include __DIR__ . '/includes/navbar.php'; ?>
    <main class="home-container">
        <section class="rank-hero">
            <h1>Ranking de Conquistas das Empresas</h1>
            <p>No sistema de conquistas, as empresas que mais doam sobem no ranking e ganham mais recomendações. A reputação é calculada com base em doações registradas, avaliações positivas dos usuários e solicitações atendidas.</p>
        </section>

        <?php if (empty($companies)): ?>
            <div class="rank-empty">
                <h2>Nenhuma empresa pontuada ainda</h2>
                <p>Assim que as primeiras doações, solicitações e avaliações forem registradas, o ranking será atualizado automaticamente.</p>
                <a href="doacoes.php">Ver doações disponíveis</a>
            </div>
        <?php else: ?>
            <section>
                <div class="rank-grid">
                    <?php foreach ($companies as $index => $company): ?>
                        <article class="rank-card">
                            <div class="position"><?php echo $index + 1; ?></div>
                            <h3><?php echo htmlspecialchars($company['empresa'], ENT_QUOTES, 'UTF-8'); ?></h3>
                            <div class="score">
                                <span>Pontuação</span>
                                <strong><?php echo number_format($company['score'], 0, ',', '.'); ?></strong>
                            </div>
                            <ul class="metric-list">
                                <li><span>Doações entregues</span><strong><?php echo htmlspecialchars((string)$company['total_doado'], ENT_QUOTES, 'UTF-8'); ?></strong></li>
                                <li><span>Solicitações recebidas</span><strong><?php echo htmlspecialchars((string)$company['total_solicitacoes'], ENT_QUOTES, 'UTF-8'); ?></strong></li>
                                <li><span>Avaliação média</span><strong><?php echo htmlspecialchars((string)$company['media_avaliacao'], ENT_QUOTES, 'UTF-8'); ?>/5</strong></li>
                                <li><span>Total de avaliações</span><strong><?php echo htmlspecialchars((string)$company['total_avaliacoes'], ENT_QUOTES, 'UTF-8'); ?></strong></li>
                            </ul>
                        </article>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>

        <section class="badge-list">
            <article class="badge-card">
                <h4>Top doador</h4>
                <p>Empresas que doam mais alimentos têm prioridade no ranking e aparecem primeiro nas recomendações.</p>
            </article>
            <article class="badge-card">
                <h4>Top recomendado</h4>
                <p>Avaliações elevadas dos usuários aumentam a visibilidade e ajudam a empresa a ganhar confiança.</p>
            </article>
            <article class="badge-card">
                <h4>Top confiável</h4>
                <p>Mais solicitações atendidas mostram engajamento real da empresa e tornam a recomendação ainda mais forte.</p>
            </article>
            
        </section>
    </main>
</body>
</html>

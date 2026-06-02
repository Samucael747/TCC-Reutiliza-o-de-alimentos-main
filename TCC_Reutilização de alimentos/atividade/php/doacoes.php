<?php
session_start();
if (!isset($_SESSION['nome'])) {
    header('Location: ../index.php?error=Voce+precisa+logar+primeiro');
    exit;
}

require 'conexao.php';
if (!$pdo) {
    die('Erro de conexão com o banco de dados. Tente novamente mais tarde.');
}

$stmt = $pdo->prepare('SELECT d.* FROM doacoes d ORDER BY d.data_doacao DESC');
$stmt->execute();
$doacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$success = $_GET['success'] ?? '';
$error   = $_GET['error'] ?? '';

$paginaAtiva = 'doacoes';
$pageTitle   = 'Doações Registradas | FomeOff';
$extra_head  = <<<'HTML'
    <style>
        body { font-family: 'Inter', sans-serif; margin: 0; background: #f7f3ee; color: #222; }
        .page-container { max-width: 1180px; margin: 24px auto 0; padding: 0 20px; }
        .page-header { display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 24px; }
        .page-header h1 { margin: 0; color: #E8411C; font-size: 2rem; }
        .message { padding: 14px 18px; border-radius: 14px; margin-bottom: 22px; color: #1f3e2e; background: #eaf8ed; }
        .message.error { background: #ffe7e5; color: #762a2a; }
        .card { background: white; border-radius: 18px; padding: 22px; box-shadow: 0 12px 32px rgba(0,0,0,0.08); margin-bottom: 18px; }
        .card h2 { margin: 0 0 12px; font-size: 1.2rem; color: #c94a00; }
        .card-row { display: grid; gap: 10px; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); }
        .card-field { background: #fff9f1; padding: 12px 14px; border-radius: 14px; border: 1px solid #ffe5cd; }
        .card-field label { display: block; font-size: 0.78rem; color: #7a6451; margin-bottom: 6px; font-weight: 700; }
        .card-field span { display: block; color: #333; font-size: 0.96rem; line-height: 1.5; }
        .empty-state { background: white; padding: 24px; border-radius: 18px; text-align: center; border: 1px solid #ffe7d6; }
        .empty-state p { margin: 0; color: #666; font-size: 1rem; }
    </style>
HTML;
?>
<!DOCTYPE html>
<html lang="pt-br">
<?php include __DIR__ . '/head.php'; ?>
<body>
    <?php include __DIR__ . '/navbar.php'; ?>

    <div class="page-container">
        <?php if ($success): ?>
            <div class="message"><?php echo htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="message error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>

        <div class="page-header">
            <div>
                <h1>Doações Registradas</h1>
                <p style="margin: 8px 0 0; color:#555;">Veja todas as doações registradas, com data e local de retirada/entrega.</p>
            </div>
        </div>

        <?php if (empty($doacoes)): ?>
            <div class="empty-state">
                <p>Não há doações registradas ainda.</p>
            </div>
        <?php else: ?>
            <?php foreach ($doacoes as $doacao): ?>
                <div class="card">
                    <h2><?php echo htmlspecialchars($doacao['nome_produto'] ?: 'Produto', ENT_QUOTES, 'UTF-8'); ?></h2>
                    <div class="card-row">
                        <div class="card-field">
                            <label>Empresa / ONG</label>
                            <span><?php echo htmlspecialchars($doacao['empresa'] ?? '---', ENT_QUOTES, 'UTF-8'); ?></span>
                        </div>
                        <div class="card-field">
                            <label>Quantidade</label>
                            <span><?php echo (int)($doacao['quantidade'] ?? 0); ?></span>
                        </div>
                        <div class="card-field">
                            <label>Tipo</label>
                            <span><?php echo htmlspecialchars(ucfirst($doacao['tipo_entrega'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></span>
                        </div>
                        <div class="card-field">
                            <label>Data</label>
                            <span><?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($doacao['data_doacao'] ?? 'now')), ENT_QUOTES, 'UTF-8'); ?></span>
                        </div>
                    </div>
                    <div class="card-row" style="margin-top:14px;">
                        <div class="card-field">
                            <label><?php echo ($doacao['tipo_entrega'] === 'entrega') ? 'Endereço de entrega' : 'Local de retirada'; ?></label>
                            <span><?php echo htmlspecialchars(($doacao['tipo_entrega'] === 'entrega' ? ($doacao['endereco_entrega'] ?? '---') : ($doacao['localizacao_retirada'] ?? '---')), ENT_QUOTES, 'UTF-8'); ?></span>
                        </div>
                        <div class="card-field">
                            <label>Solicitante</label>
                            <span><?php echo htmlspecialchars($doacao['usuario_email'] ?? '---', ENT_QUOTES, 'UTF-8'); ?></span>
                        </div>
                        <div class="card-field">
                            <label>Observações</label>
                            <span><?php echo nl2br(htmlspecialchars($doacao['observacoes'] ?? 'Nenhuma', ENT_QUOTES, 'UTF-8')); ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <?php include __DIR__ . '/footer.php'; ?>

    <script src="../js/accessibility.js"></script>
</body>
</html>

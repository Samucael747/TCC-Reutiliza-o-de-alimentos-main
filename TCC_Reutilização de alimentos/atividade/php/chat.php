<?php
session_start();

if (!isset($_SESSION['nome'])) {
    header('Location: ../entrar.php?error=Voce+precisa+logar+primeiro');
    exit;
}

require __DIR__ . '/includes/conexao.php';
$stmtVol = $pdo->query('SELECT nome AS empresa, voluntario_nome, voluntario_info FROM empresas WHERE voluntario_nome IS NOT NULL AND voluntario_nome != \'\' ORDER BY nome');
$voluntarios = $stmtVol->fetchAll(PDO::FETCH_ASSOC);

$paginaAtiva = 'chat';
$pageTitle   = 'Chat de Voluntários | FomeOff';
$extra_head  = <<<'HTML'
    <style>
        .chat-page { max-width: 1180px; margin: 36px auto; padding: 0 24px; }
        .chat-hero { margin-bottom: 24px; }
        .chat-hero h1 { font-size: 2.4rem; margin-bottom: 10px; }
        .chat-hero p { color: #475569; font-size: 1rem; max-width: 760px; }
        .chat-grid { display: grid; grid-template-columns: 1.8fr 1fr; gap: 24px; }
        .chat-panel, .volunteer-list { background: #fff; border-radius: 24px; box-shadow: 0 24px 80px rgba(15, 23, 42, 0.08); padding: 24px; }
        .chat-panel { display: flex; flex-direction: column; min-height: 600px; }
        .chat-header { display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; margin-bottom: 20px; }
        .chat-header h2 { margin: 0; font-size: 1.5rem; }
        .chat-header small { color: #64748b; }
        .chat-messages { flex: 1; overflow-y: auto; display: flex; flex-direction: column; gap: 14px; padding-right: 8px; }
        .message { width: fit-content; max-width: 78%; padding: 16px 18px; border-radius: 22px; line-height: 1.6; }
        .message.received { background: #f8fafc; color: #0f172a; align-self: flex-start; }
        .message.sent { background: #ffedd5; color: #92400e; align-self: flex-end; }
        .message small { display: block; margin-top: 8px; color: #64748b; font-size: 0.85rem; }
        .chat-form { display: flex; gap: 12px; margin-top: 20px; }
        .chat-form input { flex: 1; padding: 16px 18px; border: 1px solid #e2e8f0; border-radius: 16px; font: inherit; }
        .chat-form button { width: 56px; border: none; border-radius: 16px; background: #ff7a1a; color: #fff; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; }
        .volunteer-card { border-radius: 20px; border: 1px solid #f1f5f9; padding: 20px; margin-bottom: 18px; }
        .volunteer-card h3 { margin: 0 0 6px; font-size: 1.1rem; }
        .volunteer-card p { margin: 0; color: #475569; }
        .status { display: inline-flex; align-items: center; gap: 8px; margin-top: 12px; color: #16a34a; font-weight: 700; }
        .status .dot { width: 10px; height: 10px; border-radius: 50%; background: #16a34a; }
        .volunteer-card small { display: block; margin-top: 12px; color: #64748b; }
        .volunteer-list h2 { margin-top: 0; }
        .volunteer-list p { color: #64748b; margin-bottom: 20px; }
        @media (max-width: 960px) { .chat-grid { grid-template-columns: 1fr; } }
    </style>
HTML;
?>
<!DOCTYPE html>
<html lang="pt-br">
<?php include __DIR__ . '/includes/head.php'; ?>
<body>
    <?php include __DIR__ . '/includes/navbar.php'; ?>

    <main class="chat-page">
        <section class="chat-hero">
            <h1>Chat de voluntários</h1>
            <p>Aqui você encontra pessoas dispostas a levar os alimentos até quem precisa, sem custo, de forma voluntária. Converse direto com voluntários para agendar a entrega.</p>
        </section>

        <div class="chat-grid">
            <section class="chat-panel">
                <div class="chat-header">
                    <div>
                        <h2>Conversa com voluntários</h2>
                        <small>Escolha um voluntário e envie sua mensagem.</small>
                    </div>
                    <div class="status"><span class="dot"></span> Voluntários online</div>
                </div>

                <div class="chat-messages">
                    <div class="message received">
                        Olá! Sou Maria e posso buscar sua doação amanhã à tarde.
                        <small>Maria · 2 min atrás</small>
                    </div>
                    <div class="message sent">
                        Obrigado, Maria! Qual o melhor horário para a retirada?
                        <small>Você · agora</small>
                    </div>
                    <div class="message received">
                        Posso passar entre 14h e 17h. Você prefere horário de manhã ou tarde?
                        <small>Maria · agora</small>
                    </div>
                </div>

                <form class="chat-form" onsubmit="event.preventDefault(); alert('Mensagem enviada!'); this.querySelector('input').value = '';">
                    <input type="text" placeholder="Escreva sua mensagem..." aria-label="Escreva sua mensagem" />
                    <button type="submit"><i class="bi bi-send"></i></button>
                </form>
            </section>

            <aside class="volunteer-list">
                <h2>Voluntários disponíveis</h2>
                <p>Pessoas comprometidas em entregar doações de forma solidária e gratuita.</p>

                <?php if (empty($voluntarios)): ?>
                    <p style="color:#94a3b8;text-align:center;padding:24px 0;">Nenhum voluntário cadastrado ainda.<br>Empresas podem adicionar um voluntário no cadastro.</p>
                <?php else: ?>
                    <?php foreach ($voluntarios as $v): ?>
                    <div class="volunteer-card">
                        <h3><?php echo htmlspecialchars($v['voluntario_nome'], ENT_QUOTES, 'UTF-8'); ?></h3>
                        <p>Voluntário da empresa <strong><?php echo htmlspecialchars($v['empresa'], ENT_QUOTES, 'UTF-8'); ?></strong>.</p>
                        <div class="status"><span class="dot"></span> Online</div>
                        <?php if ($v['voluntario_info']): ?>
                            <small><?php echo htmlspecialchars($v['voluntario_info'], ENT_QUOTES, 'UTF-8'); ?></small>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </aside>
        </div>
    </main>
</body>
</html>

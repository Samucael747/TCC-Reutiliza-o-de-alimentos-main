<?php
session_start();

if (!isset($_SESSION['nome'])) {
    header('Location: ../entrar.php?error=Voce+precisa+logar+primeiro');
    exit;
}

require __DIR__ . '/includes/conexao.php';
/** @var \PDO $pdo */

$role = $_SESSION['role'] ?? 'usuario';

if ($role === 'empresa') {
    // Empresa: busca o próprio id e lista usuários que mandaram mensagem
    $stmtEmp = $pdo->prepare('SELECT id, voluntario_nome FROM empresas WHERE email = :e LIMIT 1');
    $stmtEmp->execute([':e' => $_SESSION['email']]);
    $minhaEmpresa = $stmtEmp->fetch(PDO::FETCH_ASSOC);

    $conversas = [];
    if ($minhaEmpresa) {
        $stmtConv = $pdo->prepare(
            'SELECT DISTINCT usuario_email, MAX(created_at) AS ultima FROM mensagens WHERE empresa_id = :eid GROUP BY usuario_email ORDER BY ultima DESC'
        );
        $stmtConv->execute([':eid' => $minhaEmpresa['id']]);
        $conversas = $stmtConv->fetchAll(PDO::FETCH_ASSOC);
    }
    $voluntarios = [];
} else {
    // Usuário: lista voluntários disponíveis
    $stmtVol = $pdo->query('SELECT id, nome AS empresa, voluntario_nome, voluntario_info FROM empresas WHERE voluntario_nome IS NOT NULL AND voluntario_nome != \'\' ORDER BY nome');
    $voluntarios = $stmtVol->fetchAll(PDO::FETCH_ASSOC);
    $conversas = [];
    $minhaEmpresa = null;
}

$paginaAtiva = 'chat';
$pageTitle   = 'Chat de Voluntários | FomeOff';
$extra_head  = <<<'HTML'
    <style>
        .chat-page { max-width: 1180px; margin: 36px auto; padding: 0 24px; }
        .chat-hero { margin-bottom: 24px; }
        .chat-hero h1 { font-size: 2.4rem; margin-bottom: 10px; }
        .chat-hero p { color: #475569; font-size: 1rem; max-width: 760px; }
        .chat-grid { display: grid; grid-template-columns: 1.8fr 1fr; gap: 24px; }
        .chat-panel, .side-list { background: #fff; border-radius: 24px; box-shadow: 0 24px 80px rgba(15,23,42,0.08); padding: 24px; }
        .chat-panel { display: flex; flex-direction: column; min-height: 520px; }
        .chat-header { display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; margin-bottom: 20px; }
        .chat-header h2 { margin: 0; font-size: 1.4rem; }
        .chat-header small { color: #64748b; }
        .chat-messages { flex: 1; overflow-y: auto; display: flex; flex-direction: column; gap: 12px; padding-right: 6px; min-height: 300px; }
        .msg { width: fit-content; max-width: 78%; padding: 14px 18px; border-radius: 20px; line-height: 1.6; font-size: 0.97rem; }
        .msg.received { background: #f1f5f9; color: #0f172a; align-self: flex-start; border-bottom-left-radius: 6px; }
        .msg.sent { background: #ffedd5; color: #92400e; align-self: flex-end; border-bottom-right-radius: 6px; }
        .msg small { display: block; margin-top: 6px; color: #94a3b8; font-size: 0.8rem; }
        .chat-empty { flex: 1; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-size: 0.95rem; text-align: center; padding: 24px; }
        .chat-form { display: flex; gap: 10px; margin-top: 16px; }
        .chat-form input { flex: 1; padding: 14px 18px; border: 1.5px solid #e2e8f0; border-radius: 14px; font: inherit; font-size: 0.97rem; transition: border-color 0.2s; }
        .chat-form input:focus { outline: none; border-color: #ff8c00; }
        .chat-form button { padding: 0 20px; border: none; border-radius: 14px; background: linear-gradient(135deg,#FF8C00,#FDB813); color: #fff; cursor: pointer; font-size: 1.1rem; transition: filter 0.2s; }
        .chat-form button:hover { filter: brightness(1.08); }
        .side-list h2 { margin-top: 0; font-size: 1.3rem; }
        .side-list > p { color: #64748b; margin-bottom: 16px; font-size: 0.92rem; }
        .side-card { border-radius: 18px; border: 2px solid #f1f5f9; padding: 18px; margin-bottom: 14px; cursor: pointer; transition: border-color 0.2s, box-shadow 0.2s; }
        .side-card:hover { border-color: #fbbf24; box-shadow: 0 4px 16px rgba(255,140,0,0.1); }
        .side-card.active { border-color: #ff8c00; background: #fff8f0; }
        .side-card h3 { margin: 0 0 4px; font-size: 1rem; }
        .side-card p { margin: 0; color: #475569; font-size: 0.88rem; }
        .status { display: inline-flex; align-items: center; gap: 7px; margin-top: 10px; color: #16a34a; font-weight: 600; font-size: 0.88rem; }
        .status .dot { width: 9px; height: 9px; border-radius: 50%; background: #16a34a; }
        .side-card small { display: block; margin-top: 8px; color: #64748b; font-size: 0.83rem; }
        .badge-empresa { display:inline-block; background:#fef3c7; color:#92400e; border-radius:8px; padding:2px 10px; font-size:0.8rem; font-weight:700; margin-bottom:8px; }
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
            <?php if ($role === 'empresa'): ?>
                <p>Responda as mensagens dos usuários interessados nas doações da sua empresa.</p>
                <?php if ($minhaEmpresa && $minhaEmpresa['voluntario_nome']): ?>
                    <span class="badge-empresa">Voluntário: <?php echo htmlspecialchars($minhaEmpresa['voluntario_nome'], ENT_QUOTES, 'UTF-8'); ?></span>
                <?php endif; ?>
            <?php else: ?>
                <p>Selecione um voluntário na lista e envie sua mensagem para agendar uma entrega.</p>
            <?php endif; ?>
        </section>

        <div class="chat-grid">
            <!-- Painel de conversa -->
            <section class="chat-panel">
                <div class="chat-header">
                    <div>
                        <h2 id="chatTitle">Selecione <?php echo $role === 'empresa' ? 'um usuário' : 'um voluntário'; ?></h2>
                        <small id="chatSub">Clique na lista ao lado para iniciar.</small>
                    </div>
                    <div class="status"><span class="dot"></span> Online</div>
                </div>

                <div class="chat-messages" id="chatMessages">
                    <div class="chat-empty">Escolha <?php echo $role === 'empresa' ? 'um usuário' : 'um voluntário'; ?> para ver a conversa.</div>
                </div>

                <form class="chat-form" id="chatForm" onsubmit="enviarMensagem(event)">
                    <input type="text" id="msgInput" placeholder="Escreva sua mensagem..." autocomplete="off" disabled />
                    <button type="submit" id="sendBtn" disabled><i class="bi bi-send"></i></button>
                </form>
            </section>

            <!-- Lista lateral -->
            <aside class="side-list">
                <?php if ($role === 'empresa'): ?>
                    <h2>Conversas recebidas</h2>
                    <p>Usuários que entraram em contato.</p>
                    <?php if (empty($conversas)): ?>
                        <p style="color:#94a3b8;text-align:center;padding:24px 0;">Nenhuma mensagem recebida ainda.</p>
                    <?php else: ?>
                        <?php foreach ($conversas as $c): ?>
                        <div class="side-card"
                             onclick="selecionarConversa('<?php echo htmlspecialchars($c['usuario_email'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($c['usuario_email'], ENT_QUOTES); ?>')"
                             data-key="<?php echo htmlspecialchars($c['usuario_email'], ENT_QUOTES); ?>">
                            <h3><i class="bi bi-person-circle" style="color:#ff8c00;"></i> <?php echo htmlspecialchars($c['usuario_email'], ENT_QUOTES, 'UTF-8'); ?></h3>
                            <small>Última mensagem: <?php echo date('d/m H:i', strtotime($c['ultima'])); ?></small>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                <?php else: ?>
                    <h2>Voluntários disponíveis</h2>
                    <p>Clique para iniciar uma conversa.</p>
                    <?php if (empty($voluntarios)): ?>
                        <p style="color:#94a3b8;text-align:center;padding:24px 0;">Nenhum voluntário cadastrado ainda.</p>
                    <?php else: ?>
                        <?php foreach ($voluntarios as $v): ?>
                        <div class="side-card"
                             onclick="selecionarConversa(<?php echo $v['id']; ?>, '<?php echo htmlspecialchars($v['voluntario_nome'], ENT_QUOTES); ?>')"
                             data-key="<?php echo $v['id']; ?>">
                            <h3><?php echo htmlspecialchars($v['voluntario_nome'], ENT_QUOTES, 'UTF-8'); ?></h3>
                            <p>Empresa: <strong><?php echo htmlspecialchars($v['empresa'], ENT_QUOTES, 'UTF-8'); ?></strong></p>
                            <div class="status"><span class="dot"></span> Online</div>
                            <?php if ($v['voluntario_info']): ?>
                                <small><?php echo htmlspecialchars($v['voluntario_info'], ENT_QUOTES, 'UTF-8'); ?></small>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </aside>
        </div>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>
    <script src="../js/accessibility.js"></script>
    <script>
        const ROLE = '<?php echo $role; ?>';
        let chaveAtiva   = null;
        let nomeAtivo    = '';
        let pollingTimer = null;
        let ultimoTotal  = 0;

        // Pede permissão para notificações do browser
        if ('Notification' in window && Notification.permission === 'default') {
            Notification.requestPermission();
        }

        function notificarBrowser(titulo, corpo) {
            if ('Notification' in window && Notification.permission === 'granted') {
                new Notification(titulo, { body: corpo, icon: '../Imagens/Logo.png' });
            }
        }

        function selecionarConversa(chave, nome) {
            chaveAtiva  = chave;
            nomeAtivo   = nome;
            ultimoTotal = 0;

            document.getElementById('chatTitle').textContent = nome;
            document.getElementById('chatSub').textContent   = ROLE === 'empresa' ? 'Usuário: ' + nome : 'Voluntário selecionado';
            document.getElementById('msgInput').disabled = false;
            document.getElementById('sendBtn').disabled  = false;
            document.getElementById('msgInput').focus();

            document.querySelectorAll('.side-card').forEach(c => c.classList.remove('active'));
            const card = document.querySelector(`.side-card[data-key="${String(chave).replace(/"/g,'&quot;')}"]`);
            if (card) card.classList.add('active');

            carregarMensagens();
            clearInterval(pollingTimer);
            pollingTimer = setInterval(carregarMensagens, 3000);
        }

        function carregarMensagens() {
            if (chaveAtiva === null) return;
            const url = ROLE === 'empresa'
                ? 'actions/carregarMensagens.php?usuario_email=' + encodeURIComponent(chaveAtiva)
                : 'actions/carregarMensagens.php?empresa_id=' + chaveAtiva;

            fetch(url)
                .then(r => r.json())
                .then(msgs => {
                    const box = document.getElementById('chatMessages');
                    if (!msgs.length) {
                        box.innerHTML = '<div class="chat-empty">Nenhuma mensagem ainda. Diga olá!</div>';
                        ultimoTotal = 0;
                        return;
                    }

                    // Detectar mensagens novas da outra parte
                    const novas = msgs.filter(m => ROLE === 'empresa' ? m.remetente === 'usuario' : m.remetente === 'voluntario');
                    if (novas.length > ultimoTotal) {
                        const ultima = novas[novas.length - 1];
                        notificarBrowser('💬 Nova mensagem — FomeOff', nomeAtivo + ': ' + ultima.texto.substring(0, 80));
                    }
                    ultimoTotal = novas.length;

                    const atBottom = box.scrollHeight - box.scrollTop <= box.clientHeight + 40;
                    box.innerHTML = msgs.map(m => {
                        const isMine = (ROLE === 'empresa') ? m.remetente === 'voluntario' : m.remetente === 'usuario';
                        const cls    = isMine ? 'sent' : 'received';
                        const autor  = isMine ? 'Você' : nomeAtivo;
                        const hora   = m.created_at ? m.created_at.substring(11, 16) : '';
                        return `<div class="msg ${cls}">${esc(m.texto)}<small>${esc(autor)} · ${hora}</small></div>`;
                    }).join('');
                    if (atBottom) box.scrollTop = box.scrollHeight;

                    // Marcar mensagens recebidas como lidas
                    const fd = new FormData();
                    if (ROLE === 'empresa') fd.append('usuario_email', chaveAtiva);
                    else fd.append('empresa_id', chaveAtiva);
                    fetch('actions/marcarLidas.php', { method: 'POST', body: fd }).catch(() => {});
                })
                .catch(() => {});
        }

        function enviarMensagem(e) {
            e.preventDefault();
            if (chaveAtiva === null) return;
            const input = document.getElementById('msgInput');
            const texto = input.value.trim();
            if (!texto) return;

            input.value   = '';
            input.disabled = true;

            const fd = new FormData();
            fd.append('texto', texto);
            if (ROLE === 'empresa') {
                fd.append('usuario_email', chaveAtiva);
            } else {
                fd.append('empresa_id', chaveAtiva);
            }

            fetch('actions/enviarMensagem.php', { method: 'POST', body: fd })
                .then(r => r.json())
                .then(res => { input.disabled = false; input.focus(); if (res.ok) carregarMensagens(); })
                .catch(() => { input.disabled = false; });
        }

        function esc(s) {
            return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
        }

    </script>
</body>
</html>

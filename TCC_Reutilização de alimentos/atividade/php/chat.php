<?php
session_start();

if (!isset($_SESSION['nome'])) {
    header('Location: ../entrar.php?error=Voce+precisa+logar+primeiro');
    exit;
}

require __DIR__ . '/includes/conexao.php';
$stmtVol = $pdo->query('SELECT id, nome AS empresa, voluntario_nome, voluntario_info FROM empresas WHERE voluntario_nome IS NOT NULL AND voluntario_nome != \'\' ORDER BY nome');
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
        .chat-panel, .volunteer-list { background: #fff; border-radius: 24px; box-shadow: 0 24px 80px rgba(15,23,42,0.08); padding: 24px; }
        .chat-panel { display: flex; flex-direction: column; min-height: 520px; }
        .chat-header { display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; margin-bottom: 20px; }
        .chat-header h2 { margin: 0; font-size: 1.4rem; }
        .chat-header small { color: #64748b; }
        .chat-messages { flex: 1; overflow-y: auto; display: flex; flex-direction: column; gap: 12px; padding-right: 6px; min-height: 300px; }
        .msg { width: fit-content; max-width: 78%; padding: 14px 18px; border-radius: 20px; line-height: 1.6; font-size: 0.97rem; }
        .msg.received { background: #f1f5f9; color: #0f172a; align-self: flex-start; border-bottom-left-radius: 6px; }
        .msg.sent { background: #ffedd5; color: #92400e; align-self: flex-end; border-bottom-right-radius: 6px; }
        .msg small { display: block; margin-top: 6px; color: #94a3b8; font-size: 0.8rem; }
        .chat-empty { flex: 1; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-size: 0.95rem; text-align: center; }
        .chat-form { display: flex; gap: 10px; margin-top: 16px; }
        .chat-form input { flex: 1; padding: 14px 18px; border: 1.5px solid #e2e8f0; border-radius: 14px; font: inherit; font-size: 0.97rem; transition: border-color 0.2s; }
        .chat-form input:focus { outline: none; border-color: #ff8c00; }
        .chat-form button { padding: 0 20px; border: none; border-radius: 14px; background: linear-gradient(135deg,#FF8C00,#FDB813); color: #fff; cursor: pointer; font-size: 1.1rem; transition: filter 0.2s; }
        .chat-form button:hover { filter: brightness(1.08); }
        .volunteer-list h2 { margin-top: 0; font-size: 1.3rem; }
        .volunteer-list > p { color: #64748b; margin-bottom: 16px; font-size: 0.92rem; }
        .volunteer-card { border-radius: 18px; border: 2px solid #f1f5f9; padding: 18px; margin-bottom: 14px; cursor: pointer; transition: border-color 0.2s, box-shadow 0.2s; }
        .volunteer-card:hover { border-color: #fbbf24; box-shadow: 0 4px 16px rgba(255,140,0,0.1); }
        .volunteer-card.active { border-color: #ff8c00; background: #fff8f0; box-shadow: 0 4px 16px rgba(255,140,0,0.15); }
        .volunteer-card h3 { margin: 0 0 4px; font-size: 1rem; }
        .volunteer-card p { margin: 0; color: #475569; font-size: 0.88rem; }
        .status { display: inline-flex; align-items: center; gap: 7px; margin-top: 10px; color: #16a34a; font-weight: 600; font-size: 0.88rem; }
        .status .dot { width: 9px; height: 9px; border-radius: 50%; background: #16a34a; }
        .volunteer-card small { display: block; margin-top: 8px; color: #64748b; font-size: 0.83rem; }
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
            <p>Selecione um voluntário na lista e envie sua mensagem para agendar uma entrega.</p>
        </section>

        <div class="chat-grid">
            <!-- Painel de conversa -->
            <section class="chat-panel">
                <div class="chat-header">
                    <div>
                        <h2 id="chatTitle">Selecione um voluntário</h2>
                        <small id="chatSub">Clique em um voluntário à direita para iniciar.</small>
                    </div>
                    <div class="status"><span class="dot"></span> Online</div>
                </div>

                <div class="chat-messages" id="chatMessages">
                    <div class="chat-empty" id="chatEmpty">
                        <span>Escolha um voluntário para ver a conversa.</span>
                    </div>
                </div>

                <form class="chat-form" id="chatForm" onsubmit="enviarMensagem(event)">
                    <input type="text" id="msgInput" placeholder="Escreva sua mensagem..." autocomplete="off" disabled />
                    <button type="submit" id="sendBtn" disabled><i class="bi bi-send"></i></button>
                </form>
            </section>

            <!-- Lista de voluntários -->
            <aside class="volunteer-list">
                <h2>Voluntários disponíveis</h2>
                <p>Clique para iniciar uma conversa.</p>

                <?php if (empty($voluntarios)): ?>
                    <p style="color:#94a3b8;text-align:center;padding:24px 0;">
                        Nenhum voluntário cadastrado ainda.<br>
                        Empresas podem adicionar um voluntário no cadastro.
                    </p>
                <?php else: ?>
                    <?php foreach ($voluntarios as $v): ?>
                    <div class="volunteer-card"
                         onclick="selecionarVoluntario(<?php echo $v['id']; ?>, '<?php echo htmlspecialchars($v['voluntario_nome'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($v['empresa'], ENT_QUOTES); ?>')"
                         id="card-<?php echo $v['id']; ?>">
                        <h3><?php echo htmlspecialchars($v['voluntario_nome'], ENT_QUOTES, 'UTF-8'); ?></h3>
                        <p>Empresa: <strong><?php echo htmlspecialchars($v['empresa'], ENT_QUOTES, 'UTF-8'); ?></strong></p>
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

    <?php include __DIR__ . '/includes/footer.php'; ?>
    <script src="../js/accessibility.js"></script>
    <script>
        let empresaAtiva = null;
        let nomeVoluntario = '';
        let pollingTimer = null;

        function selecionarVoluntario(empresaId, nome, empresa) {
            empresaAtiva = empresaId;
            nomeVoluntario = nome;

            document.getElementById('chatTitle').textContent = nome;
            document.getElementById('chatSub').textContent = 'Voluntário da empresa ' + empresa;
            document.getElementById('msgInput').disabled = false;
            document.getElementById('sendBtn').disabled = false;
            document.getElementById('msgInput').focus();

            document.querySelectorAll('.volunteer-card').forEach(c => c.classList.remove('active'));
            document.getElementById('card-' + empresaId).classList.add('active');

            carregarMensagens();

            clearInterval(pollingTimer);
            pollingTimer = setInterval(carregarMensagens, 3000);
        }

        function carregarMensagens() {
            if (!empresaAtiva) return;
            fetch('actions/carregarMensagens.php?empresa_id=' + empresaAtiva)
                .then(r => r.json())
                .then(msgs => {
                    const box = document.getElementById('chatMessages');
                    const empty = document.getElementById('chatEmpty');

                    if (msgs.length === 0) {
                        box.innerHTML = '<div class="chat-empty" id="chatEmpty"><span>Nenhuma mensagem ainda. Diga olá!</span></div>';
                        return;
                    }

                    const atBottom = box.scrollHeight - box.scrollTop <= box.clientHeight + 40;
                    box.innerHTML = msgs.map(m => {
                        const cls = m.remetente === 'usuario' ? 'sent' : 'received';
                        const autor = m.remetente === 'usuario' ? 'Você' : nomeVoluntario;
                        const hora = m.created_at ? m.created_at.substring(11, 16) : '';
                        return `<div class="msg ${cls}">${escHtml(m.texto)}<small>${escHtml(autor)} · ${hora}</small></div>`;
                    }).join('');

                    if (atBottom) box.scrollTop = box.scrollHeight;
                })
                .catch(() => {});
        }

        function enviarMensagem(e) {
            e.preventDefault();
            if (!empresaAtiva) return;
            const input = document.getElementById('msgInput');
            const texto = input.value.trim();
            if (!texto) return;

            input.value = '';
            input.disabled = true;

            const fd = new FormData();
            fd.append('empresa_id', empresaAtiva);
            fd.append('texto', texto);

            fetch('actions/enviarMensagem.php', { method: 'POST', body: fd })
                .then(r => r.json())
                .then(res => {
                    input.disabled = false;
                    input.focus();
                    if (res.ok) carregarMensagens();
                })
                .catch(() => { input.disabled = false; });
        }

        function escHtml(str) {
            return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
        }
    </script>
</body>
</html>

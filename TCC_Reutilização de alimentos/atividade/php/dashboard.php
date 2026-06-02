<?php
session_start();

if (!isset($_SESSION['nome'])) {
    header('Location: ../entrar.php?error=Voce+precisa+logar+primeiro');
    exit;
}

$nome = $_SESSION['nome'];
require_once __DIR__ . '/includes/conexao.php';

if (!$pdo) {
    die('Erro de conexão com o banco de dados. Tente novamente mais tarde.');
}

$cepFiltro = trim($_GET['cep'] ?? '');
$sql = 'SELECT * FROM produtos';
$params = [];

if ($cepFiltro !== '') {
    $sql .= ' WHERE cep LIKE :cep';
    $params[':cep'] = substr($cepFiltro, 0, 5) . '%';
}

$sql .= ' ORDER BY created_at DESC';
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$success = $_GET['success'] ?? '';
$error   = $_GET['error'] ?? '';

$paginaAtiva = 'dashboard';
$pageTitle   = 'Painel | FomeOff';
$extra_head  = <<<'HTML'
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
    <link rel="stylesheet" href="../css/home.css" />
HTML;
?>
<!DOCTYPE html>
<html lang="pt-br">
<?php include __DIR__ . '/includes/head.php'; ?>
<body>
    <?php include __DIR__ . '/includes/navbar.php'; ?>

    <main class="home-container">
        <?php if ($success): ?>
            <div class="message success"><?php echo htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="message error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>

        <section class="hero">
            <h1>Bem-vindo, <?php echo htmlspecialchars($nome, ENT_QUOTES, 'UTF-8'); ?>!</h1>
            <p>Encontre alimentos disponíveis para doação próximo a você e conecte sua comunidade a quem mais precisa.</p>
        </section>

        <section class="controls">
            <form class="filter" method="get" action="">
                <input type="text" name="cep" placeholder="Buscar por CEP (ex: 12345-678)"
                       value="<?php echo htmlspecialchars($cepFiltro, ENT_QUOTES, 'UTF-8'); ?>" />
                <button type="submit">Filtrar</button>
            </form>
            <div class="actions">
                <a href="doacoes.php" class="btn-primary"><i class="bi bi-box-seam"></i> Ver Doa&ccedil;&otilde;es</a>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'empresa'): ?>
                    <a href="../auth/cadastroProduto.php" class="btn-primary"><i class="bi bi-plus-circle"></i> Cadastrar Produto</a>
                <?php endif; ?>
            </div>
        </section>

        <div id="map"></div>

        <h2 class="section-title">Produtos Disponíveis</h2>

        <?php if (empty($produtos)): ?>
            <div class="empty-state">
                <p>Nenhum produto cadastrado ainda.</p>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'empresa'): ?>
                    <p>Clique em <strong>Cadastrar Produto</strong> para adicionar itens para doação.</p>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="cards">
                <?php foreach ($produtos as $produto): ?>
                    <article class="card">
                        <h3><i class="bi bi-gift"></i> <?php echo htmlspecialchars($produto['nome_produto'] ?? 'Produto', ENT_QUOTES, 'UTF-8'); ?></h3>

                        <?php if (!empty($produto['imagem'])): ?>
                            <img src="../<?php echo htmlspecialchars($produto['imagem'], ENT_QUOTES, 'UTF-8'); ?>"
                                 alt="Foto do produto" />
                        <?php endif; ?>

                        <div class="card-info">
                            <?php if (!empty($produto['empresa'])): ?>
                            <div class="card-field">
                                <div class="card-field-label">Empresa</div>
                                <div class="card-field-value"><?php echo htmlspecialchars($produto['empresa'], ENT_QUOTES, 'UTF-8'); ?></div>
                            </div>
                            <?php endif; ?>

                            <?php if (!empty($produto['descricao'])): ?>
                            <div class="card-field">
                                <div class="card-field-label">Descrição</div>
                                <div class="card-field-value"><?php echo htmlspecialchars($produto['descricao'], ENT_QUOTES, 'UTF-8'); ?></div>
                            </div>
                            <?php endif; ?>

                            <div class="card-field">
                                <div class="card-field-label">Quantidade</div>
                                <div class="card-field-value"><?php echo htmlspecialchars((string)($produto['quantidade'] ?? ''), ENT_QUOTES, 'UTF-8'); ?> unidades</div>
                            </div>

                            <?php if (!empty($produto['validade'])): ?>
                            <div class="card-field">
                                <div class="card-field-label">Validade</div>
                                <div class="card-field-value">
                                    <?php
                                        $d = $produto['validade'];
                                        echo htmlspecialchars(
                                            (strlen($d) === 10 ? date('d/m/Y', strtotime($d)) : $d),
                                            ENT_QUOTES, 'UTF-8'
                                        );
                                    ?>
                                </div>
                            </div>
                            <?php endif; ?>

                            <div class="card-field">
                                <div class="card-field-label">CEP</div>
                                <div class="card-field-value"><?php echo htmlspecialchars($produto['cep'] ?? '', ENT_QUOTES, 'UTF-8'); ?></div>
                            </div>
                        </div>

                        <div class="card-actions">
                            <form method="post" action="actions/solicitar.php">
                                <input type="hidden" name="produto_id" value="<?php echo (int)($produto['id'] ?? 0); ?>" />
                                <input type="hidden" name="tipo" value="retirada" />
                                <button type="submit" class="btn-solicitar"><i class="bi bi-check-circle"></i> Solicitar</button>
                            </form>
                            <button type="button" class="btn-entrega"
                                    onclick="document.getElementById('df-<?php echo (int)($produto['id'] ?? 0); ?>').classList.toggle('active')">
                                <i class="bi bi-truck"></i> Entrega
                            </button>
                        </div>

                        <div id="df-<?php echo (int)($produto['id'] ?? 0); ?>" class="delivery-form">
                            <form method="post" action="actions/solicitar.php">
                                <input type="hidden" name="produto_id" value="<?php echo (int)($produto['id'] ?? 0); ?>" />
                                <input type="hidden" name="tipo" value="entrega" />
                                <label style="font-weight:600;color:#666;font-size:0.9rem;">Endereço de entrega</label>
                                <input type="text" name="endereco" placeholder="Rua, número, bairro, cidade" required />
                                <textarea name="observacoes" placeholder="Observações (opcional)" rows="2"></textarea>
                                <button type="submit">Enviar pedido</button>
                            </form>
                        </div>

                        <?php
                        $avaliacoes = [];
                        try {
                            $stmtRev = $pdo->prepare('SELECT nota, comentario, usuario_email, created_at FROM avaliacoes WHERE produto_id = :id ORDER BY created_at DESC');
                            $stmtRev->execute([':id' => $produto['id']]);
                            $avaliacoes = $stmtRev->fetchAll(PDO::FETCH_ASSOC);
                        } catch (PDOException $e) { /* tabela pode não existir ainda */ }
                        ?>

                        <?php if (!empty($avaliacoes)): ?>
                            <div class="avaliacoes">
                                <strong style="font-size:0.9rem;color:#555;">Avaliações:</strong>
                                <?php foreach ($avaliacoes as $av): ?>
                                    <div class="avaliacao-item">
                                        <span class="avaliacao-nota"><?php echo str_repeat('<i class="bi bi-star-fill"></i>', max(1, (int)$av['nota'])); ?></span>
                                        <span class="avaliacao-autor">por <?php echo htmlspecialchars($av['usuario_email'], ENT_QUOTES, 'UTF-8'); ?></span>
                                        <?php if (!empty($av['comentario'])): ?>
                                            <div class="avaliacao-comentario"><?php echo nl2br(htmlspecialchars($av['comentario'], ENT_QUOTES, 'UTF-8')); ?></div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <?php
                        $canReview     = false;
                        $alreadyReviewed = false;
                        if (isset($_SESSION['email'])) {
                            try {
                                $stmtSol = $pdo->prepare('SELECT COUNT(*) FROM solicitacoes WHERE produto_id = :id AND usuario_email = :email AND status = "aprovado"');
                                $stmtSol->execute([':id' => $produto['id'], ':email' => $_SESSION['email']]);
                                $canReview = $stmtSol->fetchColumn() > 0;

                                $stmtOwn = $pdo->prepare('SELECT COUNT(*) FROM avaliacoes WHERE produto_id = :id AND usuario_email = :email');
                                $stmtOwn->execute([':id' => $produto['id'], ':email' => $_SESSION['email']]);
                                $alreadyReviewed = $stmtOwn->fetchColumn() > 0;
                            } catch (PDOException $e) { /* tabela pode não existir ainda */ }
                        }
                        ?>

                        <?php if ($canReview && !$alreadyReviewed): ?>
                            <form method="post" action="actions/salvarAvaliacao.php" class="form-avaliar">
                                <input type="hidden" name="produto_id" value="<?php echo (int)($produto['id'] ?? 0); ?>" />
                                <label style="font-size:0.9rem;font-weight:600;color:#666;">Deixe sua avaliação</label>
                                <div class="form-avaliar-row">
                                    <select name="nota" required>
                                        <option value="">Nota</option>
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                    <input name="comentario" placeholder="Comentário (opcional)" style="flex:1;" />
                                    <button type="submit">Avaliar</button>
                                </div>
                            </form>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>

    <script src="../js/accessibility.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    <script>
        const produtos = <?php echo json_encode($produtos, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
        const mapEl = document.getElementById('map');
        const map = L.map(mapEl).setView([-23.5505, -46.6333], 5);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        produtos.forEach(function(p) {
            const lat = parseFloat(p.latitude);
            const lon = parseFloat(p.longitude);
            if (p.latitude && p.longitude && !isNaN(lat) && !isNaN(lon)) {
                L.marker([lat, lon]).addTo(map).bindPopup(
                    '<div style="font-family:Inter,sans-serif;min-width:160px;">' +
                        '<strong style="color:#E8411C;font-size:1rem;">' + p.empresa + '</strong><br><br>' +
                        '<i class="bi bi-gift" style="color:#ff8c00;"></i> ' + p.nome_produto + '<br>' +
                        '<i class="bi bi-stack" style="color:#ff8c00;"></i> Qtd: ' + p.quantidade + '<br>' +
                        '<i class="bi bi-geo-alt" style="color:#ff8c00;"></i> CEP: ' + p.cep +
                    '</div>'
                );
            }
        });

        function updateLocationBadge(lat, lon) {
            const badge = document.getElementById('locationBadge');
            const txt = badge ? badge.querySelector('.location-text') : null;
            if (txt) txt.textContent = 'Localizando...';

            fetch('https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=' + lat + '&lon=' + lon)
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    const addr = data.address || {};
                    const city  = addr.city || addr.town || addr.village || addr.county || '';
                    const state = addr.state || '';
                    if (txt) txt.textContent = [city, state].filter(Boolean).join(', ') || 'Localização encontrada';
                })
                .catch(function() { if (txt) txt.textContent = 'Localização encontrada'; });
        }

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(pos) {
                    var lat = pos.coords.latitude, lon = pos.coords.longitude;
                    L.circleMarker([lat, lon], {
                        radius: 12, fillColor: '#FF8C00', color: '#E8411C',
                        weight: 3, fillOpacity: 0.9
                    }).addTo(map).bindPopup('📍 Você está aqui');
                    map.setView([lat, lon], 13);
                    updateLocationBadge(lat, lon);
                },
                function() {
                    var badge = document.getElementById('locationBadge');
                    var txt = badge ? badge.querySelector('.location-text') : null;
                    if (txt) txt.textContent = 'Localização indisponível';
                },
                { enableHighAccuracy: true, timeout: 10000 }
            );
        }
    </script>
</body>
</html>





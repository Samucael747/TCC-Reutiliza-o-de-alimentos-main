<?php
session_start();
if (!isset($_SESSION['nome'])) {
    header("Location: ../index.php?error=Voce+precisa+logar+primeiro");
    exit;
}

$nome = $_SESSION['nome'];
require 'conexao.php';

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
$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home | FomeOff</title>
    <link rel="stylesheet" href="../css/index.css" />
    <link rel="stylesheet" href="../css/acessibilidade.css" />
    <link rel="stylesheet" href="../css/accessibility-panel.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
    <style>
        * { box-sizing: border-box; }
        
        body { 
            background: linear-gradient(180deg, #FFF3E0 0%, #FFE4B5 100%);
            margin: 0;
            font-family: 'Inter', sans-serif;
        }
        
        .navbar {
            background: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            position: sticky;
            top: 0;
            z-index: 100;
            padding: 16px 20px;
        }
        
        .navbar-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 24px;
        }
        
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #E8411C;
            font-weight: 700;
            font-size: 1.3rem;
        }
        
        .navbar-brand span {
            font-size: 1.8rem;
        }
        
        .navbar-menu {
            display: flex;
            list-style: none;
            gap: 24px;
            margin: 0;
            padding: 0;
            flex: 1;
        }
        
        .navbar-menu a {
            color: #333;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .navbar-menu a:hover,
        .navbar-menu a.active {
            color: #FF8C00;
        }
        
        .navbar-menu a.active::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(135deg, #FF8C00, #FDB813);
            border-radius: 2px;
        }
        
        .navbar-actions {
            display: flex;
            gap: 12px;
            align-items: center;
        }
        
        .navbar-actions a {
            color: #333;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 8px 14px;
            border-radius: 6px;
        }
        .navbar-location {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #e8f7ed;
            color: #1f6f3f;
            padding: 10px 16px;
            border-radius: 999px;
            border: 1px solid #c9f0d6;
            font-size: 0.95rem;
            font-weight: 600;
            white-space: nowrap;
        }
        .navbar-location .location-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: rgba(47, 128, 79, 0.12);
        }
        .navbar-location .location-text {
            color: #1f6f3f;
        }
        
        .navbar-actions a:hover {
            background: rgba(255, 140, 0, 0.1);
            color: #FF8C00;
        }
        
        .home-container { 
            max-width: 1200px; 
            margin: 0 auto; 
            padding: 40px 20px;
        }
        
        .welcome { 
            text-align: center; 
            margin-bottom: 40px;
            background: linear-gradient(135deg, rgba(255, 140, 0, 0.08), rgba(253, 184, 19, 0.08));
            padding: 40px;
            border-radius: 20px;
            border-left: 6px solid #FF8C00;
        }
        
        .welcome h1 {
            margin: 0 0 12px 0;
            font-size: clamp(1.8rem, 4vw, 2.8rem);
            color: #E8411C;
        }
        
        .welcome p {
            margin: 0;
            color: #666;
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .controls { 
            display: flex; 
            flex-wrap: wrap; 
            gap: 20px; 
            justify-content: space-between; 
            align-items: stretch;
            margin-bottom: 32px;
            background: white;
            padding: 20px;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        
        .filter { 
            display: flex; 
            gap: 12px; 
            flex: 1;
            min-width: 280px;
        }
        
        .filter input { 
            flex: 1;
            padding: 12px 16px; 
            border: 2px solid #E0E0E0;
            border-radius: 10px; 
            background: #FFF;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }
        
        .filter input:focus {
            outline: none;
            border-color: #FF8C00;
            box-shadow: 0 0 0 3px rgba(255, 140, 0, 0.1);
        }
        
        .filter button { 
            padding: 12px 24px; 
            border: none; 
            border-radius: 10px; 
            background: linear-gradient(135deg, #FF8C00, #FDB813); 
            color: #fff; 
            cursor: pointer; 
            font-weight: 600;
            transition: all 0.3s ease;
            white-space: nowrap;
        }
        
        .filter button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 140, 0, 0.3);
        }
        
        #map { 
            width: 100%; 
            min-height: 480px; 
            border-radius: 16px; 
            margin-bottom: 40px; 
            box-shadow: 0 12px 32px rgba(232, 65, 28, 0.12);
            overflow: hidden;
        }
        
        .section-title {
            font-size: 1.6rem;
            color: #E8411C;
            margin: 40px 0 24px 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .cards { 
            display: grid; 
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); 
            gap: 24px;
            margin-bottom: 40px;
        }
        
        .card { 
            background: white; 
            border-radius: 16px; 
            padding: 24px; 
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            border-left: 6px solid #FF8C00;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }
        
        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.12);
        }
        
        .card h3 { 
            margin: 0 0 12px 0; 
            color: #E8411C;
            font-size: 1.2rem;
        }
        
        .card-info {
            display: grid;
            gap: 10px;
            margin-bottom: 16px;
            flex: 1;
        }
        
        .card-field {
            display: grid;
            gap: 4px;
        }
        
        .card-field-label {
            font-weight: 600;
            color: #666;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .card-field-value {
            color: #333;
            font-size: 0.95rem;
        }
        
        .card button { 
            margin-top: auto;
            padding: 12px 16px; 
            border: none; 
            border-radius: 10px; 
            background: linear-gradient(135deg, #FF8C00, #FDB813); 
            color: #fff; 
            cursor: pointer; 
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .card-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 16px;
        }
        .delivery-form {
            display: none;
            margin-top: 16px;
            padding: 16px;
            border-radius: 18px;
            background: #fff8f0;
            border: 1px solid #fed8b1;
        }
        .delivery-form.active {
            display: block;
        }
        
        .card button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 140, 0, 0.3);
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: linear-gradient(135deg, rgba(255, 140, 0, 0.08), rgba(253, 184, 19, 0.08));
            border-radius: 16px;
            border-left: 6px solid #FF8C00;
        }
        
        .empty-state p {
            color: #666;
            font-size: 1.1rem;
            margin: 0;
        }
        
        .actions { 
            display: flex; 
            gap: 14px; 
            flex-wrap: wrap;
        }
        
        .actions a { 
            color: #333;
            text-decoration: none; 
            font-weight: 500;
            padding: 10px 16px;
            border-radius: 8px;
            transition: all 0.3s ease;
            white-space: nowrap;
        }
        
        .actions a:hover {
            background: rgba(255, 140, 0, 0.1);
            color: #FF8C00;
        }
        
        .actions a.btn-primary {
            background: linear-gradient(135deg, #FF8C00, #FDB813);
            color: white;
        }
        
        .actions a.btn-primary:hover {
            background: linear-gradient(135deg, #E8411C, #FF6C3C);
        }
        
        body.dark-mode {
            background: linear-gradient(180deg, #1a1a1a 0%, #2a2a2a 100%);
        }
        
        body.dark-mode .navbar {
            background: #2a2a2a;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }
        
        body.dark-mode .card,
        body.dark-mode .controls,
        body.dark-mode .welcome {
            background: #2a2a2a;
            color: #e0e0e0;
        }
        
        body.dark-mode .card-field-label,
        body.dark-mode .card-field-value {
            color: #b0b0b0;
        }
        
        body.dark-mode .filter input {
            background: #3a3a3a;
            color: #e0e0e0;
            border-color: #555;
        }
        
        @media (max-width: 768px) { 
            .navbar-content {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
            
            .navbar-menu {
                width: 100%;
                gap: 12px;
                font-size: 0.9rem;
            }
            
            .controls { 
                flex-direction: column; 
            }
            
            .filter {
                flex-direction: column;
                min-width: auto;
            }
            
            .filter input,
            .filter button {
                width: 100%;
            }
            
            .cards {
                grid-template-columns: 1fr;
            }
            
            .welcome {
                padding: 24px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-content">
            <a href="home.php" class="navbar-brand">
                <span>🍽️</span>
                <span>FomeOff</span>
            </a>
            <ul class="navbar-menu">
                <li><a href="home.php" class="active">Home</a></li>
                <li><a href="leis_doacoes.php">📋 Leis</a></li>
                <li><a href="configuracoes.php">⚙️ Configurações</a></li>
            </ul>
            <div class="navbar-location" id="locationBadge">
                <span class="location-icon">🚩</span>
                <span class="location-text">Localizando...</span>
            </div>
            <div class="navbar-actions">
                <a href="logout.php">🚪 Sair</a>
            </div>
        </div>
    </nav>
    
    <div class="home-container">
            <?php if ($success): ?>
                <div class="message success"><?php echo htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="message error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>

            <h1>👋 Bem-vindo, <?php echo htmlspecialchars($nome, ENT_QUOTES, 'UTF-8'); ?>!</h1>
            <p>Encontre alimentos disponíveis para doação próximo a você e faça a diferença na comunidade</p>
        </div>

        <div class="controls">
            <form class="filter" method="get">
                <input type="text" name="cep" placeholder="🔍 Buscar por CEP (ex: 12345-678)" value="<?php echo htmlspecialchars($cepFiltro, ENT_QUOTES, 'UTF-8'); ?>" />
                <button type="submit">Filtrar</button>
            </form>
            <div class="actions">
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'empresa'): ?>
                    <a href="../html/cadastroProduto.php" class="btn-primary">➕ Cadastrar Produto</a>
                <?php endif; ?>
            </div>
        </div>

        <div id="map"></div>

        <h2 class="section-title">📦 Produtos Disponíveis</h2>
        <?php if (empty($produtos)): ?>
            <div class="empty-state">
                <p>🚫 Nenhum produto cadastrado ainda.</p>
                <p>As empresas podem adicionar itens para doação clicando em "Cadastrar Produto".</p>
            </div>
        <?php else: ?>
            <div class="cards">
                <?php foreach ($produtos as $produto): ?>
                    <div class="card">
                        <h3>🎁 <?php echo htmlspecialchars($produto['nome_produto'], ENT_QUOTES, 'UTF-8'); ?></h3>
                        
                        <?php if (!empty($produto['imagem'])): ?>
                            <div style="margin-bottom:18px;text-align:center;">
                                <img src="../<?php echo htmlspecialchars($produto['imagem'], ENT_QUOTES, 'UTF-8'); ?>" alt="Foto do produto" style="max-width:100%;height:auto;border-radius:16px;object-fit:cover;border:1px solid #ffe5c8;" />
                            </div>
                        <?php endif; ?>
                        <div class="card-info">
                            <div class="card-field">
                                <div class="card-field-label">🏢 Empresa</div>
                                <div class="card-field-value"><?php echo htmlspecialchars($produto['empresa'], ENT_QUOTES, 'UTF-8'); ?></div>
                            </div>
                            
                            <div class="card-field">
                                <div class="card-field-label">📝 Descrição</div>
                                <div class="card-field-value"><?php echo htmlspecialchars($produto['descricao'], ENT_QUOTES, 'UTF-8'); ?></div>
                            </div>
                            
                            <div class="card-field">
                                <div class="card-field-label">📊 Quantidade</div>
                                <div class="card-field-value"><?php echo htmlspecialchars($produto['quantidade'], ENT_QUOTES, 'UTF-8'); ?> unidades</div>
                            </div>
                            
                            <div class="card-field">
                                <div class="card-field-label">�️ Validade</div>
                                <div class="card-field-value"><?php echo htmlspecialchars(date('d/m/Y', strtotime($produto['validade'])), ENT_QUOTES, 'UTF-8'); ?></div>
                            </div>

                            <div class="card-field">
                                <div class="card-field-label">�📍 CEP</div>
                                <div class="card-field-value"><?php echo htmlspecialchars($produto['cep'], ENT_QUOTES, 'UTF-8'); ?></div>
                            </div>
                        </div>
                        
                        <div class="card-actions">
                            <form method="post" action="solicitar.php" style="margin:0">
                                <input type="hidden" name="produto_id" value="<?php echo (int)$produto['id']; ?>" />
                                <input type="hidden" name="tipo" value="retirada" />
                                <button type="submit">✅ Solicitar Doação</button>
                            </form>
                            <button type="button" onclick="toggleDeliveryForm(<?php echo (int)$produto['id']; ?>)">🚚 Solicitar Entrega</button>
                        </div>

                        <div id="delivery-form-<?php echo (int)$produto['id']; ?>" class="delivery-form">
                            <form method="post" action="solicitar.php" style="margin:0">
                                <input type="hidden" name="produto_id" value="<?php echo (int)$produto['id']; ?>" />
                                <input type="hidden" name="tipo" value="entrega" />
                                <label style="display:block;margin-bottom:8px;font-weight:600;color:#666;">Informe o endereço de entrega</label>
                                <input type="text" name="endereco" placeholder="Rua, número, bairro, cidade" required style="width:100%;padding:12px;border-radius:12px;border:1px solid #E0E0E0;margin-bottom:10px;" />
                                <textarea name="observacoes" placeholder="Observações de entrega (opcional)" rows="3" style="width:100%;padding:12px;border-radius:12px;border:1px solid #E0E0E0;margin-bottom:10px;"></textarea>
                                <button type="submit" style="padding:10px 14px;border-radius:10px;background:linear-gradient(135deg,#FF8C00,#FDB813);color:#fff;border:none;">Enviar pedido de entrega</button>
                            </form>
                        </div>

                        <?php
                            // buscar avaliações deste produto
                            $stmtRev = $pdo->prepare('SELECT nota, comentario, usuario_email, created_at FROM avaliacoes WHERE produto_id = :id ORDER BY created_at DESC');
                            $stmtRev->execute([':id' => $produto['id']]);
                            $avaliacoes = $stmtRev->fetchAll(PDO::FETCH_ASSOC);
                        ?>

                        <?php if (!empty($avaliacoes)): ?>
                            <div style="margin-top:12px;">
                                <strong>Avaliações:</strong>
                                <?php foreach ($avaliacoes as $av): ?>
                                    <div style="margin-top:8px;padding:8px;border-radius:8px;background:#fff8f0;border:1px solid #ffecd1;">
                                        <div style="font-weight:600;color:#c94a00;">
                                            <?php echo str_repeat('⭐', max(1, (int)$av['nota'])); ?> <span style="font-weight:500;color:#333;margin-left:8px;">por <?php echo htmlspecialchars($av['usuario_email'], ENT_QUOTES, 'UTF-8'); ?></span>
                                        </div>
                                        <?php if (!empty($av['comentario'])): ?>
                                            <div style="margin-top:6px;color:#444;"><?php echo nl2br(htmlspecialchars($av['comentario'], ENT_QUOTES, 'UTF-8')); ?></div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <?php
                            // permitir avaliar somente se usuário solicitou (aprovado)
                            $canReview = false;
                            if (isset($_SESSION['email'])) {
                                $stmtSol = $pdo->prepare('SELECT COUNT(*) FROM solicitacoes WHERE produto_id = :id AND usuario_email = :email AND status = "aprovado"');
                                $stmtSol->execute([':id' => $produto['id'], ':email' => $_SESSION['email']]);
                                $canReview = $stmtSol->fetchColumn() > 0;

                                // verificar se já avaliou
                                $stmtOwn = $pdo->prepare('SELECT COUNT(*) FROM avaliacoes WHERE produto_id = :id AND usuario_email = :email');
                                $stmtOwn->execute([':id' => $produto['id'], ':email' => $_SESSION['email']]);
                                $alreadyReviewed = $stmtOwn->fetchColumn() > 0;
                            } else {
                                $alreadyReviewed = false;
                            }
                        ?>

                        <?php if (!empty($canReview) && !$alreadyReviewed): ?>
                            <form method="post" action="salvarAvaliacao.php" style="margin-top:12px;">
                                <input type="hidden" name="produto_id" value="<?php echo (int)$produto['id']; ?>" />
                                <label style="display:block;margin-bottom:6px;font-weight:600;color:#666;">Deixe sua avaliação</label>
                                <div style="display:flex;gap:8px;align-items:center;">
                                    <select name="nota" required style="padding:8px;border-radius:8px;border:1px solid #e9caa8;">
                                        <option value="">Nota</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                    <input name="comentario" placeholder="Comentário (opcional)" style="flex:1;padding:8px;border-radius:8px;border:1px solid #e9caa8;" />
                                    <button type="submit" style="padding:8px 12px;border-radius:8px;background:linear-gradient(135deg,#FF8C00,#FDB813);color:#fff;border:none;">Avaliar</button>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="../js/accessibility.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    <script>
        function solicitarProduto(empresa) {
            alert(`✅ Solicitação enviada para ${empresa}!\n\nEm breve você será contatado com as instruções de coleta.`);
        }
        
        const produtos = <?php echo json_encode($produtos, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
        const mapElement = document.getElementById('map');
        const map = L.map(mapElement).setView([-23.550520, -46.633308], 5);
        let markers = [];

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        function addProductMarkers() {
            produtos.forEach((produto) => {
                const lat = parseFloat(produto.latitude);
                const lon = parseFloat(produto.longitude);
                if (
                    produto.latitude !== null && produto.longitude !== null &&
                    produto.latitude !== '' && produto.longitude !== '' &&
                    !isNaN(lat) && !isNaN(lon)
                ) {
                    const marker = L.marker([lat, lon]).addTo(map);
                    marker.bindPopup(`
                        <strong>🏢 ${produto.empresa}</strong><br>
                        <strong>🎁 ${produto.nome_produto}</strong><br>
                        📝 ${produto.descricao}<br>
                        📊 Quantidade: ${produto.quantidade}<br>
                        📍 CEP: ${produto.cep}
                    `);
                    markers.push(marker);
                }
            });
        }

        function toggleDeliveryForm(id) {
            const el = document.getElementById(`delivery-form-${id}`);
            if (el) {
                el.classList.toggle('active');
            }
        }

        function setUserLocation(lat, lon) {
            const userMarker = L.circleMarker([lat, lon], {
                radius: 12,
                fillColor: '#FF8C00',
                color: '#E8411C',
                weight: 3,
                fillOpacity: 0.9,
            }).addTo(map);
            userMarker.bindPopup('📍 Você está aqui');
            map.setView([lat, lon], 13);
        }

        addProductMarkers();

        function updateLocationBadge(lat, lon) {
            const badge = document.getElementById('locationBadge');
            const textElement = badge ? badge.querySelector('.location-text') : null;
            if (textElement) {
                textElement.textContent = 'Localizando...';
            }

            fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lon}`)
                .then((response) => response.json())
                .then((data) => {
                    const address = data.address || {};
                    const city = address.city || address.town || address.village || address.county || '';
                    const state = address.state || address.state_district || '';
                    const locationText = [city, state].filter(Boolean).join(', ');
                    if (textElement) {
                        textElement.textContent = locationText || 'Localização encontrada';
                    }
                })
                .catch(() => {
                    if (textElement) {
                        textElement.textContent = 'Localização encontrada';
                    }
                });
        }

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    setUserLocation(position.coords.latitude, position.coords.longitude);
                    updateLocationBadge(position.coords.latitude, position.coords.longitude);
                },
                () => {
                    console.warn('Localização não permitida; mostrando mapa geral.');
                    const badge = document.getElementById('locationBadge');
                    if (badge) {
                        const textElement = badge.querySelector('.location-text');
                        if (textElement) {
                            textElement.textContent = 'Localização indisponível';
                        }
                    }
                },
                { enableHighAccuracy: true, timeout: 10000 }
            );
        } else {
            const badge = document.getElementById('locationBadge');
            if (badge) {
                const textElement = badge.querySelector('.location-text');
                if (textElement) {
                    textElement.textContent = 'Geolocalização não suportada';
                }
            }
        }
    </script>
</body>
</html>

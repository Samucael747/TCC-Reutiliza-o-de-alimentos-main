<?php
session_start();
if (!isset($_SESSION['nome'])) {
    header('Location: ../index.php?error=Voce+precisa+logar+primeiro');
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
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home | FomeOff</title>
    <link rel="stylesheet" href="../css/index.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-sA+e2k0Y2RadBqtHVEL0oCe1kt+QcR4y1iwXQExgH30=" crossorigin="" />
    <style>
        body { background: linear-gradient(180deg, #FFE4B5 0%, #FFF3E0 100%); }
        .home-container { max-width: 1024px; margin: 0 auto; padding: 24px; }
        .welcome { text-align: center; margin-bottom: 24px; }
        .controls { display: flex; flex-wrap: wrap; gap: 12px; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .filter { display: flex; gap: 10px; flex-wrap: wrap; }
        .filter input { padding: 12px 14px; border: 1px solid #E0B299; border-radius: 14px; background: #FFF8F0; }
        .filter button { padding: 12px 18px; border: none; border-radius: 14px; background: linear-gradient(135deg, #FF8C00, #FDB813); color: #fff; cursor: pointer; font-weight: 600; }
        #map { width: 100%; min-height: 420px; border-radius: 24px; margin-bottom: 28px; box-shadow: 0 12px 24px rgba(232, 65, 28, 0.12); }
        .cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 18px; }
        .card { background: #fff; border-radius: 24px; padding: 20px; box-shadow: 0 18px 45px rgba(232, 65, 28, 0.08); border-left: 4px solid #FF8C00; }
        .card h3 { margin-top: 0; color: #E8411C; }
        .card strong { display: block; margin-bottom: 8px; color: #D84315; }
        .card button { margin-top: 14px; padding: 10px 14px; border: none; border-radius: 14px; background: linear-gradient(135deg, #FF8C00, #FDB813); color: #fff; cursor: pointer; font-weight: 600; }
        .actions { display: flex; gap: 12px; flex-wrap: wrap; }
        .actions a { color: #E8411C; text-decoration: none; font-weight: 600; }
        @media (max-width: 720px) { .controls { flex-direction: column; align-items: stretch; } }
    </style>
</head>
<body>
    <div class="home-container">
        <div class="welcome">
            <h1>Bem-vindo, <?php echo htmlspecialchars($nome, ENT_QUOTES, 'UTF-8'); ?>!</h1>
            <p>Encontre produtos disponíveis para doação e visualize a localidade em tempo real.</p>
        </div>

        <div class="controls">
            <form class="filter" method="get">
                <input type="text" name="cep" placeholder="Buscar por CEP (12345-678)" value="<?php echo htmlspecialchars($cepFiltro, ENT_QUOTES, 'UTF-8'); ?>" />
                <button type="submit">Filtrar CEP</button>
            </form>
            <div class="actions">
                <a href="../html/cadastroProduto.php">Cadastrar produto</a>
                <a href="logout.php">Sair</a>
            </div>
        </div>

        <div id="map"></div>

        <h2>Produtos disponíveis</h2>
        <?php if (empty($produtos)): ?>
            <p>Nenhum produto cadastrado ainda. As empresas podem adicionar itens para doação.</p>
        <?php else: ?>
            <div class="cards">
                <?php foreach ($produtos as $produto): ?>
                    <div class="card">
                        <h3><?php echo htmlspecialchars($produto['nome_produto'], ENT_QUOTES, 'UTF-8'); ?></h3>
                        <p><strong>Empresa:</strong> <?php echo htmlspecialchars($produto['empresa'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <p><strong>Descrição:</strong> <?php echo htmlspecialchars($produto['descricao'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <p><strong>Quantidade:</strong> <?php echo htmlspecialchars($produto['quantidade'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <p><strong>CEP:</strong> <?php echo htmlspecialchars($produto['cep'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <button type="button" onclick="alert('Solicitação enviada para <?php echo htmlspecialchars($produto['empresa'], ENT_QUOTES, 'UTF-8'); ?>.');">Solicitar produto</button>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-o9N1j8EpcZCkkh4d6E2s3sSCM6qMmqjv3c1hczp6pRo=" crossorigin=""></script>
    <script>
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
                if (!isNaN(lat) && !isNaN(lon)) {
                    const marker = L.marker([lat, lon]).addTo(map);
                    marker.bindPopup(`<strong>${produto.empresa}</strong><br>${produto.nome_produto}<br>CEP: ${produto.cep}`);
                    markers.push(marker);
                }
            });
        }

        function setUserLocation(lat, lon) {
            const userMarker = L.circleMarker([lat, lon], {
                radius: 10,
                fillColor: '#FF8C00',
                color: '#E8411C',
                weight: 3,
                fillOpacity: 0.9,
            }).addTo(map);
            userMarker.bindPopup('Você está aqui');
            map.setView([lat, lon], 13);
        }

        addProductMarkers();

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    setUserLocation(position.coords.latitude, position.coords.longitude);
                },
                () => {
                    console.warn('Localização não permitida; mostrando mapa geral.');
                },
                { enableHighAccuracy: true, timeout: 10000 }
            );
        }
    </script>
</body>
</html>
                                                     
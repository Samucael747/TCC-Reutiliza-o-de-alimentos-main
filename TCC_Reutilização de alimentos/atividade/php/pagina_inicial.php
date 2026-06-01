<?php
session_start();
if (!isset($_SESSION['nome'])) {
    header("Location: ../index.php?error=Voce+precisa+logar+primeiro");
    exit;
}

$nome = $_SESSION['nome'];

// Simulação de busca de doações (substitua por consulta real ao banco)
$doacoes = [
    ['id' => 1, 'empresa' => 'Supermercado X', 'cep' => '12345-678', 'descricao' => 'Pães frescos', 'quantidade' => 50],
    ['id' => 2, 'empresa' => 'Restaurante Y', 'cep' => '12345-679', 'descricao' => 'Frutas', 'quantidade' => 30],
    // Adicione mais dados ou busque do banco
];

// Filtro por CEP (lógica simples: compara prefixo do CEP)
$cepFiltro = $_GET['cep'] ?? '';
$doacoesFiltradas = $doacoes;
if ($cepFiltro) {
    $doacoesFiltradas = array_filter($doacoes, function($d) use ($cepFiltro) {
        return strpos($d['cep'], substr($cepFiltro, 0, 5)) === 0; // Compara primeiros 5 dígitos
    });
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<?php
$pageTitle = 'Home | FomeOff';
include __DIR__ . '/head.php';
?>
<body>
    <div class="home-container">
        <div class="welcome">
            <h1>Bem-vindo, <?php echo htmlspecialchars($nome); ?>!</h1>
            <p>Encontre doações de alimentos próximas a você.</p>
            <figure class="welcome-image">
            </figure>
        </div>

        <div class="filter">
            <form method="get">
                <input type="text" name="cep" placeholder="Digite seu CEP (ex: 12345-678)" value="<?php echo htmlspecialchars($cepFiltro); ?>" required>
                <button type="submit">Buscar próximos</button>
            </form>
        </div>

        <h2>Doações disponíveis</h2>
        <?php if (empty($doacoesFiltradas)): ?>
            <p>Nenhuma doação encontrada próxima ao seu CEP.</p>
        <?php else: ?>
            <?php foreach ($doacoesFiltradas as $doacao): ?>
                <div class="doacao-card">
                    <h3><?php echo htmlspecialchars($doacao['empresa']); ?></h3>
                    <p><strong>Descrição:</strong> <?php echo htmlspecialchars($doacao['descricao']); ?></p>
                    <p><strong>Quantidade:</strong> <?php echo htmlspecialchars($doacao['quantidade']); ?> unidades</p>
                    <p><strong>CEP:</strong> <?php echo htmlspecialchars($doacao['cep']); ?></p>
                    <button onclick="alert('Solicitação enviada para <?php echo htmlspecialchars($doacao['empresa']); ?>')">Solicitar doação</button>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <div class="logout">
            <a href="logout.php">Sair</a>
        </div>
    </div>
</body>
<script src="../js/site-brand.js"></script>
</html>
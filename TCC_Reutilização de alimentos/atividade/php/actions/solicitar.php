<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: ../../entrar.php?error=Voce+precisa+logar+para+solicitar');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../dashboard.php');
    exit;
}

require __DIR__ . '/../includes/conexao.php';
if (!$pdo) {
    header('Location: ../dashboard.php?error=Erro+de+conexao+com+banco');
    exit;
}

$produto_id = (int)($_POST['produto_id'] ?? 0);
$tipo = $_POST['tipo'] ?? 'retirada';
$endereco = trim($_POST['endereco'] ?? '');
$observacoes = trim($_POST['observacoes'] ?? '');

if ($produto_id <= 0) {
    header('Location: ../dashboard.php?error=Produto+invalido');
    exit;
}

if ($tipo === 'entrega' && $endereco === '') {
    header('Location: ../dashboard.php?error=Endereco+de+entrega+obrigatorio');
    exit;
}

try {
    $stmtProduto = $pdo->prepare('SELECT empresa, cnpj, cep, nome_produto, quantidade FROM produtos WHERE id = :id');
    $stmtProduto->execute([':id' => $produto_id]);
    $produto = $stmtProduto->fetch(PDO::FETCH_ASSOC);

    if (!$produto) {
        header('Location: ../dashboard.php?error=Produto+nao+encontrado');
        exit;
    }

    $pdo->beginTransaction();

    $stmt = $pdo->prepare('INSERT INTO solicitacoes (produto_id, usuario_email, status, tipo_entrega, endereco_entrega, observacoes) VALUES (:pid, :email, :status, :tipo, :endereco, :observacoes)');
    $stmt->execute([
        ':pid' => $produto_id,
        ':email' => $_SESSION['email'],
        ':status' => 'aprovado',
        ':tipo' => $tipo,
        ':endereco' => $tipo === 'entrega' ? $endereco : null,
        ':observacoes' => $tipo === 'entrega' ? $observacoes : null,
    ]);

    $localizacaoRetirada = $tipo === 'entrega' ? $endereco : ($produto['cep'] ?? '');
    $stmtDoacao = $pdo->prepare('INSERT INTO doacoes (produto_id, usuario_email, empresa, cnpj, nome_produto, quantidade, tipo_entrega, localizacao_retirada, endereco_entrega, observacoes) VALUES (:pid, :email, :empresa, :cnpj, :nome_produto, :quantidade, :tipo, :localizacao, :endereco, :observacoes)');
    $stmtDoacao->execute([
        ':pid' => $produto_id,
        ':email' => $_SESSION['email'],
        ':empresa' => $produto['empresa'],
        ':cnpj' => $produto['cnpj'],
        ':nome_produto' => $produto['nome_produto'],
        ':quantidade' => (int)$produto['quantidade'],
        ':tipo' => $tipo,
        ':localizacao' => $localizacaoRetirada,
        ':endereco' => $tipo === 'entrega' ? $endereco : null,
        ':observacoes' => $observacoes ?: null,
    ]);

    $pdo->commit();

    if ($tipo === 'entrega') {
        header('Location: ../dashboard.php?success=Pedido+de+entrega+registrado.+A+empresa+sera+contactada');
    } else {
        header('Location: ../dashboard.php?success=Solicitacao+registrada.+Verifique+suas+mensagens');
    }
    exit;
} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    header('Location: ../dashboard.php?error=Erro+ao+registrar+solicitacao');
    exit;
}






<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: ../index.php?error=Voce+precisa+logar+para+solicitar');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: home.php');
    exit;
}

require 'conexao.php';
if (!$pdo) {
    header('Location: home.php?error=Erro+de+conexao+com+banco');
    exit;
}

$produto_id = (int)($_POST['produto_id'] ?? 0);
$tipo = $_POST['tipo'] ?? 'retirada';
$endereco = trim($_POST['endereco'] ?? '');
$observacoes = trim($_POST['observacoes'] ?? '');

if ($produto_id <= 0) {
    header('Location: home.php?error=Produto+invalido');
    exit;
}

if ($tipo === 'entrega' && $endereco === '') {
    header('Location: home.php?error=Endereco+de+entrega+obrigatorio');
    exit;
}

try {
    $stmt = $pdo->prepare('INSERT INTO solicitacoes (produto_id, usuario_email, status, tipo_entrega, endereco_entrega, observacoes) VALUES (:pid, :email, :status, :tipo, :endereco, :observacoes)');
    $stmt->execute([
        ':pid' => $produto_id,
        ':email' => $_SESSION['email'],
        ':status' => 'aprovado',
        ':tipo' => $tipo,
        ':endereco' => $tipo === 'entrega' ? $endereco : null,
        ':observacoes' => $tipo === 'entrega' ? $observacoes : null,
    ]);

    if ($tipo === 'entrega') {
        header('Location: home.php?success=Pedido+de+entrega+registrado.+A+empresa+sera+contactada');
    } else {
        header('Location: home.php?success=Solicitacao+registrada.+Verifique+suas+mensagens');
    }
    exit;
} catch (PDOException $e) {
    header('Location: home.php?error=Erro+ao+registrar+solicitacao');
    exit;
}

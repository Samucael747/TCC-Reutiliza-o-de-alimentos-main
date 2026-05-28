<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: ../index.php?error=Voce+precisa+logar+para+avaliar');
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
$nota = (int)($_POST['nota'] ?? 0);
$comentario = trim($_POST['comentario'] ?? '');

if ($produto_id <= 0 || $nota < 1 || $nota > 5) {
    header('Location: home.php?error=Dados+invalidos+para+avaliacao');
    exit;
}

// verificar se usuario tem solicitacao aprovada
$stmt = $pdo->prepare('SELECT COUNT(*) FROM solicitacoes WHERE produto_id = :pid AND usuario_email = :email AND status = "aprovado"');
$stmt->execute([':pid' => $produto_id, ':email' => $_SESSION['email']]);
$has = $stmt->fetchColumn();
if (!$has) {
    header('Location: home.php?error=Somente+usuarios+que+retiraram+a+doacao+podem+avaliar');
    exit;
}

// evitar avaliacoes duplicadas do mesmo usuario para o mesmo produto
$stmt = $pdo->prepare('SELECT COUNT(*) FROM avaliacoes WHERE produto_id = :pid AND usuario_email = :email');
$stmt->execute([':pid' => $produto_id, ':email' => $_SESSION['email']]);
if ($stmt->fetchColumn() > 0) {
    header('Location: home.php?error=Voce+ja+avaliou+este+produto');
    exit;
}

// obter nome da empresa para registrar na avaliacao
$stmt = $pdo->prepare('SELECT empresa FROM produtos WHERE id = :pid LIMIT 1');
$stmt->execute([':pid' => $produto_id]);
$produto = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$produto) {
    header('Location: home.php?error=Produto+nao+encontrado');
    exit;
}

try {
    $stmt = $pdo->prepare('INSERT INTO avaliacoes (produto_id, empresa, usuario_email, nota, comentario) VALUES (:pid, :empresa, :email, :nota, :comentario)');
    $stmt->execute([
        ':pid' => $produto_id,
        ':empresa' => $produto['empresa'],
        ':email' => $_SESSION['email'],
        ':nota' => $nota,
        ':comentario' => $comentario
    ]);

    header('Location: home.php?success=Avaliacao+registrada.+Obrigado');
    exit;
} catch (PDOException $e) {
    header('Location: home.php?error=Erro+ao+salvar+avaliacao');
    exit;
}

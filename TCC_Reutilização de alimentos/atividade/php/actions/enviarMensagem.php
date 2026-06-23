<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['email'])) {
    echo json_encode(['ok' => false, 'error' => 'Não autenticado']);
    exit;
}

$empresa_id = (int)($_POST['empresa_id'] ?? 0);
$texto      = trim($_POST['texto'] ?? '');

if ($empresa_id <= 0 || $texto === '') {
    echo json_encode(['ok' => false, 'error' => 'Dados inválidos']);
    exit;
}

require __DIR__ . '/../includes/conexao.php';

$stmt = $pdo->prepare('INSERT INTO mensagens (usuario_email, empresa_id, remetente, texto) VALUES (:email, :eid, :rem, :txt)');
$stmt->execute([
    ':email' => $_SESSION['email'],
    ':eid'   => $empresa_id,
    ':rem'   => 'usuario',
    ':txt'   => $texto,
]);

echo json_encode(['ok' => true, 'id' => $pdo->lastInsertId()]);

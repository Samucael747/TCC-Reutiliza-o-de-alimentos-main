<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['email'])) {
    echo json_encode([]);
    exit;
}

$empresa_id = (int)($_GET['empresa_id'] ?? 0);
if ($empresa_id <= 0) {
    echo json_encode([]);
    exit;
}

require __DIR__ . '/../includes/conexao.php';

$stmt = $pdo->prepare('SELECT remetente, texto, created_at FROM mensagens WHERE usuario_email = :email AND empresa_id = :eid ORDER BY created_at ASC');
$stmt->execute([':email' => $_SESSION['email'], ':eid' => $empresa_id]);
$msgs = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($msgs);

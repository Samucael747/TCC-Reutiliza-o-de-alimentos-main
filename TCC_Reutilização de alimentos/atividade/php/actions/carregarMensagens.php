<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['email'])) {
    echo json_encode([]);
    exit;
}

require __DIR__ . '/../includes/conexao.php';
if (!$pdo) { echo json_encode([]); exit; }

$role = $_SESSION['role'] ?? 'usuario';

if ($role === 'empresa') {
    // Empresa busca conversa com um usuário específico
    $usuario_email = trim($_GET['usuario_email'] ?? '');
    if ($usuario_email === '') {
        echo json_encode([]);
        exit;
    }
    $stmtEmp = $pdo->prepare('SELECT id FROM empresas WHERE email = :e LIMIT 1');
    $stmtEmp->execute([':e' => $_SESSION['email']]);
    $emp = $stmtEmp->fetch(PDO::FETCH_ASSOC);
    if (!$emp) { echo json_encode([]); exit; }

    $stmt = $pdo->prepare('SELECT remetente, texto, created_at FROM mensagens WHERE empresa_id = :eid AND usuario_email = :uemail ORDER BY created_at ASC');
    $stmt->execute([':eid' => $emp['id'], ':uemail' => $usuario_email]);
} else {
    // Usuário busca conversa com uma empresa específica
    $empresa_id = (int)($_GET['empresa_id'] ?? 0);
    if ($empresa_id <= 0) { echo json_encode([]); exit; }

    $stmt = $pdo->prepare('SELECT remetente, texto, created_at FROM mensagens WHERE usuario_email = :email AND empresa_id = :eid ORDER BY created_at ASC');
    $stmt->execute([':email' => $_SESSION['email'], ':eid' => $empresa_id]);
}

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));

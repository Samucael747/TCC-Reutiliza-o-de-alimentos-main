<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['email'])) { echo json_encode(['ok' => false]); exit; }

require __DIR__ . '/../includes/conexao.php';
if (!$pdo) { echo json_encode(['ok' => false]); exit; }
/** @var \PDO $pdo */

$role = $_SESSION['role'] ?? 'usuario';

if ($role === 'empresa') {
    $usuario_email = trim($_POST['usuario_email'] ?? '');
    if (!$usuario_email) { echo json_encode(['ok' => false]); exit; }
    $stmtEmp = $pdo->prepare('SELECT id FROM empresas WHERE email = :e LIMIT 1');
    $stmtEmp->execute([':e' => $_SESSION['email']]);
    $emp = $stmtEmp->fetch(PDO::FETCH_ASSOC);
    if (!$emp) { echo json_encode(['ok' => false]); exit; }
    $stmt = $pdo->prepare('UPDATE mensagens SET lida = 1 WHERE empresa_id = :eid AND usuario_email = :uemail AND remetente = :rem AND lida = 0');
    $stmt->execute([':eid' => $emp['id'], ':uemail' => $usuario_email, ':rem' => 'usuario']);
} else {
    $empresa_id = (int)($_POST['empresa_id'] ?? 0);
    if ($empresa_id <= 0) { echo json_encode(['ok' => false]); exit; }
    $stmt = $pdo->prepare('UPDATE mensagens SET lida = 1 WHERE usuario_email = :email AND empresa_id = :eid AND remetente = :rem AND lida = 0');
    $stmt->execute([':email' => $_SESSION['email'], ':eid' => $empresa_id, ':rem' => 'voluntario']);
}

echo json_encode(['ok' => true]);

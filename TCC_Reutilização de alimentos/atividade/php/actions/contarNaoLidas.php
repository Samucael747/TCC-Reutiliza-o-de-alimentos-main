<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['email'])) { echo json_encode(['count' => 0]); exit; }

require __DIR__ . '/../includes/conexao.php';
if (!$pdo) { echo json_encode(['count' => 0]); exit; }
/** @var \PDO $pdo */

$role = $_SESSION['role'] ?? 'usuario';

if ($role === 'empresa') {
    $stmtEmp = $pdo->prepare('SELECT id FROM empresas WHERE email = :e LIMIT 1');
    $stmtEmp->execute([':e' => $_SESSION['email']]);
    $emp = $stmtEmp->fetch(PDO::FETCH_ASSOC);
    if (!$emp) { echo json_encode(['count' => 0]); exit; }
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM mensagens WHERE empresa_id = :eid AND remetente = :rem AND lida = 0');
    $stmt->execute([':eid' => $emp['id'], ':rem' => 'usuario']);
} else {
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM mensagens WHERE usuario_email = :email AND remetente = :rem AND lida = 0');
    $stmt->execute([':email' => $_SESSION['email'], ':rem' => 'voluntario']);
}

echo json_encode(['count' => (int)$stmt->fetchColumn()]);

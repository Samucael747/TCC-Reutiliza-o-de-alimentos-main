<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['email'])) {
    echo json_encode(['ok' => false, 'error' => 'Não autenticado']);
    exit;
}

$texto = trim($_POST['texto'] ?? '');
if ($texto === '') {
    echo json_encode(['ok' => false, 'error' => 'Mensagem vazia']);
    exit;
}

require __DIR__ . '/../includes/conexao.php';
if (!$pdo) {
    echo json_encode(['ok' => false, 'error' => 'Banco indisponível']);
    exit;
}
/** @var \PDO $pdo */

$role = $_SESSION['role'] ?? 'usuario';

if ($role === 'empresa') {
    $usuario_email = trim($_POST['usuario_email'] ?? '');
    if ($usuario_email === '') {
        echo json_encode(['ok' => false, 'error' => 'Usuário não informado']);
        exit;
    }
    $stmtEmp = $pdo->prepare('SELECT id FROM empresas WHERE email = :e LIMIT 1');
    $stmtEmp->execute([':e' => $_SESSION['email']]);
    $emp = $stmtEmp->fetch(PDO::FETCH_ASSOC);
    if (!$emp) {
        echo json_encode(['ok' => false, 'error' => 'Empresa não encontrada']);
        exit;
    }
    $stmt = $pdo->prepare('INSERT INTO mensagens (usuario_email, empresa_id, remetente, texto) VALUES (:uemail, :eid, :rem, :txt)');
    $stmt->execute([':uemail' => $usuario_email, ':eid' => $emp['id'], ':rem' => 'voluntario', ':txt' => $texto]);
} else {
    $empresa_id = (int)($_POST['empresa_id'] ?? 0);
    if ($empresa_id <= 0) {
        echo json_encode(['ok' => false, 'error' => 'Empresa inválida']);
        exit;
    }
    $stmt = $pdo->prepare('INSERT INTO mensagens (usuario_email, empresa_id, remetente, texto) VALUES (:email, :eid, :rem, :txt)');
    $stmt->execute([':email' => $_SESSION['email'], ':eid' => $empresa_id, ':rem' => 'usuario', ':txt' => $texto]);
}

echo json_encode(['ok' => true]);

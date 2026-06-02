<?php
session_start();
if (!isset($_SESSION['email'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Não autenticado']);
    exit;
}

header('Content-Type: application/json');

require __DIR__ . '/../includes/conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(400);
    echo json_encode(['error' => 'Método não permitido']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$email = $_SESSION['email'];
$role = $_SESSION['role'] ?? 'usuario';

if (!$data) {
    http_response_code(400);
    echo json_encode(['error' => 'Dados inválidos']);
    exit;
}

$accessibilityPreferences = json_encode($data);

try {
    if ($role === 'empresa') {
        $stmt = $pdo->prepare('UPDATE empresas SET acessibilidade_preferences = :preferences WHERE email = :email');
    } else {
        $stmt = $pdo->prepare('UPDATE usuarios SET acessibilidade_preferences = :preferences WHERE email = :email');
    }

    $stmt->execute([
        ':preferences' => $accessibilityPreferences,
        ':email' => $email
    ]);

    http_response_code(200);
    echo json_encode(['success' => true, 'message' => 'Preferências de acessibilidade salvas']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro ao salvar preferências: ' . $e->getMessage()]);
}
?>


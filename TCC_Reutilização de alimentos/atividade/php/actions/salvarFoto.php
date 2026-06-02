<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: ../entrar.php?error=Voce+precisa+logar+primeiro');
    exit;
}

header('Content-Type: application/json');
require __DIR__ . '/../includes/conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(400);
    echo json_encode(['error' => 'Método não permitido']);
    exit;
}

$email = $_SESSION['email'];
$role = $_SESSION['role'] ?? 'usuario';
$response = ['success' => false];

// Verificar se um arquivo foi enviado
if (!isset($_FILES['foto']) || $_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(['error' => 'Nenhum arquivo foi enviado ou ocorreu um erro']);
    exit;
}

$file = $_FILES['foto'];
$maxSize = 5 * 1024 * 1024; // 5MB
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

// Validar tamanho
if ($file['size'] > $maxSize) {
    http_response_code(400);
    echo json_encode(['error' => 'Arquivo muito grande. Máximo 5MB']);
    exit;
}

// Validar tipo
if (!in_array($file['type'], $allowedTypes)) {
    http_response_code(400);
    echo json_encode(['error' => 'Tipo de arquivo não permitido. Use JPG, PNG, GIF ou WebP']);
    exit;
}

// Criar diretório se não existir
$uploadDir = '../uploads/fotos/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Gerar nome único para o arquivo
$fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
$fileName = 'foto_' . $role . '_' . md5($email . time()) . '.' . $fileExtension;
$filePath = $uploadDir . $fileName;
$fileUrl = str_replace('\\', '/', $filePath);

// Mover arquivo
if (!move_uploaded_file($file['tmp_name'], $filePath)) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro ao salvar arquivo']);
    exit;
}

// Salvar caminho da foto no banco de dados
try {
    if ($role === 'empresa') {
        $stmt = $pdo->prepare('UPDATE empresas SET foto_perfil = :foto WHERE email = :email');
    } else {
        $stmt = $pdo->prepare('UPDATE usuarios SET foto_perfil = :foto WHERE email = :email');
    }

    $stmt->execute([
        ':foto' => $fileUrl,
        ':email' => $email
    ]);

    $response['success'] = true;
    $response['message'] = 'Foto de perfil atualizada com sucesso';
    $response['fotoUrl'] = $fileUrl;

    http_response_code(200);
    echo json_encode($response);
} catch (Exception $e) {
    // Remover arquivo se o banco falhar
    @unlink($filePath);

    http_response_code(500);
    echo json_encode(['error' => 'Erro ao salvar no banco de dados: ' . $e->getMessage()]);
}
?>



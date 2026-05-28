<?php
/**
 * Script de Inicialização
 * 
 * Este script verifica e cria as estruturas necessárias para o site funcionar corretamente.
 * Execute este arquivo uma única vez após fazer download do projeto.
 * 
 * Acesso: http://localhost/TCC_Reutilização%20de%20alimentos/atividade/init.php
 */

session_start();

// Array para armazenar status
$status = [
    'success' => [],
    'warning' => [],
    'error' => []
];

// 1. Verificar/Criar diretório de uploads
$uploadDir = __DIR__ . '/uploads/fotos';
if (!is_dir($uploadDir)) {
    if (@mkdir($uploadDir, 0755, true)) {
        $status['success'][] = "✅ Diretório 'uploads/fotos' criado com sucesso";
    } else {
        $status['error'][] = "❌ Erro ao criar diretório 'uploads/fotos'";
    }
} else {
    $status['success'][] = "✅ Diretório 'uploads/fotos' já existe";
}

// 2. Verificar se diretório é gravável
if (is_writable($uploadDir)) {
    $status['success'][] = "✅ Diretório 'uploads/fotos' é gravável";
} else {
    $status['error'][] = "❌ Diretório 'uploads/fotos' não é gravável. Verifique as permissões.";
}

// 3. Criar arquivo placeholder para fotos
$placeholderDir = __DIR__ . '/images';
if (!is_dir($placeholderDir)) {
    @mkdir($placeholderDir, 0755, true);
}

$placeholderFile = $placeholderDir . '/user-placeholder.png';
if (!file_exists($placeholderFile)) {
    // Criar uma imagem placeholder simples usando GD Library
    if (extension_loaded('gd')) {
        $image = imagecreatetruecolor(200, 200);
        $bgColor = imagecolorallocate($image, 230, 230, 230);
        $textColor = imagecolorallocate($image, 200, 200, 200);
        
        imagefill($image, 0, 0, $bgColor);
        imagestring($image, 5, 50, 90, 'User Photo', $textColor);
        
        imagepng($image, $placeholderFile);
        imagedestroy($image);
        
        $status['success'][] = "✅ Arquivo placeholder 'user-placeholder.png' criado";
    } else {
        $status['warning'][] = "⚠️ GD Library não disponível. Imagem placeholder não foi criada.";
    }
} else {
    $status['success'][] = "✅ Arquivo placeholder já existe";
}

// 4. Verificar conexão com banco de dados
require_once __DIR__ . '/php/conexao.php';

try {
    if ($pdo) {
        $status['success'][] = "✅ Conexão com banco de dados estabelecida";
        
        // Verificar se as tabelas existem
        $tables = ['usuarios', 'empresas', 'produtos', 'doacoes'];
        foreach ($tables as $table) {
            $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
            if ($stmt->rowCount() > 0) {
                $status['success'][] = "✅ Tabela '$table' existe";
            } else {
                $status['error'][] = "❌ Tabela '$table' não encontrada";
            }
        }
        
        // Verificar se os novos campos existem
        $stmt = $pdo->query("DESCRIBE usuarios");
        $columns = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        
        if (in_array('foto_perfil', $columns)) {
            $status['success'][] = "✅ Campo 'foto_perfil' existe na tabela 'usuarios'";
        } else {
            $status['warning'][] = "⚠️ Campo 'foto_perfil' não encontrado. Execute o SQL de atualização.";
        }
        
        if (in_array('acessibilidade_preferences', $columns)) {
            $status['success'][] = "✅ Campo 'acessibilidade_preferences' existe";
        } else {
            $status['warning'][] = "⚠️ Campo 'acessibilidade_preferences' não encontrado. Execute o SQL de atualização.";
        }
    } else {
        $status['error'][] = "❌ Falha ao conectar com o banco de dados";
    }
} catch (Exception $e) {
    $status['error'][] = "❌ Erro: " . $e->getMessage();
}

// 5. Verificar se os arquivos existem
$requiredFiles = [
    'php/leis_doacoes.php' => 'Página de Leis',
    'php/salvarFoto.php' => 'Script de Upload de Foto',
    'php/salvarAcessibilidade.php' => 'Script de Acessibilidade',
    'js/accessibility.js' => 'JavaScript de Acessibilidade',
    'css/leis.css' => 'CSS da Página de Leis',
    'css/acessibilidade.css' => 'CSS de Acessibilidade',
    'css/accessibility-panel.css' => 'CSS do Painel de Acessibilidade'
];

foreach ($requiredFiles as $file => $name) {
    $path = __DIR__ . '/' . $file;
    if (file_exists($path)) {
        $status['success'][] = "✅ Arquivo '$name' existe";
    } else {
        $status['error'][] = "❌ Arquivo '$name' não encontrado em '$file'";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicialização | FomeOff</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #FFF3E0 0%, #FFE4B5 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            max-width: 700px;
            width: 100%;
            padding: 40px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .header h1 {
            font-size: 2.5rem;
            color: #E8411C;
            margin-bottom: 10px;
        }
        
        .header p {
            color: #666;
            font-size: 1.1rem;
        }
        
        .status-section {
            margin-bottom: 30px;
        }
        
        .status-section h2 {
            font-size: 1.3rem;
            color: #333;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 3px solid #FF8C00;
        }
        
        .status-item {
            padding: 12px;
            margin: 8px 0;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .status-item.success {
            background: #E8F5E9;
            color: #256029;
            border-left: 4px solid #4CAF50;
        }
        
        .status-item.warning {
            background: #FFF3E0;
            color: #E65100;
            border-left: 4px solid #FF9800;
        }
        
        .status-item.error {
            background: #FFEBEE;
            color: #C62828;
            border-left: 4px solid #F44336;
        }
        
        .status-item strong {
            flex: 1;
        }
        
        .action-buttons {
            display: flex;
            gap: 12px;
            margin-top: 30px;
            flex-wrap: wrap;
        }
        
        .btn {
            flex: 1;
            min-width: 150px;
            padding: 14px 28px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            font-size: 1rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #FF8C00, #FDB813);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 140, 0, 0.3);
        }
        
        .btn-secondary {
            background: #F0F0F0;
            color: #333;
            border: 2px solid #E0E0E0;
        }
        
        .btn-secondary:hover {
            background: #E0E0E0;
        }
        
        .summary {
            background: linear-gradient(135deg, rgba(255, 140, 0, 0.08), rgba(253, 184, 19, 0.08));
            border-left: 6px solid #FF8C00;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-around;
            text-align: center;
        }
        
        .summary-item {
            flex: 1;
        }
        
        .summary-item strong {
            font-size: 1.8rem;
            color: #E8411C;
            display: block;
        }
        
        .summary-item span {
            font-size: 0.85rem;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🍽️ FomeOff</h1>
            <p>Verificação de Inicialização</p>
        </div>
        
        <div class="summary">
            <div class="summary-item">
                <strong><?php echo count($status['success']); ?></strong>
                <span>✅ Sucesso</span>
            </div>
            <div class="summary-item">
                <strong><?php echo count($status['warning']); ?></strong>
                <span>⚠️ Avisos</span>
            </div>
            <div class="summary-item">
                <strong><?php echo count($status['error']); ?></strong>
                <span>❌ Erros</span>
            </div>
        </div>
        
        <?php if (!empty($status['success'])): ?>
            <div class="status-section">
                <h2>✅ Configurações Corretas</h2>
                <?php foreach ($status['success'] as $message): ?>
                    <div class="status-item success">
                        <strong><?php echo $message; ?></strong>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($status['warning'])): ?>
            <div class="status-section">
                <h2>⚠️ Avisos</h2>
                <?php foreach ($status['warning'] as $message): ?>
                    <div class="status-item warning">
                        <strong><?php echo $message; ?></strong>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($status['error'])): ?>
            <div class="status-section">
                <h2>❌ Erros</h2>
                <?php foreach ($status['error'] as $message): ?>
                    <div class="status-item error">
                        <strong><?php echo $message; ?></strong>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <div class="action-buttons">
            <a href="../index.php" class="btn btn-primary">🏠 Ir para Home</a>
            <a href="init.php" class="btn btn-secondary">🔄 Recarregar</a>
        </div>
    </div>
</body>
</html>

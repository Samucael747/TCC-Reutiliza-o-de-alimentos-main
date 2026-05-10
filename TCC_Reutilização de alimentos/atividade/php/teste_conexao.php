<?php
echo "=== Teste de Conexão com Banco de Dados ===\n\n";

$host = "localhost";
$username = "root";
$password = "";
$db = "banco";

echo "1. Testando conexão básica (sem selecionar banco)...\n";
try {
    $pdo = new PDO("mysql:host=$host", $username, $password);
    echo "✓ Conexão com MySQL bem-sucedida!\n\n";
} catch (PDOException $e) {
    echo "✗ Erro ao conectar com MySQL:\n";
    echo "   " . $e->getMessage() . "\n\n";
    echo "   SOLUÇÃO: Verifique se o MySQL está rodando no XAMPP\n";
    exit;
}

echo "2. Testando seleção do banco de dados '$db'...\n";
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $username, $password);
    echo "✓ Banco de dados selecionado com sucesso!\n\n";
} catch (PDOException $e) {
    if (strpos($e->getMessage(), "Unknown database") !== false) {
        echo "✗ Banco de dados '$db' não existe.\n";
        echo "   Criando banco de dados automaticamente...\n\n";
        
        try {
            $pdo = new PDO("mysql:host=$host", $username, $password);
            $pdo->exec("CREATE DATABASE IF NOT EXISTS $db");
            echo "✓ Banco de dados '$db' criado com sucesso!\n\n";
        } catch (PDOException $createError) {
            echo "✗ Erro ao criar banco: " . $createError->getMessage() . "\n";
            exit;
        }
    } else {
        echo "✗ Erro ao selecionar banco:\n";
        echo "   " . $e->getMessage() . "\n";
        exit;
    }
}

echo "3. Testando criação de tabelas...\n";
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("CREATE TABLE IF NOT EXISTS test_conexao (id INT PRIMARY KEY AUTO_INCREMENT, msg VARCHAR(100))");
    echo "✓ Tabelas criadas com sucesso!\n\n";

    $stmt = $pdo->prepare("INSERT INTO test_conexao (msg) VALUES (?)");
    $stmt->execute(["Teste de conexão - " . date('Y-m-d H:i:s')]);
    echo "✓ Inserção de dados bem-sucedida!\n\n";

    $result = $pdo->query("SELECT * FROM test_conexao ORDER BY id DESC LIMIT 5");
    $rows = $result->fetchAll(PDO::FETCH_ASSOC);
    echo "✓ Últimos registros:\n";
    foreach ($rows as $row) {
        echo "   ID: {$row['id']}, Msg: {$row['msg']}\n";
    }

} catch (PDOException $e) {
    echo "✗ Erro: " . $e->getMessage() . "\n";
    exit;
}

echo "\n=== TUDO OK! ===\n";
echo "Seu banco de dados está funcionando corretamente.\n";
?>

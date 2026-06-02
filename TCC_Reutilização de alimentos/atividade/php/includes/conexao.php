<?php

$host = "localhost";
$username = "root";
$password = "";
$db = "banco";

$pdo = null;

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $username, $password);
    // Configura o modo de erro do PDO para exceção
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!function_exists('addColumnIfMissing')) {
    function addColumnIfMissing(PDO $pdo, string $table, string $columnName, string $columnDefinition)
    {
        $stmt = $pdo->prepare("SHOW COLUMNS FROM `$table` LIKE :column");
        $stmt->execute([':column' => $columnName]);
        if ($stmt->rowCount() === 0) {
            $pdo->exec("ALTER TABLE `$table` ADD COLUMN $columnDefinition");
        }
    }
    } // end if (!function_exists)

    // Criar tabelas se não existirem
    $pdo->exec("CREATE TABLE IF NOT EXISTS usuarios(
        id INT PRIMARY KEY AUTO_INCREMENT,
        nome VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        senha VARCHAR(255) NOT NULL,
        tema VARCHAR(20) NOT NULL DEFAULT 'claro',
        notificacoes TINYINT(1) NOT NULL DEFAULT 1
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS empresas (
        id INT PRIMARY KEY AUTO_INCREMENT,
        nome VARCHAR(100) NOT NULL,
        cnpj VARCHAR(20),
        cep VARCHAR(10),
        email VARCHAR(100),
        senha VARCHAR(255),
        tema VARCHAR(20) NOT NULL DEFAULT 'claro',
        notificacoes TINYINT(1) NOT NULL DEFAULT 1
    )");
    addColumnIfMissing($pdo, 'usuarios', 'foto_perfil', "foto_perfil VARCHAR(255) DEFAULT NULL");
    addColumnIfMissing($pdo, 'usuarios', 'acessibilidade_preferences', "acessibilidade_preferences JSON DEFAULT NULL");
    addColumnIfMissing($pdo, 'empresas', 'foto_perfil', "foto_perfil VARCHAR(255) DEFAULT NULL");
    addColumnIfMissing($pdo, 'empresas', 'acessibilidade_preferences', "acessibilidade_preferences JSON DEFAULT NULL");

    $pdo->exec("CREATE TABLE IF NOT EXISTS produtos (
        id INT PRIMARY KEY AUTO_INCREMENT,
        empresa VARCHAR(100) NOT NULL,
        cnpj VARCHAR(20),
        cep VARCHAR(10) NOT NULL,
        nome_produto VARCHAR(100) NOT NULL,
        descricao VARCHAR(255) NOT NULL,
        quantidade INT NOT NULL,
        validade DATE NOT NULL,
        imagem VARCHAR(255) NOT NULL,
        latitude DECIMAL(10,7) NULL,
        longitude DECIMAL(10,7) NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
    addColumnIfMissing($pdo, 'produtos', 'validade', "validade DATE NOT NULL DEFAULT '1970-01-01'");
    addColumnIfMissing($pdo, 'produtos', 'imagem', "imagem VARCHAR(255) NOT NULL DEFAULT ''");

    // Doações efetivamente registradas quando o usuário solicita um produto
    $pdo->exec("CREATE TABLE IF NOT EXISTS doacoes (
        id INT PRIMARY KEY AUTO_INCREMENT,
        produto_id INT NOT NULL,
        usuario_email VARCHAR(100) NOT NULL,
        empresa VARCHAR(100) NOT NULL,
        cnpj VARCHAR(20) DEFAULT NULL,
        nome_produto VARCHAR(100) NOT NULL,
        quantidade INT NOT NULL DEFAULT 1,
        tipo_entrega VARCHAR(20) NOT NULL DEFAULT 'retirada',
        localizacao_retirada VARCHAR(255) NOT NULL,
        endereco_entrega VARCHAR(255) DEFAULT NULL,
        observacoes VARCHAR(500) DEFAULT NULL,
        data_doacao DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (produto_id) REFERENCES produtos(id)
    )");
    addColumnIfMissing($pdo, 'doacoes', 'produto_id', "produto_id INT NOT NULL DEFAULT 0");
    addColumnIfMissing($pdo, 'doacoes', 'cnpj', "cnpj VARCHAR(20) DEFAULT NULL");

    // Solicitações feitas por usuários para produtos
    $pdo->exec("CREATE TABLE IF NOT EXISTS solicitacoes (
        id INT PRIMARY KEY AUTO_INCREMENT,
        produto_id INT NOT NULL,
        usuario_email VARCHAR(100) NOT NULL,
        status VARCHAR(20) NOT NULL DEFAULT 'pendente',
        tipo_entrega VARCHAR(20) NOT NULL DEFAULT 'retirada',
        endereco_entrega VARCHAR(255) DEFAULT NULL,
        observacoes VARCHAR(500) DEFAULT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (produto_id) REFERENCES produtos(id)
    )");

    addColumnIfMissing($pdo, 'solicitacoes', 'tipo_entrega', "tipo_entrega VARCHAR(20) NOT NULL DEFAULT 'retirada'");
    addColumnIfMissing($pdo, 'solicitacoes', 'endereco_entrega', "endereco_entrega VARCHAR(255) DEFAULT NULL");
    addColumnIfMissing($pdo, 'solicitacoes', 'observacoes', "observacoes VARCHAR(500) DEFAULT NULL");

    // Avaliações deixadas por usuários sobre produtos/empresas
    $pdo->exec("CREATE TABLE IF NOT EXISTS avaliacoes (
        id INT PRIMARY KEY AUTO_INCREMENT,
        produto_id INT NOT NULL,
        empresa VARCHAR(100) NOT NULL,
        usuario_email VARCHAR(100) NOT NULL,
        nota TINYINT NOT NULL,
        comentario VARCHAR(1000) NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (produto_id) REFERENCES produtos(id)
    )");

} catch (PDOException $e) {
    die("Erro na conexão com banco de dados: " . $e->getMessage());
}

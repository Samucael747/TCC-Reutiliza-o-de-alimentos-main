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
$pdo->exec("ALTER TABLE usuarios ADD COLUMN IF NOT EXISTS foto_perfil VARCHAR(255) DEFAULT NULL");
$pdo->exec("ALTER TABLE usuarios ADD COLUMN IF NOT EXISTS acessibilidade_preferences JSON DEFAULT NULL");

$pdo->exec("ALTER TABLE empresas ADD COLUMN IF NOT EXISTS foto_perfil VARCHAR(255) DEFAULT NULL");
$pdo->exec("ALTER TABLE empresas ADD COLUMN IF NOT EXISTS acessibilidade_preferences JSON DEFAULT NULL");

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
    $pdo->exec("ALTER TABLE produtos ADD COLUMN IF NOT EXISTS validade DATE NOT NULL DEFAULT '1970-01-01'");
    $pdo->exec("ALTER TABLE produtos ADD COLUMN IF NOT EXISTS imagem VARCHAR(255) NOT NULL DEFAULT ''");

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

    $pdo->exec("ALTER TABLE solicitacoes ADD COLUMN IF NOT EXISTS tipo_entrega VARCHAR(20) NOT NULL DEFAULT 'retirada'");
    $pdo->exec("ALTER TABLE solicitacoes ADD COLUMN IF NOT EXISTS endereco_entrega VARCHAR(255) DEFAULT NULL");
    $pdo->exec("ALTER TABLE solicitacoes ADD COLUMN IF NOT EXISTS observacoes VARCHAR(500) DEFAULT NULL");

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

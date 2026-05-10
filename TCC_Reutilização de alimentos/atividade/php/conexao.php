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
        senha VARCHAR(255) NOT NULL
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS empresas (
        id INT PRIMARY KEY AUTO_INCREMENT,
        nome VARCHAR(100) NOT NULL,
        cnpj VARCHAR(20),
        cep VARCHAR(10),
        email VARCHAR(100),
        senha VARCHAR(255)
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS produtos (
        id INT PRIMARY KEY AUTO_INCREMENT,
        empresa VARCHAR(100) NOT NULL,
        cnpj VARCHAR(20),
        cep VARCHAR(10) NOT NULL,
        nome_produto VARCHAR(100) NOT NULL,
        descricao VARCHAR(255) NOT NULL,
        quantidade INT NOT NULL,
        latitude DECIMAL(10,7) NULL,
        longitude DECIMAL(10,7) NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

} catch (PDOException $e) {
    die("Erro na conexão com banco de dados: " . $e->getMessage());
}

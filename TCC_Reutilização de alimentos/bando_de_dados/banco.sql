CREATE DATABASE banco;
USE banco;

CREATE TABLE usuarios(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);
CREATE TABLE empresas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    cnpj VARCHAR(20),
    cep VARCHAR(10),
    email VARCHAR(100),
    senha VARCHAR(255)
);
CREATE TABLE ongs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    cnpj VARCHAR(20),
    cep VARCHAR(10),
    email VARCHAR(100),
    senha VARCHAR(255)
);

CREATE TABLE produtos (
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
);
CREATE TABLE doacoes(
    id INT PRIMARY KEY AUTO_INCREMENT,
    produto_id INT NOT NULL,
    usuario_email VARCHAR(100) NOT NULL,
    empresa VARCHAR(100) NOT NULL,
    cnpj VARCHAR(20),
    nome_produto VARCHAR(100) NOT NULL,
    quantidade INT NOT NULL DEFAULT 1,
    tipo_entrega VARCHAR(20) NOT NULL DEFAULT 'retirada',
    localizacao_retirada VARCHAR(255) NOT NULL,
    endereco_entrega VARCHAR(255) DEFAULT NULL,
    observacoes VARCHAR(500) DEFAULT NULL,
    data_doacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (produto_id) REFERENCES produtos(id)
);
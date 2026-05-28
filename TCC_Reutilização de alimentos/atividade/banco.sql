CREATE DATABASE banco;
USE banco;

CREATE TABLE usuarios(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);
CREATE TABLE doacoes(
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT,
    descricao VARCHAR(255) NOT NULL,
    localizacao VARCHAR(255) NOT NULL,
    data_doacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
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

-- Adicionar campos de foto de perfil
ALTER TABLE usuarios ADD COLUMN IF NOT EXISTS foto_perfil VARCHAR(255) DEFAULT NULL;
ALTER TABLE usuarios ADD COLUMN IF NOT EXISTS acessibilidade_preferences JSON DEFAULT NULL;

ALTER TABLE empresas ADD COLUMN IF NOT EXISTS foto_perfil VARCHAR(255) DEFAULT NULL;
ALTER TABLE empresas ADD COLUMN IF NOT EXISTS acessibilidade_preferences JSON DEFAULT NULL;

-- Criar tabela de logs de acessibilidade
CREATE TABLE IF NOT EXISTS acessibilidade_logs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_email VARCHAR(100),
    tipo_usuario VARCHAR(50),
    preferencias JSON,
    data_atualizacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    ip_address VARCHAR(45),
    FOREIGN KEY (usuario_email) REFERENCES usuarios(email) ON DELETE CASCADE
);

-- Criar índices para melhor desempenho
CREATE INDEX IF NOT EXISTS idx_usuarios_email ON usuarios(email);
CREATE INDEX IF NOT EXISTS idx_empresas_email ON empresas(email);
CREATE INDEX IF NOT EXISTS idx_ongs_email ON ongs(email);
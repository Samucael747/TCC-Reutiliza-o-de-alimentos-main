<?php
require __DIR__ . '/../includes/conexao.php';

try {
    // Criar tabela produtos se não existir
    $sql = "CREATE TABLE IF NOT EXISTS produtos (
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
    )";
    
    $pdo->exec($sql);
    echo "Tabela 'produtos' foi criada ou já existe. Sucesso!";
    
} catch (PDOException $e) {
    echo "Erro ao criar tabela: " . $e->getMessage();
}
?>


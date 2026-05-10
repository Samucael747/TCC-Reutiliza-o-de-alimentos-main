<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'conexao.php';

    if (!$pdo) {
        header('Location: ../html/cadastroProduto.php?error=Erro+de+conexao+com+banco');
        exit;
    }

    $empresa = trim($_POST['empresa'] ?? '');
    $cnpj = trim($_POST['cnpj'] ?? '');
    $cep = trim($_POST['cep'] ?? '');
    $nome_produto = trim($_POST['nome_produto'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $quantidade = intval($_POST['quantidade'] ?? 0);
    $latitude = $_POST['latitude'] !== '' ? trim($_POST['latitude']) : null;
    $longitude = $_POST['longitude'] !== '' ? trim($_POST['longitude']) : null;

    if (!$empresa || !$cep || !$nome_produto || !$descricao || $quantidade <= 0) {
        header('Location: ../html/cadastroProduto.php?error=Preencha+todos+os+campos+corretamente');
        exit;
    }

    try {
        $stmt = $pdo->prepare('INSERT INTO produtos (empresa, cnpj, cep, nome_produto, descricao, quantidade, latitude, longitude) VALUES (:empresa, :cnpj, :cep, :nome_produto, :descricao, :quantidade, :latitude, :longitude)');
        $stmt->bindValue(':empresa', $empresa);
        $stmt->bindValue(':cnpj', $cnpj);
        $stmt->bindValue(':cep', $cep);
        $stmt->bindValue(':nome_produto', $nome_produto);
        $stmt->bindValue(':descricao', $descricao);
        $stmt->bindValue(':quantidade', $quantidade, PDO::PARAM_INT);
        $stmt->bindValue(':latitude', $latitude ?: null);
        $stmt->bindValue(':longitude', $longitude ?: null);
        $stmt->execute();

        header('Location: ../html/cadastroProduto.php?success=Produto+registrado+com+sucesso');
        exit;
    } catch (PDOException $e) {
        header('Location: ../html/cadastroProduto.php?error=Erro+ao+registrar+produto');
        exit;
    }
}

header('Location: ../html/cadastroProduto.php?error=Metodo+nao+permitido');
exit;

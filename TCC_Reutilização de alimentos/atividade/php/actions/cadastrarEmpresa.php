<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require __DIR__ . '/../includes/conexao.php';

    if (!$pdo) {
        header('Location: ../../auth/cadastroEmpresas.html?error=Erro+de+conexao+com+banco');
        exit;
    }

    $nome = trim($_POST['nome'] ?? '');
    $cnpj = trim($_POST['cnpj'] ?? '');
    $cep = trim($_POST['cep'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if (!$nome || !$email || !$senha) {
        header('Location: ../../auth/cadastroEmpresas.html?error=Dados+incompletos');
        exit;
    }

    try {
        $stmt = $pdo->prepare('SELECT id FROM empresas WHERE email = :email LIMIT 1');
        $stmt->execute([':email' => $email]);

        if ($stmt->fetch()) {
            header('Location: ../../auth/cadastroEmpresas.html?error=Email+ja+cadastrado');
            exit;
        }

        $stmt = $pdo->prepare('INSERT INTO empresas (nome, cnpj, cep, email, senha) VALUES (:nome, :cnpj, :cep, :email, :senha)');
        $stmt->execute([
            ':nome' => $nome,
            ':cnpj' => $cnpj,
            ':cep' => $cep,
            ':email' => $email,
            ':senha' => $senha,
        ]);

        header('Location: ../../entrar.php?success=Empresa+cadastrada+com+sucesso');
        exit;
    } catch (PDOException $e) {
        header('Location: ../../auth/cadastroEmpresas.html?error=Erro+ao+cadastrar+empresa');
        exit;
    }
}

header('Location: ../../auth/cadastroEmpresas.html');
exit;




<?php
if (isset($_POST['email'])) {
    $nome  = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if (!$nome || !$email || !$senha) {
        header('Location: ../../auth/cadastroUsuario.php?error=Preencha+todos+os+campos');
        exit;
    }

    require __DIR__ . '/../includes/conexao.php';

    if (!$pdo) {
        header('Location: ../../auth/cadastroUsuario.php?error=Erro+de+conexao+com+banco');
        exit;
    }

    try {
        $stmt = $pdo->prepare('SELECT id FROM usuarios WHERE email = :e LIMIT 1');
        $stmt->bindValue(':e', $email);
        $stmt->execute();

        if ($stmt->fetch()) {
            header('Location: ../../auth/cadastroUsuario.php?error=Email+ja+cadastrado');
            exit;
        }

        $stmt = $pdo->prepare('INSERT INTO usuarios (nome, email, senha) VALUES (:n, :e, :s)');
        $stmt->bindValue(':n', $nome);
        $stmt->bindValue(':e', $email);
        $stmt->bindValue(':s', $senha);
        $stmt->execute();

        header('Location: ../../entrar.php?success=Cadastro+realizado+com+sucesso');
        exit;
    } catch (PDOException $e) {
        header('Location: ../../auth/cadastroUsuario.php?error=Erro+ao+cadastrar+usuario');
        exit;
    }
} else {
    header('Location: ../../auth/cadastroUsuario.php?error=Dados+invalidos');
    exit;
}



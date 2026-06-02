<?php
session_start(); // deve ser chamado antes de qualquer output ou include

if (isset($_POST['email'])) {
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    require __DIR__ . '/../includes/conexao.php';

    if (!$pdo) {
        header('Location: ../../entrar.php?error=Erro+de+conexao+com+banco');
        exit;
    }

    $tipo = $_POST['tipo'] ?? 'usuario';

    try {
        if ($tipo === 'empresa') {
            $stmt = $pdo->prepare('SELECT id, nome, email, senha FROM empresas WHERE email = :e LIMIT 1');
        } else {
            $stmt = $pdo->prepare('SELECT id, nome, email, senha FROM usuarios WHERE email = :e LIMIT 1');
        }

        $stmt->bindValue(':e', $email);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && $usuario['senha'] === $senha) {
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['email'] = $usuario['email'];
            $_SESSION['role'] = $tipo;
            header('Location: ../dashboard.php');
            exit;
        } else {
            header('Location: ../../entrar.php?error=Email+ou+senha+incorretos');
            exit;
        }
    } catch (PDOException $e) {
        header('Location: ../../entrar.php?error=Erro+ao+autenticar');
        exit;
    }
} else {
    header("Location: ../../entrar.php");
    exit;
}





<?php
if (isset($_POST['email'])) {
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    require 'conexao.php';

    if (!$pdo) {
        header('Location: ../index.php?error=Erro+de+conexao+com+banco');
        exit;
    }

    try {
        $stmt = $pdo->prepare('SELECT id, nome, senha FROM usuarios WHERE email = :e LIMIT 1');
        $stmt->bindValue(':e', $email);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && $usuario['senha'] === $senha) {
            session_start();
            $_SESSION['nome'] = $usuario['nome'];
            header('Location: home.php');
            exit;
        } else {
            header('Location: ../index.php?error=Email+ou+senha+incorretos');
            exit;
        }
    } catch (PDOException $e) {
        header('Location: ../index.php?error=Erro+ao+autenticar');
        exit;
    }
} else {
    header("Location: ../index.php");
    exit;
}
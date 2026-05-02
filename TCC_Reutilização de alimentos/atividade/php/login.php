<?php
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    require 'Usuario.class.php';
    $usuario = new Usuario();
    $conn = $usuario->conectar();

    if ($conn) {
        if ($usuario->checkUser($email)) {
            if ($usuario->checkPass($email, $senha)) {
                session_start();
                $_SESSION['nome'] = "TESTE";
                header("Location: home.php");
                exit;
            } else {
                header("Location: ../index.php?error=Senha+incorreta");
                exit;
            }
        } else {
            header("Location: ../index.php?error=Usuario+nao+existe");
            exit;
        }
    } else {
        header("Location: ../index.php?error=Erro+de+conexao");
        exit;
    }
} else {
    header("Location: ../index.php");
    exit;
}
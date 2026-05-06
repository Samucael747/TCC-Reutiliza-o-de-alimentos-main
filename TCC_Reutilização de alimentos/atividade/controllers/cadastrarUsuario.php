<?php
if (isset($_POST['email'])) {
    $nome  = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    require '../models/Usuario.class.php';
    $usuario = new Usuario();
    $conn = $usuario->conectar();

    if ($conn) {
        if ($usuario->checkUser($email)) {
            header("Location: ../views/cadastroUsuario.php?error=Usuario+ja+existe");
            exit;
        } else {
            $user = $usuario->insertUser($nome, $email, $senha);
            if ($user) {
                header("Location: ../index.php?success=Cadastro+realizado+com+sucesso");
                exit;
            } else {
                header("Location: ../views/cadastroUsuario.php?error=Erro+ao+inserir+usuario");
                exit;
            }
        }
    }
} else {
    header("Location: ../views/cadastroUsuario.php?error=Dados+invalidos");
    exit;
}
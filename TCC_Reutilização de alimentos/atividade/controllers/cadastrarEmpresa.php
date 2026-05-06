<?php
if (isset($_POST['email'])) {
    $nome    = $_POST['nome'];
    $empresa = $_POST['empresa'];
    $cnpj    = $_POST['cnpj'];
    $cep     = $_POST['cep'];
    $email   = $_POST['email'];
    $senha   = $_POST['senha'];

    require '../models/Empresa.class.php';
    $emp  = new Empresa();
    $conn = $emp->conectar();

    if ($conn) {
        if ($emp->checkEmpresa($email)) {
            header("Location: ../views/cadastroEmpresas.php?error=Empresa+ja+cadastrada");
            exit;
        } else {
            $ok = $emp->insertEmpresa($nome, $empresa, $cnpj, $cep, $email, $senha);
            if ($ok) {
                header("Location: ../index.php?success=Empresa+cadastrada+com+sucesso");
                exit;
            } else {
                header("Location: ../views/cadastroEmpresas.php?error=Erro+ao+cadastrar+empresa");
                exit;
            }
        }
    } else {
        header("Location: ../views/cadastroEmpresas.php?error=Erro+de+conexao");
        exit;
    }
} else {
    header("Location: ../views/cadastroEmpresas.php");
    exit;
}

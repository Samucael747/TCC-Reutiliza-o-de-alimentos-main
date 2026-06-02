<?php
session_start();
if (!isset($_SESSION['email'], $_SESSION['role'])) {
    header('Location: ../../entrar.php?error=Voce+precisa+logar+primeiro');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../configuracoes.php');
    exit;
}

require __DIR__ . '/../includes/conexao.php';
if (!$pdo) {
    header('Location: ../configuracoes.php?error=Erro+de+conexao+com+banco');
    exit;
}

$role = $_SESSION['role'];
$currentEmail = $_SESSION['email'];
$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$senha = trim($_POST['senha'] ?? '');

if (!$nome || !$email) {
    header('Location: ../configuracoes.php?error=Nome+e+email+sao+obrigatorios');
    exit;
}

try {
    if ($role === 'empresa') {
        $cnpj = trim($_POST['cnpj'] ?? '');
        $cep = trim($_POST['cep'] ?? '');

        $stmt = $pdo->prepare('SELECT id, senha FROM empresas WHERE email = :email LIMIT 1');
        $stmt->execute([':email' => $currentEmail]);
        $conta = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$conta) {
            header('Location: ../configuracoes.php?error=Conta+nao+encontrada');
            exit;
        }

        if ($email !== $currentEmail) {
            $stmt = $pdo->prepare('SELECT id FROM empresas WHERE email = :email LIMIT 1');
            $stmt->execute([':email' => $email]);
            if ($stmt->fetch()) {
                header('Location: ../configuracoes.php?error=Email+ja+esta+em+uso');
                exit;
            }
        }

        $senha = $senha ?: $conta['senha'];

        $stmt = $pdo->prepare('UPDATE empresas SET nome = :nome, email = :email, senha = :senha, cnpj = :cnpj, cep = :cep WHERE email = :currentEmail');
        $stmt->execute([
            ':nome'         => $nome,
            ':email'        => $email,
            ':senha'        => $senha,
            ':cnpj'         => $cnpj,
            ':cep'          => $cep,
            ':currentEmail' => $currentEmail,
        ]);
    } else {
        $stmt = $pdo->prepare('SELECT id, senha FROM usuarios WHERE email = :email LIMIT 1');
        $stmt->execute([':email' => $currentEmail]);
        $conta = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$conta) {
            header('Location: ../configuracoes.php?error=Conta+nao+encontrada');
            exit;
        }

        if ($email !== $currentEmail) {
            $stmt = $pdo->prepare('SELECT id FROM usuarios WHERE email = :email LIMIT 1');
            $stmt->execute([':email' => $email]);
            if ($stmt->fetch()) {
                header('Location: ../configuracoes.php?error=Email+ja+esta+em+uso');
                exit;
            }
        }

        $senha = $senha ?: $conta['senha'];

        $stmt = $pdo->prepare('UPDATE usuarios SET nome = :nome, email = :email, senha = :senha WHERE email = :currentEmail');
        $stmt->execute([
            ':nome'         => $nome,
            ':email'        => $email,
            ':senha'        => $senha,
            ':currentEmail' => $currentEmail,
        ]);
    }

    $_SESSION['nome'] = $nome;
    $_SESSION['email'] = $email;

    header('Location: ../configuracoes.php?success=Configuracoes+salvas+com+sucesso');
    exit;
} catch (PDOException $e) {
    header('Location: ../configuracoes.php?error=Erro+ao+salvar+configuracoes');
    exit;
}





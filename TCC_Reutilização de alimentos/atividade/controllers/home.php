<?php
session_start();
if (!isset($_SESSION['nome'])) {
    header("Location: ../index.php");
    exit;
}
$nome = $_SESSION['nome'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Início | SolidárioConnect</title>
    <link rel="stylesheet" href="../css/index.css" />
</head>
<body>
    <p>Bem-vindo, <?php echo htmlspecialchars($nome, ENT_QUOTES, 'UTF-8'); ?>!</p>
</body>
</html>

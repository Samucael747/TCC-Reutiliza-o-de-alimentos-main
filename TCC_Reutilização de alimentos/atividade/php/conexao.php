<?php

$host = "localhost";
$username = "root";
$password = "";
$db = "banco";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $username, $password);
    // Configura o modo de erro do PDO para exceção
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
}
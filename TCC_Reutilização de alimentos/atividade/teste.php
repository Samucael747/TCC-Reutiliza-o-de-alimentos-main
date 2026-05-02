<?php
require "Usuario.class.php";
$usuario = new Usuario();

$conn = $usuario->conexao();

if( $conn ){
    echo "<h1> Conectado ao banco";
}else{
    echo "<h1> Banco indisponivel. Tente mais tarde!";
}

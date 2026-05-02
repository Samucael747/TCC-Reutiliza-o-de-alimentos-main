<?php
    session_start();
    if($_SESSION['nome']){
        $nome = $_SESSION['nome'];
        echo "Bem vindo $nome";
    }else{
        echo "Você tem que logar primeiro!"
    }
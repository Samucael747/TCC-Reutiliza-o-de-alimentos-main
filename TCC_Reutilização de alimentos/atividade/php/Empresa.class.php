<?php
class Empresa{
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $cep;
    private $empresa;
    private $cnpj;


    # os getters simplesmente retornam o valor dos atributos da classe.
    function getId(){
        return $this->id;
    }
    function getEmpresa(){
        return $this->empresa;
    }

    function getEmail(){
        return $this->email;
    }

    function getCnpj(){
        return $this->cnpj;
    }
    
    function getCep(){
        return $this->cep;
    }

    function getSenha(){
        return $this->senha;
    }

    function getNome(){
        return $this->nome;
    }

    # os setters recebem um parametro e trocam o valor do atributo pelo valor desse parametro.
    public function setNome($nome){
        $this->nome = $nome;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function setSenha($senha){
        $this->senha = $senha;
    }

    function conexao(){
        $banco   = "mysql:dbname=banco;host=localhost";
        $usuario = "root";
        $senha   = "";

        try {
            $this->pdo = new PDO($banco, $usuario, $senha);
            return true;
        } catch (\Throwable $th) {
            return false;
        }


    }

    function checkUser($email){
        $sql  = "SELECT email FROM empresa WHERE email = :e";
        $stmt = $this->pdo->prepare($sql);
        $stmt-> bindValue(":e", $email);

        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
}
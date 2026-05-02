<?php
class Usuario{
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $pdo;

    # os getters simplesmente retornam o valor dos atributos da classe.
    function getId(){
        return $this->id;
    }

    function getEmail(){
        return $this->email;
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

    function conectar(){
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

    function insertUser($nome, $email, $senha){
        $sql  = "INSERT INTO usuarios SET nome = :n, email = :e, senha = :s";
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->bindValue(":n", $nome);
        $stmt->bindValue(":e", $email);
        $stmt->bindValue(":s", $senha);

        
        return $stmt->execute();  
    }

    function checkUser($email){
        $sql  = "SELECT id FROM usuarios WHERE email = :e LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":e", $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    function checkPass($email, $senha){
        $sql  = "SELECT email, senha FROM usuarios WHERE email = :e AND senha = :s";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":e",$email);
        $stmt->bindValue(":s",$senha);
        
        return $stmt->rowCount()> 0;
        
    }
    
}
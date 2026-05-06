<?php
class Empresa {
    private $id;
    private $nome;
    private $empresa;
    private $cnpj;
    private $cep;
    private $email;
    private $senha;
    private $pdo;

    function getId()      { return $this->id; }
    function getNome()    { return $this->nome; }
    function getEmpresa() { return $this->empresa; }
    function getCnpj()    { return $this->cnpj; }
    function getCep()     { return $this->cep; }
    function getEmail()   { return $this->email; }
    function getSenha()   { return $this->senha; }

    public function setNome($nome)       { $this->nome    = $nome; }
    public function setEmpresa($empresa) { $this->empresa = $empresa; }
    public function setCnpj($cnpj)       { $this->cnpj   = $cnpj; }
    public function setCep($cep)         { $this->cep     = $cep; }
    public function setEmail($email)     { $this->email   = $email; }
    public function setSenha($senha)     { $this->senha   = $senha; }

    function conectar() {
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

    function checkEmpresa($email) {
        $sql  = "SELECT id FROM empresa WHERE email = :e LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":e", $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    function insertEmpresa($nome, $empresa, $cnpj, $cep, $email, $senha) {
        $sql  = "INSERT INTO empresa (nome, empresa, cnpj, cep, email, senha) VALUES (:n, :emp, :cnpj, :cep, :e, :s)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":n",    $nome);
        $stmt->bindValue(":emp",  $empresa);
        $stmt->bindValue(":cnpj", $cnpj);
        $stmt->bindValue(":cep",  $cep);
        $stmt->bindValue(":e",    $email);
        $stmt->bindValue(":s",    $senha);
        return $stmt->execute();
    }
}

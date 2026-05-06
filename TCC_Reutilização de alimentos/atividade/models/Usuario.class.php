<?php
class Usuario {
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $pdo;

    function getId()    { return $this->id; }
    function getNome()  { return $this->nome; }
    function getEmail() { return $this->email; }
    function getSenha() { return $this->senha; }

    public function setNome($nome)   { $this->nome  = $nome; }
    public function setEmail($email) { $this->email = $email; }
    public function setSenha($senha) { $this->senha = $senha; }

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

    function checkUser($email) {
        $sql  = "SELECT id FROM usuarios WHERE email = :e LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":e", $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    function checkPass($email, $senha) {
        $sql  = "SELECT id FROM usuarios WHERE email = :e AND senha = :s LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":e", $email);
        $stmt->bindValue(":s", $senha);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    function getUserNome($email) {
        $sql  = "SELECT nome FROM usuarios WHERE email = :e LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":e", $email);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['nome'] : '';
    }

    function insertUser($nome, $email, $senha) {
        $sql  = "INSERT INTO usuarios (nome, email, senha) VALUES (:n, :e, :s)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":n", $nome);
        $stmt->bindValue(":e", $email);
        $stmt->bindValue(":s", $senha);
        return $stmt->execute();
    }
}

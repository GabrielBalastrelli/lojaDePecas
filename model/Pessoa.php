<?php

class Pessoa
{
    private int $idPessoa;
    private string $nome;
    public PDO $dbConnection;

    public function __construct(PDO $dbConnection)
    {

        $this->dbConnection =  $dbConnection;
    }

    public function setarDados(string $nome)
    {

        $this->nome =  $nome;
    }
    public function salvarPessoa()
    {
        if (!$this->validarDados($this->nome)) {
            return false;
        }

        $sql = "INSERT INTO pessoa (nome) VALUES (:nome)";

        $stmt = $this->dbConnection->prepare($sql);

        try {
            $stmt->bindParam(":nome", $this->nome);
            $stmt->execute();

            $this->idPessoa = $this->dbConnection->lastInsertId();

            return $this->idPessoa;
        } catch (PDOException $error) {
            return $error->getMessage();
        }
    }

    public function validarDados(string $nome): bool
    {
        return $nome == "" ? false : true;
    }

    public function getDadosPessoas(int $idPessoa)
    {
        try {
            $sql = "SELECT * FROM Pessoa WHERE id_pessoa = :idPessoa  limit 1";

            $stmt = $this->dbConnection->prepare($sql);
            $stmt->bindParam(":idPessoa", $idPessoa);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $error) {
            return $error->getMessage();
        }
    }

    public function listarDadosPessoas()
    {
        try {
            $sql = "SELECT * FROM Pessoa WHERE ";

            $stmt = $this->dbConnection->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $error) {
            return $error->getMessage();
        }
    }

    public function deletarPessoa(int $idPessoa)
    {
        try {
            $sql = "DELETE FROM Pessoa WHERE id_pessoa = :id_pessoa LIMIT 1";

            $stmt =  $this->dbConnection->prepare($sql);
            $stmt->bindParam(":id_pessoa", $idPessoa);
            $stmt->execute();

            return $idPessoa;
        } catch (PDOException $error) {
            return $error->getMessage() . $error->getCode();
        }
    }
}

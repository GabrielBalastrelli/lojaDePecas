<?php

class Pessoa
{
    private int $idPessoa;
    private string $nome;
    private PDO $dbConnection;

    public function __construct(string $nome, PDO $dbConnection)
    {
        $this->nome = $nome;
        $this->dbConnection =  $dbConnection;
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
}

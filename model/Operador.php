<?php

require_once __DIR__ . "/../model/Pessoa.php";

class Operador extends Pessoa
{
    private int $codOperador;
    private int|null $idPessoa;
    private string $senha;


    public function __construct(PDO $dbConnection)
    {
        parent::__construct($dbConnection);
    }

    public function setarDadosOperador(int| null $idPessoa, int $senha, int $codOperador)
    {
        $this->codOperador =  $codOperador;
        $this->idPessoa = $idPessoa;
        $this->senha = $senha;
    }

    public function encryptarSenha(string $senha)
    {
        $this->senha = password_hash($senha, PASSWORD_BCRYPT);

        return $this->senha;
    }

    public function salvarOperador()
    {
        if (!$this->validarDadosOperador($this->idPessoa, $this->senha)) {
            return false;
        }

        $senhaCrypto = $this->encryptarSenha($this->senha);

        try {
            $sql = "INSERT INTO Operador (pessoa_id, senha) VALUE (:pessoa_id, :senha)";
            $stmt = $this->dbConnection->prepare($sql);
            $stmt->bindParam(":pessoa_id", $this->idPessoa);
            $stmt->bindParam(":senha", $senhaCrypto);

            $stmt->execute();

            $this->codOperador = $this->dbConnection->lastInsertId();

            return  $this->codOperador;
        } catch (PDOException $error) {
            return $error->getMessage();
        }
    }

    public function validarDadosOperador(?int $idPessoa, string $senha): bool
    {
        if (empty($idPessoa) || empty($senha)) {
            return false;
        }

        return true;
    }

    public function validarLogin(int $codOperador, $senha): bool
    {
        $dadosOperador = $this->getLogin($codOperador);

        if (!$dadosOperador) {
            return false;
        }

        /*if (password_verify($senha, $dadosOperador->senha)) {
            return true;
        }
        */

        if ($senha == $dadosOperador->senha) return true;

        return false;
    }

    public function getLogin(int $codOperador)
    {
        try {
            $sql = "SELECT * FROM Operador WHERE codigo_operador = :codOperador limit 1";

            $stmt = $this->dbConnection->prepare($sql);
            $stmt->bindParam(":codOperador", $codOperador);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $error) {
            return $error->getMessage();
        }
    }

    public function getDadosPessoas(int $idPessoa)
    {
        return parent::getDadosPessoas($idPessoa);
    }
}

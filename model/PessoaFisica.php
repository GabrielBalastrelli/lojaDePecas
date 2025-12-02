<?php

require_once __DIR__  . "/../model/Pessoa.php";

class PessoaFisica extends Pessoa
{
    private int $idPessoa;
    private string $cpf;
    private string $rg;
    private string $dataNascimento;
    private string $estadoCivil;

    public function __construct(PDO $dbConnection)
    {
        parent::__construct($dbConnection);
    }

    public function setarDadosPessoaFisica(int $idPessoa, string $cpf,  string $rg, string $dataNascimento, string $estadoCivil)
    {
        $this->idPessoa = $idPessoa;
        $this->cpf = $cpf;
        $this->rg = $rg;
        $this->dataNascimento = $dataNascimento;
        $this->estadoCivil = $estadoCivil;
    }
    public function putCliente(int $idPessoa, string $nome, string $cpf, string $rg, string $dataNascimento, string $estadoCivil)
    {
        try {
            $this->dbConnection->beginTransaction();

            $sql = "UPDATE pessoa SET nome = :nome WHERE id_pessoa = :idPessoa";
            $stmt = $this->dbConnection->prepare($sql);
            $stmt->bindParam(":idPessoa",  $idPessoa,  PDO::PARAM_INT);
            $stmt->bindParam(":nome",  $nome);
            $stmt->execute();

            $sqlFisica = "
            UPDATE pessoa_fisica 
            SET cpf = :cpf, rg = :rg, data_nascimento = :data_nascimento, estado_civil = :estado_civil
            WHERE pessoa_id = :idPessoa
        ";
            $stmtFisica = $this->dbConnection->prepare($sqlFisica);
            $stmtFisica->bindParam(':cpf', $cpf);
            $stmtFisica->bindParam(':rg', $rg);
            $stmtFisica->bindParam(':data_nascimento', $dataNascimento);
            $stmtFisica->bindParam(':estado_civil', $estadoCivil);
            $stmtFisica->bindParam(':idPessoa', $idPessoa, PDO::PARAM_INT);
            $stmtFisica->execute();

            $this->dbConnection->commit();

            return true;
        } catch (PDOException $error) {
            if ($this->dbConnection->inTransaction()) {
                $this->dbConnection->rollBack();
            }
            return $error->getMessage();
        }
    }


    public function salvarClienteFisica()
    {
        if (!$this->validarDadosOperador($this->idPessoa, $this->cpf, $this->rg, $this->dataNascimento, $this->estadoCivil)) {
            return false;
        }

        try {
            $sql = "INSERT INTO pessoa_fisica (pessoa_id, cpf, rg, data_nascimento, estado_civil ) 
            VALUE (:pessoa_id, :cpf, :rg, :data_nascimento, :estado_civil)";

            $stmt = $this->dbConnection->prepare($sql);
            $stmt->bindParam(":pessoa_id", $this->idPessoa);
            $stmt->bindParam(":cpf", $this->cpf);
            $stmt->bindParam(":rg", $this->rg);
            $stmt->bindParam(":data_nascimento", $this->dataNascimento);
            $stmt->bindParam(":estado_civil", $this->estadoCivil);

            $stmt->execute();

            $this->idPessoa = $this->dbConnection->lastInsertId();

            return  $this->idPessoa;
        } catch (PDOException $error) {
            return $error->getMessage();
        }
    }

    public function listarClientes()
    {
        $sql = "
            SELECT 
                p.id_pessoa,
                p.nome,
                pf.cpf,
                pf.rg,
                pf.data_nascimento,
                pf.estado_civil
            FROM pessoa p
            INNER JOIN pessoa_fisica pf ON pf.pessoa_id = p.id_pessoa
            ";

        $stmt = $this->dbConnection->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function validarDadosOperador(?int $idPessoa, string $cpf, string $rg, string $dataNascimento, string $estadoCivil): bool
    {
        if (empty($idPessoa) || empty($cpf) || empty($rg) || empty($dataNascimento) || empty($estadoCivil)) {
            return false;
        }

        return true;
    }

    public function deleteClienteFisico(int $idPessoa)
    {
        try {
            $sql = "DELETE FROM pessoa_fisica WHERE pessoa_id = :pessoa_id LIMIT 1";

            $stmt =  $this->dbConnection->prepare($sql);
            $stmt->bindParam(":pessoa_id", $idPessoa);
            $stmt->execute();

            return $idPessoa;
        } catch (PDOException $error) {
            return $error->getMessage() . $error->getCode();
        }
    }

    public function getPessoaFisica(int $idPessoa)
    {
        try {
            $sql = "
            SELECT 
                p.id_pessoa,
                p.nome,
                pf.cpf,
                pf.rg,
                pf.data_nascimento,
                pf.estado_civil
            FROM pessoa p
            INNER JOIN pessoa_fisica pf ON pf.pessoa_id = p.id_pessoa 
            WHERE p.id_pessoa = :idPessoa
            LIMIT 1
            ";

            $stmt =  $this->dbConnection->prepare($sql);
            $stmt->bindParam(":idPessoa", $idPessoa);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $error) {
            return $error->getMessage() . $error->getCode();
        }
    }
}

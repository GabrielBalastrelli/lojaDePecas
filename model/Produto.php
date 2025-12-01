<?php

class Produto
{
    private int $id_produto;
    private string $nome;
    private float $preco;
    private string $img;
    private PDO $dbConnection;

    public function __construct(PDO $dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    public function gravarProduto(string $nome, float $preco, string $img)
    {
        try {
            $sql = "INSERT INTO Produto(nome, preco, img) VALUES (:nome, :preco, :img)";

            $stmt =  $this->dbConnection->prepare($sql);
            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":preco", $preco);
            $stmt->bindParam(":img", $img);
            $stmt->execute();

            $this->id_produto = $this->dbConnection->lastInsertId();

            return [
                "erro" => false,
                "id" => $this->dbConnection->lastInsertId()
            ];
        } catch (PDOException $error) {
            return [
                "erro" => true,
                "codigo" => $error->getCode(),
                "mensagem" => $error->getMessage()
            ];
        }
    }

    public function atualizaProduto(int $id_produto, string $nome, float $preco, string $img)
    {
        try {


            if (empty($nome) || empty($preco)) {
                return new Error("Nome e preço são obrigatórios!", -999);
            }


            $sql = "UPDATE Produtos SET nome = :nome, preco = :preco, img = :img WHERE id_produto = :id_produto";

            $stmt = $this->dbConnection->prepare($sql);
            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":preco", $preco);
            $stmt->bindParam(":img", $img);
            $stmt->bindParam(":id_produto", $id_produto);

            $stmt->execute();

            return true;
        } catch (PDOException $error) {
            return $error->getMessage() . $error->getCode();
        }
    }


    public function deleteProdutc(int $id_produto)
    {
        try {
            $sql = "DELETE FROM Produtos WHERE id_produto = :id_produto LIMIT 1";

            $stmt =  $this->dbConnection->prepare($sql);
            $stmt->bindParam(":id_produto", $id_produto);
            $stmt->execute();

            return $id_produto;
        } catch (PDOException $error) {
            return $error->getMessage() . $error->getCode();
        }
    }

    public function getProduto(int $id_produto)
    {
        try {
            $sql = "SELECT * FROM Produtos WHERE id_produto = :id_produto LIMIT 1";

            $stmt =  $this->dbConnection->prepare($sql);
            $stmt->bindParam(":id_produto", $id_produto);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $error) {
            return $error->getMessage() . $error->getCode();
        }
    }

    public function listarProdutos()
    {
        try {
            $sql = "SELECT * FROM Produto";

            $stmt =  $this->dbConnection->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $error) {
            return $error->getMessage() . $error->getCode();
        }
    }

    public function validarDados(string $nome, float $preco)
    {
        if ($nome == "" && !$preco) {
            return new Error("Os parametros nome e preço são obrigatorios!", -999);
        }

        return true;
    }
}

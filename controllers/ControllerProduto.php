<?php

require_once __DIR__ . "/../model/Produto.php";

class ControllerProduto
{
    private PDO $dbConfig;
    private string $casoDeUso;

    public function __construct(PDO $dbConfig)
    {
        $this->dbConfig = $dbConfig;
    }

    public function switchController(string $case)
    {
        switch ($case) {
            case 'cadastroProduto':
                if ($_SERVER["REQUEST_METHOD"] === "POST") {
                    $nome  = $_POST["nome"];
                    $preco = floatval($_POST["preco"]);
                    $img   = $_POST["img"];

                    $produto = new Produto($this->dbConfig);
                    $resultado = $produto->gravarProduto($nome, $preco, $img);

                    if ($resultado["erro"]) {
                        $msg = urlencode($resultado["mensagem"]);
                        header("Location: index.php?url=cadastroProduto&erro=$msg");
                        exit();
                    }

                    header("Location: index.php?url=cadastroProduto&sucesso=1");
                    exit();
                }


                include __DIR__ . "/../views/Produto/CadastrarProduto.php";
                break;
            case 'produtos':
                include __DIR__ . "/../views/Produto/PainelProdutos.php";
                break;
            case 'listarProdutos':
                $produto =   $produto = new Produto($this->dbConfig);
                $dadosProduto = $produto->listarProdutos();
                include __DIR__ . "/../views/Produto/ListarProdutos.php";
                break;
            case 'excluirProd':
                echo $_POST["id_produto"] . "aaa";
                exit();
                $idProduto = intval($_POST["id_produto"]);
                $produto = $produto = new Produto($this->dbConfig);
                $produto->deleteProdutc($idProduto);
            default:
                echo "Controller não encontrado!";
                break;
        }
    }
}

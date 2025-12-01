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
                $partes = explode("/", $_GET['url']);
                $id = $partes[2];
                $produto = $produto = new Produto($this->dbConfig);
                $produto->deleteProdutc($id);
                header("Location: /lojaDePecas/public/index.php?url=listarProdutos");
                exit();
                break;
            case 'editProd':

                $partes = explode("/", $_GET['url']);

                $id = $partes[1];

                $produto = $produto = new Produto($this->dbConfig);
                $resultado = $produto->getProduto($id);

                include __DIR__ . "/../views/Produto/editarProduto.php";
                exit();
                break;
            case 'prodPut':
                $idProduto = $_POST["idProduto"] ?? null;
                $nome = $_POST["nome"] ?? null;
                $preco = floatval($_POST["preco"] ?? null);
                $img = $_POST["img"] ?? null;

                $produto = $produto = new Produto($this->dbConfig);
                $resultado = $produto->atualizaProduto($idProduto, $nome, $preco, $img);

                header("Location: /lojaDePecas/public/index.php?url=listarProdutos");
                exit();
                break;
            default:
                echo "Controller não encontrado!";
                break;
        }
    }
}

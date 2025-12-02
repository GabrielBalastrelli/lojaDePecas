<?php

class ControllerIndicador
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
            case 'indicadorTotProd':
                require __DIR__  . "/../model/Produto.php";
                require __DIR__  . "/../model/PessoaFisica.php";

                $produto = new Produto($this->dbConfig);
                $total =  $produto->recuperaTotalProduto();

                $pessoaFisica = new PessoaFisica($this->dbConfig);
                $totalCliente =  $pessoaFisica->recuperaTotalClientes();


                include __DIR__ . "/../views/Indicador/indicador.php";
                break;
            default:
                echo "Controller não encontrado!";
                break;
        }
    }
}

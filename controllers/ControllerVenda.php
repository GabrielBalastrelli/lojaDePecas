<?php

class ControllerVenda
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
            case 'efetuarVenda':
                include __DIR__ . "/../views/FaturaVenda/faturaVenda.php";
                break;
            default:
                echo "Controller não encontrado!";
                break;
        }
    }
}

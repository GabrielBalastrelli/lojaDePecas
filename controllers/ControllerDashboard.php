<?php

class ControllerDashboard
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
            case 'dashboard':
                include __DIR__ . "/../views/Dashboard/dashboard.php";
                break;
            default:
                echo "Controller não encontrado!";
                break;
        }
    }
}

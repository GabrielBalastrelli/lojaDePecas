<?php

require_once __DIR__ . "/../model/Operador.php";

class ControllerOperador
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
            case 'login':
                if ($_SERVER["REQUEST_METHOD"] === "POST") {
                    $codOperador = $_POST["codOperador"] ?? null;
                    $senha = $_POST["senha"] ?? null;

                    $operador = new Operador($this->dbConfig);
                    $operador->setarDados(null, $senha,  $codOperador);

                    $inLogin = $operador->validarLogin($codOperador,  $senha);

                    if (!$inLogin) {
                        $erro = "Login ou senha incorretos.";
                        return $erro;
                    }

                    $dadosOperador = $operador->getLogin($codOperador);

                    $pessoa = $operador->getDadosPessoas($dadosOperador->id_pessoa);

                    $_SESSION["nome"] = $pessoa->nome;
                    $_SESSION["cd"] =   $codOperador;

                    echo $_SESSION["nome"];
                    exit();
                }

                include __DIR__ . "/../views/Login/login.php";
                break;
            default:
                echo "Controller não encontrado!";
                break;
        }
    }
}

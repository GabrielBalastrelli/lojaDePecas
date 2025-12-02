<?php

require_once __DIR__ . "/../model/PessoaFisica.php";
require_once __DIR__ . "/../model/Pessoa.php";

class ControllerCliente
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
            case 'cadastroClienteFisico':
                if ($_SERVER["REQUEST_METHOD"] === "POST") {
                    $nome  = $_POST["nome"] ?? null;

                    $pessoa = new Pessoa($this->dbConfig);
                    $pessoa->setarDados($nome);
                    $idPessoa = $pessoa->salvarPessoa();


                    $cpf =  $_POST["cpf"] ?? null;
                    $rg   = $_POST["rg"] ?? null;
                    $dataNascimento = $_POST["dataNascimento"] ?? null;
                    $estadoCivil = $_POST["estadoCivil"] ?? null;

                    $pessoaFisica = new PessoaFisica($this->dbConfig);
                    $pessoaFisica->setarDadosPessoaFisica($idPessoa, $cpf, $rg, $dataNascimento, $estadoCivil);
                    $resultado = $pessoaFisica->salvarClienteFisica();

                    exit();
                    if ($resultado["erro"]) {
                        $msg = urlencode($resultado["mensagem"]);
                        header("Location: index.php?url=cadastroClienteFisico&erro=$msg");
                        exit();
                    }

                    header("Location: index.php?url=cadastroClienteFisico&sucesso=1");
                    exit();
                }
                include __DIR__ . "/../views/Cliente/CadCliente.php";
                break;
            case 'painelClientes':
                include __DIR__ . "/../views/Cliente/PainelClientes.php";
                break;
            case 'listarCliente':

                $pessoaFisica = new PessoaFisica($this->dbConfig);
                $resultados = $pessoaFisica->listarClientes();

                include __DIR__ . "/../views/Cliente/Listar.php";
                break;
            case 'clienteExcluir':
                $partes = explode("/", $_GET['url']);
                $id = $partes[1];

                $pessoaFisica = new PessoaFisica($this->dbConfig);
                $id = $pessoaFisica->deleteClienteFisico($id);

                $pessoa = new Pessoa($this->dbConfig);
                $pessoa->deletarPessoa($id);

                include __DIR__ . "/../views/Cliente/Listar.php";
                exit();
                break;
            case 'editarCliente':
                $partes = explode("/", $_GET['url']);

                $id = $partes[1];

                $pessoaFisica = new PessoaFisica($this->dbConfig);
                $resultado =  $pessoaFisica->getPessoaFisica($id);

                include __DIR__ . "/../views/Cliente/editarCliente.php";
                exit();

                break;
            case 'clientePut':

                $id = $_POST["id"];
                $nome = $_POST["nome"];
                $cpf = $_POST["cpf"];
                $rg = $_POST["rg"];
                $estadoCivil = $_POST["estadoCivil"];
                $dataNascimento = $_POST["dataNascimento"];

                $pessoaFisica = new PessoaFisica($this->dbConfig);
                $resultado =  $pessoaFisica->putCliente($id, $nome, $cpf, $rg, $estadoCivil, $dataNascimento);

                if ($resultado === true) {
                    header("Location: index.php?url=listarCliente&sucesso=1");
                } else {
                    header("Location: index.php?url=editarCliente&id=$idPessoa&erro=" . urlencode($resultado));
                }

                exit();
                break;
            default:
                echo "Controller não encontrado!";
                break;
        }
    }
}

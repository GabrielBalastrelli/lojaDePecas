<?php

require_once __DIR__  . " /../model/Pessoa.php";

class PessoaFisica extends Pessoa
{
    private int $id_pessoa;
    private string $cpf;
    private string $rg;
    private string $data_nascimento;
    private string $estado_civil;
}

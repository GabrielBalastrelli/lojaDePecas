<?php

class DbConnection
{
    private $host;
    private $user;
    private $password;
    private $database;

    public function __construct(string $host, string $user, string $password, string $database)
    {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->database = $database;
    }

    public function connection()
    {
        try {
            return  new PDO(
                "mysql:host={$this->host};dbname={$this->database};charset=utf8",
                $this->user,
                $this->password
            );
        } catch (PDOException $error) {
            die("Erro ao realizar a conexão com o banco de dados. {$error->getMessage()}");
        }
    }
};

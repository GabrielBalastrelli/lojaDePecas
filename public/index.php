<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <script src="../public/js/bootstrap.bundle.js"></script>
    <script src="../public/js/mostrarSenha.js" defer></script>
    <title>Loja de Peças</title>
</head>

<body>
    <?php
    include_once __DIR__ . "/../components/NavBar.php";
    ?>

    <main class="container-fluid text-center  d-flex flex-column justify-content-center align-items-center">
        <?php
        require_once __DIR__ . "/../config/dbConfig.php";
        $dbConfig = new DbConnection("localhost", "root", "", "loja_de_peças");

        $url = $_GET['url'] ?? 'login';
        $partes = explode('/', $url);

        switch ($partes[0]) {
            case 'login':
                require_once __DIR__ . "/../controllers/ControllerOperador.php";
                $controllerOperador = new ControllerOperador($dbConfig->connection());
                $controllerOperador->switchController($partes[0]);
                break;
            default:
                echo "404";
                break;
        }

        ?>
    </main>

    <?php
    include_once __DIR__ . "/../components/Footer.php";
    ?>
</body>

</html>
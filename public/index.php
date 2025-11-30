<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    <script src="../public/js/bootstrap.bundle.js"></script>
    <title>Loja de Peças</title>
</head>

<body>
    <?php
    include_once "../components/NavBar.php";
    ?>

    <main class="container-fluid text-center"> 
        <?php
        $url = $_GET['url'] ?? 'login';
        $partes = explode('/', $url);

        switch ($partes[0]) {
            case 'login':
                echo "Pagina de login";
                break;
            default:
                echo "404";
                break;
        }

        ?>
    </main>

    <?php
    include_once "../components/Footer.php";
    ?>
</body>

</html>
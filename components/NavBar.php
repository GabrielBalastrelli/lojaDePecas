<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">

        <a class="navbar-brand" href="#">
            <img src="../public/img/logo.png" alt="Loja de Peças" style="width: 140px;">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <?php
        if (isset($_SESSION["cd"])) { ?>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php?url=dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?url=produtos">Produtos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Emitir Nota</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?url=painelClientes">Clientes</a>
                    </li>
                </ul>
            <?php } ?>
            <?php if (isset($_SESSION["cd"])) { ?>
                <a href="logout.php" class="btn btn-danger">Sair</a>
            <?php } ?>
            </div>
    </div>
</nav>
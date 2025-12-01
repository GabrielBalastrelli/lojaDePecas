<div class="card p-4 shadow-sm" style="max-width: 800px; margin: auto;">
    <h4 class="mb-4 text-center">Confirmar Identidade</h4>

    <form class="row g-4" action="index.php?url=cadastroProduto" method="POST">

        <div class="col-12">
            <label for="produto" class="form-label">
                <i class="bi bi-box-fill"></i> Produto
            </label>
            <input type="text" class="form-control form-control-lg"
                id="produto" placeholder="Digite o Produto" name="nome">
        </div>

        <div class="col-12">
            <label for="preco" class="form-label">
                <i class="bi bi-currency-dollar"></i> Preço
            </label>
            <input type="text" class="form-control form-control-lg"
                id="preco" placeholder="Digite o preço" name="preco">
        </div>

        <div class="col-12">
            <label for="foto" class="form-label">
                <i class="bi bi-images"></i> Foto
            </label>
            <input type="text" class="form-control form-control-lg"
                id="foto" placeholder="Adicione o link da foto" name="img">
        </div>

        <div class="col-12 d-flex align-items-end">
            <button type="submit" class="btn btn-primary btn-lg w-100">
                <i class="bi bi-check-circle"></i> Cadastrar
            </button>
        </div>

    </form>
    <?php if (isset($_GET["erro"])): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($_GET["erro"]) ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET["sucesso"])): ?>
        <div class="alert alert-success">
            Produto cadastrado com sucesso!
        </div>
    <?php endif; ?>
</div>
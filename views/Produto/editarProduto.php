<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="m-0">Editar Produto</h4>
        </div>

        <div class="card-body">
            <form method="POST" action="index.php?url=prodPut">

                <div class="mb-3">
                    <label class="form-label">ID</label>
                    <input
                        type="text"
                        class="form-control"
                        name="idProduto"
                        value="<?= $resultado->id_produto ?>"
                        readonly>

                </div>

                <div class="mb-3">
                    <label class="form-label">Produto</label>
                    <input
                        type="text"
                        name="nome"
                        class="form-control"
                        value="<?= $resultado->nome ?>"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Preço</label>
                    <input
                        type="text"
                        name="preco"
                        class="form-control"
                        value="<?= $resultado->preco ?>"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Imagem</label>
                    <input
                        type="text"
                        name="img"
                        class="form-control"
                        value="<?= $resultado->img ?>">
                    <div>
                        <img width="70px" src="<?= $resultado->img ?>" alt="Imagem do Produto">
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">
                        Salvar Alterações
                    </button>
                    <a href="/lojaDePecas/public/index.php?url=listarProdutos" class="btn btn-secondary">
                        Cancelar
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
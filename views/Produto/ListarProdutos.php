<div class="card">
    <div class="card-header">
        <h2 class="float-start">Lista de Produtos</h2>
        <div class="float-end">
            <a href="/lojaDePecas/public/index.php?url=cadastroProduto" title="Novo Registro" class="btn btn-success">
                <i class="fas fa-file"></i> Novo Registro
            </a>

            <a href="/lojaDePecas/public/index.php?url=listarProdutos" title="Listar" class="btn btn-success">
                <i class="fas fa-file"></i> Listar
            </a>
        </div>
    </div>
    <div class="card-body">
        <p>Abaixo os produtos cadastrados:</p>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Imagem</td>
                    <td>Nome do Produto</td>
                    <td>Valor</td>
                    <td>Opções</td>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($dadosProduto as $dados) {
                ?>
                    <tr>
                        <td><?= $dados->id_produto ?></td>
                        <td><img src="<?= $dados->img ?>" width="70px"></td>
                        <td><?= $dados->nome ?></td>
                        <td><?= number_format($dados->preco, 2, ",", ".") ?></td>
                        <td width="150px">
                            <a href="javascript:excluir(<?= $dados->id_produto ?>, 'excluirProd')" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash">Excluir</i>
                            </a>
                            <a href="/lojaDePecas/public/index.php?url=editProd/<?= $dados->id_produto ?>" class="btn btn-info btn-sm">
                                <i class="fas fa-edit">Editar</i>
                            </a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
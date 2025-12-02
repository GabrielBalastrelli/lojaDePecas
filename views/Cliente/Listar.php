<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Lista de Clientes</h4>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>RG</th>
                        <th>Data de Nascimento</th>
                        <th>Estado Civil</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($resultados)): ?>
                        <?php foreach ($resultados as $cliente): ?>
                            <tr>
                                <td><?= htmlspecialchars($cliente->id_pessoa) ?></td>
                                <td><?= htmlspecialchars($cliente->nome) ?></td>
                                <td><?= htmlspecialchars($cliente->cpf) ?></td>
                                <td><?= htmlspecialchars($cliente->rg) ?></td>
                                <td><?= htmlspecialchars(date("d/m/Y", strtotime($cliente->data_nascimento))) ?></td>
                                <td><?= htmlspecialchars($cliente->estado_civil) ?></td>
                                <td>
                                    <a href="index.php?url=editarCliente/<?= $cliente->id_pessoa ?>" class="btn btn-sm btn-warning">
                                        Editar
                                    </a>
                                    <a href="javascript:void(0);" onclick="excluirCliente(<?= $cliente->id_pessoa ?>)" class="btn btn-sm btn-danger">
                                        Excluir
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">Nenhum cliente encontrado</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function excluirCliente(id) {
        if (confirm("Tem certeza que deseja excluir este cliente?")) {
            window.location.href = `index.php?url=clienteExcluir/${id}`;
        }
    }
</script>
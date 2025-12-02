<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="m-0">Editar Cliente</h4>
        </div>

        <div class="card-body">
            <form method="POST" action="index.php?url=clientePut">

                <div class="mb-3">
                    <label class="form-label">ID</label>
                    <input
                        type="text"
                        class="form-control"
                        name="id"
                        value="<?= $resultado->id_pessoa ?>"
                        readonly>

                </div>

                <div class="mb-3">
                    <label class="form-label">Nome</label>
                    <input
                        type="text"
                        name="nome"
                        class="form-control"
                        value="<?= $resultado->nome ?>"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">CPF</label>
                    <input
                        type="text"
                        name="cpf"
                        class="form-control"
                        value="<?= $resultado->cpf ?>"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">RG</label>
                    <input
                        type="text"
                        name="rg"
                        class="form-control"
                        value="<?= $resultado->rg ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Data de Nascimento</label>
                    <input
                        type="text"
                        name="dataNascimento"
                        class="form-control"
                        value="<?= $resultado->data_nascimento ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Estado Civil:</label>
                    <select name="estadoCivil" class="form-select" required>
                        <?php
                        $estados = ["Solteiro(a)", "Casado(a)", "Divorciado(a)", "Viúvo(a)", "Separado(a)", "União Estável"];
                        foreach ($estados as $estado) {
                            $selected = ($resultado->estado_civil === $estado) ? "selected" : "";
                            echo "<option value=\"$estado\" $selected>$estado</option>";
                        }
                        ?>
                    </select>
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
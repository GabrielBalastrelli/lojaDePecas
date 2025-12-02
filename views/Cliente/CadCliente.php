<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Cadastro de Cliente</h4>
        </div>

        <div class="card-body">
            <form method="POST" action="index.php?url=cadastroClienteFisico">

                <div class="mb-3">
                    <label class="form-label">Nome Completo:</label>
                    <input type="text" name="nome" class="form-control" required />
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">CPF:</label>
                        <input type="text" name="cpf" class="form-control" placeholder="000.000.000-00" required />
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">RG:</label>
                        <input type="text" name="rg" class="form-control" required />
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Data de Nascimento:</label>
                        <input type="date" name="dataNascimento" class="form-control" required />
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Estado Civil:</label>
                    <select name="estadoCivil" class="form-select" required>
                        <option value="">Selecione...</option>
                        <option>Solteiro(a)</option>
                        <option>Casado(a)</option>
                        <option>Divorciado(a)</option>
                        <option>Viúvo(a)</option>
                        <option>Separado(a)</option>
                        <option>União Estável</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success mt-2">
                    Salvar Cliente
                </button>

            </form>
        </div>
    </div>
</div>
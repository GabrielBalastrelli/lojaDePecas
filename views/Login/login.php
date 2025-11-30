<div class="mb-3 w-50">
    <form class=" d-flex flex-column justify-content-center align-items-center" action="/lojaDePecas/public/?url=login" method="POST">
        <div class="mb-3">
            <label for="codigoOperador" class="form-label">Código do Operador</label>
            <input type="number" class="form-control" id="codigoOperador" aria-describedby="codigoOperador" name="codOperador">
            <div id="operadorErro" class="form-text">Informe o código do funcionario.</div>
        </div>
        <div>
            <label for="senhaOperador" class="form-label">Senha</label>
            <div class="mb-3 input-group">
                <input type="password" class="form-control" id="senhaOperador" name="senha">
                <button class="btn btn-outline-secondary" type="button" onclick="mostrarSenha()"><i class="bi bi-lock"></i></button>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Logar</button>
    </form>
</div>
function excluir(id, tipo) {
  if (confirm("Tem certeza que deseja excluir este item?")) {
    window.location.href = `/lojaDePecas/public/index.php?url=excluirProd/excluir/${id}`;
  }
}

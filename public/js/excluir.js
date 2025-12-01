function excluir(id, tipo) {
  if (confirm("Tem certeza que deseja excluir este item?")) {
    window.location.href = `index.php?url=${tipo}/excluir/${id}`;
  }
}

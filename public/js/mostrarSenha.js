function mostrarSenha() {
  const campoSenha = document.getElementById("senhaOperador");

  campoSenha.type = campoSenha.type === "password" ? "text" : "password";
}

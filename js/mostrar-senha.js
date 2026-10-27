const mostrarSenha = document.querySelector("#mostrar-senha");
const campoSenha = document.querySelector("#senha");
mostrarSenha.addEventListener("click", function (){  

    this.classList.toggle("fa-eye-slash");
    this.classList.toggle("fa-eye", !this.classList.contains("fa-eye-slash"));
    const type = campoSenha.getAttribute("type") === "password"
    ? "text" : "password";
    campoSenha.setAttribute("type", type);

})
const mostrarSenha2 = document.getElementById("confirmar.mostrar");
const campoSenha2 = document.getElementById("confirmar-senha");
mostrarSenha2.addEventListener("click", function (){  

    this.classList.toggle("fa-eye-slash");
    this.classList.toggle("fa-eye", !this.classList.contains("fa-eye-slash"));
    const type = campoSenha2.getAttribute("type") === "password"
    ? "text" : "password";
    campoSenha2.setAttribute("type", type);

})

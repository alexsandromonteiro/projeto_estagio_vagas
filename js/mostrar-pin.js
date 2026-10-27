const mostrarPin = document.querySelector("#mostrar-pin");
const campoPin = document.querySelector("#pin");

mostrarPin.addEventListener("click", function (){  

    this.classList.toggle("fa-eye-slash");
    this.classList.toggle("fa-eye", !this.classList.contains("fa-eye-slash"));
    const type = campoPin.getAttribute("type") === "password"
    ? "text" : "password";
    campoPin.setAttribute("type", type);

})
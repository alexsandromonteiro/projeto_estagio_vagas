<?php 

 function verifica_sessao() {
session_start();
    if ((!isset($_SESSION['id_usuario'])) and 
    (!isset($_SESSION['email'])) and (!isset($_SESSION['senha']))
    and (!isset($_SESSION['img_usuario'])) ) {
        unset($_SESSION['email']);
        unset($_SESSION['senha']);
        unset($_SESSION["id_usuario"]);
        unset($_SESSION["img_usuario"]);
        header("Location:../login/login.php");
    }

}
?>
<?php 
session_start();

unset($_SESSION['email']);
unset($_SESSION['senha']);
unset($_SESSION["id_usuario"]);
unset($_SESSION["img_usuario"]);
session_destroy();
header("Location:./index.php");

?>
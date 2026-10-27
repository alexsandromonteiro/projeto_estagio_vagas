<?php 
session_start();
if(isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['senha'])) {

    include("../PHP/conexao.php");
    $email = $_POST['email'];
    $senha = md5($_POST['senha']);

    $consulta_usuario = 
    "SELECT * FROM usuario WHERE email = '$email' 
    and senha = '$senha'";
    
    $result_usuario = $conexao->query($consulta_usuario);

    $row = $result_usuario->fetch_object();


    if(mysqli_num_rows($result_usuario) < 1) {
        unset($_SESSION[$email]);
        unset($_SESSION[$senha]);
        header("Location:login.php?erro=dadosinvalidos");
}
    
    else {
        $_SESSION['email'] = $email;
        $_SESSION['senha'] = $senha;
        $_SESSION["id_usuario"] = $row->id_usuario;
        $_SESSION["img_usuario"] = $row->img_usuario;
        if($_SESSION['img_usuario'] == null) {
            $sql_imagem = "UPDATE usuario SET img_usuario = 'profile-icon.png' 
            WHERE id_usuario = " . $_SESSION['id_usuario'];
         $result_imagem = $conexao->query($sql_imagem);
         $_SESSION['img_usuario'] = 'profile-icon.png';
         header("Location:../index.php");
        }
        else {
        header("Location:../index.php");
        }
    }
}
else {
    header("Location:login.php");
}
   


        









?>
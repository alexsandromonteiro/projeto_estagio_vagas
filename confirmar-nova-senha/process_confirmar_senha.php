<?php


function confirmar_senha($conexao)
{
    if (
        isset($_POST['confirmar']) && isset($_POST['senha'])
        && isset($_POST['confirmar-senha']) && isset($_SESSION['email']) &&
        ($_POST['senha'] == $_POST['confirmar-senha'])
    ) {

        $email = $_SESSION['email'];

        $confirmar_senha = md5($_POST['confirmar-senha']);


        $new_senha = "UPDATE usuario SET senha = '$confirmar_senha'
        WHERE email = '$email' ";

        $result_new_senha = $conexao->query($new_senha);

        if ($result_new_senha) {
            unset($_SESSION['email']);
            session_destroy();
            header("Location:../login/login.php");
            exit();
        } else {

            echo "Falha ao trocar a senha: " . $conexao->error;
        }
    } else if (
        isset($_POST['confirmar']) && isset($_POST['senha'])
        && isset($_POST['confirmar-senha']) && isset($_SESSION['email']) &&
        ($_POST['senha'] != $_POST['confirmar-senha'])
    ) {

        echo "<br/><h4 style='color:#ff0000'>Erro! As senhas não são iguais!</h4>";
    }
}

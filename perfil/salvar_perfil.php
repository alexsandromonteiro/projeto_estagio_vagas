<?php  
include("../funcoes/funcao_sessao.php");
verifica_sessao();
include('../PHP/conexao.php');

// Consultar registro do usuário
/*$id_usuario = $_GET['id_usuario'];
$consulta_usuario = "SELECT * FROM usuario WHERE id_usuario = $id_usuario";
$result = $conexao->query($consulta_usuario);*/
$id_usuario = $_SESSION['id_usuario'];
//echo $_SESSION['email'];
//echo $_SESSION['senha'];



// Verificar se a senha do formulário é a mesma da sessão de login
if (isset($_POST['senha']) && $_POST['senha'] == $_SESSION['senha']) {

    $email = $_POST['email'];
    
    if(isset($_FILES["imagem"]) && 
    is_uploaded_file($_FILES["imagem"]["tmp_name"])) {

        if ($_SESSION['img_usuario'] !== 'profile-icon.png') {
            // A imagem da sessão é diferente de "profile-icon.png", então exclua o arquivo
            unlink("../img_perfil/" . $_SESSION['img_usuario']);
        } else {
            // A imagem da sessão é "profile-icon.png", não faça nada
        }
        $banner = $_FILES['imagem'];
        $extensao = strtolower(substr($_FILES['imagem']['name'], -4));
        $novo_nome = md5(time()) . $extensao;
        $diretorio = "../img_perfil/";
    
        move_uploaded_file($_FILES['imagem']['tmp_name'], $diretorio.$novo_nome);
    
        $sql_usuario = "UPDATE usuario SET email = '$email', img_usuario = '$novo_nome'
        WHERE id_usuario = '$id_usuario'";
        
        
        if($conexao->query($sql_usuario)) {
             $_SESSION['email'] = $email;
             $_SESSION['img_usuario'] = $novo_nome;
           header("Location:../index.php");
        }
    
    }
    else {
        $sql_usuario = "UPDATE usuario SET email = '$email' WHERE id_usuario = $id_usuario ";
        $result_atualizacao = $conexao->query($sql_usuario);
        $_SESSION['email'] = $email;
        header("Location:../index.php");
    }
    
}
    else {
        $senha = md5($_POST['senha']);
        $email = $_POST['email'];

        if(isset($_FILES['imagem']) && is_uploaded_file($_FILES["imagem"]["tmp_name"])) {
            if ($_SESSION['img_usuario'] !== 'profile-icon.png') {
                // A imagem da sessão é diferente de "profile-icon.png", então exclua o arquivo
                unlink("../img_perfil/" . $_SESSION['img_usuario']);
            } else {
                // A imagem da sessão é "profile-icon.png", não faça nada
            }
            $banner = $_FILES['imagem'];
            $extensao = strtolower(substr($_FILES['imagem']['name'], -4));
            $novo_nome = md5(time()) . $extensao;
            $diretorio = "../img_perfil/";
        
            move_uploaded_file($_FILES['imagem']['tmp_name'], $diretorio.$novo_nome);
        
            $sql_usuario = "UPDATE usuario SET email = '$email', senha = '$senha', img_usuario = '$novo_nome'
            WHERE id_usuario = '$id_usuario'";
            
            
            if($conexao->query($sql_usuario)) {
                $_SESSION['email'] = $email;
               $_SESSION['img_usuario'] = $novo_nome;
              $_SESSION['senha'] = $senha;
               header("Location:../index.php");
            }
        
        }
        else {
            $sql_usuario = "UPDATE usuario SET email = '$email', senha = '$senha' WHERE id_usuario = $id_usuario ";
            $result_atualizacao = $conexao->query($sql_usuario);
            $_SESSION['email'] = $email;
            $_SESSION['senha'] = $senha;
            header("Location:../index.php");
        }

    }
    
?>
<?php
include("../funcoes/funcao_sessao.php");
verifica_sessao();
include("../PHP/conexao.php");

if(isset($_POST['adicionar']) && !empty($_POST['id_usuario']) && !empty($_POST['area']))
{
        $id_usuario = $_POST['id_usuario'];
        $area = $_POST['area'];

        $inserção_area = "INSERT INTO area (area, id_usuario)
                        VALUES ('$area', '$id_usuario')";

        $result_area_inserir = $conexao->query($inserção_area); 
        header("Location:../cadastrar-vaga/cadastrar-vaga.php");
}





?>
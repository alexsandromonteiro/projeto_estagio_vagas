<?php 
include("../funcoes/funcao_sessao.php");
verifica_sessao();
include("../PHP/conexao.php");

$id_area = $_GET['id_area'];

$excluir_registro = "DELETE FROM area WHERE id_area = $id_area";

$result_excluir = $conexao->query($excluir_registro);

header("Location:./cadastrar-area.php");
?>
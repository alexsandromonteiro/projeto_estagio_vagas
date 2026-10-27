<?php 
include("../funcoes/funcao_sessao.php");
verifica_sessao();
include_once("../PHP/conexao.php");
$id_vaga = $_GET['id_vaga'];

$deletar_vaga_area = "DELETE FROM vaga_area WHERE id_vaga = '$id_vaga'";

$result_del_vaga_area = $conexao->query($deletar_vaga_area);

$deletar_vaga = "DELETE FROM vaga WHERE id_vaga = '$id_vaga'";

$select_banner_vaga = "SELECT img_vaga FROM vaga WHERE id_vaga = '$id_vaga'";

$result_del_banner = $conexao->query($select_banner_vaga);

foreach($result_del_banner as $deletar_banner_vaga) {
    unlink("../img_vaga/" . $deletar_banner_vaga['img_vaga']);
}

$result_del_vaga = $conexao->query($deletar_vaga);


header("Location:../index.php");

?>
<?php 

$host = "localhost";
$user = "root";
$senha = "";
$dbname = "vagas";

$conexao = new mysqli($host, $user, $senha, $dbname);


if(!$conexao) {
    echo "<h3>Erro de conexão ao Banco de Dados</h3> " + mysqli_error($conexao);
}





?>
<?php
session_start();
include('../PHP/conexao.php');

if (isset($_POST['salvar'])) {
    $vaga = $_POST['vaga'];
    $empresa = $_POST['empresa'];
    $descricao = $_POST['descricao'];
    $tipo = $_POST['tipo'];
    $atuacao = $_POST['atuacao'];
    $periodo = $_POST['periodo'];
    $salario = $_POST['salario'];
    $hora = $_POST['hora'];
    $id_usuario = $_POST['id_usuario'];

    $area1 = $_POST['area1'];
    $area2 = isset($_POST['area2']) && $_POST['area2'] !== 'selecione_area' ? $_POST['area2'] : null;
    $area3 = isset($_POST['area3']) && $_POST['area3'] !== 'selecione_area' ? $_POST['area3'] : null;
    $area4 = isset($_POST['area4']) && $_POST['area4'] !== 'selecione_area' ? $_POST['area4'] : null;


    $msg = false;

    // Inserir dados na tabela vaga
    if (isset($_FILES['banner'])) {
        $banner = $_FILES['banner'];
        $extensao = strtolower(substr($_FILES['banner']['name'], -4));
        $novo_nome = md5(time()) . $extensao;
        $diretorio = "../img_vaga/";

        if (move_uploaded_file($_FILES['banner']['tmp_name'], $diretorio . $novo_nome)) {
            $sql_vaga = "INSERT INTO vaga (vaga, desc_vaga, hora_vaga, per_vaga, sal_vaga, emp_vaga, img_vaga, id_tipo, id_atuacao, id_usuario)
                values ('$vaga', '$descricao', '$hora', '$periodo', '$salario', '$empresa', '$novo_nome', '$tipo', '$atuacao', '$id_usuario') ";
        } else {
            $sql_vaga = "INSERT INTO vaga (vaga, desc_vaga, hora_vaga, per_vaga, sal_vaga, emp_vaga, id_tipo, id_atuacao, id_usuario)
                values ('$vaga', '$descricao', '$hora', '$periodo', '$salario', '$empresa', '$tipo', '$atuacao', '$id_usuario') ";
        }
    }

    if ($conexao->query($sql_vaga)) {
        $id_vaga = $conexao->insert_id;

        // Inserir área 1
        $sql_vaga_area1 = "INSERT INTO vaga_area (id_vaga, id_area, ordem_area) VALUES ('$id_vaga', '$area1', 1)";
        $result_vaga_area1 = $conexao->query($sql_vaga_area1);
        $count = 2;

        // Verificar e inserir área 2 se não for nula e diferente de área 1
        if (!is_null($area2) && $area2 !== $area1) {
            $sql_vaga_area2 = "INSERT INTO vaga_area (id_vaga, id_area, ordem_area) VALUES ('$id_vaga', '$area2', $count)";
            $result_vaga_area2 = $conexao->query($sql_vaga_area2);
            $count++;
        }

        // Verificar e inserir área 3 se não for nula, diferente de área 1 e diferente de área 2
        if (!is_null($area3) && $area3 !== $area1 && $area3 !== $area2) {
            $sql_vaga_area3 = "INSERT INTO vaga_area (id_vaga, id_area, ordem_area) VALUES ('$id_vaga', '$area3', $count)";
            $result_vaga_area3 = $conexao->query($sql_vaga_area3);
            $count++;
        }

        // Verificar e inserir área 4 se não for nula, diferente de área 1, diferente de área 2 e diferente de área 3
        if (!is_null($area4) && $area4 !== $area1 && $area4 !== $area2 && $area4 !== $area3) {
            $sql_vaga_area4 = "INSERT INTO vaga_area (id_vaga, id_area, ordem_area) VALUES ('$id_vaga', '$area4', $count)";
            $result_vaga_area4 = $conexao->query($sql_vaga_area4);
        }

        $msg = "Dados enviados com sucesso!";
        header("Location: ../index.php");
        exit;
    } else {
        $msg = "Falha ao enviar os dados";
        echo $msg;
    }
}
?>

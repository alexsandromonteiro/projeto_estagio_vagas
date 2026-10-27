<?php
session_start();
include('../PHP/conexao.php');

$id_vaga = $_GET['id_vaga'];

$cons_vaga = "SELECT img_vaga FROM vaga WHERE id_vaga = '$id_vaga'";

$result_banner_vaga = $conexao->query($cons_vaga);

if (isset($_POST['salvar'])) {
    // Verifica se o id_vaga está definido na requisição POST
    if (isset($_POST['id_vaga'])) {
        $id_vaga = $_POST['id_vaga'];
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
        $area2 = isset($_POST['area2']) ? $_POST['area2'] : null;
        $area3 = isset($_POST['area3']) ? $_POST['area3'] : null;
        $area4 = isset($_POST['area4']) ? $_POST['area4'] : null;

        $msg = false;

        // Verifica se há um novo banner para upload
        if (isset($_FILES['banner']) && $_FILES['banner']['error'] == 0
        && is_uploaded_file($_FILES["banner"]["tmp_name"])) {
            
            foreach($result_banner_vaga as $imagem_banner) {
            unlink("../img_vaga/" . $imagem_banner['img_vaga']);
            }
            $banner = $_FILES['banner'];
            $extensao = strtolower(substr($_FILES['banner']['name'], -4));
            $novo_nome = md5(time()) . $extensao;
            $diretorio = "../img_vaga/";

            if (move_uploaded_file($_FILES['banner']['tmp_name'], $diretorio . $novo_nome)) {
                // Se o banner foi enviado com sucesso, atualiza a vaga incluindo o novo banner
                $sql_vaga = "UPDATE vaga SET 
                    vaga = '$vaga',
                    desc_vaga = '$descricao',
                    hora_vaga = '$hora',
                    per_vaga = '$periodo',
                    sal_vaga = '$salario',
                    emp_vaga = '$empresa',
                    img_vaga = '$novo_nome',
                    id_tipo = '$tipo',
                    id_atuacao = '$atuacao',
                    id_usuario = '$id_usuario'
                WHERE id_vaga = $id_vaga";
            } else {
                // Se houver um erro no upload do banner, atualiza a vaga sem alterar o banner
                $sql_vaga = "UPDATE vaga SET 
                    vaga = '$vaga',
                    desc_vaga = '$descricao',
                    hora_vaga = '$hora',
                    per_vaga = '$periodo',
                    sal_vaga = '$salario',
                    emp_vaga = '$empresa',
                    id_tipo = '$tipo',
                    id_atuacao = '$atuacao',
                    id_usuario = '$id_usuario'
                WHERE id_vaga = $id_vaga";
            }
        } else {
            // Se não houver um novo banner para upload, atualiza a vaga sem alterar o banner
            $sql_vaga = "UPDATE vaga SET 
                vaga = '$vaga',
                desc_vaga = '$descricao',
                hora_vaga = '$hora',
                per_vaga = '$periodo',
                sal_vaga = '$salario',
                emp_vaga = '$empresa',
                id_tipo = '$tipo',
                id_atuacao = '$atuacao',
                id_usuario = '$id_usuario'
            WHERE id_vaga = $id_vaga";
        }

        // Executa a consulta de atualização da vaga
        if ($conexao->query($sql_vaga)) {
            // Se a atualização da vaga foi bem-sucedida, atualiza as áreas associadas à vaga
            $count = 1;
            function atualizarVagaArea($idVaga, $idArea, $ordemArea) {
                global $conexao;
            
                // Verifica se $idArea não é vazio antes de realizar a operação
                if (!empty($idArea)) {
                    // Verifica se já existe uma associação entre a vaga e a área na ordem especificada
                    $sqlVerificarExistencia = "SELECT * FROM vaga_area WHERE id_vaga = $idVaga AND ordem_area = $ordemArea";
                    $resultadoVerificarExistencia = $conexao->query($sqlVerificarExistencia);
            
                    if ($resultadoVerificarExistencia->num_rows > 0) {
                        // Se a associação já existe, atualiza a área
                        $sql = "UPDATE vaga_area SET id_area = '$idArea' WHERE id_vaga = $idVaga AND ordem_area = $ordemArea";
                    } 
                    else {
                        // Se a associação não existe, insere uma nova área
                        $sql = "INSERT INTO vaga_area (id_vaga, id_area, ordem_area) VALUES ('$idVaga', '$idArea', $ordemArea)";
                    }
            
                    return $conexao->query($sql);
                } else {
                    // Lida com o caso em que $idArea é vazio
                    echo "ID da área está vazio.";
                    return false; // Indica que a operação falhou
                }
            }
            

            // Atualiza as áreas
            if (isset($area1)) {
                atualizarVagaArea($id_vaga, $area1, $count);
                $count++;
            }

            if (isset($area2) && $area2 !== $area1) {
                atualizarVagaArea($id_vaga, $area2, $count);
                $count++;
            }

            if (isset($area3) && $area3 !== $area1 && $area3 !== $area2) {
                atualizarVagaArea($id_vaga, $area3, $count);
                $count++;
            }

            if (isset($area4) && $area4 !== $area1 && $area4 !== $area2 && $area4 !== $area3) {
                atualizarVagaArea($id_vaga, $area4, $count);
            }

            // Função para excluir uma entrada de vaga_area com base na ordem_area
    function excluirVagaArea($idVaga, $ordemArea) {
    global $conexao;

    $sqlExcluir = "DELETE FROM vaga_area WHERE id_vaga = $idVaga AND ordem_area = $ordemArea";

    return $conexao->query($sqlExcluir);
}

if (empty($area1)) {
    excluirVagaArea($id_vaga, 1);
}

if (empty($area2)) {
    excluirVagaArea($id_vaga, 2);
}

if (empty($area3)) {
    excluirVagaArea($id_vaga, 3);
}

if (empty($area4)) {
    excluirVagaArea($id_vaga, 4);
}

            
            $msg = "Dados atualizados com sucesso!";
            header("Location: ../index.php"); // Redireciona para outra página após a atualização bem-sucedida.
            exit; // Encerra o script para evitar que ele continue após o redirecionamento.
        } else {
            $msg = "Falha ao atualizar os dados";
            echo $msg;
        }
    } else {
        // Se o id_vaga não está definido, redirecione ou trate o erro conforme necessário
        echo "ID da vaga não definido.";
    }
}
?>

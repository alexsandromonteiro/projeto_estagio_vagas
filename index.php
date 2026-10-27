<?php
    session_start();
    include_once('./PHP/conexao.php');


// Antes da consulta SQL, declare a variável $areaWhereClause
$areaWhereClause = "";

if (isset($_POST['area-checkbox'])) {
    $areasSelecionadas = $_POST['area-checkbox'];
    $areasSelecionadas = array_map(array($conexao, 'real_escape_string'), $areasSelecionadas);

    if (!empty($areasSelecionados)) {
        $areaClauses = array();
        foreach ($areasSelecionados as $area) {
            // Crie uma subconsulta que verifica se a vaga está associada à área selecionada na tabela vaga_area
            $subquery = "EXISTS (SELECT 1 FROM vaga_area va WHERE va.id_vaga = v.id_vaga AND va.id_area = '$area')";
            $areaClauses[] = $subquery;
        }
        $areaWhereClause = "AND (" . implode(" OR ", $areaClauses) . ")";
    } else {
        $areaWhereClause = "";
    }
}

// Adicione a cláusula da área na consulta SQL
$sql = "SELECT v.*, a.atuacao, t.tipo, a.id_atuacao, area.id_area, va.id_area
    FROM vaga v 
    INNER JOIN tipo t ON v.id_tipo = t.id_tipo 
    INNER JOIN atuacao a ON v.id_atuacao = a.id_atuacao 
    LEFT JOIN vaga_area va ON v.id_vaga = va.id_vaga
    INNER JOIN area ON va.id_area = area.id_area
    WHERE 1" . $areaWhereClause . " GROUP BY v.id_vaga";

        $result_vagas = mysqli_query($conexao, $sql);
        
        $vagas = [];
        while ($row = mysqli_fetch_assoc($result_vagas)) {
            $vagas[] = $row;
        }

        // Verifique o número total de vagas após a filtragem
        $total_vagas = count($vagas);

        // Defina o número de resultados por página
        $resultados_por_pagina = ($total_vagas < 10) ? $total_vagas : 10;
        
        // Calcule o número total de páginas
        if($result_vagas->num_rows > 0) {
        $total_paginas = ceil($total_vagas / $resultados_por_pagina);
        }
        else {
            
        }
        // Verifique se a página atual está definida
        if (isset($_GET['pagina'])) {
            $pagina_atual = $_GET['pagina'];
        } else {
            $pagina_atual = 1;
        }

        // Calcule o índice de início com base na página atual
        $indice_inicio = ($pagina_atual - 1) * $resultados_por_pagina;

        // Consulta SQL para buscar as vagas da página atual
        $sql_pagina_atual = $sql . " LIMIT $indice_inicio, $resultados_por_pagina";

        $vagas_pagina_atual = array_slice($vagas, $indice_inicio, $resultados_por_pagina);
        
        $result_pagina_atual = mysqli_query($conexao, $sql_pagina_atual);
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FATECBP | Painel de Vagas</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <header class="container text-center py-3">
        <div class="row align-items-center">
            <div class="col text-end">
                <a href="http://www.cps.sp.gov.br/">
                    <img class="img-fluid" src="./img/cps.png" alt="">
                </a>               
            </div>
            <div class="col-5">
                <a href="https://www.fatecbpaulista.edu.br/">
                    <img class="img-fluid" src="./img/logo-fatec.png" alt="">
                </a>               
            </div>
            <div class="col text-start">
                <a href="http://www.saopaulo.sp.gov.br/">
                    <img class="img-fluid" src="./img/sp.png" alt="">
                </a>             
            </div>
        </div>
    </header>

    <nav class="navbar bg-body-tertiary ps-3 sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href=""><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    fill="black" class="bi bi-house-fill" viewBox="0 0 16 16">
                    <path
                        d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5Z" />
                    <path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6Z" />
                </svg></a>

            <div class="btn-group">
              
            <?php if (isset($_SESSION['id_usuario']) && isset($_SESSION['email'])
                 && isset($_SESSION['senha']) && isset($_SESSION['img_usuario'])) { ?>
                <!-- Se já estiver logado vai mostrar o icone que ao ser clicado vai mostrar uma lista -->
                <button id="btn-profile-icon" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img class="rounded-circle" src="./img_perfil/<?= $_SESSION['img_usuario']?>" 
                    alt="" height="48px">
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="./perfil/perfil.php">Perfil</a></li>
                    <li><a class="dropdown-item" href="./cadastrar-vaga/cadastrar-vaga.php">Cadastrar Vaga</a></li>
                    <li><a class="dropdown-item" href="./logout.php">Sair</a></li>
                </ul>
                <?php } else { ?>
                 <!-- Se não estiver logado, mostrar o botão de entrar -->
                <a href="./login/login.php"><button class="my-2 me-3">Entrar</button></a> 
                    <?php } ?>
            </div>
        </div>
    </nav>

    <main class="mt-5">

        <h1 class="text-center display-6"><strong>Painel de Vagas</strong></h1>

        <div class="container-xxl mt-5 px-3 px-md-5 px-lg-5 px-xl-5">
            


    <div class="row">
    
        <div class="col-xl-5 col-lg-5 mb-3">

            
        <div class="accordion d-block mb-3" id="accordionFiltrar">
        <div class="accordion-item">
         <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
               data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
               <h2 class="fs-4"><strong>Filtrar</strong></h2>
            </button>
         </h2>
         <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionFiltrar">
            <div class="accordion-body">

            <h3 class="fs-5"><strong>Área</strong></h3>
                <?php
                $sql_area = "SELECT * FROM area"; // Consulte todas as áreas disponíveis na tabela "area"
                $area_result = mysqli_query($conexao, $sql_area);

                while ($row = mysqli_fetch_assoc($area_result)) {
                    $area = $row['id_area']; // Use o ID da área como valor
                    $checkboxId = 'btn-check-area-' . $area; // Use o ID da área como parte do ID
                    echo '<input type="checkbox" class="btn-check area-checkbox" id="' . $checkboxId . '" data-area="' . $area . '" autocomplete="off" name="area-checkbox[]">';
                    echo '<label class="btn" for="' . $checkboxId . '">' . $row['area'] . '</label><br>'; // Exiba o nome da área
                }
                ?>

            <div class="mt-4">
                <h3 class="fs-5"><strong>Tipo</strong></h3>
                <?php
                $sql_tipo = "SELECT DISTINCT tipo FROM tipo";
                $tipo_result = mysqli_query($conexao, $sql_tipo);

                while ($row = mysqli_fetch_assoc($tipo_result)) {
                    $tipo = $row['tipo'];
                    $checkboxId = 'btn-check-tipo-' . str_replace(' ', '-', $tipo); // Use o nome do Tipo da Vaga como parte do ID

                    echo '<input type="checkbox" class="btn-check tipo-checkbox" id="' . $checkboxId . '" data-tipo="' . $tipo . '" autocomplete="off">';
                    echo '<label class="btn" for="' . $checkboxId . '">' . $tipo . '</label>';
                }
                ?>
            </div>

            <div class="mt-4"><!--Atuação-->
                <h3 class="fs-5"><strong>Atuação</strong></h3>
                <?php
                $sql_atuacao = "SELECT DISTINCT atuacao FROM atuacao";
                $atuacao_result = mysqli_query($conexao, $sql_atuacao);

                while ($row = mysqli_fetch_assoc($atuacao_result)) {
                    $atuacao = $row['atuacao'];
                    $checkboxId = 'btn-check-' . str_replace(' ', '-', $atuacao); // Use o nome da Atuação como parte do ID

                    echo '<input type="checkbox" class="btn-check atuacao-checkbox" id="' . $checkboxId . '" data-atuacao="' . $atuacao . '" autocomplete="off">';
                    echo '<label class="btn" for="' . $checkboxId . '">' . $atuacao . '</label>';
                }
                ?>
            </div>

            <div class="mt-4"> <!-- Periodo -->
                <h3 class="fs-5"><strong>Período</strong></h3>
                
                <input type="checkbox" class="btn-check periodo-checkbox" id="btn-check-matutino" autocomplete="off" data-periodo="Matutino">
                <label class="btn" for="btn-check-matutino">Matutino</label>

                <input type="checkbox" class="btn-check periodo-checkbox" id="btn-check-vespertino" autocomplete="off" data-periodo="Vespertino">
                <label class="btn" for="btn-check-vespertino">Vespertino</label>

                <input type="checkbox" class="btn-check periodo-checkbox" id="btn-check-noturno" autocomplete="off" data-periodo="Noturno">
                <label class="btn" for="btn-check-noturno">Noturno</label>
            </div>
            </div>

         </div>
      </div>
   </div>


                </div>
                <div class="col">               
                <?php  //Proximo/Anterior
                    if (mysqli_num_rows($result_pagina_atual) > 0) {
                        // echo '<div class="navbar">';
                        // if ($pagina_atual > 1) {
                        //     $pagina_anterior = $pagina_atual - 1;
                        //     echo '<a href="?pagina=' . $pagina_anterior . '">Anterior</a>';
                        // }
                        // if (mysqli_num_rows($result_pagina_atual) == $resultados_por_pagina) {
                        //     $proxima_pagina = $pagina_atual + 1;
                        //     echo '<a href="?pagina=' . $proxima_pagina . '">Próxima</a>';
                        // }
                        // echo '</div>';

                        while ($row = mysqli_fetch_assoc($result_pagina_atual)) {
                            $id_vaga = $row['id_vaga'];
                            $vaga = $row['vaga'];
                            $empresa = $row['emp_vaga'];
                            $descricao = $row['desc_vaga'];
                            $tipo = $row['tipo'];
                            $atuacao = $row['atuacao'];
                            $periodo = $row['per_vaga'];
                            $salario = $row['sal_vaga'];
                            $hora = $row['hora_vaga'];
                            $id_usuario = $row['id_usuario'];
                            $banner = $row['img_vaga'];

                            $consultar_vaga = "SELECT * FROM atuacao a INNER JOIN vaga v 
                            ON (a.id_atuacao = v.id_atuacao) INNER JOIN tipo t
                            ON (v.id_tipo = t.id_tipo) 
                            WHERE id_vaga = $id_vaga"; 
                            $result_vaga = $conexao->query($consultar_vaga);

                            $consultar_vaga_area = "SELECT a.id_area, a.area FROM vaga v INNER JOIN vaga_area va
                            ON (v.id_vaga = va.id_vaga) INNER JOIN area a ON (va.id_area = a.id_area)
                            WHERE v.id_vaga = $id_vaga";
                            
                            $result_vaga_area = $conexao->query($consultar_vaga_area);
                            
                            $areas = $result_vaga_area->fetch_all(MYSQLI_ASSOC);    


                            
                    ?>
        <div class="text-center card-vaga p-4 rounded mb-3" data-atuacao="<?php echo $atuacao; ?>" data-tipo="<?php echo $tipo;?>"  
        data-area1="<?php echo $areas[0]['id_area'];?>" data-area2="<?php echo $areas[1]['id_area'];?>" data-area3="<?php echo $areas[2]['id_area'];?>" data-area4="<?php echo $areas[3]['id_area'];?>" 
        data-periodo="<?php echo $periodo;?>" > <!--Vaga-->
            <!-- Adicione a classe "mb-2" para um pequeno espaço vertical entre divs -->
            <div class="row"  >
                <div class="col-4 d-none d-xl-block">
                    <?php
                    if (empty($row['img_vaga'])) {
                        echo '<a href="./vagas/vaga-exemplo.php?id_vaga=' . $id_vaga . 
                        '"><img class="img-fluid" src="./img/banner.png" alt="" height="150px"></a>';
                    } else {
                        $banner_path = "./img_vaga/" . $banner;
                        if (file_exists($banner_path)) {
                            echo '<a href="./vagas/vaga-exemplo.php?id_vaga=' . $id_vaga . '">
                            <img class="img-fluid" src="' . $banner_path . '" alt="" height="150px"></a>';
                        } else {
                            echo 'A imagem não foi encontrada: ' . $banner_path;
                        }
                    }
                    ?>
                </div>
                <div class="col">
                    <a href="./vagas/vaga-exemplo.php?id_vaga=<?= $id_vaga ?>">
                        <h2><?php echo $vaga; ?></h2>
                    </a>
                   <div class="d-flex flex-wrap mt-4">
    <div class="d-flex align-items-center me-4 mb-2">
        <img class="me-2" src="./img/building-fill.svg" alt="" style="width: 16px; height: 16px;">
        <span><?php echo $empresa; ?></span>
    </div>

    <div class="d-flex align-items-center me-4 mb-2">
        <img class="me-2" src="./img/globe.svg" alt="" style="width: 16px; height: 16px;">
        <span><?php echo $atuacao; ?></span>
    </div>

    <div class="d-flex align-items-center me-4 mb-2">
        <img class="me-2" src="./img/suitcase-lg-fill.svg" alt="" style="width: 16px; height: 16px;">
        <span><?php echo $tipo; ?></span>
    </div>

    <div class="d-flex align-items-center me-4 mb-2">
        <img class="me-2" src="./img/person-badge-fill.svg" alt="" style="width: 16px; height: 16px;">
        <span><?php echo $atuacao; // Note: alterado de $atuacao para $cargo ?></span>
    </div>

    <div class="d-flex align-items-center me-4 mb-2">
        <img class="me-2" src="./img/alarm.svg" alt="" style="width: 16px; height: 16px;">
        <span><?php echo $periodo; ?></span>
    </div>

    <div class="d-flex align-items-center me-4 mb-2">
        <img class="me-2" src="./img/cash.svg" alt="" style="width: 16px; height: 16px;">
        <span><?php echo $salario; ?></span>
    </div>

    <div class="d-flex align-items-center mb-2">
        <img class="me-2" src="./img/calendar.svg" alt="" style="width: 16px; height: 16px;">
        <span><?php echo $hora; ?></span>
    </div>
</div>
                </div>
            </div>
        </div>
        <?php
    }
                if (mysqli_num_rows($result_pagina_atual) > 0) {
                    // ... (código HTML para exibir as vagas) ...

                    echo '<nav aria-label="Page navigation"><ul class="pagination justify-content-center">';
                    if ($pagina_atual > 1) {
                        $pagina_anterior = $pagina_atual - 1;
                        echo '<li class="page-item"><a class="page-link" href="?pagina=' . $pagina_anterior . '">Anterior</a></li>';
                    }
                    if ($total_paginas > $pagina_atual) {
                        $proxima_pagina = $pagina_atual + 1;
                        echo '<li class="page-item"><a class="page-link" href="?pagina=' . $proxima_pagina . '">Próxima</a></li>';
                    }
                    echo '</ul></nav>';
                } else {
                    echo '<p class="text-center">Nenhuma vaga encontrada</p>';
                }
            }
        ?>
                </div>
            </div>
        </div>
    </main>

    <hr>

    <div class="container text-center py-3 mt-5">
        <div class="row align-items-center">
            <div class="col">
                <img class="img-fluid" src="./img/artesite_emec-400x156.jpg" alt="">
            </div>
            <div class="col">
                <a href="https://www.facebook.com/fatecbpnelf/">
                    <img class="img-fluid" src="./img/logotipo-nelf-v13-400x187.jpg" alt="">
                </a>               
            </div>
            <div class="col">
                <a href="https://www.fatecbpaulista.edu.br/canal_do_bertaglia/">
                    <img class="img-fluid" src="./img/barralateral_bertha.jpg" alt="">
                </a>             
            </div>
        </div>
    </div>

    <footer class="container-xxl text-center py-4 mt-5">
        <div class="row align-items-center">
            <div class="col text-end">
                <a href="http://www.cps.sp.gov.br/">
                    <img class="img-fluid" src="./img/cps_branco.png" alt="">
                </a>               
            </div>
            <div class="col-5">
                <a href="https://www.fatecbpaulista.edu.br/">
                    <img class="img-fluid" src="./img/fatec.png" alt="">
                </a>              
            </div>
            <div class="col text-start">
                <a href="http://www.saopaulo.sp.gov.br/">
                    <img class="img-fluid" src="./img/sp_branco.png" alt="">
                </a>            
            </div>
        </div>

        <div class="mt-5">
            Rua das Indústrias, 130 - Bairro Uberaba - CEP 12.926-674 Bragança Paulista - SP <br>
            Telefone: (11) 4031-0628 <br>
            E-mail: f183ata@cps.sp.gov.br
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="./js/bootstrap.min.js"></script>
</body>

</html>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const atuacaoCheckboxes = document.querySelectorAll('.atuacao-checkbox');
    const tipoCheckboxes = document.querySelectorAll('.tipo-checkbox');
    const periodoCheckboxes = document.querySelectorAll('.periodo-checkbox');
    const areaCheckboxes = document.querySelectorAll('.area-checkbox');
    const vagas = document.querySelectorAll('.card-vaga');

    function atualizarVagasExibidas() {
        const atuacoesSelecionadas = [...atuacaoCheckboxes]
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.getAttribute('data-atuacao'));
        const tiposSelecionados = [...tipoCheckboxes]
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.getAttribute('data-tipo'));
        const periodosSelecionados = [...periodoCheckboxes]
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.getAttribute('data-periodo'));
        const areasSelecionadas = [...areaCheckboxes]
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.getAttribute('data-area'));

        vagas.forEach(vaga => {
            const atuacaoVaga = vaga.getAttribute('data-atuacao');
            const tipoVaga = vaga.getAttribute('data-tipo');
            const periodoVaga = vaga.getAttribute('data-periodo');
            const area1Vaga = vaga.getAttribute('data-area1');
            const area2Vaga = vaga.getAttribute('data-area2');
            const area3Vaga = vaga.getAttribute('data-area3');
            const area4Vaga = vaga.getAttribute('data-area4');

            vaga.style.display = (
                (atuacoesSelecionadas.length === 0 || atuacoesSelecionadas.includes(atuacaoVaga))
                && (tiposSelecionados.length === 0 || tiposSelecionados.includes(tipoVaga))
                && (periodosSelecionados.length === 0 || periodosSelecionados.includes(periodoVaga))
                && (areasSelecionadas.length === 0 || areasSelecionadas.includes(area1Vaga) ||
                    areasSelecionadas.includes(area2Vaga) || areasSelecionadas.includes(area3Vaga) ||
                    areasSelecionadas.includes(area4Vaga))
            ) ? 'block' : 'none';
        });
    }

    atuacaoCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', atualizarVagasExibidas);
    });

    tipoCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', atualizarVagasExibidas);
    });

    periodoCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', atualizarVagasExibidas);
    });

    areaCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', atualizarVagasExibidas);
    });

    atualizarVagasExibidas();
});

</script>
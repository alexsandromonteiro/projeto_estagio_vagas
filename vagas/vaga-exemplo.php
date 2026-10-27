<?php 
  session_start();
 include_once("../PHP/conexao.php");

$id_vaga = $_GET['id_vaga'];

$consultar_vaga = "SELECT * FROM vaga v INNER JOIN  atuacao a
ON (a.id_atuacao = v.id_atuacao) INNER JOIN tipo t
ON (v.id_tipo = t.id_tipo) 
WHERE id_vaga = $id_vaga";

$result_vaga = $conexao->query($consultar_vaga);

$consultar_vaga_area = "SELECT a.id_area, a.area FROM vaga v INNER JOIN vaga_area va
ON (v.id_vaga = va.id_vaga) INNER JOIN area a ON (va.id_area = a.id_area)
WHERE v.id_vaga = $id_vaga";

$result_vaga_area = $conexao->query($consultar_vaga_area);

$areas = $result_vaga_area->fetch_all(MYSQLI_ASSOC);
/*
foreach($result_vaga_area as $res_vaga_area) {
    extract($res_vaga_area);
    echo $area . "<br/>";
}

echo "<br/>" . $areas[0]['area'];
*/
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FATECBP | Vaga</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <header class="container text-center py-3">
        <div class="row align-items-center">
            <div class="col text-end">
                <a href="http://www.cps.sp.gov.br/">
                    <img class="img-fluid" src="../img/cps.png" alt="">
                </a>               
            </div>
            <div class="col-5">
                <a href="https://www.fatecbpaulista.edu.br/">
                    <img class="img-fluid" src="../img/logo-fatec.png" alt="">
                </a>               
            </div>
            <div class="col text-start">
                <a href="http://www.saopaulo.sp.gov.br/">
                    <img class="img-fluid" src="../img/sp.png" alt="">
                </a>             
            </div>
        </div>
    </header>

    <nav class="navbar bg-body-tertiary ps-3 sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    fill="black" class="bi bi-house-fill" viewBox="0 0 16 16">
                    <path
                        d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5Z" />
                    <path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6Z" />
                </svg></a>

            <div class="btn-group">
                
            <?php  if (isset($_SESSION['id_usuario']) && isset($_SESSION['email'])
                 && isset($_SESSION['senha']) && isset($_SESSION['img_usuario'])) { ?> 

                <!-- Se já estiver logado vai mostrar o icone que ao ser clicado vai mostrar uma lista -->
                <button id="btn-profile-icon" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img class="rounded-circle" src="../img_perfil/<?= $_SESSION['img_usuario'] ?>" alt="" height="48px">
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="../perfil/perfil.php">Perfil</a></li>
                    <li><a class="dropdown-item" href="../cadastrar-vaga/cadastrar-vaga.php">Cadastrar Vaga</a></li>
                    <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
                </ul>
                <?php } else { ?>
                    <!-- Se não estiver logado, mostrar o botão de entrar -->
            <a href="../login/login.php"><button class="my-2 me-3">Entrar</button></a> 

            <?php } ?>
            </div>
        </div>
    </nav>

    <main class="mt-5">

    <?php foreach($result_vaga as $dados_vaga) { 
        extract($dados_vaga); 
        ?>
        <h1 class="text-center"><strong><?=$vaga ?></strong></h1>

        <div class="container-xxl mt-5 px-5">
        <div class="text-center mb-5">
            <?php
            $banner = $dados_vaga['img_vaga'];
                if (empty($dados_vaga['img_vaga'])) {
                    echo '<img class="image-fluid" src="../img_vaga/banner.png" 
                    alt="" height="250px"></a>';
                } else {
                    $banner_path = "../img_vaga/" . $banner;
                    if (file_exists($banner_path)) {
                        echo '<a href="./vagas/vaga-exemplo.php?id_vaga=' . $id_vaga . '">
                        <img class="image-fluid" src="' . $banner_path . '" alt="" 
                        height="250px"></a>';
                    } else {
                        echo 'A imagem não foi encontrada: ' . $banner_path;
                    }
                }

            ?>
                    
                </div>
        <form class="row g-3 my-5" id="meuFormulario" method="POST" name="formulario"
                action="processa_cadastro.php" enctype="multipart/form-data">
                <div class="col-md-6 mt-4">
                    <label for="vaga" class="form-label">Vaga</label>
                    <input type="text" class="form-control" id="vaga" name="vaga"
                    value="<?= $vaga ?>" readonly required>
                </div>
        
                
                <div class="col-md-6 mt-4">
                    <label for="empresa" class="form-label">Empresa</label>
                    <input type="text" class="form-control" id="empresa" name="empresa"
                    readonly value="<?= $emp_vaga ?>">
                </div>
                <div class="col-12 mt-4">
                    <label for="descricao" class="form-label">Descrição</label>
                    <textarea class="form-control" id="descricao" rows="10" 
                    name="descricao" readonly required><?php echo $desc_vaga; ?></textarea>
                </div>

                <div class="col-md-6 mt-4">
                    <label for="tipo" class="form-label">Tipo</label>
                    <select id="tipo" name="tipo" class="form-select" required>
                        <option value="<?= $id_tipo; ?>" selected><?= $tipo; ?></option>
                        
                       </select>
                </div>
                <div class="col-md-6 mt-4">
                    <label for="atuacao" class="form-label">Atuação</label>
                    <select id="atuacao" name="atuacao" class="form-select" required>
                        <option value="<?= $id_atuacao ?>"><?= $atuacao; ?></option>
                        
                    </select>
                </div>
                <div class="col-md-6 mt-4">
                    <label for="periodo" class="form-label">Período</label>
                    <select id="periodo" name="periodo" class="form-select" required>
                        <option value="<?= $per_vaga ?>"><?= $per_vaga; ?></option>
                    </select>
                </div>
                <div class="col-md-6 mt-4">
                    <label for="salario" class="form-label">Salário</label>
                    <input type="number" class="form-control" id="salario"
                    step="any" readonly value="<?= $sal_vaga; ?>" name="salario">
                </div>             
                <div class="col-12 mt-4">
                    <label for="hora" class="form-label">Carga Horária (Semanal)</label>
                    <input type="number" class="form-control" id="hora"
                    name="hora" readonly value="<?= $hora_vaga; ?>">
                </div>

                <div class="mt-4" style="margin-bottom: -25px">
                <label for="area" class="form-label">Área</label>                  
                    <a href="../cadastrar-area/cadastrar-area.php"><span type="button" data-bs-toggle="modal" data-bs-target="#popup-modal-area"><img src="../img/plus-circle.svg" alt=""></span></a>
                </div>
                    
                <!-- area -->
                <div class="col-md-6 mt-4">
                <select id="area1" name="area1" class="form-select" required>
                <?php if (isset($areas[0]['id_area'])) { ?>
               <option value="<?= $areas[0]['id_area']; ?>"> <?= $areas[0]['area']; ?> </option>
                 <?php } else { ?>
                <option value=""></option>
                <?php } ?>
                </select>
                
                </div>
                <div class="col-md-6 mt-4">
                    <select id="area2" name="area2" class="form-select" required>
                    <?php if (isset($areas[1]['id_area'])) { ?>
               <option value="<?= $areas[1]['id_area']; ?>"> <?= $areas[1]['area']; ?> </option>
                 <?php } else { ?>
                <option value=""></option>
                <?php } ?>
                    </select>
                   
                </div>
                <div class="col-md-6 mt-4">
                    <select id="area3" name="area3" class="form-select" required>
                    <?php if (isset($areas[2]['id_area'])) { ?>
               <option value="<?= $areas[2]['id_area']; ?>"> <?= $areas[2]['area']; ?> </option>
                 <?php } else { ?>
                <option value=""></option>
                <?php } ?>
                    </select>
                   
                </div>
                <div class="col-md-6 mt-4">
                    <select id="area4" name="area4" class="form-select" required>
                    <?php if (isset($areas[3]['id_area'])) { ?>
               <option value="<?= $areas[3]['id_area']; ?>"> <?= $areas[3]['area']; ?> </option>
                 <?php } else { ?>
                <option value=""></option>
                <?php } ?>
                </select>
                   
                </div>
                
                <?php } ?>
                <?php 
                 if (isset($_SESSION['id_usuario']) && isset($_SESSION['email'])
                 && isset($_SESSION['senha']) && isset($_SESSION['img_usuario'])) {
            
                ?>
                <a href="../editar-vaga/editar-vaga.php?id_vaga=<?= $id_vaga ?>" 
                class="text-center">
                    <button type="button" class="mt-5">Editar</button></a>

            </form>
       
        <?php } 
        else {
          
        }
        ?>
    </main>

    <hr>

    <div class="container text-center py-3 mt-5">
        <div class="row align-items-center">
            <div class="col">
                <img class="img-fluid" src="../img/artesite_emec-400x156.jpg" alt="">
            </div>
            <div class="col">
                <a href="https://www.facebook.com/fatecbpnelf/">
                    <img class="img-fluid" src="../img/logotipo-nelf-v13-400x187.jpg" alt="">
                </a>               
            </div>
            <div class="col">
                <a href="https://www.fatecbpaulista.edu.br/canal_do_bertaglia/">
                    <img class="img-fluid" src="../img/barralateral_bertha.jpg" alt="">
                </a>             
            </div>
        </div>
    </div>

    <footer class="container-xxl text-center py-4 mt-5">
        <div class="row align-items-center">
            <div class="col text-end">
                <a href="http://www.cps.sp.gov.br/">
                    <img class="img-fluid" src="../img/cps_branco.png" alt="">
                </a>               
            </div>
            <div class="col-5">
                <a href="https://www.fatecbpaulista.edu.br/">
                    <img class="img-fluid" src="../img/fatec.png" alt="">
                </a>              
            </div>
            <div class="col text-start">
                <a href="http://www.saopaulo.sp.gov.br/">
                    <img class="img-fluid" src="../img/sp_branco.png" alt="">
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
    <script src="../js/bootstrap.min.js"></script>
</body>

</html>
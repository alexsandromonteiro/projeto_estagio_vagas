<?php 
include("../funcoes/funcao_sessao.php");
verifica_sessao();
include_once("../PHP/conexao.php");

$id_vaga = $_GET['id_vaga'];

$consultar_area = "SELECT * FROM area a";
$result_area = $conexao->query($consultar_area);

$consultar_tipo = "SELECT * FROM tipo WHERE tipo <> (SELECT t.tipo FROM tipo t 
INNER JOIN vaga v ON t.id_tipo = v.id_tipo WHERE v.id_vaga = $id_vaga)";

$result_tipo = $conexao->query($consultar_tipo);

$consultar_atuacao = "SELECT * FROM atuacao a WHERE a.atuacao <> (SELECT a.atuacao FROM
atuacao a INNER JOIN vaga v ON a.id_atuacao = v.id_atuacao WHERE v.id_vaga = $id_vaga)";

$result_atuacao = $conexao->query($consultar_atuacao);

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

if (isset($areas[0]['id_area'])) {
$outraAreas1 = "SELECT a.id_area, a.area
FROM area a
WHERE a.id_area NOT IN (
    SELECT va.id_area
    FROM vaga v
    INNER JOIN vaga_area va ON (v.id_vaga = va.id_vaga)
    INNER JOIN area ON (va.id_area = a.id_area) 
    WHERE va.id_vaga = '$id_vaga' AND a.area = '" . $areas[0]['area'] . "'
)";
$result_outrasAreas1 = $conexao->query($outraAreas1);
}

if (isset($areas[1]['id_area'])) {
$outraAreas2 =  "SELECT a.id_area, a.area
FROM area a
WHERE a.id_area NOT IN (
    SELECT va.id_area
    FROM vaga v
    INNER JOIN vaga_area va ON (v.id_vaga = va.id_vaga)
    INNER JOIN area ON (va.id_area = a.id_area) 
    WHERE va.id_vaga = '$id_vaga' AND a.area = '" . $areas[1]['area'] . "'
)";
$result_outrasAreas2 = $conexao->query($outraAreas2);
}

if (isset($areas[2]['id_area'])) {
$outraAreas3 =  "SELECT a.id_area, a.area
FROM area a
WHERE a.id_area NOT IN (
    SELECT va.id_area
    FROM vaga v
    INNER JOIN vaga_area va ON (v.id_vaga = va.id_vaga)
    INNER JOIN area ON (va.id_area = a.id_area) 
    WHERE va.id_vaga = '$id_vaga' AND a.area = '" . $areas[2]['area'] . "'
)";
$result_outrasAreas3 = $conexao->query($outraAreas3);
}

if (isset($areas[3]['id_area'])) {
$outraAreas4 =  "SELECT a.id_area, a.area
FROM area a
WHERE a.id_area NOT IN (
    SELECT va.id_area
    FROM vaga v
    INNER JOIN vaga_area va ON (v.id_vaga = va.id_vaga)
    INNER JOIN area ON (va.id_area = a.id_area) 
    WHERE va.id_vaga = '$id_vaga' AND a.area = '" . $areas[3]['area'] . "'
)";
$result_outrasAreas4 = $conexao->query($outraAreas4);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FATECBP | Editar Vaga</title>
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
                <button id="btn-profile-icon" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img class="rounded-circle" src="../img_perfil/<?= $_SESSION['img_usuario'] ?>"  
                    alt="" height="48px">
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="../perfil/perfil.php">Perfil</a></li>
                    <li><a class="dropdown-item" href="../cadastrar-vaga/cadastrar-vaga.php">Cadastrar Vaga</a></li>
                    <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
        <?php foreach($result_vaga as $res_vaga) {
            extract($res_vaga);
         ?>
    <main class="mt-5">

        <h1 class="text-center"><strong>Editar Vaga</strong></h1>

        <div class="container-xxl mt-5 px-5">
            <!-- Formulário de Cadastro de Vaga -->
             <form class="row g-3 my-5" id="meuFormulario" method="POST" name="formulario"
                action="processa_editar_cadastro.php?id_vaga=<?= $id_vaga ?>" 
                enctype="multipart/form-data">
                <div class="text-center mb-5">
                <input type="hidden" name="id_vaga" value="<?= $id_vaga; ?>">
                <?php
            $banner = $res_vaga['img_vaga'];
                if (empty($res_vaga['img_vaga'])) {
                    echo '<img class="image-fluid" src="../img_vaga/banner.png" alt="" 
                    id="profile-image" 
                    height="250px"></a>';
                } else {
                    $banner_path = "../img_vaga/" . $banner;
                    if (file_exists($banner_path)) {
                        echo '<a href="./vagas/vaga-exemplo.php?id_vaga=' . $id_vaga . '">
                        <img class="image-fluid" src="' . $banner_path . '" alt="" 
                        id="profile-image"
                        height="250px"></a>';
                    } else {
                        echo 'A imagem não foi encontrada: ' . $banner_path;
                    }
                }

            ?>
                <input type="file" name="banner" id="icon-banner" style="display : none;">
                <label for="icon-banner" id="icon-banner-btn" style="cursor: pointer;">✏️</label>   
                </div>
                <div class="col-md-6 mt-4">
                    <label for="vaga" class="form-label">Vaga</label>
                    <input type="text" class="form-control" id="vaga" name="vaga"
                    value="<?= $vaga; ?>"required>
                </div>
        
                
                <div class="col-md-6 mt-4">
                    <label for="empresa" class="form-label">Empresa</label>
                    <input type="text" class="form-control" id="empresa" name="empresa"
                    value="<?= $emp_vaga; ?>">
                </div>
                <div class="col-12 mt-4">
                    <label for="descricao" class="form-label">Descrição</label>
                    <textarea class="form-control" id="descricao" rows="10" 
                    name="descricao" required><?php echo $desc_vaga; ?></textarea>               
                </div>

                <div class="col-md-6 mt-4">
                    <label for="tipo" class="form-label">Tipo</label>
                    <select id="tipo" name="tipo" class="form-select" required>
                        <option value="<?= $id_tipo; ?>" selected><?= $tipo ?></option>
                        <?php while($dados_tipo = mysqli_fetch_assoc($result_tipo)) { ?>
                        <option value="<?= $dados_tipo['id_tipo']; ?>" 
                        ><?= $dados_tipo['tipo']; ?>
                    </option>
                      <?php } ?>
                       
                    </select>
                </div>
                <div class="col-md-6 mt-4">
                    <label for="atuacao" class="form-label">Atuação</label>
                    <select id="atuacao" name="atuacao" class="form-select" required>
                        <option value="<?= $id_atuacao; ?>" selected><?= $atuacao ?></option>
                        <?php while($dados_atuacao = mysqli_fetch_assoc($result_atuacao)) { ?>
                        <option value="<?= $dados_atuacao['id_atuacao']; ?>" 
                        ><?= $dados_atuacao['atuacao']; ?>
                    </option>
                      <?php } ?>
                        
                    </select>
                </div>
                <div class="col-md-6 mt-4">
                    <label for="periodo" class="form-label">Período</label>
                    
            <select id="periodo" name="periodo" class="form-select" required>
                    <option value="<?= $per_vaga ?>"> <?= $per_vaga ?> </option>
        <?php if ($per_vaga !== "Matutino") { ?>
        <option value="Matutino">Matutino</option>
        <?php } ?>
        <?php if ($per_vaga !== "Vespertino") { ?>
        <option value="Vespertino">Vespertino</option>
        <?php } ?>
        <?php if ($per_vaga !== "Noturno") { ?>
        <option value="Noturno">Noturno</option>
        <?php } ?>
        </select>
                </div>
                <div class="col-md-6 mt-4">
                    <label for="salario" class="form-label">Salário</label>
                    <input type="number" class="form-control" id="salario"
                    step="any" name="salario" value="<?= $sal_vaga; ?>">
                </div>             
                <div class="col-12 mt-4">
                    <label for="hora" class="form-label">Carga Horária (Semanal)</label>
                    <input type="number" class="form-control" id="hora"
                    name="hora" value="<?= $hora_vaga; ?>">
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
                 <?php } 
                    ?>
                    <option value="">Selecione...</option>
                    <?php
                    foreach($result_area as $res_area) {
                        
                    ?>
                <option value="<?= $res_area['id_area'];?>"><?= $res_area['area']; 
                ?></option>
                <?php } ?>
                <?php 
                if (isset($areas[0]['id_area'])) { ?>
                <?php while($dados_area1 = mysqli_fetch_assoc($result_outrasAreas1)) {?>
                <option value="<?= $dados_area1['id_area']?>"><?= $dados_area1['area']; ?></option>
                <?php }} ?>
                </select>
                
                </div>
                <div class="col-md-6 mt-4">
                    <select id="area2" name="area2" class="form-select">
                    <?php if (isset($areas[1]['id_area'])) { ?>
               <option value="<?= $areas[1]['id_area']; ?>"> <?= $areas[1]['area']; ?> </option>
               <?php }  
                ?>
                <option value="">Selecione...</option>
                <?php
                    foreach($result_area as $res_area) {
                        
                    ?>
                <option value="<?= $res_area['id_area'];?>"><?= $res_area['area']; 
                ?></option>
                <?php } ?>
                <?php
                if (isset($areas[1]['id_area'])) { ?>
                <?php while($dados_area2 = mysqli_fetch_assoc($result_outrasAreas2)) {?>
                <option value="<?= $dados_area2['id_area']?>"><?= $dados_area2['area']; ?></option>
                <?php }} ?>
                </select>
                   
                </div>
                <div class="col-md-6 mt-4">
                    <select id="area3" name="area3" class="form-select">
                    <?php if (isset($areas[2]['id_area'])) { ?>
               <option value="<?= $areas[2]['id_area']; ?>"> <?= $areas[2]['area']; ?> </option>
               <?php } ?>
                <option value="">Selecione...</option>
                <?php
                    foreach($result_area as $res_area) {
                        
                    ?>
                <option value="<?= $res_area['id_area'];?>"><?= $res_area['area']; 
                ?></option>
                <?php } ?>
                <?php  
                if (isset($areas[2]['id_area'])) { ?>
                <?php while($dados_area3 = mysqli_fetch_assoc($result_outrasAreas3)) {?>
                <option value="<?= $dados_area3['id_area']?>"><?= $dados_area3['area']; ?></option>
                <?php }} ?>
                </select>
                   
                </div>
                
                
                
                
                <div class="col-md-6 mt-4">
                <select id="area4" name="area4" class="form-select">
                <?php if (isset($areas[3]['id_area'])) { ?>
               <option value="<?= $areas[3]['id_area']; ?>"> <?= $areas[3]['area']; ?> </option>
                 <?php }
                    ?>
                    <option value="">Selecione...</option>
                    <?php 
                    foreach($result_area as $res_area) {
                        
                    ?>
                <option value="<?= $res_area['id_area'];?>" ><?= $res_area['area']; 
                ?></option>
                <?php ?>
                <?php }
                if (isset($areas[3]['id_area'])) { ?>
                <?php while($dados_area4 = mysqli_fetch_assoc($result_outrasAreas4)) {?>
                <option value="<?= $dados_area4['id_area']?>"><?= $dados_area4['area']; ?></option>
                <?php }} ?>
                </select>
                
                </div>
                

                <input type="hidden" name="id_usuario" 
                value="<?= $_SESSION['id_usuario'] ?>">


                <div class="col-12 text-center">
                    <?php } ?>
                    <button type="submit" name="salvar" class="mt-5">Salvar</button>
                    <button type="button" class="mt-5" data-bs-toggle="modal" data-bs-target="#popup-modal">Excluir Vaga</button>
                </div>
                <div class="modal fade" id="popup-modal" tabindex="-1" aria-labelledby="modalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="modalLabel">Confirmação</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        
                        <div class="modal-body">
                            Deseja excluir a vaga?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Não!</button>
                            <button type="submit" class="btn btn-success" value="excluir_vaga"><a href="excluir-vaga.php?id_vaga=<?= $id_vaga?>"
                        >Sim!</a></button>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>

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
    <script>
$(document).ready(function() {
    $('#popup-modal2').modal('show');
});
</script>
    <script>
document.getElementById("icon-banner").addEventListener("change", function(event) {
    const imageElement = document.getElementById("profile-image");
    if (event.target.files.length > 0) {
        const selectedImage = event.target.files[0];
        const objectURL = URL.createObjectURL(selectedImage);
        imageElement.src = objectURL;
    }
});

function desativa_foto() {
    let foto = window.document.getElementById('icon-banner');
    foto.disabled = true;
    let lapis = window.document.getElementById('icon-banner-btn');
    lapis.textContent = "";
}
</script>
</body>

</html>
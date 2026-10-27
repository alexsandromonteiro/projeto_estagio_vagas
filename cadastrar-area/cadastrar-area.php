
<?php 
include("../funcoes/funcao_sessao.php");
verifica_sessao();

include("../PHP/conexao.php");

$consulta_area = "SELECT id_area, area FROM area ORDER BY area ASC";

$result_area = $conexao->query($consulta_area);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FATECBP | Cadastrar Área</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <style type="text/css">
      select {
        cursor:pointer;
      }
    </style>
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
                    <li><a class="dropdown-item" href="../cadastrar-vaga/cadastrar-vaga.php">
                        Cadastrar Vaga</a></li>
                    <li><a class="dropdown-item" href="../logout.php">Sair</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="mt-5">

        <h1 class="text-center"><strong>Cadastrar Área</strong></h1>

        <div class="container-xxl mt-5 px-5">

        <!-- Formulário de Cadastro de Área -->
            
            <form class="row g-3 my-5" method="POST" name="formulario" 
            enctype="multipart/form-data" action="processa_area.php">
                <div class="col-md-6 mt-4">
                    <label for="vaga" class="form-label">Área</label>
                    <input type="text" class="form-control" id="area" name="area">
                </div>
                <div class="col-md-6 mt-4">
                    <input type="hidden" class="form-control" id="id_usuario" 
                    name="id_usuario" value="<?= $_SESSION['id_usuario'] ?>"
                    required>
                </div>
                
                <div class="col-12 text-center">
                    <button type="submit" name="adicionar" class="mt-5">Adicionar</button>
                </div>
            </form>
        </div>

    </main>
    <div class="text-start container">
        <?php 
        while ($dados_area = mysqli_fetch_assoc($result_area)) {
            extract($dados_area);
        ?>
                <p class="mb-3"><span><?= $area ?></span>
                <button class="btn bg-danger rounded-circle">
                <div class="text-end">
                <a href="excluir_area.php?id_area=<?= $id_area?>">
                    <img src="../img/trash-fill.svg" alt="">
        </a>
                </div>                                    
                </button>

                <?php } ?>
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
<?php 
include("../funcoes/funcao_sessao.php");
verifica_sessao();

include("../PHP/conexao.php");

$consulta_usuario = "SELECT * FROM usuario WHERE id_usuario = '" . $_SESSION['id_usuario'] . "'";

$result_usuario = $conexao->query($consulta_usuario);


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FATECBP | Perfil</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"> </script>
</head>

<body class="z-0">

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
                <?php
                if (isset($_SESSION['img_usuario']) && !empty($_SESSION['img_usuario'])) {
                    // Se o usuário tiver uma imagem definida, exiba-a
                    echo '<img class="rounded-circle" src="../img_perfil/' . $_SESSION['img_usuario'] . '" alt="" height="48px">';
                } else {
                    // Caso contrário, exiba uma imagem padrão
                    echo '<img class="rounded-circle" src="../img_perfil/profile-icon.png" alt="" height="48px">';
                }
                ?>
            </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="">Perfil</a></li>
                    <li><a class="dropdown-item" href="../cadastrar-vaga/cadastrar-vaga.php">Cadastrar Vaga</a></li>
                    <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container text-center mt-5">
        <?php 
        while($dados_usuario = mysqli_fetch_assoc($result_usuario)) { 
            extract($dados_usuario);
        ?>
    <form action="salvar_perfil.php" 
    class="my-5" enctype="multipart/form-data"
    method="POST">
        <div>
            <img class="rounded-circle" id="profile-image" 
            src="../img_perfil/<?= $img_usuario;?>" 
            alt="" height="250px">

            <input type="file" name="imagem" id="icon-profile" style="display : none;">
            <label for="icon-profile" id="icon-profile-btn" style="cursor: pointer;">✏️</label>
        </div>

            <div class="mb-3 text-start">
                <br/>
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" 
                id="exampleInputEmail1" aria-describedby="emailHelp"
                value="<?= $email;?>">
            </div>
            <div class="mb-3 text-start">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" name="senha" class="form-control" 
                id="exampleInputPassword1"
                value="<?= $senha; ?>">
            </div>
            <?php } ?>
            
            <div class="modal fade" id="popup-modal" tabindex="-1" aria-labelledby="modalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="modalLabel">Confirmação</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        
                        <div class="modal-body">
                            Deseja salvar as alterações realizadas?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Não!</button>
                            <button type="submit" class="btn btn-success">Sim!</button>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="mt-5" data-bs-toggle="modal" data-bs-target="#popup-modal">Salvar</button>
        </form>
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
document.getElementById("icon-profile").addEventListener("change", function(event) {
    const imageElement = document.getElementById("profile-image");
    if (event.target.files.length > 0) {
        const selectedImage = event.target.files[0];
        const objectURL = URL.createObjectURL(selectedImage);
        imageElement.src = objectURL;
    }
});

function desativa_foto() {
    let foto = window.document.getElementById('icon-profile');
    foto.disabled = true;
    let lapis = window.document.getElementById('icon-profile-btn');
    lapis.textContent = "";
}
</script>
</body>
</html>
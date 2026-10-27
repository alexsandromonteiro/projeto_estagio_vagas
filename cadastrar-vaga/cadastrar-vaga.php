<?php 

include("../funcoes/funcao_sessao.php");
verifica_sessao();
include("../PHP/conexao.php");



$cons_atuacao = "SELECT id_atuacao, atuacao FROM atuacao";

$result_atuacao = $conexao->query($cons_atuacao);

$cons_tipo = "SELECT id_tipo, tipo FROM tipo";

$result_tipo = $conexao->query($cons_tipo);

$cons_area = "SELECT id_area, area FROM area";

$result_area = $conexao->query($cons_area);
$result_area2 = $conexao->query($cons_area);
$result_area3 = $conexao->query($cons_area);
$result_area4 = $conexao->query($cons_area);

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FATECBP | Cadastrar Vaga</title>
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
                    <li><a class="dropdown-item" href="">Cadastrar Vaga</a></li>
                    <li><a class="dropdown-item" href="../logout.php">Sair</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="mt-5">

        <h1 class="text-center"><strong>Cadastrar Vaga</strong></h1>

        <div class="container-xxl mt-5 px-5">

        <!-- Formulário de Cadastro de Vaga -->
            
            <form class="row g-3 my-5" id="meuFormulario" method="POST" name="formulario"
                action="processa_cadastro.php" enctype="multipart/form-data">
                <div class="col-md-6 mt-4">
                    <label for="vaga" class="form-label">Vaga</label>
                    <input type="text" class="form-control" id="vaga" name="vaga"
                    required>
                </div>
        
                
                <div class="col-md-6 mt-4">
                    <label for="empresa" class="form-label">Empresa</label>
                    <input type="text" class="form-control" id="empresa" name="empresa"
                    >
                </div>
                <div class="col-12 mt-4">
                    <label for="descricao" class="form-label">Descrição</label>
                    <textarea class="form-control" id="descricao" rows="10"
                    name="descricao" required></textarea>                
                </div>

                <div class="col-md-6 mt-4">
                    <label for="tipo" class="form-label">Tipo</label>
                    <select id="tipo" name="tipo" class="form-select" required>
                        <option value="selecione_tipo" selected>Selecione...</option>
                        
                        <?php 
                        while($dados_tipo = mysqli_fetch_assoc($result_tipo)) {
                            extract($dados_tipo);
                            
                        
                        ?>
                        <option value="<?= $id_tipo; ?>">
                    <?= $tipo; ?></option>

                    <?php
                        }
                    ?>
                       
                    </select>
                </div>
                <div class="col-md-6 mt-4">
                    <label for="atuacao" class="form-label">Atuação</label>
                    <select id="atuacao" name="atuacao" class="form-select" required>
                        <option value="selecione_atuacao">Selecione...</option>
                        <?php 
                        while($dados_atuacao = mysqli_fetch_assoc($result_atuacao)) {
                            extract($dados_atuacao);
                            
                        
                        ?>
                        <option value="<?= $id_atuacao; ?>">
                    <?= $atuacao;?></option>

                    <?php
                        }
                    ?>
                        
                    </select>
                </div>
                <div class="col-md-6 mt-4">
                    <label for="periodo" class="form-label">Período</label>
                    <select id="periodo" name="periodo" class="form-select" required>
                        <option value="Selecionar_periodo">Selecione...</option>
                        <option value="Matutino">Matutino</option>
                        <option value="Vespertino">Vespertino</option>
                        <option value="Noturno">Noturno</option>
                    </select>
                </div>
                <div class="col-md-6 mt-4">
                    <label for="salario" class="form-label">Salário</label>
                    <input type="number" class="form-control" id="salario"
                    step="any" name="salario">
                </div>             
                <div class="col-md-6 mt-4">
                    <label for="hora" class="form-label">Carga Horária (Semanal)</label>
                    <input type="number" class="form-control" id="hora"
                    name="hora">
                </div>
                <div class="col-md-6 mt-4">
                    <label for="banner" class="form-label">Banner</label>
                    <input class="form-control" type="file" id="banner" name="banner">
                </div>

                <div class="mt-4" style="margin-bottom: -25px">
                <label for="area" class="form-label">Área</label>                  
                    <a href="../cadastrar-area/cadastrar-area.php"><span type="button" data-bs-toggle="modal" data-bs-target="#popup-modal-area"><img src="../img/plus-circle.svg" alt=""></span></a>
                </div>
                    
                <!-- area -->
                <div class="col-md-6 mt-4">
                    <select id="area1" name="area1" class="form-select" required>
                        <option value="selecione_area">Selecione...</option>
                        <?php 
                        while($dados_area = mysqli_fetch_assoc($result_area)) {
                            extract($dados_area);
                            
                        ?>
                        <option value="<?= $id_area; ?>">
                    <?= $area;?></option>

                    <?php
                        }
                    ?>
                        
                    </select>
                   
                </div>
                
                <div class="col-md-6 mt-4">
                    <select id="area2" name="area2" class="form-select">
                        <option value="selecione_area">Selecione...</option>
                        <?php 
                        while($dados_area = mysqli_fetch_assoc($result_area2)) {
                            extract($dados_area);
                            
                        
                        ?>
                        <option value="<?= $id_area; ?>">
                    <?= $area;?></option>

                    <?php
                        }
                    ?>
                        
                    </select>
                </div>

                <div class="col-md-6 mt-4">
                    <select id="area3" name="area3" class="form-select">
                        <option value="selecione_area">Selecione...</option>
                        <?php 
                        while($dados_area = mysqli_fetch_assoc($result_area3)) {
                            extract($dados_area);
                            
                        
                        ?>
                        <option value="<?= $id_area; ?>">
                    <?= $area;?></option>

                    <?php
                        }
                    ?>
                        
                    </select>
                </div>
                
                <div class="col-md-6 mt-4">
                    <select id="area4" name="area4" class="form-select">
                        <option value="selecione_area">Selecione...</option>
                        <?php 
                        while($dados_area = mysqli_fetch_assoc($result_area4)) {
                            extract($dados_area);
                            
                        
                        ?>
                        <option value="<?= $id_area; ?>">
                    <?= $area;?></option>

                    <?php
                        }
                    ?>
                        
                    </select>
                </div>


                <input type="hidden" name="id_usuario" 
                value="<?= $_SESSION['id_usuario'] ?>">
                <div class="col-12 text-center">
                    <button type="submit" name="salvar" class="mt-5">Salvar</button>
                </div>
            </form>
            <script>
    document.addEventListener("DOMContentLoaded", function () {
        var formulario = document.getElementById("meuFormulario");
        var inputs = formulario.querySelectorAll("input, select, textarea");
        var dataExpiracao = 20 * 1000; // 20 segundos

        // Função para salvar dados em tempo real
        function saveFormData() {
            var formData = {};
            inputs.forEach(function (input) {
                formData[input.name] = input.value;
            });

            // Armazene os dados e a hora atual no localStorage
            var currentTime = new Date().getTime();
            localStorage.setItem("formData", JSON.stringify({ data: formData, timestamp: currentTime }));
        }

        // Adicione ouvintes de eventos "input" para todos os campos do formulário
        inputs.forEach(function (input) {
            input.addEventListener("input", saveFormData);
        });

        // Função para preencher campos com dados armazenados
        function fillFormFields() {
            var savedData = localStorage.getItem("formData");
            if (savedData) {
                var parsedData = JSON.parse(savedData);
                var formData = parsedData.data;
                var timestamp = parsedData.timestamp;
                var currentTime = new Date().getTime();

                if (currentTime - timestamp < dataExpiracao) {
                    inputs.forEach(function (input) {
                        if (formData[input.name]) {
                            input.value = formData[input.name];
                        }
                    });
                } else {
                    // Se os dados expiraram, remova-os do localStorage
                    localStorage.removeItem("formData");
                }
            }
        }

        // Chame a função para preencher campos com dados armazenados ao carregar a página
        fillFormFields();
    });
</script>
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
</body>

</html>
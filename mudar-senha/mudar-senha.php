<?php 
include("../PHP/conexao.php");
include("./process-mudar-senha.php");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FATECBP | Mudar Senha</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../css/mostrar-pin.css">
    <style>
        h4 {
            text-align: center;
        }
    </style>
    
</head>

<body>
    <form method="POST" name="formulario">
    <div class="position-absolute top-50 start-50 translate-middle w-50">
        <div class="form-floating mb-3">
            <input type="email" name="email" class="form-control" id="email" required>
            <label for="email">Email</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" name="pin" class="form-control" id="pin" required>
            <i class="fa-solid fa-eye-slash" id="mostrar-pin"></i>
            <label for="pin">Pin</label>

           
        </div>
        <?php
            /* Estou chamando a função verifica_dados($conexao) do process-mudar-senha.php
            para caso der algum erro no email ou pin ser exibido aqui. Ao contrário
            se os registros (email e pin) existirem no banco,
            já irá direto para a página de confirmação da nova senha */
            echo "<br/>";
            echo verifica_dados($conexao); 
             
             ?>
        <div class="mt-5 text-center">
       <button type="submit" name="mudar">Alterar Senha</button>
        </div>
    </div>
</form>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/mostrar-pin.js"></script>
</body>

</html>
<?php
session_start();

include("../PHP/conexao.php");
include("./process_confirmar_senha.php");


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
    <style>
        h4 {
            text-align: center;
        }

        .fa-eye {
            position: absolute;
            top: 37%;
            right: 2.5%;
            cursor: pointer;
        }

        .fa-eye-slash {
            position: absolute;
            top: 37%;
            right: 2.5%;
            cursor: pointer;
        }
    </style>

</head>

<body>
    <form method="POST" name="formulario">
        <div class="position-absolute top-50 start-50 translate-middle w-50">
            <div class="form-floating mb-3">

                <input type="password" id="senha" name="senha" class="form-control" required>
                <i class="fa-solid fa-eye-slash" id="mostrar-senha"></i>
                <label for="senha">Senha</label>

            </div>
            <div class="form-floating">
                <input type="password" id="confirmar-senha" name="confirmar-senha" 
                class="form-control" required>
                <i class="fa fa-eye-slash" id="confirmar.mostrar"></i>
                <label for="senha">Confirmar Senha</label>
            </div>
            <?php

            confirmar_senha($conexao);
            ?>
            <div class="mt-5 text-center">
                <button type="submit" name="confirmar" id="submit">Alterar</button>
            </div>

        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/mostrar-senha.js"></script>
    <script src="../js/mostrar-confirmar-senha.js"></script>
</body>

</html>
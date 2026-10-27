<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FATECBP | Login</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../css/mostrar-senha.css">
    <style>
        h4 {
            text-align: center;
        }
    </style>
    
</head>

<body>
    <form action="./process_login.php" method="POST" name="formulario"
    id="formulario">
    <div class="position-absolute top-50 start-50 translate-middle w-50">
        <div class="form-floating mb-3">
            <input type="email" name="email" class="form-control" id="email">
            <label for="email">Email</label>
        </div>
        <div class="form-floating">
            <input type="password" name="senha" class="form-control" id="senha">
            <i class="fa-solid fa-eye-slash" id="mostrar-senha"></i>
            <label for="senha">Senha</label>
            <div class="mt-1">
                <a href="../mudar-senha/mudar-senha.php" style="color: black;">Esqueci a Senha</a>
            </div>          
        </div>
        <div class="mt-5 text-center">
            <button type="submit" name="submit" id="submit">Entrar</button>
        </div>
        <?php
        if (isset($_GET['erro'])) 
                { 
                if ($_GET['erro'] == "dadosinvalidos") { 
                echo "<br/><h4 style='color:#ff0000;font-weight:bold;'>
                Usuário e/ou senha inválidos.</h4>"; 
            }
        }
        ?>
    </div>
</form>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/mostrar-senha.js"></script>
</body>

</html>
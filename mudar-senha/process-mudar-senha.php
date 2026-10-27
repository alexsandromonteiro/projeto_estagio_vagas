<?php
// Verificação já está funcionando
function verifica_dados($conexao) {
if(isset($_POST['mudar'])) {
     // Recupere os valores do formulário
     $email = $_POST['email'];
     $pin = md5($_POST['pin']);
 
     // Consulta SQL para verificar o email e o PIN
     $sql = "SELECT * FROM usuario WHERE email = '$email' AND pin = '$pin'";
     $result = $conexao->query($sql);
 
     if ($result->num_rows > 0) {
        
        // Defina o tempo de expiração para esta sessão (em segundos)
        $session_lifetime = 600;
        session_set_cookie_params($session_lifetime);

        // Inicie a sessão antes de usar ou definir variáveis de sessão
        session_start();

        // Armazene o email na sessão
        $_SESSION['email'] = $email;

         header("Location:../confirmar-nova-senha/confirmar-nova-senha.php");
        exit();
     } else {
         // Email ou PIN inválidos
         echo "<h4 style='color:red;'>Email e/ou PIN incorretos.</h4>";
     }
}
}

?>
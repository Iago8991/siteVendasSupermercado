<?php
    session_start();
?>

<html>
    <head>
        <link rel="stylesheet" href="../css/admin.css">
    </head>
    <body>
        <?php 
            if(isset($_SESSION['erro'])) {
                echo "<div class = 'mensagem'> {$_SESSION['erro']} </div>";
                unset($_SESSION['erro']);
            } elseif (isset($_SESSION['sucesso'])) {
                echo "<div class = 'mensagemSucesso'> {$_SESSION['sucesso']} </div>";
                unset($_SESSION['sucesso']);
            }
        ?>
        <form action="adminCodigo.php" method="POST">
            <label for="email"> E-mail do administrador: </label>
            <input type="text" name="email" id="email" required>
            <br/> <br/> 
            <label for="senha"> Senha do administrador: </label>
            <input type="text" name="senha" id="senha" required>
            <br/> <br/> 
            <input type="submit" value="Enviar">
        </form>
    </body>
</html>
<?php
    session_start();
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Registro - Mercadinho IRR</title>
        <link rel="stylesheet" href="../css/registro.css">
    </head>
    <body>
        <div class="tituloSite">Mercadinho IRR</div>
        <div class="containerCentral">
            <?php
            if(isset($_SESSION['errorRegistro'])) {
                echo "<div class='mensagem'>" . $_SESSION['errorRegistro'] . "</div>";
                unset($_SESSION['errorRegistro']);
            } elseif(isset($_SESSION['sucessoRegistro'])) {
                echo "<div class='mensagemSucesso'>" . $_SESSION['sucessoRegistro'] . "</div>";
                unset($_SESSION['sucessoRegistro']);
            }
            ?>
            <form action="registroCodigo.php" method="POST">
                <label for="nome">Nome:</label>
                <input type="text" name="nome" id="nome" required>
                <label for="email">E-mail:</label>
                <input type="email" name="email" id="email" required>
                <label for="senha">Senha:</label>
                <input type="password" name="senha" id="senha" required>
                <input type="submit" value="Registrar">
            </form>
            <button class="btn-voltar" onclick="location.href='../index.php'">Voltar</button>
        </div>
    </body>
</html>

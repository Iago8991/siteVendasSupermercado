<?php
    header('Content-Type: text/html; charset=utf-8');
    session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Login - Mercadinho IRR</title>
        <link rel="stylesheet" href="../css/login.css">
    </head>
    <body>
        <div class="site-title">Mercadinho IRR</div>

        <div class="containerCentral">
            <?php
            if(isset($_SESSION['errorLogin'])) {
                echo "<div class='mensagem'>" . $_SESSION['errorLogin'] . "</div>";
                unset($_SESSION['errorLogin']);
            }
            ?>
            <form action="loginCodigo.php" method="POST">
                <label for="email">E-mail:</label>
                <input type="text" name="email" id="email" required>
                <label for="senha">Senha:</label>
                <input type="password" name="senha" id="senha" required>
                <input type="submit" value="Entrar">
            </form>
            <button class="btn-voltar" onclick="location.href='../index.php'">Voltar</button>
        </div>
    </body>
</html>

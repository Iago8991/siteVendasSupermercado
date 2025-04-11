<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Admin - Mercadinho IRR</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="site-title">Mercadinho IRR</div>
    <div class="container-central" id="container-central">
        <?php
        if(isset($_SESSION['errorAdmin'])) {
            echo "<div class='mensagem'>" . $_SESSION['errorAdmin'] . "</div>";
            unset($_SESSION['errorAdmin']);
        }
        ?>
        <form action="adminCodigo.php" method="POST">
            <label for="email">E-mail do Administrador:</label>
            <input type="text" name="email" id="email" required>
            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" required>
            <input type="submit" value="Entrar">
        </form>
        <button class="btn-voltar" onclick="location.href='../index.php'">Voltar</button>
    </div>
</body>
</html>

<html>
    <link rel="stylesheet" href="../css/login.css">
</html>

<div id="login">
    <?php
        if(isset($_SESSION['erro'])) {
            echo "<div class = 'mensagem'> {$_SESSION['erro']} </div>";
            unset($_SESSION['erro']);
        } elseif (isset($_SESSION['sucesso'])) {
            echo "<div class = 'mensagemSucesso'> {$_SESSION['sucesso']} </div>";
            unset($_SESSION['sucesso']);
        }
    ?>
    <form action="loginCodigo.php" method="POST"> 
        <center>
            <label for="email">E-mail:</label>
            <input type="text" min="0" max="200" name="email" id="email" required> 
        </center> 

        <center>
            <label for="senha">Senha:</label>
            <input type="text" min="0" max="200" name="senha" id="senha" required> 
        </center>
        <input type="submit" value="Enter">
    </form>
</div>


<html>
    <link rel="stylesheet" href="../css/registro.css">
</html>

<div id="registro">
    <?php
        if(isset($_SESSION['error'])) {
            echo "<div class = 'mensagem'> {$_SESSION['error']}</div>";
            unset($_SESSION['error']);
        } elseif (isset($_SESSION['sucesso'])) {
            echo "<div class = 'mensagemSucesso'> {$_SESSION['sucesso']} </div>";
            unset($_SESSION['sucesso']);
        }
            
    ?>
    <form action="registroCodigo.php" method="POST"> 

        <center>
            <label for="nome">NOME:</label>
            <input type="text" min="0" max="200" name="nome" id="nome"> 
        </center>
        
        <center>
            <label for="email">E-mail:</label>
            <input type="text" min="0" max="200" name="email" id="email"> 
        </center>

        <center>
            <label for="senha">Senha:</label>
            <input type="text" min="0" max="200" name="senha" id="senha"> 
        </center>
        <input type="submit" value="Enter">
    </form>
</div>
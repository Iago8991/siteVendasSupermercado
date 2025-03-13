<?PHP 
    require('../css/admin.css');
?>
<html> 
    <body>
        <?PHP 
           if (isset($_SESSION['erro'])){
            echo "<p style='color: red;'>" . $_SESSION['erro'] . "</p>";
            unset($_SESSION['erro']);
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
<?PHP 
    session_start();
    if(isset($_SESSION['admin']) && $_SESSION['admin'] == 'logado') {
?>
<html> 
    <head> 
        <title> Inserir Produtos</title>
        <meta sharte = "UTF-8">
        <meta name = "viewport" content = "width=device-width, initial-scale=1.0">
    </head>
    <body> 

        <?php
            if (isset($_SESSION['erro'])){
                echo "<p style='color: red;'>" . $_SESSION['erro'] . "</p>";
                unset($_SESSION['erro']);
            }

            if (isset($_SESSION['sucesso'])){
                echo "<p style='color: green;'>" . $_SESSION['sucesso'] . "</p>";
                unset($_SESSION['sucesso']);
            }
        ?>
        <form action="inserir_produtos_codigo.php" method="POST" enctype="multipart/form-data">

            <label for="nome"> Nome: </label>
            <input type="text" name="nome" id="nome" required> <br/> <br/>

            <label for="descricao"> Descrição: </label>
            <input type="text" max="1250" name="descricao" id="descricao" required>

            <label for="preco"> Preço: </label>
            <input type="number" name="preco" id="preco" step="0.01" required> <br/> <br/>
                
            <label for="image"> Imagem: </label>
            <input type="file" name="imagem" id="imagem" accept="image/*" required> <br/> <br/>

            <label for="estoque"> Estoque: </label>
            <input type="number" name="estoque" id="estoque" required> <br/> <br/>
        
            <input type="submit" value="Enviar">
        </form>
    </body>
</html>

<?PHP
    } else {
        echo "Você não tem permissão de administrador";
    }
?>
 
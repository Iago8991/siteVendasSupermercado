<?php
    session_start();
    require("bd_config.php");

    // Busca 8 produtos com desconto
    $sql = "SELECT * FROM produtos WHERE produtos_desconto > 0 ORDER BY RAND() LIMIT 8";
    $resultado = mysqli_query($con, $sql);
    if (!$resultado) {
        die(" Erro ao buscar produtos: " . mysqli_error($con));
    }
?>

<html>
    <head>
        <title>Supermercado</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/index.css">
    </head>
    <body>

        <!-- rodapé fixo -->
         <a href="loginRegistro/admin.php" class="linkAdmin">Admin</a>
         
         <a href="contato.php" class="linkContato">Contate-nos</a>

         <!-- termina aqui -->

         <!-- Div central -->

         <div class="containerEntrada">
            <div class="caixaLogin" onclick="location.href='loginRegistro/login.php'">
                <h2>Login</h2>
                <p>Entre na sua conta</p>
            </div>
            <div class="caixaRegistro" onclick="location.href='loginRegistro/registro.php'">
                <h2>Registro</h2>
                <p>Crie uma nova conta</p>
            </div>

            <div class="textoAViso"> <h4>Necessario efetuar login para acessar mais informações</h4> </div>
        </div>
        
        <h1 class="tituloDescontos">Produtos em Destaque</h1> 

        <!-- Produtos em destaque -->
         <div class="gradeDescontos">
            <?php while($produto = mysqli_fetch_assoc($resultado)) { ?>
                <div class="produtoItem">
                    <img src=""
                </div>
            }
         </div>
    </body>
</html>
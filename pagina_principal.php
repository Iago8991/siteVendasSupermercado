<?PHP 
    session_start();
    require("bd_config.php");

    $sql = "SELECT * FROM produtos ORDER BY RAND() LIMIT 8";
    $resultado = mysqli_query($con, $sql);
?>

<html>
    <head>
        <meta charset="UTF-8"
        <title> Pagina principal</title>

        <style>
            .produto {
                border: 1px solid #ccc;
                padding: 10px;
                width: 250px;
                margin: 10px;
                float: left;
                transition: transform 0.3s;
                position: relative;
            }
            .produto:hover {
                transform: scale(1.05);
            }
            .produto img {
                width: 100%;
            }
            .info-extra {
                display: none;
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                background: rgba(0,0,0,0.7);
                color: #fff;
                padding: 5px;
                text-align: center;
            }
            .produto:hover .info-extra {
                display: block;
            }
            .menu-lateral {
                position: fixed;
                top: 50%;
                left: 0;
                transform: translatey(-50%);
            }
            .menu-item {
                background: #ccc;
                padding: 10px;
                margin: 5px;
                width: 50px;
                transition: width 0.3s;
                overflow: hidden;
                white-space: nowrap;
                cursor: pointer;
            }
            .menu-item:hover {
                width: 150px;
            }
        </style>
    </head>
    <body>
        <div id="superior"> Mercadinho IRR </div>
        <div id="links"> 
        <a href="pagina_principal.php"> Home </a> <br/>
        <a href="/admin/inserir_produtos.php"> Inserir produtos </a> <br/>
        <a href="carinho.php"> Carrinho </a> <br/> 
       
        </div>

        <div id="produtos_aleatorios"> 



        </div>
    </body>

</html>
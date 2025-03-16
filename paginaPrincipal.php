<?PHP 
    session_start();
    require("bd_config.php");
    require('./css/paginaPrincipal.css');

    $sql = "SELECT * FROM produtos ORDER BY RAND() LIMIT 8";
    $resultado = mysqli_query($con, $sql);
?>

<html>
    <head>
        <meta charset="UTF-8"
        <title> Pagina principal </title>

    </head>
    <body>
        <h1> Bem-vindo à Loja </h1>        
        
        <!-- Menu lateral -->

        <div class="menu-lateral">
            <div class="menu-item" onlcick="location.href='carrinho.php';">
                <img src="icones/carrinho.png" alt="Carrinho" width="30">
                <span> Carrinho </span>
            </div>

            <div class="menu-item" onclick="location.href='produtos_completos.php';">
                <img src="icones/loja.png" alt="Loja" width="30">
                <span> Loja </span>
            </div>

            <div class="menu-item" onclick="location.href='pagina_principal.php';">
                <img src="icones/pagina_principal.png" alt="pagina principal" width="30">
                <span> Pagina Principal </span>
            </div>

            <div class="menu-item" onclick="location.href='\admin\inserir_produtos.php';">
                <img src="icones/loja.png" alt="inserir produtos" width="30">
                <span> Inserir Produtos </span>
            </div>

        <!-- Mais Links se necessário-->
        </div>
        
            <!-- Exibição de produtos aleatóriamente -->

            <div class="produtos">
                <?php while ($produto = mysqli_fetch_array($resultado)) { ?>
                    <div class="produto">
                        <img src="<?= htmlspecialchars($produto['produtos_imagem']) ?>" alt="<?= htmlspecialchars($produto['produtos_nome']) ?>"
                        <h2> <?= htmlspecialchars($produto['produtos_nome']) ?> </h2>
                        <p> R$ <?= number_format($produto['produtos_preco'], 2, ',', '.') ?> </p>
                        <?php 
                        
                        //Exibe o desconto se ouver
                        if (isset($produto['produtos_desconto']) && $produto['produtos_desconto'] > 0) { ?>
                            <p style="color: red;"> Desconto: <?= $produto['produtos_desconto'] ?> % </p>
                        <?php } ?>
                        <div class="info-extra">
                            <p> <?= htmlspecialchars($produto['produtos_descricao']) ?> </p>
                            <button onclick="adicionaraocarrinho(<?= $produto['produtos_id'] ?>)"> Comprar </button>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <script> 
                function adicionaraocarrinho(produtos_id) {
                    // Manda o Produto selecionado para o carrinho
                    alert(" Produto " + produtos_id + " adicionar ao carrinho (exemplo)!");
                }
            </script>
    </body>
</html>


<?PHP 
    session_start();
    if (isset($_SESSION['login']) && $_SESSION['login'] == 'logado'){
    require("bd_config.php");
    $sql = "SELECT * FROM produtos ORDER BY RAND() LIMIT 8";
    $resultado = mysqli_query($con, $sql);

   
?>

<html>
    <head>
        <link rel="stylesheet" href="/css/paginaPrincipal.css">
        <meta charset="UTF-8"
        <title> Pagina principal </title>
    </head>
    <body>
        <h1> Bem-vindo à Loja </h1>        
        
        <!-- Menu lateral -->

        <div class="menu-lateral">
            <div class="menu-item" onlcick="location.href='carrinho.php';">
                <img src="imagens/carrinho.jpg" alt="Carrinho" width="30">
                <span> Carrinho </span>
            </div>

            <div class="menu-item" onclick="location.href='exibirProdutos.php';">
                <img src="imagens/loja.webp" alt="Loja" width="30">
                <span> Loja </span>
            </div>

            <div class="menu-item" onclick="location.href='paginaPrincipal.php';">
                <img src="imagens/home.webp" alt="pagina principal" width="30">
                <span> Pagina Principal </span>
            </div>

            <div class="menu-item" onclick="location.href='/admin/inserirProdutos.php';"> <!-- Falta resolver -->
                <img src="imagens/inserir.jpg" alt="inserir produtos" width="30">
                <span> Inserir Produtos </span>
            </div>

        <!-- Mais Links se necessário-->
        </div>
        
            <!-- Exibição de produtos aleatóriamente -->

            <div class="produtos">
                <?php while ($produto = mysqli_fetch_array($resultado)) { ?>
                    <div class="produto">
                        <h2> <?= htmlspecialchars($produto['produtos_nome']) ?> </h2>
                        <img src="upload_produtos/<?= htmlspecialchars($produto['produtos_imagem']) ?>" alt="<?= htmlspecialchars($produto['produtos_nome']) ?>" width="100px" height="100px">
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

<?PHP
    } else {
        echo "Você não tem permissão de administrador";
    }
?>
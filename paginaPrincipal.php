<?php 
    header('Content-Type: text/html; charset=utf-8');
    session_start();
    if (isset($_SESSION['login']) && $_SESSION['login'] == 'logado'){
        require("menuLateral.php");
        require("bd_config.php");
        $sqlEmDestaque = "SELECT * FROM produtos WHERE produtos_desconto > 0 ORDER BY RAND()";
        $resultadoEmDestaque = mysqli_query($con, $sqlEmDestaque);
        $sqlProdutos = "SELECT * FROM produtos WHERE produtos_desconto = 0 ORDER BY RAND()";
        $resultadoProdutos = mysqli_query($con, $sqlProdutos);
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Página Principal</title>
        <link rel="stylesheet" href="./css/paginaPrincipal.css">
    </head>
    <body>
        <h1 class="tituloSite">Bem-vindo à Loja</h1>

        <?php menuLateral::render(); ?>
    
        <div class="secaoEmDestaque">
            <h2 class="tituloSecao">Em Destaque</h2>
            <div class="sliderContainer">
                <div class="sliderProdutos">
                    <?php while ($produto = mysqli_fetch_array($resultadoEmDestaque)) { ?>
                        <div class="produtoCard">
                            <h3 class="produtoNome"> <?= htmlspecialchars($produto['produtos_nome']) ?> </h3>
                            <img class="produtoImagem" src="./uploadProdutos/<?= htmlspecialchars($produto['produtos_imagem']) ?>" alt="<?= htmlspecialchars($produto['produtos_nome']) ?>">
                            <p class="produtoPreco">R$ <?= number_format($produto['produtos_preco'], 2, ',', '.') ?> </p>
                            <?php if (isset($produto['produtos_desconto']) && $produto['produtos_desconto'] > 0) { ?>
                                <p class="produtoDesconto" style="color: red;"> Desconto: <?= $produto['produtos_desconto'] ?> % </p>
                            <?php } ?>
                            <div class="produtoInfoExtra">
                                <p> <?= htmlspecialchars($produto['produtos_descricao']) ?> </p>
                                <button onclick="adicionarAoCarrinho(<?= $produto['produtos_id'] ?>)"> Comprar </button>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="navegacaoSlider">
                    <span class="setaAnterior"> &#8249; </span>
                    <span class="setaProxima"> &#8250; </span>
                </div> 
            </div>
        </div>
        <div class="secaoProdutos">
            <h2 class="tituloSecao"> Produtos </h2>
            <div class="sliderContainer">        
                <div class="sliderProdutos">
                    <?php while ($produto = mysqli_fetch_array($resultadoProdutos)) { ?>
                        <div class="produtoCard">
                            <h3 class="produtoNome"> <?= htmlspecialchars($produto['produtos_nome']) ?> </h3>
                            <img class="produtoImagem" src="./uploadProdutos/<?= htmlspecialchars($produto['produtos_imagem']) ?>" alt="<?= htmlspecialchars($produto['produtos_nome']) ?>">
                            <p class="produtoPreco"> R$ <?= number_format($produto['produtos_preco'], 2, ',', '.') ?> </p>
                            <div class="produtoInfoExtra">
                                <p> <?= htmlspecialchars($produto['produtos_descricao']) ?> </p>
                                <button onclick="adicionarAoCarrinho(<?= $produto['produtos_id'] ?>)"> Comprar </button>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="navegacaoSlider">
                    <span class="setaAnterior"> &#8249; </span>
                    <span class="setaProxima"> &#8250; </span>
                </div>
            </div>
        </div>                 

        <script>
            function adicionarAoCarrinho(produtos_id) {
                    alert("Produto " + produtos_id + " adicionado ao carrinho (exemplo)!");
                }
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.sliderContainer').forEach(container => {
                    const slider = container.querySelector('.sliderProdutos');
                    const setaPrev = container.querySelector('.setaAnterior');
                    const setaNext = container.querySelector('.setaProxima');

                    if (slider.scrollWidth > slider.clientWidth) {
                    slider.classList.add('scrollable');
                    container.querySelector('.navegacaoSlider').classList.add('scrollable');

                    setaPrev.addEventListener('click', () => {
                        slider.scrollBy({ left: -slider.clientWidth * 0.8, behavior: 'smooth' });
                    });
                    setaNext.addEventListener('click', () => {
                        slider.scrollBy({ left: slider.clientWidth * 0.8, behavior: 'smooth' });
                    });
                    }
                });
                });  
        </script>
    </body>
</html>
<?php
    } else {
        echo "Realize login para acessar a página!";
        echo "<button class='btn-voltar' onclick=\"location.href='index.php'\">Voltar</button>";
    }
?>

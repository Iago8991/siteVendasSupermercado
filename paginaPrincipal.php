<?php 
header('Content-Type: text/html; charset=utf-8');
session_start();
require_once __DIR__ . '/urlConfig.php';
require_once __DIR__ . '/menuLateral.php';

if (isset($_SESSION['login']) && $_SESSION['login'] == 'logado') {
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
    <link rel="stylesheet" href="<?= BASE_URL ?>css/paginaPrincipal.css">
</head>
<body>
    <h1 class="tituloSite">Bem-vindo à Loja</h1>
    <?php menuLateral::render(); ?>

    <div id="mainContent">
        <div class="containerCentral">
            <div class="secaoEmDestaque">
                <h2 class="tituloSecao">Em Destaque</h2>
                <div class="sliderContainer">
                    <div class="sliderProdutos">
                        <?php while ($produto = mysqli_fetch_array($resultadoEmDestaque)) { ?>
                            <div class="produtoCard">
                                <div class="cardMain">
                                    <h3 class="produtoNome"><?= htmlspecialchars($produto['produtos_nome']) ?></h3>
                                    <img class="produtoImagem" src="./uploadProdutos/<?= htmlspecialchars($produto['produtos_imagem']) ?>"
                                        alt="<?= htmlspecialchars($produto['produtos_nome']) ?>">
                                    <div class="produtoPrecoDesconto">
                                        <p class="produtoPreco">R$ <?= number_format($produto['produtos_preco'], 2, ',', '.') ?></p>
                                        <p class="produtoDesconto">Desconto: <?= $produto['produtos_desconto'] ?> %</p>
                                    </div>
                                </div>
                                <div class="detalhesHover">
                                    <p><?= htmlspecialchars($produto['produtos_descricao']) ?></p>
                                    <button id="comprar" onclick="adicionarAoCarrinho(<?= $produto['produtos_id'] ?>)">
                                        Comprar
                                    </button>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="navegacaoSlider">
                        <span class="setaAnterior">&#8249;</span>
                        <span class="setaProxima">&#8250;</span>
                    </div>
                </div>
            </div>

            <div class="secaoProdutos">
                <h2 class="tituloSecao">Produtos</h2>
                <div class="sliderContainer">
                    <div class="sliderProdutos">
                        <?php while ($produto = mysqli_fetch_array($resultadoProdutos)) { ?>
                            <div class="produtoCard">
                                <div class="cardMain">
                                    <h3 class="produtoNome"><?= htmlspecialchars($produto['produtos_nome']) ?></h3>
                                    <img class="produtoImagem" src="./uploadProdutos/<?= htmlspecialchars($produto['produtos_imagem']) ?>"
                                        alt="<?= htmlspecialchars($produto['produtos_nome']) ?>">
                                    <div class="produtoPrecoDesconto">
                                        <p class="produtoPreco">R$ <?= number_format($produto['produtos_preco'], 2, ',', '.') ?></p>
                                    </div>
                                </div>
                                <div class="detalhesHover">
                                    <p><?= htmlspecialchars($produto['produtos_descricao']) ?></p>
                                    <button id="comprar" onclick="adicionarAoCarrinho(<?= $produto['produtos_id'] ?>)">
                                        Comprar
                                    </button>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="navegacaoSlider">
                        <span class="setaAnterior">&#8249;</span>
                        <span class="setaProxima">&#8250;</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
} else {
    echo "Realize login para acessar a página!";
    echo "<button class='btn-voltar' onclick=\"location.href='index.php'\">Voltar</button>";
}
?>

<?php
    header('Content-Type: text/html; charset=utf-8');
    session_start();
    if (isset($_SESSION['login']) && $_SESSION['login'] == 'logado'){
    require("bd_config.php");
    require("menuLateral.php");

    $busca = "";
    $categoria = "";
    $whereClause = "";
    $conditions = [];

    if (isset($_GET['busca']) && !empty(trim($_GET['busca']))) {
        $busca = trim(mysqli_real_escape_string($con, $_GET['busca']));

        $palavras = array_filter(explode(" ", $busca), function($p) {
            return trim($p) !== "";
        });
        
        $searchConditions = [];
        foreach ($palavras as $palavra) {
            $palavra = trim($palavra);
            $searchConditions[] = "(produtos_nome LIKE '%$palavra%' OR produtos_descricao LIKE '%$palavra%')";
        }
        if (count($searchConditions) > 0) {
            $conditions[] = "(" . implode(" OR ", $searchConditions) . ")";
        }
    }

    if (isset($_GET['categoria']) && !empty(trim($_GET['categoria']))) {
        $categoria = trim(mysqli_real_escape_string($con, $_GET['categoria']));
        $conditions[] = "categoria = '$categoria'";
    }

    if (count($conditions) > 0) {
        $whereClause = " WHERE " . implode(" AND ", $conditions);
    } else {
        $whereClause = "";
    }

    $sql = "SELECT * FROM produtos $whereClause ORDER BY produtos_nome";
    $resultado = mysqli_query($con, $sql);

    if (!$resultado) {
        die("Erro na consulta: " . mysqli_error($con));
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <link rel="stylesheet" href="./css/exibirProdutos.css">
        <meta charset="UTF-8">
        <title>Exibir Produtos</title>
    </head>
    <body>
        <?php menuLateral::render(); ?>

        <div class="exibirProdutosContainer">
            <h1>Produtos</h1>

            <div class="filtroDePesquisa">
                <form action="exibirProdutos.php" method="GET" id="searchForm">
                    <div class="search-input">
                        <input type="text" id="busca" name="busca" placeholder="Pesquisar por nome ou descrição" value="<?=htmlspecialchars($busca)?>">
                        <span class="search-icon">&#128269;</span>
                        <span class="clear-btn" onclick="clearSearch()">&#10006;</span>
                    </div>
                    <div class="search-input">
                        <select name="categoria" id="categoria">
                            <option value="">Todas as Categorias</option>
                            <option value="cestaBasica" <?= ($categoria == "cestaBasica") ? 'selected' : '' ?>>Cesta Basica</option>
                            <option value="carne" <?= ($categoria == "carne") ? 'selected' : '' ?>>Carne</option>
                            <option value="bebidas" <?= ($categoria == "bebidas") ? 'selected' : '' ?>>Bebidas</option>
                            <option value="padaria" <?= ($categoria == "padaria") ? 'selected' : '' ?>>Padaria</option>
                            <option value="hortifruti" <?= ($categoria == "hortifruti") ? 'selected' : '' ?>>Hortifrúti (Legumes, Frutas, Relacionados)</option>
                            <option value="alimentosCongelados" <?= ($categoria == "alimentosCongelados") ? 'selected' : '' ?>>Alimentos Congelados</option>
                            <option value="produtosDeLimpeza" <?= ($categoria == "produtosDeLimpeza") ? 'selected' : '' ?>>Produtos De Limpeza</option>
                            <option value="higienePessoal" <?= ($categoria == "higienePessoal") ? 'selected' : '' ?>>Higiene Pessoal</option>
                            <option value="outrosProdutos" <?= ($categoria == "outrosProdutos") ? 'selected' : '' ?>>Outros</option>
                        </select>

                        <span class="clear-cat" onclick="clearCategory()">&#10006;</span>
                        <span class="search-icon">&#128269;</span>
                    </div>
                    <button type="submit">Filtrar</button>
                </form>
            </div>

            <div class="produtosGrade">
                <?php 
                $numRows = mysqli_num_rows($resultado);
                if ($numRows > 0){
                    while ($produto = mysqli_fetch_assoc($resultado)) { ?>
                        <div class="produtoItem">
                            <img src="uploadProdutos/<?= htmlspecialchars($produto['produtos_imagem']) ?>" alt="<?= htmlspecialchars($produto['produtos_nome']) ?>">
                            <h3><?= htmlspecialchars($produto['produtos_nome']) ?></h3>
                            <p><?= htmlspecialchars($produto['produtos_descricao']) ?></p>
                            <p class="price">R$ <?= number_format($produto['produtos_preco'], 2, ',', '.') ?></p>
                            <?php if (isset($produto['produtos_desconto']) && $produto['produtos_desconto'] > 0) { ?>
                                <p class="disconto">Desconto: <?= $produto['produtos_desconto'] ?>%</p>
                            <?php } ?>
                            
                            <div class="quantidadeContaier" data-stock="<?= intval($produto['produtos_estoque']) ?>">
                                <img src="imagens/minus.png" alt="Diminuir" class="btnQuantidade" onclick="alterarQuantidade(this, -1)">
                                <span class="quantidadeValor">1</span>
                                <img src="imagens/plus.png" alt="Aumentar" class="btnQuantidade" onclick="alterarQuantidade(this, 1)">
                                <img src="imagens/carrinho.png" alt="Carrinho" class="iconeCarrinho" onclick="location.href='carrinho.php?adicionar=<?= $produto['produtos_id'] ?>&qtd='+this.previousElementSimbling.textContent">
                            </div>
                        </div>
                    <?php } 
                    } else {
                        echo "<p class='no-results'>Produto não encontrado.</p>";
                    }
                    ?>  
                </div>
            </div>
        <?php mysqli_close($con); ?>
        <script>
            function clearSearch(){
                document.getElementById('busca').value = '';
            }
            function clearCategory(){
                document.getElementById('categoria').selectedIndex = 0;
            }

            function alterarQuantidade(btn, delta) {
                const container = btn.parentElement;
                const valorEl = container.querySelector('.quantidadeValor');
                let qtd = parseInt(valorEl.textContent, 10);
                const estoque = parseInt(container.dataset.stock, 10);

                qtd = Math.max(1, Math.min(estoque, qtd + delta));
                valorEl.textContent = qtd;
            }
        </script>
    </body>
</html>

<?php
    } else {
        echo "Realize login para acessar a página!";
        echo "<button class='btn-voltar' onclick=\"location.href='index.php'\">Voltar</button>";
    }
?>

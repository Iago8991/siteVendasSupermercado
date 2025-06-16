<?php
    header('Content-Type: text/html; charset=utf-8');
    session_start();
    error_reporting(0);
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
    <meta charset="UTF-8">
    <title>Exibir Produtos</title>
    <link rel="stylesheet" href="./css/exibirProdutos.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
    <?php menuLateral::render(); ?>

    <div class="DivSuperior">
        <div class="filtroDePesquisa">
            <div class="barraPesquisa">
                <form action="exibirProdutos.php" method="GET" id="searchForm">
                    <input 
                    type="text" 
                    id="busca" name="busca" 
                    placeholder="Pesquisar por nome ou descrição" 
                    value="<?=htmlspecialchars($busca)?>"
                    >
                    <button type="submit" class="btn-search">
                    <span class="material-icons">search</span>
                    </button>
                </form>
            </div>

            <form action="exibirProdutos.php" method="GET" id="categoriaForm" style="display:none;">
                <input type="hidden" name="busca" value="<?= htmlspecialchars($busca) ?>">
                <input type="hidden" name="categoria" id="categoriaInput" value="<?= htmlspecialchars($categoria) ?>">
            </form>
            
            <div class="categoriaDropdown">
                <button type="button" class="btn-categoria" onclick="toggleDropdown()">
                    <span id="categoriaSelecionada"><?= $categoriaLabel ?? 'Todas as Categorias' ?></span>
                    <span class="seta"></span> 
                </button>
                <ul class="dropdownOpcoes" id="dropdownOpcoes">
                    <li onclick="selecionarCategoria('', 'Todas as Categorias')">Todas as Categorias</li>
                    <li onclick="selecionarCategoria('cestaBasica', 'Cesta Básica')">Cesta Básica</li>
                    <li onclick="selecionarCategoria('carne', 'Carne')">Carne</li>
                    <li onclick="selecionarCategoria('bebidas', 'Bebidas')">Bebidas</li>
                    <li onclick="selecionarCategoria('padaria', 'Padaria')">Padaria</li>
                    <li onclick="selecionarCategoria('hortifruti', 'Hortifrúti')">Hortifrúti</li>
                    <li onclick="selecionarCategoria('alimentosCongelados', 'Alimentos Congelados')">Alimentos Congelados</li>
                    <li onclick="selecionarCategoria('produtosDeLimpeza', 'Produtos De Limpeza')">Produtos De Limpeza</li>
                    <li onclick="selecionarCategoria('higienePessoal', 'Higiene Pessoal')">Higiene Pessoal</li>
                    <li onclick="selecionarCategoria('outrosProdutos', 'Outros')">Outros</li>
                </ul>
                <input type="hidden" name="categoria" id="categoriaInput" value="<?= htmlspecialchars($categoria) ?>"> 
            </div>
        </div>
    </div>

    <div class="exibirProdutosContainer">
        <h1>Produtos</h1>

        <div class="produtosGrade">
            <?php 
            $numRows = mysqli_num_rows($resultado);
            if ($numRows > 0) {
                while ($produto = mysqli_fetch_assoc($resultado)) { ?>
                    <div class="produtoItem">
                        <img src="uploadProdutos/<?= htmlspecialchars($produto['produtos_imagem']) ?>"
                             alt="<?= htmlspecialchars($produto['produtos_nome']) ?>">
                        <h3><?= htmlspecialchars($produto['produtos_nome']) ?></h3>

                        <div class="detalhesHover">
                            <p class="descricao"><?= htmlspecialchars($produto['produtos_descricao']) ?></p>

                            <div class="precos">
                                <span class="precoAntigo">
                                    <?php if ($produto['produtos_desconto']>0): ?>
                                        <del>R$ <?= number_format($produto['produtos_preco'],2,',','.') ?></del>
                                    <?php endif; ?>
                                </span>
                                <span class="precoAtual">
                                    R$ <?= number_format(
                                        $produto['produtos_preco'] * (1 - $produto['produtos_desconto']/100),
                                        2,',','.'
                                    ) ?>
                                </span>
                                <?php if ($produto['produtos_desconto']>0): ?>
                                    <span class="labelDesconto"><?= $produto['produtos_desconto'] ?> %</span>
                                <?php endif; ?>
                            </div>

                            <div class="quantidadeContainer" data-stock="<?= intval($produto['produtos_estoque']) ?>">
                                <img src="imagens/minus.png" alt="–" class="btnQuantidade"
                                     onclick="alterarQuantidade(this,-1)">
                                <span class="quantidadeValor">1</span>
                                <img src="imagens/plus.png" alt="+" class="btnQuantidade"
                                     onclick="alterarQuantidade(this,1)">
                                <img src="imagens/carrinho.png" alt="Carrinho" class="iconeCarrinho"
                                     onclick="location.href='carrinho.php?adicionar=<?= $produto['produtos_id'] ?>&qtd='+this.previousElementSibling.textContent">
                            </div>
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
        function clearSearch() {
            document.getElementById('busca').value = '';
        }

        function toggleDropdown() {
            document.getElementById('dropdownOpcoes').classList.toggle('show');
        }
        function selecionarCategoria(valor, texto) {
            document.getElementById('categoriaInput').value = valor;
            document.getElementById('categoriaSelecionada').textContent = texto;
            toggleDropdown();
            document.getElementById('categoriaForm').submit();
        }

        document.addEventListener('click', function(e) {
            const dropdown = document.querySelector('.categoriaDropdown');
            if (!dropdown.contains(e.target)) {
            document.getElementById('dropdownOpcoes').classList.remove('show');
            }
        });

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

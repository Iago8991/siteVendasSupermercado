<?php
session_start();
require("bd_config.php");
//error_reporting(0);

$busca = "";
$categoria = "";
$whereClause = "";
$conditions = [];

// Se houver um termo de busca, utiliza para filtrar produtos
if (isset($_GET['busca']) && !empty(trim($_GET['busca']))) {
    // Remove espaços no início e no fim
    $busca = trim(mysqli_real_escape_string($con, $_GET['busca']));
    
    // Divide a pesquisa em palavras individuais e remove palavras vazias
    $palavras = array_filter(explode(" ", $busca), function($p) {
        return trim($p) !== "";
    });
    
    $searchConditions = [];
    foreach ($palavras as $palavra) {
        $palavra = trim($palavra);
        $searchConditions[] = "(produtos_nome LIKE '%$palavra%' OR produtos_descricao LIKE '%$palavra%')";
    }
    if (count($searchConditions) > 0) {
        // Junta as condições de busca com OR
        $conditions[] = "(" . implode(" OR ", $searchConditions) . ")";
    }
}

// Se houver filtro por categoria, adiciona essa condição
if (isset($_GET['categoria']) && !empty(trim($_GET['categoria']))) {
    $categoria = trim(mysqli_real_escape_string($con, $_GET['categoria']));
    $conditions[] = "categoria = '$categoria'";
}

// Se houver alguma condição, junta-as com AND; caso contrário, retorna todos os produtos
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

<html>
<head>
    <link rel="stylesheet" href="css/exibirProdutos.css">
    <meta charset="UTF-8">
    <title>Exibir Produtos</title>

    <style> 
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .exibirProdutosContainer {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .filtroDePesquisa {
            background: #fff;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-align: center;
        }
        .filtroDePesquisa .search-input {
            position: relative;
            display: inline-block;
            margin-right: 10px;
        }
        .filtroDePesquisa input[type="text"],
        .filtroDePesquisa select {
            padding: 8px 30px 8px 30px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        .filtroDePesquisa .search-icon {
            position: absolute;
            left: 8px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 16px;
            color: #aaa;
            pointer-events: none;
        }
        .filtroDePesquisa .clear-btn, .filtroDePesquisa .clear-cat {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 16px;
            color: #aaa;
            cursor: pointer;
        }
        .produtosGrade {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .produtoItem {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            width: 23%;
            box-sizing: border-box;
            text-align: center;
        }
        .produtoItem img {
            width: 100%;
            height: 100px;
            object-fit: cover;
            margin-bottom: 10px;
        }
        .produtoItem h3 {
            font-size: 1.1em;
            margin: 10px 0;
        }
        .produtoItem p {
            font-size: 0.95em;
            margin: 5px 0;
        }
        .produtoItem .price {
            font-weight: bold;
            margin-top: 10px;
        }
        .produtoItem .disconto {
            color: red;
        }
        .no-results {
            text-align: center;
            color: red;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="exibirProdutosContainer">
        <h1>Produtos</h1>

        <!-- Formulário de busca e filtro -->
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
                        <option value="alimentos" <?= ($categoria == "alimentos") ? 'selected' : '' ?>>Alimentos</option>
                        <option value="carne" <?= ($categoria == "carne") ? 'selected' : '' ?>>Carne</option>
                        <option value="bebidas" <?= ($categoria == "bebidas") ? 'selected' : '' ?>>Bebidas</option>
                        <option value="padaria" <?= ($categoria == "padaria") ? 'selected' : '' ?>>Padaria</option>
                        <option value="vegetal" <?= ($categoria == "vegetal") ? 'selected' : '' ?>>Vegetal</option>
                        <option value="fruta" <?= ($categoria == "fruta") ? 'selected' : '' ?>>Fruta</option>
                        <option value="hortifruti" <?= ($categoria == "hortifruti") ? 'selected' : '' ?>>Hortifrúti (Legumes, Frutas, Relacionados)</option>
                        <option value="alimentosCongelados" <?= ($categoria == "alimentosCongelados") ? 'selected' : '' ?>>Alimentos Congelados</option>
                        <option value="frios" <?= ($categoria == "frios") ? 'selected' : '' ?>>Frios</option>
                        <option value="produtosDeLimpeza" <?= ($categoria == "produtosDeLimpeza") ? 'selected' : '' ?>>Produtos De Limpeza</option>
                        <option value="higienePessoal" <?= ($categoria == "higienePessoal") ? 'selected' : '' ?>>Higiene Pessoal</option>
                        <option value="outros" <?= ($categoria == "outros") ? 'selected' : '' ?>>Outros</option>
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
                        <img src="upload_produtos/<?= htmlspecialchars($produto['produtos_imagem']) ?>" alt="<?= htmlspecialchars($produto['produtos_nome']) ?>" width="100px" height="100px">
                        <h3><?= htmlspecialchars($produto['produtos_nome']) ?></h3>
                        <p><?= htmlspecialchars($produto['produtos_descricao']) ?></p>
                        <p class="price">R$ <?= number_format($produto['produtos_preco'], 2, ',', '.') ?></p>
                        <?php if (isset($produto['produtos_desconto']) && $produto['produtos_desconto'] > 0) { ?>
                            <p class="disconto">Desconto: <?= $produto['produtos_desconto'] ?>%</p>
                        <?php } ?>
                        <a href="carrinho.php?adicionar=<?= $produto['produtos_id'] ?>">Comprar</a>
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
    </script>
</body>
</html>
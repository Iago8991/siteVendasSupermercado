<?PHP
    session_start();
    require("bd_config.php");
    //require('./css/exibirProdutos.css');
    //include_once("./css/exibirProdutos.css");
    //error_reporting(0);

    $busca = "";
    $categoria = "";
    $whereClause = "";

    // Se houver um termo de busca, utiliza para encontrar/filtrar produtos
    if (isset($_GET['busca']) && !empty($_GET['busca'])) {
        $busca = mysqli_real_escape_string($con, $_GET['busca']);

        //opcão 1: Divide a palavra da pesquisa em partes individuais para encontrar o resultado mais proximo

        $palavras = explode(" ", $busca);
        $condicoes = [];
        foreach ($palavras as $palavra) {
            $condicoes[] = "(produtos_nome LIKE '%$palavra%' OR produtos_descricao LIKE '%$palavra%')";
        }
        $whereClause = "WHERE " . implode(" OR ", $condicoes);


        //Opcão 2: usando SOUNDEX para encontrar palavaras semelhantes
        $whereClause .= " OR SOUNDEX(produtos_nome) = SOUNDEX('$busca')";
    } 

    // Se houver filtro por categoria, adiciona à condição
    if (isset($_GET['categoria']) && !empty($_GET['categoria'])) {
        $categoria = mysqli_real_escape_string($con, $_GET['categoria']);
        if ($whereClause == "") {
            $whereClause = "WHERE categoria = '$categoria'";
        } else {
            $whereClause .= " AND categoria = '$categoria'";
        }
    }
    
    // Consulta SQL para buscar os produtos 
    $sql = "SELECT * FROM produtos $whereClause ORDER BY produtos_nome";
    $resultado = mysqli_query($con, $sql);
?>

<html> 
    <head>
        <meta charset="UTF-8">
        <title> Exibir Produtos </title>    
    </head>

    <body>
        <div class="exibirProdutosContainer">
            <h1> Produtos </h1>

            <!-- Formulário de busca e filtro -->
             <div class="filtroDePesquisa">
                <form action="exibirProdutos.php" method="GET">
                    <input type="text" name="busca" placeholder="Pesquisar por nome ou descrição" value=" <?= htmlspecialchars($busca) ?>">
                    <select name="categoria">
                        <option value="alimentos" <?= ($categoria == "alimentos") ? 'selected' : '' ?>> Alimentos </option>                
                        <option value="carne" <?= ($categoria == "carne") ? 'selected' : '' ?>> Carne </option>
                        <option value="bebidas" <?= ($categoria == "bebidas") ? 'selected' : '' ?>> Bebidas </option>
                        <option value="padaria" <?= ($categoria == "padaria") ? 'selected' : '' ?>> Padaria </option>
                        <option value="vegetal" <?= ($categoria == "vegetal") ? 'selected' : '' ?>> Vegetal </option>
                        <option value="fruta" <?= ($categoria == "fruta") ? 'selected' : '' ?>> Fruta </option>
                        <option value="hortifruti" <?= ($categoria == "hortifruti") ? 'selected' : '' ?>> Hortifrúti (Legumes, Frutas, Relacionados) </option>
                        <option value="alimentosCongelados" <?= ($categoria == "alimentosCongelados") ? 'selected' : '' ?>> Alimentos Congelados </option>
                        <option value="frios" <?= ($categoria == "frios") ? 'selected' : '' ?>> Frios </option>
                        <option value="produtosDeLimpeza" <?= ($categoria == "produtosDeLimpeza") ? 'selected' : '' ?>> Produtos De Limpeza </option>
                        <option value="higienePessoal" <?= ($categoria == "higienePessoal") ? 'selected' : '' ?>> Higiene Pessoal </option>
                        <option value="outros" <?= ($categoria == "outros") ? 'selected' : '' ?>> Outros </option>
                    </select>
                    <button type="submut"> Filtrar </button>
                </form>
             </div>

            <div class="produtosGrade">
                <?php while ($produto = mysqli_fetch_assoc($resultado)) { ?>
                    <div class="produtoItem">
                        <img src="<?= htmlspecialchars($produto['produtos_imagem']) ?>" alt="<?= htmlspecialchars($produto['produtos_nome']) ?>">    
                        <h3> <?= htmlspecialchars($produto['produtos_nome']) ?> </h3>
                        <p> <?= htmlspecialchars($produto['produtos_descricao']) ?> </p>
                        <p class="price">R$ <?= number_format($produto['produtos_preco'], 2, ',', '.') ?> </p>
                        <?php if (isset($produto['produtos_desconto']) && $produto['produtos_desconto'] > 0) { ?>
                            <p class="disconto">Desconto: <?= $produto['produtos_desconto'] ?>%</p>
                        <?php } ?>

                        <a href="carrinho.php?adicionar=<?= $produto['produtos_id'] ?>">Comprar</a>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php mysqli_close($con); ?>
    </body>
</html>
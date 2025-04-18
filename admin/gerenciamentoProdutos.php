<?PHP 
    session_start();
    require('../bd_config.php');
    require('../menuLateral.php');

    if (isset($_SESSION['admin']) && $_SESSION['admin'] == 'logado'){
        
        // Consulta os produtos do banco de dados
        $sql = "SELECT * FROM produtos";
        $resultado = mysqli_query($con, $sql);
        
        if (!$resultado) {
            echo "Falha ao buscar produtos: " . mysqli_error($con);
        }
    ?>
    
    <html>
        <head>
            <link rel="stylesheet" href="/projetoSupermercado/css/gerenciamentoDeProdutos.css">
            <title> Gerenciador de Produtos </title>
            <meta charset="UTF-8">
        </head>
        <body>
            
                <!-- Menu lateral fixo -->
                <?php menuLateral::render(); ?>
                <!-- Colocar aqui -->
                 
                <h1 class="tituloGerenciador"> Gerenciador de Produtos</h1>

                <div class="containerGerenciador" id="mainContent">
                    <div class="produtosContainer">
                        <?php while ($produto = mysqli_fetch_assoc($resultado)) { ?>
                            <div class="produtoCard">
                                <img src="<?= htmlspecialchars($produto['produtos_imagem']) ?>" alt="<?= htmlspecialchars($produto['produtos_nome']) ?>">
                                <div class="produtoInfo">
                                    <h3> <?= htmlspecialchars($produto['produtos_nome']) ?> </h3>
                                    <p> <?= htmlspecialchars($produto['produtos_descricao']) ?> </p>
                                    <p> Preço: R$ <?= number_format($produto['produtos_preco'], 2, ',', '.') ?> </p>
                                    <p class="categoria"> Categoria: <?= htmlspecialchars($produto['categoria']) ?> </p>
                                    <p class="estoque"> Estoque: <?= htmlspecialchars($produto['produtos_estoque']) ?> </p>
                                    <?php if (isset($produto['produtos_desconto']) && $produto['produtos_desconto'] > 0) { ?>
                                        <p style="color: red;"> Desconto: <?=$produto['produtos_desconto'] ?>%</p>
                                    <?php } ?>
                                </div>
                                <div class="acoesProduto">
                                    <a href="editarProdutos.php?id=<?= $produto['produtos_id'] ?>"> Editar </a> <br/>
                                    <a href="excluirProduto.php?id=<?= $produto['produtos_id'] ?>" onclick="return confirm('Tem certeza que deseja excluir este produto?')"> Excluir </a> 
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <!-- Rodapé -->
                <div class="rodape">
                    <p>&copy; 2025 Mercadinho IRR. Todos os direitos reservados.</p>
                </div>
            </div>
        </body>
    </html>
    
 <?php   
    }else {
        echo "Você não possui permissões de administrador. ";
        exit;
    }

?>
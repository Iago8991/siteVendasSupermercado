<?PHP 
    session_start();
    require('../bd_config.php');

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
            <link rel="stylesheet" href="../css/gerenciamentoProdutos.css">
            <title> Gerenciador de Produtos </title>
            <meta charset="UTF-8">
        </head>
        <body>

            <h1>Lista de produtos</h1>

            <table border="1">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Preço</th>
                        <th>Desconto</th>
                        <th>Estoque</th>
                        <th>Imagem</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <body>
                    <?php while ($produto = mysqli_fetch_assoc($resultado)) { ?>
                        
                        <tr>
                            <td> <?= htmlspecialchars($produto['produtos_nome']) ?></td>
                            <td> <?= htmlspecialchars($produto['produtos_descricao']) ?></td>
                            <td>R$ <?= number_format($produto['produtos_preco'], 2, ',', '.') ?></td>
                            <td> 
                                <?php
                                    if (isset($produto['produtos_desconto']) && $produto['produtos_desconto'] > 0) {
                                        echo '<span style="color: red;">' . $produto['produtos_desconto'] . '%</span>'; 
                                    } else {
                                        echo "Sem desconto";
                                    }
                                ?>

                            </td>
                            <td> <?= $produto['produtos_estoque'] ?></td>
                            <td>
                                <img src="<?= htmlspecialchars($produto['produtos_imagem']) ?>" alt="Imagem do produto" width="100">
                            </td>
                            <td> 
                                <a href="editarProduto.php?id=<?= $produto['produtos_id'] ?>">Editar</a> <br/>
                                <a href="excluirProduto.php?id=<?= $produto['produtos_id'] ?>" onclick="return confirm('Tem certeza que deseja excluir este produto?')">Excluir</a>
                            </td>
                        </tr>
                    
                    <?php } ?>
                </body>
            </table>
        </body>
    </html>
    
 <?php   
    }else {
        echo "Você não possui permissões de administrador. ";
        exit;
    }

?>
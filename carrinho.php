<?php
    header('Content-Type: text/html; charset=utf-8');
    session_start();
    require_once __DIR__ . '/urlConfig.php';
    require_once __DIR__ . '/menuLateral.php';

    if (isset($_SESSION['login']) && $_SESSION['login'] == 'logado') {
        require("bd_config.php");

        $usuario_id = $_SESSION['user_id'];

        // SQL atualizado para pegar também o estoque do produto
        $sql = "SELECT ci.carrinho_id, ci.quantidade, p.produtos_id, p.produtos_nome, 
                       p.produtos_preco, p.produtos_desconto, p.produtos_imagem, p.produtos_estoque 
                FROM carrinho_itens ci 
                JOIN produtos p ON ci.produto_id = p.produtos_id 
                WHERE ci.usuario_id = ?";

        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "i", $usuario_id);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Carrinho de Compras</title>
        <link rel="stylesheet" href="<?= BASE_URL ?>css/carrinho.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script src="<?= BASE_URL ?>js/carrinho.js" defer></script>
    </head>
    <body>

        <?php menuLateral::render(); ?>

        <div id="mainContent">
            <div class="containerCentral">
                <h1 class="tituloCarrinho">Carrinho de Compras</h1>

                <div id="carrinhoDeCompras">
                    <div id="produtosCard">
                        <?php 
                        if (mysqli_num_rows($resultado) > 0) {
                            while ($item = mysqli_fetch_assoc($resultado)) { 
                                $precoOriginal = $item['produtos_preco'];
                                $desconto = $item['produtos_desconto'];
                                $precoFinal = $precoOriginal * (1 - ($desconto / 100));
                        ?>
                                <div class="itemNoCarrinho" data-preco="<?= $precoFinal ?>" id="item-<?= $item['produtos_id'] ?>">
                                    
                                    <div class="sessaoControle">
                                        <div class="ajusteQuantidade">
                                            <button class="btn-qtd" onclick="alterarQtd(<?= $item['produtos_id'] ?>, -1)">-</button>
                                            <span class="qtdValor" id="qtd-<?= $item['produtos_id'] ?>"><?= $item['quantidade'] ?></span>
                                            <button class="btn-qtd" onclick="alterarQtd(<?= $item['produtos_id'] ?>, 1)">+</button>
                                        </div>
                                        
                                        <a href="carrinhoCodigo.php?remover=<?= $item['carrinho_id'] ?>" 
                                           class="btn-remover" 
                                           onclick="return confirm('Remover item?')">
                                            <span class="material-icons">delete</span>
                                        </a>
                                    </div>

                                    <div class="sessaoInfo">
                                        <h3 class="nomeProduto"><?= htmlspecialchars($item['produtos_nome']) ?></h3>
                                        
                                        <div class="precosContainer">
                                            <p class="valorOriginal">R$ <?= number_format($precoOriginal, 2, ',', '.') ?></p>
                                            <?php if ($desconto > 0): ?>
                                                <p class="valorDesconto">R$ <?= number_format($precoFinal, 2, ',', '.') ?></p>
                                            <?php endif; ?>
                                        </div>

                                        <div class="avisoEstoque" id="aviso-<?= $item['produtos_id'] ?>" style="display:none; color: red; font-size: 12px; margin-top: 5px;">
                                            </div>
                                    </div>

                                    <div class="sessaoImagem">
                                        <img src="uploadProdutos/<?= htmlspecialchars($item['produtos_imagem']) ?>" alt="Produto">
                                    </div>
                                </div>
                        <?php 
                            } 
                        } else {
                            echo "<p class='avisoVazio'>Seu carrinho ainda está vazio!</p>";
                        }
                        ?>
                    </div>

                    <div class="sessaoFinalizar">
                        <div class="totalContainer">
                            <h2 id="textoTotal">Total: R$ <span id="valorTotal">0,00</span></h2>
                        </div>
                        <button id="comprar" onclick="finalizarCompra()">Finalizar Compra</button>
                    </div>
                </div>
            </div>
        </div>

        <?php mysqli_close($con); ?>
    </body>
</html>
<?php
    } else {
        echo "Realize login!";
    }
?>
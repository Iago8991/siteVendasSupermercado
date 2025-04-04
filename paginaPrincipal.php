<?php 
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] == 'logado'){
    require("bd_config.php");
    $sql = "SELECT * FROM produtos ORDER BY RAND() LIMIT 8";
    $resultado = mysqli_query($con, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Página Principal</title>
    <link rel="stylesheet" href="css/paginaPrincipal.css">
</head>
<body>
    <h1>Bem-vindo à Loja</h1>

    <!-- Menu lateral fixo -->

    <!-- Colocar aqui -->
    
    <!-- Conteúdo principal que será empurrado -->
    <div class="main-content" id="mainContent">
        <!-- Exibição de produtos aleatoriamente -->
        <div class="produtos">
            <?php while ($produto = mysqli_fetch_array($resultado)) { ?>
                <div class="produto">
                    <h2><?= htmlspecialchars($produto['produtos_nome']) ?></h2>
                    <img src="upload_produtos/<?= htmlspecialchars($produto['produtos_imagem']) ?>" alt="<?= htmlspecialchars($produto['produtos_nome']) ?>">
                    <p>R$ <?= number_format($produto['produtos_preco'], 2, ',', '.') ?></p>
                    <?php if (isset($produto['produtos_desconto']) && $produto['produtos_desconto'] > 0) { ?>
                        <p style="color: red;">Desconto: <?= $produto['produtos_desconto'] ?>%</p>
                    <?php } ?>
                    <div class="info-extra">
                        <p><?= htmlspecialchars($produto['produtos_descricao']) ?></p>
                        <button onclick="adicionaraocarrinho(<?= $produto['produtos_id'] ?>)">Comprar</button>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    
    <script>
        // empurra o conteudo para o lado quand o menu lateral e expandido
        const menu = document.getElementById('menuLateral');
        const mainContent = document.getElementById('mainContent');

        menu.addEventListener('mouseenter', () => {
            mainContent.style.marginLeft = '180px';
        });
        menu.addEventListener('mouseleave', () => {
            mainContent.style.marginLeft = '50px';
        });

        function adicionaraocarrinho(produtos_id) {
            alert("Produto " + produtos_id + " adicionado ao carrinho (exemplo)!");
        }
    </script>
</body>
</html>
<?php
    } else {
        echo "Você não tem permissão de administrador";
    }
?>

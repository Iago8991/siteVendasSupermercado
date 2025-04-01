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
    <style>
        
    </style>
</head>
<body>
    <h1>Bem-vindo à Loja</h1>
    
    <!-- Menu lateral fixo -->
    <div class="menu-lateral" id="menuLateral">
    <a class="menu-item" onclick="location.href='paginaPrincipal.php';">
            <img src="imagens/home.webp" alt="Página Principal">
            <span>Página Principal</span>
        </a>
        <a class="menu-item" onclick="location.href='carrinho.php';">
            <img src="imagens/carrinho.jpg" alt="Carrinho">
            <span>Carrinho</span>
        </a>
        <a class="menu-item" onclick="location.href='exibirProdutos.php';">
            <img src="imagens/loja.webp" alt="Loja">
            <span>Loja</span>
        </a>

        <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == 'logado'){ ?>
        <a class="menu-item" onclick="location.href='admin/inserirProdutos.php';">
            <img src="imagens/inserir.jpg" alt="Inserir Produtos">
            <span>Inserir Produtos</span>
        </a>
        <a class="menu-item" onclick="location.href='admin/gerenciamentoProdutos.php';">
            <img src="imagens/gerenciamento.jpg" alt="Gerenciamento Produtos">
            <span>Gerenciamneto Produtos</span>
        </a>
        <?php } else { echo ""; } ?>

        <a class="menu-item" onclick="location.href='loginRegistro/logout.php';">
            <img src="imagens/Sair.jpg" alt="Sair">
            <span>Sair</span>
        </a>
    </div>
    
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

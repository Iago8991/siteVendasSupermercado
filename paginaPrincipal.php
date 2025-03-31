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
    <link rel="stylesheet" href="/css/paginaPrincipal.css">
    <style>
        /* Menu lateral fixo */
        .menu-lateral {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 50px; /* Largura mínima */
            background: #333;
            overflow: hidden;
            transition: width 0.3s;
            z-index: 1000;
        }
        .menu-lateral:hover {
            width: 150px;
        }
        .menu-lateral .menu-item {
            display: flex;
            align-items: center;
            padding: 10px;
            color: #fff;
            text-decoration: none;
            border-bottom: 1px solid #444;
            transition: background 0.3s;
        }
        .menu-lateral .menu-item:last-child {
            border-bottom: none;
        }
        .menu-lateral .menu-item:hover {
            background: #555;
        }
        .menu-lateral .menu-item img {
            width: 30px;
            height: auto;
            margin-right: 10px;
        }
        .menu-lateral .menu-item span {
            white-space: nowrap;
            opacity: 0;
            transition: opacity 0.3s;
        }
        .menu-lateral:hover .menu-item span {
            opacity: 1;
        }

        /* Conteúdo principal */
        .main-content {
            margin-left: 50px; /* Mesmo valor que a largura mínima do menu */
            transition: margin-left 0.3s;
            padding: 20px;
        }

        /* Grade de produtos (mesmo estilo que usamos em exibirProdutos) */
        .produtos {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            margin-top: 20px;
        }
        .produto {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            width: 250px;
            box-sizing: border-box;
            text-align: center;
            transition: transform 0.3s;
        }
        .produto:hover {
            transform: scale(1.05);
        }
        .produto img {
            width: 100%;
            height: auto;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h1>Bem-vindo à Loja</h1>
    
    <!-- Menu lateral fixo -->
    <div class="menu-lateral" id="menuLateral">
        <a class="menu-item" onclick="location.href='carrinho.php';">
            <img src="imagens/carrinho.jpg" alt="Carrinho">
            <span>Carrinho</span>
        </a>
        <a class="menu-item" onclick="location.href='exibirProdutos.php';">
            <img src="imagens/loja.webp" alt="Loja">
            <span>Loja</span>
        </a>
        <a class="menu-item" onclick="location.href='paginaPrincipal.php';">
            <img src="imagens/home.webp" alt="Página Principal">
            <span>Página Principal</span>
        </a>
        <a class="menu-item" onclick="location.href='/admin/inserirProdutos.php';">
            <img src="imagens/inserir.jpg" alt="Inserir Produtos">
            <span>Inserir Produtos</span>
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
            mainContent.style.marginLeft = '150px';
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

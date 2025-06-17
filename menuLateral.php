<?php
header('Content-Type: text/html; charset=utf-8');
session_start();

class MenuLateral {
    public static function render() {
?>
    <div class="menuLateral" id="menuLateral">
        <div class="menuItems">
            <a class="menuItem" onclick="location.href='./paginaPrincipal.php';">
                <img src="./imagens/home.webp" alt="Página Principal">
                <span>Página Principal</span>
            </a>
            <a class="menuItem" onclick="location.href='./carrinho.php';">
                <img src="./imagens/carrinho.png" alt="Carrinho">
                <span>Carrinho</span>
            </a>
            <a class="menuItem" onclick="location.href='./exibirProdutos.php';">
                <img src="./imagens/loja.png" alt="Loja">
                <span>Loja</span>
            </a>
            <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == 'logado'){ ?>
                <a class="menuItem" onclick="location.href='./admin/inserirProdutos.php';">
                    <img src="./imagens/inserirProdutos.png" alt="Inserir Produtos">
                    <span>Inserir Produtos</span>
                </a>
                <a class="menuItem" onclick="location.href='./admin/gerenciamentoProdutos.php';">
                    <img src="./imagens/gerenciarProdutos.png" alt="Gerenciamento Produtos">
                    <span>Gerenciamento Produtos</span>
                </a>
            <?php } ?>
        </div>
        <div class="menuFooter">
            <a class="menuItem" onclick="location.href='./loginRegistro/logout.php';">
                <img src="./imagens/sair.png" alt="Sair">
                <span>Sair</span>
            </a>
        </div>
    </div>

    <style>
        .menuLateral {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 50px;
            background: #333;
            overflow: hidden;
            transition: width 0.3s;
            z-index: 2000;         
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .menuLateral:hover {
            width: 235px;
        }
        .menuLateral .menuItem {
            display: flex;
            align-items: center;
            padding: 10px;
            color: #fff;
            text-decoration: none;
            border-bottom: 1px solid #444;
            transition: background 0.3s;
        }
        .menuLateral .menuItem:last-child {
            border-bottom: none;
        }
        .menuLateral .menuItem:hover {
            background: #555;
        }
        .menuLateral .menuItem img {
            width: 30px;
            height: auto;
            margin-right: 10px;
        }
        .menuLateral .menuItem span {
            white-space: nowrap;
            opacity: 0;
            transition: opacity 0.3s;
        }
        .menuLateral:hover .menuItem span {
            opacity: 1;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menu = document.getElementById('menuLateral');
            const main = document.getElementById('mainContent');  // <–– aqui!
            if (menu && main) {
                menu.addEventListener('mouseenter', () => {
                    main.style.marginLeft = '220px';
                });
                menu.addEventListener('mouseleave', () => {
                    main.style.marginLeft = '50px';
                });
            }
        });
    </script>
<?php
    }
}
?>

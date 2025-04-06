<?php
    session_start(); // Inicia a sessão para verificar se o usuário está logado
?>

<?php 
    class MenuLateral {
        public static function render() {
            ?>
            <!-- CSS embutido para o Menu Lateral -->
            <style>
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
                    display: flex;
                    flex-direction: column;
                    justify-content: space-between;
                }
                .menu-lateral:hover {
                    width: 220px; /* Largura expandida */
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
            </style>

            <!-- HTML do Menu Lateral -->
            <div class="menu-lateral" id="menuLateral">
                <div class="menu-items">
                    <a class="menu-item" onclick="location.href='/projetoSupermercado/paginaPrincipal.php';">
                        <img src="imagens/home.webp" alt="Página Principal">
                        <span>Página Principal</span>
                    </a>
                    <a class="menu-item" onclick="location.href='/projetoSupermercado/carrinho.php';">
                        <img src="imagens/carrinho.png" alt="Carrinho">
                        <span>Carrinho</span>
                    </a>
                    <a class="menu-item" onclick="location.href='/projetoSupermercado/exibirProdutos.php';">
                        <img src="imagens/loja.png" alt="Loja">
                        <span>Loja</span>
                    </a>
                    <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == 'logado'){ ?>
                        <a class="menu-item" onclick="location.href='/projetoSupermercado/admin/inserirProdutos.php';">
                            <img src="imagens/inserirProdutos.png" alt="Inserir Produtos">
                            <span>Inserir Produtos</span>
                        </a>
                        <a class="menu-item" onclick="location.href='/projetoSupermercado/admin/gerenciamentoProdutos.php';">
                            <img src="imagens/gerenciarProdutos.png" alt="Gerenciamento Produtos">
                            <span>Gerenciamento Produtos</span>
                        </a>
                    <?php } ?>
                </div>
                <div class="menu-footer">
                    <a class="menu-item" onclick="location.href='/projetoSupermercado/loginRegistro/logout.php';">
                        <img src="imagens/sair.png" alt="Sair">
                        <span>Sair</span>
                    </a>
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
            <?php            
        }
    }
?>
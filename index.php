<?php
session_start();
require("bd_config.php");

// Busca 8 produtos com desconto
$sql = "SELECT * FROM produtos WHERE produtos_desconto > 0 ORDER BY RAND() LIMIT 8";
$resultado = mysqli_query($con, $sql);
if (!$resultado) {
    die("Erro ao buscar produtos com desconto: " . mysqli_error($con));
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Mercadinho IRR</title>
    <link rel="stylesheet" href="css/index.css">
</head>
    <body>

        <!-- Contêiner arredondado principal -->
        <div class="container-arredondado">
            <h1 class="titulo-mercadinho">Mercadinho IRR</h1>

            <!-- Sessão de Login e Registro -->
            <div class="sessao-login-registro">
                <div class="box-login" onclick="location.href='loginRegistro/login.php'">
                    <h2>Login</h2>
                    <!-- Mensagem que aparece ao passar o mouse -->
                    <div class="hover-message">Entre na sua conta <br/> Importante realizar registro para obter mais funções!!!</div>
                </div>
                <div class="box-registro" onclick="location.href='loginRegistro/registro.php'">
                    <h2>Registro</h2>
                    <!-- Mensagem que aparece ao passar o mouse -->
                    <div class="hover-message">Crie uma nova conta</div>
                </div>
            </div>

            <div class="loginTeste"> 
                <p> Email e senha para teste do sistema: </p> 
                <p> Email: clienteTeste@gmail.com </p>
                <p> Senha: teste0221 </p>
            </div>

            <h2 class="titulo-destaques">PRODUTOS EM DESTAQUE</h2>

            <!-- Sessão de produtos com desconto -->
            <div class="gradeDescontos">
                <?php while($produto = mysqli_fetch_assoc($resultado)) {
                    // Calcula o preço com desconto
                    $precoComDesconto = $produto['produtos_preco'] * ((100 - $produto['produtos_desconto']) / 100);
                    ?>
                    <div class="produtoItem">
                        <img class="produtoImg" src="upload_produtos/<?= htmlspecialchars($produto['produtos_imagem']) ?>" alt="<?= htmlspecialchars($produto['produtos_nome']) ?>">
                        <h3><?= htmlspecialchars($produto['produtos_nome']) ?></h3>
                        <p class="precoAntigo"><del>R$ <?= number_format($produto['produtos_preco'], 2, ',', '.') ?></del></p>
                        <p class="precoDesconto"><strong>R$ <?= number_format($precoComDesconto, 2, ',', '.') ?></strong></p>

                        <!-- Botões de quantidade e carrinho -->
                        <div class="quantidadeContainer" data-stock="<?= htmlspecialchars($produto['produtos_estoque']) ?>">
                            <img src="imagens/minus.png" alt="Diminuir" class="btnQuantidade" onclick="alterarQuantidade(this, -1)">
                            <span class="quantidadeValor">1</span>
                            <img src="imagens/plus.png" alt="Aumentar" class="btnQuantidade" onclick="alterarQuantidade(this, 1)">
                            <img src="imagens/carrinho.png" alt="Carrinho" class="iconeCarrinho" onclick="location.href='carrinho.php'">
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <!-- Rodapé (não fixo) -->
        <div class="rodape">
            <a href="contato.php" class="link-contato">Contate-nos</a>
            <a href="loginRegistro/admin.php" class="link-admin">Admin</a>
        </div>

        <?php mysqli_close($con); ?>

        <script>
            function alterarQuantidade(btn, delta) {
                const container = btn.parentElement;
                const quantidadeElemento = container.querySelector('.quantidadeValor');
                let quantidade = parseInt(quantidadeElemento.textContent);

                // Obtenha o estoque máximo do data-stock
                const estoque = parseInt(container.getAttribute('data-stock')) || 100;

                let novaQuantidade = quantidade + delta;

                if (novaQuantidade < 1) {
                    novaQuantidade = 1;
                } else if (novaQuantidade > estoque) {
                    alert("Não há mais produtos em estoque");
                    novaQuantidade = estoque;
                }

                quantidadeElemento.textContent = novaQuantidade;
            }
        </script>
    </body>
</html>

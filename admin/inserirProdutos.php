<?php 
session_start();
if(isset($_SESSION['admin']) && $_SESSION['admin'] == 'logado') {
    require('../menuLateral.php');
?>
<html>

    <head>
        <meta charset="UTF-8">
        <title>Inserir Produtos</title>
        <link rel="stylesheet" href="/projetoSupermercado/css/inserirOsProdutos.css">
    </head>
    <body>
        
        <?php menuLateral::render(); ?>

        <!-- Título do site, fora do contêiner central -->
        <div class="siteTitulo">Mercadinho IRR</div>

        <!-- Conteiner central para o formulário -->
        <div class="conteinerCentral" id="mainContent">
            <?php
                if (isset($_SESSION['erro'])){
                    echo "<div class='mensagem'>" . $_SESSION['erro'] . "</div>";
                    unset($_SESSION['erro']);
                }
                if (isset($_SESSION['sucesso'])){
                    echo "<div class='mensagemSucesso'>" . $_SESSION['sucesso'] . "</div>";
                    unset($_SESSION['sucesso']);
                }

                // Mantem o valor anterior do categoria
                $categoriaSelecionada = $_POST['categoria'] ?? '';
            ?>

            <form class="formularioInserir" action="inserirProdutosCodigo.php" method="POST" enctype="multipart/form-data">
                <label for="nome">Nome:</label>
                <input type="text" name="nome" id="nome" required>

                <label for="descricao">Descrição:</label>
                <input type="text" name="descricao" id="descricao" maxlength="1250" required>

                <label for="preco">Preço:</label>
                <input type="number" name="preco" id="preco" step="0.01" required>

                <label for="desconto">Desconto (%):</label>
                <input type="number" name="desconto" id="desconto" step="0.01" value="0" required>

                <label for="imagem">Imagem:</label>
                <input type="file" name="imagem" id="imagem" accept="image/*" required>

                <label for="estoque">Estoque:</label>
                <input type="number" name="estoque" id="estoque" required>

                <label for="categoria">Categoria:</label>
                <select name="categoria" id="categoria" required>
                    <option value="." <?= $categoriaSelecionada == 'selecione' ? 'selected' : '' ?>> Selecione </option>
                    <option value="." <?= $categoriaSelecionada == 'cestaBasica' ? 'selected' : '' ?>> Cesta Básica </option>
                    <option value="." <?= $categoriaSelecionada == 'carne' ? 'selected' : '' ?>> Carne </option>
                    <option value="." <?= $categoriaSelecionada == 'bebidas' ? 'selected' : '' ?>> Bebidas </option>
                    <option value="." <?= $categoriaSelecionada == 'padaria' ? 'selected' : '' ?>> padaria </option>
                    <option value="." <?= $categoriaSelecionada == 'hortifruti' ? 'selected' : '' ?>> Hortifrúti (legumes, frutas e verduras) </option>
                    <option value="." <?= $categoriaSelecionada == 'alimentosCongelados' ? 'selected' : '' ?>> Alimentos Congelados </option>
                    <option value="." <?= $categoriaSelecionada == 'produtosDeLimpeza' ? 'selected' : '' ?>> Produtos de Limpeza </option>
                    <option value="." <?= $categoriaSelecionada == 'higienePessoal' ? 'selected' : '' ?>> Higiene Pessoal </option>
                    <option value="." <?= $categoriaSelecionada == 'outrosProdutos' ? 'selected' : '' ?>> Outros Produtos </option>
                </select>

                <input type="submit" value="Enviar">
            </form>
            <!-- Botão de voltar -->
            <button class="btnVoltar" onclick="location.href='/projetoSupermercado/paginaPrincipal.php'">Voltar</button>
        </div>
    </body>
</html>
<?php
} else {
    echo "Você não tem permissão de administrador";
}
?>

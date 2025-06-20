<?php
    header('Content-Type: text/html; charset=utf-8');
    session_start();
    require_once __DIR__ . '/../urlConfig.php';
    require_once __DIR__ . '/../menuLateral.php';
    require('../bd_config.php');
    if (isset($_SESSION['admin']) && $_SESSION['admin'] == 'logado'){

        if(isset($_GET['id'])) {
            
            $id = intval($_GET['id']);

            $sql = "SELECT * FROM produtos WHERE produtos_id = ?";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, 'i', $id);
            mysqli_stmt_execute($stmt);
            $resultado= mysqli_stmt_get_result($stmt);

            if ($produto = mysqli_fetch_assoc($resultado)) {
   
            } else {
                echo "Produto não encontrado.";
                exit;
            }
            
            mysqli_stmt_close($stmt);

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nome      = mysqli_real_escape_string($con, $_POST['nome']);
                $descricao = mysqli_real_escape_string($con, $_POST['descricao']);
                $preco     = floatval($_POST['preco']);
                $estoque   = intval($_POST['estoque']);
                $desconto  = floatval($_POST['desconto']);
                $categoria = mysqli_real_escape_string($con, $_POST['categoria']);

                $caminhoImagem = $_POST['imagemAntiga'];

                if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
                    $tmp  = $_FILES['imagem']['tmp_name'];
                    $nomeImg = basename($_FILES['imagem']['name']);
                    $novoCaminho = __DIR__ . '../uploadProdutos/' . $nomeImg;
                    if (move_uploaded_file($tmp, $novoCaminho)) {
                        $caminhoImagem = '../uploadProdutos/' . $nomeImg;
                    } else {
                        $_SESSION['erro'] = 'Falha no upload da imagem.';
                        header('Location: editarProdutos.php?id='.$id);
                        exit;
                    }
                }

                $sql = "UPDATE produtos
                        SET produtos_nome      = ?,
                            produtos_descricao = ?,
                            produtos_preco     = ?,
                            produtos_estoque   = ?,
                            produtos_imagem    = ?,
                            produtos_desconto  = ?,
                            categoria          = ?
                        WHERE produtos_id      = ?";
                $stmt = mysqli_prepare($con, $sql);
                mysqli_stmt_bind_param(
                    $stmt,
                    "ssdisisi",
                    $nome,
                    $descricao,
                    $preco,
                    $estoque,
                    $caminhoImagem,
                    $desconto,
                    $categoria,
                    $id
                );

                if (mysqli_stmt_execute($stmt)) {
                    $_SESSION['sucesso'] = 'Produto atualizado com sucesso.';
                    header('Location: gerenciamentoProdutos.php');
                    exit;
                } else {
                    echo "Erro ao atualizar: " . mysqli_error($con);
                    exit;
                }

            }
        }
        mysqli_close($con);
        ?>
        <!DOCTYPE html>
        <html lang="pt-BR">
            <head>
                <link rel="stylesheet" href="<?= BASE_URL ?>css/editarProdutos.css">
                <title>Editar Produto</title>
                <meta charset="UTF-8">
            </head>
            <body>

                <?php menuLateral::render(); ?>
                <div id="mainContent">

                    <div id="containerCentral">
                        <h1>Editar Produto</h1>

                        <form action="<?= BASE_URL ?>editarProdutos.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">

                            <input type="hidden" name="imagemAntiga" value="<?= htmlspecialchars($produto['produtos_imagem']) ?> ">

                            <label for="nome">Nome:</label>
                            <input type="text" name="nome" id="nome" value="<?= htmlspecialchars($produto['produtos_nome']) ?>" required>

                            <label for="descricao">Descrição:</label>
                            <input type="text" name="descricao" id="descricao" value="<?= htmlspecialchars($produto['produtos_descricao']) ?>" required>

                            <label for="preco">Preço (R$):</label>
                            <input type="number" name="preco" id="preco" step="0.01" value="<?= $produto['produtos_preco'] ?>" required>

                            <label for="desconto">Desconto (%):</label>
                            <input type="number" name="desconto" id="desconto" step="0.01" value="<?= $produto['produtos_desconto'] ?>" required>

                            <label for="estoque">Estoque:</label>
                            <input type="number" name="estoque" id="estoque" value="<?= $produto['produtos_estoque'] ?>" required>

                            <div class="imagemAtualContainer">
                                <label>Imagem atual:</label>
                                <img src="<?= htmlspecialchars($produto['produtos_imagem']) ?>" alt="Imagem do produto" class="imagemAtual">
                            </div>

                            <label for="imagem">Nova imagem (opcional):</label>
                            <input type="file" name="imagem" id="imagem" accept="image/*">

                            <label for="categoria">Categoria:</label>
                            <select name="categoria" id="categoria" required>
                                <option value="selecione" <?= ($produto['categoria'] === 'selecione') ? 'selected' : '' ?>>Selecione</option>
                                <option value="cestaBasica" <?= ($produto['categoria'] === 'cestaBasica') ? 'selected' : '' ?>>Cesta Básica</option>
                                <option value="carne" <?= ($produto['categoria'] === 'carne') ? 'selected' : '' ?>>Carne</option>
                                <option value="bebidas" <?= ($produto['categoria'] === 'bebidas') ? 'selected' : '' ?>>Bebidas</option>
                                <option value="padaria" <?= ($produto['categoria'] === 'padaria') ? 'selected' : '' ?>>Padaria</option>
                                <option value="hortifruti" <?= ($produto['categoria'] === 'hortifruti') ? 'selected' : '' ?>>Hortifrúti</option>
                                <option value="alimentosCongelados" <?= ($produto['categoria'] === 'alimentosCongelados') ? 'selected' : '' ?>>Alimentos Congelados</option>
                                <option value="produtosDeLimpeza" <?= ($produto['categoria'] === 'produtosDeLimpeza') ? 'selected' : '' ?>>Produtos de Limpeza</option>
                                <option value="higienePessoal" <?= ($produto['categoria'] === 'higienePessoal') ? 'selected' : '' ?>>Higiene Pessoal</option>
                                <option value="outros" <?= ($produto['categoria'] === 'outros') ? 'selected' : '' ?>>Outros</option>
                            </select>

                            <input type="submit" value="Salvar Alterações" class="botaoSalvar">
                        </form>
                    </div>
                </div>
            </body>
        </html>
<?php   
} else {
        echo "Você não possui permissões de administrador. ";
        exit;
    }
?>
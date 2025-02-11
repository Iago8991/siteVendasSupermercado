<?php 

    session_start();
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
            //Produto encontrado
        } else {
            echo "Produto não encontrado.";
            exit;
        }
        
        mysqli_stmt_close($stmt);

        //Formulário enviado
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = mysqli_real_escape_string($con, $_POST['nome']);
            $descricao = mysqli_real_escape_string($con, $_POST['descricao']);
            $preco = floatval($_POST['preco']);
            $estoque = intval($_POST['estoque']);

            //Atualiza a imagem se um novo arquivo for enviado
            if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK){
                $imagemtmp = $_FILES['imagem']['tmp_name'];
                $imagemnome = basename($_FILES['imagem']['name']);
                $caminhoimagem = "../upload_produtos/" . $imagemnome;
                
                //Move a nova imagem para a pasta de uploads
                if (move_uploaded_file($imagemtmp, $caminhoimagem)){

                    //Atualiza os dados do produto, incluindo a imagem
                    $sql = "UPDATE produtos SET produtos_nome = ?, produtos_descricao = ?, produtos_preco = ?, produtos_estoque = ?, produtos_imagem = ? WHERE produtos_id = ?";
                    $stmt = mysqli_prepare($con, $sql);
                    mysqli_stmt_bind_param($stmt, "ssdisi", $nome, $descricao, $preco, $estoque, $caminhoimagem, $id);
                } else {
                    echo "Erro ao fazer upload da imagem.";
                    exit;
                }

                } else {
                    //Atualiza os dados sem alterar a imagem
                    $sql = "UPDATE produtos SET produtos_nome = ?, produtos_descricao = ?, produtos_preco = ?, produtos_estoque = ?, produtos_imagem = ? WHERE produtos_id = ?";
                    $stmt = mysqli_prepare($con, $sql);
                    mysqli_stmt_bind_param($stmt, "ssdisi", $nome, $descricao, $preco, $estoque, $caminhoimagem, $id);
                }

                //Executa a atualização
                if (mysqli_stmt_execute($stmt)) {
                    $_SESSION['sucesso'] = "Produto atualizado com sucesso.";
                    header("location: gerenciamento_produtos.php");
                    exit;
                } else {
                    echo "Erro ao atualiar o produto: " . mysqli_error($con);
                    exit;
                }
        }
    }
    mysqli_close($con);
?>

<html>
    <head>
        <title>Editar Produtos</title>
        <meta charset="UTF-8">
    </head>
    <body>

        <h1>Editar Produto</h1>

        <form action="editar_produto.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">

            <label for="nome"> Nome: </label>
            <input type="text" name="nome" id="nome" value="<?= htmlspecialchars($produto['produtos_nome']) ?>" required> <br/> <br/>

            <label for="descricao"> Descrição: </label>
            <input type="text" name="descricao" id="drescricao" value="<?= htmlspecialchars($produto['produtos_descricao']) ?>" required> <br/> <br/>

            <label for="preco"> Preço: </label>
            <input type="number" name="preco" id="preco" step="0.01" value="<?= $produto['produtos_preco'] ?>" required> <br/> <br/>

            <label for="estoque"> Estoque: </label>
            <input type="number" name="estoque" id="estoque" value="<?= $produto['produtos_estoque'] ?>" required> <br/> <br/>

            <label for="imagem"> Imagem atual: </label>
            <img src="<?= htmlspecialchars($produto['produtos_imagem']) ?>" alt="Imagem do produto" width="150px"> <br/> <br/>
            
            <label for="imagem"> Nova Imagem (opcional): </label>
            <input type="file" name="imagem" id="imagem" accept="image/*"> <br/> <br/>

            <input type="submit" value="Salvar Alterações">
        </form>
    </body>
</html>




<?php   
    } else {
        echo "Você não possui permissões de administrador. ";
        exit;
    }

?>
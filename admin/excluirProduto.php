<?PHP 
    session_start();
    require('../bd_config.php');

    if (isset($_SESSION['admin']) && $_SESSION['admin'] == 'logado'){

        if (!isset($_GET['id']) || empty($_GET['id'])) {
            echo "ID Não encontrado.";
            exit;
        }

        $id = intval($_GET['id']);

        // Recupera o caminho da imagem do produto.
        $sql = "SELECT produtos_imagem FROM produtos WHERE produtos_id = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        if ($produto = mysqli_fetch_assoc($resultado)) {
            $caminhoImagem = "../upload_produtos/" . $produto['produtos_imagem']; 

            //Exclui o produto do banco de dados.
            $sql_delete = "DELETE FROM produtos WHERE produtos_id = ?";
            $stmt_delete = mysqli_prepare($con, $sql_delete);
            mysqli_stmt_bind_param($stmt_delete, "i", $id);

            if (mysqli_stmt_execute($stmt_delete)) {
                // Remove a imagem associada ao produto
                if (file_exists(filename: $caminhoImagem)) {
                    unlink($caminhoImagem);
                }

                $_SESSION['sucesso'] = "Produto excluído com sucesso!";
                header("Location: gerenciamentoProdutos.php");
                exit;
            } else {
                echo "Erro ao excluir o produto: " . mysqli_error($con);
            }
        } else {
            echo "Produto não encontrado.";
        }

        mysqli_stmt_close($stmt);
        mysqli_close($con);
} else {
        echo "Você não possui permissões de administrador. ";
        exit;
    }
?>
<?PHP
    session_start();
    require('../bd_config.php');
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $nome = mysqli_real_escape_string($con, $_POST['nome']);
        $descricao = mysqli_real_escape_string($con,$_POST["descricao"]);
        $preco= floatval($_POST["preco"]);
        $estoque= intval($_POST["estoque"]);
        $desconto= floatval($_POST["desconto"]);
        $categoria = mysqli_real_escape_string($con, $_POST['categoria']);

        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK){
            $imagemtmp = $_FILES['imagem']['tmp_name'];
            $imagemNome = basename($_FILES['imagem']['name']);
            $caminhoImagem = "../uploadProdutos/" . $imagemNome; 

            if(move_uploaded_file($imagemtmp, $caminhoImagem)){
                $sql = "INSERT INTO produtos (
                    produtos_nome,
                    produtos_descricao,
                    produtos_preco, 
                    produtos_imagem, 
                    produtos_estoque, 
                    produtos_desconto, 
                    categoria)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($con, $sql);
                mysqli_stmt_bind_param($stmt, "ssdsiis",
                                                                    $nome, 
                                                                   $descricao, 
                                                                          $preco, 
                                                                          $caminhoImagem, 
                                                                          $estoque, 
                                                                          $desconto, 
                                                                          $categoria);
                
                if (mysqli_stmt_execute($stmt)){
                    $_SESSION['sucesso'] = 'Produto Inserido com sucesso!.';
                    header("Location: inserirProdutos.php");
                } else {
                    $_SESSION['erro'] = 'Erro ao inserir o produto:' . mysqli_error($con);
                    header("Location: inserirProdutos.php");
                    exit;
                }
                
                mysqli_stmt_close($stmt);
            } else {
                $_SESSION['erro'] = 'Erro ao fazer upload da imagem.';
                header("Location: inserirProdutos.php");
                exit;
            }
        } else {
            $_SESSION['erro'] = 'Nenhuma imagem enviada devido a erro no upload. (Verifique e tente novamente)';
            header("Location: inserirProdutos.php");
            exit;
        }
    } else {
        $_SESSION['erro'] = 'Erro formulario não recebido.';
            header("Location: inserirProdutos.php");
        exit;
    }
    mysqli_close($con);
?>

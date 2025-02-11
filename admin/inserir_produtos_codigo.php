<?PHP
    session_start();
    require('../bd_config.php');

    
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        //Recebe os dados do formulário 
        $nome = mysqli_real_escape_string($con, $_POST['nome']);
        $descricao = mysqli_real_escape_string($con,$_POST["descricao"]);
        $preco= floatval($_POST["preco"]);
        $estoque= intval($_POST["estoque"]);

        //Processa o Upload da imagem
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK){
            $imagemtmp = $_FILES['imagem']['tmp_name'];
            $imagemnome = basename($_FILES['imagem']['name']);
            $caminhoimagem = "../upload_produtos/" . $imagemnome; 
             //__DIR__ retorna o caminho absoluto do diretório onde o php está localizado.

            //Move a imagem para a pasta de uploads
            if(move_uploaded_file($imagemtmp, $caminhoimagem)){
                //Insere os dados no banco
                $sql = "INSERT INTO produtos (produtos_nome, produtos_descricao, produtos_preco, produtos_imagem, produtos_estoque)
                VALUES (?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($con, $sql);
                mysqli_stmt_bind_param($stmt, "ssdsi", $nome, $descricao, $preco, $caminhoimagem, $estoque);
                
                if (mysqli_stmt_execute($stmt)){
                    $_SESSION['sucesso'] = 'Produto Inserido com sucesso!.';
                    header("Location: inserir_produtos.php");
                } else {
                    $_SESSION['erro'] = 'Erro ao inserir o produto:' . mysqli_error($con);
                    header("Location: inserir_produtos.php");
                    exit;
                }
                
                mysqli_stmt_close($stmt);
            } else {
                $_SESSION['erro'] = 'Erro ao fazer upload da imagem.';
                header("Location: inserir_produtos.php");
                exit;
            }
        } else {
            $_SESSION['erro'] = 'Nenhuma imagem enviada devido a erro no upload. (Verifique e tente novamente)';
            header("Location: inserir_produtos.php");
            exit;
        }
    } else {
        $_SESSION['erro'] = 'Erro formulario não recebido.';
            header("Location: inserir_produtos.php");
        exit;
    }

    //Fecha  a conexão com o banco
    mysqli_close($con);
?>

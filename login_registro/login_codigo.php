<?PHP

    session_start();
    require ("../bd_config.php");
 
    //problema das senhas hashadas sempre que efetuar login.
    /*
    $sql = "select user_id, user_senha from usuarios";
    $result = mysqli_query($con, $sql);

    while ($row = mysqli_fetch_assoc($result)){
        $senhahash = password_hash($row['user_senha'], PASSWORD_DEFAULT);
        $updatesql = "update usuarios set user_senha = '$senhahash' where user_id = {$row['user_id']}";
        mysqli_query($con, $updatesql);
    } 
        Resolvido.
    */
    
    //Verifica se o formulário foi envaido
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $email = mysqli_real_escape_string($con, $_POST["email"]);
        $senha = $_POST["senha"];
    };

    // Verifica se o email foi encontrado
    $email = mysqli_real_escape_string($con, $_POST["email"]);
    $senha = $_POST["senha"];

    //Verifica se o email existe no banco de dados
    $comandosql = "select * from usuarios where user_email = ?";
    $consulta = mysqli_prepare($con, $comandosql);
    mysqli_stmt_bind_param($consulta, "s", $email);
    mysqli_stmt_execute($consulta);
    $resultado = mysqli_stmt_get_result($consulta);

    //Verifica se o email foi encontrado
    if(mysqli_num_rows(result: $resultado) > 0) {
            $usuario = mysqli_fetch_assoc($resultado);
        
        //Verifica a senha
        if(password_verify($senha, $usuario['user_senha'])) {
            //Se passou
            $_SESSION['user_id'] = $usuario['user_id'];
            $_SESSION['user_nome'] = $usuario['user_nome'];
            $_SESSION['login'] = 'logado';
            header ("location: ../pagina_principal.php");
            exit;
        } else {
            //Senha incorreta
            $_SESSION['erro'] = "Senha incorreta. Tente novamente.";
            header("location: login.php");
            exit;
        }
    } else {
        //Email não encontrado
        $_SESSION['erro'] = "Email não encontrado. Registre-se primeiro. <br/> <a href ='registro.php'>Registre-se</a>";
        header("location: login.php");
        exit;
    }
?>

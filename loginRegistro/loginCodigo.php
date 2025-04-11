<?PHP
    session_start();
    require ("../bd_config.php");
 
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
            header ("location: /projetoSupermercado/paginaPrincipal.php");
            exit;
        } else {
            //Senha incorreta
            $_SESSION['errorLogin'] = "Senha incorreta. Tente novamente.";
            header("location: /projetoSupermercado/loginRegistro/login.php");
            exit;
        }
    } else {
        //Email não encontrado
        $_SESSION['errorLogin'] = "Email não encontrado. Registre-se primeiro. <br/> <a href ='registro.php'>Registre-se</a>";
        header("location: /projetoSupermercado/loginRegistro/login.php");
        exit;
    }
?>

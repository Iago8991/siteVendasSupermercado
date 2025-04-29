<?PHP
    session_start();
    require ("../bd_config.php");

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $email = mysqli_real_escape_string($con, $_POST["email"]);
        $senha = $_POST["senha"];
    };

    $email = mysqli_real_escape_string($con, $_POST["email"]);
    $senha = $_POST["senha"];

    $comandosql = "select * from usuarios where user_email = ?";
    $consulta = mysqli_prepare($con, $comandosql);
    mysqli_stmt_bind_param($consulta, "s", $email);
    mysqli_stmt_execute($consulta);
    $resultado = mysqli_stmt_get_result($consulta);

    if(mysqli_num_rows(result: $resultado) > 0) {
            $usuario = mysqli_fetch_assoc($resultado);

        if(password_verify($senha, $usuario['user_senha'])) {
            $_SESSION['user_id'] = $usuario['user_id'];
            $_SESSION['user_nome'] = $usuario['user_nome'];
            $_SESSION['login'] = 'logado';
            header ("location: ../paginaPrincipal.php");
            exit;
        } else {
            $_SESSION['errorLogin'] = "Senha incorreta. Tente novamente.";
            header("location: ../loginRegistro/login.php");
            exit;
        }
    } else {
        $_SESSION['errorLogin'] = "Email não encontrado. Registre-se primeiro. <br/> <a href ='registro.php'>Registre-se</a>";
        header("location: ../loginRegistro/login.php");
        exit;
    }
?>

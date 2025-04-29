<?php
    session_start();
    require ("../bd_config.php");

    $nome = mysqli_real_escape_string($con, $_POST["nome"]);
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    $verificarEmailsql = "select * from usuarios where user_email = ?";
    $consultaEmail = mysqli_prepare($con, $verificarEmailsql);
    mysqli_stmt_bind_param($consultaEmail, "s", $email);
    mysqli_stmt_execute($consultaEmail);
    $resultadoEmail = mysqli_stmt_get_result($consultaEmail);

    $verificarNomesql = "select * from usuarios where user_nome = ?";
    $consultaNome = mysqli_prepare($con, $verificarNomesql);
    mysqli_stmt_bind_param($consultaNome, "s", $nome);
    mysqli_stmt_execute($consultaNome);
    $resultadoNome = mysqli_stmt_get_result($consultaNome);

    if(mysqli_num_rows($resultadoEmail) > 0){
        $_SESSION['errorRegistro'] = "O E-mail já está registrado, faça <a href='login.php'>login</a> o utilizando ou tente outro.";
        header("location: registro.php");
        exit; 
    } elseif (mysqli_num_rows($resultadoNome) > 0){
        $_SESSION['errorRegistro'] = "Nome de usuario já está em uso. Tente outro.";
        header("location: registro.php");
        exit;
    }   else {
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

            $comandosql = " insert into usuarios (user_nome, user_email, user_senha)
            values (?, ?, ?);";

            $consulta = mysqli_prepare($con,$comandosql);
            mysqli_stmt_bind_param($consulta, "sss", $nome, $email, $senhaHash);

            if(mysqli_stmt_execute($consulta)){
                $_SESSION['sucessoRegistro'] = "Registro realizado com sucesso!!! \n faça <a href='login.php'>login</a> ";
                header("location: login.php");
            } else {
                $_SESSION['errorRegistro'] = "ERRO ao registrar. Tente novamente.";
                header("location: registro.php");
            }
        }    

?>


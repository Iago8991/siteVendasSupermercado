<?php
    require ("../bd_config.php");

    // recebe variaveis do form na pagina registro.php
    $nome = mysqli_real_escape_string($con, $_POST["nome"]);
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    //verifica se email já existe no banco de dados
    $verificarEmailsql = "select * from usuarios where user_email = ?";
    $consultaEmail = mysqli_prepare($con, $verificarEmailsql);
    mysqli_stmt_bind_param($consultEemail, "s", $email);
    mysqli_stmt_execute($consultaEmail);
    $resultadoEmail = mysqli_stmt_get_result($consultaEmail);

    //verifica se nome já existe no banco de dados
    $verificarNomesql = "select * from usuarios where user_nome = ?";
    $consultaNome = mysqli_prepare($con, $verificarNomesql);
    mysqli_stmt_bind_param($consultaNome, "s", $nome);
    mysqli_stmt_execute($consultaNome);
    $resultadoNome = mysqli_stmt_get_result($consultaNome);

    // Mensagens de erro
    if(mysqli_num_rows($resultadoEmail) > 0){
        $_SESSION['error'] = "O E-mail já está registrado, faça <a href='login.php'>login</a> o utilizando ou tente outro.";
        header("location: registro.php");
        exit; 
    } elseif (mysqli_num_rows($resultadoNome) > 0){
        $_SESSION['error'] = "Nome de usuario já está em uso. Tente outro.";
        header("location: registro.php");
        exit;
    }   else {
            
            //Hash da senha antes de salvar no banco de dados(aumentar a segurança e evitar erro na execução do código.)
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

            // comando que insere as informações do form no banco de dados
            $comandosql = " insert into usuarios (user_nome, user_email, user_senha)
            values (?, ?, ?);";

            // execução do comando que insere as informações no banco de dados
            $consulta = mysqli_prepare($con,$comandosql);
            mysqli_stmt_bind_param($consulta, "sss", $nome, $email, $senhaHash);

            if(mysqli_stmt_execute($consulta)){
                $_SESSION['sucesso'] = "Registro realizado com sucesso!!! ";
                header("location: login.php");
            } else {
                $_SESSION['error'] = "ERRO ao registrar. Tente novamente.";
                header("location: registro.php");
            }
        }    

?>


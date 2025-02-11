<?php
//configurações íniciais
session_start();
require ("../bd_config.php");

// recebe variaveis do form na pagina registro.php
$nome = mysqli_real_escape_string($con, $_POST["nome"]);
$email = $_POST["email"];
$senha = $_POST["senha"];

//verifica se email já existe no banco de dados
$verificaremailsql = "select * from usuarios where user_email = ?";
$consultaemail = mysqli_prepare($con, $verificaremailsql);
mysqli_stmt_bind_param($consultaemail, "s", $email);
mysqli_stmt_execute($consultaemail);
$resultadoemail = mysqli_stmt_get_result($consultaemail);

//verifica se nome já existe no banco de dados
$verificarnomesql = "select * from usuarios where user_nome = ?";
$consultanome = mysqli_prepare($con, $verificarnomesql);
mysqli_stmt_bind_param($consultanome, "s", $nome);
mysqli_stmt_execute($consultanome);
$resultadonome = mysqli_stmt_get_result($consultanome);

// Mensagens de erro
if(mysqli_num_rows($resultadoemail) > 0){
    $_SESSION['error'] = "O E-mail já está registrado, faça <a href='login.php'>login</a> o utilizando ou tente outro.";
    header("location: registro.php");
    exit; 
} elseif (mysqli_num_rows($resultadonome) > 0){
    $_SESSION['error'] = "Nome de usuario já está em uso. Tente outro.";
    header("location: registro.php");
    exit;
}   else {
        
        //Hash da senha antes de salvar no banco de dados(aumentar a segurança e evitar erro na execução do código.)
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        // comando que insere as informações do form no banco de dados
        $comandosql = " insert into usuarios (user_nome, user_email, user_senha)
        values (?, ?, ?);";

        // execução do comando que insere as informações no banco de dados
        $consulta = mysqli_prepare($con,$comandosql);
        mysqli_stmt_bind_param($consulta, "sss", $nome, $email, $senha_hash);

        if(mysqli_stmt_execute($consulta)){
            $_SESSION['sucesso'] = "Registro realizado com sucesso!!! ";
            header("location: login.php");
        } else {
            $_SESSION['error'] = "ERRO ao registrar. Tente novamente.";
            header("location: registro.php");
        }
    }    

?>


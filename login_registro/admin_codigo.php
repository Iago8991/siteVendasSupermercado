<?PHP 

    session_start();
    require('../bd_config.php');

    
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $senha = $_POST['senha'];
    
    // consulta administrador existe
    $sql = "SELECT adminis_senha FROM administrador WHERE adminis_email = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) === 1) {
        mysqli_stmt_bind_result($stmt, $senha_hash);
        mysqli_stmt_fetch($stmt);

        if(hash('SHA256', $senha) === $senha_hash){
            $_SESSION['admin'] = 'logado'; 
            $_SESSION['login'] = 'logado';
            header ("location: ../pagina_principal.php");
        } else {
            $_SESSION['erro'] = 'Senha incorreta!';
            header("Location: admin.php");
            exit;
        }
    } else {
        $_SESSION['erro'] = 'Administrador não encontrado!';
        header("Location: admin.php");
        exit;
    }
    mysqli_stmt_close($stmt);
} else {
    $_SESSION['erro'] = "método de requisição inválido.";
    header("Location: admin.php");
    exit;
}

mysqli_close(mysql: $con);
?>
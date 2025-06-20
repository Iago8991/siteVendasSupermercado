<?php
    header('Content-Type: text/html; charset=utf-8');
    session_start();
    require_once __DIR__ . '/urlConfig.php';
    require_once __DIR__ . '/menuLateral.php';
    if (isset($_SESSION['login']) && $_SESSION['login'] == 'logado') {
        require("bd_config.php");
?>

<?php menuLateral::render(); ?>

    <div id="mainContent">



    
    </div>
<?php
    } else {
        echo "Realize login para acessar a página!";
        echo "<button class='btn-voltar' onclick=\"location.href='index.php'\">Voltar</button>";
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">

</html>
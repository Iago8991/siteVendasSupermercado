<?php
    session_start();
    if (isset($_SESSION['login']) && $_SESSION['login'] == 'logado') {
        require("menuLateral.php");
        require("bd_config.php");
?>

<?php menuLateral::render(); ?>

<?php
    } else {
        echo "Realize login para acessar a página!";
        echo "<button class='btn-voltar' onclick=\"location.href='index.php'\">Voltar</button>";
    }
?>
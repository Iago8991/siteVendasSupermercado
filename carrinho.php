<?php
    session_start();
    if (isset($_SESSION['login']) && $_SESSION['login'] == 'logado') {
        require("menuLateral.php");
        require("bd_config.php");
?>

<?php menuLateral::render(); ?>

<?php
    } else {
        echo "Você não tem permissão de administrador";
    }
?>
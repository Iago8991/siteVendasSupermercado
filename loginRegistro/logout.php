<?php
    session_start();
    session_destroy();
    header("Location: /projetoSupermercado/index.php");
    exit;
?>
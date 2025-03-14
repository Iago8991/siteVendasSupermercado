<?php
    $host = "localhost";
    $user = "root";
    $password = "";
    $dbname = "bd_supermercado";

    $con = new mysqli($host, $user, $password, $dbname);
    if ($con->connect_error) {
        die("Conexão falhou: " . $con->connect_error);
    }
?>
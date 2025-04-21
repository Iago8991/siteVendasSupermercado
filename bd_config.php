<?php
    $host = "localhost";
    $user = "root";
    $password = "";
    $dbname = "bd_supermercado";

    // conexão no site online
    if(isset($_SERVER['HTTP_HOST']) &&
      ($_SERVER['HTTP_HOST'] === 'iagoRighetti.infinityfreeapp.com' ||
      $_SERVER['HTTP_HOST'] === 'www.iagoRighetti.infinityfreeapp.com')
      ){
        $host = '';
        $user = '';
        $password = '';
        $dbname = '';
      }

    $con = new mysqli($host, $user, $password, $dbname);
    if ($con->connect_error) {
        die("Conexão falhou: " . $con->connect_error);
    }
?>
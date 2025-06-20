<?php

    $script = $_SERVER['SCRIPT_NAME'];

    $parts = explode('/', trim($script, '/'));

    if (count($parts) > 1 && $parts[0] !== basename($script)) {
        define('BASE_URL', '/' . $parts[0] . '/');
    } else {
        define('BASE_URL', '/'); 
    }

?>
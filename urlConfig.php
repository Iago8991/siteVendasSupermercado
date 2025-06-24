<?php

    $docRoot = realpath($_SERVER['DOCUMENT_ROOT']);

    $projRoot = realpath(__DIR__);

    $basePath = str_replace('\\','/', str_replace($docRoot, '', $projRoot));

    define('BASE_URL', ($basePath === '' ? '/' : $basePath . '/'));

?>
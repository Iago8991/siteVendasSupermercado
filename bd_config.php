<?php 
  require __DIR__ . '/vendor/autoload.php';
  use Dotenv\Dotenv;

  $dotenv = Dotenv::createImmutable(__DIR__);
  $dotenv->load();

  $isProd = ($_SERVER['HTTP_HOST'] ?? '') === 'iagoRighetti.infinityfreeapp.com';

  $host = $isProd ? $_ENV['DB_HOST_PROD'] : $_ENV['DB_HOST'];
  $dbname = $isProd ? $_ENV['DB_DATABASE_PROD'] : $_ENV['DB_DATABASE'];
  $user = $isProd ? $_ENV['DB_USERNAME_PROD'] : $_ENV['DB_USERNAME'];
  $password = $isProd ? $_ENV['DB_PASSWORD_PROD'] : $_ENV['DB_PASSWORD'];

  $con = new mysqli($host, $user, $password, $dbname);
    if ($con->connect_error) {
        die("Conexão falhou: " . $con->connect_error);
    }
?>

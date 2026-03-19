<?php
  require __DIR__ . '/vendor/autoload.php';
  use Dotenv\Dotenv;

  if (file_exists(__DIR__ . '/.env')) {
      $dotenv = Dotenv::createImmutable(__DIR__);
      $dotenv->load();
  }

  $isProd = stripos($_SERVER['HTTP_HOST'] ?? '', 'infinityfree.me') !== false;

  if ($isProd) {
      $host     = $_ENV['DB_HOST_PROD'];
      $dbname   = $_ENV['DB_DATABASE_PROD'];
      $user     = $_ENV['DB_USERNAME_PROD'];
      $password = $_ENV['DB_PASSWORD_PROD'];
  } else {
      $host     = $_ENV['DB_HOST'];
      $dbname   = $_ENV['DB_DATABASE'];
      $user     = $_ENV['DB_USERNAME'];
      $password = $_ENV['DB_PASSWORD'];
  }

  $con = new mysqli($host, $user, $password, $dbname);
  
  if ($con->connect_error) {
      die("Conexão falhou: " . $con->connect_error);
  }

  if (!$con->set_charset('utf8mb4')) {
      die("Erro ao definir o charset: " . $con->error);
  }
?>
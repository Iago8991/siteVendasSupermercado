<?php
    header('Content-Type: text/html; charset=utf-8');
    session_start();
    require_once __DIR__ . '/urlConfig.php';
    require_once __DIR__ . '/menuLateral.php';
    if (isset($_SESSION['login']) && $_SESSION['login'] == 'logado') {
        require("bd_config.php");
?>

<?php menuLateral::render(); ?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Carrinho</title>
        <link rel="stylesheet" href="<?= BASE_URL ?>css/carrinho.css">
    </head>
    <body>
            <div id="mainContent">
                <h1> Carrinho de compras</h1>

            </div>
    </body>
</html>
<?php
    } else {
        echo "Realize login para acessar a página!";
        echo "<button class='btn-voltar' onclick=\"location.href='index.php'\">Voltar</button>";
    }
?>

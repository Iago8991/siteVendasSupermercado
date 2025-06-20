<?php
    header('Content-Type: text/html; charset=utf-8');
    session_start();
    require_once __DIR__ . '/urlConfig.php';
    require_once __DIR__ . '/menuLateral.php';
if (isset($_SESSION['login']) && $_SESSION['login'] == "logado") {
    require("bd_config.php");
    
?>
    <!DOCTYPE html>
    <html lang="pt-BR">
        <head>
            <link rel="stylesheet" href="<?= BASE_URL ?>css/contato.css">
            <meta charset="UTF-8">
            <title>Contato</title>
        </head>
        <body>
            <div class="containerCentral">
                <h1>Contato</h1>

                <?php menuLateral::render(); ?>

                <p>Se você tiver alguma dúvida ou sugestão, entre em contato conosco através do e-mail:</p>
                <p class="email">iagoadsprogramer@gmail.com</p>
                <p>Ou pelo telefone:</p>
                <p class="telefone">(11) 91373-4356</p>
                <br/>
                <p>Se preferir, preencha o formulário abaixo:</p>
                <textarea class="mensagem" rows="4" cols="50" placeholder="Digite seu problema"> </textarea>

                <a href="paginaPrincipal.php" class="btn btn-primary">Voltar</a>

            </div>
        </body>
    </html>

<?php
    } else {
        echo "Realize o login para acessar a página";
        echo "<button class='btn-voltar' onclick=\"location.href='index.php'\">Voltar</button>";
    }
?>
<?php
    header('Content-Type: text/html; charset=utf-8');
    session_start();
    require_once __DIR__ . '/urlConfig.php';

    // Lógica para processar o envio e mostrar o alerta
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        echo "<script>
                alert('Reclamação enviada com sucesso responderemos em breve !!!');
                window.location.href = 'contato.php';
              </script>";
        exit;
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>css/contato.css">
    <title>Contato - Mercadinho</title>
</head>
<body>
    <div class="background-overlay">
        <div class="container-contato">
            <h1>Contate-nos</h1>
            
            <form action="contato.php" method="POST">
                <div class="campo-grupo">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" required>
                </div>

                <div class="campo-grupo">
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="campo-grupo">
                    <label for="telefone">Telefone:</label>
                    <input type="tel" id="telefone" name="telefone" required>
                </div>

                <div class="campo-grupo">
                    <label for="mensagem">Mensagem:</label>
                    <textarea id="mensagem" name="mensagem" rows="4" required></textarea>
                </div>

                <div class="info-contato">
                    <p><strong>Telefone para contato:</strong> xxxxx-xxxxxx</p>
                    <p><strong>E-mail para contato:</strong> MercadinhoIRrsuporte@gmail.com</p>
                </div>

                <div class="botoes-acoes">
                    <a href="index.php" class="btn-voltar">Voltar</a>
                    <button type="submit" class="btn-enviar">Enviar reclamação</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
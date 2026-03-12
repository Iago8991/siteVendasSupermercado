<?php
    session_start();
    include 'db_config.php';

    // 1. Verifica se o usuário está logado
    if (!isset($_SESSION['user_id'])) {
        // Se não estiver logado, manda para a página de login com um aviso
        header("Location: login.php?erro=faca_login");
        exit;
    }

    // 2. Verifica se o ID do produto chegou via POST
    if (isset($_POST['produto_id'])) {
        $usuario_id = $_SESSION['user_id'];
        $produto_id = intval($_POST['produto_id']);

        // 3. Tenta inserir ou atualizar a quantidade (Lógica que você já tem)
        $sql = "INSERT INTO carrinho_itens (usuario_id, produto_id, quantidade) 
                VALUES (?, ?, 1) 
                ON DUPLICATE KEY UPDATE quantidade = quantidade + 1";

        $stmt = $conn->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("ii", $usuario_id, $produto_id);

            if ($stmt->execute()) {
                // SUCESSO: Redireciona para o carrinho para o usuário ver o item lá
                header("Location: carrinho.php?sucesso=adicionado");
                exit;
            } else {
                echo "Erro ao inserir no banco: " . $conn->error;
            }
        } else {
            echo "Erro na preparação do SQL: " . $conn->error;
        }
    } else {
        // Se alguém tentar acessar o arquivo direto sem clicar no botão
        header("Location: paginaPrincipal.php");
        exit;
    }
?>
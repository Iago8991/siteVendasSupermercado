<?php
session_start();
include 'bd_config.php'; // Aqui ele carrega a variável $con

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?erro=faca_login");
    exit;
}

if (isset($_POST['nome_produto'])) {
    $usuario_id = $_SESSION['user_id'];
    $nome_produto = $_POST['nome_produto'];

    // 1. Procurar o ID do produto pelo Nome usando $con
    $sql_busca = "SELECT produtos_id FROM produtos WHERE produtos_nome = ?";
    $stmt_busca = $con->prepare($sql_busca);
    
    if ($stmt_busca) {
        $stmt_busca->bind_param("s", $nome_produto);
        $stmt_busca->execute();
        $resultado = $stmt_busca->get_result();

        if ($produto_encontrado = $resultado->fetch_assoc()) {
            $produto_id = $produto_encontrado['produtos_id'];

            // 2. Agora insere na tabela carrinho_itens usando $con
            $sql_carrinho = "INSERT INTO carrinho_itens (usuario_id, produto_id, quantidade) 
                             VALUES (?, ?, 1) 
                             ON DUPLICATE KEY UPDATE quantidade = quantidade + 1";

            $stmt_carrinho = $con->prepare($sql_carrinho);
            
            if ($stmt_carrinho) {
                $stmt_carrinho->bind_param("ii", $usuario_id, $produto_id);

                if ($stmt_carrinho->execute()) {
                    header("Location: carrinho.php?sucesso=adicionado");
                    exit;
                } else {
                    echo "Erro ao inserir no carrinho: " . $con->error;
                }
            }
        } else {
            echo "Produto não encontrado: " . htmlspecialchars($nome_produto);
        }
    } else {
        echo "Erro na busca do produto: " . $con->error;
    }
} else {
    header("Location: paginaPrincipal.php");
    exit;
}
?>
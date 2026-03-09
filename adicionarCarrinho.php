<?php
include 'db_config.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Você precisa estar logado para comprar.']);
    exit;
}

if (isset($_POST['produto_id'])) {
    $usuario_id = $_SESSION['user_id'];
    $produto_id = intval($_POST['produto_id']);

    // Usando a lógica de "DUPLICATE KEY" que o seu banco permite:
    // Se o produto já estiver lá, ele apenas soma +1 na quantidade.
    $sql = "INSERT INTO carrinho_itens (usuario_id, produto_id, quantidade) 
            VALUES (?, ?, 1) 
            ON DUPLICATE KEY UPDATE quantidade = quantidade + 1";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $usuario_id, $produto_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'sucesso', 'mensagem' => 'Produto adicionado ao carrinho!']);
    } else {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao adicionar ao banco.']);
    }
}
?>
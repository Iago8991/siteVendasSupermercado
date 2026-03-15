<?php
    session_start();
    require("bd_config.php");

    header('Content-Type: application/json');

    if (!isset($_SESSION['login']) || $_SESSION['login'] !== 'logado') {
        exit(json_encode(["sucesso" => false, "erro" => "Não logado"]));
    }

    $usuario_id = $_SESSION['user_id'];

    if (isset($_POST['atualizar_qtd'])) {
        $prod_id = intval($_POST['produto_id']);
        $nova_qtd = intval($_POST['quantidade']);

        $sql_estoque = "SELECT produtos_estoque FROM produtos WHERE produtos_id = ?";
        $stmt_e = $con->prepare($sql_estoque);
        $stmt_e->bind_param("i", $prod_id);
        $stmt_e->execute();
        $estoque_real = $stmt_e->get_result()->fetch_assoc()['produtos_estoque'];

        $sql_up = "UPDATE carrinho_itens SET quantidade = ? WHERE produto_id = ? AND usuario_id = ?";
        $stmt_u = $con->prepare($sql_up);
        $stmt_u->bind_param("iii", $nova_qtd, $prod_id, $usuario_id);
        
        if ($stmt_u->execute()) {
            echo json_encode([
                "sucesso" => true,
                "novaQtd" => $nova_qtd,
                "excedeu" => ($nova_qtd > $estoque_real),
                "estoque" => $estoque_real
            ]);
        }
        exit;
    }

    if (isset($_GET['remover'])) {
        $carrinho_id = intval($_GET['remover']);
        $sql_delete = "DELETE FROM carrinho_itens WHERE carrinho_id = ? AND usuario_id = ?";
        $stmt = $con->prepare($sql_delete);
        $stmt->bind_param("ii", $carrinho_id, $usuario_id);
        $stmt->execute();
        header("Location: carrinho.php");
        exit;
    }

    if (isset($_POST['limpar_carrinho'])) {
        $sql = "DELETE FROM carrinho_itens WHERE usuario_id = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "i", $usuario_id);
        
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['sucesso' => true]);
        } else {
            echo json_encode(['sucesso' => false, 'erro' => mysqli_error($con)]);
        }
        exit;
    }
?>
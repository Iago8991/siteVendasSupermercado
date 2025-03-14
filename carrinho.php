<?PHP
    require("bd_config.php");
    require('/css/carrinho.css');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Carrinho de Compras</title>
</head>
<body>
    <h1>Carrinho de Compras</h1>
   
    <div class="item" data-preco="100.00" data-desconto="10">
        <p>Produto A - R$ 100,00</p>
        <p>Desconto: 10%</p>
    </div>
    <div class="item" data-preco="200.00" data-desconto="5">
        <p>Produto B - R$ 200,00</p>
        <p>Desconto: 5%</p>
    </div>
    
    <h2 id="totalCarrinho">Total: R$ 0,00</h2>
    
    <script>
        function calcularPrecoComDesconto(preco, desconto) {
           
            if (desconto <= 0) {
                return preco;
            }
            return preco * ((100 - desconto) / 100);
        }

        function atualizarTotalCarrinho() {
            const itens = document.querySelectorAll('.item');
            let total = 0;
            itens.forEach(function(item) {
                const preco = parseFloat(item.getAttribute('data-preco'));
                const desconto = parseFloat(item.getAttribute('data-desconto'));
                const precoFinal = calcularPrecoComDesconto(preco, desconto);
                total += precoFinal;
            });
            document.getElementById('totalCarrinho').innerText = "Total: R$ " + total.toFixed(2).replace('.', ',');
        }
        
        
        atualizarTotalCarrinho();
    </script>

<?php

foreach ($carrinho as $produto) {
    echo '<div class="item" data-preco="' . $produto['produtos_preco'] . '" data-desconto="' . $produto['produtos_desconto'] . '">';
    echo '<p>' . htmlspecialchars($produto['produtos_nome']) . ' - R$ ' . number_format($produto['produtos_preco'], 2, ',', '.') . '</p>';
    echo '<p>Desconto: ' . $produto['produtos_desconto'] . '%</p>';
    echo '</div>';
}
?>
    

</body>
</html>

function alterarQtd(produtoId, delta) {
    const spanQtd = document.getElementById(`qtd-${produtoId}`);
    let quantidadeAtual = parseInt(spanQtd.innerText);
    let novaQuantidade = quantidadeAtual + delta;

    if (novaQuantidade < 1) return;

    // Envia para o PHP atualizar o banco
    const dados = new FormData();
    dados.append('atualizar_qtd', '1');
    dados.append('produto_id', produtoId);
    dados.append('quantidade', novaQuantidade);

    fetch('carrinhoCodigo.php', {
        method: 'POST',
        body: dados
    })
    .then(res => res.json())
    .then(data => {
        if (data.sucesso) {
            spanQtd.innerText = data.novaQtd;
            
            const aviso = document.getElementById(`aviso-${produtoId}`);
            if (data.excedeu) {
                aviso.style.display = 'block';
                aviso.innerHTML = `A quantidade de produtos na sua conta excede o número atual no estoque.<br>A quantidade de produtos em estoque é ${data.estoque}`;
            } else {
                aviso.style.display = 'none';
            }
            
            recalcularTotal();
        }
    })
    .catch(err => console.error("Erro ao atualizar:", err));
}

function recalcularTotal() {
    let totalGeral = 0;
    const itens = document.querySelectorAll('.itemNoCarrinho');

    itens.forEach(item => {
        const preco = parseFloat(item.getAttribute('data-preco'));
        const qtd = parseInt(item.querySelector('.qtdValor').innerText);
        totalGeral += (preco * qtd);
    });

    document.getElementById('valorTotal').innerText = totalGeral.toLocaleString('pt-BR', { minimumFractionDigits: 2 });
}

// Calcula o total assim que a página abre
window.onload = recalcularTotal;
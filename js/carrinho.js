function alterarQtd(produtoId, delta) {
    const spanQtd = document.getElementById(`qtd-${produtoId}`);
    if (!spanQtd) return;

    let quantidadeAtual = parseInt(spanQtd.innerText);
    let novaQuantidade = quantidadeAtual + delta;

    if (novaQuantidade < 1) return;

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
            if (aviso) {
                if (data.excedeu) {
                    aviso.style.display = 'block';
                    aviso.innerHTML = `Estoque insuficiente: ${data.estoque}`;
                } else {
                    aviso.style.display = 'none';
                }
            }
            recalcularTotal();
        }
    })
    .catch(err => console.error("Erro na atualização:", err));
}

function recalcularTotal() {
    let totalGeral = 0;
    const itens = document.querySelectorAll('.itemNoCarrinho');
    const valorTotalElemento = document.getElementById('valorTotal');

    if (!valorTotalElemento) return;

    itens.forEach(item => {
        const preco = parseFloat(item.getAttribute('data-preco'));
        const qtdElemento = item.querySelector('.qtdValor');
        if (qtdElemento) {
            const qtd = parseInt(qtdElemento.innerText);
            totalGeral += (preco * qtd);
        }
    });

    valorTotalElemento.innerText = totalGeral.toLocaleString('pt-BR', { 
        minimumFractionDigits: 2, 
        maximumFractionDigits: 2 
    });
}

function finalizarCompra() {
    const itens = document.querySelectorAll('.itemNoCarrinho');
    if (itens.length === 0) {
        alert("Seu carrinho está vazio!");
        return;
    }
    const modal = document.getElementById('modalPagamento');
    if (modal) modal.style.display = 'flex';
}

function fecharModal() {
    const modal = document.getElementById('modalPagamento');
    if (modal) modal.style.display = 'none';
}

const formPagamento = document.getElementById('formPagamento');
if (formPagamento) {
    formPagamento.addEventListener('submit', function(e) {
        e.preventDefault();

        const dados = new FormData();
        dados.append('limpar_carrinho', '1');

        fetch('carrinhoCodigo.php', {
            method: 'POST',
            body: dados
        })
        .then(res => res.json())
        .then(data => {
            if (data.sucesso) {
                fecharModal();
                
                const produtosCard = document.getElementById('produtosCard');
                if (produtosCard) produtosCard.innerHTML = "<p class='avisoVazio'>Seu carrinho ainda está vazio!</p>";
                
                const valorTotal = document.getElementById('valorTotal');
                if (valorTotal) valorTotal.innerText = "0,00";

                const banner = document.getElementById('bannerSucesso');
                if (banner) {
                    banner.style.display = 'block';
                    setTimeout(() => { banner.style.display = 'none'; }, 4000);
                }
            } else {
                alert("Erro ao processar pagamento.");
            }
        })
        .catch(err => {
            console.error("Erro ao finalizar:", err);
            alert("Ocorreu um erro técnico ao finalizar a compra.");
        });
    });
}

window.addEventListener('load', recalcularTotal);
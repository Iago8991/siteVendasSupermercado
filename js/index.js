
function alterarQuantidade(btn, delta) {
    const container = btn.parentElement;
    const quantidadeElemento = container.querySelector('.quantidadeValor');
    let quantidade = parseInt(quantidadeElemento.textContent);

    const estoque = parseInt(container.getAttribute('data-stock')) || 100;

    let novaQuantidade = quantidade + delta;

    if (novaQuantidade < 1) {
        novaQuantidade = 1;
    } else if (novaQuantidade > estoque) {
        alert("Não há mais produtos em estoque");
        novaQuantidade = estoque;
    }

    quantidadeElemento.textContent = novaQuantidade;
}

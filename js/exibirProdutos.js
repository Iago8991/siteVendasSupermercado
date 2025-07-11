
function clearSearch() {
    document.getElementById('busca').value = '';
}

function toggleDropdown() {
    document.getElementById('dropdownOpcoes').classList.toggle('show');
}
function selecionarCategoria(valor, texto) {
    document.getElementById('categoriaInput').value = valor;
    document.getElementById('categoriaSelecionada').textContent = texto;
    toggleDropdown();
    document.getElementById('categoriaForm').submit();
}

document.addEventListener('click', function(e) {
    const dropdown = document.querySelector('.categoriaDropdown');
    if (!dropdown.contains(e.target)) {
    document.getElementById('dropdownOpcoes').classList.remove('show');
    }
});

function alterarQuantidade(btn, delta) {
    const container = btn.parentElement;
    const valorEl = container.querySelector('.quantidadeValor');
    let qtd = parseInt(valorEl.textContent, 10);
    const estoque = parseInt(container.dataset.stock, 10);
    qtd = Math.max(1, Math.min(estoque, qtd + delta));
    valorEl.textContent = qtd;
}

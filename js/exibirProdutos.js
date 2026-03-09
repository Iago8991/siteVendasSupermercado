
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


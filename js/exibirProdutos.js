function toggleDropdown() {
    const dropdown = document.getElementById('dropdownOpcoes');
    dropdown.classList.toggle('show');
}

function selecionarCategoria(valor, texto) {
    const inputCategoria = document.getElementById('categoriaInput');
    const labelSelecionada = document.getElementById('categoriaSelecionada');
    
    if (inputCategoria && labelSelecionada) {
        inputCategoria.value = valor;
        labelSelecionada.textContent = texto;
        
        document.getElementById('dropdownOpcoes').classList.remove('show');
        
        document.getElementById('categoriaForm').submit();
    }
}

document.addEventListener('click', function(e) {
    const dropdownContainer = document.querySelector('.categoriaDropdown');
    const opcoes = document.getElementById('dropdownOpcoes');
    
    if (dropdownContainer && !dropdownContainer.contains(e.target)) {
        opcoes.classList.remove('show');
    }
});
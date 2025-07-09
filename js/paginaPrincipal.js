function adicionarAoCarrinho(produtos_id) {
    alert("Produto " + produtos_id + " adicionado ao carrinho (exemplo)!");
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.sliderContainer').forEach(container => {
        const slider = container.querySelector('.sliderProdutos');
        const prev = container.querySelector('.setaAnterior');
        const next = container.querySelector('.setaProxima');

        if (slider.scrollWidth > slider.clientWidth) {
            container.querySelector('.navegacaoSlider').classList.add('scrollable');
            prev.addEventListener('click', () => {
                slider.scrollBy({ left: -slider.clientWidth * 0.8, behavior: 'smooth' });
            });
            next.addEventListener('click', () => {
                slider.scrollBy({ left: slider.clientWidth * 0.8, behavior: 'smooth' });
            });
        }
    });
});

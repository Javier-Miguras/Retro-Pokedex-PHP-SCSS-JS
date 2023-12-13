document.addEventListener("DOMContentLoaded", function () {
    // Al hacer clic en un Pokémon de la lista
    document.querySelector('#pokemonList').addEventListener('click', function (event) {
        // Limpiar el localStorage antes de almacenar una nueva posición
        localStorage.clear();

        // Obtener la posición actual de la lista
        var position = event.target.closest('li').dataset.position;

        // Almacenar la posición en localStorage
        localStorage.setItem('lastPosition', position);
    });

    // Verificar si hay una posición almacenada en localStorage
    var lastPosition = localStorage.getItem('lastPosition');

    // Si hay una posición almacenada, desplazarse a esa posición
    if (lastPosition !== null) {
        // Encontrar el elemento con el atributo data-position igual a lastPosition
        var elementoPokemon = document.querySelector('li[data-position="' + lastPosition + '"]');

        // Asegurarse de que el elemento existe antes de intentar desplazarlo
        if (elementoPokemon) {
            elementoPokemon.scrollIntoView({ behavior: 'auto' });
            localStorage.clear();
        }
    }

    // Limpiar localStorage cuando la pagina se carga por primera vez

    if (performanceNavigation.type === 1){
        localStorage.clear();
    }

    // Limpiar localStorage solo cuando se recarga el index.php
    if (window.location.pathname.endsWith('index.php')) {
        localStorage.clear();
    }



});

document.addEventListener("DOMContentLoaded", function () {
    //Modal

    const modalWindow = document.querySelector('#modal');
    const openModalButton = document.querySelector('#openModalButton');
    const closeModalButton = document.querySelector('#closeModal');

    openModalButton.addEventListener('click', (event) => {
        event.preventDefault();
        modalWindow.showModal();
    });

    closeModalButton.addEventListener('click', () => {
        modalWindow.close();
    });

    // Type buttons

    const typeButtons = document.querySelectorAll('.type-button');

    typeButtons.forEach((typeButton) => {
        typeButton.addEventListener('click', () => {
            typeButton.classList.toggle('selected');
        });
    });

    // Variables adicionales para el filtrado por tipo
    const resetTypesButton = document.querySelector('#resetTypes');
    const applyTypesButton = document.querySelector('#applyTypes');
    const typeFilterSelect = document.querySelector('#typeFilter');

    // Restablecer tipos al hacer clic en el botón Reset
    resetTypesButton.addEventListener('click', () => {
        typeButtons.forEach((typeButton) => {
            typeButton.classList.remove('selected');
        });

        // Quitar los tipos del parámetro en la URL al hacer clic en Reset
        const filteredParams = new URLSearchParams(window.location.search);
        filteredParams.delete('typeFilter');

        // Redirigir a la página sin tipos en la URL
        window.location.href = `/?${filteredParams.toString()}`;
    });

    // Aplicar filtro al hacer clic en el botón Apply
    applyTypesButton.addEventListener('click', () => {
        const selectedTypes = Array.from(typeButtons)
            .filter((typeButton) => typeButton.classList.contains('selected'))
            .map((typeButton) => typeButton.textContent.trim());

        const filteredParams = new URLSearchParams(window.location.search);
        filteredParams.set('typeFilter', selectedTypes.join(','));

        // Redirigir a la página con los tipos seleccionados como parámetros de la URL
        window.location.href = `/?${filteredParams.toString()}`;
    });
});




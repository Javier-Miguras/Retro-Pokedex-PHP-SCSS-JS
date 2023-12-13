document.addEventListener('DOMContentLoaded', function () {
    const sortFilter = document.getElementById('sortFilter');

    sortFilter.addEventListener('change', function () {
        updateSortFilter();
    });

    function updateSortFilter() {
        const selectedSort = sortFilter.value;

        // Redirigir a la página actual con el parámetro de filtro de orden en la URL
        window.location.href = `?sortFilter=${selectedSort}`;
        

    }
});




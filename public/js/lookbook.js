    const body = document.body;
    const toggleBtn = document.getElementById('toggle-theme');
    const currentTheme = localStorage.getItem('theme');

    if (currentTheme === 'dark') {
        body.classList.replace('light-mode', 'dark-mode');
        toggleBtn.innerHTML = '<i class="bi bi-sun-fill"></i> Modo claro';
        toggleBtn.classList.replace('btn-outline-dark', 'btn-outline-light');
    }

    toggleBtn.addEventListener('click', () => {
        if (body.classList.contains('light-mode')) {
        body.classList.replace('light-mode', 'dark-mode');
        toggleBtn.innerHTML = '<i class="bi bi-sun-fill"></i> Modo claro';
        toggleBtn.classList.replace('btn-outline-dark', 'btn-outline-light');
        localStorage.setItem('theme', 'dark');
        } else {
        body.classList.replace('dark-mode', 'light-mode');
        toggleBtn.innerHTML = '<i class="bi bi-moon-fill"></i> Modo oscuro';
        toggleBtn.classList.replace('btn-outline-light', 'btn-outline-dark');
        localStorage.setItem('theme', 'light');
        }
    });

    function toggleAccordion(header) {
        const body = header.nextElementSibling;
        body.classList.toggle("show");
        const arrow = header.querySelector("span:last-child");
        arrow.textContent = body.classList.contains("show") ? "▲" : "▼";
    }

    // === Selección de filtros ===
    document.addEventListener('DOMContentLoaded', function () {
        // COLECCIONES
        const selectAllCollections = document.getElementById('select-all-collections');
        const collectionCheckboxes = document.querySelectorAll('.collection-checkbox');

        if (selectAllCollections) {
        selectAllCollections.addEventListener('change', function () {
            if (this.checked) {
            collectionCheckboxes.forEach(cb => cb.checked = false);
            }
        });

        collectionCheckboxes.forEach(cb => {
            cb.addEventListener('change', () => {
            if (cb.checked) {
                selectAllCollections.checked = false;
            }
            });
        });
        }

        // CATEGORÍAS
        const selectAllCategories = document.getElementById('select-all-categories');
        const categoryCheckboxes = document.querySelectorAll('.category-checkbox');

        if (selectAllCategories) {
        selectAllCategories.addEventListener('change', function () {
            if (this.checked) {
            categoryCheckboxes.forEach(cb => cb.checked = false);
            }
        });

        categoryCheckboxes.forEach(cb => {
            cb.addEventListener('change', () => {
            if (cb.checked) {
                selectAllCategories.checked = false;
            }
            });
        });
        }
    });
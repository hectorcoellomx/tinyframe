    const body = document.body;
    const toggleBtn = document.getElementById('toggle-theme');
    const currentTheme = localStorage.getItem('theme');
    const fitoggleBtn = document.getElementById('fitoggle');

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

    
    // === Selección de filtros ===
    document.addEventListener('DOMContentLoaded', function () {
        // COLECCIONES
        const selectAllCollections = document.getElementById('select-all-collections');
        const collectionCheckboxes = document.querySelectorAll('.collection-checkbox');

        if (selectAllCollections) {
            selectAllCollections.addEventListener('change', function () {
                if (this.checked) {
                collectionCheckboxes.forEach(cb => {
                    cb.checked = false;
                    cb.disabled = true;
                    }
                );
                }
                else{
                    collectionCheckboxes.forEach(cb =>{
                        cb.disabled = false;
                    });
                }
            });

            collectionCheckboxes.forEach(cb => {
                cb.addEventListener('change', () => {
                if (cb.checked) {
                    selectAllCollections.checked = false;

                    collectionCheckboxes.forEach(cb => {
                        cb.disabled = false;
                    });
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
                categoryCheckboxes.forEach(cb => {
                    cb.checked = false;
                    cb.disabled = true;
                });
                }
                else{
                    categoryCheckboxes.forEach(cb => {
                        cb.disabled = false;
                    })
                }
            });

            categoryCheckboxes.forEach(cb => {
                cb.addEventListener('change', () => {
                if (cb.checked) {
                    selectAllCategories.checked = false;

                    collectionCheckboxes.forEach(cb => {
                        cb.disabled = false;
                    });
                }
                });
        });
        }
        const fitoggleBtn = document.getElementById('fitoggle');
        const filterForm = document.getElementById('filter-form');
        const closeBtn = document.getElementById('filter-close');

        const applyBtn = document.getElementById('apply-filters');

        if (applyBtn) {
            applyBtn.addEventListener('click', function () {
                // Oculta los filtros
                if (filterForm) {
                    filterForm.style.display = 'none';
                }

                // Muestra el botón de abrir filtros
                if (fitoggleBtn) {
                    fitoggleBtn.style.display = 'block';
                }

                // (Opcional) podrías hacer submit programático si no quieres que el formulario lo haga por defecto
                // document.querySelector('#filter-form form').submit();
            });
        }

        if (fitoggleBtn) {
        fitoggleBtn.addEventListener('click', function () {
            filterForm.style.display = 'block';
            fitoggleBtn.style.display = 'none';
            });
        }

    // Ocultar filtros al hacer clic en "Cerrar"
        if (closeBtn) {
            closeBtn.addEventListener('click', function () {
                filterForm.style.display = 'none';
                if (fitoggleBtn) {
                    fitoggleBtn.style.display = 'block';
                }
            });
    }
        
       
    });
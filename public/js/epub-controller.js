class EPubReader {
    constructor() {
        this.book = null;
        this.rendition = null;
        this.currentSection = null;
        
        this.initElements();
        this.initEventListeners();
        this.loadBook();
    }
    
    initElements() {
        this.viewer = document.getElementById('epub-viewer');
        this.loader = document.getElementById('epub-loader');
        this.prevBtn = document.getElementById('prev-page');
        this.nextBtn = document.getElementById('next-page');
        this.pageInfo = document.getElementById('page-info');
    }
    
    initEventListeners() {
        this.prevBtn.addEventListener('click', () => this.prevPage());
        this.nextBtn.addEventListener('click', () => this.nextPage());
        
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') this.prevPage();
            if (e.key === 'ArrowRight') this.nextPage();
        });
    }
    
    async loadBook() {
        try {
            this.showLoader();
            
            // Cargar el libro
            this.book = ePub(window.epubConfig.bookPath);
            
            // Configurar el renderizado
            this.rendition = this.book.renderTo(this.viewer, {
                width: '100%',
                height: '100%',
                spread: 'none',
                manager: 'continuous'
            });
            
            // Mostrar la primera página
            await this.rendition.display();
            
            // Configurar eventos
            this.rendition.on('relocated', (location) => {
                this.updatePageInfo(location);
            });
            
            this.hideLoader();
            
        } catch (error) {
            console.error('Error loading EPUB:', error);
            this.showError('No se pudo cargar el libro. Por favor, intente nuevamente.');
        }
    }
    
    async prevPage() {
        try {
            await this.rendition.prev();
        } catch (error) {
            console.error('Error navigating back:', error);
        }
    }
    
    async nextPage() {
        try {
            await this.rendition.next();
        } catch (error) {
            console.error('Error navigating forward:', error);
        }
    }
    
    updatePageInfo(location) {
        if (location && location.start) {
            const { cfi, percentage } = location.start;
            this.pageInfo.textContent = `Página ${Math.round(percentage * 100)}%`;
        }
    }
    
    showLoader() {
        this.loader.style.display = 'block';
        this.viewer.style.opacity = '0.5';
    }
    
    hideLoader() {
        this.loader.style.display = 'none';
        this.viewer.style.opacity = '1';
    }
    
    showError(message) {
        this.hideLoader();
        alert(message);
    }
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    new EPubReader();
});
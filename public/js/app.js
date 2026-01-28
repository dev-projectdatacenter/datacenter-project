/* ============================================
   CSS PERSONNALISÉ - APP.JS (JavaScript global)
   ============================================ */

// Variables globales
window.App = {
    // Configuration
    config: {
        apiBaseUrl: '/api',
        csrfToken: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
    },
    
    // Utilitaires
    utils: {},
    
    // Composants
    components: {},
    
    // État global
    state: {}
};

// Utilitaires
App.utils = {
    // Créer une requête fetch avec CSRF
    fetch: function(url, options = {}) {
        const defaultOptions = {
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': App.config.csrfToken
            }
        };
        
        return fetch(url, { ...defaultOptions, ...options });
    },
    
    // Afficher une notification
    showNotification: function(message, type = 'info') {
        // Créer l'élément de notification
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <span class="notification-icon">${this.getIcon(type)}</span>
            <span class="notification-message">${message}</span>
            <button class="notification-close" onclick="this.parentElement.remove()">×</button>
        `;
        
        // Ajouter au DOM
        document.body.appendChild(notification);
        
        // Animation d'entrée
        setTimeout(() => notification.classList.add('show'), 100);
        
        // Auto-suppression après 5 secondes
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        }, 5000);
    },
    
    // Obtenir l'icône selon le type
    getIcon: function(type) {
        const icons = {
            success: '✓',
            error: '✗',
            warning: '⚠️',
            info: 'ℹ️'
        };
        return icons[type] || icons.info;
    },
    
    // Débouncer
    debounce: function(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    },
    
    // Vérifier si un élément est visible
    isInViewport: function(element) {
        const rect = element.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }
};

// Composants réutilisables
App.components = {
    // Modal
    modal: {
        show: function(content, title = '') {
            const modal = document.createElement('div');
            modal.className = 'modal-overlay';
            modal.innerHTML = `
                <div class="modal">
                    <div class="modal-header">
                        <h3>${title}</h3>
                        <button class="modal-close" onclick="App.components.modal.hide()">×</button>
                    </div>
                    <div class="modal-body">
                        ${content}
                    </div>
                </div>
            `;
            
            document.body.appendChild(modal);
            setTimeout(() => modal.classList.add('show'), 100);
        },
        
        hide: function() {
            const modal = document.querySelector('.modal-overlay');
            if (modal) {
                modal.classList.remove('show');
                setTimeout(() => modal.remove(), 300);
            }
        }
    },
    
    // Dropdown
    dropdown: {
        toggle: function(trigger) {
            const dropdown = trigger.nextElementSibling;
            if (dropdown && dropdown.classList.contains('dropdown-menu')) {
                dropdown.classList.toggle('show');
                
                // Fermer les autres dropdowns
                document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                    if (menu !== dropdown) {
                        menu.classList.remove('show');
                    }
                });
            }
        },
        
        close: function() {
            document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                menu.classList.remove('show');
            });
        }
    }
};

// Initialisation quand le DOM est prêt
document.addEventListener('DOMContentLoaded', function() {
    // Fermer les dropdowns en cliquant ailleurs
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown-trigger')) {
            App.components.dropdown.close();
        }
    });
    
    // Gérer les touches Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            App.components.modal.hide();
            App.components.dropdown.close();
        }
    });
    
    // Initialiser les tooltips simples
    initializeTooltips();
});

// Initialiser les tooltips
function initializeTooltips() {
    const tooltipElements = document.querySelectorAll('[title]');
    
    tooltipElements.forEach(element => {
        element.addEventListener('mouseenter', function(e) {
            const title = this.getAttribute('title');
            this.removeAttribute('title'); // Éviter le tooltip natif
            
            const tooltip = document.createElement('div');
            tooltip.className = 'tooltip';
            tooltip.textContent = title;
            document.body.appendChild(tooltip);
            
            const rect = this.getBoundingClientRect();
            tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
            tooltip.style.top = rect.top - tooltip.offsetHeight - 5 + 'px';
            
            this.setAttribute('data-tooltip', title);
        });
        
        element.addEventListener('mouseleave', function() {
            const tooltip = document.querySelector('.tooltip');
            if (tooltip) {
                tooltip.remove();
            }
            this.setAttribute('title', this.getAttribute('data-tooltip'));
        });
    });
}

// Exporter pour utilisation globale
window.App = App;
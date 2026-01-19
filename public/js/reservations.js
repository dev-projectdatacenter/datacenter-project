/**
 * JAVASCRIPT PERSONNALISÉ - RÉSERVATIONS
 * Sans jQuery, Vanilla JS pur
 */

// Variables globales
let currentStep = 1;
const totalSteps = 3;

// Exécuter quand le DOM est chargé
document.addEventListener('DOMContentLoaded', function() {
    initializeReservationForm();
    initializeResourceSelector();
    initializeDateValidation();
    initializeAvailabilityCheck();
    initializeCharacterCounter();
    initializeSuggestionButtons();
    initializeStepNavigation();
    initializeFilters();
});

/**
 * Initialise le formulaire de réservation
 */
function initializeReservationForm() {
    const form = document.getElementById('reservationForm');
    if (!form) return;

    // Validation du formulaire avant soumission
    form.addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            return false;
        }
    });
}

/**
 * Initialise le sélecteur de ressources
 */
function initializeResourceSelector() {
    const resourceSelect = document.getElementById('resource_id');
    const resourceDetails = document.getElementById('resourceDetails');
    const resourceInfo = document.getElementById('resourceInfo');

    if (!resourceSelect) return;

    resourceSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        
        if (this.value) {
            // Afficher les détails de la ressource sélectionnée
            showResourceDetails(selectedOption);
        } else {
            // Cacher les détails
            if (resourceDetails) {
                resourceDetails.style.display = 'none';
            }
        }
    });
    
    // Au chargement, filtrer les ressources disponibles
    filterAvailableResources();
}

/**
 * Filtre les ressources disponibles au chargement
 */
function filterAvailableResources() {
    const resourceSelect = document.getElementById('resource_id');
    if (!resourceSelect) return;
    
    Array.from(resourceSelect.options).forEach(option => {
        if (option.value && option.dataset.status !== 'available') {
            option.style.display = 'none';
            option.disabled = true;
        }
    });
}

/**
 * Affiche les détails de la ressource sélectionnée
 */
function showResourceDetails(option) {
    const resourceDetails = document.getElementById('resourceDetails');
    const resourceInfo = document.getElementById('resourceInfo');
    
    if (!resourceDetails || !resourceInfo) return;

    const location = option.dataset.location || 'Non spécifiée';
    const category = option.dataset.category || 'Non spécifiée';
    const resourceName = option.textContent;

    const detailsHTML = `
        <div style="display: grid; gap: 10px;">
            <div><strong>Nom:</strong> ${resourceName}</div>
            <div><strong>Catégorie:</strong> ${category}</div>
            <div><strong>Emplacement:</strong> ${location}</div>
        </div>
    `;

    resourceInfo.innerHTML = detailsHTML;
    resourceDetails.style.display = 'block';
}

/**
 * Initialise la validation des dates
 */
function initializeDateValidation() {
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');

    if (!startDate || !endDate) return;

    // Définir la date minimale à maintenant
    const now = new Date();
    const localDateTime = new Date(now.getTime() - now.getTimezoneOffset() * 60000)
        .toISOString()
        .slice(0, 16);
    
    startDate.min = localDateTime;

    // Valider que la date de fin est après la date de début
    startDate.addEventListener('change', validateDates);
    endDate.addEventListener('change', validateDates);
}

/**
 * Valide les dates du formulaire
 */
function validateDates() {
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');

    if (!startDate || !endDate) return true;

    const start = new Date(startDate.value);
    const end = new Date(endDate.value);
    const now = new Date();

    // Vérifier que la date de début est dans le futur
    if (start <= now) {
        showError('La date de début doit être dans le futur.');
        return false;
    }

    // Vérifier que la date de fin est après la date de début
    if (end <= start) {
        showError('La date de fin doit être après la date de début.');
        return false;
    }

    hideError();
    return true;
}

/**
 * Initialise la vérification de disponibilité
 */
function initializeAvailabilityCheck() {
    const checkBtn = document.getElementById('checkAvailability');
    if (!checkBtn) return;

    checkBtn.addEventListener('click', checkAvailability);
}

/**
 * Vérifie la disponibilité d'une ressource
 */
async function checkAvailability() {
    const resourceId = document.getElementById('resource_id').value;
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    const resultDiv = document.getElementById('availabilityResult');

    if (!resourceId || !startDate || !endDate) {
        showError('Veuillez remplir tous les champs avant de vérifier la disponibilité.');
        return;
    }

    if (!validateDates()) {
        return;
    }

    // Afficher un indicateur de chargement
    const checkBtn = document.getElementById('checkAvailability');
    const originalText = checkBtn.innerHTML;
    checkBtn.innerHTML = '🔄 Vérification...';
    checkBtn.disabled = true;

    try {
        const response = await fetch(`/reservations/api/check-availability`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                               document.querySelector('input[name="_token"]')?.value
            },
            body: JSON.stringify({
                resource_id: resourceId,
                start_date: startDate,
                end_date: endDate
            })
        });

        const data = await response.json();
        
        if (resultDiv) {
            resultDiv.style.display = 'block';
            
            if (data.available) {
                resultDiv.className = 'availability-result available';
                resultDiv.innerHTML = '✅ La ressource est disponible pour cette période.';
            } else {
                resultDiv.className = 'availability-result unavailable';
                resultDiv.innerHTML = '❌ La ressource n\'est pas disponible pour cette période. Veuillez choisir d\'autres dates.';
            }
        }
    } catch (error) {
        console.error('Erreur lors de la vérification de disponibilité:', error);
        showError('Une erreur est survenue lors de la vérification de disponibilité.');
    } finally {
        // Restaurer le bouton
        checkBtn.innerHTML = originalText;
        checkBtn.disabled = false;
    }
}

/**
 * Initialise le compteur de caractères
 */
function initializeCharacterCounter() {
    const textarea = document.getElementById('justification');
    const counter = document.getElementById('charCount');

    if (!textarea || !counter) return;

    // Mettre à jour le compteur
    function updateCounter() {
        const length = textarea.value.length;
        counter.textContent = length;
        
        if (length > 1000) {
            counter.style.color = 'var(--danger-color)';
        } else if (length > 800) {
            counter.style.color = 'var(--warning-color)';
        } else {
            counter.style.color = 'var(--text-secondary)';
        }
    }

    textarea.addEventListener('input', updateCounter);
    textarea.addEventListener('paste', function() {
        setTimeout(updateCounter, 10);
    });

    // Initialiser
    updateCounter();
}

/**
 * Initialise les boutons de suggestion
 */
function initializeSuggestionButtons() {
    const suggestionBtns = document.querySelectorAll('.suggestion-btn');
    const textarea = document.getElementById('justification');

    if (!textarea) return;

    suggestionBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const text = this.dataset.text;
            textarea.value = text;
            textarea.focus();
            
            // Déclencher l'événement input pour mettre à jour le compteur
            textarea.dispatchEvent(new Event('input'));
        });
    });
}

/**
 * Initialise la navigation entre étapes
 */
function initializeStepNavigation() {
    const nextBtn = document.getElementById('nextStep');
    const prevBtn = document.getElementById('prevStep');
    const submitBtn = document.getElementById('submitForm');

    if (nextBtn) {
        nextBtn.addEventListener('click', nextStep);
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', prevStep);
    }

    if (submitBtn) {
        submitBtn.addEventListener('click', function() {
            if (validateForm()) {
                document.getElementById('reservationForm').submit();
            }
        });
    }

    // Afficher la première étape
    showStep(1);
}

/**
 * Affiche une étape spécifique
 */
function showStep(step) {
    // Cacher toutes les étapes
    for (let i = 1; i <= totalSteps; i++) {
        const stepElement = document.getElementById(`step${i}`);
        if (stepElement) {
            stepElement.style.display = i === step ? 'block' : 'none';
        }
    }

    // Mettre à jour les boutons de navigation
    updateNavigationButtons(step);
    currentStep = step;
}

/**
 * Met à jour les boutons de navigation
 */
function updateNavigationButtons(step) {
    const nextBtn = document.getElementById('nextStep');
    const prevBtn = document.getElementById('prevStep');
    const submitBtn = document.getElementById('submitForm');

    if (!nextBtn || !prevBtn || !submitBtn) return;

    // Bouton précédent
    prevBtn.style.display = step === 1 ? 'none' : 'inline-flex';

    // Boutons suivant/soumettre
    if (step === totalSteps) {
        nextBtn.style.display = 'none';
        submitBtn.style.display = 'inline-flex';
    } else {
        nextBtn.style.display = 'inline-flex';
        submitBtn.style.display = 'none';
    }
}

/**
 * Passe à l'étape suivante
 */
function nextStep() {
    if (validateCurrentStep()) {
        showStep(currentStep + 1);
    }
}

/**
 * Passe à l'étape précédente
 */
function prevStep() {
    showStep(currentStep - 1);
}

/**
 * Valide l'étape actuelle
 */
function validateCurrentStep() {
    switch (currentStep) {
        case 1:
            return validateStep1();
        case 2:
            return validateStep2();
        case 3:
            return validateStep3();
        default:
            return true;
    }
}

/**
 * Valide l'étape 1 (Ressource)
 */
function validateStep1() {
    const resourceId = document.getElementById('resource_id').value;
    
    if (!resourceId) {
        showError('Veuillez sélectionner une ressource.');
        return false;
    }

    hideError();
    return true;
}

/**
 * Valide l'étape 2 (Dates)
 */
function validateStep2() {
    return validateDates();
}

/**
 * Valide l'étape 3 (Justification)
 */
function validateStep3() {
    const justification = document.getElementById('justification').value;
    
    if (!justification.trim()) {
        showError('Veuillez fournir une justification pour votre demande.');
        return false;
    }

    if (justification.length < 10) {
        showError('La justification doit contenir au moins 10 caractères.');
        return false;
    }

    if (justification.length > 1000) {
        showError('La justification ne doit pas dépasser 1000 caractères.');
        return false;
    }

    hideError();
    return true;
}

/**
 * Valide le formulaire complet
 */
function validateForm() {
    return validateStep1() && validateStep2() && validateStep3();
}

/**
 * Initialise les filtres (page index)
 */
function initializeFilters() {
    const dateRangeInput = document.getElementById('date_range');
    
    if (dateRangeInput) {
        // Initialiser un date picker simple
        initializeDateRangePicker(dateRangeInput);
    }
}

/**
 * Initialise un sélecteur de plage de dates simple
 */
function initializeDateRangePicker(input) {
    input.addEventListener('focus', function() {
        this.placeholder = 'Format: JJ/MM/AAAA - JJ/MM/AAAA';
    });

    input.addEventListener('blur', function() {
        this.placeholder = 'JJ/MM/AAAA - JJ/MM/AAAA';
    });

    // Validation simple du format
    input.addEventListener('change', function() {
        const value = this.value.trim();
        const dateRangeRegex = /^\d{2}\/\d{2}\/\d{4}\s*-\s*\d{2}\/\d{2}\/\d{4}$/;
        
        if (value && !dateRangeRegex.test(value)) {
            showError('Format de date invalide. Utilisez: JJ/MM/AAAA - JJ/MM/AAAA');
            this.value = '';
        } else {
            hideError();
        }
    });
}

/**
 * Affiche un message d'erreur
 */
function showError(message) {
    // Créer ou mettre à jour l'alerte d'erreur
    let errorAlert = document.querySelector('.alert-error');
    
    if (!errorAlert) {
        errorAlert = document.createElement('div');
        errorAlert.className = 'alert alert-error';
        errorAlert.innerHTML = `
            <span class="alert-icon">⚠️</span>
            <div id="errorMessage">${message}</div>
        `;
        
        // Insérer au début du formulaire ou de la page
        const form = document.getElementById('reservationForm');
        const mainContent = document.querySelector('.main-content');
        
        if (form) {
            form.insertBefore(errorAlert, form.firstChild);
        } else if (mainContent) {
            mainContent.insertBefore(errorAlert, mainContent.firstChild);
        }
    } else {
        const errorMessage = document.getElementById('errorMessage');
        if (errorMessage) {
            errorMessage.textContent = message;
        }
    }

    // Faire défiler vers l'erreur
    errorAlert.scrollIntoView({ behavior: 'smooth', block: 'center' });
}

/**
 * Cache le message d'erreur
 */
function hideError() {
    const errorAlert = document.querySelector('.alert-error');
    if (errorAlert) {
        errorAlert.remove();
    }
}

/**
 * Utilitaires
 */
const Utils = {
    // Formater une date
    formatDate: function(date) {
        return new Date(date).toLocaleDateString('fr-FR', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    },

    // Débouncer pour les événements fréquents
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

    // Vérifier si un élément est visible dans le viewport
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

// Exporter pour utilisation globale si nécessaire
window.ReservationApp = {
    checkAvailability,
    validateForm,
    showStep,
    Utils
};

/**
 * tech-reservations.js
 * JavaScript pour la gestion des réservations techniques
 * Géré par HALIMA - Jour 6
 */

// Variables globales
// Plus besoin de selectedReservations - on utilise seulement les actions individuelles

// Initialisation
document.addEventListener('DOMContentLoaded', function() {
    // Initialiser seulement les listeners de formulaire individuels
    initializeFormListeners();
});

// Gérer les soumissions de formulaire
function initializeFormListeners() {
    const rejectForm = document.getElementById('rejectForm');
    if (rejectForm) {
        rejectForm.addEventListener('submit', function(e) {
            const reason = document.getElementById('rejection_reason').value.trim();
            
            if (!reason) {
                e.preventDefault();
                alert('Veuillez fournir une raison pour le refus.');
                return;
            }
            
            if (!confirm('Êtes-vous sûr de vouloir refuser cette réservation ?')) {
                e.preventDefault();
                return;
            }
        });
    }
}

// Approuver une réservation individuelle
window.approveReservation = function(reservationId) {
    if (!confirm('Êtes-vous sûr de vouloir approuver cette réservation ?')) {
        return;
    }
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/tech/reservations/${reservationId}/approve`;
    
    // Ajouter les tokens CSRF
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (csrfToken) {
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken.getAttribute('content');
        form.appendChild(csrfInput);
    }
    
    // Ajouter la méthode PUT
    const methodInput = document.createElement('input');
    methodInput.type = 'hidden';
    methodInput.name = '_method';
    methodInput.value = 'PUT';
    form.appendChild(methodInput);
    
    document.body.appendChild(form);
    form.submit();
}

// Afficher la modale de refus
window.showRejectModal = function(reservationId) {
    const modal = document.getElementById('rejectModal');
    const form = document.getElementById('rejectForm');
    
    if (!modal || !form) {
        console.error('Modal ou form non trouvé');
        return;
    }
    
    // Définir l'action du formulaire
    form.action = `/tech/reservations/${reservationId}/reject`;
    
    // Réinitialiser le formulaire
    form.reset();
    
    // Afficher la modale
    modal.style.display = 'block';
    
    // Mettre le focus sur le champ de raison
    setTimeout(() => {
        const reasonField = document.getElementById('rejection_reason');
        if (reasonField) {
            reasonField.focus();
        }
    }, 100);
}

// Fermer une modale
window.closeModal = function(modalId) {
    const modal = document.getElementById(modalId);
    modal.style.display = 'none';
}

// Fermer les modales en cliquant à l'extérieur
window.addEventListener('click', function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
    }
});

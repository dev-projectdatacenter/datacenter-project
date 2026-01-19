/**
 * tech-reservations.js
 * JavaScript pour la gestion des réservations techniques
 * Géré par HALIMA - Jour 6
 */

// Variables globales
let selectedReservations = new Set();

// Initialisation
document.addEventListener('DOMContentLoaded', function() {
    initializeEventListeners();
    updateSelectedCount();
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

    const bulkApproveForm = document.getElementById('bulkApproveForm');
    if (bulkApproveForm) {
        bulkApproveForm.addEventListener('submit', function(e) {
            if (!confirm(`Êtes-vous sûr de vouloir approuver ${selectedReservations.size} réservation(s) ?`)) {
                e.preventDefault();
                return;
            }
        });
    }

    const bulkRejectForm = document.getElementById('bulkRejectForm');
    if (bulkRejectForm) {
        bulkRejectForm.addEventListener('submit', function(e) {
            const reason = document.getElementById('bulk_rejection_reason').value.trim();
            
            if (!reason) {
                e.preventDefault();
                alert('Veuillez fournir une raison pour le refus.');
                return;
            }
            
            if (!confirm(`Êtes-vous sûr de vouloir refuser ${selectedReservations.size} réservation(s) ?`)) {
                e.preventDefault();
                return;
            }
        });
    }
}

// Initialiser les écouteurs d'événements
function initializeEventListeners() {
    // Écouter les changements sur les cases à cocher
    document.querySelectorAll('.reservation-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                selectedReservations.add(parseInt(this.value));
            } else {
                selectedReservations.delete(parseInt(this.value));
            }
            updateSelectedCount();
        });
    });

    // Initialiser les listeners de formulaire
    initializeFormListeners();
}

// Mettre à jour le compteur de sélections
function updateSelectedCount() {
    const count = selectedReservations.size;
    document.getElementById('selectedCount').textContent = count;
    
    // Activer/désactiver les boutons groupés
    const bulkApproveBtn = document.querySelector('button[onclick="showBulkApproveModal()"]');
    const bulkRejectBtn = document.querySelector('button[onclick="showBulkRejectModal()"]');
    
    if (count > 0) {
        bulkApproveBtn.disabled = false;
        bulkRejectBtn.disabled = false;
    } else {
        bulkApproveBtn.disabled = true;
        bulkRejectBtn.disabled = true;
    }
}

// Sélectionner/désélectionner tout
function toggleSelectAll() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.reservation-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
        const reservationId = parseInt(checkbox.value);
        
        if (selectAll.checked) {
            selectedReservations.add(reservationId);
        } else {
            selectedReservations.delete(reservationId);
        }
    });
    
    updateSelectedCount();
}

// Approuver une réservation individuelle
function approveReservation(reservationId) {
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
function showRejectModal(reservationId) {
    const modal = document.getElementById('rejectModal');
    const form = document.getElementById('rejectForm');
    
    // Définir l'action du formulaire
    form.action = `/tech/reservations/${reservationId}/reject`;
    
    // Réinitialiser le formulaire
    form.reset();
    
    // Afficher la modale
    modal.style.display = 'block';
}

// Afficher la modale d'approbation groupée
function showBulkApproveModal() {
    if (selectedReservations.size === 0) {
        alert('Veuillez sélectionner au moins une réservation.');
        return;
    }
    
    const modal = document.getElementById('bulkApproveModal');
    const form = document.getElementById('bulkApproveForm');
    
    // Mettre à jour le compteur
    document.getElementById('bulkApproveCount').textContent = selectedReservations.size;
    
    // Ajouter les réservations sélectionnées au formulaire
    form.action = '/tech/reservations/bulk-approve';
    
    // Supprimer les anciennes réservations
    const oldInputs = form.querySelectorAll('input[name="reservations[]"]');
    oldInputs.forEach(input => input.remove());
    
    // Ajouter les nouvelles réservations
    selectedReservations.forEach(reservationId => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'reservations[]';
        input.value = reservationId;
        form.appendChild(input);
    });
    
    // Afficher la modale
    modal.style.display = 'block';
}

// Afficher la modale de refus groupé
function showBulkRejectModal() {
    if (selectedReservations.size === 0) {
        alert('Veuillez sélectionner au moins une réservation.');
        return;
    }
    
    const modal = document.getElementById('bulkRejectModal');
    const form = document.getElementById('bulkRejectForm');
    
    // Mettre à jour le compteur
    document.getElementById('bulkRejectCount').textContent = selectedReservations.size;
    
    // Ajouter les réservations sélectionnées au formulaire
    form.action = '/tech/reservations/bulk-reject';
    
    // Supprimer les anciennes réservations
    const oldInputs = form.querySelectorAll('input[name="reservations[]"]');
    oldInputs.forEach(input => input.remove());
    
    // Ajouter les nouvelles réservations
    selectedReservations.forEach(reservationId => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'reservations[]';
        input.value = reservationId;
        form.appendChild(input);
    });
    
    // Réinitialiser le formulaire
    form.reset();
    
    // Afficher la modale
    modal.style.display = 'block';
}

// Afficher la justification complète
function showJustification(reservationId) {
    // Récupérer la justification complète (pour l'exemple, on utilise une donnée simulée)
    // En réalité, vous devriez faire un appel AJAX pour récupérer la justification
    const justifications = {
        // Exemples de justifications complètes
        1: "J'ai besoin de cette ressource pour un projet critique qui doit être livré la semaine prochaine. L'équipe de développement dépend de cette infrastructure pour tester les nouvelles fonctionnalités avant la mise en production.",
        2: "Formation prévue pour les nouveaux employés. Nous avons besoin d'un environnement stable pour les exercices pratiques et les démonstrations.",
        // Ajoutez d'autres justifications au besoin
    };
    
    const justification = justifications[reservationId] || "Justification non disponible.";
    
    document.getElementById('fullJustification').textContent = justification;
    
    const modal = document.getElementById('justificationModal');
    modal.style.display = 'block';
}

// Fermer une modale
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.style.display = 'none';
}

// Fermer les modales en cliquant à l'extérieur
window.addEventListener('click', function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
    }
});


// Fonction utilitaire pour afficher les messages
function showMessage(message, type = 'info') {
    // Créer un élément pour le message
    const messageDiv = document.createElement('div');
    messageDiv.className = `alert alert-${type}`;
    messageDiv.textContent = message;
    
    // Ajouter le message au début du contenu principal
    const mainContent = document.querySelector('.main-content');
    mainContent.insertBefore(messageDiv, mainContent.firstChild);
    
    // Supprimer le message après 5 secondes
    setTimeout(() => {
        messageDiv.remove();
    }, 5000);
}

// Fonction pour rafraîchir la liste des réservations
function refreshReservations() {
    window.location.reload();
}

// Fonction pour filtrer les réservations
function filterReservations() {
    const form = document.querySelector('.filter-form');
    const formData = new FormData(form);
    
    // Construire l'URL avec les paramètres de filtre
    const url = new URL(window.location);
    
    // Ajouter ou mettre à jour les paramètres
    for (const [key, value] of formData.entries()) {
        if (value) {
            url.searchParams.set(key, value);
        } else {
            url.searchParams.delete(key);
        }
    }
    
    // Rediriger vers l'URL filtrée
    window.location.href = url.toString();
}

// Ajouter des raccourcis clavier
document.addEventListener('keydown', function(e) {
    // Ctrl+A pour tout sélectionner
    if (e.ctrlKey && e.key === 'a') {
        e.preventDefault();
        document.getElementById('selectAll').click();
    }
    
    // Échap pour fermer les modales
    if (e.key === 'Escape') {
        document.querySelectorAll('.modal').forEach(modal => {
            if (modal.style.display === 'block') {
                modal.style.display = 'none';
            }
        });
    }
});

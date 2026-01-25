/*  Gestion complète (Dropdowns, Modals, Tabs, DatePicker) */

document.addEventListener('DOMContentLoaded', function() {
    console.log(' UI Engine Loaded');

    
    // 1. GESTION DES DROPDOWNS
 
    const dropdownTriggers = document.querySelectorAll('.dropdown-trigger');
    
    dropdownTriggers.forEach(trigger => {
        trigger.addEventListener('click', function(e) {
            e.stopPropagation();
            const targetId = this.getAttribute('data-target');
            const dropdown = document.getElementById(targetId);
            
            // Ferme les autres
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                if(menu.id !== targetId) menu.classList.add('hidden');
            });
            
            dropdown.classList.toggle('hidden');
        });
    });

    // Fermer au clic extérieur
    window.addEventListener('click', function() {
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            menu.classList.add('hidden');
        });
    });

    // 2. GESTION DES MODALES (Pop-ups)
   
      // Ouvrir une modale
    document.querySelectorAll('[data-modal-target]').forEach(button => {
        button.addEventListener('click', function() {
            const modalId = this.getAttribute('data-modal-target');
            const modal = document.getElementById(modalId);
            if(modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex'); // Pour centrer avec Flexbox
                document.body.style.overflow = 'hidden'; // Empêche le scroll derrière
            }
        });
    });

    // Fermer une modale (Bouton X ou Annuler)
    document.querySelectorAll('[data-modal-close]').forEach(button => {
        button.addEventListener('click', function() {
            const modal = this.closest('.modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto'; // Réactive le scroll
        });
    });

    // Fermer en cliquant en dehors (sur le fond gris)
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
                this.classList.remove('flex');
                document.body.style.overflow = 'auto';
            }
        });
    });

  
    // 3. GESTION DES TABS (Onglets)
    
    document.querySelectorAll('.tab-btn').forEach(button => {
        button.addEventListener('click', function() {
            // 1. Désactiver tous les onglets du groupe
            const container = this.closest('.tabs-container');
            container.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('border-blue-600', 'text-blue-600');
                btn.classList.add('border-transparent', 'text-gray-500');
            });

            // 2. Cacher tous les contenus
            container.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });

            // 3. Activer l'onglet cliqué
            this.classList.remove('border-transparent', 'text-gray-500');
            this.classList.add('border-blue-600', 'text-blue-600');

            // 4. Afficher le contenu lié
            const targetId = this.getAttribute('data-tab-target');
            document.getElementById(targetId).classList.remove('hidden');
        });
    });

    
    // 4. DATE PICKER INTELLIGENT
    
    // Empêche de sélectionner une date passée pour les réservations
    const dateInputs = document.querySelectorAll('.datepicker-future');
    if(dateInputs.length > 0) {
        const today = new Date().toISOString().split('T')[0];
        dateInputs.forEach(input => {
            input.setAttribute('min', today);
        });
    }
});
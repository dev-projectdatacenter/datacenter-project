<!-- Discussions de la ressource - ACCESSIBLE À TOUS -->
<div class="discussion-container">
    <div class="discussion-header">
        <h2 class="discussion-title">💬 Discussions</h2>
        <p class="discussion-subtitle">Posez des questions, partagez des informations et signalez des problèmes</p>
    </div>
    
    <!-- Formulaire d'ajout de message -->
    <div class="discussion-form">
        <form id="discussionForm">
            <div class="form-group">
                <label for="message" class="form-label">Votre message</label>
                <textarea id="message" class="form-textarea" 
                          placeholder="Posez une question, partagez une information ou signalez un problème..." 
                          required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">
                💬 Envoyer le message
            </button>
        </form>
    </div>
    
    <!-- Liste des messages -->
    <div class="messages-list" id="messagesList">
        <!-- Les messages seront chargés ici par JavaScript -->
    </div>
</div>

<!-- Modal de signalement -->
<div class="modal" id="reportModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">🚨 Signaler un message</h3>
            <button class="modal-close" onclick="hideReportModal()">&times;</button>
        </div>
        <div class="modal-body">
            <form id="reportForm">
                <input type="hidden" id="discussionId">
                <div class="form-group">
                    <label for="reason" class="form-label">Raison du signalement</label>
                    <select id="reason" class="form-select" required>
                        <option value="">Choisir une raison...</option>
                        <option value="spam">📢 Spam ou publicité</option>
                        <option value="inappropriate">⚠️ Contenu inapproprié</option>
                        <option value="hate">😠 Discours haineux</option>
                        <option value="offensive">🗣️ Langage offensant</option>
                        <option value="off-topic">❌ Hors sujet</option>
                        <option value="other">📝 Autre</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="description" class="form-label">Description (optionnel)</label>
                    <textarea id="description" class="form-textarea" rows="3" 
                              placeholder="Précisez la raison du signalement..."></textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline" onclick="hideReportModal()">Annuler</button>
            <button type="button" class="btn btn-danger" onclick="submitReport()">Signaler</button>
        </div>
    </div>
</div>

<!-- Inclure le CSS et JavaScript -->
<link rel="stylesheet" href="{{ asset('css/moderation.css') }}">
<script src="{{ asset('js/moderation.js') }}"></script>

<!-- CORRECTION DU TEXTAREA BLOQUÉ -->
<style>
/* Forcer le textarea à être cliquable et fonctionnel */
#message {
    pointer-events: auto !important;
    user-select: text !important;
    cursor: text !important;
    opacity: 1 !important;
    visibility: visible !important;
    display: block !important;
    z-index: 99999 !important;
    position: relative !important;
    background: white !important;
    color: #333 !important;
    border: 2px solid #e1e5e9 !important;
    outline: none !important;
}

/* Empêcher la perte de focus */
#message:focus {
    outline: 2px solid #667eea !important;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1) !important;
    z-index: 99999 !important;
}

/* S'assurer qu'aucun overlay ne bloque le textarea */
.discussion-form {
    position: relative;
    z-index: 10000;
}

/* Empêcher tout élément de se superposer */
.discussion-container {
    position: relative;
    z-index: 10000;
}

/* Désactiver tout événement qui pourrait voler le focus */
* {
    -webkit-user-select: text !important;
    -moz-user-select: text !important;
    -ms-user-select: text !important;
    user-select: text !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const resourceId = {{ $resource->id }};
    let discussions = [];
    
    // Charger les discussions existantes
    loadDiscussions();
    
    // CORRECTION DU TEXTAREA BLOQUÉ
    const textarea = document.getElementById('message');
    if (textarea) {
        console.log('Textarea trouvé:', textarea);
        
        // Forcer toutes les propriétés pour que le textarea fonctionne
        textarea.style.pointerEvents = 'auto';
        textarea.style.userSelect = 'text';
        textarea.style.cursor = 'text';
        textarea.style.opacity = '1';
        textarea.style.visibility = 'visible';
        textarea.style.display = 'block';
        textarea.style.zIndex = '99999';
        textarea.style.position = 'relative';
        textarea.style.background = 'white';
        textarea.style.color = '#333';
        
        // S'assurer qu'il n'est ni readonly ni disabled
        textarea.readOnly = false;
        textarea.disabled = false;
        textarea.removeAttribute('readonly');
        textarea.removeAttribute('disabled');
        
        // Forcer le focus plusieurs fois
        const forceFocus = () => {
            textarea.focus();
            console.log('Focus forcé sur textarea');
        };
        
        // Focus immédiat
        forceFocus();
        
        // Focus après 200ms
        setTimeout(forceFocus, 200);
        
        // Focus après 500ms
        setTimeout(forceFocus, 500);
        
        // Focus après 1000ms
        setTimeout(forceFocus, 1000);
        
        // Empêcher la perte de focus
        textarea.addEventListener('blur', function(e) {
            console.log('Perte de focus détectée, re-focus immédiat');
            e.preventDefault();
            e.stopPropagation();
            setTimeout(() => {
                textarea.focus();
            }, 10);
        });
        
        // Écouter les événements
        textarea.addEventListener('click', function(e) {
            console.log('Click sur textarea');
            e.preventDefault();
            e.stopPropagation();
            this.focus();
        });
        
        textarea.addEventListener('mousedown', function(e) {
            console.log('Mousedown sur textarea');
            e.preventDefault();
            e.stopPropagation();
            this.focus();
        });
        
        textarea.addEventListener('focus', function() {
            console.log('Focus sur textarea - MAINTENANT ÇA DEVRAIT RESTER');
        });
        
        textarea.addEventListener('input', function() {
            console.log('Texte tapé:', this.value);
        });
        
        // Empêcher tout autre élément de voler le focus
        document.addEventListener('click', function(e) {
            if (e.target !== textarea && !textarea.contains(e.target)) {
                console.log('Click ailleurs, mais on garde le focus sur textarea');
                setTimeout(() => {
                    textarea.focus();
                }, 10);
            }
        });
        
    } else {
        console.error('Textarea NON TROUVÉ !');
    }
    
    // Soumettre un nouveau message
    document.getElementById('discussionForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const messageInput = document.getElementById('message');
        const message = messageInput.value.trim();
        
        if (!message) {
            alert('Veuillez entrer un message.');
            return;
        }
        
        // Ajouter la discussion
        const discussion = window.moderationSystem.addDiscussion(resourceId, message);
        
        // Ajouter à l'affichage
        addMessageToList(discussion);
        
        // Vider le formulaire
        messageInput.value = '';
        
        // Afficher une confirmation
        window.moderationSystem.createAlert('✅ Message publié avec succès', 'success');
    });
    
    // Charger les discussions depuis le système
    function loadDiscussions() {
        discussions = window.moderationSystem.getDiscussions(resourceId);
        renderDiscussions();
    }
    
    // Afficher les discussions
    function renderDiscussions() {
        const messagesList = document.getElementById('messagesList');
        
        if (discussions.length === 0) {
            messagesList.innerHTML = `
                <div class="empty-state">
                    <h3>Aucune discussion</h3>
                    <p>Soyez le premier à poser une question !</p>
                </div>
            `;
            return;
        }
        
        messagesList.innerHTML = discussions.map(discussion => createMessageHTML(discussion)).join('');
    }
    
    // Créer le HTML d'un message
    function createMessageHTML(discussion) {
        const isOwnMessage = discussion.user_id === window.moderationSystem.currentUser.id;
        const statusClass = discussion.status === 'reported' ? 'message-reported' : 
                           discussion.status === 'hidden' ? 'message-hidden' : 
                           discussion.status === 'deleted' ? 'message-deleted' : '';
        
        const date = new Date(discussion.created_at).toLocaleString('fr-FR', {
            day: 'numeric',
            month: 'short',
            hour: '2-digit',
            minute: '2-digit'
        });
        
        return `
            <div class="message-item ${statusClass}" data-discussion-id="${discussion.id}">
                <div class="message-header">
                    <div>
                        <span class="message-author">${discussion.user_name}</span>
                        <span class="message-date">${date}</span>
                        ${discussion.status === 'reported' ? '<span class="badge badge-warning">Signalé</span>' : ''}
                        ${discussion.status === 'hidden' ? '<span class="badge badge-danger">Caché</span>' : ''}
                        ${discussion.status === 'deleted' ? '<span class="badge badge-danger">Supprimé</span>' : ''}
                    </div>
                    <div class="message-actions">
                        ${!isOwnMessage ? `
                            <button class="btn btn-sm btn-outline" onclick="showReportModal(${discussion.id})">
                                🚨 Signaler
                            </button>
                        ` : ''}
                        ${window.moderationSystem.canModerate(discussion) && discussion.status === 'normal' ? `
                            <button class="btn btn-sm btn-warning" onclick="hideMessage(${discussion.id})">
                                👁️ Cacher
                            </button>
                        ` : ''}
                        ${window.moderationSystem.canModerate(discussion) && discussion.status === 'reported' ? `
                            <button class="btn btn-sm btn-warning" onclick="restoreMessage(${discussion.id})">
                                ↩️ Restaurer
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="deleteMessage(${discussion.id})">
                                🗑️ Supprimer
                            </button>
                        ` : ''}
                    </div>
                </div>
                <div class="message-content">
                    <p>${discussion.message}</p>
                    ${discussion.report_reason ? `
                        <small><strong>Raison du signalement:</strong> ${discussion.report_reason}</small>
                    ` : ''}
                    ${discussion.reported_by_name ? `
                        <small><strong>Signalé par:</strong> ${discussion.reported_by_name}</small>
                    ` : ''}
                </div>
            </div>
        `;
    }
    
    // Ajouter un message à la liste
    function addMessageToList(discussion) {
        const messagesList = document.getElementById('messagesList');
        const messageHTML = createMessageHTML(discussion);
        
        // Insérer au début de la liste
        messagesList.insertAdjacentHTML('afterbegin', messageHTML);
        
        // Mettre à jour le compteur de discussions
        updateDiscussionCount();
    }
    
    // Mettre à jour le compteur de discussions
    function updateDiscussionCount() {
        const count = discussions.filter(d => d.status === 'normal').length;
        const countElement = document.getElementById('discussion-count');
        if (countElement) {
            countElement.textContent = count;
        }
    }
    
    // Afficher la modal de signalement
    function showReportModal(discussionId) {
        document.getElementById('discussionId').value = discussionId;
        const modal = document.getElementById('reportModal');
        modal.classList.add('show');
        document.getElementById('reason').focus();
    }
    
    // Cacher la modal de signalement
    function hideReportModal() {
        const modal = document.getElementById('reportModal');
        modal.classList.remove('show');
        document.getElementById('reportForm').reset();
    }
    
    // Soumettre le signalement
    function submitReport() {
        const discussionId = document.getElementById('discussionId').value;
        const reason = document.getElementById('reason').value;
        const description = document.getElementById('description').value;
        
        if (!reason) {
            alert('Veuillez choisir une raison.');
            return;
        }
        
        const reportReason = description ? `${reason}: ${description}` : reason;
        
        if (window.moderationSystem.reportDiscussion(resourceId, discussionId, reportReason)) {
            hideReportModal();
            window.moderationSystem.createAlert('🚨 Message signalé avec succès', 'warning');
            loadDiscussions(); // Recharger les discussions
        } else {
            alert('Erreur lors du signalement.');
        }
    }
    
    // Cacher un message
    function hideMessage(discussionId) {
        if (confirm('Êtes-vous sûr de vouloir cacher ce message ?')) {
            if (window.moderationSystem.hideDiscussion(resourceId, discussionId)) {
                window.moderationSystem.createAlert('👁️ Message caché avec succès', 'success');
                loadDiscussions();
            } else {
                alert('Erreur lors du masquage du message.');
            }
        }
    }
    
    // Supprimer un message
    function deleteMessage(discussionId) {
        if (confirm('Êtes-vous sûr de vouloir supprimer ce message ? Cette action est irréversible.')) {
            if (window.moderationSystem.deleteDiscussion(resourceId, discussionId)) {
                window.moderationSystem.createAlert('🗑️ Message supprimé avec succès', 'success');
                loadDiscussions();
            } else {
                alert('Erreur lors de la suppression du message.');
            }
        }
    }
    
    // Restaurer un message
    function restoreMessage(discussionId) {
        if (window.moderationSystem.restoreDiscussion(resourceId, discussionId)) {
            window.moderationSystem.createAlert('↩️ Message restauré avec succès', 'success');
            loadDiscussions();
        } else {
            alert('Erreur lors de la restauration du message.');
        }
    }
    
    // Fermer la modal si on clique en dehors
    document.getElementById('reportModal').addEventListener('click', function(e) {
        if (e.target === this) {
            hideReportModal();
        }
    });
    
    // Rendre les fonctions disponibles globalement
    window.showReportModal = showReportModal;
    window.hideReportModal = hideReportModal;
    window.submitReport = submitReport;
    window.hideMessage = hideMessage;
    window.deleteMessage = deleteMessage;
    window.restoreMessage = restoreMessage;
    window.addMessageToList = addMessageToList;
    window.updateDiscussionCount = updateDiscussionCount;
    window.loadDiscussions = loadDiscussions;
    window.renderDiscussions = renderDiscussions;
    window.createMessageHTML = createMessageHTML;
    window.showReportModal = showReportModal;
});
</script>

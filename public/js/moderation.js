/**
 * Système de modération sans base de données
 * Utilise localStorage pour stocker les discussions
 */

class ModerationSystem {
    constructor() {
        this.discussions = this.loadDiscussions();
        this.currentUser = null;
        this.init();
    }

    init() {
        // Charger les informations de l'utilisateur depuis la page
        const userInfo = document.querySelector('meta[name="user-info"]');
        if (userInfo) {
            this.currentUser = JSON.parse(userInfo.getAttribute('content'));
        }
    }

    // Charger les discussions depuis localStorage
    loadDiscussions() {
        const stored = localStorage.getItem('resource_discussions');
        return stored ? JSON.parse(stored) : {};
    }

    // Sauvegarder les discussions dans localStorage
    saveDiscussions() {
        localStorage.setItem('resource_discussions', JSON.stringify(this.discussions));
    }

    // Ajouter une discussion
    addDiscussion(resourceId, message) {
        if (!this.discussions[resourceId]) {
            this.discussions[resourceId] = [];
        }

        const discussion = {
            id: Date.now(),
            resource_id: parseInt(resourceId),
            user_id: this.currentUser.id,
            user_name: this.currentUser.name,
            message: message,
            status: 'normal',
            created_at: new Date().toISOString(),
            reported_by: null,
            report_reason: null,
            moderated_at: null,
            moderated_by: null
        };

        this.discussions[resourceId].unshift(discussion);
        this.saveDiscussions();
        
        return discussion;
    }

    // Signaler une discussion
    reportDiscussion(resourceId, discussionId, reason) {
        const discussion = this.findDiscussion(resourceId, discussionId);
        if (discussion) {
            discussion.status = 'reported';
            discussion.reported_by = this.currentUser.id;
            discussion.reported_by_name = this.currentUser.name;
            discussion.report_reason = reason;
            discussion.reported_at = new Date().toISOString();
            
            this.saveDiscussions();
            this.notifyModerators(resourceId, discussion);
            
            return true;
        }
        return false;
    }

    // Cacher une discussion
    hideDiscussion(resourceId, discussionId) {
        const discussion = this.findDiscussion(resourceId, discussionId);
        if (discussion && this.canModerate(discussion)) {
            discussion.status = 'hidden';
            discussion.moderated_by = this.currentUser.id;
            discussion.moderated_by_name = this.currentUser.name;
            discussion.moderated_at = new Date().toISOString();
            
            this.saveDiscussions();
            this.notifyAuthor(discussion, 'hidden');
            
            return true;
        }
        return false;
    }

    // Supprimer une discussion
    deleteDiscussion(resourceId, discussionId) {
        const discussion = this.findDiscussion(resourceId, discussionId);
        if (discussion && this.canModerate(discussion)) {
            discussion.status = 'deleted';
            discussion.moderated_by = this.currentUser.id;
            discussion.moderated_by_name = this.currentUser.name;
            discussion.moderated_at = new Date().toISOString();
            
            this.saveDiscussions();
            this.notifyAuthor(discussion, 'deleted');
            
            return true;
        }
        return false;
    }

    // Restaurer une discussion
    restoreDiscussion(resourceId, discussionId) {
        const discussion = this.findDiscussion(resourceId, discussionId);
        if (discussion && this.canModerate(discussion)) {
            discussion.status = 'normal';
            discussion.reported_by = null;
            discussion.report_reason = null;
            discussion.moderated_at = null;
            discussion.moderated_by = null;
            
            this.saveDiscussions();
            return true;
        }
        return false;
    }

    // Trouver une discussion
    findDiscussion(resourceId, discussionId) {
        if (!this.discussions[resourceId]) return null;
        return this.discussions[resourceId].find(d => d.id === parseInt(discussionId));
    }

    // Vérifier si l'utilisateur peut modérer
    canModerate(discussion) {
        if (!this.currentUser) return false;
        
        // Admin peut tout modérer
        if (this.currentUser.role === 'admin') return true;
        
        // Tech manager peut modérer
        if (this.currentUser.role === 'tech_manager') return true;
        
        // Le propriétaire de la ressource peut modérer
        // (cette vérification se fait côté serveur)
        return true;
    }

    // Obtenir les discussions pour une ressource
    getDiscussions(resourceId, includeHidden = false) {
        if (!this.discussions[resourceId]) return [];
        
        let discussions = this.discussions[resourceId];
        
        if (!includeHidden) {
            discussions = discussions.filter(d => d.status === 'normal' || d.status === 'reported');
        }
        
        return discussions.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
    }

    // Obtenir les discussions signalées
    getReportedDiscussions() {
        const reported = [];
        
        Object.keys(this.discussions).forEach(resourceId => {
            this.discussions[resourceId].forEach(discussion => {
                if (discussion.status === 'reported') {
                    discussion.resource_id = parseInt(resourceId);
                    reported.push(discussion);
                }
            });
        });
        
        return reported.sort((a, b) => new Date(b.reported_at) - new Date(a.reported_at));
    }

    // Obtenir les statistiques
    getStats() {
        const stats = {
            total: 0,
            normal: 0,
            reported: 0,
            hidden: 0,
            deleted: 0
        };

        Object.keys(this.discussions).forEach(resourceId => {
            this.discussions[resourceId].forEach(discussion => {
                stats.total++;
                stats[discussion.status]++;
            });
        });

        return stats;
    }

    // Notifier les modérateurs (simulation)
    notifyModerators(resourceId, discussion) {
        // Créer une alerte dans l'interface
        this.createAlert(`🚨 Message signalé sur la ressource ${resourceId}`, 'warning');
        
        // Ajouter à la liste des notifications
        this.addNotification({
            type: 'warning',
            title: 'Message signalé',
            message: `Un message sur la ressource ${resourceId} a été signalé par ${discussion.reported_by_name}`,
            discussion_id: discussion.id,
            resource_id: resourceId
        });
    }

    // Notifier l'auteur
    notifyAuthor(discussion, action) {
        const actionText = action === 'hidden' ? 'caché' : 'supprimé';
        
        // Créer une alerte dans l'interface
        this.createAlert(`Message ${actionText}`, 'info');
        
        // Ajouter à la liste des notifications
        this.addNotification({
            type: 'error',
            title: `Message ${actionText}`,
            message: `Votre message a été ${actionText} par un modérateur.`,
            discussion_id: discussion.id
        });
    }

    // Créer une alerte dans l'interface
    createAlert(message, type = 'info') {
        // Créer une alerte temporaire
        const alert = document.createElement('div');
        alert.className = `alert alert-${type}`;
        alert.innerHTML = `
            <span class="alert-icon">${this.getAlertIcon(type)}</span>
            <span class="alert-message">${message}</span>
            <button class="alert-close" onclick="this.parentElement.remove()">×</button>
        `;
        
        // Ajouter au début du body
        document.body.insertBefore(alert, document.body.firstChild);
        
        // Supprimer automatiquement après 5 secondes
        setTimeout(() => {
            if (alert.parentElement) {
                alert.remove();
            }
        }, 5000);
    }

    // Ajouter une notification
    addNotification(notification) {
        // Récupérer les notifications existantes
        let notifications = JSON.parse(localStorage.getItem('moderation_notifications') || '[]');
        
        // Ajouter la nouvelle notification
        notification.id = Date.now();
        notification.created_at = new Date().toISOString();
        notification.read = false;
        
        notifications.unshift(notification);
        
        // Limiter à 50 notifications
        notifications = notifications.slice(0, 50);
        
        // Sauvegarder
        localStorage.setItem('moderation_notifications', JSON.stringify(notifications));
        
        // Mettre à jour le compteur
        this.updateNotificationBadge();
    }

    // Mettre à jour le badge de notifications
    updateNotificationBadge() {
        const notifications = JSON.parse(localStorage.getItem('moderation_notifications') || '[]');
        const unreadCount = notifications.filter(n => !n.read).length;
        
        const badge = document.getElementById('moderation-badge');
        if (badge) {
            if (unreadCount > 0) {
                badge.textContent = unreadCount > 99 ? '99+' : unreadCount;
                badge.style.display = 'inline-block';
            } else {
                badge.style.display = 'none';
            }
        }
    }

    // Obtenir l'icône pour le type d'alerte
    getAlertIcon(type) {
        const icons = {
            'info': 'ℹ️',
            'success': '✅',
            'warning': '⚠️',
            'error': '❌'
        };
        return icons[type] || 'ℹ️';
    }
}

// Initialiser le système
window.moderationSystem = new ModerationSystem();

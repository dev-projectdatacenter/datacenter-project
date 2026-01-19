/**
 * notifications-pure.js
 * JavaScript pur pour le système de notifications - SANS JQUERY
 * Géré par HALIMA - Jour 7 (CORRECTION)
 * CONTRAINTES: JavaScript pur (sans jQuery, Bootstrap, Tailwind)
 */

// Variables globales
let notificationPollingInterval = null;
let lastNotificationCount = 0;
let selectedNotifications = new Set();

// Initialisation au chargement du DOM
document.addEventListener('DOMContentLoaded', function() {
    initializeNotifications();
    startNotificationPolling();
    initializeEventListeners();
    updateNotificationBadge();
});

// Initialiser le système de notifications
function initializeNotifications() {
    // Créer le conteneur de toast si nécessaire
    if (!document.getElementById('toast-container')) {
        const container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'toast-container';
        document.body.appendChild(container);
    }
    
    // Masquer le message flash après 5 secondes
    const flashMessage = document.getElementById('flash-message');
    if (flashMessage) {
        setTimeout(function() {
            flashMessage.style.display = 'none';
        }, 5000);
    }
}

// Initialiser les écouteurs d'événements
function initializeEventListeners() {
    // Écouter les clics sur les notifications pour marquer comme lues
    const notificationItems = document.querySelectorAll('.notification-item.unread');
    notificationItems.forEach(function(item) {
        item.addEventListener('click', function(e) {
            // Ne pas marquer comme lu si on clique sur un bouton
            if (e.target.tagName === 'BUTTON' || e.target.tagName === 'INPUT') {
                return;
            }
            
            const notificationId = this.getAttribute('data-notification-id');
            markAsRead(notificationId);
        });
    });
    
    // Écouter les changements sur les cases à cocher
    const checkboxes = document.querySelectorAll('.notification-select');
    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', updateBulkActions);
    });
}

// Démarrer le polling des notifications
function startNotificationPolling() {
    // Arrêter le polling existant
    if (notificationPollingInterval) {
        clearInterval(notificationPollingInterval);
    }
    
    // Démarrer le polling toutes les 30 secondes
    notificationPollingInterval = setInterval(function() {
        checkForNewNotifications();
    }, 30000);
    
    // Vérifier immédiatement au chargement
    checkForNewNotifications();
}

// Vérifier les nouvelles notifications
function checkForNewNotifications() {
    fetch('/notifications/api/unread-count', {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': getCsrfToken(),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(function(response) {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(function(data) {
        const currentCount = data.count || 0;
        
        // Si de nouvelles notifications sont arrivées
        if (currentCount > lastNotificationCount && lastNotificationCount > 0) {
            const newCount = currentCount - lastNotificationCount;
            showNotificationAlert(newCount);
            playNotificationSound();
        }
        
        lastNotificationCount = currentCount;
        updateNotificationBadge(currentCount);
    })
    .catch(function(error) {
        console.error('Erreur lors de la vérification des notifications:', error);
    });
}

// Obtenir le token CSRF
function getCsrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : '';
}

// Mettre à jour le badge de notifications
function updateNotificationBadge(count) {
    if (count === undefined) {
        // Récupérer le compteur actuel via API
        fetch('/notifications/api/unread-count', {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': getCsrfToken(),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            updateBadgeDisplay(data.count || 0);
        })
        .catch(function(error) {
            console.error('Erreur lors de la récupération du compteur:', error);
        });
    } else {
        updateBadgeDisplay(count);
    }
}

// Mettre à jour l'affichage du badge
function updateBadgeDisplay(count) {
    const badge = document.getElementById('notification-badge');
    
    if (badge) {
        if (count > 0) {
            badge.textContent = count > 99 ? '99+' : count;
            badge.style.display = 'inline-block';
        } else {
            badge.style.display = 'none';
        }
    }
}

// Afficher une alerte de nouvelles notifications
function showNotificationAlert(count) {
    const message = count === 1 ? '1 nouvelle notification' : count + ' nouvelles notifications';
    
    // Créer une notification toast
    const toast = document.createElement('div');
    toast.className = 'toast toast-info';
    toast.innerHTML = `
        <div class="toast-content">
            <span class="toast-icon">🔔</span>
            <span class="toast-message">${message}</span>
            <button class="toast-close" onclick="this.parentElement.parentElement.remove()">×</button>
        </div>
    `;
    
    // Ajouter au conteneur
    const container = document.getElementById('toast-container');
    container.appendChild(toast);
    
    // Animation d'entrée
    setTimeout(function() {
        toast.classList.add('show');
    }, 100);
    
    // Supprimer automatiquement après 5 secondes
    setTimeout(function() {
        toast.classList.add('hide');
        setTimeout(function() {
            if (toast.parentElement) {
                toast.remove();
            }
        }, 300);
    }, 5000);
    
    // Clic pour fermer
    toast.addEventListener('click', function() {
        toast.classList.add('hide');
        setTimeout(function() {
            if (toast.parentElement) {
                toast.remove();
            }
        }, 300);
    });
}

// Jouer un son de notification
function playNotificationSound() {
    try {
        // Créer un son simple avec l'API Web Audio
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
        const oscillator = audioContext.createOscillator();
        const gainNode = audioContext.createGain();
        
        oscillator.connect(gainNode);
        gainNode.connect(audioContext.destination);
        
        oscillator.frequency.value = 800;
        oscillator.type = 'sine';
        
        gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
        gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.5);
        
        oscillator.start(audioContext.currentTime);
        oscillator.stop(audioContext.currentTime + 0.5);
    } catch (error) {
        console.error('Erreur lors de la lecture du son:', error);
    }
}

// Marquer une notification comme lue
function markAsRead(notificationId) {
    fetch('/notifications/' + notificationId + '/read', {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': getCsrfToken(),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(function(response) {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(function(data) {
        if (data.success) {
            // Mettre à jour l'interface
            const notificationItem = document.querySelector('[data-notification-id="' + notificationId + '"]');
            if (notificationItem) {
                notificationItem.classList.remove('unread');
                notificationItem.classList.add('read');
                
                // Mettre à jour le badge
                updateNotificationBadge();
                
                // Afficher un message de succès
                showToast('Notification marquée comme lue', 'success');
            }
        }
    })
    .catch(function(error) {
        console.error('Erreur lors du marquage comme lu:', error);
        showToast('Erreur lors du marquage comme lu', 'error');
    });
}

// Supprimer une notification
function deleteNotification(notificationId) {
    if (!confirm('Êtes-vous sûr de vouloir supprimer cette notification ?')) {
        return;
    }
    
    fetch('/notifications/' + notificationId, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': getCsrfToken(),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(function(response) {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(function(data) {
        if (data.success) {
            // Supprimer l'élément de l'interface
            const notificationItem = document.querySelector('[data-notification-id="' + notificationId + '"]');
            if (notificationItem) {
                notificationItem.style.transition = 'opacity 0.3s, transform 0.3s';
                notificationItem.style.opacity = '0';
                notificationItem.style.transform = 'translateX(-100%)';
                
                setTimeout(function() {
                    notificationItem.remove();
                    updateNotificationBadge();
                    showToast('Notification supprimée avec succès', 'success');
                }, 300);
            }
        }
    })
    .catch(function(error) {
        console.error('Erreur lors de la suppression:', error);
        showToast('Erreur lors de la suppression', 'error');
    });
}

// Marquer toutes les notifications comme lues
function markAllAsRead() {
    fetch('/notifications/mark-all-read', {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': getCsrfToken(),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(function(response) {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(function(data) {
        if (data.success) {
            // Mettre à jour l'interface
            const unreadItems = document.querySelectorAll('.notification-item.unread');
            unreadItems.forEach(function(item) {
                item.classList.remove('unread');
                item.classList.add('read');
            });
            
            // Mettre à jour le badge
            updateNotificationBadge();
            
            // Afficher un message de succès
            showToast('Toutes les notifications ont été marquées comme lues', 'success');
        }
    })
    .catch(function(error) {
        console.error('Erreur lors du marquage global comme lu:', error);
        showToast('Erreur lors du marquage comme lu', 'error');
    });
}

// Mettre à jour les actions groupées
function updateBulkActions() {
    const checkboxes = document.querySelectorAll('.notification-select:checked');
    const count = checkboxes.length;
    
    // Mettre à jour le compteur
    const selectedCount = document.getElementById('selected-count');
    if (selectedCount) {
        selectedCount.textContent = count;
    }
    
    // Afficher/masquer le panneau d'actions groupées
    const bulkActions = document.getElementById('bulk-actions');
    if (bulkActions) {
        bulkActions.style.display = count > 0 ? 'block' : 'none';
    }
    
    // Mettre à jour la sélection
    selectedNotifications.clear();
    checkboxes.forEach(function(checkbox) {
        selectedNotifications.add(parseInt(checkbox.value));
    });
}

// Marquer les notifications sélectionnées comme lues
function markSelectedAsRead() {
    if (selectedNotifications.size === 0) {
        showToast('Veuillez sélectionner au moins une notification', 'warning');
        return;
    }
    
    const notificationIds = Array.from(selectedNotifications);
    
    fetch('/notifications/mark-multiple-read', {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': getCsrfToken(),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            notification_ids: notificationIds
        })
    })
    .then(function(response) {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(function(data) {
        if (data.success) {
            // Mettre à jour l'interface
            notificationIds.forEach(function(id) {
                const item = document.querySelector('[data-notification-id="' + id + '"]');
                if (item) {
                    item.classList.remove('unread');
                    item.classList.add('read');
                    const checkbox = item.querySelector('.notification-select');
                    if (checkbox) {
                        checkbox.checked = false;
                    }
                }
            });
            
            clearSelection();
            updateNotificationBadge();
            showToast(data.updated + ' notification(s) marquée(s) comme lue(s)', 'success');
        }
    })
    .catch(function(error) {
        console.error('Erreur lors du marquage groupé:', error);
        showToast('Erreur lors du marquage comme lu', 'error');
    });
}

// Supprimer les notifications sélectionnées
function deleteSelected() {
    if (selectedNotifications.size === 0) {
        showToast('Veuillez sélectionner au moins une notification', 'warning');
        return;
    }
    
    if (!confirm('Êtes-vous sûr de vouloir supprimer les ' + selectedNotifications.size + ' notification(s) sélectionnée(s) ?')) {
        return;
    }
    
    const notificationIds = Array.from(selectedNotifications);
    
    fetch('/notifications/delete-multiple', {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': getCsrfToken(),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            notification_ids: notificationIds
        })
    })
    .then(function(response) {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(function(data) {
        if (data.success) {
            // Supprimer les éléments de l'interface
            notificationIds.forEach(function(id) {
                const item = document.querySelector('[data-notification-id="' + id + '"]');
                if (item) {
                    item.style.transition = 'opacity 0.3s, transform 0.3s';
                    item.style.opacity = '0';
                    item.style.transform = 'translateX(-100%)';
                    
                    setTimeout(function() {
                        item.remove();
                    }, 300);
                }
            });
            
            clearSelection();
            updateNotificationBadge();
            showToast(data.deleted + ' notification(s) supprimée(s) avec succès', 'success');
        }
    })
    .catch(function(error) {
        console.error('Erreur lors de la suppression groupée:', error);
        showToast('Erreur lors de la suppression', 'error');
    });
}

// Effacer la sélection
function clearSelection() {
    const checkboxes = document.querySelectorAll('.notification-select');
    checkboxes.forEach(function(checkbox) {
        checkbox.checked = false;
    });
    
    selectedNotifications.clear();
    updateBulkActions();
}

// Afficher un message toast
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = 'toast toast-' + type;
    toast.innerHTML = `
        <div class="toast-content">
            <span class="toast-icon">${getToastIcon(type)}</span>
            <span class="toast-message">${message}</span>
            <button class="toast-close" onclick="this.parentElement.parentElement.remove()">×</button>
        </div>
    `;
    
    const container = document.getElementById('toast-container');
    container.appendChild(toast);
    
    setTimeout(function() {
        toast.classList.add('show');
    }, 100);
    
    setTimeout(function() {
        toast.classList.add('hide');
        setTimeout(function() {
            if (toast.parentElement) {
                toast.remove();
            }
        }, 300);
    }, 3000);
}

// Obtenir l'icône pour le toast
function getToastIcon(type) {
    const icons = {
        'success': '✅',
        'error': '❌',
        'warning': '⚠️',
        'info': 'ℹ️'
    };
    return icons[type] || 'ℹ️';
}

// Gérer la visibilité de la page pour optimiser le polling
document.addEventListener('visibilitychange', function() {
    if (document.hidden) {
        // Mettre en pause le polling quand la page n'est pas visible
        if (notificationPollingInterval) {
            clearInterval(notificationPollingInterval);
            notificationPollingInterval = null;
        }
    } else {
        // Reprendre le polling quand la page redevient visible
        startNotificationPolling();
    }
});

// Nettoyer lors du déchargement de la page
window.addEventListener('beforeunload', function() {
    if (notificationPollingInterval) {
        clearInterval(notificationPollingInterval);
    }
});

// Fonctions utilitaires exportées pour l'utilisation globale
window.NotificationManager = {
    updateBadge: updateNotificationBadge,
    markAsRead: markAsRead,
    delete: deleteNotification,
    markAllAsRead: markAllAsRead,
    showToast: showToast,
    clearSelection: clearSelection
};

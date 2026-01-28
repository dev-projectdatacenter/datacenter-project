@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="user-info" content='{{ json_encode([
    'id' => auth()->id(),
    'name' => auth()->user()->name,
    'role' => auth()->user()->role->name ?? 'guest'
]) }}'>

<div class="container">
    <div class="page-header">
        <h1>🚨 Tableau de bord de modération</h1>
    </div>

    <!-- Statistiques -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">💬</div>
            <div class="stat-content">
                <h3 id="total-discussions">0</h3>
                <p>Total des messages</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon warning">🚨</div>
            <div class="stat-content">
                <h3 id="reported-discussions">0</h3>
                <p>Messages signalés</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon info">👁️</div>
            <div class="stat-content">
                <h3 id="hidden-discussions">0</h3>
                <p>Messages cachés</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon danger">🗑️</div>
            <div class="stat-content">
                <h3 id="deleted-discussions">0</h3>
                <p>Messages supprimés</p>
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="actions-grid">
        <div class="action-card">
            <h3>🚨 Messages signalés</h3>
            <p>Consultez et modérez les messages signalés par les utilisateurs</p>
            <button onclick="showReportedDiscussions()" class="btn btn-primary">
                Voir les messages signalés
            </button>
        </div>
        
        <div class="action-card">
            <h3>📊 Gérer les ressources</h3>
            <p>Accédez à la gestion des ressources et leurs discussions</p>
            <a href="{{ route('resources.index') }}" class="btn btn-outline">
                Gérer les ressources
            </a>
        </div>
    </div>

    <!-- Messages signalés -->
    <div id="reported-discussions-section" style="display: none;">
        <h2>🚨 Messages signalés</h2>
        <div id="reported-list">
            <!-- Les messages signalés seront chargés ici -->
        </div>
    </div>

    <!-- Liste des notifications -->
    <div class="notifications-section">
        <h2>📢 Notifications récentes</h2>
        <div id="notifications-list">
            <!-- Les notifications seront chargées ici -->
        </div>
    </div>
</div>

<!-- Inclure le CSS et JavaScript -->
<link rel="stylesheet" href="{{ asset('css/moderation.css') }}">
<script src="{{ asset('js/moderation.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Charger les statistiques
    loadStats();
    
    // Charger les notifications
    loadNotifications();
    
    // Rafraîchir toutes les 30 secondes
    setInterval(() => {
        loadStats();
        loadNotifications();
    }, 30000);
});

function loadStats() {
    const stats = window.moderationSystem.getStats();
    
    document.getElementById('total-discussions').textContent = stats.total;
    document.getElementById('reported-discussions').textContent = stats.reported;
    document.getElementById('hidden-discussions').textContent = stats.hidden;
    document.getElementById('deleted-discussions').textContent = stats.deleted;
}

function loadNotifications() {
    const notifications = JSON.parse(localStorage.getItem('moderation_notifications') || '[]');
    const notificationsList = document.getElementById('notifications-list');
    
    if (notifications.length === 0) {
        notificationsList.innerHTML = '<div class="empty-state"><p>Aucune notification récente.</p></div>';
        return;
    }
    
    notificationsList.innerHTML = notifications.slice(0, 10).map(notification => `
        <div class="notification-item ${notification.read ? 'read' : 'unread'}">
            <div class="notification-header">
                <span class="notification-type">${getNotificationIcon(notification.type)}</span>
                <span class="notification-title">${notification.title}</span>
                <span class="notification-date">${formatDate(notification.created_at)}</span>
            </div>
            <div class="notification-content">
                <p>${notification.message}</p>
            </div>
        </div>
    `).join('');
}

function showReportedDiscussions() {
    const section = document.getElementById('reported-discussions-section');
    const list = document.getElementById('reported-list');
    const discussions = window.moderationSystem.getReportedDiscussions();
    
    if (discussions.length === 0) {
        list.innerHTML = '<div class="empty-state"><h3>🎉 Aucun message signalé</h3><p>Tous les messages respectent les règles de la communauté.</p></div>';
    } else {
        list.innerHTML = discussions.map(discussion => `
            <div class="reported-item">
                <div class="reported-header">
                    <span class="badge badge-warning">Signalé</span>
                    <strong>${discussion.resource_id}</strong>
                    par ${discussion.user_name}
                    <span class="date">${formatDate(discussion.reported_at)}</span>
                </div>
                <div class="reported-content">
                    <p><strong>Message:</strong> ${discussion.message}</p>
                    <p><strong>Raison:</strong> ${discussion.report_reason}</p>
                    <p><strong>Signalé par:</strong> ${discussion.reported_by_name}</p>
                </div>
                <div class="reported-actions">
                    <button onclick="hideDiscussion(${discussion.resource_id}, ${discussion.id})" class="btn btn-sm btn-warning">
                        👁️ Cacher
                    </button>
                    <button onclick="deleteDiscussion(${discussion.resource_id}, ${discussion.id})" class="btn btn-sm btn-danger">
                        🗑️ Supprimer
                    </button>
                    <button onclick="restoreDiscussion(${discussion.resource_id}, ${discussion.id})" class="btn btn-sm btn-outline">
                        ↩️ Restaurer
                    </button>
                </div>
            </div>
        `).join('');
    }
    
    section.style.display = 'block';
    
    // Scroller vers la section
    section.scrollIntoView({ behavior: 'smooth' });
}

function hideDiscussion(resourceId, discussionId) {
    if (confirm('Êtes-vous sûr de vouloir cacher ce message ?')) {
        if (window.moderationSystem.hideDiscussion(resourceId, discussionId)) {
            window.moderationSystem.createAlert('👁️ Message caché avec succès', 'success');
            showReportedDiscussions(); // Recharger la liste
        }
    }
}

function deleteDiscussion(resourceId, discussionId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce message ? Cette action est irréversible.')) {
        if (window.moderationSystem.deleteDiscussion(resourceId, discussionId)) {
            window.moderationSystem.createAlert('🗑️ Message supprimé avec succès', 'success');
            showReportedDiscussions(); // Recharger la liste
        }
    }
}

function restoreDiscussion(resourceId, discussionId) {
    if (window.moderationSystem.restoreDiscussion(resourceId, discussionId)) {
        window.moderationSystem.createAlert('↩️ Message restauré avec succès', 'success');
        showReportedDiscussions(); // Recharger la liste
    }
}

function getNotificationIcon(type) {
    const icons = {
        'info': 'ℹ️',
        'success': '✅',
        'warning': '⚠️',
        'error': '❌'
    };
    return icons[type] || 'ℹ️';
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleString('fr-FR', {
        day: 'numeric',
        month: 'short',
        hour: '2-digit',
        minute: '2-digit'
    });
}

// Rendre les fonctions disponibles globalement
window.showReportedDiscussions = showReportedDiscussions;
window.hideDiscussion = hideDiscussion;
window.deleteDiscussion = deleteDiscussion;
window.restoreDiscussion = restoreDiscussion;
</script>

<style>
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: transform 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
}

.stat-icon {
    font-size: 2.5rem;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.stat-icon.warning {
    background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);
}

.stat-icon.info {
    background: linear-gradient(135deg, #e3f2fd 0%, #2196f3 100%);
}

.stat-icon.danger {
    background: linear-gradient(135deg, #f44336 0%, #e91e63 100%);
}

.stat-content h3 {
    margin: 0;
    font-size: 1.8rem;
    font-weight: bold;
    color: #333;
}

.stat-content p {
    margin: 0;
    color: #666;
}

.actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.action-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    text-align: center;
}

.action-card h3 {
    margin: 0 0 0.5rem 0;
    color: #333;
}

.action-card p {
    color: #666;
    margin-bottom: 1rem;
}

.notification-item {
    background: white;
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 1rem;
    border-left: 4px solid #e1e5e9;
    transition: all 0.3s ease;
}

.notification-item.unread {
    background: #f8f9fa;
    border-left-color: #667eea;
}

.notification-header {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.5rem;
}

.notification-title {
    font-weight: 600;
    color: #333;
}

.notification-date {
    font-size: 0.8rem;
    color: #666;
    margin-left: auto;
}

.notification-content p {
    margin: 0;
    color: #333;
}

.reported-item {
    background: white;
    border-radius: 8px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    border-left: 4px solid #ff9800;
}

.reported-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.reported-content {
    background: #fff3e0;
    padding: 1rem;
    border-radius: 4px;
    margin-bottom: 1rem;
}

.reported-content p {
    margin: 0.25rem 0;
}

.reported-actions {
    display: flex;
    gap: 0.5rem;
    justify-content: flex-end;
}

.empty-state {
    text-align: center;
    padding: 3rem;
    color: #666;
}

.empty-state h3 {
    margin-bottom: 1rem;
    color: #333;
}
</div>
@endsection

<script src="{{ asset('js/moderation.js') }}"></script>

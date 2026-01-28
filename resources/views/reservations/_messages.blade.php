<!-- Messagerie interne de la réservation -->
<link rel="stylesheet" href="{{ asset('css/messaging.css') }}">

<div class="reservation-messages">
    <div class="messages-header">
        <h5>
            <span class="icon-comments"></span> Messagerie interne
            @if($reservation->unread_count > 0)
                <span class="badge">{{ $reservation->unread_count }} non lu(s)</span>
            @endif
        </h5>
    </div>
    
    <div class="messages-container">
        <div id="messages-list">
            <div class="loading-spinner">
                <span class="icon-spinner"></span> Chargement des messages...
            </div>
        </div>
    </div>
    
    <div class="message-form">
        <form id="message-form">
            @csrf
            <div class="message-input-group">
                <input type="text" id="message-input" class="message-input" 
                       placeholder="Tapez votre message ici..." 
                       maxlength="1000" required>
                <button type="submit" class="message-button">
                    <span class="icon-paper-plane"></span> Envoyer
                </button>
            </div>
            <div class="message-help">Maximum 1000 caractères</div>
        </form>
    </div>
</div>

<script src="{{ asset('js/messaging.js') }}"></script>
<script>
// Initialiser la messagerie pour cette réservation
document.addEventListener('DOMContentLoaded', function() {
    initReservationMessaging({{ $reservation->id }});
});
</script>

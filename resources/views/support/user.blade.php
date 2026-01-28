@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>👥 Support Technique</h1>
        <p>Contactez notre équipe technique pour obtenir de l'aide</p>
    </div>

    <div class="support-container">
        <!-- Options de contact -->
        <div class="contact-options">
            <div class="contact-card">
                <div class="contact-icon">📧</div>
                <h3>Email de support</h3>
                <p>Envoyez-nous un email détaillant votre problème</p>
                <div class="contact-info">
                    <strong>Email :</strong> support@datacenter.com<br>
                    <strong>Délai de réponse :</strong> 24-48h
                </div>
                <a href="mailto:support@datacenter.com?subject=Demande de support - {{ auth()->user()->name }}" class="btn btn-primary">Envoyer un email</a>
            </div>

            <div class="contact-card">
                <div class="contact-icon">📞</div>
                <h3>Appel téléphonique</h3>
                <p>Appelez notre ligne d'assistance technique</p>
                <div class="contact-info">
                    <strong>Téléphone :</strong> 01 23 45 67 89<br>
                    <strong>Disponible :</strong> Lun-Ven, 8h-20h<br>
                    <strong>Urgence :</strong> 24h/24h
                </div>
                <a href="tel:+33123456789" class="btn btn-primary">Appeler maintenant</a>
            </div>

            <div class="contact-card">
                <div class="contact-icon">🚨</div>
                <h3>Signaler un incident</h3>
                <p>Signalez un problème urgent sur une ressource</p>
                <div class="contact-info">
                    <strong>Type :</strong> Panne, incident, problème<br>
                    <strong>Traitement :</strong> Prioritaire
                </div>
                <a href="{{ route('incidents.create') }}" class="btn btn-danger">Signaler un incident</a>
            </div>
        </div>

        <!-- Formulaire de contact rapide -->
        <div class="contact-form-section">
            <h2>📝 Formulaire de contact</h2>
            <p>Décrivez votre problème et nous vous répondrons rapidement</p>
            
            <form class="contact-form" onsubmit="submitContactForm(event)">
                <div class="form-group">
                    <label for="subject">Sujet *</label>
                    <select id="subject" name="subject" required>
                        <option value="">Choisissez un sujet</option>
                        <option value="reservation">Problème de réservation</option>
                        <option value="resource">Panne de ressource</option>
                        <option value="access">Problème d'accès</option>
                        <option value="incident">Signalement d'incident</option>
                        <option value="account">Problème de compte</option>
                        <option value="other">Autre</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="urgency">Niveau d'urgence *</label>
                    <select id="urgency" name="urgency" required>
                        <option value="">Choisissez l'urgence</option>
                        <option value="low">🟢 Faible - Question générale</option>
                        <option value="medium">🟡 Moyenne - Problème gênant</option>
                        <option value="high">🔴 Élevée - Blocage majeur</option>
                        <option value="critical">🚨 Critique - Urgence absolue</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="description">Description du problème *</label>
                    <textarea id="description" name="description" rows="6" required
                              placeholder="Décrivez en détail ce que vous rencontrez..."></textarea>
                </div>

                <div class="form-group">
                    <label for="resource_id">Ressource concernée (si applicable)</label>
                    <select id="resource_id" name="resource_id">
                        <option value="">Sélectionnez une ressource</option>
                        @foreach(\App\Models\Resource::all() as $resource)
                            <option value="{{ $resource->id }}">{{ $resource->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Envoyer la demande</button>
                    <button type="button" class="btn btn-outline" onclick="resetForm()">Effacer</button>
                </div>
            </form>
        </div>

        <!-- FAQ -->
        <div class="faq-section">
            <h2>❓ Questions fréquentes</h2>
            <div class="faq-list">
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFAQ(this)">
                        <span>Comment puis-je réserver une ressource ?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Allez dans la section "Ressources" du dashboard, choisissez la ressource qui vous intéresse, vérifiez les disponibilités et cliquez sur "Réserver". Remplissez le formulaire avec les dates et la justification, puis soumettez votre demande.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFAQ(this)">
                        <span>Que faire en cas de panne de serveur ?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Signalez immédiatement l'incident via le formulaire "Signaler un incident" dans le dashboard. Décrivez précisément le problème et l'équipe technique interviendra rapidement. En cas d'urgence, appelez le numéro d'urgence 24h/24h.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFAQ(this)">
                        <span>Comment annuler une réservation ?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Allez dans "Mes réservations", trouvez la réservation à annuler et cliquez sur "Annuler". Vous pouvez annuler jusqu'à 24h avant la date prévue sans pénalité.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFAQ(this)">
                        <span>Quels sont les horaires du support technique ?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Notre support technique est disponible :<br>
                        • Email : 24h/24h (réponse sous 24-48h)<br>
                        • Téléphone : Lun-Ven 8h-20h (urgence 24h/24h)<br>
                        • Incidents critiques : Traitement immédiat</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.support-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem 0;
}

.contact-options {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.contact-card {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    text-align: center;
    transition: transform 0.3s ease;
}

.contact-card:hover {
    transform: translateY(-5px);
}

.contact-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
}

.contact-card h3 {
    margin-bottom: 1rem;
    color: #333;
}

.contact-card p {
    color: #666;
    margin-bottom: 1.5rem;
}

.contact-info {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    text-align: left;
}

.contact-info strong {
    color: #333;
}

.contact-form-section {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    margin-bottom: 3rem;
}

.contact-form {
    max-width: 600px;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #333;
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 0.75rem;
    border: 2px solid #e1e5e9;
    border-radius: 8px;
    font-family: inherit;
    font-size: 1rem;
}

.form-group textarea {
    resize: vertical;
}

.form-actions {
    display: flex;
    gap: 1rem;
}

.btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s ease;
}

.btn-primary {
    background: #4299e1;
    color: white;
}

.btn-primary:hover {
    background: #3182ce;
}

.btn-danger {
    background: #dc3545;
    color: white;
}

.btn-danger:hover {
    background: #c82333;
}

.btn-outline {
    background: transparent;
    color: #4299e1;
    border: 2px solid #4299e1;
}

.btn-outline:hover {
    background: #4299e1;
    color: white;
}

.faq-section {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.faq-list {
    margin-top: 2rem;
}

.faq-item {
    border: 1px solid #e1e5e9;
    border-radius: 8px;
    margin-bottom: 1rem;
    overflow: hidden;
}

.faq-question {
    padding: 1rem;
    background: #f8f9fa;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: background 0.3s ease;
}

.faq-question:hover {
    background: #e9ecef;
}

.faq-toggle {
    font-size: 1.5rem;
    font-weight: bold;
    color: #4299e1;
}

.faq-answer {
    padding: 1rem;
    display: none;
    background: white;
}

.faq-answer.show {
    display: block;
}

@media (max-width: 768px) {
    .contact-options {
        grid-template-columns: 1fr;
    }
    
    .form-actions {
        flex-direction: column;
    }
}
</style>

<script>
function toggleFAQ(element) {
    const answer = element.nextElementSibling;
    const toggle = element.querySelector('.faq-toggle');
    
    if (answer.classList.contains('show')) {
        answer.classList.remove('show');
        toggle.textContent = '+';
    } else {
        answer.classList.add('show');
        toggle.textContent = '-';
    }
}

function submitContactForm(event) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    const subject = formData.get('subject');
    const urgency = formData.get('urgency');
    const description = formData.get('description');
    
    // Créer le sujet de l'email
    const emailSubject = `Demande de support - ${subject} - ${urgency} - ${auth().user.name}`;
    const emailBody = `Description: ${description}\n\nUtilisateur: ${auth().user.name}\nEmail: ${auth().user.email}`;
    
    // Ouvrir le client email par défaut
    window.location.href = `mailto:support@datacenter.com?subject=${encodeURIComponent(emailSubject)}&body=${encodeURIComponent(emailBody)}`;
    
    // Afficher une confirmation
    alert('Votre client email va s\'ouvrir avec les informations pré-remplies. Envoyez l\'email pour finaliser votre demande.');
}

function resetForm() {
    document.querySelector('.contact-form').reset();
}
</script>
@endsection

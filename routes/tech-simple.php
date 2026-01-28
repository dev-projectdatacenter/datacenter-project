<?php
/**
 * routes/tech-simple.php
 * Routes simplifiées pour le Tech Manager
 * Évite les conflits avec les contrôleurs manquants
 */

use Illuminate\Support\Facades\Route;

// ══════════════════════════════════════════════════════════
// ROUTES TECH MANAGER (Authentification requise)
// ══════════════════════════════════════════════════════════

Route::middleware(['auth', 'role:tech_manager'])->group(function () {
    
    // Dashboard Tech Manager - MOVED to dashboard.php to avoid conflicts
    
    // Gestion des ressources
    Route::get('/tech/resources', function () {
        $resources = \App\Models\Resource::with('category')
            ->latest()
            ->paginate(15);
            
        return '<h1>💻 Mes ressources supervisées</h1>
        <table border="1" cellpadding="5">
            <tr>
                <th>Nom</th>
                <th>Type</th>
                <th>Statut</th>
                <th>CPU</th>
                <th>RAM</th>
                <th>Actions</th>
            </tr>
            @foreach($resources as $resource)
            <tr>
                <td>{{ $resource->name }}</td>
                <td>{{ $resource->category->name ?? \'N/A\' }}</td>
                <td>{{ $resource->status }}</td>
                <td>{{ $resource->cpu ?? \'N/A\' }}</td>
                <td>{{ $resource->ram ?? \'N/A\' }}</td>
                <td>
                    @if($resource->status === \'available\')
                        <form method="POST" action="/tech/resources/{{ $resource->id }}/maintenance" style="display:inline;">
                            @csrf
                            <button type="submit" style="background:orange;color:white;padding:5px;">🔧 Maintenance</button>
                        </form>
                    @endif
                    @if($resource->status === \'maintenance\')
                        <form method="POST" action="/tech/resources/{{ $resource->id }}/activate" style="display:inline;">
                            @csrf
                            <button type="submit" style="background:green;color:white;padding:5px;">✅ Activer</button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </table>
        <p><a href="/dashboard/tech">← Retour dashboard</a></p>';
    })->name('tech.resources.index');
    
    // Mettre une ressource en maintenance
    Route::post('/tech/resources/{resource}/maintenance', function ($resourceId) {
        $resource = \App\Models\Resource::findOrFail($resourceId);
        $resource->status = 'maintenance';
        $resource->save();
        
        // Logger l'action
        \App\Services\ActivityLogService::log(
            'resource_maintenance',
            "Ressource {$resource->name} mise en maintenance",
            auth()->id()
        );
        
        return '<h1>✅ Ressource en maintenance</h1>
        <p>La ressource {{ $resource->name }} est maintenant en maintenance.</p>
        <p><a href="/tech/resources">← Retour aux ressources</a></p>';
    })->name('tech.resources.maintenance');
    
    // Activer une ressource
    Route::post('/tech/resources/{resource}/activate', function ($resourceId) {
        $resource = \App\Models\Resource::findOrFail($resourceId);
        $resource->status = 'available';
        $resource->save();
        
        // Logger l'action
        \App\Services\ActivityLogService::log(
            'resource_activated',
            "Ressource {$resource->name} réactivée",
            auth()->id()
        );
        
        return '<h1>✅ Ressource activée</h1>
        <p>La ressource {{ $resource->name }} est maintenant disponible.</p>
        <p><a href="/tech/resources">← Retour aux ressources</a></p>';
    })->name('tech.resources.activate');
    
    // Gestion des réservations
    Route::get('/tech/reservations', function () {
        $reservations = \App\Models\Reservation::with(['user', 'resource'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(20);
            
        return '<h1>📅 Réservations en attente de validation</h1>
        <table border="1" cellpadding="5">
            <tr>
                <th>Utilisateur</th>
                <th>Ressource</th>
                <th>Date début</th>
                <th>Date fin</th>
                <th>Motivation</th>
                <th>Actions</th>
            </tr>
            @foreach($reservations as $reservation)
            <tr>
                <td>{{ $reservation->user->name }}</td>
                <td>{{ $reservation->resource->name }}</td>
                <td>{{ $reservation->start_date->format(\'d/m/Y\') }}</td>
                <td>{{ $reservation->end_date->format(\'d/m/Y\') }}</td>
                <td>{{ substr($reservation->motivation ?? \'\', 0, 50) }}...</td>
                <td>
                    <form method="POST" action="/tech/reservations/{{ $reservation->id }}/approve" style="display:inline;">
                        @csrf
                        <button type="submit" style="background:green;color:white;padding:5px;">✅ Approuver</button>
                    </form>
                    <form method="POST" action="/tech/reservations/{{ $reservation->id }}/reject" style="display:inline;">
                        @csrf
                        <button type="submit" style="background:red;color:white;padding:5px;">❌ Refuser</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
        <p><a href="/dashboard/tech">← Retour dashboard</a></p>';
    })->name('tech.reservations.index');
    
    // Approuver une réservation (redirection vers dashboard.php)
    // Route supprimée - utilisez celle dans dashboard.php
    
    // Refuser une réservation
    Route::post('/tech/reservations/{reservation}/reject', function ($reservationId) {
        $reservation = \App\Models\Reservation::findOrFail($reservationId);
        $reservation->status = 'rejected';
        $reservation->rejected_by = auth()->id();
        $reservation->rejected_at = now();
        $reservation->save();
        
        // Logger l'action
        \App\Services\ActivityLogService::log(
            'reservation_rejected',
            "Réservation refusée pour {$reservation->resource->name} par {$reservation->user->name}",
            auth()->id()
        );
        
        return '<h1>❌ Réservation refusée</h1>
        <p>La réservation a été refusée.</p>
        <p><a href="/tech/reservations">← Retour aux réservations</a></p>';
    })->name('tech.reservations.reject');
    
    // Gestion des incidents
    Route::get('/tech/incidents', function () {
        $incidents = \App\Models\Incident::with(['user', 'resource'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(20);
            
        return '<h1>🚨 Incidents à traiter</h1>
        <table border="1" cellpadding="5">
            <tr>
                <th>Date</th>
                <th>Utilisateur</th>
                <th>Ressource</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
            @foreach($incidents as $incident)
            <tr>
                <td>{{ $incident->created_at->format(\'d/m/Y H:i\') }}</td>
                <td>{{ $incident->user->name }}</td>
                <td>{{ $incident->resource->name ?? \'N/A\' }}</td>
                <td>{{ substr($incident->description, 0, 100) }}...</td>
                <td>
                    <form method="POST" action="/tech/incidents/{{ $incident->id }}/resolve" style="display:inline;">
                        @csrf
                        <button type="submit" style="background:green;color:white;padding:5px;">✅ Résolu</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
        <p><a href="/dashboard/tech">← Retour dashboard</a></p>';
    })->name('tech.incidents.index');
    
    // Résoudre un incident
    Route::post('/tech/incidents/{incident}/resolve', function ($incidentId) {
        $incident = \App\Models\Incident::findOrFail($incidentId);
        $incident->status = 'resolved';
        $incident->resolved_by = auth()->id();
        $incident->resolved_at = now();
        $incident->save();
        
        // Logger l'action
        \App\Services\ActivityLogService::log(
            'incident_resolved',
            "Incident résolu pour {$incident->resource->name}",
            auth()->id()
        );
        
        return '<h1>✅ Incident résolu</h1>
        <p>L\'incident a été marqué comme résolu.</p>
        <p><a href="/tech/incidents">← Retour aux incidents</a></p>';
    })->name('tech.incidents.resolve');
});

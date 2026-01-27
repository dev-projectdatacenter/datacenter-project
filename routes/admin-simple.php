<?php
/**
 * routes/admin-simple.php
 * Routes complètes pour l'Administrateur du Data Center
 * Gestion complète du système
 */

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;

// ══════════════════════════════════════════════════════════
// ROUTES ADMINISTRATEUR (Authentification requise)
// ══════════════════════════════════════════════════════════

Route::middleware(['auth', 'role:admin'])->group(function () {
    
    // ══════════════════════════════════════════════════════════
    // GESTION DES UTILISATEURS
    // ══════════════════════════════════════════════════════════
    
    // Liste des utilisateurs
    Route::get('/admin/users', function () {
        $users = \App\Models\User::with('role')
            ->latest()
            ->paginate(20);
            
        return '<h1>👥 Gestion des utilisateurs</h1>
        <table border="1" cellpadding="5">
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Rôle</th>
                <th>Statut</th>
                <th>Créé le</th>
                <th>Actions</th>
            </tr>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                <td>{{ $user->role->name }}</td>
                <td>{{ $user->status }}</td>
                <td>{{ $user->created_at->format(\'d/m/Y\') }}</td>
                <td>
                    <a href="/admin/users/{{ $user->id }}/edit">✏️</a>
                    @if($user->status === \'active\')
                        <a href="/admin/users/{{ $user->id }}/deactivate">🔒</a>
                    @else
                        <a href="/admin/users/{{ $user->id }}/activate">🔓</a>
                    @endif
                    <a href="/admin/users/{{ $user->id }}/delete">🗑️</a>
                </td>
            </tr>
            @endforeach
        </table>
        <p><a href="/admin/users/create">➕ Ajouter un utilisateur</a></p>
        <p><a href="/admin/dashboard">← Retour dashboard</a></p>';
    })->name('admin.users.index');
    
    // Formulaire création utilisateur
    Route::get('/admin/users/create', function () {
        $roles = \App\Models\Role::all();
        
        return '<h1>➕ Ajouter un utilisateur</h1>
        <form method="POST" action="/admin/users">
            @csrf
            <table border="1" cellpadding="5">
                <tr>
                    <th><label for="name">Nom *</label></th>
                    <td><input type="text" name="name" required></td>
                </tr>
                <tr>
                    <th><label for="email">Email *</label></th>
                    <td><input type="email" name="email" required></td>
                </tr>
                <tr>
                    <th><label for="password">Mot de passe *</label></th>
                    <td><input type="password" name="password" required></td>
                </tr>
                <tr>
                    <th><label for="phone">Téléphone</label></th>
                    <td><input type="tel" name="phone"></td>
                </tr>
                <tr>
                    <th><label for="role_id">Rôle *</label></th>
                    <td>
                        <select name="role_id" required>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="status">Statut *</label></th>
                    <td>
                        <select name="status" required>
                            <option value="active">Actif</option>
                            <option value="inactive">Inactif</option>
                        </select>
                    </td>
                </tr>
            </table>
            <button type="submit">✅ Créer l\'utilisateur</button>
            <a href="/admin/users">← Annuler</a>
        </form>';
    })->name('admin.users.create');
    
    // Créer utilisateur
    Route::post('/admin/users', function () {
        try {
            $data = request()->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:6',
                'phone' => 'nullable|string',
                'role_id' => 'required|exists:roles,id',
                'status' => 'required|in:active,inactive',
            ]);
            
            $user = \App\Models\User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'phone' => $data['phone'],
                'role_id' => $data['role_id'],
                'status' => $data['status'],
            ]);
            
            // Logger l'action
            \App\Services\ActivityLogService::log(
                'user_created',
                "Utilisateur créé: {$user->name} ({$user->email})",
                auth()->id()
            );
            
            return '<h1>✅ Utilisateur créé !</h1>
            <p>L\'utilisateur a été créé avec succès.</p>
            <p><a href="/admin/users">← Retour à la liste</a></p>';
            
        } catch (\Exception $e) {
            return '<h1>❌ Erreur</h1>
            <p>Une erreur est survenue: ' . $e->getMessage() . '</p>
            <p><a href="/admin/users/create">← Réessayer</a></p>';
        }
    })->name('admin.users.store');
    
    // Activer/Désactiver utilisateur
    Route::post('/admin/users/{user}/activate', function ($userId) {
        $user = \App\Models\User::findOrFail($userId);
        $user->status = 'active';
        $user->save();
        
        \App\Services\ActivityLogService::log(
            'user_activated',
            "Utilisateur activé: {$user->name}",
            auth()->id()
        );
        
        return '<h1>✅ Utilisateur activé</h1>
        <p><a href="/admin/users">← Retour à la liste</a></p>';
    })->name('admin.users.activate');
    
    Route::post('/admin/users/{user}/deactivate', function ($userId) {
        $user = \App\Models\User::findOrFail($userId);
        $user->status = 'inactive';
        $user->save();
        
        \App\Services\ActivityLogService::log(
            'user_deactivated',
            "Utilisateur désactivé: {$user->name}",
            auth()->id()
        );
        
        return '<h1>🔒 Utilisateur désactivé</h1>
        <p><a href="/admin/users">← Retour à la liste</a></p>';
    })->name('admin.users.deactivate');
    
    // ══════════════════════════════════════════════════════════
    // GESTION DES RESSOURCES
    // ══════════════════════════════════════════════════════════
    
    // Liste des ressources
    Route::get('/admin/resources', function () {
        $resources = \App\Models\Resource::with('category')
            ->latest()
            ->paginate(20);
            
        return '<h1>💻 Gestion des ressources</h1>
        <table border="1" cellpadding="5">
            <tr>
                <th>Nom</th>
                <th>Type</th>
                <th>CPU</th>
                <th>RAM</th>
                <th>Stockage</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
            @foreach($resources as $resource)
            <tr>
                <td>{{ $resource->name }}</td>
                <td>{{ $resource->category->name ?? \'N/A\' }}</td>
                <td>{{ $resource->cpu ?? \'N/A\' }}</td>
                <td>{{ $resource->ram ?? \'N/A\' }}</td>
                <td>{{ $resource->storage ?? \'N/A\' }}</td>
                <td>{{ $resource->status }}</td>
                <td>
                    <a href="/admin/resources/{{ $resource->id }}/edit">✏️</a>
                    @if($resource->status === \'available\')
                        <a href="/admin/resources/{{ $resource->id }}/deactivate">🔒</a>
                    @else
                        <a href="/admin/resources/{{ $resource->id }}/activate">🔓</a>
                    @endif
                    <a href="/admin/resources/{{ $resource->id }}/delete">🗑️</a>
                </td>
            </tr>
            @endforeach
        </table>
        <p><a href="/admin/resources/create">➕ Ajouter une ressource</a></p>
        <p><a href="/admin/dashboard">← Retour dashboard</a></p>';
    })->name('admin.resources.index');
    
    // Activer/Désactiver ressource
    Route::post('/admin/resources/{resource}/activate', function ($resourceId) {
        $resource = \App\Models\Resource::findOrFail($resourceId);
        $resource->status = 'available';
        $resource->save();
        
        \App\Services\ActivityLogService::log(
            'resource_activated',
            "Ressource activée: {$resource->name}",
            auth()->id()
        );
        
        return '<h1>✅ Ressource activée</h1>
        <p><a href="/admin/resources">← Retour à la liste</a></p>';
    })->name('admin.resources.activate');
    
    Route::post('/admin/resources/{resource}/deactivate', function ($resourceId) {
        $resource = \App\Models\Resource::findOrFail($resourceId);
        $resource->status = 'inactive';
        $resource->save();
        
        \App\Services\ActivityLogService::log(
            'resource_deactivated',
            "Ressource désactivée: {$resource->name}",
            auth()->id()
        );
        
        return '<h1>🔒 Ressource désactivée</h1>
        <p><a href="/admin/resources">← Retour à la liste</a></p>';
    })->name('admin.resources.deactivate');
    
    // ══════════════════════════════════════════════════════════
    // GESTION DES DEMANDES DE COMPTE
    // ══════════════════════════════════════════════════════════
    
    // Approuver une demande
    Route::post('/admin/account-requests/{request}/approve', function ($requestId) {
        $request = \App\Models\AccountRequest::findOrFail($requestId);
        
        // Créer le compte utilisateur
        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('DataCenter2026!'),
            'role_id' => \App\Models\Role::where('name', $request->role_requested)->first()->id,
            'status' => 'active',
        ]);
        
        // Mettre à jour la demande
        $request->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);
        
        // Logger l'action
        \App\Services\ActivityLogService::log(
            'account_request_approved',
            "Demande de compte approuvée pour {$request->name} ({$request->email})",
            auth()->id()
        );
        
        return '<h1>✅ Compte créé !</h1>
        <p>Le compte a été créé avec succès pour {{ $request->name }}</p>
        <p>Email: {{ $request->email }}</p>
        <p>Mot de passe temporaire: DataCenter2026!</p>
        <p><a href="/admin/account-requests">← Retour aux demandes</a></p>';
    })->name('admin.account-requests.approve');
    
    // Refuser une demande
    Route::post('/admin/account-requests/{request}/reject', function ($requestId) {
        $request = \App\Models\AccountRequest::findOrFail($requestId);
        
        $request->update([
            'status' => 'rejected',
            'rejected_by' => auth()->id(),
            'rejected_at' => now(),
        ]);
        
        // Logger l'action
        \App\Services\ActivityLogService::log(
            'account_request_rejected',
            "Demande de compte refusée pour {$request->name} ({$request->email})",
            auth()->id()
        );
        
        return '<h1>❌ Demande refusée</h1>
        <p>La demande de {{ $request->name }} a été refusée.</p>
        <p><a href="/admin/account-requests">← Retour aux demandes</a></p>';
    })->name('admin.account-requests.reject');
    
    // ══════════════════════════════════════════════════════════
    // STATISTIQUES ET LOGS
    // ══════════════════════════════════════════════════════════
    
    // Logs d'activité
    Route::get('/admin/logs', function () {
        $logs = \App\Models\ActivityLog::with('user')
            ->latest()
            ->paginate(50);
            
        return '<h1>📜 Logs d\'activité</h1>
        <table border="1" cellpadding="5">
            <tr>
                <th>Date</th>
                <th>Utilisateur</th>
                <th>Action</th>
                <th>Description</th>
                <th>IP</th>
            </tr>
            @foreach($logs as $log)
            <tr>
                <td>{{ $log->created_at->format(\'d/m/Y H:i\') }}</td>
                <td>{{ $log->user ? $log->user->name : \'N/A\' }}</td>
                <td>{{ $log->action }}</td>
                <td>{{ $log->description }}</td>
                <td>{{ $log->ip_address }}</td>
            </tr>
            @endforeach
        </table>
        <p><a href="/admin/dashboard">← Retour dashboard</a></p>';
    })->name('admin.logs');
    
    // Statistiques détaillées
    Route::get('/admin/statistics', function () {
        $stats = [
            'usersByRole' => \App\Models\User::join('roles', 'users.role_id', '=', 'roles.id')
                ->selectRaw('roles.name, COUNT(*) as count')
                ->groupBy('roles.name')
                ->get(),
            'resourcesByCategory' => \App\Models\Resource::join('categories', 'resources.category_id', '=', 'categories.id')
                ->selectRaw('categories.name, COUNT(*) as count')
                ->groupBy('categories.name')
                ->get(),
            'reservationsByMonth' => \App\Models\Reservation::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', date('Y'))
                ->groupBy('month')
                ->get(),
        ];
        
        return '<h1>📊 Statistiques détaillées</h1>
        <h2>Utilisateurs par rôle</h2>
        <table border="1" cellpadding="5">
            @foreach($stats[\'usersByRole\'] as $stat)
            <tr><td>{{ $stat->name }}</td><td>{{ $stat->count }}</td></tr>
            @endforeach
        </table>
        
        <h2>Ressources par catégorie</h2>
        <table border="1" cellpadding="5">
            @foreach($stats[\'resourcesByCategory\'] as $stat)
            <tr><td>{{ $stat->name }}</td><td>{{ $stat->count }}</td></tr>
            @endforeach
        </table>
        
        <h2>Réservations par mois</h2>
        <table border="1" cellpadding="5">
            @foreach($stats[\'reservationsByMonth\'] as $stat)
            <tr><td>Mois {{ $stat->month }}</td><td>{{ $stat->count }}</td></tr>
            @endforeach
        </table>
        
        <p><a href="/admin/dashboard">← Retour dashboard</a></p>';
    })->name('admin.statistics');
});

// Fonction helper pour calculer le taux d'occupation
if (!function_exists('calculateOccupancyRate')) {
    function calculateOccupancyRate() {
        $totalResources = \App\Models\Resource::count();
        if ($totalResources === 0) return 0;
        
        $activeReservations = \App\Models\Reservation::where('status', 'approved')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->count();
            
        return round(($activeReservations / $totalResources) * 100, 2);
    }
}

<?php
/**
 * routes/support.php
 * Routes du support technique (Tech Managers uniquement)
 */

use Illuminate\Support\Facades\Route;

// ══════════════════════════════════════════════════════════
    // SUPPORT TECHNIQUE (Tech Managers uniquement)
    // ════════════════════════════════════════════════════════════

Route::middleware(['auth', 'role:tech_manager'])->prefix('support')->name('support.')->group(function () {
    // Tableau de bord du support
    Route::get('/', function() {
        // Statistiques du support
        $stats = [
            'totalRequests' => 0, // À implémenter avec les vraies données
            'pendingRequests' => 0,
            'resolvedToday' => 0,
            'avgResponseTime' => 0
        ];
        
        // Demandes récentes (simulation)
        $recentRequests = collect([
            (object)[
                'id' => 1,
                'user_id' => 2,
                'user' => (object)['name' => 'Jean Dupont', 'role' => 'user'],
                'subject' => 'Panne serveur web',
                'description' => 'Le serveur web principal ne répond plus aux requêtes HTTP.',
                'urgency' => 'high',
                'status' => 'pending',
                'resource_id' => 1,
                'resource' => (object)['name' => 'Serveur Web Principal'],
                'notes' => 'Urgence élevée - vérifier le service Apache',
                'created_at' => now()->subMinutes(30),
                'updated_at' => now()->subMinutes(30)
            ],
            (object)[
                'id' => 2,
                'user_id' => 3,
                'user' => (object)['name' => 'Marie Martin', 'role' => 'user'],
                'subject' => 'Problème d\'accès VPN',
                'description' => 'Impossible de se connecter au VPN depuis le domicile.',
                'urgency' => 'medium',
                'status' => 'in_progress',
                'resource_id' => null,
                'resource' => null,
                'notes' => 'Vérifier les identifiants VPN et la configuration du client',
                'created_at' => now()->subHours(2),
                'updated_at' => now()->subHours(2)
            ]
        ]);
        
        return view('support.index', compact('stats', 'recentRequests'));
    })->name('index');
    
    // Liste des demandes
    Route::get('/requests', function() {
        // À implémenter avec les vraies données
        $requests = collect([]);
        
        return view('support.requests', compact('requests'));
    })->name('requests');
    
    // Boîte de réception des emails
    Route::get('/emails', function() {
        // À implémenter avec les vrais emails
        $emails = collect([]);
        
        return view('support.emails', compact('emails'));
    })->name('emails');
    
    // Soumission du formulaire de support
    Route::post('/submit', function(\Illuminate\Http\Request $request) {
        // Valider les données
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'urgency' => 'required|in:low,medium,high,critical',
            'description' => 'required|string|max:2000',
            'resource_id' => 'nullable|exists:resources,id',
            'notes' => 'nullable|string|max:1000'
        ]);
        
        // Créer la demande de support
        $supportRequest = new \App\Models\SupportRequest();
        $supportRequest->user_id = $validated['user_id'];
        $supportRequest->subject = $validated['subject'];
        $supportRequest->description = $validated['description'];
        $supportRequest->urgency = $validated['urgency'];
        $supportRequest->resource_id = $validated['resource_id'];
        $supportRequest->notes = $validated['notes'];
        $supportRequest->status = 'pending';
        $supportRequest->created_at = now();
        $supportRequest->updated_at = now();
        $supportRequest->save();
        
        // Notifier les autres tech managers
        $techManagers = \App\Models\User::where('role_id', 3)->get(); // role_id 3 = tech_manager
        foreach ($techManagers as $techManager) {
            \App\Models\Notification::create([
                'user_id' => $techManager->id,
                'title' => 'Nouvelle demande de support',
                'message' => 'Une nouvelle demande de support a été créée : ' . $validated['subject'],
                'type' => 'support',
                'priority' => $validated['urgency'],
                'read' => false
            ]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Demande de support créée avec succès'
        ]);
    })->name('submit');
    
    // Mettre à jour le statut d'une demande
    Route::post('/requests/{request}/status', function($requestId) {
        // À implémenter avec les vraies données
        return response()->json([
            'success' => true,
            'message' => 'Statut mis à jour'
        ]);
    })->name('update.status');
});

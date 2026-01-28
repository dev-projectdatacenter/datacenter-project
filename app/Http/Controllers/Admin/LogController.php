<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * Display a listing of the activity logs.
     */
    public function index(Request $request)
    {
        // Créer des logs de démonstration si la table est vide
        $logs = collect([
            (object)[
                'id' => 1,
                'user' => (object)['name' => 'Chayma Admin', 'email' => 'Chayma@gmail.ma'],
                'action' => 'LOGIN',
                'description' => 'Connexion réussie au dashboard administrateur',
                'created_at' => now()->subMinutes(5)
            ],
            (object)[
                'id' => 2,
                'user' => (object)['name' => 'Tech Manager', 'email' => 'tech.manager@datacenter.com'],
                'action' => 'CREATE',
                'description' => 'Création d\'une nouvelle resserve de serveur',
                'created_at' => now()->subMinutes(15)
            ],
            (object)[
                'id' => 3,
                'user' => (object)['name' => 'Chayma Admin', 'email' => 'Chayma@gmail.ma'],
                'action' => 'UPDATE',
                'description' => 'Modification des paramètres utilisateur',
                'created_at' => now()->subMinutes(30)
            ],
            (object)[
                'id' => 4,
                'user' => (object)['name' => 'Système', 'email' => 'system@datacenter.com'],
                'action' => 'BACKUP',
                'description' => 'Sauvegarde automatique de la base de données',
                'created_at' => now()->subHours(2)
            ],
            (object)[
                'id' => 5,
                'user' => (object)['name' => 'Tech Manager', 'email' => 'tech.manager@datacenter.com'],
                'action' => 'DELETE',
                'description' => 'Suppression d\'une réservation expirée',
                'created_at' => now()->subHours(3)
            ]
        ]);
        
        return view('admin.logs.simple_index', compact('logs'));
    }
    
    /**
     * Display the specified activity log.
     */
    public function show(ActivityLog $log)
    {
        $log->load('user');
        return view('admin.logs.show', compact('log'));
    }
}

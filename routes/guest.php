<?php

/**
 * routes/guest.php
 * Routes publiques pour les invités (non authentifiés)
 * Auteur: Équipe Data Center
 */

use Illuminate\Support\Facades\Route;

// ════════════════════════════════════════════════════════════
// ROUTES PUBLIQUES (Invité)
// ════════════════════════════════════════════════════════════

// Page d'accueil publique
Route::get('/', function () {
    return view('welcome');
});

// Consultation des ressources (lecture seule)
Route::get('/all-resources', function () {
    $resources = \App\Models\Resource::with('category')
        ->where('status', 'active')
        ->orderBy('name')
        ->paginate(20);
    
    return view('guest.resources.index', compact('resources'));
})->name('guest.resources.index');

// Détail d'une ressource (lecture seule)
Route::get('/resources/{resource}', function ($resource) {
    $resource = \App\Models\Resource::with('category')
        ->where('id', $resource)
        ->where('status', 'active')
        ->firstOrFail();
    
    return view('guest.resources.show', compact('resource'));
})->name('guest.resources.show');

// Règles d'utilisation
Route::get('/rules', function () {
    return view('guest.rules');
})->name('guest.rules');

// Demande d'ouverture de compte
Route::get('/request-account', function () {
    return view('guest.request-account');
})->name('guest.request-account');

Route::post('/request-account', function () {
    $data = request()->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required|string|max:20',
        'department' => 'required|string|max:255',
        'motivation' => 'required|string|min:50|max:1000',
    ], [
        'name.required' => 'Le nom complet est obligatoire.',
        'email.required' => 'L\'adresse email est obligatoire.',
        'email.email' => 'Veuillez entrer une adresse email valide.',
        'email.unique' => 'Cette adresse email est déjà utilisée.',
        'phone.required' => 'Le numéro de téléphone est obligatoire.',
        'department.required' => 'Le département est obligatoire.',
        'motivation.required' => 'La motivation est obligatoire.',
        'motivation.min' => 'La motivation doit contenir au moins 50 caractères.',
        'motivation.max' => 'La motivation ne peut pas dépasser 1000 caractères.',
    ]);

    // Créer la demande de compte
    \App\Models\AccountRequest::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'phone' => $data['phone'],
        'department' => $data['department'],
        'motivation' => $data['motivation'],
        'status' => 'pending',
    ]);

    return redirect('/request-account')
        ->with('success', 'Votre demande de compte a été soumise avec succès! Vous recevrez une réponse par email.');
});

// Dashboard invité
Route::get('/guest/dashboard', function () {
    $statistics = [
        'totalResources' => \App\Models\Resource::count(),
        'availableResources' => \App\Models\Resource::where('status', 'active')->count(),
        'categories' => \App\Models\ResourceCategory::count(),
    ];
    
    return view('dashboard.guest', compact('statistics'));
})->name('dashboard.guest');

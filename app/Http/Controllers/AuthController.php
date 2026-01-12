<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    // --- Tes fonctions existantes (login, logout...) sont ici ---
    // (Ne les efface pas)


    // --- AJOUTE CES DEUX FONCTIONS EN DESSOUS ---

    // 1. Pour afficher le formulaire de demande
    public function showAccountRequest()
    {
        return view('auth.account-request');
    }

    // 2. Pour traiter l'envoi du formulaire
    public function submitAccountRequest(Request $request)
    {
        // On validera les données plus tard
        dd($request->all()); // Juste pour tester que ça marche
    }

} // <--- Vérifie bien que cette accolade ferme tout le fichier à la fin
<?php
// app/Http/Controllers/AuthController.php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    // Afficher le formulaire de connexion
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Traiter la connexion
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            // Logger la connexion réussie
            $user = Auth::user();
            ActivityLogService::logLogin($user);
            
            // Redirection selon le rôle (avec relation)
            $roleName = $user->role ? $user->role->name : 'guest';
            
            return $this->redirectToDashboard($roleName);
        }

        // Logger la tentative de connexion échouée
        ActivityLogService::logFailedLogin($request->email);

        return back()->withErrors([
            'email' => 'Les identifiants ne correspondent pas.',
        ])->onlyInput('email');
    }

    // Afficher le formulaire d'inscription
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Traiter l'inscription (redirection vers AccountRequestController)
    public function register(Request $request)
    {
        return redirect()->route('register');
    }

    // Déconnexion
    public function logout(Request $request)
    {
        $user = Auth::user();
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Logger la déconnexion
        if ($user) {
            ActivityLogService::logLogout($user);
        }

        return redirect('/');
    }

    // Redirection selon rôle
    private function redirectToDashboard($role)
    {
        switch ($role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'tech_manager':
                return redirect()->route('dashboard.tech');
            case 'user':
                return redirect()->route('dashboard.user');
            default:
                return redirect('/');
        }
    }
}
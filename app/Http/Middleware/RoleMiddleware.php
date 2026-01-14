<?php
// app/Http/Middleware/RoleMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Charger la relation role
        $user->load('role');
        
        // Vérifier si le compte est actif
        if ($user->status !== 'active') {
            Auth::logout();
            return redirect()->route('login')
                ->withErrors(['email' => 'Votre compte n\'est pas actif.']);
        }

        // Vérifier le rôle
        if (!$this->checkRole($user->role->name, $role)) {
            // Redirection selon le rôle de l'utilisateur
            return $this->redirectToDashboard($user->role->name);
        }

        return $next($request);
    }

    /**
     * Vérifier si le rôle de l'utilisateur correspond au rôle requis
     * avec hiérarchie: ADMIN > TECH_MANAGER > USER > INVITE
     */
    private function checkRole($userRole, $requiredRole)
    {
        // Définir la hiérarchie des rôles
        $hierarchy = [
            'INVITE' => 0,
            'USER' => 1,
            'TECH_MANAGER' => 2,
            'ADMIN' => 3,
        ];

        // Si l'utilisateur a un rôle plus élevé, il a accès
        if (isset($hierarchy[$userRole]) && isset($hierarchy[$requiredRole])) {
            return $hierarchy[$userRole] >= $hierarchy[$requiredRole];
        }

        return false;
    }

    /**
     * Rediriger vers le dashboard approprié
     */
    private function redirectToDashboard($role)
    {
        switch ($role) {
            case 'ADMIN':
                return redirect()->route('admin.dashboard');
            case 'TECH_MANAGER':
                return redirect()->route('dashboard.tech');
            case 'USER':
                return redirect()->route('dashboard.user');
            case 'INVITE':
            default:
                return redirect('/');
        }
    }
}
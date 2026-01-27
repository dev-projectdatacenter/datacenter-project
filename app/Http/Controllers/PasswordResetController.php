<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\PasswordResetMail;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    /**
     * Afficher le formulaire de demande de réinitialisation
     */
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Envoyer le lien de réinitialisation
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'Veuillez entrer une adresse email valide.',
            'email.exists' => 'Cette adresse email n\'existe pas dans notre système.',
        ]);

        $user = User::where('email', $request->email)->first();
        
        // Générer un token unique
        $token = Str::random(60);
        
        // Stocker le token en session (simple pour le développement)
        session([
            'password_reset_token' => $token,
            'password_reset_email' => $request->email,
            'password_reset_expires' => Carbon::now()->addMinutes(60),
        ]);

        // Afficher la page avec le token (pour le développement)
        return view('auth.reset-link-display');
    }

    /**
     * Afficher le formulaire de réinitialisation
     */
    public function showResetForm($token = null)
    {
        // Vérifier si le token est valide
        if (!$token || !session('password_reset_token') || session('password_reset_token') !== $token) {
            return redirect()->route('password.request')
                ->with('error', 'Le lien de réinitialisation est invalide ou a expiré.');
        }

        // Vérifier si le token n'a pas expiré
        if (Carbon::now()->gt(session('password_reset_expires'))) {
            session()->forget(['password_reset_token', 'password_reset_email', 'password_reset_expires']);
            return redirect()->route('password.request')
                ->with('error', 'Le lien de réinitialisation a expiré.');
        }

        return view('auth.reset-password', ['token' => $token]);
    }

    /**
     * Réinitialiser le mot de passe
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'password_confirmation' => 'required|string|min:8',
        ], [
            'token.required' => 'Le token de réinitialisation est requis.',
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'Veuillez entrer une adresse email valide.',
            'email.exists' => 'Cette adresse email n\'existe pas dans notre système.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'password.regex' => 'Le mot de passe doit contenir au moins une majuscule, une minuscule et un chiffre.',
            'password_confirmation.required' => 'La confirmation du mot de passe est obligatoire.',
        ]);

        // Vérifier le token
        if (!session('password_reset_token') || session('password_reset_token') !== $request->token) {
            return back()->withErrors(['token' => 'Le token de réinitialisation est invalide.']);
        }

        // Vérifier l'email
        if (session('password_reset_email') !== $request->email) {
            return back()->withErrors(['email' => 'L\'adresse email ne correspond pas à la demande.']);
        }

        // Vérifier l'expiration
        if (Carbon::now()->gt(session('password_reset_expires'))) {
            session()->forget(['password_reset_token', 'password_reset_email', 'password_reset_expires']);
            return back()->withErrors(['token' => 'Le lien de réinitialisation a expiré.']);
        }

        // Mettre à jour le mot de passe
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Nettoyer la session
        session()->forget(['password_reset_token', 'password_reset_email', 'password_reset_expires']);

        // Logger l'activité
        \App\Services\ActivityLogService::log(
            'password_reset',
            "Réinitialisation du mot de passe pour {$user->email}",
            $user
        );

        return redirect()->route('login')
            ->with('success', 'Votre mot de passe a été réinitialisé avec succès. Vous pouvez maintenant vous connecter.');
    }
}

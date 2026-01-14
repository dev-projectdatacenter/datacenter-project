<?php

namespace App\Http\Controllers;

use App\Models\AccountRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;

class AccountRequestController extends Controller
{
    /**
     * Afficher le formulaire de demande de compte (pour les invités)
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Soumettre une demande de compte
     */
    public function store(RegisterRequest $request)
    {
        AccountRequest::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role_requested' => $request->role_requested,
            'message' => $request->message,
            'status' => 'pending',
        ]);

        return redirect()->route('login')
            ->with('success', 'Votre demande de compte a été soumise. Un administrateur va la valider.');
    }

    /**
     * Afficher le statut d'une demande (pour le demandeur)
     */
    public function status($email)
    {
        $request = AccountRequest::where('email', $email)->first();
        
        if (!$request) {
            return redirect()->route('account-request.create')
                ->with('error', 'Aucune demande trouvée pour cette adresse email.');
        }

        return view('account-requests.status', compact('request'));
    }

    /**
     * Afficher la liste des demandes (admin)
     */
    public function index()
    {
        $requests = AccountRequest::where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.account-requests.index', compact('requests'));
    }

    /**
     * Approuver une demande
     */
    public function approve(AccountRequest $accountRequest)
    {
        // Trouver le rôle correspondant
        $role = \App\Models\Role::where('name', $accountRequest->role_requested)->first();
        
        // Créer l'utilisateur
        $user = \App\Models\User::create([
            'role_id' => $role->id,
            'name' => $accountRequest->name,
            'email' => $accountRequest->email,
            'phone' => $accountRequest->phone,
            'password' => bcrypt('password'), // Mot de passe temporaire
            'status' => 'active',
        ]);

        // Mettre à jour le statut de la demande
        $accountRequest->update([
            'status' => 'approved',
        ]);

        // Logger l'activité
        \App\Services\ActivityLogService::log(
            'account_request_approved',
            "Approbation de la demande de compte pour {$accountRequest->email}",
            auth()->user()
        );

        return redirect()->route('admin.requests.index')
            ->with('success', 'Demande de compte approuvée avec succès. Le mot de passe temporaire est "password".');
    }

    /**
     * Refuser une demande
     */
    public function reject(Request $request, AccountRequest $accountRequest)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $accountRequest->update([
            'status' => 'rejected',
        ]);

        // Logger l'activité
        \App\Services\ActivityLogService::log(
            'account_request_rejected',
            "Refus de la demande de compte pour {$accountRequest->email}: {$request->rejection_reason}",
            auth()->user()
        );

        return redirect()->route('admin.requests.index')
            ->with('success', 'Demande de compte refusée.');
    }

    /**
     * Afficher l'historique des demandes
     */
    public function history()
    {
        $requests = AccountRequest::where('status', '!=', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.account-requests.history', compact('requests'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AccountRequest;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    /**
     * Afficher la liste des utilisateurs
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Afficher le formulaire de création d'utilisateur
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Créer un nouvel utilisateur
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'status' => 'sometimes|in:active,inactive,blocked',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'status' => $request->status ?? 'active',
        ]);


        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Afficher les détails d'un utilisateur
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Afficher le formulaire d'édition d'utilisateur
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Mettre à jour un utilisateur
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role_id' => 'required|exists:roles,id',
            'status' => 'sometimes|in:active,inactive,blocked',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'status' => $request->status ?? $user->status,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }


        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur mis à jour avec succès.');
    }

    /**
     * Supprimer un utilisateur
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $userName = $user->name;
        $user->delete();


        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur supprimé avec succès.');
    }

    /**
     * Activer/Désactiver un utilisateur
     */
    public function toggleStatus(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas désactiver votre propre compte.');
        }

        $newStatus = $user->status === 'active' ? 'inactive' : 'active';
        $user->update(['status' => $newStatus]);

        $status = $newStatus === 'active' ? 'activé' : 'désactivé';
        return back()->with('success', "Utilisateur {$status} avec succès.");
    }

    /**
     * Afficher les demandes de compte
     */
    public function accountRequests()
    {
        $requests = AccountRequest::where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.account-requests.index', compact('requests'));
    }

    /**
     * Approuver une demande de compte
     */
    public function approveRequest(AccountRequest $accountRequest)
    {
        // Créer l'utilisateur
        $user = User::create([
            'name' => $accountRequest->name,
            'email' => $accountRequest->email,
            'password' => $accountRequest->password,
            'role' => $accountRequest->role,
            'is_active' => true,
        ]);

        // Mettre à jour le statut de la demande
        $accountRequest->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return redirect()->route('admin.account-requests')
            ->with('success', 'Demande de compte approuvée avec succès.');
    }

    /**
     * Refuser une demande de compte
     */
    public function rejectRequest(Request $request, AccountRequest $accountRequest)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $accountRequest->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'rejected_by' => auth()->id(),
            'rejected_at' => now(),
        ]);

        return redirect()->route('admin.account-requests')
            ->with('success', 'Demande de compte refusée.');
    }

    /**
     * Changer le rôle d'un utilisateur
     */
    public function changeRole(Request $request, User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas modifier votre propre rôle.');
        }

        $request->validate([
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        $user->update(['role_id' => $request->role_id]);

        return back()->with('success', 'Rôle de l\'utilisateur mis à jour avec succès.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Afficher la liste des réservations
     */
    public function index()
    {
        return view('admin.reservations.index');
    }

    /**
     * Afficher le formulaire de création de réservation
     */
    public function create()
    {
        return view('admin.reservations.create');
    }

    /**
     * Enregistrer une nouvelle réservation
     */
    public function store(Request $request)
    {
        // Logique de création de réservation
        return redirect()->route('admin.reservations.index')
            ->with('success', 'Réservation créée avec succès');
    }

    /**
     * Afficher une réservation spécifique
     */
    public function show($id)
    {
        return view('admin.reservations.show', compact('id'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit($id)
    {
        return view('admin.reservations.edit', compact('id'));
    }

    /**
     * Mettre à jour une réservation
     */
    public function update(Request $request, $id)
    {
        // Logique de mise à jour
        return redirect()->route('admin.reservations.index')
            ->with('success', 'Réservation mise à jour avec succès');
    }

    /**
     * Supprimer une réservation
     */
    public function destroy($id)
    {
        // Logique de suppression
        return redirect()->route('admin.reservations.index')
            ->with('success', 'Réservation supprimée avec succès');
    }
}

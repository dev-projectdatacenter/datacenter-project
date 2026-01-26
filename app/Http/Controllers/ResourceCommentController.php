<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\ResourceComment;
use Illuminate\Http\Request;

class ResourceCommentController extends Controller
{
    /**
     * Enregistrer un nouveau commentaire
     */
    public function store(Request $request, Resource $resource)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        ResourceComment::create([
            'resource_id' => $resource->id,
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return back()->with('success', 'Commentaire ajouté avec succès.');
    }

    /**
     * Supprimer un commentaire (Admin ou Tech Manager de la ressource)
     */
    public function destroy(ResourceComment $comment)
    {
        // Seul l'admin ou le tech manager responsable de la ressource peut supprimer
        if (auth()->user()->role->name !== 'admin' && auth()->user()->id !== $comment->resource->managed_by) {
            abort(403);
        }

        $comment->delete();

        return back()->with('success', 'Commentaire supprimé.');
    }
}

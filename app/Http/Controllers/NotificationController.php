<?php
/**
 * NotificationController.php
 * Gestion des notifications - Version pure Laravel
 * Géré par HALIMA - Jour 7 (CORRECTION)
 * CONTRAINTES: Laravel pur + CSS/JS personnalisé (sans jQuery, Bootstrap, Tailwind)
 */

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Liste des notifications de l'utilisateur
     */
    public function index(Request $request)
    {
        $query = Notification::where('user_id', auth()->id());
        
        // Filtres personnalisés sans dépendances externes
        if ($request->has('type') && $request->get('type') !== '') {
            $query->where('type', $request->get('type'));
        }
        
        if ($request->has('status') && $request->get('status') !== '') {
            if ($request->get('status') === 'read') {
                $query->where('read', true);
            } elseif ($request->get('status') === 'unread') {
                $query->where('read', false);
            }
        }
        
        $notifications = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Marquer une notification comme lue
     */
    public function markAsRead(Notification $notification)
    {
        // Vérification manuelle des permissions
        if ($notification->user_id !== auth()->id()) {
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        $notification->update(['read' => true]);

        // Réponse JSON pour JavaScript pur
        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Notification marquée comme lue']);
        }

        return back()->with('success', 'Notification marquée comme lue.');
    }

    /**
     * Marquer toutes les notifications comme lues
     */
    public function markAllAsRead()
    {
        $updated = Notification::where('user_id', auth()->id())
            ->where('read', false)
            ->update(['read' => true]);

        // Réponse JSON pour JavaScript pur
        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'updated' => $updated]);
        }

        return back()->with('success', 'Toutes les notifications ont été marquées comme lues.');
    }

    /**
     * Supprimer une notification
     */
    public function destroy(Notification $notification)
    {
        // Vérification manuelle des permissions
        if ($notification->user_id !== auth()->id()) {
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        $notification->delete();

        // Réponse JSON pour JavaScript pur
        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Notification supprimée']);
        }

        return back()->with('success', 'Notification supprimée avec succès.');
    }

    /**
     * API: Nombre de notifications non lues
     */
    public function unreadCount()
    {
        $count = Notification::where('user_id', auth()->id())
            ->where('read', false)
            ->count();

        return response()->json(['count' => $count]);
    }

    /**
     * API: Notifications récentes
     */
    public function recent()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->where('read', false)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return response()->json($notifications);
    }

    /**
     * API: Marquer plusieurs notifications comme lues
     */
    public function markMultipleAsRead(Request $request)
    {
        $request->validate([
            'notification_ids' => 'required|array',
            'notification_ids.*' => 'exists:notifications,id'
        ]);

        $updated = Notification::where('user_id', auth()->id())
            ->whereIn('id', $request->get('notification_ids'))
            ->where('read', false)
            ->update(['read' => true]);

        return response()->json(['success' => true, 'updated' => $updated]);
    }

    /**
     * API: Supprimer plusieurs notifications
     */
    public function destroyMultiple(Request $request)
    {
        $request->validate([
            'notification_ids' => 'required|array',
            'notification_ids.*' => 'exists:notifications,id'
        ]);

        $deleted = Notification::where('user_id', auth()->id())
            ->whereIn('id', $request->get('notification_ids'))
            ->delete();

        return response()->json(['success' => true, 'deleted' => $deleted]);
    }

    /**
     * API: Statistiques des notifications
     */
    public function stats()
    {
        $stats = [
            'total' => Notification::where('user_id', auth()->id())->count(),
            'unread' => Notification::where('user_id', auth()->id())->where('read', false)->count(),
            'read' => Notification::where('user_id', auth()->id())->where('read', true)->count(),
            'by_type' => Notification::where('user_id', auth()->id())
                ->selectRaw('type, COUNT(*) as count')
                ->groupBy('type')
                ->get()
                ->keyBy('type')
        ];

        return response()->json($stats);
    }
}

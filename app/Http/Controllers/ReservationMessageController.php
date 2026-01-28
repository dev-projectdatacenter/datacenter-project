<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\ReservationMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationMessageController extends Controller
{
    /**
     * Afficher les messages d'une réservation
     */
    public function index(Reservation $reservation)
    {
        // Vérifier les permissions
        $this->authorize('view', $reservation);
        
        $messages = $reservation->messages()->with('sender')->get();
        
        // Marquer les messages comme lus
        $reservation->messages()
            ->where('sender_id', '!=', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
        
        return response()->json([
            'messages' => $messages->map(function ($message) {
                return [
                    'id' => $message->id,
                    'sender' => $message->sender->name,
                    'sender_type' => $message->sender_type,
                    'message' => $message->message,
                    'date' => $message->formatted_date,
                    'is_mine' => $message->sender_id === Auth::id()
                ];
            })
        ]);
    }
    
    /**
     * Envoyer un nouveau message
     */
    public function store(Request $request, Reservation $reservation)
    {
        // Vérifier les permissions
        $this->authorize('view', $reservation);
        
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);
        
        $message = ReservationMessage::create([
            'reservation_id' => $reservation->id,
            'sender_id' => Auth::id(),
            'message' => $request->message,
            'sender_type' => Auth::user()->hasRole('tech_manager') ? 'tech_manager' : 'user'
        ]);
        
        // Charger les relations
        $message->load('sender');
        
        return response()->json([
            'success' => true,
            'message' => [
                'id' => $message->id,
                'sender' => $message->sender->name,
                'sender_type' => $message->sender_type,
                'message' => $message->message,
                'date' => $message->formatted_date,
                'is_mine' => true
            ]
        ]);
    }
    
    /**
     * Compter les messages non lus
     */
    public function unreadCount()
    {
        $user = Auth::user();
        
        $query = ReservationMessage::where('is_read', false)
            ->where('sender_id', '!=', $user->id);
        
        // Si c'est un tech manager, il voit tous les messages
        if (!$user->hasRole('tech_manager')) {
            // Si c'est un utilisateur normal, il voit seulement ses réservations
            $userReservations = Reservation::where('user_id', $user->id)->pluck('id');
            $query->whereIn('reservation_id', $userReservations);
        }
        
        $count = $query->count();
        
        return response()->json(['count' => $count]);
    }
}

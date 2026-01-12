<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Notification;
class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $notifications = [
            [
                'user_id' => 3, // Fatima Zahrae
                'type' => 'reservation',
                'message' => 'Votre réservation pour Serveur Dell PowerEdge a été approuvée.',
                'read' => false,
            ],
            [
                'user_id' => 4, // Ouarda
                'type' => 'reservation',
                'message' => 'Votre réservation pour Serveur HPE ProLiant est en attente de validation.',
                'read' => false,
            ],
            [
                'user_id' => 5, // Halima
                'type' => 'maintenance',
                'message' => 'Le NAS Synology sera en maintenance demain de 09h à 12h.',
                'read' => false,
            ],
            [
                'user_id' => 6, // Fatima
                'type' => 'incident',
                'message' => 'Un incident a été signalé sur VM Ubuntu Dev 01.',
                'read' => false,
            ],
        ];

        foreach ($notifications as $notification) {
            Notification::create($notification);
        }
    }
    }


<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ActivityLog;
class ActivityLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $logs = [
            [
                'user_id' => 1, // Chayma (ADMIN)
                'action' => 'create',
                'entity_type' => 'User',
                'entity_id' => 3, // Fatima Zahrae
                'description' => 'Création d’un nouvel utilisateur interne.',
            ],
            [
                'user_id' => 2, // Responsable technique
                'action' => 'update',
                'entity_type' => 'Resource',
                'entity_id' => 3, // NAS Synology
                'description' => 'Mise en maintenance planifiée du NAS Synology.',
            ],
            [
                'user_id' => 3, // Fatima Zahrae
                'action' => 'create',
                'entity_type' => 'Reservation',
                'entity_id' => 1, // Réservation Serveur Dell
                'description' => 'Nouvelle réservation pour projet de test serveur.',
            ],
            [
                'user_id' => 4, // Ouarda
                'action' => 'create',
                'entity_type' => 'Reservation',
                'entity_id' => 2, // Réservation Serveur HPE
                'description' => 'Nouvelle réservation pour simulation réseau.',
            ],
            [
                'user_id' => 5, // Halima
                'action' => 'create',
                'entity_type' => 'Reservation',
                'entity_id' => 3, // VM Ubuntu Dev
                'description' => 'Développement application interne.',
            ],
            [
                'user_id' => 6, // Fatima
                'action' => 'create',
                'entity_type' => 'Reservation',
                'entity_id' => 4, // NAS Synology
                'description' => 'Stockage temporaire des fichiers de projet.',
            ],
            [
                'user_id' => 5, // Halima
                'action' => 'report',
                'entity_type' => 'Incident',
                'entity_id' => 1, // Incident signalé
                'description' => 'Signalement d’un incident sur VM Ubuntu Dev 01.',
            ],
            [
                'user_id' => 7, // Invité Test 1
                'action' => 'request_account',
                'entity_type' => 'AccountRequest',
                'entity_id' => null,
                'description' => 'Demande de création de compte utilisateur.',
            ],
        ];

        foreach ($logs as $log) {
            ActivityLog::create($log);
        }
    }
    }


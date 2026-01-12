<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Incident;
use Carbon\Carbon;
class IncidentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      $incidents = [
            [
                'user_id' => 3, // Fatima Zahrae
                'resource_id' => 2, // VM Ubuntu Dev 01
                'description' => 'La VM Ubuntu Dev 01 ne répond pas au démarrage.',
                'status' => 'open',
            ],
            [
                'user_id' => 4, // Ouarda
                'resource_id' => 1, // Serveur Dell PowerEdge
                'description' => 'Le serveur émet un bruit suspect dans le rack 3.',
                'status' => 'open',
            ],
            [
                'user_id' => 5, // Halima
                'resource_id' => null, // Incident général, pas de ressource spécifique
                'description' => 'Problème de connexion réseau intermittent dans le Data Center.',
                'status' => 'open',
            ],
            [
                'user_id' => 6, // Fatima
                'resource_id' => 4, // Switch Cisco Catalyst 9300
                'description' => 'Port 10 du switch ne fonctionne plus correctement.',
                'status' => 'open',
            ],
        ];

        foreach ($incidents as $incident) {
            Incident::create($incident);
        }
    }
    }


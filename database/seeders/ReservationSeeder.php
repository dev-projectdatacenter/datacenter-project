<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Reservation;
use Carbon\Carbon;
use App\Models\AccountRequest;
class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      $reservations = [
            [
                'user_id' => 3, // Fatima Zahrae
                'resource_id' => 1, // Serveur Dell PowerEdge
                'start_date' => Carbon::now()->addDays(1), // demain
                'end_date' => Carbon::now()->addDays(3),   // après-demain
                'status' => 'pending', // correspond au default de migration
                'justification' => 'Projet de test serveur',
            ],
            [
                'user_id' => 4, // Ouarda
                'resource_id' => 2, // Serveur HPE ProLiant
                'start_date' => Carbon::now()->addDays(2),
                'end_date' => Carbon::now()->addDays(5),
                'status' => 'approved',
                'justification' => 'Besoin pour simulation réseau',
            ],
            [
                'user_id' => 5, // Halima
                'resource_id' => 3, // VM Ubuntu Dev
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addDays(2),
                'status' => 'active',
                'justification' => 'Développement application interne',
            ],
            [
                'user_id' => 6, // Fatima
                'resource_id' => 4, // NAS Synology
                'start_date' => Carbon::now()->addDays(1),
                'end_date' => Carbon::now()->addDays(4),
                'status' => 'finished',
                'justification' => 'Stockage temporaire des fichiers de projet',
            ],
        ];

        foreach ($reservations as $reservation) {
            Reservation::create($reservation);
        }
    }
}
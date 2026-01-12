<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Maintenance;

use Carbon\Carbon;
class MaintenanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          $maintenances = [
            [
                'resource_id' => 3, // NAS Synology DS1821+
                'start_date' => Carbon::now()->addDay(),
                'end_date' => Carbon::now()->addDay()->addHours(3),
                'reason' => 'Vérification RAID et mise à jour DSM',
            ],
            [
                'resource_id' => 2, // VM Ubuntu Dev 01
                'start_date' => Carbon::now()->addDays(2),
                'end_date' => Carbon::now()->addDays(2)->addHours(2),
                'reason' => 'Maintenance de l’OS et patch sécurité',
            ],
            [
                'resource_id' => 4, // Switch Cisco Catalyst 9300
                'start_date' => Carbon::now()->addDays(3),
                'end_date' => Carbon::now()->addDays(3)->addHours(4),
                'reason' => 'Mise à jour firmware IOS XE',
            ],
        ];

        foreach ($maintenances as $maintenance) {
            Maintenance::create($maintenance);
        }
    }
    }


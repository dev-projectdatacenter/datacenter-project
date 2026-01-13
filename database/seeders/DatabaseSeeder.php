<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            // Tables sans dépendances
            RoleSeeder::class,
            ResourceCategorySeeder::class,

            //  Tables dépendantes
            UserSeeder::class,
            ResourceSeeder::class,

            //  Fonctionnel
            ReservationSeeder::class,
            MaintenanceSeeder::class,
            IncidentSeeder::class,

            //  Communication & traçabilité
            NotificationSeeder::class,
            ActivityLogSeeder::class,

            //  Demandes externes
            AccountRequestSeeder::class,
        ]);
    }
    }

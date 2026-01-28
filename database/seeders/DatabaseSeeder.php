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
            // Structure de base
            RoleSeeder::class,
            UserSeeder::class,
            
            // Données de base
            AccountRequestSeeder::class,
            ResourceCategorySeeder::class,
            ResourceSeeder::class,
            
            // Données fonctionnelles
            ReservationSeeder::class,
            IncidentSeeder::class,
            MaintenanceSeeder::class,
            NotificationSeeder::class,
            
            // Audit et logs
            ActivityLogSeeder::class,
            
            // Données de test (optionnel)
            // AdditionalUsersSeeder::class,
            // TestUsersSeeder::class,
        ]);
    }
}

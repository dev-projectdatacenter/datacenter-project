<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class TestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Récupérer les IDs des rôles
        $adminRole = DB::table('roles')->where('name', 'admin')->first();
        $techRole = DB::table('roles')->where('name', 'tech_manager')->first();
        $userRole = DB::table('roles')->where('name', 'user')->first();

        if (!$adminRole || !$techRole || !$userRole) {
            $this->command->error('Veuillez d\'abord exécuter RolesSeeder');
            return;
        }

        // Créer un administrateur
        User::create([
            'role_id' => $adminRole->id,
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => Hash::make('password123'),
            'phone' => '+212600000000',
            'status' => 'active',
        ]);

        // Créer un responsable technique
        User::create([
            'role_id' => $techRole->id,
            'name' => 'Tech Manager Test',
            'email' => 'tech@test.com',
            'password' => Hash::make('password123'),
            'phone' => '+212600000001',
            'status' => 'active',
        ]);

        // Créer un utilisateur interne
        User::create([
            'role_id' => $userRole->id,
            'name' => 'User Test',
            'email' => 'user@test.com',
            'password' => Hash::make('password123'),
            'phone' => '+212600000002',
            'status' => 'active',
        ]);

        $this->command->info('Utilisateurs de test créés avec succès !');
        $this->command->info('Emails disponibles :');
        $this->command->info('- admin@test.com (Administrateur)');
        $this->command->info('- tech@test.com (Responsable technique)');
        $this->command->info('- user@test.com (Utilisateur interne)');
        $this->command->info('Mot de passe pour tous : password123');
    }
}

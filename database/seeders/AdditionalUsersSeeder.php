<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdditionalUsersSeeder extends Seeder
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

        // Utilisateurs supplémentaires pour les tests
        $additionalUsers = [
            // Administrateurs supplémentaires
            [
                'role_id' => $adminRole->id,
                'name' => 'Marie Dupont',
                'email' => 'marie.dupont@test.com',
                'password' => Hash::make('password123'),
                'phone' => '+212600000010',
                'status' => 'active',
            ],
            [
                'role_id' => $adminRole->id,
                'name' => 'Jean Martin',
                'email' => 'jean.martin@test.com',
                'password' => Hash::make('password123'),
                'phone' => '+212600000011',
                'status' => 'active',
            ],
            
            // Responsables techniques supplémentaires
            [
                'role_id' => $techRole->id,
                'name' => 'Pierre Durand',
                'email' => 'pierre.durand@test.com',
                'password' => Hash::make('password123'),
                'phone' => '+212600000020',
                'status' => 'active',
            ],
            [
                'role_id' => $techRole->id,
                'name' => 'Sophie Lefebvre',
                'email' => 'sophie.lefebvre@test.com',
                'password' => Hash::make('password123'),
                'phone' => '+212600000021',
                'status' => 'active',
            ],
            [
                'role_id' => $techRole->id,
                'name' => 'Robert Bernard',
                'email' => 'robert.bernard@test.com',
                'password' => Hash::make('password123'),
                'phone' => '+212600000022',
                'status' => 'inactive',
            ],
            
            // Utilisateurs internes supplémentaires
            [
                'role_id' => $userRole->id,
                'name' => 'Claire Petit',
                'email' => 'claire.petit@test.com',
                'password' => Hash::make('password123'),
                'phone' => '+212600000030',
                'status' => 'active',
            ],
            [
                'role_id' => $userRole->id,
                'name' => 'Lucas Robert',
                'email' => 'lucas.robert@test.com',
                'password' => Hash::make('password123'),
                'phone' => '+212600000031',
                'status' => 'active',
            ],
            [
                'role_id' => $userRole->id,
                'name' => 'Emma Girard',
                'email' => 'emma.girard@test.com',
                'password' => Hash::make('password123'),
                'phone' => '+212600000032',
                'status' => 'active',
            ],
            [
                'role_id' => $userRole->id,
                'name' => 'Nicolas Moreau',
                'email' => 'nicolas.moreau@test.com',
                'password' => Hash::make('password123'),
                'phone' => '+212600000033',
                'status' => 'blocked',
            ],
            [
                'role_id' => $userRole->id,
                'name' => 'Isabelle Laurent',
                'email' => 'isabelle.laurent@test.com',
                'password' => Hash::make('password123'),
                'phone' => '+212600000034',
                'status' => 'active',
            ],
        ];

        foreach ($additionalUsers as $userData) {
            // Vérifier si l'utilisateur existe déjà
            $existingUser = User::where('email', $userData['email'])->first();
            if (!$existingUser) {
                User::create($userData);
                $this->command->info("Utilisateur créé : {$userData['email']}");
            } else {
                $this->command->warn("Utilisateur déjà existant : {$userData['email']}");
            }
        }

        $this->command->info('Utilisateurs supplémentaires créés avec succès !');
        
        // Afficher le résumé
        $totalUsers = User::count();
        $adminCount = User::where('role_id', $adminRole->id)->count();
        $techCount = User::where('role_id', $techRole->id)->count();
        $userCount = User::where('role_id', $userRole->id)->count();
        
        $this->command->info("Total d'utilisateurs : {$totalUsers}");
        $this->command->info("- Administrateurs : {$adminCount}");
        $this->command->info("- Responsables techniques : {$techCount}");
        $this->command->info("- Utilisateurs internes : {$userCount}");
    }
}

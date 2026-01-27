<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AccountRequest;

class AccountRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $requests = [
            // Demandes en attente
            [
                'name' => 'Jean Dupont',
                'email' => 'jean.dupont@entreprise.com',
                'phone' => '+212600123456',
                'role_requested' => 'user',
                'status' => 'pending',
                'created_at' => now()->subDays(2),
            ],
            [
                'name' => 'Marie Curie',
                'email' => 'marie.curie@labo.fr',
                'phone' => '+212600789012',
                'role_requested' => 'tech_manager',
                'status' => 'pending',
                'created_at' => now()->subDay(),
            ],
            [
                'name' => 'Pierre Martin',
                'email' => 'pierre.martin@startup.ma',
                'phone' => '+212600345678',
                'role_requested' => 'user',
                'status' => 'pending',
                'created_at' => now()->subHours(6),
            ],
            // Demandes déjà traitées
            [
                'name' => 'Sophie Laurent',
                'email' => 'sophie.laurent@tech.com',
                'phone' => '+212600111222',
                'role_requested' => 'user',
                'status' => 'approved',
                'created_at' => now()->subDays(5),
            ],
            [
                'name' => 'Thomas Bernard',
                'email' => 'thomas.bernard@suspicious.com',
                'phone' => '+212600999888',
                'role_requested' => 'admin',
                'status' => 'rejected',
                'created_at' => now()->subDays(2),
            ],
        ];

        foreach ($requests as $request) {
            AccountRequest::create($request);
        }

        $this->command->info('Demandes de compte créées avec succès !');
        $this->command->info('📋 Demandes en attente : 3');
        $this->command->info('✅ Demandes approuvées : 1');
        $this->command->info('❌ Demandes refusées : 1');
        $this->command->info('');
        $this->command->info('📧 Emails de test pour les demandes en attente :');
        $this->command->info('- jean.dupont@entreprise.com (Utilisateur interne)');
        $this->command->info('- marie.curie@labo.fr (Responsable technique)');
        $this->command->info('- pierre.martin@startup.ma (Utilisateur interne)');
    }
}
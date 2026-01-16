<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['name' => 'admin', 'description' => 'Administrateur du système'],
            ['name' => 'tech_manager', 'description' => 'Responsable technique des ressources'],
            ['name' => 'user', 'description' => 'Utilisateur interne'],
            ['name' => 'guest', 'description' => 'Invité (accès limité)'],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(
                ['name' => $role['name']],
                $role
            );
        }

        $this->command->info('Rôles créés avec succès !');
    }
}

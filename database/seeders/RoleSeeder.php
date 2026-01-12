<?php

namespace Database\Seeders;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Role::insert([
            [
                'name' => 'ADMIN',
                'description' => 'Administrateur du Data Center : gestion complète des utilisateurs, ressources et statistiques'
            ],
            [
                'name' => 'TECH_MANAGER',
                'description' => 'Responsable technique chargé de superviser et gérer un ensemble de ressources'
            ],
            [
                'name' => 'USER',
                'description' => 'Utilisateur interne pouvant réserver des ressources et signaler des incidents'
            ],
            [
                'name' => 'INVITE',
                'description' => 'Invité : accès lecture seule, peut demander un compte'
            ],
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ResourceCategory;
class ResourceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $categories = [
            [
                'name' => 'Serveurs physiques',
                'description' => 'Serveurs dédiés hébergés dans le Data Center'
            ],
            [
                'name' => 'Machines virtuelles',
                'description' => 'VMs créées sur les hyperviseurs pour différents services'
            ],
            [
                'name' => 'Stockage',
                'description' => 'Équipements de stockage comme NAS ou SAN'
            ],
            [
                'name' => 'Équipements réseau',
                'description' => 'Switches, routeurs et autres équipements réseau'
            ],
        ];

        foreach ($categories as $category) {
            ResourceCategory::create($category);
        }
    }
}

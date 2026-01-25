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
                'description' => 'Serveurs dédiés hébergés dans le Data Center',
                'image_url' => 'images/categories/servers.png'
            ],
            [
                'name' => 'Machines virtuelles',
                'description' => 'VMs créées sur les hyperviseurs pour différents services',
                'image_url' => 'images/categories/vms.png'
            ],
            [
                'name' => 'Stockage',
                'description' => 'Équipements de stockage comme NAS ou SAN',
                'image_url' => 'images/categories/storage.png'
            ],
            [
                'name' => 'Équipements réseau',
                'description' => 'Switches, routeurs et autres équipements réseau',
                'image_url' => 'images/categories/network.png'
            ],
        ];

        foreach ($categories as $category) {
            ResourceCategory::updateOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}

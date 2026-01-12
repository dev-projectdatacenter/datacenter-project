<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Resource;

class ResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $resources = [
            [
                'category_id' => 1, 
                'name' => 'Serveur Dell PowerEdge R740',
                'status' => 'available',
                'cpu' => 'Intel Xeon Silver 4210',
                'ram' => '64GB',
                'storage' => '2TB SSD',
                'os' => 'Ubuntu 22.04',
                'location' => null,
            ],
            [
                'category_id' => 2, 
                'name' => 'VM Ubuntu Dev 01',
                'status' => 'busy',
                'cpu' => '4 vCPU',
                'ram' => '16GB',
                'storage' => '200GB',
                'os' => 'Ubuntu 22.04',
                'location' => null,
            ],
            [
                'category_id' => 3, 
                'name' => 'NAS Synology DS1821+',
                'status' => 'available',
                'cpu' => null,
                'ram' => null,
                'storage' => '16TB RAID6',
                'os' => 'DSM 7.2',
                'location' => null,
            ],
            [
                'category_id' => 4, 
                'name' => 'Switch Cisco Catalyst 9300',
                'status' => 'available',
                'cpu' => null,
                'ram' => null,
                'storage' => null,
                'os' => 'IOS XE 17.6',
                'location' => null,
            ],
        ];

        foreach ($resources as $resource) {
            Resource::create($resource);
        }
    }
}
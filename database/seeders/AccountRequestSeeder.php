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
            [
                'name' => 'Sara Benali',
                'email' => 'sara.benali@example.com',
                'phone' => '0661112233',
                'status' => 'pending',
                'role_requested' => 'USER',
            ],
            [
                'name' => 'Karim El Fassi',
                'email' => 'karim.elfassi@example.com',
                'phone' => '0672223344',
                'status' => 'pending',
                'role_requested' => 'INVITE',
            ],
            [
                'name' => 'Amina Rahimi',
                'email' => 'amina.rahimi@example.com',
                'phone' => '0683334455',
                'status' => 'approved',
                'role_requested' => 'USER',
            ],
            [
                'name' => 'Mohamed Idrissi',
                'email' => 'mohamed.idrissi@example.com',
                'phone' => null,
                'status' => 'rejected',
                'role_requested' => 'TECH_MANAGER',
            ],
        ];

        foreach ($requests as $request) {
            AccountRequest::create($request);
        }
    }
}
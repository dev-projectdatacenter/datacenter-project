<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class UserSeeder extends Seeder
{
  /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // -------------------
        // 1. Administrateur (role_id = 1)
        // -------------------
        User::create([
            'name' => 'Chayma',
            'email' => 'Chayma@gmail.ma',
            'password' => Hash::make('admin1234'),
            'role_id' => 1, // ADMIN
            'phone' => '0600000000',
            'status' => 'active',
        ]);

        // -------------------
        // 2. Responsable technique (role_id = 2)
        // -------------------
        User::create([
            'name' => 'Responsable Technique',
            'email' => 'tech.manager@datacenter.com',
            'password' => Hash::make('tech1234'),
            'role_id' => 2, // TECH_MANAGER
            'phone' => '0611111111',
            'status' => 'active',
        ]);

        // -------------------
        // 3. Utilisateurs internes (role_id = 3)
        // -------------------
        $internalUsers = [
            ['name' => 'Fatima Zahrae', 'email' => 'fatimaZahrae@gmail.ma', 'phone' => '0622222222'],
            ['name' => 'Ouarda', 'email' => 'Ouarda@gmail.ma', 'phone' => '0622223333'],
            ['name' => 'Halima', 'email' => 'Halima@gmail.ma', 'phone' => '0633334444'],
            ['name' => 'Fatima', 'email' => 'Fatima@gmail.ma', 'phone' => '0644445555'],
        ];

        foreach ($internalUsers as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make('user1234'),
                'role_id' => 3, // USER
                'phone' => $user['phone'],
                'status' => 'active',
            ]);
        }

        // -------------------
        // 4. Invités (role_id = 4)
        // -------------------
        $inviteUsers = [
            ['name' => 'Invité Test 1', 'email' => 'invite1@gmail.ma', 'phone' => '0655556666'],
            ['name' => 'Invité Test 2', 'email' => 'invite2@gmail.ma', 'phone' => null],
        ];

        foreach ($inviteUsers as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make('guest1234'),
                'role_id' => 4, // INVITE
                'phone' => $user['phone'],
                'status' => 'inactive', // en attente d'activation
            ]);
        }
    }
}

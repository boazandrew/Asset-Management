<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@email.com'],
            [
                'name' => 'Admin User',
                'role' => 'admin',
                'password' => Hash::make('admin123'),
            ]
        );

        // Users
        $users = [
            ['name' => 'Ramesh', 'email' => 'user1@email.com'],
            ['name' => 'Suresh', 'email' => 'user2@email.com'],
            ['name' => 'Rajesh', 'email' => 'user3@email.com'],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'role' => 'user',
                    'password' => Hash::make('user123'),
                ]
            );
        }
    }
}

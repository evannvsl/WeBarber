<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class DatabaseSeeder extends Seeder
{
    
    public function run(): void
{
    $admins = [
        [
            'name' => 'Admin',
            'email' => env('ADMIN_EMAIL'),
            'password' => env('ADMIN_PASSWORD'),
        ],
        [
            'name' => 'Admin Satu',
            'email' => env('ADMIN2_EMAIL'),
            'password' => env('ADMIN2_PASSWORD'),
        ],
        [
            'name' => 'Admin Kedua',
            'email' => env('ADMIN3_EMAIL'),
            'password' => env('ADMIN3_PASSWORD'),
        ],
    ];

    foreach ($admins as $admin) {
        if (empty($admin['email']) || empty($admin['password'])) {
            continue;
        }

        User::firstOrCreate(
            ['email' => $admin['email']],
            [
                'name' => $admin['name'],
                'password' => Hash::make($admin['password']),
                'role' => 'admin',
            ]
        );
    }
}
}
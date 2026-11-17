<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@powerveda.com'],
            [
                'name' => 'Yuvar Dhan Admin',
                'password' => 'Admin@12345',
                'contactNo' => '+91 9876543210',
                'role' => 'Admin',
                'email_verified_at' => now(),
            ]
        );
    }
}

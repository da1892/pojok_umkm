<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@pojokumkm.com'],
            [
                'name' => 'Admin Wonogiri',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );
    }
}

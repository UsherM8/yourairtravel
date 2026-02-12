<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!User::where('email', 'admin@yourairtravel.nl')->exists()) {
            User::create([
                'name' => 'Admin Usher',
                'email' => 'admin@yourairtravel.nl',
                'password' => Hash::make('password'), // Je wachtwoord is 'password'
            ]);
        }
    }
}

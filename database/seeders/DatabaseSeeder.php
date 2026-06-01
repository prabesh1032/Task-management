<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Only create admin if doesn't exist
        if (!User::where('email', 'admin@gmail.com')->exists()) {
            User::create([
                'name'     => 'Admin',
                'email'    => 'admin@gmail.com',
                'password' => bcrypt('12345678'),
                'role'     => 'admin',
            ]);
        }
    }
}

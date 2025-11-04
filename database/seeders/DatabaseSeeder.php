<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserAdmin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@bina-adult-care.com',
            'password' => Hash::make('admin123')
        ]);

        UserAdmin::create([
            'user_id' => $user->id,
            'role' => 'admin'
        ]);

        // Seed content and services
        $this->call([
            ServiceSeeder::class,
            ContentSeeder::class,
        ]);
    }
}

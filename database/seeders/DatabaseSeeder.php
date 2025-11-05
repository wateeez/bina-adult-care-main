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
        // Seed content, services, benefits, and admin accounts
        $this->call([
            ServiceSeeder::class,
            ContentSeeder::class,
            BenefitSeeder::class,
            UserAdminSeeder::class, // Creates admin accounts with email/password
        ]);
    }
}

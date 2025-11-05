<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserAdmin;
use Illuminate\Support\Facades\Hash;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default super admin account
        UserAdmin::create([
            'email' => 'admin@binaadultcare.com',
            'password' => Hash::make('Admin@123'),
            'role' => 'super_admin',
            'is_active' => true
        ]);

        // Create a content editor for demonstration
        UserAdmin::create([
            'email' => 'editor@binaadultcare.com',
            'password' => Hash::make('Editor@123'),
            'role' => 'content_editor',
            'is_active' => true
        ]);

        echo "\n✅ Default admin accounts created:\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "🔴 SUPER ADMIN:\n";
        echo "   Email: admin@binaadultcare.com\n";
        echo "   Password: Admin@123\n";
        echo "\n🟢 CONTENT EDITOR:\n";
        echo "   Email: editor@binaadultcare.com\n";
        echo "   Password: Editor@123\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "⚠️  IMPORTANT: Change these passwords after first login!\n\n";
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, update existing data to match new enum values
        DB::statement("UPDATE `user_admin` SET `role` = 'super_admin' WHERE `role` = 'admin'");
        
        // Drop the foreign key and existing columns we don't need
        Schema::table('user_admin', function (Blueprint $table) {
            if (Schema::hasColumn('user_admin', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
            if (Schema::hasColumn('user_admin', 'permissions')) {
                $table->dropColumn('permissions');
            }
        });

        // Now modify the table structure
        Schema::table('user_admin', function (Blueprint $table) {
            // Modify existing role column
            DB::statement("ALTER TABLE `user_admin` MODIFY COLUMN `role` enum('super_admin', 'content_editor') NOT NULL DEFAULT 'content_editor'");
            
            // Add email authentication
            if (!Schema::hasColumn('user_admin', 'email')) {
                $table->string('email')->unique()->after('role');
            }
            
            // Add password column if it doesn't exist
            if (!Schema::hasColumn('user_admin', 'password')) {
                $table->string('password', 255)->after('email');
            }
            
            // Session management
            if (!Schema::hasColumn('user_admin', 'last_activity')) {
                $table->timestamp('last_activity')->nullable()->after('password');
            }
            
            // Account status
            if (!Schema::hasColumn('user_admin', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('last_activity');
            }
        });
        
        // Delete old admin records since we'll create new ones with email/password
        DB::statement("TRUNCATE TABLE `user_admin`");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_admin', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('id');
            $table->json('permissions')->nullable();
            
            $table->dropColumn([
                'email',
                'password',
                'last_activity',
                'is_active'
            ]);
            
            DB::statement("ALTER TABLE `user_admin` MODIFY COLUMN `role` varchar(255) NOT NULL DEFAULT 'admin'");
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};

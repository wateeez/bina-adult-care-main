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
        // Skip complex MySQL-only alterations when running tests on sqlite to avoid syntax errors.
        if (DB::getDriverName() !== 'mysql') {
            // Lightweight noop for non-MySQL (e.g. sqlite in tests). Ensures migration is marked run.
            return;
        }

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

        // Now modify the table structure (MySQL only)
        Schema::table('user_admin', function (Blueprint $table) {
            DB::statement("ALTER TABLE `user_admin` MODIFY COLUMN `role` enum('super_admin', 'content_editor') NOT NULL DEFAULT 'content_editor'");

            if (!Schema::hasColumn('user_admin', 'email')) {
                $table->string('email')->unique()->after('role');
            }
            if (!Schema::hasColumn('user_admin', 'password')) {
                $table->string('password', 255)->after('email');
            }
            if (!Schema::hasColumn('user_admin', 'last_activity')) {
                $table->timestamp('last_activity')->nullable()->after('password');
            }
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
        if (DB::getDriverName() !== 'mysql') {
            // Nothing to revert for non-MySQL test runs.
            return;
        }
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admin_activity_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_admin_id');
            $table->string('action_type', 50); // login, create, update, delete, etc.
            $table->string('module', 50); // services, benefits, admins, etc.
            $table->text('description'); // Detailed description of the action
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->json('old_values')->nullable(); // Store previous values for updates
            $table->json('new_values')->nullable(); // Store new values for updates
            $table->timestamps();

            $table->foreign('user_admin_id')->references('id')->on('user_admin')->onDelete('cascade');
            $table->index('user_admin_id');
            $table->index('action_type');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_activity_logs');
    }
};

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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('type', ['bar', 'popup'])->default('bar');
            
            // Content
            $table->text('text_content')->nullable();
            $table->string('image_path')->nullable();
            $table->string('link_url')->nullable();
            $table->string('link_text')->default('Learn More');
            
            // Display settings
            $table->boolean('is_active')->default(false);
            $table->string('background_color')->default('#4A90E2');
            $table->string('text_color')->default('#ffffff');
            
            // Popup specific settings
            $table->integer('delay_seconds')->default(3); // Delay before showing popup
            $table->boolean('show_once_per_session')->default(true);
            
            // Scheduling (optional)
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index('type');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};

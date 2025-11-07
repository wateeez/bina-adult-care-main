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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('header_image')->nullable();
            $table->string('author_name')->default('Bina Adult Care');
            
            // SEO fields
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            
            // Publishing
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            
            // View count
            $table->integer('view_count')->default(0);
            
            $table->timestamps();
            
            // Indexes for performance
            $table->index('slug');
            $table->index('is_published');
            $table->index('published_at');
        });
        
        Schema::create('blog_paragraph_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_id')->constrained()->onDelete('cascade');
            $table->string('image_path');
            $table->integer('paragraph_number'); // Which paragraph this image belongs to
            $table->string('caption')->nullable();
            $table->string('alt_text')->nullable();
            $table->integer('order')->default(0); // Order within the paragraph
            $table->timestamps();
            
            // Indexes
            $table->index(['blog_id', 'paragraph_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_paragraph_images');
        Schema::dropIfExists('blogs');
    }
};

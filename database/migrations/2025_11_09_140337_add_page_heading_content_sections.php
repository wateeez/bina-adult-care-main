<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Content;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $sections = [
            ['section' => 'home_hero_title', 'content' => 'Owned, Operated, and Managed by Caregivers.'],
            ['section' => 'home_hero_subtitle', 'content' => 'We look after your best interests, with a profound understanding of the challenges caregivers face firsthand.'],
            ['section' => 'home_program_title', 'content' => 'Bina Adult Care: The Human Service and Home Health Workers Loan Repayment Program'],
            ['section' => 'home_program_text', 'content' => 'Our employees are eligible through the Bina Adult care Program.'],
            ['section' => 'about_story_title', 'content' => 'Our Story'],
            ['section' => 'about_mission_title', 'content' => 'Our Mission'],
            ['section' => 'gallery_hero', 'content' => 'Photo Gallery'],
            ['section' => 'gallery_subtitle', 'content' => 'Explore our collection of memorable moments'],
            ['section' => 'contact_hero', 'content' => 'Get in Touch'],
            ['section' => 'contact_subtitle', 'content' => 'We\'re here to answer your questions and discuss your care needs.'],
        ];

        foreach ($sections as $section) {
            Content::firstOrCreate(
                ['section' => $section['section']],
                $section
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $sections = [
            'home_hero_title',
            'home_hero_subtitle',
            'home_program_title',
            'home_program_text',
            'about_story_title',
            'about_mission_title',
            'gallery_hero',
            'gallery_subtitle',
            'contact_hero',
            'contact_subtitle',
        ];

        Content::whereIn('section', $sections)->delete();
    }
};

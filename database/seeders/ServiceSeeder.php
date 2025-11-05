<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title' => 'Personal Care Assistance',
                'description' => 'Professional assistance with daily activities including bathing, dressing, grooming, and mobility support.',
                'image' => null,
            ],
            [
                'title' => 'Companionship & Emotional Support',
                'description' => 'Friendly conversation, social engagement, and emotional support to enhance quality of life.',
                'image' => null,
            ],
            [
                'title' => 'Medication Reminders',
                'description' => 'Timely medication reminders and assistance with organizing prescriptions.',
                'image' => null,
            ],
            [
                'title' => 'Light Housekeeping',
                'description' => 'Assistance with maintaining a clean and organized living environment.',
                'image' => null,
            ],
            [
                'title' => 'Respite Care',
                'description' => 'Temporary relief for family caregivers to prevent burnout and ensure continued quality care.',
                'image' => null,
            ],
            [
                'title' => 'Transportation Assistance',
                'description' => 'Safe and reliable transportation for medical appointments, shopping, and social activities.',
                'image' => null,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
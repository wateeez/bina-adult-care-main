<?php

namespace Database\Seeders;

use App\Models\Benefit;
use Illuminate\Database\Seeder;

class BenefitSeeder extends Seeder
{
    public function run(): void
    {
        $benefits = [
            [
                'title' => 'Certified Training and Education',
                'icon' => 'fas fa-certificate',
                'description' => 'Access to professional training programs and certifications',
                'order' => 1
            ],
            [
                'title' => 'Industry-Leading Wages',
                'icon' => 'fas fa-dollar-sign',
                'description' => 'Competitive compensation packages',
                'order' => 2
            ],
            [
                'title' => '401(k) Plan',
                'icon' => 'fas fa-piggy-bank',
                'description' => 'Retirement savings with employer matching',
                'order' => 3
            ],
            [
                'title' => 'Flexible Hours',
                'icon' => 'fas fa-clock',
                'description' => 'Work schedules that fit your lifestyle',
                'order' => 4
            ],
            [
                'title' => 'Employee Recognition Programs',
                'icon' => 'fas fa-award',
                'description' => 'Celebrate achievements and milestones',
                'order' => 5
            ],
            [
                'title' => 'Health Insurance',
                'icon' => 'fas fa-heart',
                'description' => 'Comprehensive health coverage for you and your family',
                'order' => 6
            ]
        ];

        foreach ($benefits as $benefit) {
            Benefit::create($benefit);
        }
    }
}

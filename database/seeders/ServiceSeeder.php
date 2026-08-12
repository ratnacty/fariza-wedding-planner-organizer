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
                'name' => 'Wedding Organizer',
                'slug' => 'wedding-organizer',
                'icon' => 'flower',
                'description' => 'Perencanaan pernikahan dari awal hingga hari H, dengan konsep yang elegan dan terorganisir.',
                'order' => 1,
            ],
            [
                'name' => 'Makeup Artist (MUA)',
                'slug' => 'makeup-artist',
                'icon' => 'sparkles',
                'description' => 'Riasan profesional untuk mempercantik penampilan Anda di hari istimewa.',
                'order' => 2,
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['slug' => $service['slug']], $service);
        }
    }
}

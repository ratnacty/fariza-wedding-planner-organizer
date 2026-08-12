<?php

namespace Database\Seeders;

use App\Models\HeroSlide;
use Illuminate\Database\Seeder;

class HeroSlideSeeder extends Seeder
{
    public function run(): void
    {
        $slides = [
            [
                'eyebrow' => 'Wujudkan',
                'title' => 'Pernikahan Impian Anda',
                'subtitle' => 'Fariza Wedding Organizer siap membantu mewujudkan momen pernikahan yang berkesan dan tak terlupakan.',
                'cover_color' => 'rose',
                'order' => 1,
            ],
            [
                'eyebrow' => 'Elegan & Berkesan',
                'title' => 'Setiap Detail Kami Rancang untuk Anda',
                'subtitle' => 'Dari dekorasi hingga dokumentasi, tim kami mengurus semuanya dengan sentuhan personal.',
                'cover_color' => 'blush',
                'order' => 2,
            ],
            [
                'eyebrow' => 'Tim Profesional',
                'title' => 'Dipercaya Ratusan Pasangan Bahagia',
                'subtitle' => 'Konsep modern, pelayanan penuh makna, dan hasil yang selalu memukau.',
                'cover_color' => 'rose',
                'order' => 3,
            ],
        ];

        foreach ($slides as $slide) {
            HeroSlide::updateOrCreate(['title' => $slide['title']], $slide);
        }
    }
}

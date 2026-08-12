<?php

namespace Database\Seeders;

use App\Models\Gallery;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['title' => 'Momen Bahagia Pengantin', 'category' => 'Pengantin', 'cover_color' => 'blush'],
            ['title' => 'Rangkaian Buket Segar', 'category' => 'Dekorasi', 'cover_color' => 'rose'],
            ['title' => 'Tata Meja Resepsi', 'category' => 'Venue', 'cover_color' => 'blush'],
            ['title' => 'Pelaminan Elegan', 'category' => 'Dekorasi', 'cover_color' => 'rose'],
            ['title' => 'Detail Bunga Meja', 'category' => 'Dekorasi', 'cover_color' => 'blush'],
            ['title' => 'Meja Hantaran & Lilin', 'category' => 'Venue', 'cover_color' => 'rose'],
        ];

        foreach ($items as $index => $item) {
            Gallery::updateOrCreate(
                ['title' => $item['title']],
                array_merge($item, ['order' => $index + 1])
            );
        }
    }
}

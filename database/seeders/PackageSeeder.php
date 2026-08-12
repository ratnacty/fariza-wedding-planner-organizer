<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'name' => 'Silver',
                'slug' => 'silver',
                'tier' => 'Silver',
                'tagline' => 'Awal yang manis untuk hari bahagia Anda',
                'description' => 'Paket pernikahan dengan pelayanan lengkap dan berkualitas, cocok untuk resepsi intim hingga 150 tamu undangan.',
                'price' => 25000000,
                'features' => [
                    'Dekorasi pelaminan minimalis elegan',
                    'MC & dokumentasi foto',
                    'Among tamu 4 orang',
                    'Kapasitas hingga 150 tamu',
                    'Konsultasi 3x sebelum hari H',
                ],
                'cover_color' => 'blush',
                'order' => 1,
            ],
            [
                'name' => 'Gold',
                'slug' => 'gold',
                'tier' => 'Gold',
                'tagline' => 'Kemewahan yang seimbang, kenangan tak terlupakan',
                'description' => 'Paket pernikahan dengan pelayanan lengkap dan berkualitas, dilengkapi dekorasi premium dan dokumentasi sinematik.',
                'price' => 45000000,
                'features' => [
                    'Dekorasi pelaminan premium bertema',
                    'MC, dokumentasi foto & video sinematik',
                    'Among tamu 6 orang',
                    'Kapasitas hingga 300 tamu',
                    'Konsultasi tak terbatas sebelum hari H',
                    'Souvenir untuk 300 tamu',
                ],
                'cover_color' => 'rose',
                'is_featured' => true,
                'order' => 2,
            ],
            [
                'name' => 'Platinum',
                'slug' => 'platinum',
                'tier' => 'Platinum',
                'tagline' => 'Pernikahan impian tanpa kompromi',
                'description' => 'Paket pernikahan dengan pelayanan lengkap dan berkualitas untuk resepsi megah dengan sentuhan personal di setiap detail.',
                'price' => 75000000,
                'features' => [
                    'Dekorasi pelaminan mewah custom design',
                    'Tim dokumentasi foto & video sinematik lengkap',
                    'Among tamu 10 orang',
                    'Kapasitas hingga 500 tamu',
                    'Konsultasi tak terbatas + wedding rehearsal',
                    'Souvenir premium untuk seluruh tamu',
                    'Prewedding photoshoot',
                ],
                'cover_color' => 'blush',
                'order' => 3,
            ],
        ];

        foreach ($packages as $package) {
            Package::updateOrCreate(['slug' => $package['slug']], $package);
        }
    }
}

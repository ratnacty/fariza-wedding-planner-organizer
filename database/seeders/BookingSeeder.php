<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\BlockedDate;
use App\Models\Package;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $service = Service::first();
        $package = Package::where('slug', 'gold')->first();
        $today = Carbon::today();

        $partial = $today->copy()->addDays(4);
        Booking::updateOrCreate(
            ['whatsapp' => '081234500001', 'wedding_date' => $partial->toDateString()],
            [
                'name' => 'Dinda & Raka',
                'event_location' => 'Serpong, Tangerang Selatan',
                'service_id' => $service?->id,
                'package_id' => $package?->id,
                'message' => 'Ingin survei lokasi dan konsultasi dekorasi.',
                'status' => Booking::STATUS_CONFIRMED,
            ]
        );

        $full = $today->copy()->addDays(11);
        foreach ([1, 2] as $i) {
            Booking::updateOrCreate(
                ['whatsapp' => "08123450001{$i}", 'wedding_date' => $full->toDateString()],
                [
                    'name' => "Calon Pengantin {$i}",
                    'event_location' => 'Tangerang Selatan',
                    'service_id' => $service?->id,
                    'package_id' => $package?->id,
                    'message' => 'Booking survei tanggal.',
                    'status' => Booking::STATUS_CONFIRMED,
                ]
            );
        }

        BlockedDate::updateOrCreate(
            ['date' => $today->copy()->addDays(17)->toDateString()],
            ['reason' => 'Hari libur nasional']
        );
    }
}

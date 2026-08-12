<?php

namespace App\Support;

use App\Models\BlockedDate;
use App\Models\Booking;
use Carbon\CarbonImmutable;

class BookingCalendar
{
    const STATUS_PAST = 'lewat';
    const STATUS_AVAILABLE = 'tersedia';
    const STATUS_PARTIAL = 'terbooking';
    const STATUS_FULL = 'penuh';

    /**
     * Build a day-by-day availability map for the given month.
     *
     * @return array<int, array{status: string, count: int, capacity: int}>
     */
    public static function forMonth(int $year, int $month): array
    {
        $capacity = (int) config('booking.daily_capacity');
        $start = CarbonImmutable::create($year, $month, 1)->startOfDay();
        $end = $start->endOfMonth();
        $today = CarbonImmutable::today();

        $bookedCounts = Booking::query()
            ->whereBetween('wedding_date', [$start->toDateString(), $end->toDateString()])
            ->where('status', '!=', Booking::STATUS_CANCELLED)
            ->selectRaw('wedding_date, count(*) as total')
            ->groupBy('wedding_date')
            ->pluck('total', 'wedding_date')
            ->mapWithKeys(fn ($total, $date) => [substr($date, 8, 2) => $total]);

        $blocked = BlockedDate::query()
            ->whereBetween('date', [$start->toDateString(), $end->toDateString()])
            ->pluck('date')
            ->map(fn ($date) => substr($date, 8, 2))
            ->flip();

        $days = [];

        for ($date = $start; $date->lte($end); $date = $date->addDay()) {
            $dayKey = $date->format('d');
            $count = (int) ($bookedCounts[$dayKey] ?? 0);

            if ($date->lt($today)) {
                $status = self::STATUS_PAST;
            } elseif (isset($blocked[$dayKey]) || $count >= $capacity) {
                $status = self::STATUS_FULL;
            } elseif ($count > 0) {
                $status = self::STATUS_PARTIAL;
            } else {
                $status = self::STATUS_AVAILABLE;
            }

            $days[(int) $dayKey] = [
                'status' => $status,
                'count' => $count,
                'capacity' => $capacity,
            ];
        }

        return $days;
    }

    public static function isBookable(string $date): bool
    {
        $capacity = (int) config('booking.daily_capacity');
        $carbonDate = CarbonImmutable::parse($date)->startOfDay();

        if ($carbonDate->lt(CarbonImmutable::today())) {
            return false;
        }

        if (BlockedDate::where('date', $carbonDate->toDateString())->exists()) {
            return false;
        }

        $count = Booking::where('wedding_date', $carbonDate->toDateString())
            ->where('status', '!=', Booking::STATUS_CANCELLED)
            ->count();

        return $count < $capacity;
    }
}

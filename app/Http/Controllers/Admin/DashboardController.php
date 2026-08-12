<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Gallery;
use App\Models\Package;
use App\Models\Service;
use App\Support\BookingCalendar;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $today = Carbon::today();
        $monthNames = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        $bookingsThisMonth = Booking::whereBetween('created_at', [$today->copy()->startOfMonth(), $today->copy()->endOfMonth()])->count();
        $bookingsLastMonth = Booking::whereBetween('created_at', [$today->copy()->subMonthNoOverflow()->startOfMonth(), $today->copy()->subMonthNoOverflow()->endOfMonth()])->count();
        $trendPercent = $bookingsLastMonth > 0
            ? round((($bookingsThisMonth - $bookingsLastMonth) / $bookingsLastMonth) * 100)
            : ($bookingsThisMonth > 0 ? 100 : 0);

        $statusCounts = Booking::selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status');
        $totalBookings = (int) $statusCounts->sum();
        $statusBreakdown = collect([
            ['key' => Booking::STATUS_PENDING, 'label' => 'Menunggu', 'color' => '#f0c14b'],
            ['key' => Booking::STATUS_CONFIRMED, 'label' => 'Dikonfirmasi', 'color' => '#7fb88f'],
            ['key' => Booking::STATUS_CANCELLED, 'label' => 'Dibatalkan', 'color' => '#e2748d'],
        ])->map(function ($item) use ($statusCounts, $totalBookings) {
            $count = (int) ($statusCounts[$item['key']] ?? 0);
            $item['count'] = $count;
            $item['percent'] = $totalBookings > 0 ? round(($count / $totalBookings) * 100) : 0;

            return $item;
        });

        return view('admin.dashboard', [
            'totalPackages' => Package::count(),
            'totalServices' => Service::count(),
            'totalGalleries' => Gallery::count(),
            'totalBookings' => $totalBookings,
            'bookingsThisMonth' => $bookingsThisMonth,
            'trendPercent' => $trendPercent,
            'pendingBookings' => (int) ($statusCounts[Booking::STATUS_PENDING] ?? 0),
            'statusBreakdown' => $statusBreakdown,

            'latestBookings' => Booking::with(['service', 'package'])
                ->latest()
                ->take(5)
                ->get(),

            'upcomingBookings' => Booking::with(['service', 'package'])
                ->where('wedding_date', '>=', $today)
                ->orderBy('wedding_date')
                ->take(5)
                ->get(),

            'popularPackages' => Package::withCount('bookings')
                ->having('bookings_count', '>', 0)
                ->orderByDesc('bookings_count')
                ->take(3)
                ->get(),

            'calendarYear' => $today->year,
            'calendarMonth' => $today->month,
            'calendarDays' => BookingCalendar::forMonth($today->year, $today->month),
            'calendarDaysInMonth' => $today->daysInMonth,
            'calendarStartOffset' => ($today->copy()->startOfMonth()->dayOfWeekIso - 1),
            'calendarMonthLabel' => $monthNames[$today->month].' '.$today->year,
        ]);
    }
}

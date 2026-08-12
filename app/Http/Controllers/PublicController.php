<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\HeroSlide;
use App\Models\Package;
use App\Models\Service;
use App\Support\BookingCalendar;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class PublicController extends Controller
{
    public function home(): View
    {
        $today = Carbon::today();
        $monthNames = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        return view('public.home', [
            'slides' => HeroSlide::where('is_active', true)->orderBy('order')->get(),
            'services' => Service::where('is_active', true)->orderBy('order')->get(),
            'packages' => Package::where('is_active', true)->orderBy('order')->take(3)->get(),
            'galleries' => Gallery::orderBy('order')->take(6)->get(),
            'calendarYear' => $today->year,
            'calendarMonth' => $today->month,
            'calendarDays' => BookingCalendar::forMonth($today->year, $today->month),
            'calendarDaysInMonth' => $today->daysInMonth,
            'calendarStartOffset' => ($today->copy()->startOfMonth()->dayOfWeekIso - 1),
            'calendarMonthLabel' => $monthNames[$today->month].' '.$today->year,
            'servicesForBooking' => Service::where('is_active', true)->orderBy('order')->get(),
            'packagesForBooking' => Package::where('is_active', true)->orderBy('order')->get(),
        ]);
    }
}

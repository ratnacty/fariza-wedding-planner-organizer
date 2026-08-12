<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingStoreRequest;
use App\Models\Booking;
use App\Support\BookingCalendar;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function calendar(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'year' => ['required', 'integer', 'min:2020', 'max:2100'],
            'month' => ['required', 'integer', 'min:1', 'max:12'],
        ]);

        return response()->json([
            'days' => BookingCalendar::forMonth($validated['year'], $validated['month']),
        ]);
    }

    public function store(BookingStoreRequest $request): RedirectResponse|JsonResponse
    {
        $booking = Booking::create($request->validated());

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Booking survei berhasil dikirim! Tim kami akan segera menghubungi Anda.',
                'code' => $booking->code,
            ]);
        }

        return back()->with('booking_success', 'Booking survei berhasil dikirim! Tim kami akan segera menghubungi Anda via WhatsApp. Kode booking: '.$booking->code);
    }
}

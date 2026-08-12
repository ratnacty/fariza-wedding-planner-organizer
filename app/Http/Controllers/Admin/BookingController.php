<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlockedDate;
use App\Models\Booking;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status');

        $bookings = Booking::with(['service', 'package'])
            ->when($status, fn ($q) => $q->where('status', $status))
            ->orderByDesc('wedding_date')
            ->paginate(15)
            ->withQueryString();

        return view('admin.bookings.index', [
            'bookings' => $bookings,
            'status' => $status,
            'blockedDates' => BlockedDate::where('date', '>=', Carbon::today())->orderBy('date')->get(),
        ]);
    }

    public function update(Request $request, Booking $booking): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:pending,confirmed,cancelled'],
        ]);

        $booking->update($data);

        return back()->with('status', 'Status booking berhasil diperbarui.');
    }

    public function destroy(Booking $booking): RedirectResponse
    {
        $booking->delete();

        return back()->with('status', 'Booking berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlockedDate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BlockedDateController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'date' => ['required', 'date', 'after_or_equal:today', 'unique:blocked_dates,date'],
            'reason' => ['nullable', 'string', 'max:255'],
        ]);

        BlockedDate::create($data);

        return back()->with('status', 'Tanggal berhasil ditutup dari kalender booking.');
    }

    public function destroy(BlockedDate $blockedDate): RedirectResponse
    {
        $blockedDate->delete();

        return back()->with('status', 'Tanggal berhasil dibuka kembali.');
    }
}

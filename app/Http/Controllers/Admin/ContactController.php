<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function edit(): View
    {
        return view('admin.contact.edit', [
            'contact' => Contact::first() ?? new Contact(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:150'],
            'address' => ['nullable', 'string', 'max:255'],
            'hours' => ['nullable', 'string', 'max:150'],
            'map_url' => ['nullable', 'url', 'max:500'],
        ]);

        if (! empty($data['map_url'])) {
            $coordinates = $this->extractCoordinates($data['map_url']);

            if (! $coordinates) {
                return back()->withInput()->withErrors([
                    'map_url' => 'Link Maps tidak bisa dibaca. Buka lokasi di Google Maps, tekan Bagikan/Share lalu Salin link, dan tempel link tersebut di sini.',
                ]);
            }

            [$data['latitude'], $data['longitude']] = $coordinates;
        }

        $contact = Contact::first() ?? new Contact();
        $contact->fill($data)->save();

        return redirect()->route('admin.contact.edit')->with('status', 'Kontak berhasil diperbarui.');
    }

    private function extractCoordinates(string $url): ?array
    {
        $coordinates = $this->matchCoordinates($url);

        if ($coordinates) {
            return $coordinates;
        }

        // Share links (maps.app.goo.gl, goo.gl/maps) redirect to the full URL that contains coordinates.
        try {
            $resolvedUrl = Http::timeout(6)->get($url)->effectiveUri();
        } catch (\Throwable) {
            return null;
        }

        return $resolvedUrl ? $this->matchCoordinates((string) $resolvedUrl) : null;
    }

    private function matchCoordinates(string $url): ?array
    {
        // Pin/place URLs encode the exact marker as !3d{lat}!4d{lng}, which is more
        // precise than the @lat,lng map-center segment also present in the same URL.
        if (preg_match('/!3d(-?\d+\.\d+)!4d(-?\d+\.\d+)/', $url, $m)) {
            return [$m[1], $m[2]];
        }

        if (preg_match('/@(-?\d+\.\d+),(-?\d+\.\d+)/', $url, $m)) {
            return [$m[1], $m[2]];
        }

        if (preg_match('/[?&]q=(-?\d+\.\d+),(-?\d+\.\d+)/', $url, $m)) {
            return [$m[1], $m[2]];
        }

        return null;
    }
}

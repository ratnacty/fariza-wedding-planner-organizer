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

        $coordinates = null;
        $resolvedAddress = null;

        if (! empty($data['map_url'])) {
            [$coordinates, $resolvedAddress] = $this->resolveMapUrl($data['map_url']);
        }

        // A resolved link is a more reliable source of truth than hand-typed shorthand,
        // so it takes over the Alamat field — this is what "paste the link" should do.
        if ($resolvedAddress) {
            $data['address'] = $resolvedAddress;
        }

        if (! $coordinates && ! empty($data['address'])) {
            $coordinates = $this->coordinatesFromAddress($data['address']);
        }

        if ($coordinates) {
            [$data['latitude'], $data['longitude']] = $coordinates;
        }

        $contact = Contact::first() ?? new Contact();
        $contact->fill($data)->save();

        $status = 'Kontak berhasil diperbarui.';

        if ($resolvedAddress) {
            $status .= ' Alamat otomatis diperbarui dari link Google Maps yang ditempel.';
        }

        if (! $coordinates && (! empty($data['map_url']) || ! empty($data['address']))) {
            $status .= ' Lokasi di peta belum bisa ditemukan otomatis — coba lengkapi Alamat dengan nama jalan yang lebih spesifik, atau tempel link Google Maps yang berisi koordinat langsung (format ".../@-6.123,106.456,17z").';
        }

        return redirect()->route('admin.contact.edit')->with('status', $status);
    }

    /**
     * @return array{0: ?array, 1: ?string} [coordinates, resolved address text]
     */
    private function resolveMapUrl(string $url): array
    {
        if ($coordinates = $this->matchCoordinates($url)) {
            return [$coordinates, null];
        }

        // Share links (maps.app.goo.gl, goo.gl/maps) redirect to the full URL, which
        // sometimes carries coordinates and sometimes only a place name — worth trying.
        try {
            $resolvedUrl = (string) Http::timeout(6)->get($url)->effectiveUri();
        } catch (\Throwable) {
            return [null, null];
        }

        if (! $resolvedUrl) {
            return [null, null];
        }

        if ($coordinates = $this->matchCoordinates($resolvedUrl)) {
            return [$coordinates, null];
        }

        // Business-listing shares resolve to "?q=<place name/address>&ftid=..." instead
        // of coordinates. That text is a real, usable address — worth showing in the
        // Alamat field even if it turns out not geocodable below.
        $query = parse_url($resolvedUrl, PHP_URL_QUERY);
        parse_str($query ?? '', $params);

        if (empty($params['q'])) {
            return [null, null];
        }

        $placeText = $params['q'];

        return [$this->coordinatesFromAddress($placeText), $placeText];
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

    private function coordinatesFromAddress(string $address): ?array
    {
        try {
            $response = Http::withHeaders([
                'User-Agent' => 'FarizaWeddingOrganizer/1.0 (admin contact form geocoding)',
            ])->timeout(6)->get('https://nominatim.openstreetmap.org/search', [
                'q' => $address,
                'format' => 'json',
                'limit' => 1,
            ]);
        } catch (\Throwable) {
            return null;
        }

        $result = $response->json(0);

        return $result ? [$result['lat'], $result['lon']] : null;
    }
}

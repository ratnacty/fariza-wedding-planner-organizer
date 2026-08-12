<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PackageController extends Controller
{
    public function index(): View
    {
        return view('admin.packages.index', [
            'packages' => Package::orderBy('order')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.packages.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['name']);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('packages', 'public');
        }

        Package::create($data);

        return redirect()->route('admin.packages.index')->with('status', 'Paket berhasil ditambahkan.');
    }

    public function edit(Package $package): View
    {
        return view('admin.packages.edit', ['package' => $package]);
    }

    public function update(Request $request, Package $package): RedirectResponse
    {
        $data = $this->validated($request);

        if ($data['name'] !== $package->name) {
            $data['slug'] = $this->uniqueSlug($data['name'], $package->id);
        }

        if ($request->hasFile('image')) {
            if ($package->image_path) {
                Storage::disk('public')->delete($package->image_path);
            }

            $data['image_path'] = $request->file('image')->store('packages', 'public');
        }

        $package->update($data);

        return redirect()->route('admin.packages.index')->with('status', 'Paket berhasil diperbarui.');
    }

    public function destroy(Package $package): RedirectResponse
    {
        if ($package->image_path) {
            Storage::disk('public')->delete($package->image_path);
        }

        $package->delete();

        return redirect()->route('admin.packages.index')->with('status', 'Paket berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'tier' => ['nullable', 'string', 'max:50'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'features' => ['nullable', 'string'],
            'cover_color' => ['required', 'in:rose,blush'],
            'image' => ['nullable', 'image', 'max:2048'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        unset($data['image']);

        $data['features'] = collect(preg_split('/\r\n|\r|\n/', (string) $request->input('features')))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values()
            ->all();

        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active');
        $data['order'] = $data['order'] ?? 0;

        return $data;
    }

    private function uniqueSlug(string $name, ?int  $ignoreId = null): string
    {
        $slug = Str::slug($name);
        $original = $slug;
        $i = 1;

        while (Package::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = "{$original}-{$i}";
            $i++;
        }

        return $slug;
    }
}

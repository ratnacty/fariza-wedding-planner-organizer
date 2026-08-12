<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class HeroSlideController extends Controller
{
    public function index(): View
    {
        return view('admin.hero-slides.index', [
            'slides' => HeroSlide::orderBy('order')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.hero-slides.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('hero-slides', 'public');
        }

        HeroSlide::create($data);

        return redirect()->route('admin.hero-slides.index')->with('status', 'Hero slide berhasil ditambahkan.');
    }

    public function edit(HeroSlide $heroSlide): View
    {
        return view('admin.hero-slides.edit', ['slide' => $heroSlide]);
    }

    public function update(Request $request, HeroSlide $heroSlide): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            if ($heroSlide->image_path) {
                Storage::disk('public')->delete($heroSlide->image_path);
            }

            $data['image_path'] = $request->file('image')->store('hero-slides', 'public');
        }

        $heroSlide->update($data);

        return redirect()->route('admin.hero-slides.index')->with('status', 'Hero slide berhasil diperbarui.');
    }

    public function destroy(HeroSlide $heroSlide): RedirectResponse
    {
        if ($heroSlide->image_path) {
            Storage::disk('public')->delete($heroSlide->image_path);
        }

        $heroSlide->delete();

        return redirect()->route('admin.hero-slides.index')->with('status', 'Hero slide berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'eyebrow' => ['nullable', 'string', 'max:100'],
            'title' => ['required', 'string', 'max:150'],
            'subtitle' => ['nullable', 'string', 'max:500'],
            'cover_color' => ['required', 'in:rose,blush'],
            'image' => ['nullable', 'image', 'max:2048'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        unset($data['image']);

        $data['is_active'] = $request->boolean('is_active');
        $data['order'] = $data['order'] ?? 0;

        return $data;
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Package;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(): View
    {
        return view('admin.gallery.index', [
            'galleries' => Gallery::with('package')->orderBy('order')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.gallery.create', [
            'packages' => Package::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['nullable', 'string', 'max:150'],
            'category' => ['nullable', 'string', 'max:100'],
            'cover_color' => ['required', 'in:rose,blush'],
            'image' => ['required', 'image', 'max:2048'],
            'package_id' => ['nullable', 'exists:packages,id'],
            'order' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['order'] = $data['order'] ?? 0;
        $data['image_path'] = $request->file('image')->store('gallery', 'public');
        unset($data['image']);

        Gallery::create($data);

        return redirect()->route('admin.gallery.index')->with('status', 'Foto galeri berhasil ditambahkan.');
    }

    public function edit(Gallery $gallery): View
    {
        return view('admin.gallery.edit', [
            'gallery' => $gallery,
            'packages' => Package::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Gallery $gallery): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['nullable', 'string', 'max:150'],
            'category' => ['nullable', 'string', 'max:100'],
            'cover_color' => ['required', 'in:rose,blush'],
            'image' => ['nullable', 'image', 'max:2048'],
            'package_id' => ['nullable', 'exists:packages,id'],
            'order' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['order'] = $data['order'] ?? 0;

        if ($request->hasFile('image')) {
            if ($gallery->image_path) {
                Storage::disk('public')->delete($gallery->image_path);
            }

            $data['image_path'] = $request->file('image')->store('gallery', 'public');
        }

        unset($data['image']);

        $gallery->update($data);

        return redirect()->route('admin.gallery.index')->with('status', 'Foto galeri berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery): RedirectResponse
    {
        if ($gallery->image_path) {
            Storage::disk('public')->delete($gallery->image_path);
        }

        $gallery->delete();

        return redirect()->route('admin.gallery.index')->with('status', 'Foto galeri berhasil dihapus.');
    }
}

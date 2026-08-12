<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(): View
    {
        return view('public.gallery.index', [
            'galleries' => Gallery::orderBy('order')->paginate(12),
        ]);
    }
}

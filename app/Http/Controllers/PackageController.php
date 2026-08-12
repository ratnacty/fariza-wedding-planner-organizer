<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\View\View;

class PackageController extends Controller
{
    public function index(): View
    {
        return view('public.packages.index', [
            'packages' => Package::where('is_active', true)->orderBy('order')->get(),
        ]);
    }

    public function show(Package $package): View
    {
        return view('public.packages.show', [
            'package' => $package,
            'gallery' => $package->galleries()->orderBy('order')->get(),
            'otherPackages' => Package::where('is_active', true)
                ->where('id', '!=', $package->id)
                ->orderBy('order')
                ->take(2)
                ->get(),
        ]);
    }
}

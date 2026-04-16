<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
   public function __construct()
{
    // Allow homepage and AJAX filter without login
    $this->middleware('auth')->except(['index', 'filter']);
}

    public function index(Request $request)
{
    $query = Package::where('is_popular', 1);

    if ($request->filled('country')) {
        $query->whereRaw('LOWER(country) = ?', [strtolower($request->country)]);
    }

    $packages = $query->latest()->take(6)->get();

    $countries = Package::select('country')
        ->whereNotNull('country')
        ->distinct()
        ->pluck('country');

    return view('index', compact('packages', 'countries'));
}
public function filter(Request $request)
{
    $query = Package::where('is_popular', 1);

    if ($request->filled('country')) {
    $query->whereRaw('LOWER(country) = ?', [strtolower($request->country)]);
}
    $packages = $query->latest()->take(6)->get();

    return view('indexes.partials.packages', compact('packages'))->render();
}
}
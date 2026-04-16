<?php

namespace App\Http\Controllers;
 use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
   

public function index()
{
    $packages = Package::all();
    $popular = Package::where('is_popular', true)->get();

    return view('packages.index', compact('packages', 'popular'));
}


public function show(Package $package)
{
     
    return view('packages.show', compact('package'));
}
}

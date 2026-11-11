<?php

namespace App\Http\Controllers;

use App\Service;

class ServiceController extends Controller
{
    // Menampilkan layanan yang aktif
    public function index()
    {
        $services = Service::where('status', 'aktif')
            ->latest()
            ->get();

        return view('services.index', compact('services'));
    }

    // Menampilkan detail layanan
    public function show($id)
    {
        $service = Service::where('status', 'aktif')
            ->findOrFail($id);

        return view('services.show', compact('service'));
    }
}
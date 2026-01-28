<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locations = Location::all();
        return view('pages.admin.location.index', compact('locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $payload = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        if (!isset($payload['name'])) {
            return redirect()->route('admin.locations.index')->with('error', 'Nama lokasi perlu diisi.');
        }

        Location::create([
            'location_name' => $payload['name'],
        ]);

        return redirect()->route('admin.locations.index')->with('success', 'Lokasi berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $payload = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        if (!isset($payload['name'])) {
            return redirect()->route('admin.locations.index')->with('error', 'Nama lokasi wajib diisi.');
        }

        $location = Location::findOrFail($id);
        $location->location_name = $payload['name'];
        $location->save();

        return redirect()->route('admin.locations.index')->with('success', 'Lokasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Location::destroy($id);
        return redirect()->route('admin.locations.index')->with('success', 'Lokasi berhasil dihapus.');
    }
}

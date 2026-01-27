<?php

namespace App\Http\Controllers;

use App\Models\TicketType;
use Illuminate\Http\Request;

class TicketTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ticket_types = TicketType::all();

        return view('pages.admin.ticket-type.index', compact('ticket_types'));
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
            return redirect()->route('admin.ticket-types.index')->with('error', 'Nama tipe tiket wajib diisi.');
        }

        TicketType::create([
            'name' => $payload['name'],
        ]);

        return redirect()->route('admin.ticket-types.index')->with('success', 'Tipe tiket berhasil ditambahkan.');
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
            return redirect()->route('admin.ticket-types.index')->with('error', 'Nama tipe tiket wajib diisi.');
        }

        $category = TicketType::findOrFail($id);
        $category->name = $payload['name'];
        $category->save();

        return redirect()->route('admin.ticket-types.index')->with('success', 'Tipe tiket berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        TicketType::destroy($id);
        return redirect()->route('admin.ticket-types.index')->with('success', 'Tipe tiket berhasil dihapus.');
    }
}

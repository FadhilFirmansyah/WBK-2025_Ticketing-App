<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = request()->validate([
            'event_id' => 'required|exists:events,id',
            'type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        // Create the ticket
        Ticket::create($validatedData);

        return redirect()->route('admin.events.show', $validatedData['event_id'])->with('success', 'Ticket berhasil ditambahkan.');
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $ticket = Ticket::findOrFail($id);

        $validatedData = $request->validate([
            'type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $ticket->update($validatedData);

        return redirect()->route('admin.events.show', $ticket->event_id)->with('success', 'Ticket berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ticket = Ticket::findOrFail($id);
        $eventId = $ticket->event_id;
        $ticket->delete();

        return redirect()->route('admin.events.show', $eventId)->with('success', 'Ticket berhasil dihapus.');
    }
}

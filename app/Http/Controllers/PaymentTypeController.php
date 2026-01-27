<?php

namespace App\Http\Controllers;

use App\Models\PaymentType;
use Illuminate\Http\Request;

class PaymentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payment_types = PaymentType::all();
        return view('pages.admin.payment-type.index', compact('payment_types'));
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
            return redirect()->route('admin.payment-type.index')->with('error', 'Nama tipe pembayaran wajib diisi.');
        }

        PaymentType::create([
            'name' => $payload['name'],
        ]);

        return redirect()->route('admin.payment-types.index')->with('success', 'Tipe Pembayaran berhasil ditambahkan.');
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
            return redirect()->route('admin.payment-types.index')->with('error', 'Nama tipe pembayaran wajib diisi.');
        }

        $category = PaymentType::findOrFail($id);
        $category->name = $payload['name'];
        $category->save();

        return redirect()->route('admin.payment-types.index')->with('success', 'Tipe Pembayaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        PaymentType::destroy($id);
        return redirect()->route('admin.payment-types.index')->with('success', 'Tipe Pembayaran berhasil dihapus.');
    }
}

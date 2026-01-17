<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DetailOrder;
use App\Models\Order;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $user = Auth::user() ?? \App\Models\User::first();
        $orders = Order::where('user_id', $user->id)->with('event')->orderBy('created_at', 'desc')->get();
        
        return view('orders.index', compact('orders'));
    }

    // show a specific order
    public function show(Order $order)
    {
        $order->load('detailOrders.ticket', 'event');
        return view('orders.show', compact('order'));
    }

  // store an order (AJAX POST)
  public function store(Request $request)
  {

    $data = $request->validate([
      'event_id' => 'required|exists:events,id',
      'items' => 'required|array|min:1',
      'items.*.ticket_id' => 'required|integer|exists:tickets,id',
      'items.*.amount' => 'required|integer|min:1',
    ]);

    $user = Auth::user();

    try {
      // transaction
      $order = DB::transaction(function () use ($data, $user) {
        $total = 0;
        // validate stock and calculate total
        foreach ($data['items'] as $it) {
          $t = Ticket::lockForUpdate()->findOrFail($it['ticket_id']);
          if ($t->stock < $it['amount']) {
            throw new \Exception("Stok tidak cukup untuk tipe: {$t->type}");
          }
          $total += ($t->price ?? 0) * $it['amount'];
        }

        $order = Order::create([
          'user_id' => $user->id,
          'event_id' => $data['event_id'],
          'order_date' => Carbon::now(),
          'total_price' => $total,
        ]);

        foreach ($data['items'] as $it) {
          $t = Ticket::findOrFail($it['ticket_id']);
          $subtotal = ($t->price ?? 0) * $it['amount'];
          DetailOrder::create([
            'order_id' => $order->id,
            'ticket_id' => $t->id,
            'amount' => $it['amount'],
            'subtotal_price' => $subtotal,
          ]);

          // reduce stock
          $t->stock = max(0, $t->stock - $it['amount']);
          $t->save();
        }

        return $order;
      });

      // flash success message to session so it appears after redirect
      session()->flash('success', 'Pesanan berhasil dibuat.');

      return response()->json(['ok' => true, 'order_id' => $order->id, 'redirect' => route('orders.index')]);
    } catch (\Exception $e) {
      return response()->json(['ok' => false, 'message' => $e->getMessage()], 422);
    }
  }
}

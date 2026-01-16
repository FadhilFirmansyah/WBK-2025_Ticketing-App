<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guerded = ['id'];

    protected $casts = [
        'order_date' => 'datetime',
        'total_price' => 'decimal:2'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function event(){
        return $this->belongsTo(Event::class);
    }

    public function detailOrders(){
        return $this->hasMany(DetailOrder::class);
    }

    public function tickets(){
        return $this->belongsToMany(Ticket::class, 'detai_orders')->withPivot('amount', 'subtotal_price');
    }
}

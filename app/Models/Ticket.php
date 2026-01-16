<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $guarded = ['id'];

    public function event(){
        return $this->belongsTo(Event::class);
    }

    public function detailOrders(){
        return $this->hasMany(DetailOrder::class);
    }

    public function orders(){
        return $this->belongsToMany(Order::class, 'detail_orders')->withPivot('amount', 'subtotal_price');
    }
}

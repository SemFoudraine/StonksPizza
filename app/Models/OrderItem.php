<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'pizza_id',
        'price',
        'quantity'
    ];

    // Relatie terug naar Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relatie naar Pizza
    public function pizza()
    {
        return $this->belongsTo(Pizza::class);
    }

}

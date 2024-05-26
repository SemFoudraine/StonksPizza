<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['order_id', 'pizza_name', 'price', 'quantity'];

    // Relatie met Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relatie met Ingredients
    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class)->withTimestamps();
    }
}

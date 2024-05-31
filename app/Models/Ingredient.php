<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $fillable = ['name', 'price'];

    public $timestamps = false;

    public function orderItems()
    {
        return $this->belongsToMany(OrderItem::class, 'ingredient_pizza', 'ingredient_id', 'order_item_id');
    }
}


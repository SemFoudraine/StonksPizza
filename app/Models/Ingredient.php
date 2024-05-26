<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $fillable = ['name', 'price'];

    public $timestamps = false;

    public function pizzas()
    {
        return $this->belongsToMany(Pizza::class);
    }

    public function orderItems()
    {
        return $this->belongsToMany(OrderItem::class);
    }

}

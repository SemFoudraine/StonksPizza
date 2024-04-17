<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_name',
        'customer_email',
        'address',  
        'total_price'
    ];

    // Relatie met OrderItem
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}


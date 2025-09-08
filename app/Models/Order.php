<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['username', 'total_amount', 'queue_number'];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}


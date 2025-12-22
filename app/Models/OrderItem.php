<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 
        'product_name', 
        'fabric',   // <--- This MUST be here or it saves as NULL
        'cutting',  // <--- This is working for you now
        'size', 
        'quantity', 
        'price', 
        'subtotal'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
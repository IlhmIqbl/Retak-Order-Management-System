<?php

// app/Models/Invoice.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = []; // <--- ADD THIS (Allows creating invoices easily)

    // Rename from 'orders' to 'order'
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
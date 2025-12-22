<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Allows us to save all fields at once (be careful with mass assignment)
    protected $guarded = [];

    // Relationship: An order belongs to ONE customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relationship: An order has MANY items (shirts, pants, etc.)
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relationship: An order belongs to a Designer (who is a User)
    public function designer()
    {
        return $this->belongsTo(User::class, 'designer_id');
    }

    // Relationship: Who created this order? (Optional, based on your migration)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function show(Order $order)
    {
        // Load the relationship so we can show items
        $order->load(['customer', 'items', 'designer']);

        return view('invoice', compact('order'));
    }
    public function namelist(Order $order)
{
    // Load necessary data
    $order->load(['customer', 'items', 'designer']);
    
    return view('namelist', compact('order'));
}
}
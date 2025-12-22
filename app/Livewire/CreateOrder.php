<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads; // Needed for file upload
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class CreateOrder extends Component
{
    use WithFileUploads;

    // --- 1. Order Details ---
    public $customer_id;
    public $order_date;
    public $shipping_address; 
    public $notes;
    public $status = 'Draft';
    public $design_file;
    public $designer_id;

    // --- NEW: Identity Card Variables (The Fix) ---
    public $customer_email = '';
    public $customer_phone = '';

    // --- 2. Order Items ---
    public $items = []; 

    // --- 3. Setup ---
   public function mount()
{
    // 1. Set Default Date
    $this->order_date = date('Y-m-d'); 
    
    // 2. Setup Default Item
    $this->items[] = [
        'product_name' => '',
        'fabric' => '',
        'cutting' => '',
        'size' => 'M',
        'quantity' => 1,
        'price' => 0,
        'subtotal' => 0
    ];

    // 3. NEW: Check if we came from Customer Details page
    if (request()->has('customer_id')) {
        $this->customer_id = request()->query('customer_id');
        
        // Trigger the auto-fill function manually
        $this->updatedCustomerId($this->customer_id);
    }
}

    // --- 4. THE HYBRID LOGIC (Auto-Fill) ---
    public function updatedCustomerId($value)
    {
        $customer = Customer::find($value);
        
        if ($customer) {
            // Fill the form fields
            $this->shipping_address = $customer->shipping_address;
            
            // Fill the "Identity Card" variables
            $this->customer_email = $customer->email;
            $this->customer_phone = $customer->phone_number;
        } else {
            // Reset if they unselect
            $this->shipping_address = '';
            $this->customer_email = '';
            $this->customer_phone = '';
        }
    }

    // --- 5. Item Logic ---
    public function addItem()
    {
        $this->items[] = [
            'product_name' => '','fabric' =>'','cutting' =>'', 'size' => 'M', 'quantity' => 1, 'price' => 0, 'subtotal' => 0
        ];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function getTotalProperty()
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += (float)$item['quantity'] * (float)$item['price'];
        }
        return $total;
    }

    // --- 6. SAVE ---
    public function save()
{
    $this->validate([
        'customer_id' => 'required',
        'items.*.product_name' => 'required',
        // ... (your other validations)
    ]);

    // 1. CAPTURE the result of the transaction in a variable
    $finalInvoiceNumber = DB::transaction(function () {
        
        // Handle File Upload
        $filePath = null;
        if ($this->design_file) {
            $filePath = $this->design_file->store('designs', 'public'); 
        }

        // Create Order
        $order = Order::create([
            'customer_id' => $this->customer_id,
            'designer_id' => $this->designer_id,
            'order_date' => $this->order_date,
            'shipping_address' => $this->shipping_address,
            'notes' => $this->notes,
            'status' => 'Draft',
            'total_amount' => $this->getTotalProperty(),
            'design_file_path' => $filePath,
        ]);

        // Generate Invoice Number
        $invoiceNumber = 'INV-' . date('Y') . '-' . str_pad($order->id, 4, '0', STR_PAD_LEFT);
        
        $order->update(['invoice_number' => $invoiceNumber]);
        
        // Save Items
        // ... inside the save() function ...

        foreach ($this->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_name' => $item['product_name'],
                
                // --- ADD THESE TWO LINES ---
                'fabric' => $item['fabric'] ?? null,   // <--- Saves the Fabric
                'cutting' => $item['cutting'] ?? null, // <--- Saves the Cutting
                // ---------------------------

                'size' => $item['size'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $item['quantity'] * $item['price'],
            ]);
        }

        // 2. RETURN the invoice number from inside the transaction
        return $invoiceNumber; 
    });

    // 3. USE the captured variable here
    return redirect()->route('customers.index')
        ->with('message', 'Order Created! Invoice: ' . $finalInvoiceNumber);
}       

    public function deleteOrder($orderId)
{
    // 1. Find and Delete the order
    $order = \App\Models\Order::find($orderId);
    
    if ($order) {
        $order->delete();
    }

    // 2. Refresh the list immediately
    $this->mount($this->customer->id); 
    
    // 3. Show success notification (Optional)
    session()->flash('message', 'Order deleted successfully.');
}

// 3. Update render() to send Users (Designers) to the view
public function render()
{
    return view('livewire.create-order', [
        'customers' => Customer::all(),
        'designers' => \App\Models\User::all(), // <--- Fetch Users
    ])->layout('layouts.admin-layout');
}
}
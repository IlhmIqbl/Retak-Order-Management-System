<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Customer;
use App\Models\Order;

class CustomerDetails extends Component
{
    public $customer;
    public $orders;

    // Variables for Editing Status
    public $isEditModalOpen = false;
    public $editingOrderId;
    public $editingStatus;

    public function mount($id)
    {
        $this->customer = Customer::findOrFail($id);
        $this->orders = $this->customer->orders()->orderBy('created_at', 'desc')->get();
    }

    public function delete()
    {
        $this->customer->delete();
        return redirect()->route('customers.index')->with('message', 'Customer deleted successfully.');
    }

    // --- NEW: Function to Delete a Specific Order ---
    public function deleteOrder($orderId)
    {
        $order = Order::find($orderId);
        
        if ($order) {
            $order->delete();
        }

        // Refresh the list
        $this->mount($this->customer->id); 
        session()->flash('message', 'Order deleted successfully.');
    }

    // --- NEW: Functions for Edit Status Modal ---
    public function editStatus($orderId, $currentStatus)
    {
        $this->editingOrderId = $orderId;
        $this->editingStatus = $currentStatus;
        $this->isEditModalOpen = true;
    }

    public function updateStatus()
    {
        $order = Order::find($this->editingOrderId);
        $order->update(['status' => $this->editingStatus]);
        
        $this->isEditModalOpen = false;
        $this->mount($this->customer->id); // Refresh list
    }

    public function render()
    {
        return view('livewire.customer-details')->layout('layouts.admin-layout');
    }
}
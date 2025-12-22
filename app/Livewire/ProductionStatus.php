<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;

class ProductionStatus extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = '';

    // Status Modal Variables
    public $isEditModalOpen = false;
    public $editingOrderId;
    public $editingStatus;

    // Reset pagination when searching
    public function updatedSearch() { $this->resetPage(); }

    public function render()
    {
        $orders = Order::with('customer', 'designer')
            ->when($this->search, function($query) {
                $query->whereHas('customer', function($q) {
                    $q->where('name', 'like', '%'.$this->search.'%');
                })->orWhere('invoice_number', 'like', '%'.$this->search.'%');
            })
            ->when($this->filterStatus, function($query) {
                $query->where('status', $this->filterStatus);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.production-status', [
            'orders' => $orders
        ])->layout('layouts.admin-layout');
    }

    // --- Status Update Logic ---
    public function editStatus($orderId, $currentStatus)
    {
        $this->editingOrderId = $orderId;
        $this->editingStatus = $currentStatus;
        $this->isEditModalOpen = true;
    }

    public function updateStatus()
    {
        $order = Order::find($this->editingOrderId);
        if ($order) {
            $order->update(['status' => $this->editingStatus]);
            session()->flash('message', 'Status updated successfully.');
        }
        $this->isEditModalOpen = false;
    }
}
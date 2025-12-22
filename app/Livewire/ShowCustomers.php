<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Customer;

class ShowCustomers extends Component
{
    use WithPagination;

    // Search & Modal State
    public $search = '';
    public $isModalOpen = 0; // 0 = Closed, 1 = Open

    // Form Fields (Matches your Database)
    public $name, $email, $phone_number, $shipping_address, $customer_id;

    // Reset pagination when searching
    public function updatedSearch()
    {
        $this->resetPage();
    }

    // 1. OPEN MODAL (Reset fields)
    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    // 2. OPEN MODAL (Helper)
    public function openModal()
    {
        $this->isModalOpen = true;
    }

    // 3. CLOSE MODAL (Helper)
    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    // 4. RESET FIELDS
    private function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->phone_number = '';
        $this->shipping_address = '';
        $this->customer_id = null;
    }

    // 5. STORE DATA (Add New Customer)
    public function store()
    {
        // Validation
        $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
        ]);

        // Create or Update
        Customer::updateOrCreate(['id' => $this->customer_id], [
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'shipping_address' => $this->shipping_address,
        ]);

        // Close and Message
        session()->flash('message', $this->customer_id ? 'Customer Updated Successfully.' : 'Customer Created Successfully.');
        $this->closeModal();
        $this->resetInputFields();
    }

    // 6. EDIT (Optional - fills the form)
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        $this->customer_id = $id;
        $this->name = $customer->name;
        $this->email = $customer->email;
        $this->phone_number = $customer->phone_number;
        $this->shipping_address = $customer->shipping_address;
    
        $this->openModal();
    }

    // 7. DELETE FUNCTION
    public function delete($id)
    {
        Customer::find($id)->delete();
        session()->flash('message', 'Customer Deleted Successfully.');
    }

    public function render()
    {
        $customers = Customer::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'asc')
            ->paginate(10);

        return view('livewire.show-customers', [
            'customers' => $customers
        ])->layout('layouts.admin-layout');
    }
    public function mount()
{
    // SECURITY CHECK: Kick out Factory users
    if (auth()->user()->isFactory()) {
        abort(403, 'UNAUTHORIZED: User cannot access this page.');
    }
}
}
<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Customer;

class CreateCustomer extends Component
{
    // Define the variables needed for the form
    public $company_name, $contact_person, $phone_number, $email, $shipping_address;

    public function save()
    {
        $this->validate([
            'company_name' => 'required',
            'contact_person' => 'required',
            'phone_number' => 'required',
        ]);

        // Save to Database
        Customer::create([
            'name' => $this->company_name, // Mapping company_name to 'name' column
            'company_name' => $this->company_name, // Save both just in case
            'contact_person' => $this->contact_person,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'shipping_address' => $this->shipping_address,
        ]);

        return redirect()->route('customers.index');
    }

    public function render()
    {
        return view('livewire.create-customer');
    }
}
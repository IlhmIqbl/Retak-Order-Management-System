<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Customer Information') }}
    </h2>
</x-slot>

<div class="p-6">

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
        <div class="relative w-full md:w-1/2">
            <input wire:model.live.debounce.300ms="search" type="text" class="block w-full pl-4 pr-3 py-3 border-none rounded-lg bg-gray-200" placeholder="Search...">
        </div>
        
        <button wire:click="create" class="flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
            + Add New Customer
        </button>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-500 font-medium border-b">
                <tr>
                    <th class="px-6 py-4">Customer ID</th>
                    <th class="px-6 py-4">Name</th>
                    <th class="px-6 py-4">Contact</th>
                    <th class="px-6 py-4">Email</th>
                    <th class="px-6 py-4">Last Order Date</th>
                    <th class="px-6 py-4 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($customers as $customer)
                   <tr class="hover:bg-blue-50 transition">
                        <td class="px-6 py-4 font-bold text-blue-600">
                            CUST {{ str_pad($customer->id, 3, '0', STR_PAD_LEFT) }}
                        </td>

                        <td class="px-6 py-4 text-gray-900 font-medium">
                            <a href="{{ route('customers.show', $customer->id) }}" class="hover:text-blue-600 hover:underline">
                                {{ $customer->name }}
                            </a>
                        </td>
                        
                        <td class="px-6 py-4">{{ $customer->phone_number }}</td>
                        <td class="px-6 py-4">{{ $customer->email }}</td>
                        <td class="px-6 py-4 text-gray-600">
                            @if($customer->orders->isNotEmpty())
                                {{ \Carbon\Carbon::parse($customer->orders->last()->order_date)->format('d/m/Y') }}
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center flex justify-center gap-2">
                            <button wire:click="edit({{ $customer->id }})" class="text-blue-500 hover:text-blue-700 px-2">
                                Edit
                            </button>
                            |
                            <button wire:click="delete({{ $customer->id }})" 
                                    wire:confirm="Are you sure you want to delete this customer?"
                                    class="text-red-500 hover:text-red-700 px-2">
                                Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">No customers found.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4">{{ $customers->links() }}</div>
    </div>

    @if($isModalOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form wire:submit.prevent="store">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="mb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                {{ $customer_id ? 'Edit Customer' : 'Add New Customer' }}
                            </h3>
                        </div>
                        
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Customer Name</label>
                                <input type="text" wire:model="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Phone Number</label>
                                <input type="text" wire:model="phone_number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @error('phone_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                                <input type="email" wire:model="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                             <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Shipping Address</label>
                                <textarea wire:model="shipping_address" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                            Save
                        </button>
                        <button wire:click="closeModal" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
    </div>
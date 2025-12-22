<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    
    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('customers.index') }}" class="flex items-center text-gray-600 hover:text-gray-900 font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Customers
        </a>
    </div>

    <div class="bg-white shadow-sm overflow-hidden sm:rounded-lg mb-8 p-8 border border-gray-100">
        <div class="flex flex-col md:flex-row justify-between">
            
            <div class="mb-6 md:mb-0 md:w-1/2">
                <h1 class="text-3xl font-bold text-gray-900 mb-3">{{ $customer->name }}</h1>
                
                <div class="flex items-center gap-3 mb-8">
                    <span class="px-3 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full border border-green-200">
                        {{ $orders->count() }} Purchases
                    </span>
                    <span class="px-3 py-1 text-xs font-semibold bg-gray-100 text-gray-600 rounded-full border border-gray-200">
                        ID: {{ $customer->id }}
                    </span>
                </div>
                
                <div class="flex gap-6 mt-6">
                    <button wire:click="delete" wire:confirm="Are you sure you want to delete this customer?" 
                            class="flex items-center px-6 py-2.5 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition">
                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Delete
                    </button>
                    
                    <a href="{{ route('orders.create', ['customer_id' => $customer->id]) }}" 
                    class="flex items-center px-6 py-2.5 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 transition">
                        + Add New Order
                    </a>
                </div>
            </div>

            <div class="md:w-1/2 md:pl-12 border-l border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 mb-6">Details</h3>
                
                <div class="space-y-4">
                    <div class="grid grid-cols-[120px_1fr] items-start">
                        <span class="text-sm font-medium text-gray-500">Contact</span>
                        <span class="text-sm font-semibold text-gray-900">{{ $customer->phone_number }}</span>
                    </div>

                    <div class="grid grid-cols-[120px_1fr] items-start">
                        <span class="text-sm font-medium text-gray-500">Email</span>
                        <span class="text-sm font-semibold text-gray-900">{{ $customer->email }}</span>
                    </div>

                    <div class="grid grid-cols-[120px_1fr] items-start">
                        <span class="text-sm font-medium text-gray-500">Address</span>
                        <span class="text-sm text-gray-900 leading-relaxed max-w-xs">
                            {{ $customer->shipping_address ?? 'No address provided' }}
                        </span>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <h3 class="text-lg font-bold text-gray-900 mb-4 px-1">Past Orders</h3>
    
    <div class="bg-white shadow-sm overflow-hidden sm:rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-gray-50">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Order ID</th>
            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Date</th>
            
            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Invoice</th>
            
            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Design</th>
            
            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
            
            <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Action</th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        @forelse($orders as $order)
        <tr class="hover:bg-gray-50">
            <td class="px-6 py-4 text-sm font-bold text-gray-900">
                #{{ $order->id }}
            </td>
            <td class="px-6 py-4 text-sm text-gray-500">
                {{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}
            </td>
            
            <td class="px-6 py-4 text-sm font-mono text-blue-600">
    @if($order->invoice_number)
        <a href="{{ route('orders.invoice', $order->id) }}" target="_blank" class="hover:underline hover:text-blue-800 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            {{ $order->invoice_number }}
        </a>
    @else
        <span class="text-gray-400 text-xs italic">Generating...</span>
    @endif
</td>

            <td class="px-6 py-4 text-sm text-gray-500">
                @if($order->design_file_path)
                    <a href="{{ Storage::url($order->design_file_path) }}" target="_blank" class="text-blue-600 hover:underline flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                        View File
                    </a>
                @else
                    <span class="text-gray-400">No File</span>
                @endif
            </td>

            <td class="px-6 py-4">
                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                    {{ $order->status == 'Completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ $order->status }}
                </span>
            </td>

            <td class="px-6 py-4 text-right text-sm font-medium">
    <div class="flex justify-end gap-3">
        
        <button wire:click="editStatus({{ $order->id }}, '{{ $order->status }}')" 
                class="text-indigo-600 hover:text-indigo-900 font-semibold hover:underline px-2">
            Edit
        </button>

        <span class="text-gray-300">|</span>

        <button wire:click="deleteOrder({{ $order->id }})" 
                wire:confirm="Are you sure you want to delete Order #{{ $order->id }}? This cannot be undone."
                class="text-red-600 hover:text-red-900 font-semibold hover:underline px-2">
            Delete
        </button>
        
    </div>
</td>
        </tr>
        @empty

        
        <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">No orders found.</td></tr>
        @endforelse
    </tbody>
</table>

@if($isEditModalOpen)
<div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75" aria-hidden="true"></div>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Update Order Status</h3>
                <select wire:model="editingStatus" class="w-full border-gray-300 rounded-md shadow-sm">
                    <option value="Draft">Draft</option>
                    <option value="Processing">Processing</option>
                    <option value="Printing">Printing</option>
                    <option value="Completed">Completed</option>
                    <option value="Cancelled" class="text-red-600">Cancelled</option>
                </select>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse">
                <button wire:click="updateStatus" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 sm:ml-3 sm:w-auto sm:text-sm">Save</button>
                <button wire:click="$set('isEditModalOpen', false)" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancel</button>
            </div>
        </div>
    </div>
</div>
@endif
    </div>

</div>
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-2xl font-bold text-gray-800">Production Status</h2>
        
        <div class="flex gap-2 w-full md:w-auto">
            <input wire:model.live="search" type="text" placeholder="Search Customer or Invoice..." class="border-gray-300 rounded-md shadow-sm text-sm w-full md:w-64">
            
            <select wire:model.live="filterStatus" class="border-gray-300 rounded-md shadow-sm text-sm">
                <option value="">All Statuses</option>
                <option value="Draft">Draft</option>
                <option value="Processing">Processing</option>
                <option value="Printing">Printing</option>
                <option value="Completed">Completed</option>
                <option value="Cancelled">Cancelled</option>
            </select>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Order ID</th>
                
                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Date</th>
                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Invoice</th>
                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Customer</th>
                <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Files</th>
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
                    <a href="{{ route('orders.invoice', $order->id) }}" target="_blank" class="hover:underline">
                        {{ $order->invoice_number }}
                    </a>
                </td>

                <td class="px-6 py-4 text-sm text-gray-900">
                    {{ $order->customer->name }}
                </td>

                <td class="px-6 py-4 text-center">
                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                        {{ $order->status == 'Completed' ? 'bg-green-100 text-green-800' : 
                          ($order->status == 'Printing' ? 'bg-purple-100 text-purple-800' : 
                          ($order->status == 'Processing' ? 'bg-blue-100 text-blue-800' : 
                          ($order->status == 'Cancelled' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800'))) }}">
                        {{ $order->status }}
                    </span>
                </td>

                <td class="px-6 py-4 text-right">
                    <a href="{{ route('orders.namelist', $order->id) }}" target="_blank" class="text-sm text-indigo-600 hover:text-indigo-900 font-semibold border border-indigo-200 px-3 py-1 rounded hover:bg-indigo-50 transition">
                        📄 Namelist
                    </a>
                </td>

                <td class="px-6 py-4 text-right">
                    <button wire:click="editStatus({{ $order->id }}, '{{ $order->status }}')" class="text-gray-500 hover:text-gray-900 text-sm underline">
                        Update Status
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-4 text-center text-gray-500">No active orders found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $orders->links() }}
    </div>
</div>

    @if($isEditModalOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75" aria-hidden="true"></div>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Update Production Status</h3>
                    
                    <select wire:model="editingStatus" class="w-full border-gray-300 rounded-md shadow-sm">
                        <option value="Draft">Draft</option>
                        <option value="Processing">Processing</option>
                        <option value="Printing">Printing</option>
                        <option value="Completed">Completed</option>
                        <option value="Cancelled">Cancelled</option>
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
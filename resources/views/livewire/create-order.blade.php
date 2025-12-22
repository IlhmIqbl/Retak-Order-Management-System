<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6">
        
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Create New Order</h2>
            <div class="text-xl font-bold text-blue-600">
                Total: RM {{ number_format($this->total, 2) }}
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            
            <div>
            <label class="block font-medium text-gray-700 mb-2">Select Customer</label>
            <select wire:model.live="customer_id" class="w-full border-gray-300 rounded-md shadow-sm">
    <option value="">-- Choose Customer --</option>
    
    @foreach($customers as $customer)
        <option value="{{ $customer->id }}">
            {{-- FORMAT: CUST-001 - Name --}}
            CUST-{{ str_pad($customer->id, 3, '0', STR_PAD_LEFT) }} — {{ $customer->name }}
        </option>
    @endforeach
    
</select>
        </div>

        

            <div>
                <label class="block font-medium text-gray-700 mb-2">Order Date</label>
                <input type="date" wire:model="order_date" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
            </div>
            <div>
            <label class="block font-medium text-gray-700 mb-2">Assign Designer</label>
            <select wire:model="designer_id" class="w-full border-gray-300 rounded-md shadow-sm">
                <option value="">-- Select Designer --</option>
                @foreach($designers as $designer)
                    <option value="{{ $designer->id }}">{{ $designer->name }}</option>
                @endforeach
    </select>
</div>

            <div class="md:col-span-2">
                <label class="block font-medium text-gray-700 mb-2">Shipping Address</label>
                <textarea wire:model="shipping_address" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"></textarea>
                <p class="text-xs text-gray-500 mt-1">Changing this address ONLY affects this order. It does not change the customer's permanent profile.</p>
            </div>
            <div class="md:col-span-2 mt-4">
    <label class="block font-medium text-gray-700 mb-2">Upload Design / Print File</label>
    
    <div class="flex items-center justify-center w-full">
        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                </svg>
                <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                <p class="text-xs text-gray-500">PDF, AI, PSD, PNG, or JPG (MAX. 10MB)</p>
            </div>
            
            <input type="file" wire:model="design_file" class="hidden" />
        </label>
    </div>

    <div wire:loading wire:target="design_file" class="text-blue-500 text-sm mt-2">
        Uploading file... please wait.
    </div>

    @if ($design_file)
        <div class="mt-2 text-green-600 text-sm font-semibold">
            File Selected: {{ $design_file->getClientOriginalName() }}
        </div>
    @endif
    
    @error('design_file') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
</div>
        </div>

        <hr class="my-6 border-gray-200">

        <h3 class="text-lg font-semibold text-gray-800 mb-4">Order Items</h3>
        
        <div class="overflow-x-auto mb-4">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 w-1/3">Product Name</th>
                        <th class="px-4 py-3 w-1/6">Size</th>
                        <th class="px-4 py-3 w-1/6">Fabric</th>
                        <th class="px-4 py-3 w-1/6">Cutting</th>
                        <th class="px-4 py-3 w-1/6">Price (RM)</th>
                        <th class="px-4 py-3 w-1/6">Quantity</th>
                        <th class="px-4 py-3 w-1/6 text-right">Subtotal (RM)</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $index => $item)
                    <tr class="bg-white border-b">
                        <td class="px-4 py-2">
                            <input type="text" wire:model="items.{{ $index }}.product_name" class="w-full border-gray-300 rounded text-sm" placeholder="e.g. Jersey 2024">
                            @error('items.'.$index.'.product_name') <span class="text-red-500 text-xs">Required</span> @enderror
                        </td>
                       

                        <td class="px-4 py-2">
                            <select wire:model.live="items.{{ $index }}.size" class="w-full border-gray-300 rounded text-sm">
                                <option value="XS">XS</option>
                                <option value="S">S</option>
                                <option value="M">M</option>
                                <option value="L">L</option>
                                <option value="XL">XL</option>
                                <option value="2XL">2XL</option>
                                <option value="3XL">3XL</option>
                                <option value="4XL">4XL</option>
                            </select>
                        </td>

                         <td class="px-4 py-2">
                            <select wire:model.live="items.{{ $index }}.fabric" class="w-full border-gray-300 rounded text-sm">
                                <option value="">-- Select --</option>
                                <option value="Nylon">Nylon</option>
                                <option value="RPJK">RPJK</option>
                                <option value="Microfiber">Microfiber</option>
                            </select>
                        </td>

                        <td class="px-4 py-2">
                            <select wire:model.live="items.{{ $index }}.cutting" class="w-full border-gray-300 rounded text-sm">
                                <option value="">-- Select --</option>
                                <option value="Regular">Regular</option>
                                <option value="Slim-fit">Slim-Fit</option>
                                <option value="Oversized">Oversized</option>
                            </select>
                        </td>

                        <td class="px-4 py-2">
                            <input type="number" step="0.01" wire:model.live="items.{{ $index }}.price" class="w-full border-gray-300 rounded text-sm">
                        </td>

                        <td class="px-4 py-2">
                            <input type="number" wire:model.live="items.{{ $index }}.quantity" class="w-full border-gray-300 rounded text-sm">
                        </td>

                        <td class="px-4 py-2 text-right font-medium text-gray-900">
                             {{ number_format( (float)$item['quantity'] * (float)$item['price'] , 2) }}
                        </td>

                        <td class="px-4 py-2 text-center">
                            <button wire:click="removeItem({{ $index }})" class="text-red-500 hover:text-red-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <button wire:click="addItem" class="mb-6 flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Add Another Item
        </button>

        <div class="grid grid-cols-1 gap-6">
             <div>
                <label class="block font-medium text-gray-700 mb-2">Order Notes</label>
                <textarea wire:model="notes" rows="2" class="w-full border-gray-300 rounded-md shadow-sm"></textarea>
            </div>
        </div>

        <div class="flex justify-end mt-8">
            <button wire:click="save" class="bg-blue-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-blue-700 shadow-lg transform transition hover:scale-105">
                Save Order
            </button>
        </div>

    </div>
</div>
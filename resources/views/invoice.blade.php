<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $order->invoice_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Print Settings: Hide buttons when printing */
        @media print {
            .no-print { display: none; }
            body { -webkit-print-color-adjust: exact; }
        }
    </style>
</head>
<body class="bg-gray-100 p-10 print:bg-white print:p-0">

    <div class="max-w-3xl mx-auto bg-white p-12 shadow-lg print:shadow-none">
        
        <div class="flex justify-between items-start mb-10">
            <div>
                <h1 class="text-4xl font-bold text-gray-800 tracking-wide">INVOICE</h1>
                <p class="text-gray-500 mt-1">#{{ $order->invoice_number }}</p>
            </div>
            <div class="text-right">
                <h2 class="text-xl font-bold text-gray-900">RETAK APPAREL</h2>
                <p class="text-sm text-gray-500">
                    123 Business Park,<br>
                    Shah Alam, Selangor<br>
                    support@retakapparel.com
                </p>
            </div>
        </div>

        <div class="flex justify-between border-t border-gray-200 pt-8 mb-10">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Billed To</p>
                <p class="font-bold text-gray-900">{{ $order->customer->name }}</p>
                <p class="text-sm text-gray-600 mt-1 w-48">
                    {{ $order->shipping_address }}<br>
                    {{ $order->customer->phone_number }}
                </p>
            </div>
            
            <div class="text-right">
                <div class="mb-4">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Order Date</p>
                    <p class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Status</p>
                    <span class="px-2 py-1 text-xs font-semibold rounded bg-gray-100 text-gray-800">
                        {{ $order->status }}
                    </span>
                </div>
            </div>
        </div>

        <table class="w-full mb-10">
    <thead>
        <tr class="border-b-2 border-gray-800">
            <th class="text-left py-3 text-sm font-bold text-gray-600 uppercase">Description</th>
            <th class="text-center py-3 text-sm font-bold text-gray-600 uppercase">Size</th>
            <th class="text-center py-3 text-sm font-bold text-gray-600 uppercase">Fabric</th>
            <th class="text-center py-3 text-sm font-bold text-gray-600 uppercase">Cutting</th>
            <th class="text-center py-3 text-sm font-bold text-gray-600 uppercase">Qty</th>
            <th class="text-right py-3 text-sm font-bold text-gray-600 uppercase">Price</th>
            <th class="text-right py-3 text-sm font-bold text-gray-600 uppercase">Total</th>
        </tr>
    </thead>
    <tbody class="text-gray-700">
        @foreach($order->items as $item)
        <tr class="border-b border-gray-200">
            <td class="py-4 text-sm font-medium">{{ $item->product_name }}</td>
            <td class="py-4 text-center text-sm">{{ $item->size }}</td>
            <td class="py-4 text-center text-sm text-gray-500">{{ $item->fabric ?? '-' }}</td>
            <td class="py-4 text-center text-sm text-gray-500">{{ $item->cutting ?? '-' }}</td>
            <td class="py-4 text-center text-sm">{{ $item->quantity }}</td>
            <td class="py-4 text-right text-sm">RM {{ number_format($item->price, 2) }}</td>
            <td class="py-4 text-right text-sm font-bold">RM {{ number_format($item->subtotal, 2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

        <div class="flex justify-end mb-12">
            <div class="w-1/3">
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-600 text-sm">Subtotal</span>
                    <span class="font-bold text-gray-900">RM {{ number_format($order->total_amount, 2) }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-800">
                    <span class="text-gray-800 text-lg font-bold">Total Due</span>
                    <span class="text-blue-600 text-lg font-bold">RM {{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        @if($order->notes)
        <div class="bg-gray-50 p-4 rounded mb-8">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Notes</p>
            <p class="text-sm text-gray-600">{{ $order->notes }}</p>
        </div>
        @endif

        <div class="text-center text-xs text-gray-400 mt-12">
            This is a computer-generated invoice. No signature is required.
        </div>

        <div class="mt-8 text-center no-print">
            <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow-lg transition">
                Print / Save as PDF
            </button>
            <a href="{{ route('customers.show', $order->customer_id) }}" class="text-gray-500 hover:text-gray-800 ml-4 text-sm font-medium">
                Go Back
            </a>
        </div>

    </div>
</body>
</html>
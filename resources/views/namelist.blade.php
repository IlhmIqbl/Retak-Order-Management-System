<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Namelist #{{ $order->id }} - {{ $order->customer->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none; }
            body { -webkit-print-color-adjust: exact; }
        }
    </style>
</head>
<body class="bg-white p-10 text-black">

    <div class="max-w-4xl mx-auto border-2 border-black p-8">
        
        <div class="flex justify-between items-center border-b-2 border-black pb-4 mb-6">
            <div>
                <h1 class="text-3xl font-bold uppercase">Production Namelist</h1>
                <p class="text-lg">Order ID: <span class="font-bold">#{{ $order->id }}</span></p>
                <p class="text-sm text-gray-600">Invoice: {{ $order->invoice_number }}</p>
            </div>
            <div class="text-right">
                <p class="font-bold text-xl">{{ $order->customer->name }}</p>
                <p>Due Date: {{ \Carbon\Carbon::parse($order->order_date)->addDays(14)->format('d M Y') }}</p> </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
            <div class="p-2 border border-gray-300">
                <span class="font-bold">Designer:</span> {{ $order->designer->name ?? 'Unassigned' }}
            </div>
            <div class="p-2 border border-gray-300">
                <span class="font-bold">Total Items:</span> {{ $order->items->sum('quantity') }} pcs
            </div>
        </div>

        <table class="w-full border-collapse border border-black">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-black px-4 py-2 w-16">No.</th>
                    <th class="border border-black px-4 py-2 text-left">Item Name / Description</th>
                    <th class="border border-black px-4 py-2 text-center">Fabric</th>
                    <th class="border border-black px-4 py-2 text-center">Cutting</th>
                    <th class="border border-black px-4 py-2 text-center">Size</th>
                    <th class="border border-black px-4 py-2 text-center">Qty</th>
                    <th class="border border-black px-4 py-2 w-24">Check</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $index => $item)
                <tr>
                    <td class="border border-black px-4 py-3 text-center">{{ $index + 1 }}</td>
                    <td class="border border-black px-4 py-3 font-bold">{{ $item->product_name }}</td>
                    <td class="border border-black px-4 py-3 text-center">{{ $item->fabric }}</td>
                    <td class="border border-black px-4 py-3 text-center">{{ $item->cutting }}</td>
                    <td class="border border-black px-4 py-3 text-center font-bold text-lg">{{ $item->size }}</td>
                    <td class="border border-black px-4 py-3 text-center">{{ $item->quantity }}</td>
                    <td class="border border-black px-4 py-3"></td> </tr>
                @endforeach
            </tbody>
        </table>

        @if($order->notes)
        <div class="mt-6 p-4 border border-black bg-gray-50">
            <p class="font-bold underline mb-2">Production Notes:</p>
            <p>{{ $order->notes }}</p>
        </div>
        @endif

        <div class="mt-8 text-center no-print px-2">
            <button onclick="window.print()" class="bg-black text-white px-6 py-2 font-bold uppercase tracking-wider rounded-xl hover:bg-gray-800">
                Print
            </button>
            <button onclick="window.close()" class="bg-red-500 text-white px-6 py-2 font-bold uppercase tracking-wider rounded-xl ml-4 hover:bg-red-700 transition">
            Close
        </button>
        </div>

    </div>

</body>
</html>
@extends('layouts.customer')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white shadow-lg rounded-lg border border-gray-200">
    <h2 class="text-3xl font-bold mb-6 text-center text-orange-600">🧾 Order History</h2>

    @if ($order)
        <div class="mb-6 space-y-2">
            <div class="flex justify-between">
                <span class="text-gray-600 font-medium">Order ID:</span>
                <span class="text-gray-800 font-semibold">{{ $order->id }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600 font-medium">Customer:</span>
                <span class="text-gray-800">{{ $order->customer_name }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600 font-medium">Status:</span>
                <span class="capitalize px-2 py-0.5 text-sm rounded 
                    @if($order->status == 'completed') bg-green-100 text-green-700 
                    @elseif($order->status == 'processing') bg-blue-100 text-blue-700 
                    @else bg-yellow-100 text-yellow-700 @endif">
                    {{ $order->status }}
                </span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600 font-medium">Placed At:</span>
                <span class="text-gray-800">{{ $order->created_at->format('d M Y H:i') }}</span>
            </div>
        </div>

        <div class="border-t border-gray-300 pt-4">
            <h3 class="text-xl font-semibold mb-3 text-gray-800">🧂 Ordered Items</h3>
            <ul class="divide-y divide-gray-200">
                @foreach ($order->items as $item)
                    <li class="py-3 flex justify-between items-center">
                        <div>
                            <p class="font-medium text-gray-900">{{ $item->menuItem->name }}</p>
                            <p class="text-sm text-gray-500">Quantity: {{ $item->quantity }}</p>
                        </div>
                        <p class="text-gray-700 font-semibold">
                            RM {{ number_format($item->menuItem->price * $item->quantity, 2) }}
                        </p>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="mt-6 text-right">
            <p class="text-xl font-bold text-gray-900">
                Total: <span class="text-orange-600">RM {{ number_format($order->total_amount, 2) }}</span>
            </p>
        </div>
    @else
        <div class="text-center text-gray-500">
            <p class="text-lg">No recent orders found.</p>
            <a href="{{ route('customer.menu') }}" class="inline-block mt-4 px-4 py-2 bg-orange-500 text-white rounded hover:bg-orange-600 transition">
                Browse Menu
            </a>
        </div>
    @endif
</div>
@endsection

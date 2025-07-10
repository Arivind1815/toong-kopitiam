@extends('layouts.customer')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 mt-10 rounded shadow">
    <h2 class="text-2xl font-bold text-green-600 mb-3 text-center">Thank You for Your Order!</h2>

    <div class="text-center mb-6">
        <p class="text-gray-700">Order ID: <span class="font-semibold">#{{ $order->id }}</span></p>
        <p class="text-sm text-gray-500">Placed on {{ $order->created_at->format('d M Y, h:i A') }}</p>
    </div>

    <div class="border-t pt-4">
        <h3 class="text-lg font-bold mb-2">Customer Information</h3>
        <p><strong>Name:</strong> {{ $order->customer_name }}</p>
        <p><strong>Email:</strong> {{ $order->email ?? '-' }}</p>
        <p><strong>Phone:</strong> {{ $order->phone }}</p>
        @if($order->special_instructions)
            <p><strong>Instructions:</strong> {{ $order->special_instructions }}</p>
        @endif
    </div>

    <div class="border-t mt-6 pt-4">
        <h3 class="text-lg font-bold mb-2">Order Summary</h3>
        <table class="w-full text-sm border border-collapse mb-4">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-3 py-2 text-left">Item</th>
                    <th class="border px-3 py-2 text-left">Qty</th>
                    <th class="border px-3 py-2 text-left">Price</th>
                    <th class="border px-3 py-2 text-left">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($order->items as $item)
                    @php
                        $name = $item->menuItem->name ?? 'Item Removed';
                        $price = $item->menuItem->price ?? 0;
                        $subtotal = $price * $item->quantity;
                        $total += $subtotal;
                    @endphp
                    <tr>
                        <td class="border px-3 py-2">{{ $name }}</td>
                        <td class="border px-3 py-2">{{ $item->quantity }}</td>
                        <td class="border px-3 py-2">RM {{ number_format($price, 2) }}</td>
                        <td class="border px-3 py-2">RM {{ number_format($subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-right text-lg font-bold">
            Total: RM {{ number_format($total, 2) }}
        </div>
    </div>

    <div class="text-center mt-6">
        <a href="{{ route('customer.index') }}" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">
            Back to Home
        </a>
    </div>
</div>
@endsection


@extends('layouts.admin')

@section('content')
    <h2 class="text-3xl font-bold text-gray-800 mb-2">🧾 Order #{{ $order->id }}</h2>

    {{-- Order Status --}}
    @php
        $badgeColors = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'processing' => 'bg-blue-100 text-blue-800',
            'completed' => 'bg-green-100 text-green-800',
        ];
    @endphp
    <div class="mb-4">
        <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full {{ $badgeColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
            {{ ucfirst($order->status) }}
        </span>
    </div>

    {{-- Customer Details --}}
    <div class="bg-white border rounded p-4 mb-6 shadow-sm space-y-2">
        <h3 class="text-lg font-semibold text-gray-700 mb-2">👤 Customer Info</h3>
        <p><span class="font-medium text-gray-600">Name:</span> {{ $order->customer_name }}</p>
        <p><span class="font-medium text-gray-600">Email:</span> {{ $order->email ?? '-' }}</p>
        <p><span class="font-medium text-gray-600">Phone:</span> {{ $order->phone ?? '-' }}</p>
        <p><span class="font-medium text-gray-600">Ordered At:</span> {{ $order->created_at->format('d M Y, h:i A') }}</p>
    </div>

    {{-- Special Instructions --}}
    @if (!empty($order->special_instructions))
        <div class="bg-yellow-50 border border-yellow-300 p-4 rounded mb-6 shadow-sm">
            <h4 class="font-semibold text-yellow-800 mb-1">📌 Special Instructions:</h4>
            <p class="whitespace-pre-line text-gray-800">{{ $order->special_instructions }}</p>
        </div>
    @endif

    {{-- Ordered Items --}}
    <h3 class="text-xl font-semibold text-gray-800 mb-2">🍽️ Items Ordered</h3>
    <div class="overflow-x-auto bg-white rounded shadow-sm mb-4">
        <table class="min-w-full text-sm border-collapse">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-4 py-2 text-left font-medium">Item</th>
                    <th class="px-4 py-2 text-left font-medium">Price</th>
                    <th class="px-4 py-2 text-left font-medium">Quantity</th>
                    <th class="px-4 py-2 text-left font-medium">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($order->items as $item)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 flex items-center gap-3">
                            @if ($item->menuItem && $item->menuItem->image)
                                <img src="{{ asset('storage/' . $item->menuItem->image) }}"
                                     class="w-10 h-10 object-cover rounded" alt="{{ $item->menuItem->name }}">
                            @endif
                            <span>{{ $item->menuItem->name ?? 'Item Removed' }}</span>
                        </td>
                        <td class="px-4 py-3">RM {{ number_format($item->menuItem->price ?? 0, 2) }}</td>
                        <td class="px-4 py-3">{{ $item->quantity }}</td>
                        <td class="px-4 py-3">
                            RM {{ number_format(($item->menuItem->price ?? 0) * $item->quantity, 2) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-gray-500 italic py-4">No items found in this order.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Total --}}
    <div class="text-right text-xl font-bold bg-gray-50 px-4 py-3 rounded shadow">
        💰 Total: RM {{ number_format($order->items->sum(fn($item) => ($item->menuItem->price ?? 0) * $item->quantity), 2) }}
    </div>

    {{-- Back Button --}}
    <div class="mt-6">
        <a href="{{ route('admin.orders') }}"
           class="inline-block text-blue-600 hover:underline text-sm">
           ← Back to Orders
        </a>
    </div>
@endsection




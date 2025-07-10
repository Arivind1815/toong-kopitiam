@extends('layouts.customer')

@section('content')
<div class="min-h-screen bg-gray-100 py-10 px-4">
    <div class="max-w-3xl mx-auto p-6 sm:p-8 bg-white shadow-xl rounded-2xl border border-gray-200">
        <h2 class="text-2xl font-bold mb-6 text-center">Checkout</h2>

        {{-- Display session error --}}
        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        {{-- Cart Items Validation --}}
        @if(!empty($cartItems) && is_array($cartItems) && count($cartItems) > 0)
        <form action="{{ route('order.store') }}" method="POST">
            @csrf

            {{-- Customer Info --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block font-semibold mb-1">Name</label>
                    <input type="text" name="customer_name" required class="w-full border px-3 py-2 rounded" value="{{ old('customer_name') }}">
                </div>
                <div>
                    <label class="block font-semibold mb-1">Phone</label>
                    <input type="text" name="phone" required class="w-full border px-3 py-2 rounded" value="{{ old('phone') }}">
                </div>
                <div class="md:col-span-2">
                    <label class="block font-semibold mb-1">Email</label>
                    <input type="email" name="email" required class="w-full border px-3 py-2 rounded" value="{{ old('email') }}">
                </div>
            </div>

            {{-- Special Instructions --}}
            <div class="mb-6">
                <label for="special_instructions" class="block font-semibold mb-1">
                    Special Instructions (optional)
                </label>
                <textarea name="special_instructions" id="special_instructions"
                    rows="3" placeholder="E.g. Less sugar, more spicy..."
                    class="w-full border px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('special_instructions') }}</textarea>
            </div>

            {{-- Order Summary --}}
            <h3 class="font-bold mb-3 text-lg">Order Summary</h3>
            <div class="mb-4 space-y-2 bg-gray-50 rounded p-4 border border-gray-200">
                @php $total = 0; @endphp
                @foreach($cartItems as $item)
                    @php
                        $quantity = $item['quantity'] ?? 1;
                        $subtotal = $item['price'] * $quantity;
                        $total += $subtotal;
                    @endphp
                    <div class="flex justify-between">
                        <span>{{ $item['name'] }} x {{ $quantity }}</span>
                        <span>RM {{ number_format($subtotal, 2) }}</span>
                    </div>
                @endforeach
            </div>

            <div class="text-right font-bold text-lg mb-6">
                Total: RM {{ number_format($total, 2) }}
            </div>

            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded transition">
                Place Order
            </button>
        </form>
        @else
            <p class="text-center text-gray-500 italic">Your cart is empty. 
                <a href="{{ route('customer.menu') }}" class="text-blue-600 hover:underline">Go back to menu</a>
            </p>
        @endif
    </div>
</div>
@endsection


@extends('layouts.customer')

@section('content')
<div class="max-w-4xl mx-auto mt-8 px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow-xl rounded-2xl p-6 sm:p-8">
        <!-- 🛒 Cart Header -->
        <h2 class="text-3xl font-extrabold text-gray-800 mb-6 border-b pb-3">🛒 Your Cart</h2>

        <!-- ✅ Success Message -->
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4 border border-green-300">
                {{ session('success') }}
            </div>
        @endif

        @if(count($cart) > 0)
        <form action="{{ route('cart.update') }}" method="POST">
            @csrf

            <!-- 🧾 Cart Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-sm sm:text-base border-collapse">
                    <thead class="bg-gray-100 text-gray-700 border-b">
                        <tr>
                            <th class="p-3 text-left">Item</th>
                            <th class="p-3 text-left">Quantity</th>
                            <th class="p-3 text-left">Price</th>
                            <th class="p-3 text-left">Subtotal</th>
                            <th class="p-3 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach($cart as $item)
                            @php
                                $itemId = (string)$item['id'];
                                $subtotal = $item['price'] * $item['quantity'];
                                $total += $subtotal;
                            @endphp
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3 font-medium text-gray-800">{{ $item['name'] }}</td>
                                <td class="p-3">
                                    <input type="number" name="quantities[{{ $itemId }}]"
                                           value="{{ $item['quantity'] }}" min="1"
                                           class="w-20 border-gray-300 rounded px-3 py-1 focus:ring-[#FF5722] focus:border-[#FF5722]">
                                </td>
                                <td class="p-3 text-gray-700">RM {{ number_format($item['price'], 2) }}</td>
                                <td class="p-3 text-gray-700">RM {{ number_format($subtotal, 2) }}</td>
                                <td class="p-3">
                                    <button type="submit" name="remove" value="{{ $itemId }}"
                                            class="text-red-500 hover:text-red-700 text-sm underline">
                                        Remove
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- 💰 Total and Actions -->
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-6">
                <div class="text-xl font-semibold text-gray-800">
                    Total: RM {{ number_format($total, 2) }}
                </div>
                <div class="flex flex-wrap gap-3">
                    <button type="submit"
                        class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 shadow-md">
                        Update Cart
                    </button>
                </div>
            </div>
        </form>

        <!-- 🔘 Bottom Buttons -->
        <div class="flex flex-col sm:flex-row items-center justify-between mt-8 gap-4">
            <!-- 🧹 Clear Cart -->
            <form action="{{ route('cart.clear') }}" method="POST" class="w-full sm:w-auto">
                @csrf
                <button type="submit"
                    class="w-full sm:w-auto bg-red-500 text-white px-5 py-2 rounded hover:bg-red-600 shadow-md">
                    Clear Cart
                </button>
            </form>

            <!-- 🧾 Checkout -->
            <a href="{{ route('cart.checkout') }}"
                class="w-full sm:w-auto text-center bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 shadow-md font-semibold">
                Proceed to Checkout
            </a>
        </div>

        @else
            <div class="text-center text-gray-500 italic mt-8">
                🛍️ Your cart is currently empty.
            </div>
        @endif
    </div>
</div>
@endsection




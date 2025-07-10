<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Toong Kopitiam</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        ::selection {
            background-color: #ff7043;
            color: black;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 min-h-screen flex flex-col">

    <!-- 🔶 Navigation Bar -->
    <nav class="text-black shadow-lg" style="background-color: #FF5722;">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ route('customer.index') }}" class="text-2xl font-extrabold tracking-wide hover:text-white transition">
                Toong Kopitiam
            </a>

            <div class="flex items-center gap-6">
                <!-- ✅ Menu Link -->
                <a href="{{ route('customer.menu') }}"
                   class="text-base font-semibold hover:text-white transition">
                    Menu
                </a>

                <!-- ✅ Order History Link -->
                <a href="{{ route('customer.history') }}"
                   class="text-base font-semibold hover:text-white transition">
                    Order History
                </a>

                <!-- ✅ Cart Dropdown -->
                @php
                    $cart = session('cart', []);
                    $cartCount = array_sum(array_column($cart, 'quantity'));
                    $cartTotal = array_reduce($cart, fn($sum, $item) => $sum + ($item['price'] * $item['quantity']), 0);
                @endphp

                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.away="open = false"
                            class="relative flex items-center text-black focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 2.7A1 1 0 007 17h10m-5 0a1 1 0 100 2 1 1 0 000-2m-6 0a1 1 0 100 2 1 1 0 000-2"/>
                        </svg>
                        Cart
                        @if($cartCount > 0)
                            <span class="absolute top-0 right-0 transform translate-x-1/2 -translate-y-1/2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold bg-white text-red-600 rounded-full shadow">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </button>

                    <!-- Cart Dropdown -->
                    <div x-show="open" x-transition class="absolute right-0 mt-2 w-72 bg-white text-black rounded-lg shadow-xl z-50"
                         style="display: none;" @click.away="open = false">
                        <div class="p-4 max-h-64 overflow-y-auto text-sm">
                            @forelse ($cart as $item)
                                <div class="flex justify-between items-center mb-2">
                                    <div>
                                        <p class="font-medium">{{ $item['name'] }}</p>
                                        <p class="text-xs text-gray-600">Qty: {{ $item['quantity'] }}</p>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-700">
                                        RM {{ number_format($item['price'] * $item['quantity'], 2) }}
                                    </span>
                                </div>
                            @empty
                                <p class="text-gray-500">Cart is empty.</p>
                            @endforelse
                        </div>

                        @if(count($cart) > 0)
                            <div class="border-t px-4 py-3 bg-gray-50 flex justify-between items-center">
                                <span class="font-semibold">Total:</span>
                                <span class="text-red-600 font-bold">RM {{ number_format($cartTotal, 2) }}</span>
                            </div>
                            <div class="p-4 pt-2">
                                <a href="{{ route('customer.cart') }}"
                                   class="block text-center text-black px-4 py-2 rounded-md text-sm font-medium"
                                   style="background-color: #FF5722;">
                                    View Cart
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- 🔸 Main Content -->
    <main class="flex-1 max-w-7xl mx-auto w-full p-6">
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded shadow-sm">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded shadow-sm">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <!-- 🔹 Footer -->
    <footer class="bg-white border-t py-4 text-center text-sm text-gray-500">
        &copy; {{ date('Y') }} Toong Kopitiam. All rights reserved.
    </footer>
</body>
</html>

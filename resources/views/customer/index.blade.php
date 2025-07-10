@extends('layouts.customer')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8 bg-white rounded-xl shadow-inner">
    <h1 class="text-4xl font-extrabold text-center text-gray-900 mb-12 tracking-tight">
        🍽️ Popular at <span class="text-[#FF5722]">Toong Kopitiam</span>
    </h1>

    @foreach(['food' => 'Delicious Food', 'beverage' => 'Refreshing Beverages', 'sides' => 'Tasty Sides'] as $key => $label)
        @if($popularItems[$key]->count())
            <section class="mb-20">
                <!-- Section Header -->
                <div class="flex justify-between items-center mb-6 border-b pb-2 border-gray-300">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 tracking-tight">
                        {{ $label }}
                    </h2>
                    <a href="{{ route('customer.menu') }}?category={{ $key }}"
                       class="text-sm font-medium text-[#FF5722] hover:text-orange-700 transition">
                        View All →
                    </a>
                </div>

                <!-- Items Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                    @foreach($popularItems[$key] as $item)
                        <div class="bg-gray rounded-2xl border border-gray-200 shadow hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col overflow-hidden group">
                            
                            <!-- Item Image -->
                            @if($item->image)
                                <div class="h-48 overflow-hidden relative">
                                    <img src="{{ asset('storage/' . $item->image) }}"
                                         alt="{{ $item->name }}"
                                         class="h-full w-full object-cover transform group-hover:scale-105 transition duration-300 ease-in-out">
                                </div>
                            @else
                                <div class="h-48 flex items-center justify-center bg-gray-100 text-gray-400">
                                    <span>No Image</span>
                                </div>
                            @endif

                            <!-- Card Content -->
                            <div class="p-5 flex-1 flex flex-col justify-between">
                                
                                <!-- Item Title -->
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-1 group-hover:text-[#FF5722] transition">
                                        {{ $item->name }}
                                    </h3>

                                    <!-- Description -->
                                    <p class="text-sm text-gray-600 mb-4 leading-relaxed">
                                        {{ Str::limit($item->description, 80, '...') }}
                                    </p>
                                </div>

                                <!-- Price & Add-to-Cart -->
                                <div class="mt-auto flex items-center justify-between">
                                    <span class="text-xl font-bold text-green-700">
                                        RM {{ number_format($item->price, 2) }}
                                    </span>

                                    <form method="POST" action="{{ route('cart.add') }}" class="flex items-center gap-2">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit"
                                            class="bg-[#FF5722] text-black font-semibold px-4 py-2 text-sm rounded-full shadow hover:bg-orange-600 hover:text-white transition">
                                            Add to Cart
                                        </button>
                                    </form>
                                </div>

                                <!-- Optional Labels -->
                                @if($item->is_spicy || $item->is_veg || $item->is_special)
                                    <div class="mt-3 flex gap-2 text-xs">
                                        @if($item->is_spicy)
                                            <span class="bg-red-100 text-red-600 px-2 py-0.5 rounded-full">🌶️ Spicy</span>
                                        @endif
                                        @if($item->is_veg)
                                            <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full">🥬 Veg</span>
                                        @endif
                                        @if($item->is_special)
                                            <span class="bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded-full">⭐ Best Seller</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    @endforeach

    <!-- Section Footer -->
    <div class="text-center mt-10">
        <a href="{{ route('customer.menu') }}"
           class="inline-block bg-black text-white font-semibold px-6 py-3 rounded-full shadow hover:bg-gray-800 transition">
            Explore Full Menu
        </a>
    </div>
</div>
@endsection

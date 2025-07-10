<div class="bg-white rounded-2xl shadow-md hover:shadow-xl border border-gray-200 overflow-hidden flex flex-col transition-all duration-300 group">
    @if ($item->image)
        <div class="h-48 overflow-hidden">
            <img src="{{ asset('storage/' . $item->image) }}"
                 alt="{{ $item->name }}"
                 class="w-full h-full object-cover transform group-hover:scale-105 transition duration-300 ease-in-out">
        </div>
    @endif

    <div class="p-5 flex flex-col justify-between flex-1">
        <!-- Title -->
        <h4 class="text-xl font-bold text-gray-900 mb-1 group-hover:text-[#FF5722] transition">
            {{ $item->name }}
        </h4>

        <!-- Description -->
        <p class="text-sm text-gray-600 mb-4 leading-relaxed">
            {{ Str::limit($item->description, 90) }}
        </p>

        <!-- Price & Action -->
        <div class="mt-auto">
            <div class="flex justify-between items-center mb-3">
                <span class="text-xl font-extrabold text-green-700">RM {{ number_format($item->price, 2) }}</span>
                <span class="text-xs text-gray-400">{{ ucfirst($item->category ?? 'item') }}</span>
            </div>

            <form action="{{ route('cart.add') }}" method="POST" class="flex items-center gap-2">
                @csrf
                <input type="hidden" name="id" value="{{ $item->id }}">
                <input type="hidden" name="name" value="{{ $item->name }}">
                <input type="hidden" name="price" value="{{ $item->price }}">

                <!-- Quantity Input -->
                <input type="number" name="quantity" value="1" min="1"
                       class="w-16 px-2 py-1 text-sm border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-orange-300">

                <!-- Add Button -->
                <button type="submit"
                        class="flex-1 bg-[#FF5722] hover:bg-orange-600 text-black px-4 py-2 rounded-full text-sm font-semibold shadow-md transition">
                    Add to Cart
                </button>
            </form>
        </div>
    </div>
</div>

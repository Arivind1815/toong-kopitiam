@extends('layouts.customer')

@section('content')
<h2 class="text-3xl font-extrabold mb-10 text-center text-gray-900">🛍️ Browse Our Menu</h2>

<!-- Alpine wrapper -->
<div x-data="{ selected: 'food' }">

    <!-- Category Tabs -->
    <div class="flex flex-wrap justify-center gap-3 mb-8">
        @foreach (['food' => 'Food', 'beverage' => 'Beverage', 'sides' => 'Sides'] as $key => $label)
            <button type="button"
                @click="selected = '{{ $key }}'"
                class="px-5 py-2 rounded-full text-sm font-semibold transition-all duration-300 border"
                :class="selected === '{{ $key }}'
                    ? 'bg-[#FF5722] text-black shadow'
                    : 'bg-white text-black border-gray-400 hover:bg-gray-100 hover:text-orange-600'">
                {{ $label }}
            </button>
        @endforeach
    </div>

    <!-- Menu Sections (Switch Based on Tab) -->
    <template x-if="selected === 'food'">
        <div>
            <h3 class="text-2xl font-semibold mb-6 text-left text-gray-800 border-b pb-2 border-gray-300">Food</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($menuItems['food'] ?? [] as $item)
                    @include('partials.menu-card', ['item' => $item])
                @endforeach
            </div>
        </div>
    </template>

    <template x-if="selected === 'beverage'">
        <div>
            <h3 class="text-2xl font-semibold mb-6 text-left text-gray-800 border-b pb-2 border-gray-300">Beverage</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($menuItems['beverage'] ?? [] as $item)
                    @include('partials.menu-card', ['item' => $item])
                @endforeach
            </div>
        </div>
    </template>

    <template x-if="selected === 'sides'">
        <div>
            <h3 class="text-2xl font-semibold mb-6 text-left text-gray-800 border-b pb-2 border-gray-300">Sides</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($menuItems['sides'] ?? [] as $item)
                    @include('partials.menu-card', ['item' => $item])
                @endforeach
            </div>
        </div>
    </template>

</div>
@endsection

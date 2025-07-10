@extends('layouts.admin')

@section('content')
<div class="flex items-center justify-center min-h-[75vh] bg-gray-50 px-4">
    <div class="w-full max-w-md bg-white p-6 rounded-2xl shadow-md">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">✏️ Edit Menu Item</h2>

        {{-- Error Alert --}}
        @if($errors->any())
            <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded mb-4 shadow-sm text-sm">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>⚠️ {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('admin.menu.update', $item->id) }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block font-medium text-gray-700 mb-1">Name <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $item->name) }}"
                       class="w-full border border-gray-300 px-4 py-2 rounded focus:ring-2 focus:ring-blue-400 focus:outline-none"
                       required>
            </div>

            <div>
                <label for="category" class="block font-medium text-gray-700 mb-1">Category <span class="text-red-500">*</span></label>
                <select name="category" id="category"
                        class="w-full border border-gray-300 px-4 py-2 rounded bg-white focus:ring-2 focus:ring-blue-400 focus:outline-none"
                        required>
                    <option value="food" {{ $item->category === 'food' ? 'selected' : '' }}>🍽️ Food</option>
                    <option value="beverage" {{ $item->category === 'beverage' ? 'selected' : '' }}>🥤 Beverage</option>
                    <option value="sides" {{ $item->category === 'sides' ? 'selected' : '' }}>🍟 Sides</option>
                </select>
            </div>

            <div>
                <label for="price" class="block font-medium text-gray-700 mb-1">Price (RM) <span class="text-red-500">*</span></label>
                <input type="number" step="0.01" id="price" name="price" value="{{ old('price', $item->price) }}"
                       class="w-full border border-gray-300 px-4 py-2 rounded focus:ring-2 focus:ring-blue-400 focus:outline-none"
                       required>
            </div>

            <div>
                <label for="description" class="block font-medium text-gray-700 mb-1">Description</label>
                <textarea id="description" name="description" rows="3"
                          class="w-full border border-gray-300 px-4 py-2 rounded focus:ring-2 focus:ring-blue-400 focus:outline-none"
                          placeholder="Describe this menu item...">{{ old('description', $item->description) }}</textarea>
            </div>

            <div>
                <label for="image" class="block font-medium text-gray-700 mb-1">Image (optional)</label>
                <input type="file" name="image" id="image" accept="image/*"
                       class="w-full border border-gray-300 px-4 py-2 rounded bg-white file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200">

                @if($item->image)
                    <div class="mt-3">
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}"
                             class="w-32 h-32 object-cover rounded shadow border">
                    </div>
                @endif
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 text-white text-center font-semibold px-4 py-2 rounded hover:bg-blue-700 transition">
                💾 Update Item
            </button>
        </form>
    </div>
</div>
@endsection

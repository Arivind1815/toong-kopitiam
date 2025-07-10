@extends('layouts.admin')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-2xl shadow-md">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">🍽️ Add New Menu Item</h2>

    {{-- ✅ Success message --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded mb-4 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- ❌ Validation errors --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded mb-4 shadow-sm">
            <ul class="list-disc pl-5 space-y-1 text-sm">
                @foreach ($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- 📋 Form --}}
    <form method="POST" action="{{ route('admin.menu.store') }}" enctype="multipart/form-data" class="space-y-5">
        @csrf

        <div>
            <label class="block font-semibold text-gray-700 mb-1" for="name">Item Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name') }}"
                   class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                   placeholder="e.g., Nasi Lemak" required>
        </div>

        <div>
            <label class="block font-semibold text-gray-700 mb-1" for="price">Price (RM) <span class="text-red-500">*</span></label>
            <input type="number" step="0.01" name="price" id="price" value="{{ old('price') }}"
                   class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                   placeholder="e.g., 6.50" required>
        </div>

        <div>
            <label class="block font-semibold text-gray-700 mb-1" for="category">Category <span class="text-red-500">*</span></label>
            <select name="category" id="category"
                    class="w-full border border-gray-300 rounded px-4 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required>
                <option value="" disabled selected>-- Select Category --</option>
                <option value="food" {{ old('category') == 'food' ? 'selected' : '' }}>🍛 Food</option>
                <option value="beverage" {{ old('category') == 'beverage' ? 'selected' : '' }}>🥤 Beverage</option>
                <option value="sides" {{ old('category') == 'sides' ? 'selected' : '' }}>🍟 Sides</option>
            </select>
        </div>

        <div>
            <label class="block font-semibold text-gray-700 mb-1" for="description">Description</label>
            <textarea name="description" id="description" rows="3"
                      class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                      placeholder="Brief description (optional)">{{ old('description') }}</textarea>
        </div>

        <div>
            <label class="block font-semibold text-gray-700 mb-1" for="image">Image (optional)</label>
            <input type="file" name="image" id="image" accept="image/*"
                   class="w-full border border-gray-300 rounded px-4 py-2 bg-white file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200">
        </div>

        <button type="submit"
                class="w-full bg-blue-600 text-white font-semibold px-4 py-2 rounded hover:bg-blue-700 transition">
            ➕ Add Item
        </button>
    </form>
</div>
@endsection

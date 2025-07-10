@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto p-4">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">📋 Menu Management</h2>

    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded shadow-sm mb-4">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 gap-3">
        <a href="{{ route('admin.menu.create') }}"
           class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition w-full sm:w-auto text-center">
            ➕ Add New Item
        </a>
    </div>

    <!-- 🔍 Filters -->
    <form method="GET" action="{{ route('admin.menu') }}"
        class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6 bg-white p-4 rounded shadow-sm border border-gray-200">

        <!-- 🔎 Search -->
        <div class="md:col-span-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="🔍 Search by name..."
                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm"
                aria-label="Search menu items">
        </div>

        <!-- 📂 Category Filter -->
        <div>
            <select name="category"
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm">
                <option value="">📂 All Categories</option>
                <option value="food" {{ request('category') == 'food' ? 'selected' : '' }}>🍛 Food</option>
                <option value="beverage" {{ request('category') == 'beverage' ? 'selected' : '' }}>🥤 Beverage</option>
                <option value="sides" {{ request('category') == 'sides' ? 'selected' : '' }}>🍟 Sides</option>
            </select>
        </div>

        <!-- ✅ Availability Filter -->
        <div>
            <select name="available"
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm">
                <option value="">⚙️ All Status</option>
                <option value="1" {{ request('available') === '1' ? 'selected' : '' }}>✅ Available</option>
                <option value="0" {{ request('available') === '0' ? 'selected' : '' }}>❌ Unavailable</option>
            </select>
        </div>

        <!-- 🔃 Sort By -->
        <div>
            <select name="sort"
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm">
                <option value="">↕️ Sort By</option>
                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>🔤 Name A-Z</option>
                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>🔡 Name Z-A</option>
                <option value="price_low_high" {{ request('sort') == 'price_low_high' ? 'selected' : '' }}>💸 Price Low-High</option>
                <option value="price_high_low" {{ request('sort') == 'price_high_low' ? 'selected' : '' }}>💰 Price High-Low</option>
                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>🆕 Newest</option>
                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>📅 Oldest</option>
            </select>
        </div>

        <!-- 🔵 Filter Button -->
        <div class="md:col-span-5 flex justify-end">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded shadow transition duration-150">
                Apply Filters
            </button>
        </div>
    </form>

    <!-- 📋 Menu Table -->
    <div class="bg-white rounded shadow-md overflow-x-auto">
        @if ($menuItems->count())
            <table class="min-w-full text-sm text-left" id="sortable-table">
                <thead class="bg-gray-100 text-gray-700 uppercase tracking-wider">
                    <tr>
                        <th class="px-4 py-3">Image</th>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Category</th>
                        <th class="px-4 py-3">Price (RM)</th>
                        <th class="px-4 py-3">Available</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody id="sortable-body">
                    @foreach ($menuItems as $item)
                        <tr class="border-t" data-id="{{ $item->id }}">
                            <td class="px-4 py-3">
                                @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}"
                                         class="w-16 h-16 object-cover rounded shadow">
                                @else
                                    <span class="text-gray-500 italic">No Image</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">{{ $item->name }}</td>
                            <td class="px-4 py-3">{{ ucfirst($item->category) }}</td>
                            <td class="px-4 py-3">RM {{ number_format($item->price, 2) }}</td>
                            <td class="px-4 py-3">
                                <button
                                    class="availability-toggle text-sm px-3 py-1 rounded text-white transition
                                           {{ $item->available ? 'bg-green-500 hover:bg-green-600' : 'bg-gray-400 hover:bg-gray-500' }}"
                                    data-id="{{ $item->id }}"
                                    data-available="{{ $item->available }}">
                                    {{ $item->available ? 'Available' : 'Unavailable' }}
                                </button>
                            </td>
                            <td class="px-4 py-3 space-x-2">
                                <a href="{{ route('admin.menu.edit', $item->id) }}"
                                   class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">
                                    ✏️ Edit
                                </a>
                                <form action="{{ route('admin.menu.destroy', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure?')"
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                        🗑️ Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-center py-6 text-gray-500 italic">No menu items found.</p>
        @endif
    </div>

    <!-- 📄 Pagination -->
    <div class="mt-6">
        {{ $menuItems->appends(request()->query())->links() }}
    </div>
</div>

<!-- 🔃 Sortable & Toggle Scripts -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    const sortable = new Sortable(document.getElementById('sortable-body'), {
        animation: 150,
        onEnd: function () {
            let order = [];
            document.querySelectorAll('#sortable-body tr').forEach((row, index) => {
                order.push({ id: row.dataset.id, position: index + 1 });
            });

            fetch('{{ route('admin.menu.reorder') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ order })
            });
        }
    });

    document.querySelectorAll('.availability-toggle').forEach(button => {
        button.addEventListener('click', function () {
            const menuItemId = this.dataset.id;
            fetch(`/admin/menu/toggle-availability/${menuItemId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            }).then(res => res.json())
              .then(data => {
                  if (data.success) {
                      this.dataset.available = data.available;
                      this.textContent = data.available ? 'Available' : 'Unavailable';
                      this.classList.toggle('bg-green-500', data.available);
                      this.classList.toggle('hover:bg-green-600', data.available);
                      this.classList.toggle('bg-gray-400', !data.available);
                      this.classList.toggle('hover:bg-gray-500', !data.available);
                  }
              });
        });
    });
</script>
@endsection


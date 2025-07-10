@extends('layouts.admin')

@section('content')
<h2 class="text-3xl font-bold text-gray-800 mb-4">📦 Manage Orders</h2>

<!-- 🔍 Filter Section -->
<form method="GET" class="mb-6 flex flex-col md:flex-row md:items-end gap-4">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, email, or date"
           class="border px-4 py-2 rounded w-full md:w-1/3 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">

    <select name="status" class="border px-4 py-2 rounded w-full md:w-1/4 shadow-sm focus:ring-2 focus:ring-blue-500">
        <option value="">All Statuses</option>
        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Processing</option>
        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
    </select>

    <select name="sort" class="border px-4 py-2 rounded w-full md:w-1/4 shadow-sm focus:ring-2 focus:ring-blue-500">
        <option value="">Sort By</option>
        <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Newest</option>
        <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest</option>
        <option value="amount_desc" {{ request('sort') === 'amount_desc' ? 'selected' : '' }}>Total: High to Low</option>
        <option value="amount_asc" {{ request('sort') === 'amount_asc' ? 'selected' : '' }}>Total: Low to High</option>
    </select>

    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded shadow">
        Filter
    </button>
</form>

<!-- 📋 Orders Table -->
<div class="overflow-x-auto bg-white shadow rounded-lg">
    <table class="w-full text-sm table-auto">
        <thead class="bg-gray-100 text-gray-700 text-left">
            <tr>
                <th class="p-3">Order ID</th>
                <th class="p-3">Customer</th>
                <th class="p-3">Email</th>
                <th class="p-3">Phone</th>
                <th class="p-3">Total</th>
                <th class="p-3">Status</th>
                <th class="p-3">Date</th>
                <th class="p-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                <tr class="border-t hover:bg-gray-50 transition">
                    <td class="p-3 font-medium text-gray-800">{{ $order->id }}</td>
                    <td class="p-3">
                        {{ $order->customer_name }}
                        @if ($order->created_at->gt(now()->subDay()))
                            <span class="ml-2 text-xs bg-red-500 text-white px-2 py-0.5 rounded-full">New</span>
                        @endif
                    </td>
                    <td class="p-3">{{ $order->email ?? '-' }}</td>
                    <td class="p-3">{{ $order->phone ?? '-' }}</td>
                    <td class="p-3 font-semibold text-blue-600">RM {{ number_format($order->total_amount, 2) }}</td>
                    <td class="p-3">
                        @php
                            $badgeColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'processing' => 'bg-blue-100 text-blue-800',
                                'completed' => 'bg-green-100 text-green-800',
                            ];
                        @endphp
                        <span class="text-xs px-2 py-1 rounded font-semibold {{ $badgeColors[$order->status] ?? 'bg-gray-200 text-gray-800' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="p-3 text-gray-600">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                    <td class="p-3">
                        <div class="flex flex-wrap gap-2 items-center">
                            <!-- 🔄 Status Update -->
                            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="flex items-center gap-1">
                                @csrf
                                @method('PUT')
                                <select name="status" class="text-sm border rounded px-2 py-1 focus:ring-blue-500">
                                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                                <button type="submit" class="bg-green-600 text-white text-xs px-2 py-1 rounded hover:bg-green-700 transition">
                                    Update
                                </button>
                            </form>

                            <!-- 👁️ View -->
                            <a href="{{ route('admin.orders.show', $order->id) }}"
                               class="bg-blue-600 text-white text-xs px-2 py-1 rounded hover:bg-blue-700 transition">
                                View
                            </a>

                            <!-- 🗑️ Delete -->
                            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this order?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white text-xs px-2 py-1 rounded hover:bg-red-700 transition">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center py-6 text-gray-400 italic">
                        🛒 No orders found. Try adjusting your filters.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- 📄 Pagination -->
<div class="mt-6">
    {{ $orders->withQueryString()->links() }}
</div>
@endsection

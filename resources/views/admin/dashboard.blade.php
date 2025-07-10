@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <!-- Header -->
    <h2 class="text-3xl font-bold text-gray-800 mb-2">👋 Welcome, Admin</h2>
    <p class="text-gray-500 mb-6">Here's an overview of your restaurant system's activity.</p>

    <!-- 🔢 Quick Stats Summary -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg shadow text-center">
            <h3 class="text-sm text-gray-500 mb-1">Total Menu Items</h3>
            <p class="text-2xl font-bold text-blue-600">{{ $totalItems }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow text-center">
            <h3 class="text-sm text-gray-500 mb-1">Food Items</h3>
            <p class="text-2xl font-bold text-green-600">{{ $foodCount }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow text-center">
            <h3 class="text-sm text-gray-500 mb-1">Beverage Items</h3>
            <p class="text-2xl font-bold text-yellow-600">{{ $beverageCount }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow text-center">
            <h3 class="text-sm text-gray-500 mb-1">Sides</h3>
            <p class="text-2xl font-bold text-purple-600">{{ $sidesCount }}</p>
        </div>
    </div>

    <!-- 📦 Order Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg shadow text-center">
            <h3 class="text-sm text-gray-500 mb-1">Total Orders</h3>
            <p class="text-2xl font-bold text-gray-800">{{ $totalOrders }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow text-center">
            <h3 class="text-sm text-gray-500 mb-1">Pending Orders</h3>
            <p class="text-2xl font-bold text-amber-500">{{ $pendingOrders }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow text-center">
            <h3 class="text-sm text-gray-500 mb-1">Completed Orders</h3>
            <p class="text-2xl font-bold text-emerald-600">{{ $completedOrders }}</p>
        </div>
    </div>

    <!-- 🆕 Recently Added Menu Items -->
    <div class="bg-white p-5 rounded-lg shadow mb-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-3">📋 Recently Added Menu Items</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left table-auto">
                <thead class="text-gray-600 bg-gray-50 border-b">
                    <tr>
                        <th class="py-2 px-4">Name</th>
                        <th class="py-2 px-4">Category</th>
                        <th class="py-2 px-4">Price</th>
                        <th class="py-2 px-4">Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentItems as $item)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2 px-4">{{ $item->name }}</td>
                            <td class="py-2 px-4 capitalize">{{ $item->category }}</td>
                            <td class="py-2 px-4">RM {{ number_format($item->price, 2) }}</td>
                            <td class="py-2 px-4 text-sm text-gray-500">{{ $item->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-4 text-center text-gray-500">No recent items found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- 📊 Sales Summary -->
    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-3">📈 Sales Summary (RM)</h3>
        <canvas id="salesChart" height="80"></canvas>
    </div>

    <!-- 🍽️ Popular Items & Status Charts -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white p-5 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-3">🔥 Most Popular Items</h3>
            <canvas id="popularItemsChart" class="mx-auto" width="250" height="250"></canvas>
        </div>

        <div class="bg-white p-5 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-3">📊 Order Status Overview</h3>
            <canvas id="orderStatusChart" class="mx-auto" width="250" height="250"></canvas>
        </div>
    </div>

    <!-- 🔗 Navigation Links -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('admin.menu') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-center py-3 rounded shadow transition">
            🍔 Manage Menu
        </a>
        <a href="{{ route('admin.orders') }}" class="bg-green-600 hover:bg-green-700 text-white text-center py-3 rounded shadow transition">
            🧾 Manage Orders
        </a>
        <a href="{{ route('admin.logout') }}" class="bg-red-600 hover:bg-red-700 text-white text-center py-3 rounded shadow transition">
            🚪 Logout
        </a>
    </div>
</div>

<!-- 🧠 Charts Scripts -->
<script>
    // Sales Chart
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    new Chart(salesCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($salesDates) !!},
            datasets: [{
                label: 'Sales (RM)',
                data: {!! json_encode($salesAmounts) !!},
                backgroundColor: 'rgba(79, 70, 229, 0.6)',
                borderRadius: 6,
                maxBarThickness: 40,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Popular Items Pie Chart
    new Chart(document.getElementById('popularItemsChart'), {
        type: 'pie',
        data: {
            labels: {!! json_encode($popularItems->pluck('name')) !!},
            datasets: [{
                data: {!! json_encode($popularItems->pluck('total_sold')) !!},
                backgroundColor: ['#60a5fa', '#34d399', '#fbbf24', '#f87171', '#c084fc'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });

    // Order Status Doughnut Chart
    new Chart(document.getElementById('orderStatusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Completed'],
            datasets: [{
                data: [{{ $pendingOrders }}, {{ $completedOrders }}],
                backgroundColor: ['#facc15', '#4ade80'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>
@endsection

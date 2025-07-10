<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Toong Kopitiam Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        ::selection {
            background-color: #3B82F6; /* blue-500 */
            color: white;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 font-sans min-h-screen flex flex-col">

    <!-- 🔶 Admin Navigation Bar -->
    <nav class="bg-white shadow border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ route('admin.dashboard') }}"
               class="text-2xl font-extrabold text-orange-600 hover:text-orange-700 transition">
               🧾 Toong Kopitiam Admin
            </a>

            <div class="flex flex-wrap gap-3 mt-2 md:mt-0">
                <a href="{{ route('admin.menu') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded shadow transition">
                    Manage Menu
                </a>
                <a href="{{ route('admin.orders') }}"
                   class="bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-2 rounded shadow transition">
                    View Orders
                </a>
                <a href="{{ route('admin.logout') }}"
                   class="bg-red-600 hover:bg-red-700 text-white text-sm px-4 py-2 rounded shadow transition">
                    Logout
                </a>
            </div>
        </div>
    </nav>

    <!-- 🔸 Main Admin Content -->
    <main class="flex-1 px-6 py-6 max-w-7xl mx-auto w-full">
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

    <!-- 🔹 Footer -->
    <footer class="bg-white border-t text-center py-4 text-sm text-slate-500">
        &copy; {{ date('Y') }} Toong Kopitiam Admin. All rights reserved.
    </footer>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Login - Toong Kopitiam')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .backdrop-blur {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.85);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-orange-100 via-orange-200 to-orange-300 min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-md p-8 rounded-3xl backdrop-blur shadow-xl border border-orange-300 transition-transform transform hover:-translate-y-1 hover:shadow-orange-400">


        {{-- Title & Subtitle --}}
        <div class="text-center mb-6">
            <h1 class="text-3xl font-extrabold text-orange-600 tracking-tight">Toong Kopitiam</h1>
            <p class="text-gray-600 text-sm">Admin Control Panel Login</p>
        </div>

        {{-- Yield Login Form --}}
        @yield('content')

        {{-- Footer --}}
        <p class="mt-8 text-xs text-center text-gray-500">
            &copy; {{ date('Y') }} Toong Kopitiam.
        </p>
    </div>

</body>
</html>

@extends('layouts.auth')

@section('title', 'Admin Login')

@section('content')
    <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md border border-gray-200 mt-10">
        <h2 class="text-3xl font-extrabold text-center text-orange-600 mb-6">
            Admin Login
        </h2>

        {{-- Session Error --}}
        @if(session('error'))
            <div class="bg-red-100 text-red-800 border border-red-300 p-3 rounded mb-4 text-sm">
                {{ session('error') }}
            </div>
        @endif

        {{-- Login Form --}}
        <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-6" novalidate>
            @csrf

            {{-- Username --}}
            <div>
                <label for="username" class="block text-sm font-semibold text-gray-700 mb-1">Username</label>
                <input type="text" id="username" name="username"
                       value="{{ old('username') }}"
                       placeholder="Enter admin username"
                       class="w-full border border-gray-300 px-4 py-2 rounded-md focus:ring-2 focus:ring-orange-400 focus:outline-none"
                       required autofocus>
                @error('username')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                <input type="password" id="password" name="password"
                       placeholder="••••••••"
                       class="w-full border border-gray-300 px-4 py-2 rounded-md focus:ring-2 focus:ring-orange-400 focus:outline-none"
                       required>
                @error('password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit --}}
            <div>
                <button type="submit"
                        class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 rounded-md shadow-md transition duration-200">
                    Login
                </button>
            </div>
        </form>
    </div>
@endsection

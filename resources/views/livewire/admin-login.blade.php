<div>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-6 rounded shadow w-96">
        <h2 class="text-2xl font-bold mb-4 text-center">Admin Login</h2>

        @if ($error)
            <div class="bg-red-100 text-red-700 px-3 py-2 rounded mb-4">
                {{ $error }}
            </div>
        @endif

        <form wire:submit.prevent="login">
            <input type="text" wire:model="username" placeholder="Username"
                   class="w-full mb-3 p-2 border rounded" required>

            <input type="password" wire:model="password" placeholder="Password"
                   class="w-full mb-4 p-2 border rounded" required>

            <button type="submit"
                    class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">
                Login
            </button>
        </form>
    </div>
</div>

</div>

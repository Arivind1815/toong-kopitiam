<div class="max-w-4xl mx-auto p-4 bg-white shadow rounded">
    <h2 class="text-xl font-bold mb-4">{{ $editId ? 'Edit' : 'Add' }} Menu Item</h2>

    <form wire:submit.prevent="save" class="space-y-4">
        <input type="text" wire:model="name" placeholder="Name" class="w-full p-2 border rounded" required>

        <input type="number" wire:model="price" step="0.01" placeholder="Price (e.g., 4.50)" class="w-full p-2 border rounded" required>

        <select wire:model="category" class="w-full p-2 border rounded" required>
            <option value="">-- Select Category --</option>
            <option value="food">Food</option>
            <option value="beverage">Beverage</option>
            <option value="sides">Sides</option>
        </select>

        <textarea wire:model="description" placeholder="Description" class="w-full p-2 border rounded"></textarea>

        <div class="flex space-x-2">
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">
                {{ $editId ? 'Update' : 'Add' }}
            </button>
            @if($editId)
                <button type="button" wire:click="resetForm" class="bg-gray-500 text-white px-4 py-2 rounded">
                    Cancel
                </button>
            @endif
        </div>
    </form>

    <hr class="my-6">

    <h3 class="text-lg font-semibold mb-2">All Menu Items</h3>
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2">Name</th>
                <th class="p-2">Category</th>
                <th class="p-2">Price</th>
                <th class="p-2">Description</th>
                <th class="p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($menuItems as $item)
                <tr class="border-b">
                    <td class="p-2">{{ $item->name }}</td>
                    <td class="p-2 capitalize">{{ $item->category }}</td>
                    <td class="p-2">RM {{ number_format($item->price, 2) }}</td>
                    <td class="p-2">{{ $item->description }}</td>
                    <td class="p-2">
                        <button wire:click="edit({{ $item->id }})" class="text-blue-600 hover:underline">Edit</button>
                        <button wire:click="delete({{ $item->id }})" class="text-red-600 hover:underline ml-2">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

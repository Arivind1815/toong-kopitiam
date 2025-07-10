<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuItem;

class AdminMenuController extends Controller
{
    public function index(Request $request)
    {
        $query = MenuItem::query();

        // 🔍 Search by name
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 🧩 Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        // ✅ Filter by availability
        if ($request->has('available') && $request->available != '') {
            $query->where('available', $request->available);
        }

        // ↕️ Sort results
        if ($request->has('sort') && $request->sort != '') {
        switch ($request->sort) {
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'price_low_high':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high_low':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
        }
    } else {
        // Default sort
        $query->orderBy('created_at', 'desc');
    }

        $menuItems = $query->paginate(10);

        return view('admin.menu', compact('menuItems'));
    }

    public function create()
    {
        return view('admin.menu-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'available' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        MenuItem::create([
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'description' => $request->description,
            'available' => $request->has('available') ? $request->available : true,
            'image' => $request->file('image') ? $request->file('image')->store('menu_images', 'public') : null,
        ]);

        return redirect()->route('admin.menu')->with('success', 'Menu item added successfully.');
    }

    public function toggleAvailability($id)
{
    $item = MenuItem::findOrFail($id);
    $item->available = !$item->available;
    $item->save();

    return response()->json([
        'success' => true,
        'available' => $item->available
    ]);
}

    public function edit($id)
    {
        $item = MenuItem::findOrFail($id);
        return view('admin.menu-edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'available' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $item = MenuItem::findOrFail($id);
        $item->name = $request->name;
        $item->category = $request->category;
        $item->price = $request->price;
        $item->description = $request->description;
        $item->available = $request->has('available') ? $request->available : true;

        if ($request->hasFile('image')) {
            $item->image = $request->file('image')->store('menu_images', 'public');
        }

        $item->save();

        return redirect()->route('admin.menu')->with('success', 'Menu item updated successfully.');
    }

    public function destroy($id)
    {
        $item = MenuItem::findOrFail($id);
        $item->delete();

        return redirect()->route('admin.menu')->with('success', 'Menu item deleted successfully.');
    }

    // 🧩 Placeholder for Drag-and-Drop ordering
    public function reorder(Request $request)
    {
        foreach ($request->order as $index => $id) {
            MenuItem::where('id', $id)->update(['display_order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}


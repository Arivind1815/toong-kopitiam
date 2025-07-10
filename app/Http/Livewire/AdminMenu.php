<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\MenuItem;

class AdminMenu extends Component
{
    use WithFileUploads;

    public $menuItems;
    public $name, $price, $category, $description;
    public $image; // For new uploads
    public $editId = null;

    protected $rules = [
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'category' => 'required|in:food,beverage,sides',
        'description' => 'nullable|string|max:1000',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ];

    public function mount()
    {
        $this->loadItems();
    }

    public function loadItems()
    {
        $this->menuItems = MenuItem::orderBy('category')->get();
    }

    public function save()
    {
        $this->validate();

        $imagePath = null;

        if ($this->image) {
            $imagePath = $this->image->store('menu_images', 'public');
        }

        if ($this->editId) {
            $item = MenuItem::find($this->editId);
            $item->update([
                'name' => $this->name,
                'price' => $this->price,
                'category' => $this->category,
                'description' => $this->description,
                'image' => $imagePath ?? $item->image, // use old image if not changed
            ]);
        } else {
            MenuItem::create([
                'name' => $this->name,
                'price' => $this->price,
                'category' => $this->category,
                'description' => $this->description,
                'image' => $imagePath,
            ]);
        }

        $this->resetForm();
        $this->loadItems();
    }

    public function edit($id)
    {
        $item = MenuItem::findOrFail($id);
        $this->editId = $item->id;
        $this->name = $item->name;
        $this->price = $item->price;
        $this->category = $item->category;
        $this->description = $item->description;
    }

    public function delete($id)
    {
        MenuItem::findOrFail($id)->delete();
        $this->loadItems();
    }

    public function resetForm()
    {
        $this->editId = null;
        $this->name = '';
        $this->price = '';
        $this->category = '';
        $this->description = '';
        $this->image = null;
    }

    public function render()
    {
        return view('livewire.admin-menu');
    }
}


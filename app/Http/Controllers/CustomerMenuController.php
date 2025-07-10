<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Session;

class CustomerMenuController extends Controller
{
    public function index()
{
    $popularItems = [
        'food' => MenuItem::where('category', 'food')
                          ->where('available', true)
                          ->withCount('orderItems')
                          ->orderByDesc('order_items_count')
                          ->take(4)->get(),

        'beverage' => MenuItem::where('category', 'beverage')
                              ->where('available', true)
                              ->withCount('orderItems')
                              ->orderByDesc('order_items_count')
                              ->take(4)->get(),

        'sides' => MenuItem::where('category', 'sides')
                           ->where('available', true)
                           ->withCount('orderItems')
                           ->orderByDesc('order_items_count')
                           ->take(4)->get(),
    ];

    return view('customer.index', compact('popularItems'));
}

    // Display menu items grouped by category
    public function menu()
    {
        $menuItems = MenuItem::where('available', true)->get()->groupBy('category');
        return view('customer.menu', compact('menuItems'));
    }

    // Add item to cart (session-based)
    public function addToCart(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:menu_items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $item = MenuItem::findOrFail($request->id);
        $cart = Session::get('cart', []);

        if (isset($cart[$item->id])) {
            $cart[(string)$item->id]['quantity'] += $request->quantity;
        } else {
            $cart[$item->id] = [
                'id' => $item->id,
                'name' => $item->name,
                'price' => $item->price,
                'image' => $item->image,
                'quantity' => $request->quantity,
            ];
        }

        Session::put('cart', $cart);

        return redirect()->back()->with('success', "{$item->name} added to cart!");
    }

    // Show cart contents
    public function viewCart()
    {
        $cart = Session::get('cart', []);
        return view('customer.cart', compact('cart'));
    }

    // Update cart item quantity
    public function updateCart(Request $request)
{
    $cart = Session::get('cart', []);

    if ($request->has('remove')) {
        $id = (string) $request->remove;
        unset($cart[$id]);
        Session::put('cart', $cart);
        return redirect()->back()->with('success', 'Item removed from cart.');
    }

    if ($request->has('quantities')) {
        foreach ($request->quantities as $id => $qty) {
            $id = (string) $id;
            if (isset($cart[$id]) && $qty > 0) {
                $cart[$id]['quantity'] = (int) $qty;
            }
        }
        Session::put('cart', $cart);
        return redirect()->back()->with('success', 'Cart updated.');
    }

    return redirect()->back();
}
    // Remove item from cart

public function removeFromCart(Request $request)
{
    $id = (string) $request->id;

    if (isset($cart[$request->id])) {
        unset($cart[$request->id]);
        Session::put('cart', $cart);
    }

    return redirect()->route('customer.cart')->with('success', 'Item removed from cart.');
}

    // Clear the cart
public function clearCart()
{
    Session::forget('cart');
    return redirect()->back()->with('success', 'Cart cleared.');
}

    // Handle checkout and create order
    public function checkout(Request $request)
    {
        $cart = Session::get('cart');

        if (empty($cart) || count($cart) === 0) {
            return redirect()->route('customer.menu')->with('error', 'Your cart is empty.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'special_instructions' => 'nullable|string|max:1000',
        ]);

        $totalAmount = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        $order = Order::create([
            'customer_name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'special_instructions' => $request->special_instructions,
            'status' => 'pending',
            'total_amount' => $totalAmount,
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_item_id' => $item['id'],
                'quantity' => $item['quantity'],
            ]);
        }

        Session::forget('cart');

        return redirect()->route('customer.menu')->with('success', 'Order placed successfully!');
    }
}


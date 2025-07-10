<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\MenuItem;
use Illuminate\Support\Facades\DB;

class CustomerOrderController extends Controller
{
    public function showCheckoutForm()
{
    $cart = session()->get('cart', []);

    if (empty($cart)) {
        return redirect()->route('customer.menu')->with('error', 'Your cart is empty.');
    }

    return view('customer.checkout', ['cartItems' => $cart]);
}

    public function store(Request $request)
{
    $request->validate([
        'customer_name' => 'required|string|max:255',
        'email' => 'nullable|email|max:255',
        'phone' => 'required|string|max:20',
        'special_instructions' => 'nullable|string|max:1000',
    ]);

    $cart = session()->get('cart', []);

    if (empty($cart)) {
        return redirect()->back()->with('error', 'Your cart is empty.');
    }

    DB::beginTransaction();

    try {
        // ✅ Recalculate total using current DB prices
        $total = 0;

        foreach ($cart as $item) {
            $menuItem = MenuItem::find($item['id']);
            if ($menuItem) {
                $total += $menuItem->price * $item['quantity'];
            }
        }

        // ✅ Create order with recalculated total
        $order = Order::create([
            'customer_name' => $request->customer_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => 'pending',
            'special_instructions' => $request->special_instructions,
            'total_amount' => $total,
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_item_id' => $item['id'],
                'quantity' => $item['quantity'],
            ]);
        }

        DB::commit();
        session()->forget('cart');
        
        session()->put('last_order_id', $order->id);

        return redirect()->route('customer.thank-you', ['order' => $order->id])
                         ->with('success', 'Order placed successfully!');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Failed to place order: ' . $e->getMessage());
    }
}
    public function history()
    {
        // For demo: store the last order in session or DB (if no user login system)
        $lastOrderId = session('last_order_id');
        
        if (!$lastOrderId) {
            return view('customer.history', ['order' => null]);
        }

        $order = Order::with('items.menuItem')->find($lastOrderId);

        return view('customer.history', compact('order'));
}

}

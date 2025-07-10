<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::query();

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', strtolower($request->status)); // Ensure lowercase match
        }

        // Search by name, email, or date
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhereDate('created_at', $search);
            });
        }

        // Sort options
        switch ($request->input('sort')) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'amount_desc':
                $query->orderBy('total_amount', 'desc');
                break;
            case 'amount_asc':
                $query->orderBy('total_amount', 'asc');
                break;
            default: // latest
                $query->orderBy('created_at', 'desc');
        }

        $orders = $query->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('items.menuItem')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed'
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Order status updated.');
    }

            public function destroy(Order $order)
        {
            $order->delete();
            return redirect()->route('admin.orders')->with('success', 'Order deleted successfully.');
        }
}

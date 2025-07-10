<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Count totals
        $totalItems = MenuItem::count();
        $foodCount = MenuItem::where('category', 'food')->count();
        $beverageCount = MenuItem::where('category', 'beverage')->count();
        $sidesCount = MenuItem::where('category', 'sides')->count();

        // Recent items (limit to latest 5)
        $recentItems = MenuItem::latest()->take(5)->get();

        // Order Stats
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $completedOrders = Order::where('status', 'completed')->count();

        // Sales Summary: Last 7 Days
        $sales = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(total_amount) as total')
        )
        ->where('status', 'completed')
        ->groupBy('date')
        ->orderBy('date', 'desc')
        ->limit(7)
        ->get()
        ->reverse();

        $salesDates = $sales->pluck('date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d M'))->toArray();
        $salesAmounts = $sales->pluck('total')->toArray();

        // Most Popular Items
        $popularItems = OrderItem::select('menu_item_id')
            ->selectRaw('COUNT(*) as total_sold')
            ->groupBy('menu_item_id')
            ->orderByDesc('total_sold')
            ->with('menuItem')
            ->take(5)
            ->get()
            ->map(function ($item) {
                return (object)[
                    'name' => $item->menuItem->name ?? 'Unknown',
                    'total_sold' => $item->total_sold,
                ];
            });

        return view('admin.dashboard', compact(
            'totalItems', 'foodCount', 'beverageCount', 'sidesCount',
            'recentItems', 'totalOrders', 'pendingOrders', 'completedOrders',
            'popularItems', 'salesDates', 'salesAmounts' 
        ));
    }
}

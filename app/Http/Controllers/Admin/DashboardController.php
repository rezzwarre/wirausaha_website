<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRevenue = Order::where('status', 'confirmed')->sum('total_price');
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $pendingPaymentsCount = Payment::where('status', 'pending')->count();
        $lowStockProducts = Product::where('stock', '<=', 5)->count();
        $totalCustomers = User::where('role', 'customer')->count();

        $recentOrders = Order::with(['user', 'payment'])->latest()->take(5)->get();
        $recentPayments = Payment::with(['order.user', 'bankAccount'])->latest()->take(5)->get();
        $recentStockMovements = StockMovement::with(['product', 'creator'])->latest()->take(6)->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalOrders',
            'totalProducts',
            'pendingPaymentsCount',
            'lowStockProducts',
            'totalCustomers',
            'recentOrders',
            'recentPayments',
            'recentStockMovements'
        ));
    }
}

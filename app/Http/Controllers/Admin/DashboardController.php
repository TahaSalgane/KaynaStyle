<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalOrders = Order::count();
        $totalUsers = User::count();

        // Recent orders
        $recentOrders = Order::with('items')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Monthly sales data for chart
        $monthlySales = Order::selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Product statistics
        $activeProducts = Product::where('is_active', true)->count();
        $featuredProducts = Product::where('is_featured', true)->count();

        // Order statistics
        $pendingOrders = Order::where('status', 'pending')->count();
        $completedOrders = Order::where('status', 'completed')->count();

        // Total revenue calculation
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');

        // Top selling products
        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select('products.id', 'products.name_en', 'products.price', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->groupBy('products.id', 'products.name_en', 'products.price')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return (object) [
                    'product' => (object) [
                        'name' => $item->name_en,
                        'price' => $item->price
                    ],
                    'total_sold' => $item->total_sold
                ];
            });

        // Monthly revenue data for chart
        $monthlyRevenue = Order::selectRaw('MONTH(created_at) as month, SUM(total_amount) as revenue')
            ->whereYear('created_at', date('Y'))
            ->where('status', 'completed')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // If no revenue data, create empty data for chart
        if ($monthlyRevenue->isEmpty()) {
            $monthlyRevenue = collect([
                (object) ['month' => 1, 'revenue' => 0],
                (object) ['month' => 2, 'revenue' => 0],
                (object) ['month' => 3, 'revenue' => 0],
                (object) ['month' => 4, 'revenue' => 0],
                (object) ['month' => 5, 'revenue' => 0],
                (object) ['month' => 6, 'revenue' => 0],
                (object) ['month' => 7, 'revenue' => 0],
                (object) ['month' => 8, 'revenue' => 0],
                (object) ['month' => 9, 'revenue' => 0],
                (object) ['month' => 10, 'revenue' => 0],
                (object) ['month' => 11, 'revenue' => 0],
                (object) ['month' => 12, 'revenue' => 0],
            ]);
        }

        // Orders by status for chart
        $ordersByStatus = Order::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        // If no orders, create default data
        if ($ordersByStatus->isEmpty()) {
            $ordersByStatus = collect([
                (object) ['status' => 'pending', 'count' => 0],
                (object) ['status' => 'completed', 'count' => 0],
                (object) ['status' => 'cancelled', 'count' => 0],
            ]);
        }

        return view('admin.dashboard.index', compact(
            'totalProducts',
            'totalCategories',
            'totalOrders',
            'totalUsers',
            'recentOrders',
            'monthlySales',
            'activeProducts',
            'featuredProducts',
            'pendingOrders',
            'completedOrders',
            'totalRevenue',
            'topProducts',
            'monthlyRevenue',
            'ordersByStatus'
        ));
    }
}

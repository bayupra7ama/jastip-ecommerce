<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalProducts'   => Product::count(),
            'totalCategories' => Category::count(),
            'totalOrders'     => Order::count(),
        ]);
    }
}

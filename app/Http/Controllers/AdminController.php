<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserOrder;
use App\Models\Product;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        // Ensure only admins can access
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Access denied. Admin privileges required.');
        }

        $userRole = auth()->user()->role;
        
        // You can add more admin-specific data here
        $adminData = [
            'totalUsers' => User::count(),
            'adminUsers' => User::where('role', 'admin')->count(),
            'regularUsers' => User::where('role', 'user')->count(),
            'recentUsers' => User::latest()->take(5)->get(),
        ];

        $users = User::all();
        $products = Product::all();
        $orders = UserOrder::all();

        return view('admin-dashboard.home', compact('userRole', 'adminData', 'users', 'products', 'orders'));
    }

    public function users()
    {
        // Ensure only admins can access
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Access denied. Admin privileges required.');
        }

        $users = User::all();
        $products = Product::all();
        $orders = UserOrder::all();
        return view('admin-dashboard.users', compact('users', 'products', 'orders'));
    }

    public function products()
    {
        // Ensure only admins can access
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Access denied. Admin privileges required.');
        }

        $users = User::all();
        $products = Product::all();
        $orders = UserOrder::all();
        return view('admin-dashboard.products', compact('products', 'users', 'orders'));
    }

    public function orders()
    {
        // Ensure only admins can access
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Access denied. Admin privileges required.');
        }

        $users = User::all();
        $products = Product::all();
        $orders = UserOrder::all();
        return view('admin-dashboard.orders', compact('orders', 'users', 'products'));
    }

    public function login()
    {
        return view('auth.login');
    }
}

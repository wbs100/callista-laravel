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

        $users = User::orderBy('created_at', 'desc')->paginate(10);
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
        $products = Product::orderBy('created_at', 'desc')->paginate(12);
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
        $orders = UserOrder::with('user')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin-dashboard.orders', compact('orders', 'users', 'products'));
    }

    public function login()
    {
        return view('auth.login');
    }

    // Product CRUD Methods
    
    public function storeProduct(Request $request)
    {
        // Ensure only admins can access
        if (auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Access denied'], 403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'new_price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'type' => 'required|string|max:100',
            'color' => 'required|string|max:50',
            'vendor' => 'required|string|max:100',
            'weight' => 'required|string|max:50',
            'size' => 'required|string|max:100',
            'stock_status' => 'required|in:in_stock,low_stock,out_of_stock',
            'rating' => 'nullable|numeric|min:0|max:5',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Generate unique barcode
        $barcode = 'CAL-' . strtoupper(substr($request->type, 0, 3)) . '-' . str_pad(Product::count() + 1, 3, '0', STR_PAD_LEFT);

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'new_price' => $request->new_price,
            'old_price' => $request->old_price,
            'type' => $request->type,
            'color' => $request->color,
            'vendor' => $request->vendor,
            'weight' => $request->weight,
            'size' => $request->size,
            'stock_status' => $request->stock_status,
            'rating' => $request->rating ?? 0,
            'barcode' => $barcode,
            'tags' => ['furniture', 'quality'],
        ]);

        // Handle image upload
        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            $imageName = time() . '_' . $product->id . '.' . $image->getClientOriginalExtension();
            
            // Create directory if it doesn't exist
            $uploadPath = public_path('uploads/products/images');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            // Move file to public directory
            $image->move($uploadPath, $imageName);
            $imagePath = 'uploads/products/images/' . $imageName;
            
            // Create product image record
            \App\Models\ProductImage::create([
                'product_id' => $product->id,
                'image' => $imagePath,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully!',
            'product' => $product
        ]);
    }

    public function editProduct(Product $product)
    {
        // Ensure only admins can access
        if (auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Access denied'], 403);
        }

        // Load product with images
        $product->load('images');

        return response()->json([
            'success' => true,
            'product' => $product
        ]);
    }

    public function updateProduct(Request $request, Product $product)
    {
        // Ensure only admins can access
        if (auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Access denied'], 403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'new_price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'type' => 'required|string|max:100',
            'color' => 'required|string|max:50',
            'vendor' => 'required|string|max:100',
            'weight' => 'required|string|max:50',
            'size' => 'required|string|max:100',
            'stock_status' => 'required|in:in_stock,low_stock,out_of_stock',
            'rating' => 'nullable|numeric|min:0|max:5',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'new_price' => $request->new_price,
            'old_price' => $request->old_price,
            'type' => $request->type,
            'color' => $request->color,
            'vendor' => $request->vendor,
            'weight' => $request->weight,
            'size' => $request->size,
            'stock_status' => $request->stock_status,
            'rating' => $request->rating ?? $product->rating,
        ]);

        // Handle image upload
        if ($request->hasFile('product_image')) {
            // Delete old image if exists
            $oldImage = $product->images()->first();
            if ($oldImage) {
                $oldImagePath = public_path($oldImage->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
                $oldImage->delete();
            }

            // Upload new image
            $image = $request->file('product_image');
            $imageName = time() . '_' . $product->id . '.' . $image->getClientOriginalExtension();
            
            // Create directory if it doesn't exist
            $uploadPath = public_path('uploads/products/images');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            // Move file to public directory
            $image->move($uploadPath, $imageName);
            $imagePath = 'uploads/products/images/' . $imageName;
            
            // Create new product image record
            \App\Models\ProductImage::create([
                'product_id' => $product->id,
                'image' => $imagePath,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully!',
            'product' => $product
        ]);
    }

    public function destroyProduct(Product $product)
    {
        // Ensure only admins can access
        if (auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Access denied'], 403);
        }

        // Delete product images from filesystem
        foreach ($product->images as $image) {
            $imagePath = public_path($image->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Delete product (cascade will delete images from database)
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully!'
        ]);
    }
}

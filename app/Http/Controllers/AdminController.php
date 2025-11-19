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

    public function products(Request $request)
    {
        // Ensure only admins can access
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Access denied. Admin privileges required.');
        }

        $users = User::all();
        $orders = UserOrder::all();
        
        // Build query with filters
        $query = Product::query();
        
        // Search filter
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        // Category filter
        if ($request->filled('category')) {
            $query->where('type', $request->category);
        }
        
        // Price range filter
        if ($request->filled('price_range')) {
            switch ($request->price_range) {
                case '0-5000':
                    $query->where('new_price', '<=', 5000);
                    break;
                case '5000-15000':
                    $query->whereBetween('new_price', [5000, 15000]);
                    break;
                case '15000-30000':
                    $query->whereBetween('new_price', [15000, 30000]);
                    break;
                case '30000-50000':
                    $query->whereBetween('new_price', [30000, 50000]);
                    break;
                case '50000+':
                    $query->where('new_price', '>', 50000);
                    break;
            }
        }
        
        // Stock status filter
        if ($request->filled('stock_status')) {
            $query->where('stock_status', $request->stock_status);
        }
        
        $products = $query->orderBy('created_at', 'desc')->paginate(12)->withQueryString();
        
        return view('admin-dashboard.products', compact('products', 'users', 'orders'));
    }

    public function orders(Request $request)
    {
        // Ensure only admins can access
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Access denied. Admin privileges required.');
        }

        $users = User::all();
        $products = Product::all();
        
        // Build query with filters
        $query = UserOrder::with('user');
        
        // Order ID filter
        if ($request->filled('order_id')) {
            $query->where('id', 'like', '%' . $request->order_id . '%');
        }
        
        // Customer filter (search in user name or email)
        if ($request->filled('customer')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->customer . '%')
                  ->orWhere('email', 'like', '%' . $request->customer . '%');
            });
        }
        
        // Status filter
        if ($request->filled('status')) {
            $status = $request->status;
            $query->where(function($q) use ($status) {
                // Handle boolean values (0/1)
                if ($status === '0') {
                    $q->where('status', 0)->orWhere('status', false)->orWhere('status', 'pending');
                } elseif ($status === '1') {
                    $q->where('status', 1)->orWhere('status', true)->orWhere('status', 'completed');
                } else {
                    // Handle string statuses
                    $q->where('status', $status);
                }
            });
        }
        
        // Date range filter
        if ($request->filled('date_range')) {
            $dateRange = $request->date_range;
            $now = now();
            
            switch ($dateRange) {
                case 'today':
                    $query->whereDate('created_at', $now->toDateString());
                    break;
                case 'week':
                    $query->whereBetween('created_at', [$now->startOfWeek(), $now->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('created_at', $now->month)
                          ->whereYear('created_at', $now->year);
                    break;
                case 'custom':
                    if ($request->filled('date_from')) {
                        $query->whereDate('created_at', '>=', $request->date_from);
                    }
                    if ($request->filled('date_to')) {
                        $query->whereDate('created_at', '<=', $request->date_to);
                    }
                    break;
            }
        }
        
        $orders = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Preserve query parameters in pagination links
        $orders->appends($request->query());
        
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

    // Order management methods
    public function orderDetails(UserOrder $order)
    {
        // Ensure only admins can access
        if (auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Access denied'], 403);
        }

        try {
            // Load order with user relationship
            $order->load(['user']);
            
            // Ensure JSON fields are properly formatted
            if (is_string($order->cart_data)) {
                $order->cart_data = json_decode($order->cart_data, true);
            }
            
            if (is_string($order->billing_data)) {
                $order->billing_data = json_decode($order->billing_data, true);
            }
            
            if (is_string($order->payment_data)) {
                $order->payment_data = json_decode($order->payment_data, true);
            }

            return response()->json([
                'success' => true,
                'order' => $order
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading order details: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateOrderStatus(Request $request, UserOrder $order)
    {
        // Ensure only admins can access
        if (auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Access denied'], 403);
        }

        try {
            $request->validate([
                'status' => 'required|in:0,1,processing,shipped,delivered,cancelled,payment_pending,payment_failed,refunded',
                'payment_mode' => 'nullable|in:card_payment,bank_transfer,cash_on_delivery',
                'order_notes' => 'nullable|string|max:1000',
                'contact_info' => 'nullable|string|max:255'
            ]);

            // Update order
            $updateData = [
                'status' => $request->status,
                'updated_at' => now()
            ];

            if ($request->has('payment_mode') && $request->payment_mode) {
                $updateData['payment_mode'] = $request->payment_mode;
            }

            if ($request->has('order_notes')) {
                $updateData['order_notes'] = $request->order_notes;
            }

            if ($request->has('contact_info')) {
                $updateData['contact_info'] = $request->contact_info;
            }

            $order->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Order updated successfully!',
                'order' => $order->fresh()
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error: ' . implode(', ', $e->errors())
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating order: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroyOrder(UserOrder $order)
    {
        // Ensure only admins can access
        if (auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Access denied'], 403);
        }

        try {
            // Prevent deletion of completed orders
            if ($order->status === 1 || $order->status === true) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete completed orders'
                ], 400);
            }

            $order->delete();

            return response()->json([
                'success' => true,
                'message' => 'Order deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting order: ' . $e->getMessage()
            ], 500);
        }
    }
}

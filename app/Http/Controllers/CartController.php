<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\UserCart;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    /**
     * Add product to cart
     */
    public function add(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:product,id',
                'quantity' => 'nullable|integer|min:1',
            ]);

            $product = Product::with('images')->findOrFail($request->product_id);
            $quantity = $request->quantity ?? 1;

            // Check stock availability
            if ($product->stock_status === 'out_of_stock') {
                return response()->json([
                    'success' => false,
                    'message' => 'Product is out of stock'
                ], 400);
            }

            if (Auth::check()) {
                // For logged-in users, store in database
                $userId = Auth::id();
                
                // Check if item already exists in user's cart
                $existingCartItem = UserCart::where('user_id', $userId)
                    ->where('item_id', $product->id)
                    ->first();

                if ($existingCartItem) {
                    // Update quantity if item exists
                    $existingCartItem->quantity += $quantity;
                    $existingCartItem->save();
                } else {
                    // Create new cart item
                    UserCart::create([
                        'user_id' => $userId,
                        'item_id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->new_price,
                        'quantity' => $quantity,
                        'attributes' => json_encode([
                            'image' => $product->images->first()->image ?? 'default.jpg',
                            'vendor' => $product->vendor ?? '',
                            'stock_status' => $product->stock_status,
                            'barcode' => $product->barcode ?? '',
                            'color' => $product->color ?? '',
                            'type' => $product->type ?? '',
                            'old_price' => $product->old_price,
                            'discount' => $product->old_price ? round((($product->old_price - $product->new_price) / $product->old_price) * 100) : 0
                        ])
                    ]);
                }

                $cartCount = UserCart::where('user_id', $userId)->sum('quantity');
                $cartTotal = UserCart::where('user_id', $userId)->sum(DB::raw('price * quantity'));

            } else {
                // For guest users, use session cart
                $cartItem = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'quantity' => $quantity,
                    'price' => $product->new_price,
                    'weight' => 0,
                    'options' => [
                        'image' => $product->images->first()->image ?? 'default.jpg',
                        'vendor' => $product->vendor ?? '',
                        'stock_status' => $product->stock_status,
                        'barcode' => $product->barcode ?? '',
                        'color' => $product->color ?? '',
                        'type' => $product->type ?? '',
                        'old_price' => $product->old_price,
                        'discount' => $product->old_price ? round((($product->old_price - $product->new_price) / $product->old_price) * 100) : 0
                    ],
                ];

                Cart::add($cartItem);
                $cartCount = Cart::getTotalQuantity();
                $cartTotal = Cart::getTotal();
            }

            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully',
                'cart_count' => $cartCount,
                'cart_total' => $cartTotal
            ]);

        } catch (\Exception $e) {
            Log::error('Cart add error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required',
                'quantity' => 'required|integer|min:0',
            ]);

            if (Auth::check()) {
                // For logged-in users, update database
                $userId = Auth::id();
                
                if ($request->quantity == 0) {
                    UserCart::where('user_id', $userId)
                        ->where('item_id', $request->product_id)
                        ->delete();
                } else {
                    UserCart::where('user_id', $userId)
                        ->where('item_id', $request->product_id)
                        ->update(['quantity' => $request->quantity]);
                }

                $cartCount = UserCart::where('user_id', $userId)->sum('quantity');
                $cartTotal = UserCart::where('user_id', $userId)->sum(DB::raw('price * quantity'));

            } else {
                // For guest users, use session cart
                if ($request->quantity == 0) {
                    Cart::remove($request->product_id);
                } else {
                    Cart::update($request->product_id, [
                        'quantity' => [
                            'relative' => false,
                            'value' => $request->quantity
                        ],
                    ]);
                }

                $cartCount = Cart::getTotalQuantity();
                $cartTotal = Cart::getTotal();
            }

            return response()->json([
                'success' => true,
                'message' => 'Cart updated successfully',
                'cart_count' => $cartCount,
                'cart_total' => $cartTotal
            ]);

        } catch (\Exception $e) {
            Log::error('Cart update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove item from cart
     */
    public function remove(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required',
            ]);

            if (Auth::check()) {
                // For logged-in users, remove from database
                $userId = Auth::id();
                UserCart::where('user_id', $userId)
                    ->where('item_id', $request->product_id)
                    ->delete();

                $cartCount = UserCart::where('user_id', $userId)->sum('quantity');
                $cartTotal = UserCart::where('user_id', $userId)->sum(DB::raw('price * quantity'));

            } else {
                // For guest users, remove from session cart
                Cart::remove($request->product_id);
                $cartCount = Cart::getTotalQuantity();
                $cartTotal = Cart::getTotal();
            }

            return response()->json([
                'success' => true,
                'message' => 'Product removed from cart',
                'cart_count' => $cartCount,
                'cart_total' => $cartTotal
            ]);

        } catch (\Exception $e) {
            Log::error('Cart remove error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Clear entire cart
     */
    public function clear(Request $request)
    {
        try {
            if (Auth::check()) {
                // For logged-in users, clear database cart
                $userId = Auth::id();
                UserCart::where('user_id', $userId)->delete();
            } else {
                // For guest users, clear session cart
                Cart::clear();
            }

            return response()->json([
                'success' => true,
                'message' => 'Cart cleared successfully',
                'cart_count' => 0,
                'cart_total' => 0
            ]);

        } catch (\Exception $e) {
            Log::error('Cart clear error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get cart item count
     */
    public function getCount()
    {
        if (Auth::check()) {
            $count = UserCart::where('user_id', Auth::id())->sum('quantity');
        } else {
            $count = Cart::getTotalQuantity();
        }

        return response()->json([
            'success' => true,
            'count' => $count
        ]);
    }

    /**
     * Get cart total
     */
    public function getTotal()
    {
        if (Auth::check()) {
            $userId = Auth::id();
            $total = UserCart::where('user_id', $userId)->sum(DB::raw('price * quantity'));
            $items = UserCart::where('user_id', $userId)->get();
        } else {
            $total = Cart::getTotal();
            $items = Cart::getContent();
        }

        return response()->json([
            'success' => true,
            'total' => $total,
            'formatted_total' => 'Rs. ' . number_format($total),
            'items' => $items
        ]);
    }

    /**
     * Display cart page
     */
    public function index()
    {
        if (Auth::check()) {
            // For logged-in users, get cart from database
            $userId = Auth::id();
            $cartItems = UserCart::where('user_id', $userId)->get();
            $cartTotal = $cartItems->sum(function ($item) {
                return $item->price * $item->quantity;
            });
            $cartCount = $cartItems->sum('quantity');
        } else {
            // For guest users, get cart from session
            $cartItems = Cart::getContent();
            $cartTotal = Cart::getTotal();
            $cartCount = Cart::getTotalQuantity();
        }
        
        // Fetch full product details for each cart item
        $cartItemsWithDetails = collect();
        $totalDiscount = 0;
        
        foreach ($cartItems as $item) {
            if (Auth::check()) {
                $productId = $item->item_id;
                $itemName = $item->name;
                $itemPrice = $item->price;
                $itemQuantity = $item->quantity;
            } else {
                $productId = $item->id;
                $itemName = $item->name;
                $itemPrice = $item->price;
                $itemQuantity = $item->quantity;
            }

            $product = Product::with('images')->find($productId);
            if ($product) {
                // Calculate discount for this item
                $itemDiscount = 0;
                if ($product->old_price && $product->old_price > $product->new_price) {
                    $itemDiscount = $itemQuantity * ($product->old_price - $product->new_price);
                    $totalDiscount += $itemDiscount;
                }
                
                // Add product details to cart item
                $itemWithDetails = (object) [
                    'id' => $productId,
                    'name' => $itemName,
                    'price' => $itemPrice,
                    'quantity' => $itemQuantity,
                    'product' => $product,
                    'item_discount' => $itemDiscount
                ];
                
                $cartItemsWithDetails->push($itemWithDetails);
            }
        }
        
        $subtotal = $cartItemsWithDetails->sum(function ($item) {
            return $item->quantity * $item->price;
        });

        $deliveryFee = $subtotal > 50000 ? 0 : 1500; // Free delivery over Rs. 50,000
        $finalTotal = $subtotal - $totalDiscount + $deliveryFee;

        $recommendedProducts = Product::with('images')
            ->where('stock_status', '!=', 'out_of_stock')
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('public-site.cart', compact(
            'cartItemsWithDetails', 
            'cartTotal', 
            'cartCount', 
            'subtotal', 
            'totalDiscount', 
            'deliveryFee', 
            'finalTotal',
            'recommendedProducts'
        ));
    }

    /**
     * Get cart table partial for AJAX updates
     */
    public function getTable()
    {
        $cartItems = Cart::getContent();
        
        // Fetch full product details for each cart item
        $cartItemsWithDetails = collect();
        foreach ($cartItems as $item) {
            $product = Product::with('images')->find($item->id);
            if ($product) {
                $itemWithDetails = (object) [
                    'id' => $item->id,
                    'name' => $item->name,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'product' => $product
                ];
                $cartItemsWithDetails->push($itemWithDetails);
            }
        }
        
        return response()->json([
            'success' => true,
            'html' => '', // Will be implemented when partial views are created
            'items' => $cartItemsWithDetails
        ]);
    }

    /**
     * Get cart list/sidebar for AJAX updates
     */
    public function getList()
    {
        $cartItems = Cart::getContent();
        $cartTotal = Cart::getTotal();
        
        // Fetch full product details for each cart item
        $cartItemsWithDetails = collect();
        foreach ($cartItems as $item) {
            $product = Product::with('images')->find($item->id);
            if ($product) {
                $itemWithDetails = (object) [
                    'id' => $item->id,
                    'name' => $item->name,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'product' => $product
                ];
                $cartItemsWithDetails->push($itemWithDetails);
            }
        }
        
        return response()->json([
            'success' => true,
            'html' => '', // Will be implemented when partial views are created
            'items' => $cartItemsWithDetails,
            'total' => $cartTotal
        ]);
    }

    /**
     * Migrate session cart to database when user logs in
     */
    public function migrateSessionToDatabase($userId)
    {
        try {
            $sessionCart = Cart::getContent();
            
            foreach ($sessionCart as $item) {
                // Check if item already exists in user's database cart
                $existingItem = UserCart::where('user_id', $userId)
                    ->where('item_id', $item->id)
                    ->first();

                if ($existingItem) {
                    // Update quantity if item exists
                    $existingItem->quantity += $item->quantity;
                    $existingItem->save();
                } else {
                    // Create new cart item
                    UserCart::create([
                        'user_id' => $userId,
                        'item_id' => $item->id,
                        'name' => $item->name,
                        'price' => $item->price,
                        'quantity' => $item->quantity,
                        'attributes' => json_encode($item->attributes)
                    ]);
                }
            }

            // Clear session cart after migration
            Cart::clear();

            return true;
        } catch (\Exception $e) {
            Log::error('Cart migration error: ' . $e->getMessage());
            return false;
        }
    }
}

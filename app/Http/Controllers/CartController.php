<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Darryldecode\Cart\Facades\CartFacade as Cart;
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

            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully',
                'cart_count' => Cart::getTotalQuantity(),
                'cart_total' => Cart::getTotal()
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

            return response()->json([
                'success' => true,
                'message' => 'Cart updated successfully',
                'cart_count' => Cart::getTotalQuantity(),
                'cart_total' => Cart::getTotal()
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

            Cart::remove($request->product_id);

            return response()->json([
                'success' => true,
                'message' => 'Product removed from cart',
                'cart_count' => Cart::getTotalQuantity(),
                'cart_total' => Cart::getTotal()
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
            Cart::clear();

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
        return response()->json([
            'success' => true,
            'count' => Cart::getTotalQuantity()
        ]);
    }

    /**
     * Get cart total
     */
    public function getTotal()
    {
        return response()->json([
            'success' => true,
            'total' => Cart::getTotal(),
            'formatted_total' => 'Rs. ' . number_format(Cart::getTotal()),
            'items' => Cart::getContent()
        ]);
    }

    /**
     * Display cart page
     */
    public function index()
    {
        $cartItems = Cart::getContent();
        $cartTotal = Cart::getTotal();
        $cartCount = Cart::getTotalQuantity();
        
        // Fetch full product details for each cart item
        $cartItemsWithDetails = collect();
        $totalDiscount = 0;
        
        foreach ($cartItems as $item) {
            $product = Product::with('images')->find($item->id);
            if ($product) {
                // Calculate discount for this item
                $itemDiscount = 0;
                if ($product->old_price && $product->old_price > $product->new_price) {
                    $itemDiscount = $item->quantity * ($product->old_price - $product->new_price);
                    $totalDiscount += $itemDiscount;
                }
                
                // Add product details to cart item
                $itemWithDetails = (object) [
                    'id' => $item->id,
                    'name' => $item->name,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'product' => $product,
                    'item_discount' => $itemDiscount
                ];
                
                $cartItemsWithDetails->push($itemWithDetails);
            }
        }
        
        $subtotal = $cartItems->sum(function ($item) {
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
}

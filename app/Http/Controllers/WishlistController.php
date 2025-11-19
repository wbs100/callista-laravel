<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\UserWishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WishlistController extends Controller
{
    /**
     * Add product to wishlist
     */
    public function add(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:product,id',
            ]);

            // For non-authenticated users, use session-based wishlist
            if (!Auth::check()) {
                $wishlist = session()->get('wishlist', []);
                
                if (!in_array($request->product_id, $wishlist)) {
                    $wishlist[] = $request->product_id;
                    session()->put('wishlist', $wishlist);
                    
                    return response()->json([
                        'success' => true,
                        'message' => 'Product added to wishlist',
                        'wishlist_count' => count($wishlist)
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Product already in wishlist'
                    ], 400);
                }
            }

            // For authenticated users, use database
            $userId = Auth::id();
            $productId = $request->product_id;

            $product = Product::with('images')->find($productId);

            // Check if product already in wishlist
            $existingWishlist = UserWishlist::where('user_id', $userId)
                ->where('item_id', $productId)
                ->first();

            if ($existingWishlist) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product already in wishlist'
                ], 400);
            }

            // Add to wishlist
            UserWishlist::create([
                'user_id' => $userId,
                'item_id' => $productId,
                'name' => $product->name,
                'price' => $product->new_price,
                'quantity' => 1,
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

            $wishlistCount = UserWishlist::where('user_id', $userId)->count();

            return response()->json([
                'success' => true,
                'message' => 'Product added to wishlist successfully',
                'wishlist_count' => $wishlistCount
            ]);

        } catch (\Exception $e) {
            Log::error('Wishlist add error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove product from wishlist
     */
    public function remove(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required',
            ]);

            // For non-authenticated users, use session-based wishlist
            if (!Auth::check()) {
                $wishlist = session()->get('wishlist', []);
                
                if (($key = array_search($request->product_id, $wishlist)) !== false) {
                    unset($wishlist[$key]);
                    $wishlist = array_values($wishlist); // Reindex array
                    session()->put('wishlist', $wishlist);
                }
                
                return response()->json([
                    'success' => true,
                    'message' => 'Product removed from wishlist',
                    'wishlist_count' => count($wishlist)
                ]);
            }

            // For authenticated users, use database
            $userId = Auth::id();
            $productId = $request->product_id;

            UserWishlist::where('user_id', $userId)
                ->where('product_id', $productId)
                ->delete();

            $wishlistCount = UserWishlist::where('user_id', $userId)->count();

            return response()->json([
                'success' => true,
                'message' => 'Product removed from wishlist',
                'wishlist_count' => $wishlistCount
            ]);

        } catch (\Exception $e) {
            Log::error('Wishlist remove error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get wishlist item count
     */
    public function getCount()
    {
        try {
            if (!Auth::check()) {
                $wishlist = session()->get('wishlist', []);
                return response()->json([
                    'success' => true,
                    'count' => count($wishlist)
                ]);
            }

            $count = UserWishlist::where('user_id', Auth::id())->count();

            return response()->json([
                'success' => true,
                'count' => $count
            ]);

        } catch (\Exception $e) {
            Log::error('Wishlist count error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'count' => 0
            ], 500);
        }
    }

    /**
     * Get wishlist total (items with details)
     */
    public function getTotal()
    {
        try {
            if (!Auth::check()) {
                $wishlistIds = session()->get('wishlist', []);
                $products = Product::with('images')->whereIn('id', $wishlistIds)->get();
                
                return response()->json([
                    'success' => true,
                    'total' => count($products),
                    'items' => $products
                ]);
            }

            $wishlistItems = UserWishlist::with(['product', 'product.images'])
                ->where('user_id', Auth::id())
                ->get();

            $products = $wishlistItems->map(function ($item) {
                return $item->product;
            });

            return response()->json([
                'success' => true,
                'total' => $wishlistItems->count(),
                'items' => $products
            ]);

        } catch (\Exception $e) {
            Log::error('Wishlist total error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'total' => 0,
                'items' => []
            ], 500);
        }
    }

    /**
     * Migrate session wishlist to database when user logs in
     */
    public function migrateSessionToDatabase($userId)
    {
        try {
            $sessionCart = session()->get('wishlist', []);
            
            foreach ($sessionCart as $item) {
                // Check if item already exists in user's database wishlist
                $existingItem = UserWishlist::where('user_id', $userId)
                    ->where('item_id', $item->id)
                    ->first();

                if ($existingItem) {
                    // Update quantity if item exists
                    $existingItem->quantity += $item->quantity;
                    $existingItem->save();
                } else {
                    // Create new wishlist item
                    UserWishlist::create([
                        'user_id' => $userId,
                        'item_id' => $item->id,
                        'name' => $item->name,
                        'price' => $item->price,
                        'quantity' => $item->quantity,
                        'attributes' => json_encode($item->attributes)
                    ]);
                }
            }

            // Clear session wishlist after migration
            session()->forget('wishlist');

            return true;
        } catch (\Exception $e) {
            Log::error('Wishlist migration error: ' . $e->getMessage());
            return false;
        }
    }
}

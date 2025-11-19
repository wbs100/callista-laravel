<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserOrder;
use App\Models\UserWishlist;
use App\Models\UserBillingData;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $user = Auth::user();
        $userId = $user->id;
        $userRole = $user->role;
        
        // Get user's orders
        $orders = UserOrder::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Calculate statistics
        $totalOrders = $orders->count();
        $totalSpent = $orders->sum(function($order) {
            $cartData = $order->cart_data;
            return isset($cartData['total']) ? $cartData['total'] : 0;
        });
        
        // Get recent orders (last 5)
        $recentOrders = $orders->take(5);
        
        // Calculate this month's orders
        $thisMonthOrders = $orders->filter(function($order) {
            return $order->created_at->isCurrentMonth();
        })->count();
        
        // Calculate last month's total for percentage
        $lastMonthTotal = $orders->filter(function($order) {
            return $order->created_at->format('Y-m') === Carbon::now()->subMonth()->format('Y-m');
        })->sum(function($order) {
            $cartData = $order->cart_data;
            return isset($cartData['total']) ? $cartData['total'] : 0;
        });
        
        // Calculate percentage change
        $spentChange = 0;
        $currentMonthTotal = $orders->filter(function($order) {
            return $order->created_at->isCurrentMonth();
        })->sum(function($order) {
            $cartData = $order->cart_data;
            return isset($cartData['total']) ? $cartData['total'] : 0;
        });
        
        if ($lastMonthTotal > 0) {
            $spentChange = round((($currentMonthTotal - $lastMonthTotal) / $lastMonthTotal) * 100);
        } elseif ($currentMonthTotal > 0) {
            $spentChange = 100; // 100% increase from 0
        }
        
        // Get wishlist count
        $wishlistCount = UserWishlist::where('user_id', $userId)->count();
        
        // Get new wishlist items this month
        $newWishlistItems = UserWishlist::where('user_id', $userId)
            ->where('created_at', '>=', Carbon::now()->startOfMonth())
            ->count();
        
        // Get billing data for account info
        $billingData = UserBillingData::where('user_id', $userId)->first();
        
        // Calculate loyalty points (you can customize this logic)
        $loyaltyPoints = floor($totalSpent / 100); // 1 point per 100 LKR spent
        $pointsEarned = $orders->filter(function($order) {
            return $order->created_at->isCurrentMonth();
        })->sum(function($order) {
            $cartData = $order->cart_data;
            $total = isset($cartData['total']) ? $cartData['total'] : 0;
            return floor($total / 100);
        });
        
        $userData = [
            'user' => $user,
            'totalOrders' => $totalOrders,
            'totalSpent' => $totalSpent,
            'thisMonthOrders' => $thisMonthOrders,
            'spentChange' => $spentChange,
            'wishlistCount' => $wishlistCount,
            'newWishlistItems' => $newWishlistItems,
            'loyaltyPoints' => $loyaltyPoints,
            'pointsEarned' => $pointsEarned,
            'recentOrders' => $recentOrders,
            'billingData' => $billingData,
        ];

        return view('public-site.dashboard', compact('userRole', 'userData'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $userId = $user->id;

        // Validate the request
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $userId,
            'address_1' => 'required|string|max:255',
            'address_2' => 'nullable|string|max:255',
            'town' => 'required|string|max:255',
            'postal_code' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        try {
            // Update user's name and email
            $fullName = $request->first_name . ' ' . $request->last_name;
            $user->name = $fullName;
            
            if ($user->email !== $request->email) {
                $user->email = $request->email;
                $user->email_verified_at = null; // Reset email verification if email changes
            }
            
            $user->save();

            // Update or create billing data
            UserBillingData::updateOrCreate(
                ['user_id' => $userId],
                [
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'company_name' => $request->company_name,
                    'address_1' => $request->address_1,
                    'address_2' => $request->address_2,
                    'town' => $request->town,
                    'postal_code' => $request->postal_code,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'notes' => $request->notes,
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully!',
                'data' => [
                    'user' => $user->fresh(),
                    'billingData' => UserBillingData::where('user_id', $userId)->first()
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating profile: ' . $e->getMessage()
            ], 500);
        }
    }
}

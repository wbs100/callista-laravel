<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use App\Models\UserCart;
use App\Models\UserBillingData;
use App\Models\UserOrder;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display the checkout page
     */
    public function show()
    {
        if (Auth::check()) {
            // For logged-in users, get cart from database
            $userId = Auth::id();
            $cartItems = UserCart::where('user_id', $userId)->get();
            
            if ($cartItems->isEmpty()) {
                return redirect()->route('cart')->with('error', 'Your cart is empty.');
            }
            
            $cartCount = $cartItems->sum('quantity');
            $billingData = UserBillingData::where('user_id', $userId)->first();
        } else {
            // For guest users, get cart from session
            $cartItems = Cart::getContent();
            
            if ($cartItems->isEmpty()) {
                return redirect()->route('cart')->with('error', 'Your cart is empty.');
            }
            
            $cartCount = Cart::getTotalQuantity();
            $billingData = null;
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

        return view('public-site.checkout', compact(
            'cartItemsWithDetails', 
            'cartCount', 
            'subtotal', 
            'totalDiscount', 
            'deliveryFee', 
            'finalTotal',
            'billingData'
        ));
    }

    // Server-to-server notification from PayHere
    public function store(Request $request)
    {
        Log::info('Checkout Request Received', $request->all()); // Debug log

        try {
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'company_name' => 'nullable|string|max:255',
                'address_1' => 'required|string|max:255',
                'address_2' => 'nullable|string|max:255',
                'town' => 'required|string|max:255',
                'postal_code' => 'required|string|max:255',
                'phone' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'notes' => 'nullable|string|max:1000',
                'payment_method' => 'required|in:bank_transfer,card_payment,cash_on_delivery',
            ]);
            
            Log::info('Validation passed successfully'); // Debug log
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed: ', $e->errors());
            return back()->withErrors($e->errors())->withInput();
        }
        
        // Get cart items based on user authentication
        if (Auth::check()) {
            $userId = Auth::id();
            $cartItems = UserCart::where('user_id', $userId)->get();
            
            if ($cartItems->isEmpty()) {
                Log::warning('Checkout attempt with empty cart for user ID: ' . $userId);
                return redirect()->route('cart')->with('error', 'Your cart is empty.');
            }
            Log::info('User ID for checkout: ' . $userId); // Debug log
            Log::info('Cart items count: ' . $cartItems->count()); // Debug log
        } else {
            return redirect()->route('login')->with('error', 'Please login to complete your order.');
        }

        // Calculate total from cart items
        $subtotal = 0;
        $totalDiscount = 0;
        $orderItems = [];
        
        foreach ($cartItems as $item) {
            $product = Product::find($item->item_id);
            if (!$product) {
                Log::error('Product not found: ' . $item->item_id);
                return redirect()->route('cart')->with('error', 'Some products in your cart are no longer available.');
            }
            
            // Check stock availability
            if ($product->stock_status === 'out_of_stock') {
                Log::error('Product out of stock: ' . $product->name);
                return redirect()->route('cart')->with('error', "Product '{$product->name}' is out of stock.");
            }
            
            // Use the current price from cart (which is already the discounted price)
            $itemTotal = $item->price * $item->quantity;
            $subtotal += $itemTotal;
            
            // Calculate discount for this item (difference between old and new price)
            if ($product->old_price && $product->old_price > $product->new_price) {
                $itemDiscount = $item->quantity * ($product->old_price - $product->new_price);
                $totalDiscount += $itemDiscount;
            }
            
            $orderItems[] = [
                'product' => $product,
                'quantity' => $item->quantity,
                'price' => $item->price, // Use cart price (already discounted)
                'total' => $itemTotal
            ];
        }
        
        // Calculate delivery fee and final total (match the show method logic)
        $deliveryFee = $subtotal > 50000 ? 0 : 1500; // Free delivery over Rs. 50,000
        $total = $subtotal + $deliveryFee; // Subtotal is already using discounted prices, so no need to subtract discount again

        Log::info('Checkout Total: ' . $total); // Debug log

        Log::info('Starting database transaction'); // Debug log
        
        DB::beginTransaction();

        try {
            // Generate order code
            $latestOrder = UserOrder::latest()->first();
            $nextNumber = $latestOrder ? intval(substr($latestOrder->order_code, 3)) + 1 : 1;
            $orderCode = 'CAL' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);

            Log::info('Order Code: ' . $orderCode); // Debug log

            // Payment slip handling (for bank transfer - to be implemented in form later)
            $paymentSlipPath = null;

            // Save or update billing data for logged-in users
            if (Auth::check()) {
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
            }

            // Prepare billing data
            $billingData = [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'company_name' => $request->company_name,
                'address_1' => $request->address_1,
                'address_2' => $request->address_2,
                'town' => $request->town,
                'postal_code' => $request->postal_code,
                'phone' => $request->phone,
                'email' => $request->email,
            ];

            // Prepare cart data for storage
            $cartData = [
                'items' => $orderItems,
                'subtotal' => $subtotal, // This is the sum of discounted prices
                'discount' => $totalDiscount, // This is the total discount amount
                'delivery_fee' => $deliveryFee,
                'total' => $total, // This is subtotal + delivery_fee (discount already applied in subtotal)
            ];

            // Prepare payment data
            $paymentData = [
                'method' => $request->payment_method,
                'status' => $request->payment_method === 'card_payment' ? 'pending' : 'completed',
                'order_code' => $orderCode,
            ];

            // Create the order
            $order = UserOrder::create([
                'user_id' => $userId,
                'contact_info' => $request->phone . ' | ' . $request->email,
                'billing_data' => $billingData,
                'order_notes' => $request->notes ?? '',
                'cart_data' => $cartData,
                'payment_mode' => $request->payment_method,
                'payment_data' => $paymentData,
                'status' => false, // 0 = pending, 1 = completed
            ]);

            // Create order items and update stock
            foreach ($orderItems as $orderItem) {
                // Here you would create order items in a separate table if you have one
                // For now, we'll just clear the cart since the order contains the total
                
                $product = $orderItem['product'];
                // Update stock if you have stock tracking
                // $product->update(['stock_quantity' => $product->stock_quantity - $orderItem['quantity']]);
            }

            // Clear the user's cart
            UserCart::where('user_id', $userId)->delete();

            DB::commit();

            if ($request->payment_method === 'card_payment') {
                // Redirect to PayHere
                $merchant_id = env('PAYHERE_MERCHANT_ID');
                $merchant_secret = env('PAYHERE_MERCHANT_SECRET');
                $currency = 'LKR';

                $amount = number_format($total, 2, '.', '');
                $order_id = $order->id; // Use the actual order ID from database

                $payment = [
                    "merchant_id" => $merchant_id,
                    "return_url" => route('payment.success'),
                    "cancel_url" => route('payment.cancel'),
                    "notify_url" => route('payment.notify'),
                    "order_id" => $order_id,
                    "items" => 'Order #' . $orderCode,
                    "currency" => "LKR",
                    "amount" => $amount,
                    "first_name" => $request->first_name,
                    "last_name" => $request->last_name,
                    "email" => $request->email,
                    "phone" => $request->phone,
                    "address" => $request->address_1,
                    "city" => $request->town,
                    "country" => "Sri Lanka",
                ];

                // Generate the hash signature
                $payment['hash'] = strtoupper(md5(
                    $merchant_id . $payment['order_id'] . $payment['amount'] . $payment['currency'] . strtoupper(md5($merchant_secret))
                ));

                Log::info('PayHere payment data prepared for order: ' . $orderCode);

                return view('payhere.redirect', compact('payment'));
            }

            Log::info('Order placed successfully for order: ' . $orderCode);
            return redirect()->route('home')->with('success', 'Order placed successfully! Order Code: ' . $orderCode);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Checkout error: ' . $e->getMessage());

            // Delete uploaded payment slip if order creation fails
            if ($paymentSlipPath && file_exists(public_path($paymentSlipPath))) {
                unlink(public_path($paymentSlipPath));
            }

            return back()->with('error', 'Checkout failed: ' . $e->getMessage());
        }
    }

    public function paymentSuccess(Request $request)
    {
        return redirect()->route('home')->with('success', 'Payment completed successfully!');
    }

    public function paymentCancel(Request $request)
    {
        return redirect()->route('cart')->with('error', 'Payment was cancelled.');
    }

    // notify nethod for api/payment/notify route
    public function paymentNotify(Request $request)
    {
        Log::info('PayHere Notify Received', $request->all()); // Debug log

        // Step 1: Validate required fields
        $requiredFields = ['merchant_id', 'order_id', 'payhere_amount', 'payhere_currency', 'status_code', 'md5sig'];
        foreach ($requiredFields as $field) {
            if (!$request->has($field)) {
                Log::warning("Missing field in IPN: $field");
                return response("Missing field: $field", 400);
            }
        }

        // Step 2: Setup variables
        $merchant_id = env('PAYHERE_MERCHANT_ID');
        $merchant_secret = strtoupper(md5(env('PAYHERE_MERCHANT_SECRET')));
        $order_id = $request->order_id;
        $payhere_amount = $request->payhere_amount;
        $payhere_currency = $request->payhere_currency;
        $status = $request->status_code;
        $received_md5sig = $request->md5sig;

        // Step 3: Generate the local MD5 signature
        $local_md5sig = strtoupper(
            md5(
                $merchant_id .
                $order_id .
                $payhere_amount .
                $payhere_currency .
                $status .
                $merchant_secret
            )
        );

        // Step 4: Compare signatures
        if ($local_md5sig !== $received_md5sig) {
            Log::error('MD5 Signature Mismatch', [
                'expected' => $local_md5sig,
                'received' => $received_md5sig,
            ]);
            return response('Signature mismatch', 400);
        }

        // Step 5: Handle completed payment (status 2 = success)
        if ((int) $status === 2) {
            $order = UserOrder::find($order_id);

            if ($order) {
                // Update payment data to mark as completed
                $paymentData = $order->payment_data;
                $paymentData['status'] = 'completed';
                $paymentData['payhere_transaction_id'] = $request->payment_id ?? null;
                
                $order->payment_data = $paymentData;
                $order->status = true; // Mark order as completed
                $order->save();

                Log::info("Order ID {$order->id} payment marked as completed.");
            } else {
                Log::warning("Order not found for ID: {$order_id}");
            }
        } else {
            Log::info("Payment not completed. Status: {$status}, Order ID: {$order_id}");
        }

        return response('IPN received', 200);
    }
}

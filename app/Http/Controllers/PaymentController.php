<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\UserCart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    // Server-to-server notification from PayHere
    public function store(Request $request)
    {
        $user = Auth::guard('public_user')->user();

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'postal_code' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'notes' => 'nullable|string|max:1000',
            'payment_method' => 'required|in:bank_transfer,card_payment',
            'payment_slip' => 'required_if:payment_method,bank_transfer|nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $cart = UserCart::with('items.product')->where('public_user_id', $user->id)->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        $total = $cart->items->sum(function ($item) {
            $discount = $item->product->product_discount;
            $price = $item->product->selling_price;
            return ($price - ($price * $discount / 100)) * $item->quantity;
        });

        DB::beginTransaction();

        try {
            // Generate order code
            $latestOrder = Order::latest()->first();
            $nextNumber = $latestOrder ? intval(substr($latestOrder->order_code, 3)) + 1 : 1;
            $orderCode = 'YIO' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);

            // Handle payment slip upload
            $paymentSlipPath = null;
            if ($request->hasFile('payment_slip')) {
                $slip = $request->file('payment_slip');
                $slipName = $orderCode . '_' . time() . '.' . $slip->getClientOriginalExtension();
                $slip->move(public_path('uploads/payment_slips'), $slipName);
                $paymentSlipPath = 'uploads/payment_slips/' . $slipName;
            }

            // Create the order (for both card and cash)
            $order = Order::create([
                'order_code' => $orderCode,
                'public_user_id' => $user->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'company' => $request->company,
                'address_line1' => $request->address_line1,
                'address_line2' => $request->address_line2,
                'city' => $request->city,
                'province' => $request->province,
                'postal_code' => $request->postal_code,
                'phone' => $request->phone,
                'email' => $request->email,
                'notes' => $request->notes,
                'payment_method' => $request->payment_method,
                'payment_slip' => $paymentSlipPath, // Store the path
                'total' => $total,
            ]);

            foreach ($cart->items as $item) {
                $discountedPrice = $item->product->selling_price;
                if ($item->product->product_discount > 0) {
                    $discountedPrice -= $discountedPrice * $item->product->product_discount / 100;
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $discountedPrice,
                    'price' => $discountedPrice * $item->quantity,
                ]);

                $product = $item->product;
                if ($product->stock_quantity >= $item->quantity) {
                    $product->stock_quantity -= $item->quantity;
                    $product->save();
                } else {
                    throw new \Exception("Insufficient stock for product: {$product->name}");
                }
            }

            $cart->items()->delete();
            $cart->delete();

            DB::commit();

            if ($request->payment_method === 'card_payment') {
                // Redirect to PayHere
                $merchant_id = env('PAYHERE_MERCHANT_ID');

                $merchant_secret = env('PAYHERE_MERCHANT_SECRET');
                $currency = 'LKR';

                $amount = number_format($total, 2, '.', '');
                $order_id = $orderCode;

                // Prepare hash
                $hash = strtoupper(md5(
                    $merchant_id . $order_id . $amount . $currency . strtoupper(md5($merchant_secret))
                ));

                $payment = [
                    "merchant_id" => $merchant_id,
                    "return_url" => route('payment.success'),
                    "cancel_url" => route('payment.cancel'),
                    "notify_url" => route('payment.notify'),
                    "order_id" => $order_id,
                    "items" => 'Order #' . $order_id,
                    "currency" => "LKR",
                    "amount" => $amount,
                    "first_name" => $request->first_name,
                    "last_name" => $request->last_name,
                    "email" => $request->email,
                    "phone" => $request->phone,
                    "address" => $request->address_line1,
                    "city" => $request->city,
                    "country" => "Sri Lanka",
                ];

                // Generate the hash signature
                $payment['hash'] = strtoupper(md5(
                    $merchant_id . $payment['order_id'] . $payment['amount'] . $payment['currency'] . strtoupper(md5($merchant_secret))
                ));

                return view('payhere.redirect', compact('payment'));
            }

            return redirect()->route('home')->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

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
            $order = Order::where('order_code', $order_id)->first();

            if ($order) {
                if ($order->payment_status !== 'completed') {
                    $order->payment_status = 'completed';
                    // $order->order_status = 'processing'; // Optional: update order status
                    $order->save();

                    Log::info("Order #{$order->order_code} payment marked as completed.");
                } else {
                    Log::info("Order #{$order->order_code} payment already completed.");
                }
            } else {
                Log::warning("Order not found for order_code: {$order_id}");
            }
        } else {
            Log::info("Payment not completed. Status: {$status}, Order ID: {$order_id}");
        }

        return response('IPN received', 200);
    }
}

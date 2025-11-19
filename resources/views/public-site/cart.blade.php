@extends('layouts.public-site')

@section('content')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/cart.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/product-components.css') }}">
@endpush

<!-- Cart Page Header -->
<section class="cart-header">
    <div class="container">
        <div class="breadcrumb">
            <a href="/"><i class="fas fa-home"></i> Home</a>
            <span class="separator">/</span>
            <span class="current">Shopping Cart</span>
        </div>
        <h1>Your Shopping Cart</h1>
        <p class="cart-count-text"><span id="cartItemCount">{{ $cartCount }}</span> {{ $cartCount == 1 ? 'item' :
            'items' }} in your cart</p>
    </div>
</section>

<!-- Cart Content -->
<section class="cart-content">
    <div class="container">
        <div class="cart-layout" style="@if($cartItemsWithDetails->count() > 0) grid-template-columns: 2fr 1fr; @else grid-template-columns: 1fr; @endif">
            <!-- Cart Items -->
            <div class="cart-items-section">
                <div class="section-title">
                    <h2>Cart Items</h2>
                    @if($cartItemsWithDetails->count() > 0)
                    <button class="btn-text clear-cart">
                        <i class="fas fa-trash"></i> Clear Cart
                    </button>
                    @endif
                </div>

                <div id="cartTableBody">
                    @if($cartItemsWithDetails->count() > 0)
                    @foreach($cartItemsWithDetails as $item)
                    <div class="cart-item" data-product-id="{{ $item->id }}">
                        <div class="item-image">
                            @if($item->product->images && $item->product->images->count() > 0)
                            <img src="{{ asset('' . $item->product->images->first()->image) }}"
                                alt="{{ $item->name }}">
                            @else
                            <img src="{{ asset('assets/images/placeholder.jpg') }}" alt="{{ $item->name }}">
                            @endif
                            @if($item->product->old_price && $item->product->old_price > $item->product->new_price)
                            <span class="item-badge sale">Sale</span>
                            @else
                            <span class="item-badge">New</span>
                            @endif
                        </div>
                        <div class="item-details">
                            <h3 class="item-name">{{ $item->name }}</h3>
                            <p class="item-category"><i class="fas fa-tag"></i> {{ $item->product->type ?? 'Furniture' }}</p>
                            <p class="item-description">{{ Str::limit($item->product->description ?? 'Premium quality furniture piece', 100) }}</p>
                            <div class="item-specs">
                                @if($item->product->color)
                                <span><i class="fas fa-palette"></i> Color: {{ $item->product->color }}</span>
                                @endif
                                @if($item->product->vendor)
                                <span><i class="fas fa-store"></i> Vendor: {{ $item->product->vendor }}</span>
                                @endif
                                @if($item->product->barcode)
                                <span><i class="fas fa-barcode"></i> SKU: {{ $item->product->barcode }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="item-actions">
                            <div class="item-price">
                                <span class="current-price">LKR {{ number_format($item->product->new_price) }}</span>
                                @if($item->product->old_price && $item->product->old_price > $item->product->new_price)
                                <span class="original-price">LKR {{ number_format($item->product->old_price) }}</span>
                                @endif
                            </div>
                            <div class="quantity-control">
                                <div class="quantity__box" data-product-id="{{ $item->id }}">
                                    <button class="quantity__value decrease qty-btn minus"
                                        data-item-id="{{ $item->id }}">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" class="quantity__number qty-input"
                                        value="{{ $item->quantity }}" min="1" max="10" data-item-id="{{ $item->id }}">
                                    <button class="quantity__value increase qty-btn plus"
                                        data-item-id="{{ $item->id }}">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <button class="btn-remove remove-from-cart-button" data-product-id="{{ $item->id }}">
                                <i class="fas fa-trash-alt"></i> Remove
                            </button>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="empty-cart">
                        <div
                            style="text-align: center; padding: 60px 20px; border: 2px dashed #e5e7eb; border-radius: 12px; background: #f9fafb;">
                            <i class="fas fa-shopping-cart"
                                style="font-size: 4rem; color: #d1d5db; margin-bottom: 20px;"></i>
                            <h3 style="color: #6b7280; margin-bottom: 12px; font-size: 1.5rem;">Your Cart is Empty</h3>
                            <p style="color: #9ca3af; margin-bottom: 30px; font-size: 1rem;">Start adding some amazing
                                furniture to your cart!</p>
                            <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                                <a href="/marketplace" class="btn btn-primary">
                                    <i class="fas fa-shopping-bag"></i> Start Shopping
                                </a>
                                <a href="/" class="btn btn-secondary">
                                    <i class="fas fa-home"></i> Go Home
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Continue Shopping -->
                <div class="continue-shopping">
                    <a href="/marketplace" class="btn btn-outline">
                        <i class="fas fa-arrow-left"></i> Continue Shopping
                    </a>
                    <a href="/marketplace#featured-products" class="btn btn-secondary">
                        <i class="fas fa-store"></i> Browse All Products
                    </a>
                </div>
            </div>

            <!-- Cart Summary -->
            @if($cartItemsWithDetails->count() > 0)
            <div class="cart-summary-section">
                <div class="summary-card sticky-summary">
                    <h3>Order Summary</h3>

                    <div class="summary-row">
                        <span>Subtotal ({{ $cartCount }} {{ $cartCount == 1 ? 'item' : 'items' }})</span>
                        <span class="subtotal-amount" id="cart-subtotal">LKR {{ number_format($subtotal) }}</span>
                    </div>

                    @if($totalDiscount > 0)
                    <div class="summary-row">
                        <span>Discount</span>
                        <span class="discount-amount success">- LKR {{ number_format($totalDiscount) }}</span>
                    </div>
                    @endif

                    <div class="summary-row">
                        <span>Delivery Fee</span>
                        <span class="delivery-fee">
                            @if($deliveryFee > 0)
                            LKR {{ number_format($deliveryFee) }}
                            @else
                            <span class="success">Free</span>
                            @endif
                        </span>
                    </div>

                    <div class="promo-code-section">
                        <div class="promo-input-group">
                            <input type="text" placeholder="Enter promo code" id="promoCode" class="promo-input">
                            <button class="btn-apply">Apply</button>
                        </div>
                        <p class="promo-message" style="display: none;"></p>
                    </div>

                    <div class="summary-divider"></div>

                    <div class="summary-row total">
                        <span>Total Amount</span>
                        <span class="total-amount" id="cart-total">LKR {{ number_format($finalTotal) }}</span>
                    </div>

                    @if($totalDiscount > 0)
                    <div class="savings-badge">
                        <i class="fas fa-check-circle"></i> You're saving LKR {{ number_format($totalDiscount) }}!
                    </div>
                    @endif

                    <button class="btn btn-primary btn-full checkout-btn">
                        <i class="fas fa-lock"></i> Proceed to Checkout
                    </button>

                    <div class="security-badges">
                        <span><i class="fas fa-shield-alt"></i> Secure Checkout</span>
                        <span><i class="fas fa-truck"></i> Free Returns</span>
                    </div>
                </div>

                <!-- Additional Info -->
                <div class="info-cards">
                    <div class="info-card">
                        <i class="fas fa-shipping-fast"></i>
                        <div>
                            <h4>Fast Delivery</h4>
                            <p>Delivered within 3-5 business days</p>
                        </div>
                    </div>
                    <div class="info-card">
                        <i class="fas fa-undo"></i>
                        <div>
                            <h4>Easy Returns</h4>
                            <p>30-day return policy</p>
                        </div>
                    </div>
                    <div class="info-card">
                        <i class="fas fa-headset"></i>
                        <div>
                            <h4>24/7 Support</h4>
                            <p>Always here to help</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>

<!-- Recommended Products -->
<section class="recommended-products">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">You May Also Like</h2>
            <a href="/marketplace" class="view-all-link">
                <span>View All Products</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <div class="products-grid">
            @foreach($recommendedProducts as $product)
            <x-product-card :product="$product" classes="recommended-product-card" />
            @endforeach
        </div>

        <!-- Marketplace Quick Access -->
        <div class="marketplace-quick-access">
            <div class="quick-access-grid">
                <a href="/marketplace#category-living-room" class="quick-access-item">
                    <i class="fas fa-couch"></i>
                    <span>Living Room</span>
                </a>
                <a href="/marketplace#category-bedroom-sets" class="quick-access-item">
                    <i class="fas fa-bed"></i>
                    <span>Bedroom</span>
                </a>
                <a href="/marketplace#category-tables" class="quick-access-item">
                    <i class="fas fa-table"></i>
                    <span>Tables</span>
                </a>
                <a href="/marketplace#category-chairs" class="quick-access-item">
                    <i class="fas fa-chair"></i>
                    <span>Chairs</span>
                </a>
                <a href="/marketplace#category-custom" class="quick-access-item">
                    <i class="fas fa-tools"></i>
                    <span>Custom</span>
                </a>
                <a href="/marketplace" class="quick-access-item featured">
                    <i class="fas fa-store"></i>
                    <span>All Products</span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Product Modal -->
<x-product-modal />

@push('scripts')

<script>
    $(document).ready(function() {
    // Function to refresh cart page content
    function refreshCartPage() {
        location.reload(); // Simple page reload for now
    }

    // Override the refreshCartTable function for cart page
    window.refreshCartTable = function() {
        refreshCartPage();
    };

    // Override the refreshCartList function for cart page  
    window.refreshCartList = function() {
        console.log('Cart list refreshed');
    };

    // Update cart counts and totals on page load
    //updateCartCount();
    //loadCartTotal();

    // Handle quantity changes with delegation
    $(document).on('click', '.qty-btn.plus', function(e) {
        e.preventDefault();
        const input = $(this).siblings('.qty-input');
        let currentVal = parseInt(input.val()) || 1;
        input.val(currentVal + 1).trigger('change');
    });

    $(document).on('click', '.qty-btn.minus', function(e) {
        e.preventDefault();
        const input = $(this).siblings('.qty-input');
        let currentVal = parseInt(input.val()) || 1;
        if (currentVal > 1) {
            input.val(currentVal - 1).trigger('change');
        }
    });

    $(document).on('change', '.qty-input', function() {
        const productId = $(this).data('item-id');
        const newQuantity = $(this).val();
        
        if (newQuantity < 1) {
            $(this).val(1);
            return;
        }

        // Update cart via AJAX
        $.ajax({
            url: '/cart/update',
            method: 'POST',
            data: {
                product_id: productId,
                quantity: newQuantity,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Refresh the page to show updated totals
                setTimeout(function() {
                    location.reload();
                }, 500);
            },
            error: function(xhr) {
                console.error('Failed to update quantity');
                location.reload(); // Reload to reset to correct state
            }
        });
    });

    // Handle checkout button
    $('.checkout-btn').on('click', function() {
        console.log("test");
        @auth
            // If user is logged in, proceed to checkout
            Swal.fire({
                title: 'Proceed to Checkout?',
                text: 'You will be redirected to the checkout page.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, checkout!',
                cancelButtonText: 'Continue Shopping'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to checkout page
                    window.location.href = "{{ route('checkout.show') }}";
                }
            });
        @else
            // If user is not logged in, prompt to login
            Swal.fire({
                title: 'Login Required',
                text: 'Please login to proceed with checkout.',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Login',
                cancelButtonText: 'Continue as Guest'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/login';
                }
            });
        @endauth
    });

    // Handle promo code application
    $('.btn-apply').on('click', function() {
        const promoCode = $('#promoCode').val().trim();
        
        if (!promoCode) {
            $('.promo-message').text('Please enter a promo code').css('color', 'red').show();
            return;
        }

        // For now, show a simple message (you can implement actual promo code logic later)
        $('.promo-message').text('Promo code feature coming soon!').css('color', 'blue').show();
    });

    // Add to cart for recommended products
    $(document).on('click', '.quick-add', function(e) {
        e.preventDefault();
        
        // This is a placeholder - you'd need to add product IDs to the recommended products
        Swal.fire({
            title: 'Feature Coming Soon!',
            text: 'Quick add functionality for recommended products will be available soon.',
            icon: 'info'
        });
    });
});
</script>
@endpush

@endsection
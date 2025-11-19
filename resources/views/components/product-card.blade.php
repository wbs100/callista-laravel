@props([
    'product',
    'showBadge' => true,
    'badgeText' => null,
    'showQuickView' => true,
    'showAddToCart' => true,
    'classes' => ''
])

<div class="product-card {{ $classes }}" 
     data-product-id="{{ $product->id }}" 
     data-filter-categories="{{ $attributes->get('data-filter-categories', '') }}"
     data-aos="fade-up">
    @if($showBadge && ($badgeText || $product->old_price))
        <div class="product-badge">
            {{ $badgeText ?? ($product->old_price ? 'Sale' : 'New') }}
        </div>
    @endif
    
    <div class="product-image">
        @if($product->images && $product->images->count() > 0)
            <img src="{{ asset($product->images->first()->image) }}" 
                 alt="{{ $product->name }}" 
                 loading="lazy">
        @else
            <img src="{{ asset('assets/placeholder-product.jpg') }}" 
                 alt="{{ $product->name }}" 
                 loading="lazy">
        @endif
        
        @if($showQuickView || $showAddToCart)
            <div class="product-overlay">
                <div class="product-actions">
                    @if($showQuickView)
                        <button class="btn-quick-view" data-product-id="{{ $product->id }}" title="Quick View">
                            <i class="fas fa-eye"></i>
                        </button>
                    @endif
                    @if($showAddToCart)
                        <button class="btn-add-to-cart" data-product-id="{{ $product->id }}" title="Add to Cart">
                            <i class="fas fa-shopping-cart"></i>
                        </button>
                        <button class="btn-add-to-wishlist" data-product-id="{{ $product->id }}" title="Add to Wishlist">
                            <i class="fas fa-heart"></i>
                        </button>
                    @endif
                </div>
            </div>
        @endif
    </div>
    
    <div class="product-info">
        @if($product->rating > 0)
            <div class="product-rating">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= $product->rating)
                        <i class="fas fa-star"></i>
                    @else
                        <i class="far fa-star"></i>
                    @endif
                @endfor
                <span>({{ number_format($product->rating, 1) }})</span>
            </div>
        @endif
        
        <h3 class="product-title">{{ $product->name }}</h3>
        
        @if($product->type)
            <div class="product-category">{{ ucfirst($product->type) }}</div>
        @endif
        
        <div class="product-price">
            <span class="price-current">Rs. {{ number_format($product->new_price, 0) }}</span>
            @if($product->old_price && $product->old_price > $product->new_price)
                <span class="price-original">Rs. {{ number_format($product->old_price, 0) }}</span>
            @endif
        </div>
        
        @if($product->stock_status === 'out_of_stock')
            <div class="stock-status out-of-stock">Out of Stock</div>
        @elseif($product->stock_status === 'low_stock')
            <div class="stock-status low-stock">Low Stock</div>
        @else
            <div class="stock-status in-stock">In Stock</div>
        @endif
    </div>
</div>

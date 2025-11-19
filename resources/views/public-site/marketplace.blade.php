@extends('layouts.public-site')

@section('content')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/marketplace.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/sidebar-filters.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/slideshow-fix.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/product-components.css') }}">
@endpush

<!-- Hero Section -->
<section
    style="padding: 120px 0 80px; background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%); min-height: 600px; overflow: hidden;">
    <div
        style="display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center; max-width: 1400px; margin: 0 auto; padding: 0 24px;">
        <div style="max-width: 600px;">
            <h1
                style="font-size: clamp(2.5rem, 5vw, 3rem); font-weight: 700; line-height: 1.2; margin-bottom: 24px; color: #111827;">
                Transform Your Space<br>with <span style="color: #8b4513;">Callista</span>
            </h1>
            <p style="font-size: 18px; color: #6b7280; margin-bottom: 32px; line-height: 1.6;">
                Discover premium furniture, customize your perfect pieces, and bring your interior design dreams to
                life—all in one seamless experience with flexible payment options.
            </p>
            <div class="hero-buttons" style="display: flex; gap: 16px; margin-bottom: 48px;">
                <a href="#marketplace-section" class="btn btn-primary">
                    <i class="fas fa-store"></i>
                    <span>Browse Marketplace</span>
                </a>
                <a href="/interior" class="btn btn-outline">
                    Explore Services
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div style="display: flex; gap: 48px;">
                <div style="display: flex; flex-direction: column;">
                    <span style="font-size: 32px; font-weight: 700; color: #8b4513;">500+</span>
                    <span style="font-size: 14px; color: #6b7280;">Premium Products</span>
                </div>
                <div style="display: flex; flex-direction: column;">
                    <span style="font-size: 32px; font-weight: 700; color: #8b4513;">100+</span>
                    <span style="font-size: 14px; color: #6b7280;">Custom Designs</span>
                </div>
                <div style="display: flex; flex-direction: column;">
                    <span style="font-size: 32px; font-weight: 700; color: #8b4513;">1000+</span>
                    <span style="font-size: 14px; color: #6b7280;">Happy Customers</span>
                </div>
            </div>
        </div>

        <div style="position: relative; max-width: 100%;">
            <img src="../assets/hero-living-room.jpg" alt="Modern Living Room"
                style="width: 100%; max-width: 100%; height: 450px; object-fit: cover; border-radius: 16px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); display: block;">

            <div
                style="position: absolute; top: 20px; right: 20px; background: rgba(255, 255, 255, 0.95); color: #3d7c47; padding: 10px 18px; border-radius: 20px; font-size: 14px; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); z-index: 5; backdrop-filter: blur(10px);">
                <i class="fas fa-seedling" style="font-size: 16px; color: #3d7c47;"></i>
                Three Services, One Destination
            </div>

            <div
                style="position: absolute; bottom: 24px; left: 24px; background: white; padding: 16px 20px; border-radius: 12px; display: flex; align-items: center; gap: 12px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);">
                <i class="fas fa-credit-card" style="color: #3d7c47; font-size: 20px;"></i>
                <div style="display: flex; flex-direction: column;">
                    <strong style="font-weight: 600; color: #111827;">Flexible Payments</strong>
                    <span style="font-size: 14px; color: #6b7280;">Easy installments available</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products / Marketplace Section -->
<section class="featured-products" id="marketplace-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <h2 class="section-title">Furniture <span class="gradient-text">Marketplace</span></h2>
            <div class="section-nav">
                <button class="tab-btn active" data-filter="all">All</button>
                @foreach($categories->take(5) as $category)
                <button class="tab-btn" data-filter="{{ $category }}">{{ ucfirst(str_replace('-', ' ', $category))
                    }}</button>
                @endforeach
            </div>
        </div>

        <!-- Search Bar -->
        <div class="search-container" style="margin-bottom: 2rem;">
            <div class="search-input-wrapper">
                <i class="fas fa-search"></i>
                <input type="text" class="search-input" id="searchInput"
                    placeholder="Search furniture by name, category, or description...">
            </div>
        </div>

        <!-- Main Content Layout with Sidebar Filter -->
        <div class="marketplace-layout">
            <!-- Sidebar Filter Section -->
            <aside class="filter-sidebar">
                <div class="filter-header">
                    <h3 class="filter-title">
                        <i class="fas fa-filter"></i>
                        Filters
                    </h3>
                    <button class="clear-filters-btn" id="clearAllFilters">
                        <i class="fas fa-times"></i>
                        Clear All
                    </button>
                </div>

                <!-- Results Count -->
                <div class="results-info">
                    <span class="results-count" id="resultsCount">8</span>
                    <span class="results-text">products found</span>
                </div>

                <!-- Category Filter -->
                <div class="filter-group">
                    <h4 class="filter-group-title">Category</h4>
                    <div class="filter-options">
                        <label class="filter-option">
                            <input type="radio" name="category" value="all" checked>
                            <span class="option-text">All Categories</span>
                        </label>
                        @foreach($categories as $category)
                        <label class="filter-option">
                            <input type="radio" name="category" value="{{ $category }}">
                            <span class="option-text">{{ ucfirst(str_replace('-', ' ', $category)) }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- Price Range Filter -->
                <div class="filter-group">
                    <h4 class="filter-group-title">Price Range</h4>
                    <div class="price-filter">
                        <div class="price-inputs">
                            <input type="number" id="priceMin" placeholder="Min" value="" min="0" max="300000"
                                step="1000">
                            <span class="price-separator">to</span>
                            <input type="number" id="priceMax" placeholder="Max" value="" min="0" max="300000"
                                step="1000">
                        </div>
                    </div>
                </div>

                <!-- Rating Filter -->
                <div class="filter-group">
                    <h4 class="filter-group-title">Rating</h4>
                    <div class="filter-options">
                        <label class="filter-option">
                            <input type="radio" name="rating" value="all" checked>
                            <span class="option-text">All Ratings</span>
                        </label>
                        <label class="filter-option">
                            <input type="radio" name="rating" value="4+">
                            <span class="option-text">4+ Stars</span>
                        </label>
                        <label class="filter-option">
                            <input type="radio" name="rating" value="3+">
                            <span class="option-text">3+ Stars</span>
                        </label>
                    </div>
                </div>

                <!-- Features Filter -->
                <div class="filter-group">
                    <h4 class="filter-group-title">Features</h4>
                    <div class="filter-options">
                        <label class="filter-checkbox">
                            <input type="checkbox" id="inStock" checked>
                            <span class="checkbox-mark"></span>
                            <span class="option-text">In Stock</span>
                        </label>
                        <label class="filter-checkbox">
                            <input type="checkbox" id="customizable">
                            <span class="checkbox-mark"></span>
                            <span class="option-text">Customizable</span>
                        </label>
                        <label class="filter-checkbox">
                            <input type="checkbox" id="onSale">
                            <span class="checkbox-mark"></span>
                            <span class="option-text">On Sale</span>
                        </label>
                    </div>
                </div>
            </aside>

            <!-- Main Products Area -->
            <main class="products-main">
                <!-- Sort Controls -->
                <div class="sort-controls">
                    <div class="sort-group">
                        <label for="sortSelect">Sort by:</label>
                        <select class="sort-select" id="sortSelect">
                            <option value="default">Recommended</option>
                            <option value="price-low">Price: Low to High</option>
                            <option value="price-high">Price: High to Low</option>
                            <option value="rating">Customer Rating</option>
                            <option value="newest">Newest</option>
                            <option value="popular">Popular</option>
                        </select>
                    </div>
                </div>
                <!-- Products Grid -->
                <!-- Products Grid -->
                <div class="products-grid" id="marketplace-products-grid">
                    @forelse($products as $index => $product)
                    <x-product-card :product="$product"
                        :badge-text="$product->old_price && $product->old_price > $product->new_price ? 'Sale' : ($product->rating >= 4.5 ? 'Popular' : ($product->created_at->diffInDays() <= 30 ? 'New' : 'Featured'))"
                        :classes="$product->type" data-aos="fade-up" data-aos-delay="{{ ($index % 4) * 100 }}" />
                    @empty
                    <div class="no-products" style="grid-column: 1 / -1; text-align: center; padding: 80px 40px;">
                        <i class="fas fa-search-minus"
                            style="font-size: 4rem; color: #d1d5db; margin-bottom: 24px;"></i>
                        <h3 style="color: #6b7280; margin-bottom: 12px; font-size: 1.5rem;">No Products Found</h3>
                        <p style="color: #9ca3af; margin-bottom: 24px;">Try adjusting your filters or search terms</p>
                        <button class="btn btn-primary" onclick="resetAllFilters()">
                            <i class="fas fa-redo"></i> Reset All Filters
                        </button>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($products->hasPages())
                <div class="pagination-wrapper" style="margin-top: 40px;">
                    {{ $products->links('vendor.pagination.admin-pagination') }}
                </div>
                @endif

                <!-- No Results Message -->
                <div class="no-results" id="no-results">
                    <i class="fas fa-search-minus"></i>
                    <h3>No products found</h3>
                    <p>Try adjusting your filters or search terms to find what you're looking for</p>
                    <button class="btn btn-primary"
                        onclick="document.querySelector('.smart-filter-system')?.resetAllFilters?.()">
                        <i class="fas fa-redo"></i> Reset All Filters
                    </button>
                </div>
            </main>
        </div>

        {{-- <div class="section-footer" data-aos="fade-up" style="margin-top: 3rem;">
            <a href="/collection" class="btn btn-primary">
                View All Products <i class="fas fa-arrow-right"></i>
            </a>
        </div> --}}
    </div>
</section>

<!-- Featured Section -->
<section class="featured-showcase" id="featured-showcase">
    <div class="container">
        <!-- Section Header -->
        <div class="featured-header" data-aos="fade-up">
            <div class="header-content">
                <span class="section-label">Featured Collection</span>
                <h2 class="section-title">
                    Handpicked <span class="gradient-text">Premium</span> Pieces
                </h2>
                <p class="section-description">
                    Discover our carefully curated selection of exceptional furniture pieces that blend
                    timeless design with contemporary functionality
                </p>
            </div>
        </div>

        <!-- Image Slideshow -->
        <div class="slideshow-container" data-aos="fade-up" data-aos-delay="200"
            style="position: relative; width: 100%; max-width: 1200px; margin: 0 auto; background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);">
            <div class="slideshow-wrapper" style="position: relative; width: 100%; height: 600px; overflow: hidden;">
                <!-- Navigation Buttons -->
                <button class="nav-btn prev-btn" id="featuredPrev" aria-label="Previous slide"
                    style="position: absolute; top: 50%; left: 20px; transform: translateY(-50%); z-index: 10; width: 50px; height: 50px; background: rgba(255, 255, 255, 0.9); border: 2px solid rgba(139, 69, 19, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="nav-btn next-btn" id="featuredNext" aria-label="Next slide"
                    style="position: absolute; top: 50%; right: 20px; transform: translateY(-50%); z-index: 10; width: 50px; height: 50px; background: rgba(255, 255, 255, 0.9); border: 2px solid rgba(139, 69, 19, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                    <i class="fas fa-chevron-right"></i>
                </button>

                <div class="slides-track" id="slidesTrack" style="position: relative; width: 100%; height: 100%;">
                    <div class="slide active"
                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 1; visibility: visible; z-index: 2;">
                        <img src="../assets/funi (1).jpeg" alt="Luxury Living Room Set" loading="lazy"
                            style="width: 100%; height: 100%; object-fit: cover; display: block;">
                    </div>
                    <div class="slide"
                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; visibility: hidden; z-index: 1;">
                        <img src="../assets/funi (2).jpeg" alt="Designer Office Chair" loading="lazy"
                            style="width: 100%; height: 100%; object-fit: cover; display: block;">
                    </div>
                    <div class="slide"
                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; visibility: hidden; z-index: 1;">
                        <img src="../assets/sofa.png" alt="Modern Dining Set" loading="lazy"
                            style="width: 100%; height: 100%; object-fit: cover; display: block;">
                    </div>
                    <div class="slide"
                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; visibility: hidden; z-index: 1;">
                        <img src="../assets/bed.png" alt="Storage Ottoman" loading="lazy"
                            style="width: 100%; height: 100%; object-fit: cover; display: block;">
                    </div>
                    <div class="slide"
                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; visibility: hidden; z-index: 1;">
                        <img src="../assets/hero-living-room.jpg" alt="Modern Living Room" loading="lazy"
                            style="width: 100%; height: 100%; object-fit: cover; display: block;">
                    </div>
                </div>

                <!-- Slide Dots -->
                <div class="slide-dots"
                    style="position: absolute; bottom: 30px; left: 50%; transform: translateX(-50%); display: flex; gap: 12px; z-index: 10;">
                    <span class="dot active" data-slide="0"
                        style="width: 12px; height: 12px; border-radius: 50%; background: white; cursor: pointer; box-shadow: 0 0 0 3px rgba(139, 69, 19, 0.5);"></span>
                    <span class="dot" data-slide="1"
                        style="width: 12px; height: 12px; border-radius: 50%; background: rgba(255, 255, 255, 0.5); cursor: pointer;"></span>
                    <span class="dot" data-slide="2"
                        style="width: 12px; height: 12px; border-radius: 50%; background: rgba(255, 255, 255, 0.5); cursor: pointer;"></span>
                    <span class="dot" data-slide="3"
                        style="width: 12px; height: 12px; border-radius: 50%; background: rgba(255, 255, 255, 0.5); cursor: pointer;"></span>
                    <span class="dot" data-slide="4"
                        style="width: 12px; height: 12px; border-radius: 50%; background: rgba(255, 255, 255, 0.5); cursor: pointer;"></span>
                </div>
            </div>
        </div>



        <!-- Background Decoration -->
        <div class="section-decoration">
            <div class="decoration-circle circle-1"></div>
            <div class="decoration-circle circle-2"></div>
            <div class="decoration-circle circle-3"></div>
        </div>
</section>

<!-- Product Modal -->
<x-product-modal />

@push('scripts')
{{-- <script src="{{ asset('assets/js/marketplace.js') }}"></script> --}}
<script src="{{ asset('assets/js/sidebar-filters.js') }}"></script>
<script src="{{ asset('assets/js/slideshow-fix.js') }}"></script>
<script src="{{ asset('assets/js/marketplace-filter.js') }}"></script>
@endpush

@endsection
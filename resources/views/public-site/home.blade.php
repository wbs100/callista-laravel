@extends('layouts.public-site')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/product-components.css') }}">
@endpush

@section('content')

<!-- Hero Section -->
<section class="hero" id="home">
    <div class="hero-slider">
        <!-- Slide 1 -->
        <div class="hero-slide active">
            <div class="hero-bg hero-bg-1"></div>
            <div class="container">
                <div class="hero-content">
                    <h1 class="hero-title" data-aos="fade-up">
                        Transform Your <span class="gradient-text">Living Space</span>
                    </h1>
                    <p class="hero-subtitle" data-aos="fade-up" data-aos-delay="200">
                        Discover premium furniture and expert interior design solutions
                    </p>
                    <div class="hero-buttons" data-aos="fade-up" data-aos-delay="400">
                        <a href="/marketplace" class="btn btn-primary">
                            <span>Explore Collection</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                        <a href="/customize" class="btn btn-outline">
                            <span>Design Your Own</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slide 2 -->
        <div class="hero-slide">
            <div class="hero-bg hero-bg-2"></div>
            <div class="container">
                <div class="hero-content">
                    <h1 class="hero-title" data-aos="fade-up">
                        Elegant <span class="gradient-text">Interior Designs</span>
                    </h1>
                    <p class="hero-subtitle" data-aos="fade-up" data-aos-delay="200">
                        Professional interior design services for your dream home
                    </p>
                    <div class="hero-buttons" data-aos="fade-up" data-aos-delay="400">
                        <a href="/interior" class="btn btn-primary">
                            <span>Design Services</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                        <a href="/contact" class="btn btn-outline">
                            <span>Get Consultation</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slide 3 -->
        <div class="hero-slide">
            <div class="hero-bg hero-bg-3"></div>
            <div class="container">
                <div class="hero-content">
                    <h1 class="hero-title" data-aos="fade-up">
                        Custom <span class="gradient-text">Furniture Solutions</span>
                    </h1>
                    <p class="hero-subtitle" data-aos="fade-up" data-aos-delay="200">
                        Create personalized furniture that perfectly fits your style
                    </p>
                    <div class="hero-buttons" data-aos="fade-up" data-aos-delay="400">
                        <a href="/customize" class="btn btn-primary">
                            <span>Start Customizing</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                        <a href="/marketplace" class="btn btn-outline">
                            <span>View Catalog</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Slider Controls -->
    <div class="hero-controls">
        <button class="hero-control prev" aria-label="Previous slide">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="hero-control next" aria-label="Next slide">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>

    <!-- Slider Indicators -->
    <div class="hero-indicators">
        <button class="indicator active" data-slide="0" aria-label="Go to slide 1"></button>
        <button class="indicator" data-slide="1" aria-label="Go to slide 2"></button>
        <button class="indicator" data-slide="2" aria-label="Go to slide 3"></button>
    </div>

    <!-- <div class="hero-scroll">
            <div class="scroll-icon">
                <span></span>
            </div>
        </div> -->
</section>

<!-- Features Section -->
<section class="features">
    <div class="container">
        <div class="features-grid">
            <div class="feature-card" data-aos="fade-up">
                <div class="feature-icon">
                    <i class="fas fa-truck"></i>
                </div>
                <h3>Free Delivery</h3>
                <p>Island-wide delivery for orders over Rs. 50,000</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Quality Guarantee</h3>
                <p>Premium materials with 5-year warranty</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-icon">
                    <i class="fas fa-pencil-ruler"></i>
                </div>
                <h3>Custom Design</h3>
                <p>Personalized furniture to match your style</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <h3>Expert Support</h3>
                <p>Professional consultation and support</p>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="categories">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <h2 class="section-title">Shop by <span class="gradient-text">Category</span></h2>
            <p class="section-subtitle">Find the perfect piece for every room</p>
        </div>

        <div class="categories-grid">
            <a href="/marketplace#category-living-room" class="category-card" data-aos="zoom-in">
                <div class="category-image">
                    <img src="assets/hero-living-room.jpg" alt="Living Room">
                    <div class="category-overlay">
                        <h3>Living Room</h3>
                        <p>256 Products</p>
                    </div>
                </div>
            </a>

            <a href="/marketplace#category-bedroom-sets" class="category-card" data-aos="zoom-in"
                data-aos-delay="100">
                <div class="category-image">
                    <img src="assets/product-bedroom.jpg" alt="Bedroom">
                    <div class="category-overlay">
                        <h3>Bedroom</h3>
                        <p>189 Products</p>
                    </div>
                </div>
            </a>

            <a href="/marketplace#category-chairs" class="category-card" data-aos="zoom-in"
                data-aos-delay="200">
                <div class="category-image">
                    <img src="assets/interior-design.jpg" alt="Office">
                    <div class="category-overlay">
                        <h3>Office</h3>
                        <p>143 Products</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="featured-products">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <h2 class="section-title">Featured <span class="gradient-text">Products</span></h2>
            <div class="section-nav">
                <button class="tab-btn active" data-filter="all">All</button>
                <button class="tab-btn" data-filter="new">New Arrivals</button>
                <button class="tab-btn" data-filter="sale">On Sale</button>
                <button class="tab-btn" data-filter="trending">Trending</button>
            </div>
        </div>

        <div class="products-grid" id="featured-products-grid">
            @forelse($featuredProducts as $index => $product)
                <x-product-card 
                    :product="$product" 
                    :badge-text="$product->old_price && $product->old_price > $product->new_price ? 'Sale' : ($index < 2 ? 'New' : ($product->rating >= 4 ? 'Popular' : 'Featured'))"
                    :classes="$product->type"
                    data-aos="fade-up" 
                    data-aos-delay="{{ $index * 100 }}" 
                />
            @empty
                <div class="no-products" style="grid-column: 1 / -1; text-align: center; padding: 40px;">
                    <i class="fas fa-box-open" style="font-size: 3rem; color: #d1d5db; margin-bottom: 16px;"></i>
                    <h3 style="color: #6b7280; margin-bottom: 8px;">No Products Available</h3>
                    <p style="color: #9ca3af;">Check back soon for new arrivals!</p>
                </div>
            @endforelse
        </div>

        <div class="section-footer" data-aos="fade-up">
            <a href="/marketplace" class="btn btn-primary">
                View All Products <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<!-- Interior Design Showcase -->
<section class="showcase">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <h2 class="section-title">Interior Design <span class="gradient-text">Showcase</span></h2>
            <p class="section-subtitle">Get inspired by our latest projects</p>
        </div>

        <div class="showcase-grid">
            <div class="showcase-item large" data-aos="fade-up">
                <img src="assets/mini.png" alt="Project 1">
                <div class="showcase-content">
                    <h3>Modern Minimalist Home</h3>
                    <p>Colombo 07</p>
                </div>
            </div>

            <div class="showcase-item" data-aos="fade-up" data-aos-delay="100">
                <img src="assets/12 (1).png" alt="Project 2">
                <div class="showcase-content">
                    <h3>Luxury Villa</h3>
                    <p>Galle</p>
                </div>
            </div>

            <div class="showcase-item" data-aos="fade-up" data-aos-delay="200">
                <img src="assets/12 (5).png" alt="Project 3">
                <div class="showcase-content">
                    <h3>Office Space</h3>
                    <p>Colombo 03</p>
                </div>
            </div>

            <div class="showcase-item large" data-aos="fade-up" data-aos-delay="300">
                <img src="assets/12 (7).png" alt="Project 4">
                <div class="showcase-content">
                    <h3>Elegant Dining</h3>
                    <p>Kandy</p>
                </div>
            </div>

            <div class="showcase-item" data-aos="fade-up" data-aos-delay="400">
                <img src="assets/12 (8).png" alt="Project 5">
                <div class="showcase-content">
                    <h3>Modern Kitchen</h3>
                    <p>Negombo</p>
                </div>
            </div>

            <div class="showcase-item" data-aos="fade-up" data-aos-delay="500">
                <img src="assets/12 (4).png" alt="Project 6">
                <div class="showcase-content">
                    <h3>Cozy Lounge</h3>
                    <p>Moratuwa</p>
                </div>
            </div>

            <div class="showcase-item" data-aos="fade-up" data-aos-delay="600">
                <img src="assets/12 (6).png" alt="Project 7">
                <div class="showcase-content">
                    <h3>Luxury Bathroom</h3>
                    <p>Panadura</p>
                </div>
            </div>

            <div class="showcase-item" data-aos="fade-up" data-aos-delay="700">
                <img src="assets/12 (3).png" alt="Project 8">
                <div class="showcase-content">
                    <h3>Study Room</h3>
                    <p>Dehiwala</p>
                </div>
            </div>

            <div class="showcase-item" data-aos="fade-up" data-aos-delay="800">
                <img src="assets/12 (2).png" alt="Project 9">
                <div class="showcase-content">
                    <h3>Garden Area</h3>
                    <p>Maharagama</p>
                </div>
            </div>

            <div class="showcase-item " data-aos="fade-up" data-aos-delay="900">
                <img src="assets/12 (1).png" alt="Project 10">
                <div class="showcase-content">
                    <h3>Modern Minimalist Home</h3>
                    <p>Colombo 07</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter -->
<section class="newsletter">
    <div class="container">
        <div class="newsletter-content" data-aos="fade-up">
            <h2>Stay Updated</h2>
            <p>Subscribe to get special offers and exclusive deals</p>
            <form class="newsletter-form">
                <input type="email" placeholder="Enter your email" required>
                <button type="submit" class="btn btn-primary">
                    Subscribe <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>
</section>

<!-- Product Modal -->
<x-product-modal />



@endsection

@push('scripts')
@endpush
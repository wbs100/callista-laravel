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
                @php
                    $isOnSale = $product->old_price && $product->old_price > $product->new_price;
                    $isNew = $index < 2;
                    $isTrending = $product->rating >= 4;
                    
                    $filterClasses = [];
                    if ($isOnSale) $filterClasses[] = 'sale';
                    if ($isNew) $filterClasses[] = 'new';
                    if ($isTrending) $filterClasses[] = 'trending';
                    
                    $badgeText = $isOnSale ? 'Sale' : ($isNew ? 'New' : ($isTrending ? 'Popular' : 'Featured'));
                @endphp
                <x-product-card 
                    :product="$product" 
                    :badge-text="$badgeText"
                    :classes="$product->type . ' ' . implode(' ', $filterClasses)"
                    data-aos="fade-up" 
                    data-aos-delay="{{ $index * 100 }}"
                    data-filter-categories="{{ implode(' ', $filterClasses) }}"
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Featured Products Filter Functionality
    const filterButtons = document.querySelectorAll('.tab-btn');
    const productCards = document.querySelectorAll('#featured-products-grid .product-card');
    
    // Initialize filter functionality
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filterValue = this.getAttribute('data-filter');
            
            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Add loading effect and filter products
            addLoadingEffect();
            setTimeout(() => filterProducts(filterValue), 100);
        });
    });
    
    // Initialize filter counts
    updateFilterCounts();
    
    function filterProducts(filter) {
        let showDelay = 0;
        let hideDelay = 0;
        
        productCards.forEach((card, index) => {
            const categories = card.getAttribute('data-filter-categories') || '';
            
            if (filter === 'all') {
                // Show all products with stagger
                setTimeout(() => showProduct(card), showDelay);
                showDelay += 50;
            } else {
                // Check if product has the filter category
                if (categories.includes(filter)) {
                    setTimeout(() => showProduct(card), showDelay);
                    showDelay += 50;
                } else {
                    setTimeout(() => hideProduct(card), hideDelay);
                    hideDelay += 30;
                }
            }
        });
        
        // Check if no products are visible after animations complete
        setTimeout(checkEmptyState, 400);
    }
    
    function showProduct(card) {
        card.style.display = 'block';
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px) scale(0.95)';
        
        // Animate in with stagger effect
        requestAnimationFrame(() => {
            card.style.transition = 'all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1)';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0) scale(1)';
        });
    }
    
    function hideProduct(card) {
        card.style.transition = 'all 0.25s cubic-bezier(0.4, 0, 1, 1)';
        card.style.opacity = '0';
        card.style.transform = 'translateY(-20px) scale(0.95)';
        
        setTimeout(() => {
            card.style.display = 'none';
        }, 250);
    }
    
    function checkEmptyState() {
        const visibleProducts = Array.from(productCards).filter(card => {
            return card.style.display !== 'none';
        });
        
        // Remove existing empty state
        const existingEmptyState = document.querySelector('#featured-products-grid .filter-empty-state');
        if (existingEmptyState) {
            existingEmptyState.remove();
        }
        
        if (visibleProducts.length === 0) {
            // Show empty state
            const emptyState = document.createElement('div');
            emptyState.className = 'filter-empty-state';
            emptyState.style.cssText = `
                grid-column: 1 / -1;
                text-align: center;
                padding: 60px 20px;
                color: #6b7280;
            `;
            emptyState.innerHTML = `
                <i class="fas fa-search" style="font-size: 3rem; margin-bottom: 16px; opacity: 0.5;"></i>
                <h3 style="margin-bottom: 8px; font-weight: 600;">No Products Found</h3>
                <p style="color: #9ca3af;">Try selecting a different filter or view all products.</p>
                <button onclick="document.querySelector('[data-filter=\"all\"]').click()" 
                        style="margin-top: 16px; padding: 8px 20px; background: #667eea; color: white; border: none; border-radius: 6px; cursor: pointer;">
                    View All Products
                </button>
            `;
            
            document.getElementById('featured-products-grid').appendChild(emptyState);
        }
    }
    
    // Add smooth hover effects for filter buttons
    filterButtons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            if (!this.classList.contains('active')) {
                this.style.transform = 'translateY(-2px)';
                this.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
            }
        });
        
        button.addEventListener('mouseleave', function() {
            if (!this.classList.contains('active')) {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 2px 8px rgba(0,0,0,0.1)';
            }
        });
    });
    
    // Add keyboard support for filter buttons
    filterButtons.forEach(button => {
        button.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.click();
            }
        });
    });
    
    // Update filter counts
    function updateFilterCounts() {
        filterButtons.forEach(button => {
            const filterValue = button.getAttribute('data-filter');
            let count = 0;
            
            if (filterValue === 'all') {
                count = productCards.length;
            } else {
                count = Array.from(productCards).filter(card => {
                    const categories = card.getAttribute('data-filter-categories') || '';
                    return categories.includes(filterValue);
                }).length;
            }
            
            // Only show count if button doesn't already have it
            if (!button.querySelector('.filter-count')) {
                const countSpan = document.createElement('span');
                countSpan.className = 'filter-count';
                countSpan.textContent = ` (${count})`;
                button.appendChild(countSpan);
            }
        });
    }
    
    // Add loading animation for filter changes
    function addLoadingEffect() {
        const grid = document.getElementById('featured-products-grid');
        grid.style.opacity = '0.7';
        grid.style.pointerEvents = 'none';
        
        setTimeout(() => {
            grid.style.opacity = '1';
            grid.style.pointerEvents = 'auto';
        }, 300);
    }
});
</script>

<style>
/* Filter Button Styles */
.section-nav {
    display: flex;
    gap: 12px;
    justify-content: center;
    flex-wrap: wrap;
    margin-top: 24px;
}

/* .tab-btn {
    padding: 12px 24px;
    border: 2px solid #e5e7eb;
    background: white;
    color: #6b7280;
    border-radius: 50px;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.tab-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    transition: left 0.3s ease;
    z-index: -1;
}

.tab-btn:hover {
    border-color: #667eea;
    color: #667eea;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
}

.tab-btn.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-color: #667eea;
    color: white;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.tab-btn.active::before {
    left: 0;
}

.tab-btn:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
} */

.filter-count {
    font-size: 12px;
    opacity: 0.8;
    font-weight: 500;
}

.tab-btn.active .filter-count {
    opacity: 1;
}

#featured-products-grid {
    transition: opacity 0.3s ease;
}

/* Product Grid Animation */
.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 24px;
    margin-top: 40px;
}

.product-card {
    transition: all 0.3s ease;
}

.filter-empty-state {
    animation: fadeIn 0.5s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .section-nav {
        gap: 8px;
    }
    
    .tab-btn {
        padding: 10px 16px;
        font-size: 13px;
    }
    
    .products-grid {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 16px;
    }
}

@media (max-width: 480px) {
    .tab-btn {
        padding: 8px 12px;
        font-size: 12px;
    }
    
    .products-grid {
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }
}
</style>
@endpush
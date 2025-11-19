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
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Product filtering functionality
    const filterButtons = document.querySelectorAll('.tab-btn');
    const productCards = document.querySelectorAll('.product-card');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');
            
            const filter = this.dataset.filter;
            
            productCards.forEach(card => {
                if (filter === 'all') {
                    card.style.display = 'block';
                } else {
                    if (card.classList.contains(filter)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                }
            });
        });
    });
    
    // Quick view functionality
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-quick-view')) {
            e.preventDefault();
            e.stopPropagation();
            const productId = e.target.closest('.btn-quick-view').dataset.productId;
            openProductModal(productId);
        }
    });
    
    // Add to cart functionality
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-add-to-cart')) {
            e.preventDefault();
            e.stopPropagation();
            const productId = e.target.closest('.btn-add-to-cart').dataset.productId;
            addToCart(productId);
        }
    });
    
    // Add to wishlist functionality
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-add-to-wishlist')) {
            e.preventDefault();
            e.stopPropagation();
            const productId = e.target.closest('.btn-add-to-wishlist').dataset.productId;
            addToWishlist(productId);
        }
    });
    
    // Modal event handlers
    document.addEventListener('click', function(e) {
        const modal = document.getElementById('productModal');
        if (e.target === modal || e.target.classList.contains('modal-overlay')) {
            closeProductModal();
        }
    });
    
    // Prevent modal content clicks from closing modal
    document.addEventListener('click', function(e) {
        if (e.target.closest('.modal-content')) {
            e.stopPropagation();
        }
    });
    
    // Escape key to close modal
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('productModal');
            if (modal.classList.contains('active')) {
                closeProductModal();
            }
        }
    });
    
    // Modal close button using event delegation
    document.addEventListener('click', function(e) {
        if (e.target.closest('#modalCloseBtn')) {
            e.preventDefault();
            e.stopPropagation();
            closeProductModal();
        }
    });
});

// Product modal functions
function openProductModal(productId) {
    const modal = document.getElementById('productModal');
    
    // Show loading state
    modal.style.display = 'flex';
    requestAnimationFrame(() => {
        modal.classList.add('active');
    });
    
    // Fetch product data
    fetch(`/api/products/${productId}`)
        .then(response => response.json())
        .then(product => {
            populateModal(product);
        })
        .catch(error => {
            console.error('Error fetching product:', error);
            //closeProductModal();
        });
}

function closeProductModal() {
    const modal = document.getElementById('productModal');
    modal.classList.remove('active');
    setTimeout(() => modal.style.display = 'none', 300);
}

function populateModal(product) {
    // Set product name
    document.getElementById('modalProductName').textContent = product.name;
    
    // Set product rating
    const ratingContainer = document.getElementById('modalRating');
    let ratingHtml = '';
    for (let i = 1; i <= 5; i++) {
        if (i <= product.rating) {
            ratingHtml += '<i class="fas fa-star"></i>';
        } else {
            ratingHtml += '<i class="far fa-star"></i>';
        }
    }
    ratingHtml += `<span>(${product.rating.toFixed(1)})</span>`;
    ratingContainer.innerHTML = ratingHtml;
    
    // Set price
    const priceContainer = document.getElementById('modalPrice');
    let priceHtml = `<span class="price-current">Rs. ${new Intl.NumberFormat().format(product.new_price)}</span>`;
    if (product.old_price && product.old_price > product.new_price) {
        priceHtml += `<span class="price-original">Rs. ${new Intl.NumberFormat().format(product.old_price)}</span>`;
    }
    priceContainer.innerHTML = priceHtml;
    
    // Set meta information
    document.getElementById('modalCategory').textContent = product.type ? product.type.charAt(0).toUpperCase() + product.type.slice(1) : '-';
    document.getElementById('modalVendor').textContent = product.vendor || '-';
    document.getElementById('modalSku').textContent = product.barcode || '-';
    
    // Set stock status
    const stockElement = document.getElementById('modalStock');
    stockElement.textContent = product.stock_status.replace('_', ' ').toUpperCase();
    stockElement.className = `stock-badge ${product.stock_status.replace('_', '-')}`;
    
    // Set description
    document.getElementById('modalDescription').textContent = product.description || 'No description available.';
    
    // Set tags
    // const tagsContainer = document.getElementById('modalTags');
    // if (product.tags && product.tags.length > 0) {
    //     tagsContainer.innerHTML = product.tags.map(tag => `<span class="tag">${tag}</span>`).join('');
    // } else {
    //     tagsContainer.innerHTML = '<span class="tag">No tags</span>';
    // }
    
    // Set images
    if (product.images && product.images.length > 0) {
        console.log(product.images);
        console.log(product.images.length);
        // Main image
        document.getElementById('modalMainImage').src = product.images[0].url;
        document.getElementById('modalMainImage').alt = product.images[0].alt;
        
        // Thumbnails
        const thumbnailsContainer = document.getElementById('modalThumbnails');
        thumbnailsContainer.innerHTML = product.images.map((image, index) => `
            <div class="thumbnail ${index === 0 ? 'active' : ''}" onclick="changeMainImage('${image.url}', ${index})">
                <img src="${image.url}" alt="${image.alt}">
            </div>
        `).join('');

        console.log();
    } else {
        alert("oops")
    }
    
    // Set up action buttons
    document.getElementById('modalAddToCart').onclick = () => addToCart(product.id);
    document.getElementById('modalAddToWishlist').onclick = () => addToWishlist(product.id);
}

function changeMainImage(imageUrl, index) {
    document.getElementById('modalMainImage').src = imageUrl;
    
    // Update active thumbnail
    document.querySelectorAll('.thumbnail').forEach((thumb, i) => {
        thumb.classList.toggle('active', i === index);
    });
}

function increaseQuantity() {
    const input = document.getElementById('modalQuantity');
    const currentValue = parseInt(input.value);
    const maxValue = parseInt(input.max);
    if (currentValue < maxValue) {
        input.value = currentValue + 1;
    }
}

function decreaseQuantity() {
    const input = document.getElementById('modalQuantity');
    const currentValue = parseInt(input.value);
    const minValue = parseInt(input.min);
    if (currentValue > minValue) {
        input.value = currentValue - 1;
    }
}

function addToCart(productId) {
    const quantity = document.getElementById('modalQuantity') ? document.getElementById('modalQuantity').value : 1;
    
    // Add your cart logic here
    console.log(`Adding product ${productId} to cart with quantity ${quantity}`);
    
    // Show success message
    showNotification('Product added to cart!', 'success');
}

function addToWishlist(productId) {
    // Add your wishlist logic here
    console.log(`Adding product ${productId} to wishlist`);
    
    // Show success message
    showNotification('Product added to wishlist!', 'success');
}

function showNotification(message, type = 'info') {
    // Simple notification system
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'success' ? '#10b981' : '#3b82f6'};
        color: white;
        padding: 12px 24px;
        border-radius: 8px;
        z-index: 10000;
        transition: all 0.3s ease;
        transform: translateX(100%);
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => notification.style.transform = 'translateX(0)', 10);
    
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}
</script>
@endpush
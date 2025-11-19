class MarketplaceFilter {
    constructor() {
        this.currentFilters = {
            category: 'all',
            search: '',
            price_min: '',
            price_max: '',
            rating: 'all',
            in_stock: true,
            customizable: false,
            on_sale: false,
            sort: 'default'
        };
        
        this.init();
    }
    
    init() {
        this.bindEvents();
        this.initializeFilters();
        this.updateProductCount();
    }
    
    bindEvents() {
        // Search input
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            let searchTimeout;
            searchInput.addEventListener('input', (e) => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    this.currentFilters.search = e.target.value;
                    this.applyFilters();
                }, 500);
            });
        }
        
        // Category filters (radio buttons)
        document.querySelectorAll('input[name="category"]').forEach(input => {
            input.addEventListener('change', (e) => {
                if (e.target.checked) {
                    this.currentFilters.category = e.target.value;
                    this.applyFilters();
                }
            });
        });
        
        // Price range filters
        const priceMin = document.getElementById('priceMin');
        const priceMax = document.getElementById('priceMax');
        
        if (priceMin) {
            priceMin.addEventListener('change', (e) => {
                this.currentFilters.price_min = e.target.value;
                this.applyFilters();
            });
        }
        
        if (priceMax) {
            priceMax.addEventListener('change', (e) => {
                this.currentFilters.price_max = e.target.value;
                this.applyFilters();
            });
        }
        
        // Rating filter
        document.querySelectorAll('input[name="rating"]').forEach(input => {
            input.addEventListener('change', (e) => {
                if (e.target.checked) {
                    this.currentFilters.rating = e.target.value;
                    this.applyFilters();
                }
            });
        });
        
        // Feature checkboxes
        const inStockCheckbox = document.getElementById('inStock');
        const customizableCheckbox = document.getElementById('customizable');
        const onSaleCheckbox = document.getElementById('onSale');
        
        if (inStockCheckbox) {
            inStockCheckbox.addEventListener('change', (e) => {
                this.currentFilters.in_stock = e.target.checked;
                this.applyFilters();
            });
        }
        
        if (customizableCheckbox) {
            customizableCheckbox.addEventListener('change', (e) => {
                this.currentFilters.customizable = e.target.checked;
                this.applyFilters();
            });
        }
        
        if (onSaleCheckbox) {
            onSaleCheckbox.addEventListener('change', (e) => {
                this.currentFilters.on_sale = e.target.checked;
                this.applyFilters();
            });
        }
        
        // Sort dropdown
        const sortSelect = document.getElementById('sortSelect');
        if (sortSelect) {
            sortSelect.addEventListener('change', (e) => {
                this.currentFilters.sort = e.target.value;
                this.applyFilters();
            });
        }
        
        // Tab buttons
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                // Remove active class from all tabs
                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                // Add active class to clicked tab
                e.target.classList.add('active');
                
                const filter = e.target.dataset.filter;
                this.currentFilters.category = filter;
                
                // Update radio button
                const categoryRadio = document.querySelector(`input[name="category"][value="${filter}"]`);
                if (categoryRadio) {
                    categoryRadio.checked = true;
                }
                
                this.applyFilters();
            });
        });
        
        // Clear all filters button
        const clearAllBtn = document.getElementById('clearAllFilters');
        if (clearAllBtn) {
            clearAllBtn.addEventListener('click', () => {
                this.resetAllFilters();
            });
        }
        
        // Single consolidated click handler
        document.addEventListener('click', (e) => {
            // Handle product action buttons
            if (e.target.closest('.btn-quick-view')) {
                console.log('Quick view button clicked'); // Debug log
                e.preventDefault();
                e.stopPropagation();
                const productId = e.target.closest('.btn-quick-view').dataset.productId;
                this.openProductModal(productId);
                return;
            }
            
            if (e.target.closest('.btn-add-to-cart')) {
                e.preventDefault();
                e.stopPropagation();
                const productId = e.target.closest('.btn-add-to-cart').dataset.productId;
                //this.addToCart(productId);
                return;
            }
            
            if (e.target.closest('.btn-add-to-wishlist')) {
                e.preventDefault();
                e.stopPropagation();
                const productId = e.target.closest('.btn-add-to-wishlist').dataset.productId;
                //this.addToWishlist(productId);
                return;
            }
            
            // Handle modal close button
            if (e.target.closest('#modalCloseBtn')) {
                console.log('Close button clicked'); // Debug log
                e.preventDefault();
                e.stopPropagation();
                this.closeProductModal();
                return;
            }
            
            // Handle modal overlay clicks
            const modal = document.getElementById('productModal');
            if (modal && modal.classList.contains('active')) {
                // Check if click is on overlay or modal itself (not content)
                if (e.target === modal || e.target.classList.contains('modal-overlay')) {
                    console.log('Overlay clicked, closing modal'); // Debug log
                    this.closeProductModal();
                    return;
                }
                
                // Prevent modal content clicks from bubbling
                if (e.target.closest('.modal-content')) {
                    e.stopPropagation();
                }
            }
        });
        
        // Escape key to close modal
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                const modal = document.getElementById('productModal');
                if (modal && modal.classList.contains('active')) {
                    console.log('Escape key pressed, closing modal'); // Debug log
                    this.closeProductModal();
                }
            }
        });
    }
    
    initializeFilters() {
        // Set initial values from URL parameters if any
        const urlParams = new URLSearchParams(window.location.search);
        
        Object.keys(this.currentFilters).forEach(key => {
            if (urlParams.has(key)) {
                this.currentFilters[key] = urlParams.get(key);
            }
        });
        
        // Update UI to match current filters
        this.updateUI();
    }
    
    applyFilters() {
        this.showLoading();
        
        // Build query parameters
        const params = new URLSearchParams();
        
        Object.keys(this.currentFilters).forEach(key => {
            if (this.currentFilters[key] && this.currentFilters[key] !== '' && this.currentFilters[key] !== 'all') {
                params.append(key, this.currentFilters[key]);
            }
        });
        
        // Make AJAX request
        fetch(`/api/products?${params.toString()}`)
            .then(response => response.json())
            .then(data => {
                this.updateProductGrid(data.products);
                this.updateProductCount(data.pagination.total);
                this.hideLoading();
                
                // Update URL without page reload
                const newUrl = `${window.location.pathname}?${params.toString()}`;
                window.history.pushState({}, '', newUrl);
            })
            .catch(error => {
                console.error('Error fetching products:', error);
                this.hideLoading();
                this.showError('Failed to load products. Please try again.');
            });
    }
    
    updateProductGrid(products) {
        const grid = document.getElementById('marketplace-products-grid');
        
        if (products.length === 0) {
            grid.innerHTML = `
                <div class="no-products" style="grid-column: 1 / -1; text-align: center; padding: 80px 40px;">
                    <i class="fas fa-search-minus" style="font-size: 4rem; color: #d1d5db; margin-bottom: 24px;"></i>
                    <h3 style="color: #6b7280; margin-bottom: 12px; font-size: 1.5rem;">No Products Found</h3>
                    <p style="color: #9ca3af; margin-bottom: 24px;">Try adjusting your filters or search terms</p>
                    <button class="btn btn-primary" onclick="marketplaceFilter.resetAllFilters()">
                        <i class="fas fa-redo"></i> Reset All Filters
                    </button>
                </div>
            `;
            return;
        }
        
        grid.innerHTML = products.map((product, index) => {
            const badge = this.getBadgeText(product);
            const imageUrl = product.images && product.images.length > 0 
                ? product.images[0].url
                : '/assets/placeholder-product.jpg';
            
            return `
                <div class="product-card ${product.type || ''}" data-product-id="${product.id}" data-aos="fade-up" data-aos-delay="${(index % 4) * 100}">
                    <div class="product-badge">${badge}</div>
                    <div class="product-image">
                        <img src="${imageUrl}" alt="${product.name}" loading="lazy">
                        <div class="product-overlay">
                            <div class="product-actions">
                                <button class="btn-quick-view" data-product-id="${product.id}" title="Quick View">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-add-to-cart" data-product-id="${product.id}" title="Add to Cart">
                                    <i class="fas fa-shopping-cart"></i>
                                </button>
                                <button class="btn-add-to-wishlist" data-product-id="${product.id}" title="Add to Wishlist">
                                    <i class="fas fa-heart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="product-info">
                        ${product.rating > 0 ? this.generateRating(product.rating) : ''}
                        <h3 class="product-title">${product.name}</h3>
                        ${product.type ? `<div class="product-category">${product.type.charAt(0).toUpperCase() + product.type.slice(1)}</div>` : ''}
                        <div class="product-price">
                            <span class="price-current">Rs. ${new Intl.NumberFormat().format(product.new_price)}</span>
                            ${product.old_price && product.old_price > product.new_price ? 
                                `<span class="price-original">Rs. ${new Intl.NumberFormat().format(product.old_price)}</span>` : ''}
                        </div>
                        <div class="stock-status ${product.stock_status.replace('_', '-')}">${product.stock_status.replace('_', ' ').toUpperCase()}</div>
                    </div>
                </div>
            `;
        }).join('');
        
        // Reinitialize AOS for new elements
        if (typeof AOS !== 'undefined') {
            AOS.refresh();
        }
    }
    
    getBadgeText(product) {
        if (product.old_price && product.old_price > product.new_price) {
            return 'Sale';
        }
        if (product.rating >= 4.5) {
            return 'Popular';
        }
        const createdDate = new Date(product.created_at);
        const now = new Date();
        const daysDiff = (now - createdDate) / (1000 * 60 * 60 * 24);
        if (daysDiff <= 30) {
            return 'New';
        }
        return 'Featured';
    }
    
    generateRating(rating) {
        let html = '<div class="product-rating">';
        for (let i = 1; i <= 5; i++) {
            if (i <= rating) {
                html += '<i class="fas fa-star"></i>';
            } else {
                html += '<i class="far fa-star"></i>';
            }
        }
        html += `<span>(${rating})</span></div>`;
        return html;
    }
    
    updateProductCount(count) {
        const counter = document.getElementById('resultsCount');
        if (counter) {
            counter.textContent = count || 0;
        }
    }
    
    updateUI() {
        // Update search input
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.value = this.currentFilters.search;
        }
        
        // Update category radio
        const categoryRadio = document.querySelector(`input[name="category"][value="${this.currentFilters.category}"]`);
        if (categoryRadio) {
            categoryRadio.checked = true;
        }
        
        // Update price inputs
        const priceMin = document.getElementById('priceMin');
        const priceMax = document.getElementById('priceMax');
        if (priceMin) priceMin.value = this.currentFilters.price_min;
        if (priceMax) priceMax.value = this.currentFilters.price_max;
        
        // Update rating radio
        const ratingRadio = document.querySelector(`input[name="rating"][value="${this.currentFilters.rating}"]`);
        if (ratingRadio) {
            ratingRadio.checked = true;
        }
        
        // Update checkboxes
        const inStockCheckbox = document.getElementById('inStock');
        const customizableCheckbox = document.getElementById('customizable');
        const onSaleCheckbox = document.getElementById('onSale');
        
        if (inStockCheckbox) inStockCheckbox.checked = this.currentFilters.in_stock;
        if (customizableCheckbox) customizableCheckbox.checked = this.currentFilters.customizable;
        if (onSaleCheckbox) onSaleCheckbox.checked = this.currentFilters.on_sale;
        
        // Update sort select
        const sortSelect = document.getElementById('sortSelect');
        if (sortSelect) {
            sortSelect.value = this.currentFilters.sort;
        }
    }
    
    resetAllFilters() {
        this.currentFilters = {
            category: 'all',
            search: '',
            price_min: '',
            price_max: '',
            rating: 'all',
            in_stock: true,
            customizable: false,
            on_sale: false,
            sort: 'default'
        };
        
        this.updateUI();
        this.applyFilters();
        
        // Reset tab buttons
        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
        document.querySelector('.tab-btn[data-filter="all"]')?.classList.add('active');
    }
    
    showLoading() {
        const grid = document.getElementById('marketplace-products-grid');
        grid.style.opacity = '0.5';
        grid.style.pointerEvents = 'none';
    }
    
    hideLoading() {
        const grid = document.getElementById('marketplace-products-grid');
        grid.style.opacity = '1';
        grid.style.pointerEvents = 'auto';
    }
    
    showError(message) {
        // Simple error notification
        const notification = document.createElement('div');
        notification.className = 'notification error';
        notification.textContent = message;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: #ef4444;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            z-index: 10000;
            transition: all 0.3s ease;
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 5000);
    }
    
    // Product modal methods
    openProductModal(productId) {
        console.log('Opening modal for product:', productId); // Debug log
        
        const modal = document.getElementById('productModal');
        if (!modal) {
            console.error('Modal element not found');
            return;
        }
        
        // Prevent any existing close timeouts
        if (this.modalCloseTimeout) {
            clearTimeout(this.modalCloseTimeout);
        }
        
        // Remove any existing active class first
        modal.classList.remove('active');
        modal.style.display = 'flex';
        
        // Force reflow then add active class
        modal.offsetHeight;
        
        setTimeout(() => {
            modal.classList.add('active');
            console.log('Modal should be visible now'); // Debug log
        }, 50);
        
        fetch(`/api/products/${productId}`)
            .then(response => response.json())
            .then(product => {
                this.populateModal(product);
            })
            .catch(error => {
                console.error('Error fetching product:', error);
                //this.closeProductModal();
            });
    }
    
    closeProductModal() {
        console.log('Closing modal'); // Debug log
        
        const modal = document.getElementById('productModal');
        if (!modal) return;
        
        modal.classList.remove('active');
        this.modalCloseTimeout = setTimeout(() => {
            modal.style.display = 'none';
            console.log('Modal hidden'); // Debug log
        }, 300);
    }
    
    populateModal(product) {
        // Set product name
        document.getElementById('modalProductName').textContent = product.name;
        
        // Set product rating
        const ratingContainer = document.getElementById('modalRating');
        ratingContainer.innerHTML = this.generateRating(product.rating);
        
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
            document.getElementById('modalMainImage').src = product.images[0].url;
            document.getElementById('modalMainImage').alt = product.images[0].alt;
            
            const thumbnailsContainer = document.getElementById('modalThumbnails');
            thumbnailsContainer.innerHTML = product.images.map((image, index) => `
                <div class="thumbnail ${index === 0 ? 'active' : ''}" onclick="marketplaceFilter.changeMainImage('${image.url}', ${index})">
                    <img src="${image.url}" alt="${image.alt}">
                </div>
            `).join('');
        }
        
        // Set up action buttons
        // document.getElementById('modalAddToCart').onclick = () => this.addToCart(product.id);
        // document.getElementById('modalAddToWishlist').onclick = () => this.addToWishlist(product.id);
    }
    
    changeMainImage(imageUrl, index) {
        document.getElementById('modalMainImage').src = imageUrl;
        
        document.querySelectorAll('.thumbnail').forEach((thumb, i) => {
            thumb.classList.toggle('active', i === index);
        });
    }
    
    addToCart(productId) {
        const quantity = document.getElementById('modalQuantity') ? document.getElementById('modalQuantity').value : 1;
        
        console.log(`Adding product ${productId} to cart with quantity ${quantity}`);
        
        this.showNotification('Product added to cart!', 'success');
    }
    
    addToWishlist(productId) {
        console.log(`Adding product ${productId} to wishlist`);
        
        this.showNotification('Product added to wishlist!', 'success');
    }
    
    showNotification(message, type = 'info') {
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
}

// Global functions for modal
function closeProductModal() {
    if (window.marketplaceFilter) {
        window.marketplaceFilter.closeProductModal();
    }
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

function resetAllFilters() {
    if (window.marketplaceFilter) {
        window.marketplaceFilter.resetAllFilters();
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.marketplaceFilter = new MarketplaceFilter();
});

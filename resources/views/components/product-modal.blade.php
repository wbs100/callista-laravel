@props(['product' => null])

<div id="productModal" class="product-modal" style="display: none;">
    <div class="modal-overlay"></div>
    <div class="modal-content">
        <button class="modal-close" id="modalCloseBtn">
            <i class="fas fa-times"></i>
        </button>
        
        <div class="modal-body">
            <div class="product-images">
                <div class="main-image">
                    <img id="modalMainImage" src="" alt="Product Image">
                </div>
                <div class="image-thumbnails" id="modalThumbnails">
                    <!-- Thumbnails will be populated via JavaScript -->
                </div>
            </div>
            
            <div class="product-details">
                <div class="product-header">
                    <h2 id="modalProductName">Product Name</h2>
                    <div class="product-rating" id="modalRating">
                        <!-- Rating stars will be populated via JavaScript -->
                    </div>
                </div>
                
                <div class="product-price" id="modalPrice">
                    <span class="price-current">Rs. 0</span>
                </div>
                
                <div class="product-meta">
                    <div class="meta-item">
                        <span class="label">Category:</span>
                        <span id="modalCategory">-</span>
                    </div>
                    <div class="meta-item">
                        <span class="label">Vendor:</span>
                        <span id="modalVendor">-</span>
                    </div>
                    <div class="meta-item">
                        <span class="label">SKU:</span>
                        <span id="modalSku">-</span>
                    </div>
                    <div class="meta-item">
                        <span class="label">Stock:</span>
                        <span id="modalStock" class="stock-badge">In Stock</span>
                    </div>
                </div>
                
                <div class="product-description">
                    <h4>Description</h4>
                    <p id="modalDescription">Product description will be displayed here.</p>
                </div>
                
                @if($product && $product->tags)
                    <div class="product-tags">
                        <h4>Tags</h4>
                        <div class="tags-list" id="modalTags">
                            <!-- Tags will be populated via JavaScript -->
                        </div>
                    </div>
                @endif
                
                <div class="product-actions">
                    <div class="quantity-selector">
                        <button type="button" onclick="decreaseQuantity()">-</button>
                        <input type="number" id="modalQuantity" value="1" min="1" max="10">
                        <button type="button" onclick="increaseQuantity()">+</button>
                    </div>
                    
                    <button class="btn btn-primary add-to-cart-btn" id="modalAddToCart" style="width: fit-content">
                        <i class="fas fa-shopping-cart"></i>
                        Add to Cart
                    </button>
                    
                    <button class="btn btn-primary add-to-wishlist-btn" id="modalAddToWishlist" style="width: fit-content">
                        <i class="fas fa-heart"></i>
                        Add to Wishlist
                    </button>
                </div>
                
                <div class="product-features">
                    <div class="feature-item">
                        <i class="fas fa-truck"></i>
                        <span>Free delivery for orders over Rs. 50,000</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-shield-alt"></i>
                        <span>5-year warranty included</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-undo"></i>
                        <span>30-day return policy</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.product-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.product-modal.active {
    opacity: 1;
    visibility: visible;
}

.modal-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.modal-content {
    position: relative;
    background: white;
    border-radius: 16px;
    max-width: 1200px;
    max-height: 90vh;
    width: 90%;
    overflow-y: auto;
    transform: scale(0.8);
    transition: transform 0.3s ease;
}

.product-modal.active .modal-content {
    transform: scale(1);
}

.modal-close {
    position: absolute;
    top: 20px;
    right: 20px;
    width: 40px;
    height: 40px;
    border: none;
    background: rgba(0, 0, 0, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 10;
    transition: background 0.2s ease;
}

.modal-close:hover {
    background: rgba(0, 0, 0, 0.2);
}

.modal-body {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    padding: 40px;
}

.product-images {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.main-image img {
    width: 100%;
    height: 400px;
    object-fit: cover;
    border-radius: 12px;
}

.image-thumbnails {
    display: flex;
    gap: 8px;
    overflow-x: auto;
}

.thumbnail {
    width: 80px;
    height: 80px;
    border-radius: 8px;
    overflow: hidden;
    cursor: pointer;
    border: 2px solid transparent;
    transition: border-color 0.2s ease;
}

.thumbnail.active {
    border-color: #8b4513;
}

.thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.product-details {
    display: flex;
    flex-direction: column;
    gap: 24px;
}

.product-header h2 {
    font-size: 2rem;
    font-weight: 700;
    color: #111827;
    margin-bottom: 8px;
}

.product-price {
    display: flex;
    align-items: center;
    gap: 16px;
}

.price-current {
    font-size: 1.5rem;
    font-weight: 700;
    color: #8b4513;
}

.price-original {
    font-size: 1.2rem;
    color: #6b7280;
    text-decoration: line-through;
}

.product-meta {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}

.meta-item {
    display: flex;
    justify-content: space-between;
}

.meta-item .label {
    font-weight: 600;
    color: #6b7280;
}

.stock-badge {
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.stock-badge.in-stock {
    background: #d1fae5;
    color: #065f46;
}

.stock-badge.low-stock {
    background: #fef3c7;
    color: #92400e;
}

.stock-badge.out-of-stock {
    background: #fee2e2;
    color: #991b1b;
}

.product-description h4 {
    font-weight: 600;
    margin-bottom: 8px;
}

.tags-list {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.tag {
    padding: 4px 12px;
    background: #f3f4f6;
    border-radius: 16px;
    font-size: 0.875rem;
    color: #6b7280;
}

.product-actions {
    display: flex;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
}

.quantity-selector {
    display: flex;
    align-items: center;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    overflow: hidden;
}

.quantity-selector button {
    width: 40px;
    height: 40px;
    border: none;
    background: #f9fafb;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s ease;
}

.quantity-selector button:hover {
    background: #f3f4f6;
}

.quantity-selector input {
    width: 60px;
    height: 40px;
    border: none;
    text-align: center;
    outline: none;
}

.product-features {
    display: flex;
    flex-direction: column;
    gap: 12px;
    padding: 20px;
    background: #f9fafb;
    border-radius: 12px;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 12px;
}

.feature-item i {
    color: #8b4513;
    width: 20px;
}

.feature-item span {
    font-size: 0.875rem;
    color: #6b7280;
}

@media (max-width: 768px) {
    .modal-body {
        grid-template-columns: 1fr;
        gap: 24px;
        padding: 24px;
    }
    
    .product-actions {
        flex-direction: column;
        align-items: stretch;
    }
    
    .product-actions .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>

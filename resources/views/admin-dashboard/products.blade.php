@extends('layouts.admin-dashboard')

@section('content')

<div class="dashboard-content">
    <!-- Product Stats - Highlighted Section -->
    <div class="highlighted-section">
        <div class="highlight-badge">Product Analytics</div>
        <h2 class="section-title-highlighted">
            <i class="fas fa-chart-pie"></i>
            Inventory Overview
        </h2>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Total Products</div>
                    <div class="stat-icon primary">
                        <i class="fas fa-box"></i>
                    </div>
                </div>
                <div class="stat-value">{{ count($products) }}</div>
                <div class="stat-change positive">
                    <i class="fas fa-info-circle"></i>
                    <span>All products in catalog</span>
                </div>
            </div>

            <div class="stat-card success">
                <div class="stat-header">
                    <div class="stat-title">In Stock</div>
                    <div class="stat-icon success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $products->where('stock_status', 'in-stock')->count() }}</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>{{ $products->count() > 0 ? round(($products->where('stock_status', 'in-stock')->count() /
                        $products->count()) * 100, 1) : 0 }}% of total inventory</span>
                </div>
            </div>

            <div class="stat-card warning">
                <div class="stat-header">
                    <div class="stat-title">Low Stock</div>
                    <div class="stat-icon warning">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $products->where('stock_status', 'low-stock')->count() }}</div>
                <div class="stat-change neutral">
                    <i class="fas fa-minus"></i>
                    <span>Needs restocking</span>
                </div>
            </div>

            <div class="stat-card info">
                <div class="stat-header">
                    <div class="stat-title">Out of Stock</div>
                    <div class="stat-icon info">
                        <i class="fas fa-times-circle"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $products->where('stock_status', 'out-of-stock')->count() }}</div>
                <div class="stat-change negative">
                    <i class="fas fa-arrow-down"></i>
                    <span>Unavailable products</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Inventory Alerts -->
    <div class="inventory-alerts">
        <div class="alert-title">
            <i class="fas fa-bell"></i>
            Inventory Alerts
        </div>
        <ul class="alert-list">
            <li class="alert-item">
                <span class="stock-indicator stock-low"></span>
                Modern Dining Table - Only 3 units left
            </li>
            <li class="alert-item">
                <span class="stock-indicator stock-low"></span>
                Ergonomic Office Chair - Only 2 units left
            </li>
            <li class="alert-item">
                <span class="stock-indicator stock-medium"></span>
                Luxury Sofa Set - 8 units remaining
            </li>
        </ul>
    </div>

    <!-- Product Filters -->
    <div class="product-filters">
        <div class="filter-row">
            <div class="form-group">
                <label class="form-label">Product Name</label>
                <input type="text" class="form-input" placeholder="Search by name...">
            </div>
            <div class="form-group">
                <label class="form-label">Category</label>
                <select class="form-select">
                    <option value="">All Categories</option>
                    <option value="living-room">Living Room</option>
                    <option value="bedroom">Bedroom</option>
                    <option value="tables">Tables</option>
                    <option value="chairs">Chairs</option>
                    <option value="custom">Custom</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Price Range</label>
                <select class="form-select">
                    <option value="">All Prices</option>
                    <option value="0-50000">LKR 0 - 50,000</option>
                    <option value="50000-100000">LKR 50,000 - 100,000</option>
                    <option value="100000-200000">LKR 100,000 - 200,000</option>
                    <option value="200000+">LKR 200,000+</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Stock Status</label>
                <select class="form-select">
                    <option value="">All Stock</option>
                    <option value="in-stock">In Stock</option>
                    <option value="low-stock">Low Stock</option>
                    <option value="out-of-stock">Out of Stock</option>
                </select>
            </div>
            <button class="btn-filter">
                <i class="fas fa-filter"></i>
                Filter
            </button>
        </div>
    </div>

    <!-- Products Grid - Highlighted Section -->
    <div class="highlighted-section">
        <div class="highlight-badge">Product Catalog</div>
        <div class="product-header" style="justify-content: space-between;">
            <h2 class="section-title-highlighted">
                <i class="fas fa-store"></i>
                Product Inventory
            </h2>
            <a href="#" class="btn-add-product">
                <i class="fas fa-plus"></i>
                Add New Product
            </a>
        </div>

        <div class="product-grid">
            @forelse($products as $product)
            <div class="product-card" data-product-id="{{ $product->id }}">
                <div class="product-image">
                    @if($product->images && $product->images->count() > 0)
                    <img src="{{ asset($product->images->first()->image) }}" alt="{{ $product->name }}">
                    @else
                    <div class="no-image-placeholder">
                        <i class="fas fa-image"></i>
                        <span>No Image</span>
                    </div>
                    @endif

                    @if($product->old_price && $product->old_price > $product->new_price)
                    <div class="product-badge sale">Sale</div>
                    @elseif($product->created_at >= now()->subDays(30))
                    <div class="product-badge">New</div>
                    @else
                    <div class="product-badge featured">Featured</div>
                    @endif
                </div>
                <div class="product-info">
                    <div class="product-category">{{ ucfirst($product->type) }}</div>
                    <h3 class="product-name">{{ $product->name }}</h3>
                    <div class="product-price">
                        <span class="price-current">LKR {{ number_format($product->new_price) }}</span>
                        @if($product->old_price && $product->old_price > $product->new_price)
                        <span class="price-original">LKR {{ number_format($product->old_price) }}</span>
                        @endif
                    </div>
                    <div class="product-stats">
                        <div class="stat-item">
                            <div class="stat-label">Stock Status</div>
                            <div class="stat-value">
                                @php
                                $stockClass = 'stock-medium';
                                if($product->stock_status == 'out-of-stock') $stockClass = 'stock-out';
                                elseif($product->stock_status == 'in-stock') $stockClass = 'stock-high';
                                @endphp
                                <span class="stock-indicator {{ $stockClass }}"></span>
                                {{ ucwords(str_replace('-', ' ', $product->stock_status)) }}
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label">Rating</div>
                            <div class="stat-value">
                                @if($product->rating)
                                {{ $product->rating }}/5 ⭐
                                @else
                                No ratings
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="product-actions">
                        <button class="btn-product btn-edit" title="Edit {{ $product->name }}">
                            <i class="fas fa-edit"></i>
                            Edit
                        </button>
                        <button class="btn-product btn-delete" title="Delete {{ $product->name }}">
                            <i class="fas fa-trash"></i>
                            Delete
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 3rem; color: #666;">
                <i class="fas fa-box-open" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                <h3>No products found</h3>
                <p>Add your first product to get started.</p>
                <a href="#" class="btn-add-product" style="margin-top: 1rem; display: inline-block;">
                    <i class="fas fa-plus"></i>
                    Add Product
                </a>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        {{ $products->links('vendor.pagination.admin-pagination') }}
    </div>
</div>

<!-- Add Product Modal -->
<div id="addProductModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Add New Product</h3>
            <span class="modal-close">&times;</span>
        </div>
        <form id="addProductForm" class="modal-form">
            @csrf
            <div class="form-grid">
                <div class="form-group">
                    <label for="name" class="form-label">Product Name *</label>
                    <input type="text" id="name" name="name" class="form-input" required>
                </div>
                
                <div class="form-group">
                    <label for="type" class="form-label">Category *</label>
                    <select id="type" name="type" class="form-input" required>
                        <option value="">Select Category</option>
                        <option value="Living Room">Living Room</option>
                        <option value="Bedroom">Bedroom</option>
                        <option value="Dining">Dining</option>
                        <option value="Office">Office</option>
                        <option value="Storage">Storage</option>
                        <option value="Kitchen">Kitchen</option>
                        <option value="Outdoor">Outdoor</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="new_price" class="form-label">Current Price (LKR) *</label>
                    <input type="number" id="new_price" name="new_price" class="form-input" min="0" step="0.01" required>
                </div>

                <div class="form-group">
                    <label for="old_price" class="form-label">Original Price (LKR)</label>
                    <input type="number" id="old_price" name="old_price" class="form-input" min="0" step="0.01">
                </div>

                <div class="form-group">
                    <label for="color" class="form-label">Color *</label>
                    <input type="text" id="color" name="color" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="vendor" class="form-label">Vendor *</label>
                    <input type="text" id="vendor" name="vendor" class="form-input" value="Callista Furniture" required>
                </div>

                <div class="form-group">
                    <label for="weight" class="form-label">Weight *</label>
                    <input type="text" id="weight" name="weight" class="form-input" placeholder="e.g., 25 kg" required>
                </div>

                <div class="form-group">
                    <label for="size" class="form-label">Dimensions *</label>
                    <input type="text" id="size" name="size" class="form-input" placeholder="e.g., 120cm x 80cm x 75cm" required>
                </div>

                <div class="form-group">
                    <label for="stock_status" class="form-label">Stock Status *</label>
                    <select id="stock_status" name="stock_status" class="form-input" required>
                        <option value="">Select Status</option>
                        <option value="in_stock">In Stock</option>
                        <option value="out_of_stock">Out of Stock</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="rating" class="form-label">Rating</label>
                    <input type="number" id="rating" name="rating" class="form-input" min="0" max="5" step="1">
                </div>

                <div class="form-group full-width">
                    <label for="product_image" class="form-label">Product Image</label>
                    <div class="image-upload-container">
                        <input type="file" id="product_image" name="product_image" accept="image/*" class="file-input" style="display: none;">
                        <div class="image-upload-area" onclick="document.getElementById('product_image').click();">
                            <div class="upload-placeholder">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <p>Click to upload image</p>
                                <small>JPEG, PNG, JPG or GIF (max 2MB)</small>
                            </div>
                            <img id="image_preview" class="image-preview" style="display: none;">
                        </div>
                    </div>
                </div>

                <div class="form-group full-width">
                    <label for="description" class="form-label">Description *</label>
                    <textarea id="description" name="description" class="form-input" rows="3" required></textarea>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn-secondary modal-cancel">Cancel</button>
                <button type="submit" class="btn-primary">Create Product</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Product Modal -->
<div id="editProductModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Edit Product</h3>
            <span class="modal-close">&times;</span>
        </div>
        <form id="editProductForm" class="modal-form">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit_product_id" name="product_id">
            
            <div class="form-grid">
                <div class="form-group">
                    <label for="edit_name" class="form-label">Product Name *</label>
                    <input type="text" id="edit_name" name="name" class="form-input" required>
                </div>
                
                <div class="form-group">
                    <label for="edit_type" class="form-label">Category *</label>
                    <select id="edit_type" name="type" class="form-input" required>
                        <option value="">Select Category</option>
                        <option value="Living Room">Living Room</option>
                        <option value="Bedroom">Bedroom</option>
                        <option value="Dining">Dining</option>
                        <option value="Office">Office</option>
                        <option value="Storage">Storage</option>
                        <option value="Kitchen">Kitchen</option>
                        <option value="Outdoor">Outdoor</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="edit_new_price" class="form-label">Current Price (LKR) *</label>
                    <input type="number" id="edit_new_price" name="new_price" class="form-input" min="0" step="0.01" required>
                </div>

                <div class="form-group">
                    <label for="edit_old_price" class="form-label">Original Price (LKR)</label>
                    <input type="number" id="edit_old_price" name="old_price" class="form-input" min="0" step="0.01">
                </div>

                <div class="form-group">
                    <label for="edit_color" class="form-label">Color *</label>
                    <input type="text" id="edit_color" name="color" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="edit_vendor" class="form-label">Vendor *</label>
                    <input type="text" id="edit_vendor" name="vendor" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="edit_weight" class="form-label">Weight *</label>
                    <input type="text" id="edit_weight" name="weight" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="edit_size" class="form-label">Dimensions *</label>
                    <input type="text" id="edit_size" name="size" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="edit_stock_status" class="form-label">Stock Status *</label>
                    <select id="edit_stock_status" name="stock_status" class="form-input" required>
                        <option value="">Select Status</option>
                        <option value="in_stock">In Stock</option>
                        <option value="out_of_stock">Out of Stock</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="edit_rating" class="form-label">Rating</label>
                    <input type="number" id="edit_rating" name="rating" class="form-input" min="0" max="5" step="1">
                </div>

                <div class="form-group full-width">
                    <label for="edit_product_image" class="form-label">Product Image</label>
                    <div class="image-upload-container">
                        <input type="file" id="edit_product_image" name="product_image" accept="image/*" class="file-input" style="display: none;">
                        <div class="image-upload-area" onclick="document.getElementById('edit_product_image').click();">
                            <div class="upload-placeholder">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <p>Click to upload new image</p>
                                <small>JPEG, PNG, JPG or GIF (max 2MB)</small>
                            </div>
                            <img id="edit_image_preview" class="image-preview" style="display: none;">
                            <div id="current_image_container" class="current-image" style="display: none;">
                                <img id="current_image" class="image-preview">
                                <div class="image-overlay">
                                    <span>Click to change image</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group full-width">
                    <label for="edit_description" class="form-label">Description *</label>
                    <textarea id="edit_description" name="description" class="form-input" rows="3" required></textarea>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn-secondary modal-cancel">Cancel</button>
                <button type="submit" class="btn-primary">Update Product</button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        backdrop-filter: blur(5px);
    }

    .modal-content {
        background-color: white;
        margin: 2% auto;
        padding: 0;
        border-radius: 12px;
        width: 90%;
        max-width: 800px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        animation: modalSlideIn 0.3s ease-out;
    }

    @keyframes modalSlideIn {
        from { transform: translateY(-50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .modal-header {
        background: var(--gradient-primary);
        color: white;
        padding: 1.5rem 2rem;
        border-radius: 12px 12px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 1.25rem;
    }

    .modal-close {
        font-size: 1.5rem;
        cursor: pointer;
        opacity: 0.8;
        transition: opacity 0.3s;
    }

    .modal-close:hover {
        opacity: 1;
    }

    .modal-form {
        padding: 2rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: var(--dark-color);
    }

    .form-input {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid var(--border-color);
        border-radius: 8px;
        font-size: 1rem;
        transition: border-color 0.3s;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--primary-color);
    }

    textarea.form-input {
        resize: vertical;
        min-height: 100px;
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        padding-top: 1rem;
        border-top: 1px solid var(--border-color);
    }

    .btn-secondary {
        padding: 0.75rem 1.5rem;
        background: var(--light-gray);
        color: var(--gray-color);
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-secondary:hover {
        background: #ddd;
    }

    .btn-primary {
        padding: 0.75rem 1.5rem;
        background: var(--gradient-primary);
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    /* Image Upload Styles */
    .image-upload-container {
        margin-top: 0.5rem;
    }

    .image-upload-area {
        border: 2px dashed var(--border-color);
        border-radius: 8px;
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        background: #fafafa;
        position: relative;
        min-height: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .image-upload-area:hover {
        border-color: var(--primary-color);
        background: #f5f5f5;
    }

    .upload-placeholder {
        color: var(--gray-color);
    }

    .upload-placeholder i {
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
        color: var(--primary-color);
        opacity: 0.7;
    }

    .upload-placeholder p {
        margin: 0.5rem 0;
        font-weight: 500;
        font-size: 1.1rem;
    }

    .upload-placeholder small {
        font-size: 0.875rem;
        color: var(--gray-color);
    }

    .image-preview {
        max-width: 100%;
        max-height: 200px;
        border-radius: 8px;
        object-fit: cover;
    }

    .current-image {
        position: relative;
        display: inline-block;
    }

    .current-image .image-preview {
        opacity: 0.8;
        transition: opacity 0.3s;
    }

    .image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s;
        border-radius: 8px;
    }

    .current-image:hover .image-overlay {
        opacity: 1;
    }

    .current-image:hover .image-preview {
        opacity: 0.6;
    }

    .image-overlay span {
        color: white;
        font-weight: 500;
    }

    .no-image-placeholder {
        width: 100%;
        height: 200px;
        background: #f8f9fa;
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #6c757d;
        font-size: 0.9rem;
    }

    .no-image-placeholder i {
        font-size: 2rem;
        margin-bottom: 0.5rem;
        opacity: 0.5;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Modal controls
        $('.btn-add-product').click(function(e) {
            e.preventDefault();
            $('#addProductModal').fadeIn(300);
        });

        $('.modal-close, .modal-cancel').click(function() {
            $('.modal').fadeOut(300);
            resetForms();
        });

        $(window).click(function(event) {
            if ($(event.target).hasClass('modal')) {
                $('.modal').fadeOut(300);
                resetForms();
            }
        });

        // Image preview handling
        $('#product_image').change(function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#image_preview').attr('src', e.target.result).show();
                    $('.upload-placeholder').hide();
                };
                reader.readAsDataURL(file);
            }
        });

        $('#edit_product_image').change(function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#edit_image_preview').attr('src', e.target.result).show();
                    $('#current_image_container').hide();
                    $('.upload-placeholder').hide();
                };
                reader.readAsDataURL(file);
            }
        });

        // Create Product
        $('#addProductForm').submit(function(e) {
            e.preventDefault();
            
            // Create FormData for file upload
            const formData = new FormData(this);
            
            $.ajax({
                url: '{{ route("admin.products.store") }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        $('#addProductModal').fadeOut(300);
                        showNotification(response.message);
                        resetForms();
                        // Reload the page to refresh the products grid
                        setTimeout(() => window.location.reload(), 1000);
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = 'Please fix the following errors:\n';
                        Object.keys(errors).forEach(field => {
                            errorMessage += `• ${errors[field][0]}\n`;
                        });
                        showNotification(errorMessage, 'error');
                    } else {
                        showNotification('Error creating product. Please try again.', 'error');
                    }
                }
            });
        });

        // Edit Product
        $('.btn-edit').click(function(e) {
            e.preventDefault();
            let productId = $(this).closest('.product-card').data('product-id');
            
            $.ajax({
                url: `/admin/products/${productId}/edit`,
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        let product = response.product;
                        
                        // Populate edit form
                        $('#edit_product_id').val(product.id);
                        $('#edit_name').val(product.name);
                        $('#edit_type').val(product.type);
                        $('#edit_new_price').val(product.new_price);
                        $('#edit_old_price').val(product.old_price);
                        $('#edit_color').val(product.color);
                        $('#edit_vendor').val(product.vendor);
                        $('#edit_weight').val(product.weight);
                        $('#edit_size').val(product.size);
                        $('#edit_stock_status').val(product.stock_status);
                        $('#edit_rating').val(product.rating);
                        $('#edit_description').val(product.description);
                        
                        // Handle current image display
                        if (product.images && product.images.length > 0) {
                            $('#current_image').attr('src', `${window.location.origin}/${product.images[0].image}`);
                            $('#current_image_container').show();
                            $('.upload-placeholder').hide();
                        } else {
                            $('#current_image_container').hide();
                            $('.upload-placeholder').show();
                        }
                        
                        // Reset image previews
                        $('#edit_image_preview').hide();
                        
                        $('#editProductModal').fadeIn(300);
                    }
                },
                error: function() {
                    showNotification('Error loading product data. Please try again.', 'error');
                }
            });
        });

        // Update Product
        $('#editProductForm').submit(function(e) {
            e.preventDefault();
            let productId = $('#edit_product_id').val();
            
            // Create FormData for file upload
            const formData = new FormData(this);
            formData.append('_method', 'PUT');
            
            $.ajax({
                url: `/admin/products/${productId}`,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        $('#editProductModal').fadeOut(300);
                        showNotification(response.message);
                        resetForms();
                        // Reload the page to refresh the products grid
                        setTimeout(() => window.location.reload(), 1000);
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = 'Please fix the following errors:\n';
                        Object.keys(errors).forEach(field => {
                            errorMessage += `• ${errors[field][0]}\n`;
                        });
                        showNotification(errorMessage, 'error');
                    } else {
                        showNotification('Error updating product. Please try again.', 'error');
                    }
                }
            });
        });

        // Delete Product
        $('.btn-delete').click(function(e) {
            e.preventDefault();
            let productId = $(this).closest('.product-card').data('product-id');
            let productName = $(this).closest('.product-card').find('.product-name').text();
            
            Swal.fire({
                title: 'Delete Product',
                text: `Are you sure you want to delete "${productName}"? This action cannot be undone.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/admin/products/${productId}`,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                showNotification(response.message);
                                // Reload the page to refresh the products grid
                                setTimeout(() => window.location.reload(), 1000);
                            }
                        },
                        error: function() {
                            showNotification('Error deleting product. Please try again.', 'error');
                        }
                    });
                }
            });
        });

        function resetForms() {
            $('#addProductForm')[0].reset();
            $('#editProductForm')[0].reset();
            
            // Reset image previews
            $('#image_preview').hide();
            $('#edit_image_preview').hide();
            $('#current_image_container').hide();
            $('.upload-placeholder').show();
        }

        function showNotification(message, type = 'success') {
            // Create notification element
            const notification = $(`
                <div class="notification ${type === 'error' ? 'notification-error' : 'notification-success'}">
                    <i class="fas ${type === 'error' ? 'fa-exclamation-circle' : 'fa-check-circle'}"></i>
                    <span>${message}</span>
                </div>
            `);
            
            // Add to body
            $('body').append(notification);
            
            // Show notification
            setTimeout(() => notification.addClass('show'), 100);
            
            // Hide and remove notification
            setTimeout(() => {
                notification.removeClass('show');
                setTimeout(() => notification.remove(), 300);
            }, 4000);
        }
    });
</script>
@endpush

@endsection
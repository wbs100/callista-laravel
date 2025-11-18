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
                    <span>{{ $products->count() > 0 ? round(($products->where('stock_status', 'in-stock')->count() / $products->count()) * 100, 1) : 0 }}% of total inventory</span>
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
        <div class="product-header">
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
            <div class="product-card">
                <div class="product-image">
                    @if($product->images && $product->images->count() > 0)
                        <img src="{{ asset('storage/' . $product->images->first()->image) }}" alt="{{ $product->name }}">
                    @else
                        <img src="#" alt="{{ $product->name }}">
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
                                    elseif($product->stock_status == 'low-stock') $stockClass = 'stock-low';
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
@endsection
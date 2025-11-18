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
                <div class="stat-value">2,847</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>+12 new products this week</span>
                </div>
            </div>

            <div class="stat-card success">
                <div class="stat-header">
                    <div class="stat-title">In Stock</div>
                    <div class="stat-icon success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
                <div class="stat-value">2,156</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>75.7% of total inventory</span>
                </div>
            </div>

            <div class="stat-card warning">
                <div class="stat-header">
                    <div class="stat-title">Low Stock</div>
                    <div class="stat-icon warning">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                </div>
                <div class="stat-value">127</div>
                <div class="stat-change neutral">
                    <i class="fas fa-minus"></i>
                    <span>Needs restocking</span>
                </div>
            </div>

            <div class="stat-card info">
                <div class="stat-header">
                    <div class="stat-title">Categories</div>
                    <div class="stat-icon info">
                        <i class="fas fa-tags"></i>
                    </div>
                </div>
                <div class="stat-value">24</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>+2 new categories</span>
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
            <!-- Product Card 1 -->
            <div class="product-card">
                <div class="product-image">
                    <img src="../assets/sofa.png" alt="Modern Dining Table">
                    <div class="product-badge featured">Featured</div>
                </div>
                <div class="product-info">
                    <div class="product-category">Tables</div>
                    <h3 class="product-name">Modern Dining Table</h3>
                    <div class="product-price">
                        <span class="price-current">LKR 125,000</span>
                        <span class="price-original">LKR 140,000</span>
                    </div>
                    <div class="product-stats">
                        <div class="stat-item">
                            <div class="stat-label">Stock</div>
                            <div class="stat-value">
                                <span class="stock-indicator stock-low"></span>
                                3 units
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label">Sales</div>
                            <div class="stat-value">147</div>
                        </div>
                    </div>
                    <div class="product-actions">
                        <button class="btn-product btn-edit">
                            <i class="fas fa-edit"></i>
                            Edit
                        </button>
                        <button class="btn-product btn-delete">
                            <i class="fas fa-trash"></i>
                            Delete
                        </button>
                    </div>
                </div>
            </div>

            <!-- Product Card 2 -->
            <div class="product-card">
                <div class="product-image">
                    <img src="../assets/bed.png" alt="Ergonomic Office Chair">
                    <div class="product-badge">Popular</div>
                </div>
                <div class="product-info">
                    <div class="product-category">Chairs</div>
                    <h3 class="product-name">Ergonomic Office Chair</h3>
                    <div class="product-price">
                        <span class="price-current">LKR 45,000</span>
                    </div>
                    <div class="product-stats">
                        <div class="stat-item">
                            <div class="stat-label">Stock</div>
                            <div class="stat-value">
                                <span class="stock-indicator stock-low"></span>
                                2 units
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label">Sales</div>
                            <div class="stat-value">89</div>
                        </div>
                    </div>
                    <div class="product-actions">
                        <button class="btn-product btn-edit">
                            <i class="fas fa-edit"></i>
                            Edit
                        </button>
                        <button class="btn-product btn-delete">
                            <i class="fas fa-trash"></i>
                            Delete
                        </button>
                    </div>
                </div>
            </div>

            <!-- Product Card 3 -->
            <div class="product-card">
                <div class="product-image">
                    <img src="../assets/funi (1).jpeg" alt="Luxury Sofa Set">
                    <div class="product-badge sale">Sale</div>
                </div>
                <div class="product-info">
                    <div class="product-category">Living Room</div>
                    <h3 class="product-name">Luxury Sofa Set</h3>
                    <div class="product-price">
                        <span class="price-current">LKR 185,000</span>
                        <span class="price-original">LKR 210,000</span>
                    </div>
                    <div class="product-stats">
                        <div class="stat-item">
                            <div class="stat-label">Stock</div>
                            <div class="stat-value">
                                <span class="stock-indicator stock-medium"></span>
                                8 units
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label">Sales</div>
                            <div class="stat-value">234</div>
                        </div>
                    </div>
                    <div class="product-actions">
                        <button class="btn-product btn-edit">
                            <i class="fas fa-edit"></i>
                            Edit
                        </button>
                        <button class="btn-product btn-delete">
                            <i class="fas fa-trash"></i>
                            Delete
                        </button>
                    </div>
                </div>
            </div>

            <!-- Product Card 4 -->
            <div class="product-card">
                <div class="product-image">
                    <img src="../assets/funi (2).jpeg" alt="Complete Bedroom Set">
                    <div class="product-badge">New</div>
                </div>
                <div class="product-info">
                    <div class="product-category">Bedroom</div>
                    <h3 class="product-name">Complete Bedroom Set</h3>
                    <div class="product-price">
                        <span class="price-current">LKR 275,000</span>
                    </div>
                    <div class="product-stats">
                        <div class="stat-item">
                            <div class="stat-label">Stock</div>
                            <div class="stat-value">
                                <span class="stock-indicator stock-high"></span>
                                15 units
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label">Sales</div>
                            <div class="stat-value">67</div>
                        </div>
                    </div>
                    <div class="product-actions">
                        <button class="btn-product btn-edit">
                            <i class="fas fa-edit"></i>
                            Edit
                        </button>
                        <button class="btn-product btn-delete">
                            <i class="fas fa-trash"></i>
                            Delete
                        </button>
                    </div>
                </div>
            </div>

            <!-- Product Card 5 -->
            <div class="product-card">
                <div class="product-image">
                    <img src="../assets/sofa.png" alt="Designer Coffee Table">
                    <div class="product-badge featured">Featured</div>
                </div>
                <div class="product-info">
                    <div class="product-category">Tables</div>
                    <h3 class="product-name">Designer Coffee Table</h3>
                    <div class="product-price">
                        <span class="price-current">LKR 65,000</span>
                        <span class="price-original">LKR 75,000</span>
                    </div>
                    <div class="product-stats">
                        <div class="stat-item">
                            <div class="stat-label">Stock</div>
                            <div class="stat-value">
                                <span class="stock-indicator stock-high"></span>
                                22 units
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label">Sales</div>
                            <div class="stat-value">156</div>
                        </div>
                    </div>
                    <div class="product-actions">
                        <button class="btn-product btn-edit">
                            <i class="fas fa-edit"></i>
                            Edit
                        </button>
                        <button class="btn-product btn-delete">
                            <i class="fas fa-trash"></i>
                            Delete
                        </button>
                    </div>
                </div>
            </div>

            <!-- Product Card 6 -->
            <div class="product-card">
                <div class="product-image">
                    <img src="../assets/bed.png" alt="Dining Chairs Set">
                    <div class="product-badge">Popular</div>
                </div>
                <div class="product-info">
                    <div class="product-category">Chairs</div>
                    <h3 class="product-name">Dining Chairs Set (4)</h3>
                    <div class="product-price">
                        <span class="price-current">LKR 95,000</span>
                    </div>
                    <div class="product-stats">
                        <div class="stat-item">
                            <div class="stat-label">Stock</div>
                            <div class="stat-value">
                                <span class="stock-indicator stock-high"></span>
                                18 units
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label">Sales</div>
                            <div class="stat-value">123</div>
                        </div>
                    </div>
                    <div class="product-actions">
                        <button class="btn-product btn-edit">
                            <i class="fas fa-edit"></i>
                            Edit
                        </button>
                        <button class="btn-product btn-delete">
                            <i class="fas fa-trash"></i>
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
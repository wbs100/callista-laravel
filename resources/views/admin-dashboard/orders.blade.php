@extends('layouts.admin-dashboard')

@section('content')

<div class="dashboard-content">
    <!-- Order Stats - Highlighted Section -->
    <div class="highlighted-section">
        <div class="highlight-badge">Order Analytics</div>
        <h2 class="section-title-highlighted">
            <i class="fas fa-chart-line"></i>
            Order Overview
        </h2>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Total Orders</div>
                    <div class="stat-icon primary">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                </div>
                <div class="stat-value">1,247</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>+23 today</span>
                </div>
            </div>

            <div class="stat-card success">
                <div class="stat-header">
                    <div class="stat-title">Revenue</div>
                    <div class="stat-icon success">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>
                <div class="stat-value">LKR 1.2M</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>+18% this month</span>
                </div>
            </div>

            <div class="stat-card warning">
                <div class="stat-header">
                    <div class="stat-title">Pending</div>
                    <div class="stat-icon warning">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
                <div class="stat-value">23</div>
                <div class="stat-change neutral">
                    <i class="fas fa-minus"></i>
                    <span>Needs attention</span>
                </div>
            </div>

            <div class="stat-card info">
                <div class="stat-header">
                    <div class="stat-title">Avg Order Value</div>
                    <div class="stat-icon info">
                        <i class="fas fa-calculator"></i>
                    </div>
                </div>
                <div class="stat-value">LKR 95K</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>+12% from last month</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Status Summary -->
    <div class="order-summary-cards">
        <div class="summary-card">
            <div class="summary-icon summary-pending">
                <i class="fas fa-clock"></i>
            </div>
            <div class="summary-value">23</div>
            <div class="summary-label">Pending Orders</div>
        </div>
        <div class="summary-card">
            <div class="summary-icon summary-processing">
                <i class="fas fa-cogs"></i>
            </div>
            <div class="summary-value">45</div>
            <div class="summary-label">Processing</div>
        </div>
        <div class="summary-card">
            <div class="summary-icon summary-shipped">
                <i class="fas fa-truck"></i>
            </div>
            <div class="summary-value">67</div>
            <div class="summary-label">Shipped</div>
        </div>
        <div class="summary-card">
            <div class="summary-icon summary-delivered">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="summary-value">1,112</div>
            <div class="summary-label">Delivered</div>
        </div>
    </div>

    <!-- Priority Orders Alert -->
    <div class="priority-orders">
        <div class="priority-title">
            <i class="fas fa-exclamation-triangle"></i>
            Priority Orders
        </div>
        <ul class="priority-list">
            <li class="priority-item">
                <span>
                    <span class="priority-order-id">#ORD-2024-001</span> - High-value customer order
                </span>
                <span class="priority-reason">VIP Customer</span>
            </li>
            <li class="priority-item">
                <span>
                    <span class="priority-order-id">#ORD-2024-008</span> - Custom furniture order
                </span>
                <span class="priority-reason">Custom Order</span>
            </li>
            <li class="priority-item">
                <span>
                    <span class="priority-order-id">#ORD-2024-015</span> - Express delivery requested
                </span>
                <span class="priority-reason">Express</span>
            </li>
        </ul>
    </div>

    <!-- Order Filters -->
    <div class="order-filters">
        <div class="filter-row">
            <div class="form-group">
                <label class="form-label">Order ID</label>
                <input type="text" class="form-input" placeholder="Search by order ID...">
            </div>
            <div class="form-group">
                <label class="form-label">Customer</label>
                <input type="text" class="form-input" placeholder="Search by customer...">
            </div>
            <div class="form-group">
                <label class="form-label">Status</label>
                <select class="form-select">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="shipped">Shipped</option>
                    <option value="delivered">Delivered</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Date Range</label>
                <select class="form-select">
                    <option value="">All Dates</option>
                    <option value="today">Today</option>
                    <option value="week">This Week</option>
                    <option value="month">This Month</option>
                    <option value="custom">Custom Range</option>
                </select>
            </div>
            <button class="btn-filter">
                <i class="fas fa-filter"></i>
                Filter
            </button>
        </div>
    </div>

    <!-- Orders Table - Highlighted Section -->
    <div class="highlighted-section">
        <div class="highlight-badge">Order Management</div>
        <div class="order-header">
            <h2 class="section-title-highlighted">
                <i class="fas fa-list-alt"></i>
                Order History
            </h2>
            <a href="#" class="btn-export">
                <i class="fas fa-download"></i>
                Export Orders
            </a>
        </div>

        <div class="orders-table">
            <div class="table-header">Recent Orders</div>
            <div class="orders-table-content">
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Products</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Order Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <a href="#" class="order-id">#ORD-2024-001</a>
                            </td>
                            <td>
                                <div class="customer-info">
                                    <div class="customer-avatar">AM</div>
                                    <div class="customer-details">
                                        <div class="customer-name">Amara Mendis</div>
                                        <div class="customer-email">amara@email.com</div>
                                    </div>
                                </div>
                            </td>
                            <td>Modern Dining Table, Chair Set</td>
                            <td class="order-amount">LKR 220,000</td>
                            <td>
                                <span class="order-status status-shipped">Shipped</span>
                            </td>
                            <td class="order-date">2024-01-15</td>
                            <td>
                                <div class="order-actions">
                                    <button class="btn-action btn-view" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn-action btn-edit-order" title="Edit Order">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-action btn-delete-order" title="Delete Order">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <a href="#" class="order-id">#ORD-2024-002</a>
                            </td>
                            <td>
                                <div class="customer-info">
                                    <div class="customer-avatar">KS</div>
                                    <div class="customer-details">
                                        <div class="customer-name">Kasun Silva</div>
                                        <div class="customer-email">kasun@email.com</div>
                                    </div>
                                </div>
                            </td>
                            <td>Luxury Sofa Set</td>
                            <td class="order-amount">LKR 185,000</td>
                            <td>
                                <span class="order-status status-processing">Processing</span>
                            </td>
                            <td class="order-date">2024-01-14</td>
                            <td>
                                <div class="order-actions">
                                    <button class="btn-action btn-view" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn-action btn-edit-order" title="Edit Order">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-action btn-delete-order" title="Delete Order">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <a href="#" class="order-id">#ORD-2024-003</a>
                            </td>
                            <td>
                                <div class="customer-info">
                                    <div class="customer-avatar">NP</div>
                                    <div class="customer-details">
                                        <div class="customer-name">Nimali Perera</div>
                                        <div class="customer-email">nimali@email.com</div>
                                    </div>
                                </div>
                            </td>
                            <td>Complete Bedroom Set</td>
                            <td class="order-amount">LKR 275,000</td>
                            <td>
                                <span class="order-status status-delivered">Delivered</span>
                            </td>
                            <td class="order-date">2024-01-13</td>
                            <td>
                                <div class="order-actions">
                                    <button class="btn-action btn-view" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn-action btn-edit-order" title="Edit Order">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-action btn-delete-order" title="Delete Order">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <a href="#" class="order-id">#ORD-2024-004</a>
                            </td>
                            <td>
                                <div class="customer-info">
                                    <div class="customer-avatar">RJ</div>
                                    <div class="customer-details">
                                        <div class="customer-name">Roshan Jayasinghe</div>
                                        <div class="customer-email">roshan@email.com</div>
                                    </div>
                                </div>
                            </td>
                            <td>Designer Coffee Table</td>
                            <td class="order-amount">LKR 65,000</td>
                            <td>
                                <span class="order-status status-pending">Pending</span>
                            </td>
                            <td class="order-date">2024-01-12</td>
                            <td>
                                <div class="order-actions">
                                    <button class="btn-action btn-view" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn-action btn-edit-order" title="Edit Order">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-action btn-delete-order" title="Delete Order">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <a href="#" class="order-id">#ORD-2024-005</a>
                            </td>
                            <td>
                                <div class="customer-info">
                                    <div class="customer-avatar">SW</div>
                                    <div class="customer-details">
                                        <div class="customer-name">Saman Wickramasinghe</div>
                                        <div class="customer-email">saman@email.com</div>
                                    </div>
                                </div>
                            </td>
                            <td>Ergonomic Office Chair</td>
                            <td class="order-amount">LKR 45,000</td>
                            <td>
                                <span class="order-status status-shipped">Shipped</span>
                            </td>
                            <td class="order-date">2024-01-11</td>
                            <td>
                                <div class="order-actions">
                                    <button class="btn-action btn-view" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn-action btn-edit-order" title="Edit Order">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-action btn-delete-order" title="Delete Order">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <a href="#" class="order-id">#ORD-2024-006</a>
                            </td>
                            <td>
                                <div class="customer-info">
                                    <div class="customer-avatar">TD</div>
                                    <div class="customer-details">
                                        <div class="customer-name">Tharaka De Silva</div>
                                        <div class="customer-email">tharaka@email.com</div>
                                    </div>
                                </div>
                            </td>
                            <td>Dining Chairs Set (4)</td>
                            <td class="order-amount">LKR 95,000</td>
                            <td>
                                <span class="order-status status-cancelled">Cancelled</span>
                            </td>
                            <td class="order-date">2024-01-10</td>
                            <td>
                                <div class="order-actions">
                                    <button class="btn-action btn-view" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn-action btn-edit-order" title="Edit Order">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-action btn-delete-order" title="Delete Order">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
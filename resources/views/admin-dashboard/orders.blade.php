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
                <div class="stat-value">{{ count($orders) }}</div>
                <div class="stat-change positive">
                    <i class="fas fa-info-circle"></i>
                    <span>All orders placed</span>
                </div>
            </div>

            <div class="stat-card success">
                <div class="stat-header">
                    <div class="stat-title">Revenue</div>
                    <div class="stat-icon success">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>
                @php
                    $totalRevenue = 0;
                    foreach($orders as $order) {
                        if(isset($order->cart_data) && is_array($order->cart_data)) {
                            foreach($order->cart_data as $item) {
                                $totalRevenue += isset($item['price']) ? $item['price'] * (isset($item['quantity']) ? $item['quantity'] : 1) : 0;
                            }
                        }
                    }
                @endphp
                <div class="stat-value">LKR {{ number_format($totalRevenue / 1000) }}K</div>
                <div class="stat-change positive">
                    <i class="fas fa-chart-line"></i>
                    <span>Total sales</span>
                </div>
            </div>

            <div class="stat-card warning">
                <div class="stat-header">
                    <div class="stat-title">Pending</div>
                    <div class="stat-icon warning">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $orders->where('status', 'pending')->count() }}</div>
                <div class="stat-change neutral">
                    <i class="fas fa-minus"></i>
                    <span>Needs attention</span>
                </div>
            </div>

            <div class="stat-card info">
                <div class="stat-header">
                    <div class="stat-title">Delivered</div>
                    <div class="stat-icon info">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $orders->where('status', 'delivered')->count() }}</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>Completed orders</span>
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
            <div class="summary-value">{{ $orders->where('status', 'pending')->count() }}</div>
            <div class="summary-label">Pending Orders</div>
        </div>
        <div class="summary-card">
            <div class="summary-icon summary-processing">
                <i class="fas fa-cogs"></i>
            </div>
            <div class="summary-value">{{ $orders->where('status', 'processing')->count() }}</div>
            <div class="summary-label">Processing</div>
        </div>
        <div class="summary-card">
            <div class="summary-icon summary-shipped">
                <i class="fas fa-truck"></i>
            </div>
            <div class="summary-value">{{ $orders->where('status', 'shipped')->count() }}</div>
            <div class="summary-label">Shipped</div>
        </div>
        <div class="summary-card">
            <div class="summary-icon summary-delivered">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="summary-value">{{ $orders->where('status', 'delivered')->count() }}</div>
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
                        @forelse($orders as $order)
                            <tr>
                                <td>
                                    <a href="#" class="order-id">#ORD-{{ $order->id }}</a>
                                </td>
                                <td>
                                    <div class="customer-info">
                                        <div class="customer-avatar">
                                            {{ strtoupper(substr($order->user->name, 0, 2)) }}
                                        </div>
                                        <div class="customer-details">
                                            <div class="customer-name">{{ $order->user->name }}</div>
                                            <div class="customer-email">{{ $order->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $order->product_details ?? 'N/A' }}</td>
                                <td class="order-amount">LKR {{ number_format($order->total_amount, 0) }}</td>
                                <td>
                                    <span class="order-status status-{{ strtolower($order->status) }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="order-date">{{ $order->created_at->format('Y-m-d') }}</td>
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
                        @empty
                            <tr>
                                <td colspan="7" class="text-center" style="padding: 40px;">
                                    <div style="opacity: 0.6;">
                                        <i class="fas fa-shopping-cart" style="font-size: 2rem; margin-bottom: 10px;"></i>
                                        <p>No orders found</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
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
                        if(isset($order->cart_data['total'])) {
                            $totalRevenue += $order->cart_data['total'];
                        }
                    }
                @endphp
                <div class="stat-value">LKR {{ number_format($totalRevenue / 1000, 1) }}K</div>
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
                @php
                    $allOrders = $orders->getCollection(); // Get the filtered collection
                    
                    $pendingCount = $allOrders->filter(function($order) {
                        return $order->status === false || $order->status === 0 || $order->status === 'pending' || 
                               (isset($order->payment_data['status']) && $order->payment_data['status'] === 'pending');
                    })->count();
                    
                    $completedCount = $allOrders->filter(function($order) {
                        return $order->status === true || $order->status === 1 || $order->status === 'completed' || $order->status === 'delivered';
                    })->count();
                @endphp
                <div class="stat-value">{{ $pendingCount }}</div>
                <div class="stat-change neutral">
                    <i class="fas fa-minus"></i>
                    <span>Needs attention</span>
                </div>
            </div>

            <div class="stat-card info">
                <div class="stat-header">
                    <div class="stat-title">Completed</div>
                    <div class="stat-icon info">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $completedCount }}</div>
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
            <div class="summary-value">{{ $orders->where('status', '0')->count() }}</div>
            <div class="summary-label">Pending Orders</div>
        </div>
        {{-- <div class="summary-card">
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
        </div> --}}
        <div class="summary-card">
            <div class="summary-icon summary-delivered">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="summary-value">{{ $orders->where('status', '1')->count() }}</div>
            <div class="summary-label">Completed</div>
        </div>
    </div>

    <!-- Priority Orders Alert (hidden)-->
    {{-- <div class="priority-orders">
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
    </div> --}}

    <!-- Order Filters -->
    <div class="order-filters">
        <div class="filter-row">
            <div class="form-group">
                <label class="form-label">Order ID</label>
                <input type="text" id="filterOrderId" class="form-input" placeholder="Search by order ID..." value="{{ request('order_id') }}">
            </div>
            <div class="form-group">
                <label class="form-label">Customer</label>
                <input type="text" id="filterCustomer" class="form-input" placeholder="Search by customer..." value="{{ request('customer') }}">
            </div>
            <div class="form-group">
                <label class="form-label">Status</label>
                <select id="filterStatus" class="form-select">
                    <option value="">All Status</option>
                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Pending</option>
                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Date Range</label>
                <select id="filterDateRange" class="form-select">
                    <option value="">All Dates</option>
                    <option value="today" {{ request('date_range') == 'today' ? 'selected' : '' }}>Today</option>
                    <option value="week" {{ request('date_range') == 'week' ? 'selected' : '' }}>This Week</option>
                    <option value="month" {{ request('date_range') == 'month' ? 'selected' : '' }}>This Month</option>
                    <option value="custom" {{ request('date_range') == 'custom' ? 'selected' : '' }}>Custom Range</option>
                </select>
            </div>
            <div class="form-group custom-date-inputs" style="display: {{ request('date_range') == 'custom' ? 'block' : 'none' }};">
                <label class="form-label">Custom Date Range</label>
                <div style="display: flex; gap: 10px;">
                    <input type="date" id="filterDateFrom" class="form-input" placeholder="From" value="{{ request('date_from') }}" style="flex: 1;">
                    <input type="date" id="filterDateTo" class="form-input" placeholder="To" value="{{ request('date_to') }}" style="flex: 1;">
                </div>
            </div>
            <div class="filter-actions">
                <button class="btn-filter" onclick="applyFilters()">
                    <i class="fas fa-filter"></i>
                    Filter
                </button>
                <button class="btn-clear-filter" onclick="clearFilters()">
                    <i class="fas fa-times"></i>
                    Clear
                </button>
            </div>
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
            <div class="table-header">
                Recent Orders
                @if(request()->hasAny(['order_id', 'customer', 'status', 'date_range']))
                    <span class="filter-indicator">
                        <i class="fas fa-filter"></i>
                        Filtered Results ({{ $orders->total() }} found)
                        <button class="clear-filters-btn" onclick="clearFilters()" title="Clear all filters">
                            <i class="fas fa-times"></i>
                        </button>
                    </span>
                @else
                    <span class="total-count">({{ $orders->total() }} total)</span>
                @endif
            </div>
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
                                    <a href="#" class="order-id">#{{ $order->id }}</a>
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
                                <td>
                                    <div class="products-list">
                                        @if(isset($order->cart_data['items']) && is_array($order->cart_data['items']))
                                            @foreach($order->cart_data['items'] as $item)
                                                <div class="product-item">
                                                    <span class="product-name m-0">{{ $item['product']['name'] ?? 'Unknown Product' }}</span>
                                                    <span class="product-quantity">×{{ $item['quantity'] ?? 1 }}</span>
                                                </div>
                                            @endforeach
                                        @else
                                            <span class="text-muted">No products</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="order-amount text-nowrap">
                                    LKR {{ number_format($order->cart_data['total'] ?? 0) }}
                                    @if(isset($order->cart_data['discount']) && $order->cart_data['discount'] > 0)
                                        <small class="discount-info text-nowrap">
                                            <br><span class="text-success">-LKR {{ number_format($order->cart_data['discount']) }} saved</span>
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        // Handle different status formats
                                        if (is_bool($order->status)) {
                                            $status = $order->status ? 'completed' : 'pending';
                                            $statusText = $order->status ? 'Completed' : 'Pending';
                                        } elseif (is_numeric($order->status)) {
                                            $status = $order->status == 1 ? 'completed' : 'pending';
                                            $statusText = $order->status == 1 ? 'Completed' : 'Pending';
                                        } else {
                                            $status = $order->status ?? 'pending';
                                            // Convert status to display text
                                            $statusText = match($status) {
                                                'processing' => 'Processing',
                                                'shipped' => 'Shipped', 
                                                'delivered' => 'Delivered',
                                                'cancelled' => 'Cancelled',
                                                'payment_pending' => 'Payment Pending',
                                                'payment_failed' => 'Payment Failed',
                                                'refunded' => 'Refunded',
                                                'completed' => 'Completed',
                                                default => 'Pending'
                                            };
                                        }
                                        
                                        // Check payment data for additional context
                                        if (isset($order->payment_data['status']) && $order->payment_data['status'] === 'pending' && $status === 'pending') {
                                            $status = 'payment_pending';
                                            $statusText = 'Payment Pending';
                                        }
                                    @endphp
                                    <span class="order-status text-nowrap status-{{ strtolower(str_replace(['_', ' '], '-', $status)) }}">
                                        {{ $statusText }}
                                    </span>
                                </td>
                                <td class="order-date text-nowrap">{{ $order->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <div class="order-actions">
                                        <button class="btn-action btn-view" title="View Details" 
                                                onclick="viewOrderDetails({{ $order->id }})">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn-action btn-edit-order" title="Edit Order Status" 
                                                onclick="editOrderStatus({{ $order->id }}, '{{ $status }}')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn-action btn-delete-order" title="Delete Order" 
                                                onclick="deleteOrder({{ $order->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center" style="padding: 40px;">
                                    <div style="opacity: 0.6;">
                                        @if(request()->hasAny(['order_id', 'customer', 'status', 'date_range']))
                                            <i class="fas fa-filter" style="font-size: 2rem; margin-bottom: 10px; color: #667eea;"></i>
                                            <p>No orders match your filters</p>
                                            <button class="btn-clear-filter" onclick="clearFilters()" style="margin-top: 16px;">
                                                <i class="fas fa-times"></i>
                                                Clear Filters
                                            </button>
                                        @else
                                            <i class="fas fa-shopping-cart" style="font-size: 2rem; margin-bottom: 10px;"></i>
                                            <p>No orders found</p>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            {{ $orders->links('vendor.pagination.admin-pagination') }}
        </div>
    </div>
</div>

<!-- Order Details Modal -->
<div id="orderDetailsModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2><i class="fas fa-receipt"></i> Order Details</h2>
            <span class="close" onclick="closeModal('orderDetailsModal')">&times;</span>
        </div>
        <div class="modal-body" id="orderDetailsContent">
            <!-- Order details will be loaded here -->
        </div>
    </div>
</div>

<!-- Edit Order Status Modal -->
<div id="editOrderModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2><i class="fas fa-edit"></i> Edit Order Status</h2>
            <span class="close" onclick="closeModal('editOrderModal')">&times;</span>
        </div>
        <div class="modal-body">
            <form id="editOrderForm">
                <input type="hidden" id="editOrderId">
                <div class="form-group">
                    <label class="form-label">Order Status</label>
                    <select id="editOrderStatus" class="form-select">
                        <option value="0">Pending</option>
                        <option value="1">Completed</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Payment Mode</label>
                    <select id="editPaymentMode" class="form-select">
                        <option value="">Select Payment Mode</option>
                        <option value="card_payment">Credit/Debit Card</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="cash_on_delivery">Cash on Delivery</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Order Notes</label>
                    <textarea id="editOrderNotes" class="form-input" rows="3" placeholder="Add any notes about this order..."></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Contact Information</label>
                    <input type="text" id="editContactInfo" class="form-input" placeholder="Customer contact information">
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn-secondary" onclick="closeModal('editOrderModal')">Cancel</button>
                    <button type="submit" class="btn-primary">Update Order</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Product List Styles */
.products-list {
    max-width: 200px;
}

.product-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 4px;
    padding: 2px 0;
}

.product-name {
    font-size: 0.9rem;
    color: #374151;
    flex: 1;
    margin-right: 8px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.product-quantity {
    font-size: 0.8rem;
    color: #6b7280;
    font-weight: 600;
    background: #f3f4f6;
    padding: 1px 6px;
    border-radius: 12px;
}

.discount-info {
    font-size: 0.75rem;
    color: #059669 !important;
}

/* Status Styles */
.order-status {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: capitalize;
}

.status-pending,
.status-payment-pending {
    background: #fef3c7;
    color: #92400e;
}

.status-processing {
    background: #dbeafe;
    color: #1e40af;
}

.status-shipped {
    background: #e0e7ff;
    color: #3730a3;
}

.status-completed,
.status-delivered {
    background: #d1fae5;
    color: #065f46;
}

.status-cancelled {
    background: #fee2e2;
    color: #991b1b;
}

.status-payment-failed {
    background: #fecaca;
    color: #b91c1c;
}

.status-refunded {
    background: #f3e8ff;
    color: #7c3aed;
}

/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    animation: fadeIn 0.3s ease;
}

.modal-content {
    background-color: white;
    margin: 5% auto;
    padding: 0;
    border-radius: 12px;
    width: 90%;
    max-width: 600px;
    max-height: 80vh;
    overflow: hidden;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    animation: slideIn 0.3s ease;
}

.modal-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 20px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h2 {
    margin: 0;
    font-size: 1.5rem;
    display: flex;
    align-items: center;
    gap: 10px;
}

.close {
    color: white;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
    transition: opacity 0.3s;
}

.close:hover {
    opacity: 0.7;
}

.modal-body {
    padding: 30px;
    max-height: 60vh;
    overflow-y: auto;
}

.modal-actions {
    display: flex;
    gap: 12px;
    justify-content: flex-end;
    margin-top: 24px;
}

.btn-secondary,
.btn-primary {
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-secondary {
    background: #f3f4f6;
    color: #374151;
}

.btn-secondary:hover {
    background: #e5e7eb;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideIn {
    from { transform: translateY(-50px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

/* Form Styles */
.form-group {
    margin-bottom: 0px;
}

.form-label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #374151;
}

.form-select,
.form-input {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.3s ease;
}

.form-select:focus,
.form-input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

textarea.form-input {
    resize: vertical;
    min-height: 80px;
}

/* SweetAlert Custom Styles */
.swal2-popup.swal-popup {
    border-radius: 12px !important;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
}

.swal2-title.swal-title {
    font-size: 1.5rem !important;
    font-weight: 700 !important;
    color: #374151 !important;
}

.swal2-content.swal-content {
    font-size: 1rem !important;
    color: #6b7280 !important;
}

.swal2-confirm.swal-confirm-btn {
    background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%) !important;
    border: none !important;
    border-radius: 8px !important;
    padding: 12px 24px !important;
    font-weight: 600 !important;
    font-size: 0.95rem !important;
    transition: all 0.3s ease !important;
}

.swal2-confirm.swal-confirm-btn:hover {
    transform: translateY(-1px) !important;
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3) !important;
}

.swal2-cancel.swal-cancel-btn {
    background: #f3f4f6 !important;
    color: #374151 !important;
    border: none !important;
    border-radius: 8px !important;
    padding: 12px 24px !important;
    font-weight: 600 !important;
    font-size: 0.95rem !important;
    transition: all 0.3s ease !important;
}

.swal2-cancel.swal-cancel-btn:hover {
    background: #e5e7eb !important;
    transform: translateY(-1px) !important;
}

.swal2-icon.swal2-warning {
    border-color: #f59e0b !important;
    color: #f59e0b !important;
}

.swal2-icon.swal2-success {
    border-color: #059669 !important;
    color: #059669 !important;
}

.swal2-icon.swal2-error {
    border-color: #dc2626 !important;
    color: #dc2626 !important;
}

/* Loading animation for SweetAlert */
.swal2-loader {
    border-color: #667eea transparent #667eea transparent !important;
}

/* Filter Styles */
.order-filters {
    background: white;
    padding: 24px;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    margin-bottom: 24px;
}

.filter-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    align-items: end;
}

.filter-actions {
    display: flex;
    gap: 10px;
    align-items: end;
    margin-bottom: 0px;
}

.btn-filter,
.btn-clear-filter {
    padding: 12px 20px;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
    white-space: nowrap;
}

.btn-filter {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-filter:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.btn-clear-filter {
    background: #f3f4f6;
    color: #374151;
    border: 1px solid #e5e7eb;
}

.btn-clear-filter:hover {
    background: #e5e7eb;
    transform: translateY(-1px);
}

.custom-date-inputs {
    grid-column: span 2;
}

/* Filter indicator styles */
.table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 24px;
    background: #f8fafc;
    border-bottom: 1px solid #e5e7eb;
    font-weight: 600;
}

.filter-indicator {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #667eea;
    font-size: 0.9rem;
    font-weight: 500;
}

.clear-filters-btn {
    background: #fee2e2;
    color: #dc2626;
    border: none;
    border-radius: 4px;
    padding: 4px 8px;
    cursor: pointer;
    font-size: 0.8rem;
    transition: all 0.2s ease;
}

.clear-filters-btn:hover {
    background: #fecaca;
    transform: scale(1.05);
}

.total-count {
    color: #6b7280;
    font-size: 0.9rem;
    font-weight: 500;
}

@media (max-width: 768px) {
    .filter-row {
        grid-template-columns: 1fr;
    }
    
    .custom-date-inputs {
        grid-column: span 1;
    }
    
    .filter-actions {
        justify-content: stretch;
    }
    
    .btn-filter,
    .btn-clear-filter {
        flex: 1;
        justify-content: center;
    }
    
    .table-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
    
    .filter-indicator,
    .total-count {
        font-size: 0.8rem;
    }
}
</style>

<script>
// Order management functions
function viewOrderDetails(orderId) {
    // Show loading state
    document.getElementById('orderDetailsContent').innerHTML = `
        <div style="text-align: center; padding: 40px;">
            <i class="fas fa-spinner fa-spin" style="font-size: 2rem; color: #667eea;"></i>
            <p style="margin-top: 16px; color: #6b7280;">Loading order details...</p>
        </div>
    `;
    
    document.getElementById('orderDetailsModal').style.display = 'block';
    
    // Fetch order details (you'll need to create this route)
    fetch(`/admin/orders/${orderId}/details`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('orderDetailsContent').innerHTML = formatOrderDetails(data.order);
            } else {
                document.getElementById('orderDetailsContent').innerHTML = `
                    <div style="text-align: center; padding: 40px; color: #ef4444;">
                        <i class="fas fa-exclamation-triangle" style="font-size: 2rem; margin-bottom: 16px;"></i>
                        <p>Error loading order details</p>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('orderDetailsContent').innerHTML = `
                <div style="text-align: center; padding: 40px; color: #ef4444;">
                    <i class="fas fa-exclamation-triangle" style="font-size: 2rem; margin-bottom: 16px;"></i>
                    <p>Error loading order details</p>
                </div>
            `;
        });
}

function formatOrderDetails(order) {
    let itemsHtml = '';
    if (order.cart_data && order.cart_data.items) {
        itemsHtml = order.cart_data.items.map(item => `
            <div style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #f3f4f6;">
                <div>
                    <div style="font-weight: 600; color: #374151;">${item.product.name}</div>
                    <div style="font-size: 0.9rem; color: #6b7280;">Quantity: ${item.quantity}</div>
                    <div style="font-size: 0.9rem; color: #6b7280;">Unit Price: LKR ${parseInt(item.price).toLocaleString()}</div>
                </div>
                <div style="font-weight: 600; color: #374151;">
                    LKR ${parseInt(item.total).toLocaleString()}
                </div>
            </div>
        `).join('');
    }

    return `
        <div class="order-details-content">
            <div class="detail-section">
                <h3 style="color: #374151; margin-bottom: 16px;">
                    <i class="fas fa-info-circle"></i> Order Information
                </h3>
                <div class="detail-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
                    <div>
                        <strong>Order ID:</strong> #${order.id}<br>
                        <strong>Customer:</strong> ${order.user.name}<br>
                        <strong>Email:</strong> ${order.user.email}
                    </div>
                    <div>
                        <strong>Order Date:</strong> ${new Date(order.created_at).toLocaleDateString()}<br>
                        <strong>Payment Mode:</strong> ${order.payment_mode || 'N/A'}<br>
                        <strong>Contact:</strong> ${order.contact_info || 'N/A'}
                    </div>
                </div>
            </div>
            
            <div class="detail-section">
                <h3 style="color: #374151; margin-bottom: 16px;">
                    <i class="fas fa-shopping-cart"></i> Order Items
                </h3>
                <div class="items-list">
                    ${itemsHtml}
                </div>
            </div>
            
            <div class="detail-section">
                <h3 style="color: #374151; margin-bottom: 16px;">
                    <i class="fas fa-calculator"></i> Order Summary
                </h3>
                <div style="background: #f8fafc; padding: 16px; border-radius: 8px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span>Subtotal:</span>
                        <span>LKR ${parseInt(order.cart_data.subtotal || 0).toLocaleString()}</span>
                    </div>
                    ${order.cart_data.discount > 0 ? `
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px; color: #059669;">
                            <span>Discount:</span>
                            <span>-LKR ${parseInt(order.cart_data.discount).toLocaleString()}</span>
                        </div>
                    ` : ''}
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span>Delivery Fee:</span>
                        <span>LKR ${parseInt(order.cart_data.delivery_fee || 0).toLocaleString()}</span>
                    </div>
                    <hr style="margin: 12px 0;">
                    <div style="display: flex; justify-content: space-between; font-weight: 700; font-size: 1.1rem;">
                        <span>Total:</span>
                        <span>LKR ${parseInt(order.cart_data.total || 0).toLocaleString()}</span>
                    </div>
                </div>
            </div>
            
            ${order.billing_data ? `
                <div class="detail-section">
                    <h3 style="color: #374151; margin-bottom: 16px;">
                        <i class="fas fa-map-marker-alt"></i> Billing Address
                    </h3>
                    <div style="background: #f8fafc; padding: 16px; border-radius: 8px;">
                        <div>${order.billing_data.first_name} ${order.billing_data.last_name}</div>
                        ${order.billing_data.company_name ? `<div>${order.billing_data.company_name}</div>` : ''}
                        <div>${order.billing_data.address_1}</div>
                        ${order.billing_data.address_2 ? `<div>${order.billing_data.address_2}</div>` : ''}
                        <div>${order.billing_data.town}, ${order.billing_data.postal_code}</div>
                        <div style="margin-top: 8px;">
                            <strong>Phone:</strong> ${order.billing_data.phone}<br>
                            <strong>Email:</strong> ${order.billing_data.email}
                        </div>
                    </div>
                </div>
            ` : ''}
            
            ${order.order_notes ? `
                <div class="detail-section">
                    <h3 style="color: #374151; margin-bottom: 16px;">
                        <i class="fas fa-sticky-note"></i> Order Notes
                    </h3>
                    <div style="background: #f8fafc; padding: 16px; border-radius: 8px;">
                        <p style="margin: 0; white-space: pre-wrap;">${order.order_notes}</p>
                    </div>
                </div>
            ` : ''}
            
            ${order.payment_data ? `
                <div class="detail-section">
                    <h3 style="color: #374151; margin-bottom: 16px;">
                        <i class="fas fa-credit-card"></i> Payment Information
                    </h3>
                    <div style="background: #f8fafc; padding: 16px; border-radius: 8px;">
                        <div><strong>Payment Mode:</strong> ${order.payment_mode || 'N/A'}</div>
                        ${order.payment_data.order_id ? `<div><strong>Payment Order ID:</strong> ${order.payment_data.order_id}</div>` : ''}
                        ${order.payment_data.status ? `<div><strong>Payment Status:</strong> <span class="order-status status-${order.payment_data.status}">${order.payment_data.status}</span></div>` : ''}
                        ${order.payment_data.method ? `<div><strong>Payment Method:</strong> ${order.payment_data.method}</div>` : ''}
                    </div>
                </div>
            ` : ''}
        </div>
    `;
}

function editOrderStatus(orderId, currentStatus) {
    // Show loading state while fetching order details
    Swal.fire({
        title: 'Loading Order Details...',
        text: 'Please wait while we fetch the order information.',
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // Fetch current order details
    fetch(`/admin/orders/${orderId}/details`)
        .then(response => response.json())
        .then(data => {
            Swal.close();
            if (data.success) {
                const order = data.order;
                
                // Populate form fields
                document.getElementById('editOrderId').value = orderId;
                document.getElementById('editOrderStatus').value = order.status || '0';
                document.getElementById('editPaymentMode').value = order.payment_mode || '';
                document.getElementById('editOrderNotes').value = order.order_notes || '';
                document.getElementById('editContactInfo').value = order.contact_info || '';
                
                // Show modal
                document.getElementById('editOrderModal').style.display = 'block';
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to load order details.',
                    icon: 'error',
                    confirmButtonColor: '#dc2626'
                });
            }
        })
        .catch(error => {
            Swal.close();
            console.error('Error:', error);
            Swal.fire({
                title: 'Error!',
                text: 'Failed to load order details.',
                icon: 'error',
                confirmButtonColor: '#dc2626'
            });
        });
}

function deleteOrder(orderId) {
    Swal.fire({
        title: 'Delete Order?',
        text: `Are you sure you want to delete order #${orderId}? This action cannot be undone.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, Delete Order',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        focusCancel: true,
        customClass: {
            popup: 'swal-popup',
            title: 'swal-title',
            content: 'swal-content',
            confirmButton: 'swal-confirm-btn',
            cancelButton: 'swal-cancel-btn'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading state
            Swal.fire({
                title: 'Deleting Order...',
                text: 'Please wait while we delete the order.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Delete the order
            fetch(`/admin/orders/${orderId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'Order has been deleted successfully.',
                        icon: 'success',
                        confirmButtonColor: '#059669',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: data.message || 'Failed to delete order.',
                        icon: 'error',
                        confirmButtonColor: '#dc2626',
                        confirmButtonText: 'Try Again'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'An unexpected error occurred while deleting the order.',
                    icon: 'error',
                    confirmButtonColor: '#dc2626',
                    confirmButtonText: 'OK'
                });
            });
        }
    });
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

// Handle edit order form submission
document.getElementById('editOrderForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const orderId = document.getElementById('editOrderId').value;
    const status = document.getElementById('editOrderStatus').value;
    const paymentMode = document.getElementById('editPaymentMode').value;
    const orderNotes = document.getElementById('editOrderNotes').value;
    const contactInfo = document.getElementById('editContactInfo').value;
    
    // Show loading state
    Swal.fire({
        title: 'Updating Order...',
        text: 'Please wait while we update the order.',
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    // Update the order
    fetch(`/admin/orders/${orderId}/update-status`, {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            status: status,
            payment_mode: paymentMode,
            order_notes: orderNotes,
            contact_info: contactInfo
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeModal('editOrderModal');
            Swal.fire({
                title: 'Updated!',
                text: 'Order status has been updated successfully.',
                icon: 'success',
                confirmButtonColor: '#059669',
                confirmButtonText: 'OK'
            }).then(() => {
                location.reload();
            });
        } else {
            Swal.fire({
                title: 'Error!',
                text: data.message || 'Failed to update order status.',
                icon: 'error',
                confirmButtonColor: '#dc2626',
                confirmButtonText: 'Try Again'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            title: 'Error!',
            text: 'An unexpected error occurred while updating the order.',
            icon: 'error',
            confirmButtonColor: '#dc2626',
            confirmButtonText: 'OK'
        });
    });
});

// Close modals when clicking outside
window.onclick = function(event) {
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });
}

// Filter functionality
function applyFilters() {
    const orderId = document.getElementById('filterOrderId').value;
    const customer = document.getElementById('filterCustomer').value;
    const status = document.getElementById('filterStatus').value;
    const dateRange = document.getElementById('filterDateRange').value;
    const dateFrom = document.getElementById('filterDateFrom').value;
    const dateTo = document.getElementById('filterDateTo').value;

    // Build query parameters
    const params = new URLSearchParams();
    
    if (orderId.trim()) params.append('order_id', orderId.trim());
    if (customer.trim()) params.append('customer', customer.trim());
    if (status) params.append('status', status);
    if (dateRange) params.append('date_range', dateRange);
    if (dateRange === 'custom') {
        if (dateFrom) params.append('date_from', dateFrom);
        if (dateTo) params.append('date_to', dateTo);
    }

    // Redirect with filters
    const currentUrl = window.location.pathname;
    const newUrl = params.toString() ? `${currentUrl}?${params.toString()}` : currentUrl;
    window.location.href = newUrl;
}

function clearFilters() {
    // Clear all filter inputs
    document.getElementById('filterOrderId').value = '';
    document.getElementById('filterCustomer').value = '';
    document.getElementById('filterStatus').value = '';
    document.getElementById('filterDateRange').value = '';
    document.getElementById('filterDateFrom').value = '';
    document.getElementById('filterDateTo').value = '';
    
    // Hide custom date inputs
    document.querySelector('.custom-date-inputs').style.display = 'none';
    
    // Redirect to base URL without filters
    window.location.href = window.location.pathname;
}

// Show/hide custom date inputs based on date range selection
document.getElementById('filterDateRange').addEventListener('change', function() {
    const customDateInputs = document.querySelector('.custom-date-inputs');
    if (this.value === 'custom') {
        customDateInputs.style.display = 'block';
    } else {
        customDateInputs.style.display = 'none';
        // Clear custom date values when not using custom range
        document.getElementById('filterDateFrom').value = '';
        document.getElementById('filterDateTo').value = '';
    }
});

// Allow filtering by pressing Enter in input fields
document.getElementById('filterOrderId').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') applyFilters();
});

document.getElementById('filterCustomer').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') applyFilters();
});

// Auto-apply filters when status changes
document.getElementById('filterStatus').addEventListener('change', function() {
    if (this.value !== '') {
        applyFilters();
    }
});

// Auto-apply filters when date range changes (except custom)
document.getElementById('filterDateRange').addEventListener('change', function() {
    if (this.value !== '' && this.value !== 'custom') {
        applyFilters();
    }
});
</script>

@endsection
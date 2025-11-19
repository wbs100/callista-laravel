@extends('layouts.admin-dashboard')

@section('content')

<div class="dashboard-content">
    <!-- Custom Requirements - Highlighted Section -->
    <div class="highlighted-section">
        <div class="highlight-badge">Custom Requirements</div>
        <h2 class="section-title-highlighted">
            <i class="fas fa-chart-line"></i>
            Custom Requirements
        </h2>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Total Requests</div>
                    <div class="stat-icon primary">
                        <i class="fas fa-tools"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $customRequests->total() }}</div>
                <div class="stat-change positive">
                    <i class="fas fa-info-circle"></i>
                    <span>All custom requests</span>
                </div>
            </div>

            <div class="stat-card warning">
                <div class="stat-header">
                    <div class="stat-title">Pending</div>
                    <div class="stat-icon warning">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $customRequests->where('status', 'pending')->count() }}</div>
                <div class="stat-change neutral">
                    <i class="fas fa-minus"></i>
                    <span>Needs attention</span>
                </div>
            </div>

            <div class="stat-card info">
                <div class="stat-header">
                    <div class="stat-title">In Progress</div>
                    <div class="stat-icon info">
                        <i class="fas fa-cogs"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $customRequests->where('status', 'in_progress')->count() }}</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>Being crafted</span>
                </div>
            </div>

            <div class="stat-card success">
                <div class="stat-header">
                    <div class="stat-title">Completed</div>
                    <div class="stat-icon success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $customRequests->where('status', 'completed')->count() }}</div>
                <div class="stat-change positive">
                    <i class="fas fa-chart-line"></i>
                    <span>Successfully delivered</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Request Status Summary -->
    <div class="order-summary-cards">
        <div class="summary-card">
            <div class="summary-icon summary-pending">
                <i class="fas fa-clock"></i>
            </div>
            <div class="summary-value">{{ $customRequests->where('status', 'pending')->count() }}</div>
            <div class="summary-label">Pending Requests</div>
        </div>
        <div class="summary-card">
            <div class="summary-icon summary-processing">
                <i class="fas fa-eye"></i>
            </div>
            <div class="summary-value">{{ $customRequests->where('status', 'reviewing')->count() }}</div>
            <div class="summary-label">Under Review</div>
        </div>
        <div class="summary-card">
            <div class="summary-icon summary-shipped">
                <i class="fas fa-cogs"></i>
            </div>
            <div class="summary-value">{{ $customRequests->where('status', 'in_progress')->count() }}</div>
            <div class="summary-label">In Progress</div>
        </div>
        <div class="summary-card">
            <div class="summary-icon summary-delivered">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="summary-value">{{ $customRequests->where('status', 'completed')->count() }}</div>
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

    <!-- Custom Request Filters -->
    <div class="order-filters">
        <div class="filter-row">
            <div class="form-group">
                <label class="form-label">Request ID</label>
                <input type="text" id="filterRequestId" class="form-input" placeholder="Search by request ID..."
                    value="{{ request('request_id') }}">
            </div>
            <div class="form-group">
                <label class="form-label">Customer Name</label>
                <input type="text" id="filterCustomer" class="form-input" placeholder="Search by customer name..."
                    value="{{ request('search') }}">
            </div>
            <div class="form-group">
                <label class="form-label">Status</label>
                <select id="filterStatus" class="form-select">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
                    <option value="reviewing" {{ request('status')=='reviewing' ? 'selected' : '' }}>Reviewing</option>
                    <option value="quoted" {{ request('status')=='quoted' ? 'selected' : '' }}>Quoted</option>
                    <option value="approved" {{ request('status')=='approved' ? 'selected' : '' }}>Approved</option>
                    <option value="in_progress" {{ request('status')=='in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="completed" {{ request('status')=='completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status')=='cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Date Range</label>
                <select id="filterDateRange" class="form-select">
                    <option value="">All Dates</option>
                    <option value="today" {{ request('date_range')=='today' ? 'selected' : '' }}>Today</option>
                    <option value="week" {{ request('date_range')=='week' ? 'selected' : '' }}>This Week</option>
                    <option value="month" {{ request('date_range')=='month' ? 'selected' : '' }}>This Month</option>
                    <option value="custom" {{ request('date_range')=='custom' ? 'selected' : '' }}>Custom Range</option>
                </select>
            </div>
            <div class="form-group custom-date-inputs"
                style="display: {{ request('date_range') == 'custom' ? 'block' : 'none' }};">
                <label class="form-label">Custom Date Range</label>
                <div style="display: flex; gap: 10px;">
                    <input type="date" id="filterDateFrom" class="form-input" placeholder="From"
                        value="{{ request('date_from') }}" style="flex: 1;">
                    <input type="date" id="filterDateTo" class="form-input" placeholder="To"
                        value="{{ request('date_to') }}" style="flex: 1;">
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
        <div class="highlight-badge">Request Management</div>
        <div class="order-header">
            <h2 class="section-title-highlighted">
                <i class="fas fa-list-alt"></i>
                Custom Furniture Requests
            </h2>
            <a href="#" class="btn-export">
                <i class="fas fa-download"></i>
                Export Requests
            </a>
        </div>

        <div class="orders-table">
            <div class="table-header">
                Recent Custom Requests
                @if(request()->hasAny(['request_id', 'search', 'status', 'date_range']))
                <span class="filter-indicator">
                    <i class="fas fa-filter"></i>
                    Filtered Results ({{ $customRequests->count() }} found)
                    <button class="clear-filters-btn" onclick="clearFilters()" title="Clear all filters">
                        <i class="fas fa-times"></i>
                    </button>
                </span>
                @else
                <span class="total-count">({{ $customRequests->total() }} total)</span>
                @endif
            </div>
            <div class="orders-table-content">
                <table>
                    <thead>
                        <tr>
                            <th>Request ID</th>
                            <th>Customer</th>
                            <th>Furniture Type</th>
                            <th>Budget Range</th>
                            <th>Status</th>
                            <th>Request Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customRequests as $request)
                        <tr>
                            <td>
                                <a href="#" class="order-id">#CR-{{ $request->id }}</a>
                            </td>
                            <td>
                                <div class="customer-info">
                                    <div class="customer-avatar">
                                        {{ strtoupper(substr($request->full_name, 0, 2)) }}
                                    </div>
                                    <div class="customer-details">
                                        <div class="customer-name">{{ $request->full_name }}</div>
                                        <div class="customer-email">{{ $request->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="furniture-details">
                                    <div class="furniture-type">{{ $request->furniture_type }}</div>
                                    @if($request->dimensions)
                                    <small class="text-muted">{{ $request->dimensions }}</small>
                                    @endif
                                </div>
                            </td>
                            <td class="budget-range text-nowrap">
                                @if($request->budget)
                                    LKR {{ $request->budget }}
                                @else
                                    <span class="text-muted">Not specified</span>
                                @endif
                                @if($request->quoted_price)
                                <small class="quoted-price">
                                    <br><span class="text-info">Quoted: LKR {{ number_format($request->quoted_price) }}</span>
                                </small>
                                @endif
                            </td>
                            <td>
                                <span class="order-status text-nowrap status-{{ strtolower(str_replace('_', '-', $request->status)) }}">
                                    {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                                </span>
                            </td>
                            <td class="order-date text-nowrap">{{ $request->created_at->format('Y-m-d') }}</td>
                            <td>
                                <div class="order-actions">
                                    <button class="btn-action btn-view" title="View Details"
                                        onclick="viewRequestDetails({{ $request->id }})">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn-action btn-edit-order" title="Edit Request Status"
                                        onclick="editRequestStatus({{ $request->id }}, '{{ $request->status }}')">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-action btn-delete-order" title="Delete Request"
                                        onclick="deleteRequest({{ $request->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center" style="padding: 40px;">
                                <div style="opacity: 0.6;">
                                    @if(request()->hasAny(['request_id', 'search', 'status', 'date_range']))
                                    <i class="fas fa-filter"
                                        style="font-size: 2rem; margin-bottom: 10px; color: #667eea;"></i>
                                    <p>No custom requests match your filters</p>
                                    <button class="btn-clear-filter" onclick="clearFilters()" style="margin-top: 16px;">
                                        <i class="fas fa-times"></i>
                                        Clear Filters
                                    </button>
                                    @else
                                    <i class="fas fa-tools" style="font-size: 2rem; margin-bottom: 10px;"></i>
                                    <p>No custom requests found</p>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            {{ $customRequests->links('vendor.pagination.admin-pagination') }}
            <br>
        </div>
    </div>
</div>

<!-- Request Details Modal -->
<div id="requestDetailsModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2><i class="fas fa-tools"></i> Custom Request Details</h2>
            <span class="close" onclick="closeModal('requestDetailsModal')">&times;</span>
        </div>
        <div class="modal-body" id="requestDetailsContent">
            <!-- Request details will be loaded here -->
        </div>
    </div>
</div>

<!-- Edit Request Status Modal -->
<div id="editRequestModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2><i class="fas fa-edit"></i> Edit Request Status</h2>
            <span class="close" onclick="closeModal('editRequestModal')">&times;</span>
        </div>
        <div class="modal-body">
            <form id="editRequestForm">
                <input type="hidden" id="editRequestId">
                <div class="form-group">
                    <label class="form-label">Request Status</label>
                    <select id="editRequestStatus" class="form-select">
                        <option value="pending">Pending</option>
                        <option value="reviewing">Reviewing</option>
                        <option value="quoted">Quoted</option>
                        <option value="approved">Approved</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Quoted Price (LKR)</label>
                    <input type="number" id="editQuotedPrice" class="form-input" step="0.01" min="0"
                        placeholder="Enter quoted price...">
                </div>
                <div class="form-group">
                    <label class="form-label">Admin Notes</label>
                    <textarea id="editAdminNotes" class="form-input" rows="3"
                        placeholder="Add any notes about this request..."></textarea>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn-secondary" onclick="closeModal('editRequestModal')">Cancel</button>
                    <button type="submit" class="btn-primary">Update Request</button>
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
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes slideIn {
        from {
            transform: translateY(-50px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
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

    /* Custom Request Specific Styles */
    .furniture-details {
        max-width: 180px;
    }

    .furniture-type {
        font-weight: 600;
        color: #374151;
        margin-bottom: 2px;
    }

    .quoted-price {
        font-size: 0.75rem;
        color: #3b82f6 !important;
    }

    .budget-range {
        min-width: 120px;
    }
</style>

<script>
// Basic JavaScript functions for custom requests
function viewRequestDetails(id) {
    // Placeholder function - can be implemented later
    alert('View request details for ID: ' + id);
}

function editRequestStatus(id, status) {
    // Placeholder function - can be implemented later
    alert('Edit request status for ID: ' + id + ', current status: ' + status);
}

function deleteRequest(id) {
    // Placeholder function - can be implemented later
    if (confirm('Are you sure you want to delete this custom request?')) {
        alert('Delete request ID: ' + id);
    }
}

function applyFilters() {
    const params = new URLSearchParams();
    
    const requestId = document.getElementById('filterRequestId').value;
    const customer = document.getElementById('filterCustomer').value;
    const status = document.getElementById('filterStatus').value;
    const dateRange = document.getElementById('filterDateRange').value;
    
    if (requestId) params.append('request_id', requestId);
    if (customer) params.append('search', customer);
    if (status) params.append('status', status);
    if (dateRange) params.append('date_range', dateRange);
    
    if (dateRange === 'custom') {
        const dateFrom = document.getElementById('filterDateFrom').value;
        const dateTo = document.getElementById('filterDateTo').value;
        if (dateFrom) params.append('date_from', dateFrom);
        if (dateTo) params.append('date_to', dateTo);
    }
    
    window.location.href = '{{ route("admin.custom-requests") }}' + (params.toString() ? '?' + params.toString() : '');
}

function clearFilters() {
    window.location.href = '{{ route("admin.custom-requests") }}';
}

// Show custom date inputs when custom range is selected
document.addEventListener('DOMContentLoaded', function() {
    const dateRangeSelect = document.getElementById('filterDateRange');
    const customDateInputs = document.querySelector('.custom-date-inputs');
    
    if (dateRangeSelect && customDateInputs) {
        dateRangeSelect.addEventListener('change', function() {
            customDateInputs.style.display = this.value === 'custom' ? 'block' : 'none';
        });
    }
});

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}
</script>


@endsection
@extends('layouts.admin-dashboard')

@section('content')

<div class="dashboard-content">
    <!-- User Stats - Highlighted Section -->
    <div class="highlighted-section">
        <div class="highlight-badge">Featured Stats</div>
        <h2 class="section-title-highlighted">
            <i class="fas fa-chart-line"></i>
            User Analytics Overview
        </h2>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Total Users</div>
                    <div class="stat-icon primary">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <div class="stat-value">{{ count($users) }}</div>
                <div class="stat-change positive">
                    <i class="fas fa-info-circle"></i>
                    <span>All registered users</span>
                </div>
            </div>

            <div class="stat-card success">
                <div class="stat-header">
                    <div class="stat-title">Regular Users</div>
                    <div class="stat-icon success">
                        <i class="fas fa-user-check"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $users->where('role', 'user')->count() }}</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>Customer accounts</span>
                </div>
            </div>

            <div class="stat-card warning">
                <div class="stat-header">
                    <div class="stat-title">Admin Users</div>
                    <div class="stat-icon warning">
                        <i class="fas fa-user-shield"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $users->where('role', 'admin')->count() }}</div>
                <div class="stat-change neutral">
                    <i class="fas fa-shield-alt"></i>
                    <span>Admin accounts</span>
                </div>
            </div>

            <div class="stat-card info">
                <div class="stat-header">
                    <div class="stat-title">Recent Users</div>
                    <div class="stat-icon info">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $users->where('created_at', '>=', now()->subDays(7))->count() }}</div>
                <div class="stat-change positive">
                    <i class="fas fa-calendar-week"></i>
                    <span>Last 7 days</span>
                </div>
            </div>
        </div>
    </div>

    <!-- User Search Form -->
    <div class="user-search-form">
        <div class="search-row">
            <div class="form-group">
                <label class="form-label">Name</label>
                <input type="text" class="form-input" placeholder="Search by name...">
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" class="form-input" placeholder="Search by email...">
            </div>
            <div class="form-group">
                <label class="form-label">Status</label>
                <select class="form-input">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="pending">Pending</option>
                </select>
            </div>
            <button class="btn-search">
                <i class="fas fa-search"></i>
                Search
            </button>
        </div>
    </div>

    <!-- Users Table - Highlighted Section -->
    <div class="highlighted-section">
        <div class="highlight-badge">User Management</div>
        <div class="table-actions">
            <h2 class="section-title-highlighted">
                <i class="fas fa-table"></i>
                Users Database
            </h2>
            <a href="#" class="btn-add">
                <i class="fas fa-plus"></i>
                Add New User
            </a>
        </div>

        <div class="table-container">
            <table class="user-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Join Date</th>
                        <th>Status</th>
                        <th>Orders</th>
                        <th>Total Spent</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr class="user-row">
                        <td>
                            <div class="user-info">
                                <div class="user-avatar-sm">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <div class="user-details">
                                    <h4>{{ $user->name }}</h4>
                                    <p>{{ ucfirst($user->role) }} {{ $user->role == 'user' ? 'Customer' : 'User' }}</p>
                                </div>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at->format('Y-m-d') }}</td>
                        <td>
                            @if($user->email_verified_at)
                                <span class="status-badge status-active">Active</span>
                            @else
                                <span class="status-badge status-pending">Pending</span>
                            @endif
                        </td>
                        <td>{{ $orders->where('user_id', $user->id)->count() }}</td>
                        <td>
                            @php
                                $userOrders = $orders->where('user_id', $user->id);
                                $totalSpent = 0;
                                foreach($userOrders as $order) {
                                    if(isset($order->cart_data) && is_array($order->cart_data)) {
                                        foreach($order->cart_data as $item) {
                                            $totalSpent += isset($item['price']) ? $item['price'] * (isset($item['quantity']) ? $item['quantity'] : 1) : 0;
                                        }
                                    }
                                }
                            @endphp
                            LKR {{ number_format($totalSpent) }}
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-sm btn-primary-sm" title="Edit User">
                                    <i class="fas fa-edit"></i>
                                    Edit
                                </button>
                                @if($user->role !== 'admin')
                                <button class="btn-sm btn-danger-sm" title="Delete User">
                                    <i class="fas fa-trash"></i>
                                    Delete
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 2rem; color: #666;">
                            <i class="fas fa-users" style="font-size: 2rem; margin-bottom: 1rem; display: block;"></i>
                            No users found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination">
            <a href="#" class="pagination-btn">
                <i class="fas fa-chevron-left"></i>
            </a>
            <a href="#" class="pagination-btn active">1</a>
            <a href="#" class="pagination-btn">2</a>
            <a href="#" class="pagination-btn">3</a>
            <a href="#" class="pagination-btn">4</a>
            <a href="#" class="pagination-btn">5</a>
            <a href="#" class="pagination-btn">
                <i class="fas fa-chevron-right"></i>
            </a>
        </div>
    </div>
</div>
@endsection
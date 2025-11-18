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
                <div class="stat-value">4,856</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>+15.3% from last month</span>
                </div>
            </div>

            <div class="stat-card success">
                <div class="stat-header">
                    <div class="stat-title">Active Users</div>
                    <div class="stat-icon success">
                        <i class="fas fa-user-check"></i>
                    </div>
                </div>
                <div class="stat-value">4,127</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>+8.2% from last month</span>
                </div>
            </div>

            <div class="stat-card warning">
                <div class="stat-header">
                    <div class="stat-title">New Registrations</div>
                    <div class="stat-icon warning">
                        <i class="fas fa-user-plus"></i>
                    </div>
                </div>
                <div class="stat-value">247</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>+23.1% from last week</span>
                </div>
            </div>

            <div class="stat-card info">
                <div class="stat-header">
                    <div class="stat-title">Premium Users</div>
                    <div class="stat-icon info">
                        <i class="fas fa-crown"></i>
                    </div>
                </div>
                <div class="stat-value">856</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>+5.7% from last month</span>
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
                    <tr class="user-row">
                        <td>
                            <div class="user-info">
                                <div class="user-avatar-sm">JP</div>
                                <div class="user-details">
                                    <h4>John Perera</h4>
                                    <p>Premium Customer</p>
                                </div>
                            </div>
                        </td>
                        <td>john.perera@email.com</td>
                        <td>2024-01-15</td>
                        <td><span class="status-badge status-active">Active</span></td>
                        <td>23</td>
                        <td>LKR 485,000</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-sm btn-primary-sm">
                                    <i class="fas fa-edit"></i>
                                    Edit
                                </button>
                                <button class="btn-sm btn-danger-sm">
                                    <i class="fas fa-trash"></i>
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="user-row">
                        <td>
                            <div class="user-info">
                                <div class="user-avatar-sm">SF</div>
                                <div class="user-details">
                                    <h4>Sarah Fernando</h4>
                                    <p>Regular Customer</p>
                                </div>
                            </div>
                        </td>
                        <td>sarah.fernando@email.com</td>
                        <td>2024-02-20</td>
                        <td><span class="status-badge status-active">Active</span></td>
                        <td>12</td>
                        <td>LKR 325,000</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-sm btn-primary-sm">
                                    <i class="fas fa-edit"></i>
                                    Edit
                                </button>
                                <button class="btn-sm btn-danger-sm">
                                    <i class="fas fa-trash"></i>
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="user-row">
                        <td>
                            <div class="user-info">
                                <div class="user-avatar-sm">AR</div>
                                <div class="user-details">
                                    <h4>Amal Rajapaksa</h4>
                                    <p>New Customer</p>
                                </div>
                            </div>
                        </td>
                        <td>amal.rajapaksa@email.com</td>
                        <td>2024-10-25</td>
                        <td><span class="status-badge status-pending">Pending</span></td>
                        <td>1</td>
                        <td>LKR 45,000</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-sm btn-primary-sm">
                                    <i class="fas fa-edit"></i>
                                    Edit
                                </button>
                                <button class="btn-sm btn-danger-sm">
                                    <i class="fas fa-trash"></i>
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="user-row">
                        <td>
                            <div class="user-info">
                                <div class="user-avatar-sm">NS</div>
                                <div class="user-details">
                                    <h4>Nimal Silva</h4>
                                    <p>Regular Customer</p>
                                </div>
                            </div>
                        </td>
                        <td>nimal.silva@email.com</td>
                        <td>2024-03-10</td>
                        <td><span class="status-badge status-inactive">Inactive</span></td>
                        <td>8</td>
                        <td>LKR 180,000</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-sm btn-primary-sm">
                                    <i class="fas fa-edit"></i>
                                    Edit
                                </button>
                                <button class="btn-sm btn-danger-sm">
                                    <i class="fas fa-trash"></i>
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="user-row">
                        <td>
                            <div class="user-info">
                                <div class="user-avatar-sm">DW</div>
                                <div class="user-details">
                                    <h4>Dilini Wickramasinghe</h4>
                                    <p>Premium Customer</p>
                                </div>
                            </div>
                        </td>
                        <td>dilini.w@email.com</td>
                        <td>2024-01-28</td>
                        <td><span class="status-badge status-active">Active</span></td>
                        <td>31</td>
                        <td>LKR 620,000</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-sm btn-primary-sm">
                                    <i class="fas fa-edit"></i>
                                    Edit
                                </button>
                                <button class="btn-sm btn-danger-sm">
                                    <i class="fas fa-trash"></i>
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
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
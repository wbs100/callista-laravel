@extends('layouts.user-dashboard')

@section('content')

<!-- Main Content -->
<main class="dashboard-main">
    <div class="dashboard-header">
        <h1 class="dashboard-title">Welcome back, {{ $userData['user']['name'] }}!</h1>
        <p class="dashboard-subtitle">Here's what's happening with your account</p>
    </div>

    <!-- Account Statistics - Highlighted Section -->
    <div class="highlighted-section">
        <div class="highlight-badge">Account Overview</div>
        <h2 class="section-title-highlighted">
            <i class="fas fa-chart-pie"></i>
            Your Account Summary
        </h2>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Total Orders</div>
                    <div class="stat-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $userData['totalOrders'] }}</div>
                <div class="stat-change {{ $userData['thisMonthOrders'] > 0 ? 'positive' : 'neutral' }}">
                    <i class="fas fa-{{ $userData['thisMonthOrders'] > 0 ? 'arrow-up' : 'minus' }}"></i>
                    <span>{{ $userData['thisMonthOrders'] > 0 ? '+' . $userData['thisMonthOrders'] . ' this month' : 'No orders this month' }}</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Total Spent</div>
                    <div class="stat-icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>
                <div class="stat-value">LKR {{ number_format($userData['totalSpent'] / 1000, 0) }}K</div>
                <div class="stat-change {{ $userData['spentChange'] >= 0 ? 'positive' : 'negative' }}">
                    <i class="fas fa-arrow-{{ $userData['spentChange'] >= 0 ? 'up' : 'down' }}"></i>
                    <span>{{ $userData['spentChange'] >= 0 ? '+' : '' }}{{ $userData['spentChange'] }}% from last month</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Saved Items</div>
                    <div class="stat-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $userData['wishlistCount'] }}</div>
                <div class="stat-change {{ $userData['newWishlistItems'] > 0 ? 'positive' : 'neutral' }}">
                    <i class="fas fa-{{ $userData['newWishlistItems'] > 0 ? 'arrow-up' : 'heart' }}"></i>
                    <span>{{ $userData['newWishlistItems'] > 0 ? $userData['newWishlistItems'] . ' new favorites' : 'No new favorites' }}</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Loyalty Points</div>
                    <div class="stat-icon">
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                <div class="stat-value">{{ number_format($userData['loyaltyPoints']) }}</div>
                <div class="stat-change {{ $userData['pointsEarned'] > 0 ? 'positive' : 'neutral' }}">
                    <i class="fas fa-{{ $userData['pointsEarned'] > 0 ? 'arrow-up' : 'star' }}"></i>
                    <span>{{ $userData['pointsEarned'] > 0 ? '+' . $userData['pointsEarned'] . ' points earned' : 'No points this month' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions - Highlighted Section -->
    <div class="highlighted-section">
        <div class="highlight-badge">Quick Actions</div>
        <h2 class="section-title-highlighted">
            <i class="fas fa-bolt"></i>
            What would you like to do?
        </h2>

        <div class="quick-actions">
            <a href="/marketplace" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-store"></i>
                </div>
                <div class="action-title">Browse Marketplace</div>
                <div class="action-description">Explore our latest furniture collection</div>
            </a>

            <a href="/customize" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-paint-brush"></i>
                </div>
                <div class="action-title">Custom Design</div>
                <div class="action-description">Create your personalized furniture</div>
            </a>

            <a href="/interior" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-home"></i>
                </div>
                <div class="action-title">Interior Design</div>
                <div class="action-description">Get professional design consultation</div>
            </a>

            <a href="/cart" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="action-title">View Cart</div>
                <div class="action-description">Check your selected items</div>
            </a>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="highlighted-section">
        <div class="highlight-badge">Order History</div>
        <h2 class="section-title-highlighted">
            <i class="fas fa-history"></i>
            Recent Orders
        </h2>

        <div class="recent-orders">
            <div class="orders-header">Your Recent Purchases</div>

            @if($userData['recentOrders']->count() > 0)
                @foreach($userData['recentOrders'] as $order)
                    @php
                        $cartData = $order->cart_data;
                        $paymentData = $order->payment_data;
                        $total = isset($cartData['total']) ? $cartData['total'] : 0;
                        $itemCount = isset($cartData['items']) ? count($cartData['items']) : 0;
                        
                        // Determine status class and text
                        $statusClass = $order->status ? 'status-delivered' : 'status-processing';
                        $statusText = $order->status ? 'Completed' : 'Processing';
                        
                        if (isset($paymentData['status']) && $paymentData['status'] === 'pending') {
                            $statusClass = 'status-pending';
                            $statusText = 'Pending Payment';
                        }
                    @endphp
                    <div class="order-item">
                        <div class="order-info">
                            <div class="order-id">#{{ $order->id }}</div>
                            <div class="order-date">{{ $order->created_at->format('F j, Y') }}</div>
                            <div>{{ $itemCount }} item{{ $itemCount != 1 ? 's' : '' }} - LKR {{ number_format($total) }}</div>
                        </div>
                        <div class="order-status {{ $statusClass }}">{{ $statusText }}</div>
                    </div>
                @endforeach
            @else
                <div class="order-item">
                    <div class="order-info">
                        <div class="order-id">No orders yet</div>
                        <div class="order-date">Start shopping to see your orders here</div>
                        <div><a href="{{ route('marketplace') }}" class="text-primary">Browse our marketplace</a></div>
                    </div>
                    <div class="order-status status-pending">-</div>
                </div>
            @endif
        </div>
    </div>

    <!-- Account Information -->
    <div class="highlighted-section">
        <div class="highlight-badge">Account Details</div>
        <h2 class="section-title-highlighted">
            <i class="fas fa-user-circle"></i>
            Account Information
        </h2>

        <div class="account-info">
            <div class="info-group">
                <div class="info-label">Full Name</div>
                <div class="info-value">{{ $userData['user']['name'] }}</div>
            </div>

            <div class="info-group">
                <div class="info-label">Email Address</div>
                <div class="info-value">{{ $userData['user']['email'] }}</div>
            </div>

            <div class="info-group">
                <div class="info-label">Contact Info</div>
                <div class="info-value">
                    @if($userData['billingData']->contact_info)
                        {{ $userData['billingData']->contact_info }}
                    @else
                        <span class="text-muted">Not provided</span>
                    @endif
                </div>
            </div>

            <div class="info-group">
                <div class="info-label">Member Since</div>
                <div class="info-value">{{ $userData['user']['created_at']->format('F j, Y') }}</div>
            </div>

            <div class="info-group">
                <div class="info-label">Delivery Address</div>
                <div class="info-value">
                    @if($userData['billingData'])
                        {{ $userData['billingData']->address_1 }}
                        @if($userData['billingData']->address_2), {{ $userData['billingData']->address_2 }}@endif
                        <br>{{ $userData['billingData']->town }}, {{ $userData['billingData']->postal_code }}
                    @else
                        <span class="text-muted">No address saved</span>
                    @endif
                </div>
            </div>

            <div class="info-group">
                <div class="info-label">Account Status</div>
                <div class="info-value">
                    <span class="status-badge status-active">Active</span>
                    @if($userData['user']['email_verified_at'])
                        <span class="status-badge status-verified">Verified</span>
                    @else
                        <span class="status-badge status-unverified">Unverified</span>
                    @endif
                </div>
            </div>
        </div>

        <a href="#profile" class="btn-edit-profile">
            <i class="fas fa-edit"></i>
            Edit Profile
        </a>
    </div>
</main>

@endsection

@section('styles')
<style>
.status-badge {
    display: inline-block;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 0.8rem;
    font-weight: 600;
    margin-right: 5px;
}

.status-active {
    background: #d4edda;
    color: #155724;
}

.status-verified {
    background: #cce7ff;
    color: #004085;
}

.status-unverified {
    background: #fff3cd;
    color: #856404;
}

.status-pending {
    background: #fff3cd;
    color: #856404;
}

.text-muted {
    color: #6c757d !important;
}

.text-primary {
    color: #007bff !important;
    text-decoration: none;
}

.text-primary:hover {
    text-decoration: underline;
}

.stat-change.neutral {
    color: #6c757d;
}

.stat-change.negative {
    color: #dc3545;
}
</style>
@endsection
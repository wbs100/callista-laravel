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
            <div class="orders-header">
                Your Recent Purchases
                {{-- @if($userData['recentOrders']->count() > 0)
                    <a href="#" class="view-all-orders" style="float: right; color: #667eea; text-decoration: none; font-size: 0.9rem;">
                        <i class="fas fa-arrow-right"></i> View All Orders
                    </a>
                @endif --}}
            </div>

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
                    @if($userData['billingData'] && $userData['billingData']->phone)
                        {{ $userData['billingData']->phone }} | {{ $userData['billingData']->email }}
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

        <a href="#" class="btn-edit-profile" id="edit-profile-btn">
            <i class="fas fa-edit"></i>
            Edit Profile
        </a>
    </div>
</main>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">
                    <i class="fas fa-user-edit"></i>
                    Edit Profile Information
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editProfileForm" method="POST" action="{{ route('user.profile.update') }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <!-- Personal Information -->
                        <div class="col-md-6">
                            <h6 class="section-subtitle">
                                <i class="fas fa-user"></i>
                                Personal Information
                            </h6>
                            
                            <div class="mb-3">
                                <label for="edit_first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="edit_first_name" name="first_name" 
                                       value="{{ $userData['billingData']->first_name ?? '' }}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="edit_last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="edit_last_name" name="last_name" 
                                       value="{{ $userData['billingData']->last_name ?? '' }}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="edit_company_name" class="form-label">Company Name</label>
                                <input type="text" class="form-control" id="edit_company_name" name="company_name" 
                                       value="{{ $userData['billingData']->company_name ?? '' }}">
                            </div>
                            
                            <div class="mb-3">
                                <label for="edit_phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="edit_phone" name="phone" 
                                       value="{{ $userData['billingData']->phone ?? '' }}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="edit_email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="edit_email" name="email" 
                                       value="{{ $userData['user']['email'] }}" required>
                            </div>
                        </div>
                        
                        <!-- Address Information -->
                        <div class="col-md-6">
                            <h6 class="section-subtitle">
                                <i class="fas fa-map-marker-alt"></i>
                                Address Information
                            </h6>
                            
                            <div class="mb-3">
                                <label for="edit_address_1" class="form-label">Address Line 1</label>
                                <input type="text" class="form-control" id="edit_address_1" name="address_1" 
                                       value="{{ $userData['billingData']->address_1 ?? '' }}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="edit_address_2" class="form-label">Address Line 2</label>
                                <input type="text" class="form-control" id="edit_address_2" name="address_2" 
                                       value="{{ $userData['billingData']->address_2 ?? '' }}">
                            </div>
                            
                            <div class="mb-3">
                                <label for="edit_town" class="form-label">City/Town</label>
                                <input type="text" class="form-control" id="edit_town" name="town" 
                                       value="{{ $userData['billingData']->town ?? '' }}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="edit_postal_code" class="form-label">Postal Code</label>
                                <input type="text" class="form-control" id="edit_postal_code" name="postal_code" 
                                       value="{{ $userData['billingData']->postal_code ?? '' }}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="edit_notes" class="form-label">Additional Notes</label>
                                <textarea class="form-control" id="edit_notes" name="notes" rows="3">{{ $userData['billingData']->notes ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i>
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary" id="save-profile-btn">
                        <i class="fas fa-save"></i>
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

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

.modal-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-bottom: none;
}

.modal-header .btn-close {
    filter: invert(1);
}

.section-subtitle {
    color: #495057;
    font-weight: 600;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #f8f9fa;
}

.section-subtitle i {
    color: #667eea;
    margin-right: 0.5rem;
}

.form-label {
    font-weight: 600;
    color: #495057;
}

.btn-edit-profile {
    display: inline-block;
    padding: 12px 24px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.btn-edit-profile:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    color: white;
    text-decoration: none;
}

.modal-body {
    padding: 2rem;
}

.modal-footer {
    padding: 1rem 2rem 2rem;
    border-top: 1px solid #dee2e6;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.form-control.is-invalid {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}

.invalid-feedback {
    display: block;
    width: 100%;
    margin-top: 0.25rem;
    font-size: 0.875rem;
    color: #dc3545;
}

.orders-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    font-weight: 600;
}

.view-all-orders:hover {
    color: #5a67d8 !important;
}
</style>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Open edit profile modal
    $('#edit-profile-btn').on('click', function(e) {
        e.preventDefault();
        $('#editProfileModal').modal('show');
    });

    // Handle form submission
    $('#editProfileForm').on('submit', function(e) {
        e.preventDefault();
        
        const form = $(this);
        const submitBtn = $('#save-profile-btn');
        const originalText = submitBtn.html();
        
        // Disable submit button and show loading
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
        
        // Clear previous errors
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').remove();
        
        $.ajax({
            url: form.attr('action'),
            method: 'PUT',
            data: form.serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Profile Updated!',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 2000
                    });
                    
                    // Close modal
                    $('#editProfileModal').modal('hide');
                    
                    // Update the displayed information on the page
                    updateDisplayedInfo(response.data);
                    
                    // Reload page after a delay to reflect changes
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Update Failed',
                        text: response.message || 'An error occurred while updating your profile.'
                    });
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    // Handle validation errors
                    const errors = xhr.responseJSON.errors;
                    
                    $.each(errors, function(field, messages) {
                        const input = $(`#edit_${field}`);
                        input.addClass('is-invalid');
                        input.after(`<div class="invalid-feedback">${messages[0]}</div>`);
                    });
                    
                    Swal.fire({
                        icon: 'warning',
                        title: 'Validation Error',
                        text: 'Please check the form for errors and try again.'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An unexpected error occurred. Please try again.'
                    });
                }
            },
            complete: function() {
                // Re-enable submit button
                submitBtn.prop('disabled', false).html(originalText);
            }
        });
    });
    
    // Function to update displayed information
    function updateDisplayedInfo(data) {
        if (data.billingData) {
            // Update contact info
            const contactInfo = data.billingData.phone + ' | ' + data.billingData.email;
            $('.info-group').find('.info-value').each(function() {
                const label = $(this).siblings('.info-label').text();
                if (label === 'Contact Info') {
                    $(this).text(contactInfo);
                } else if (label === 'Delivery Address') {
                    let address = data.billingData.address_1;
                    if (data.billingData.address_2) {
                        address += ', ' + data.billingData.address_2;
                    }
                    address += '<br>' + data.billingData.town + ', ' + data.billingData.postal_code;
                    $(this).html(address);
                }
            });
        }
        
        // Update email if changed
        if (data.user) {
            $('.info-group').find('.info-value').each(function() {
                const label = $(this).siblings('.info-label').text();
                if (label === 'Email Address') {
                    $(this).text(data.user.email);
                }
            });
        }
    }
    
    // Reset form when modal is hidden
    $('#editProfileModal').on('hidden.bs.modal', function() {
        $('#editProfileForm')[0].reset();
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').remove();
    });
    
    // Add input focus effects
    $('.form-control').on('focus', function() {
        $(this).removeClass('is-invalid');
        $(this).siblings('.invalid-feedback').fadeOut();
    });
    
    // Handle view all orders (placeholder)
    $('.view-all-orders').on('click', function(e) {
        e.preventDefault();
        Swal.fire({
            icon: 'info',
            title: 'Coming Soon',
            text: 'Full order history page is coming soon!'
        });
    });
});
</script>
@endsection
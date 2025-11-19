<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}" type="image/x-icon">
    <title>User Dashboard - Callista LK</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">

    <!-- Page-specific styles -->
    @yield('styles')

    <style>
        /* Dashboard-specific styles */
        .dashboard-wrapper {
            min-height: 100vh;
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            padding: 2rem 0;
        }

        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1rem;
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 2rem;
        }

        /* Sidebar Navigation */
        .dashboard-sidebar {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            height: fit-content;
            box-shadow: var(--shadow-medium);
            border: 1px solid var(--border-color);
            position: sticky;
            top: 2rem;
        }

        .user-profile {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid var(--border-color);
        }

        .user-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--gradient-primary);
            margin: 0 auto 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            font-weight: 600;
        }

        .user-name {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        .user-email {
            color: var(--gray-color);
            font-size: 0.875rem;
        }

        .nav-menu {
            list-style: none;

            display: flex;
            flex-direction: column;
        }

        .nav-item {
            margin-bottom: 0.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.875rem 1rem;
            border-radius: 12px;
            text-decoration: none;
            color: var(--gray-color);
            transition: all var(--transition-medium);
            font-weight: 500;

            border: none
        }

        .nav-link:hover,
        .nav-link.active {
            background: var(--gradient-primary);
            color: white;
            transform: translateX(4px);

            i {
                color: white;
            }
        }

        .nav-icon {
            font-size: 1.125rem;
            width: 20px;
            text-align: center;
        }

        /* Main Content */
        .dashboard-main {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: var(--shadow-medium);
            border: 1px solid var(--border-color);
        }

        .dashboard-header {
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .dashboard-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        .dashboard-subtitle {
            color: var(--gray-color);
            font-size: 1rem;
        }

        /* Highlighted Sections */
        .highlighted-section {
            position: relative;
            background: linear-gradient(135deg, rgba(139, 69, 19, 0.05) 0%, rgba(210, 105, 30, 0.05) 100%);
            border: 2px solid var(--primary-color);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .highlighted-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
        }

        .highlight-badge {
            position: absolute;
            top: -1px;
            right: 2rem;
            background: var(--gradient-primary);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0 0 8px 8px;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .section-title-highlighted {
            color: var(--primary-color);
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .section-title-highlighted i {
            background: var(--gradient-primary);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: var(--shadow-small);
            border: 1px solid var(--border-color);
            transition: all var(--transition-medium);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--gradient-primary);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-large);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .stat-title {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--gray-color);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--gradient-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.125rem;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        .stat-change {
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .stat-change.positive {
            color: var(--secondary-color);
        }

        .stat-change.negative {
            color: #ef4444;
        }

        /* Recent Orders */
        .recent-orders {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid var(--border-color);
        }

        .orders-header {
            background: var(--gradient-primary);
            color: white;
            padding: 1rem 1.5rem;
            font-weight: 600;
        }

        .order-item {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all var(--transition-fast);
        }

        .order-item:hover {
            background: rgba(139, 69, 19, 0.02);
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .order-info {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .order-id {
            font-weight: 600;
            color: var(--primary-color);
        }

        .order-date {
            font-size: 0.875rem;
            color: var(--gray-color);
        }

        .order-status {
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-delivered {
            background: rgba(34, 197, 94, 0.1);
            color: #15803d;
        }

        .status-processing {
            background: rgba(59, 130, 246, 0.1);
            color: #1d4ed8;
        }

        .status-shipped {
            background: rgba(139, 69, 19, 0.1);
            color: var(--primary-color);
        }

        /* Quick Actions */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .action-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            border: 1px solid var(--border-color);
            transition: all var(--transition-medium);
            cursor: pointer;
            text-decoration: none;
            color: inherit;
        }

        .action-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-medium);
            border-color: var(--primary-color);
        }

        .action-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--gradient-primary);
            margin: 0 auto 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }

        .action-title {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        .action-description {
            font-size: 0.875rem;
            color: var(--gray-color);
        }

        /* Account Info */
        .account-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        .info-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .info-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--gray-color);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .info-value {
            font-size: 1rem;
            color: var(--dark-color);
            font-weight: 500;
        }

        .btn-edit-profile {
            background: var(--gradient-primary);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition-medium);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            width: fit-content;
            margin-top: 1rem;
        }

        .btn-edit-profile:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-medium);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .dashboard-container {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .dashboard-sidebar {
                position: static;
                order: 2;
            }

            .dashboard-main {
                order: 1;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .account-info {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .quick-actions {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="dashboard-wrapper">
        <div class="dashboard-container">
            <!-- Sidebar -->
            <aside class="dashboard-sidebar">
                <div class="user-profile">
                    <div class="user-avatar">
                        {{ strtoupper(substr($userData['user']['name'], 0, 1) . substr(strrchr($userData['user']['name'], ' '), 1, 1)) }}
                    </div>
                    <div class="user-name">{{ $userData['user']['name'] }}</div>
                    <div class="user-email">{{ $userData['user']['email'] }}</div>
                </div>

                <nav>
                    <ul class="nav-menu">
                        <li class="nav-item">
                            <a href="#overview" class="nav-link active">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <span>Overview</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#orders" class="nav-link">
                                <i class="nav-icon fas fa-shopping-bag"></i>
                                <span>My Orders</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#favorites" class="nav-link">
                                <i class="nav-icon fas fa-heart"></i>
                                <span>Favorites</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#profile" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <span>Profile</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#addresses" class="nav-link">
                                <i class="nav-icon fas fa-map-marker-alt"></i>
                                <span>Addresses</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#settings" class="nav-link">
                                <i class="nav-icon fas fa-cog"></i>
                                <span>Settings</span>
                            </a>
                        </li>
                        <li class="nav-item" style="width: 100%">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="nav-link" style="width: 100%">
                                    <i class="nav-icon fas fa-sign-out-alt"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </li>
                    </ul>
                </nav>
            </aside>

            @yield('content')
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Navigation functionality
            const navLinks = document.querySelectorAll('.nav-link');
            
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Remove active class from all links
                    navLinks.forEach(l => l.classList.remove('active'));
                    // Add active class to clicked link
                    this.classList.add('active');
                    
                    console.log('Navigation clicked:', this.textContent.trim());
                });
            });
            
            // Quick action cards
            const actionCards = document.querySelectorAll('.action-card');
            actionCards.forEach(card => {
                card.addEventListener('click', function() {
                    console.log('Quick action clicked:', this.querySelector('.action-title').textContent);
                });
            });
            
            // Order items click handler
            const orderItems = document.querySelectorAll('.order-item');
            orderItems.forEach(item => {
                item.addEventListener('click', function() {
                    const orderId = this.querySelector('.order-id').textContent;
                    console.log('Order clicked:', orderId);
                    // Add order details view functionality
                });
            });
            
            // Edit profile button
            const editProfileBtn = document.querySelector('.btn-edit-profile');
            editProfileBtn.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Edit profile clicked');
                // Add profile editing functionality
            });
            
            // Animate stat cards on scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };
            
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animationDelay = Math.random() * 0.3 + 's';
                        entry.target.classList.add('animate-fadeInUp');
                    }
                });
            }, observerOptions);
            
            // Observe stat cards
            const statCards = document.querySelectorAll('.stat-card');
            statCards.forEach(card => observer.observe(card));
            
            console.log('User dashboard loaded successfully!');
        });
    </script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Page-specific scripts -->
    @yield('scripts')
</body>

</html>
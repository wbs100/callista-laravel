@extends('layouts.public-site')

@section('content')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/interior.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/footer-optimizations.css') }}">
@endpush

<!-- Hero Section -->
<section class="interior-hero">
    <div class="hero-overlay"></div>
    <div class="container">
        <div class="hero-content">

            <h1>Transform Your Space with Expert <span class="gradient-text">Interior Design</span></h1>
            <p>From concept to completion, our experienced designers create stunning spaces that reflect your style and
                enhance your lifestyle. Comprehensive design solutions for homes and offices.</p>
            <div class="hero-actions">
                <button class="btn btn-primary">
                    <i class="fas fa-calendar-alt"></i>
                    Book Consultation
                </button>
                <button class="btn btn-outline">
                    <i class="fas fa-images"></i>
                    View Portfolio
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Services Overview -->
<section class="services-overview">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Our Interior Design Services</h2>
            <p class="section-subtitle">Complete design solutions tailored to your needs and budget</p>
        </div>
        <div class="services-grid">
            <div class="service-card" data-aos="fade-up" data-aos-delay="100">
                <div class="service-icon">
                    <i class="fas fa-home"></i>
                </div>
                <h3>Residential Design</h3>
                <p>Complete home makeovers, room-specific designs, and space optimization for modern living.</p>
                <ul class="service-features">
                    <li><i class="fas fa-check"></i> Living Room Design</li>
                    <li><i class="fas fa-check"></i> Bedroom Styling</li>
                    <li><i class="fas fa-check"></i> Kitchen Planning</li>
                    <li><i class="fas fa-check"></i> Bathroom Design</li>
                </ul>
                <div class="service-price">Starting from <span>LKR 150,000</span></div>
            </div>

            <div class="service-card featured" data-aos="fade-up" data-aos-delay="200">
                <div class="service-badge">Most Popular</div>
                <div class="service-icon">
                    <i class="fas fa-building"></i>
                </div>
                <h3>Commercial Design</h3>
                <p>Professional office spaces, retail stores, and commercial establishments that inspire productivity.
                </p>
                <ul class="service-features">
                    <li><i class="fas fa-check"></i> Office Space Planning</li>
                    <li><i class="fas fa-check"></i> Retail Store Design</li>
                    <li><i class="fas fa-check"></i> Reception Areas</li>
                    <li><i class="fas fa-check"></i> Meeting Rooms</li>
                </ul>
                <div class="service-price">Starting from <span>LKR 200,000</span></div>
            </div>

            <div class="service-card" data-aos="fade-up" data-aos-delay="300">
                <div class="service-icon">
                    <i class="fas fa-tools"></i>
                </div>
                <h3>Renovation & Remodeling</h3>
                <p>Transform existing spaces with modern design concepts and efficient space utilization.</p>
                <ul class="service-features">
                    <li><i class="fas fa-check"></i> Space Renovation</li>
                    <li><i class="fas fa-check"></i> Layout Optimization</li>
                    <li><i class="fas fa-check"></i> Modern Updates</li>
                    <li><i class="fas fa-check"></i> Value Enhancement</li>
                </ul>
                <div class="service-price">Starting from <span>LKR 100,000</span></div>
            </div>
        </div>
    </div>
</section>

<!-- Portfolio Showcase -->
<section class="portfolio-showcase">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Our Design Portfolio</h2>
            <p class="section-subtitle">Explore our latest projects and design inspirations</p>
        </div>

        <!-- Portfolio Filter -->
        <div class="portfolio-filter">
            <button class="filter-btn active" data-filter="all">All Projects</button>
            <button class="filter-btn" data-filter="residential">Residential</button>
            <button class="filter-btn" data-filter="commercial">Commercial</button>
            <button class="filter-btn" data-filter="renovation">Renovation</button>
        </div>

        <!-- Portfolio Search Bar -->
        <div class="portfolio-search-container">
            <div class="portfolio-search-wrapper">
                <i class="fas fa-search"></i>
                <input type="text" class="portfolio-search-input" id="portfolioSearchInput"
                    placeholder="Search projects by name, category, or description...">
                <button class="search-clear-btn" id="portfolioSearchClear" title="Clear search">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <!-- Portfolio Grid -->
        <div class="portfolio-grid" id="portfolioGrid">
            <!-- Residential Projects -->
            <div class="portfolio-item residential" data-aos="fade-up">
                <div class="portfolio-image">
                    <img src="../assets/funi (1).jpeg" alt="Modern Living Room"
                        onerror="this.src='../images/placeholder.jpg'">
                    <div class="portfolio-overlay">
                        <div class="portfolio-info">
                            <h3>Modern Living Room</h3>
                            <p>Contemporary design with minimalist approach</p>
                            <span class="portfolio-category">Residential</span>
                        </div>
                        <div class="portfolio-actions">
                            <button class="portfolio-btn" onclick="openPortfolioModal(1)" title="View Project Details">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="portfolio-btn" title="Add to Favorites">
                                <i class="fas fa-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="portfolio-item commercial" data-aos="fade-up" data-aos-delay="100">
                <div class="portfolio-image">
                    <img src="../assets/12 (2).png" alt="Executive Office"
                        onerror="this.src='../images/placeholder.jpg'">
                    <div class="portfolio-overlay">
                        <div class="portfolio-info">
                            <h3>Executive Office</h3>
                            <p>Professional workspace with luxury finishes</p>
                            <span class="portfolio-category">Commercial</span>
                        </div>
                        <div class="portfolio-actions">
                            <button class="portfolio-btn" onclick="openPortfolioModal(2)" title="View Project Details">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="portfolio-btn" title="Add to Favorites">
                                <i class="fas fa-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="portfolio-item residential" data-aos="fade-up" data-aos-delay="200">
                <div class="portfolio-image">
                    <img src="../assets/funi (3).jpeg" alt="Luxury Bedroom"
                        onerror="this.src='../images/placeholder.jpg'">
                    <div class="portfolio-overlay">
                        <div class="portfolio-info">
                            <h3>Luxury Bedroom Suite</h3>
                            <p>Elegant bedroom with custom furnishings</p>
                            <span class="portfolio-category">Residential</span>
                        </div>
                        <div class="portfolio-actions">
                            <button class="portfolio-btn" onclick="openPortfolioModal(3)" title="View Project Details">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="portfolio-btn" title="Add to Favorites">
                                <i class="fas fa-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="portfolio-item renovation" data-aos="fade-up" data-aos-delay="300">
                <div class="portfolio-image">
                    <img src="../assets/12 (4).png" alt="Kitchen Renovation"
                        onerror="this.src='../images/placeholder.jpg'">
                    <div class="portfolio-overlay">
                        <div class="portfolio-info">
                            <h3>Modern Kitchen</h3>
                            <p>Complete kitchen renovation with island</p>
                            <span class="portfolio-category">Renovation</span>
                        </div>
                        <div class="portfolio-actions">
                            <button class="portfolio-btn" onclick="openPortfolioModal(4)" title="View Project Details">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="portfolio-btn" title="Add to Favorites">
                                <i class="fas fa-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="portfolio-item commercial" data-aos="fade-up" data-aos-delay="400">
                <div class="portfolio-image">
                    <img src="../assets/12 (5).png" alt="Retail Store" onerror="this.src='../images/placeholder.jpg'">
                    <div class="portfolio-overlay">
                        <div class="portfolio-info">
                            <h3>Boutique Retail Store</h3>
                            <p>Modern retail space with custom displays</p>
                            <span class="portfolio-category">Commercial</span>
                        </div>
                        <div class="portfolio-actions">
                            <button class="portfolio-btn" onclick="openPortfolioModal(5)" title="View Project Details">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="portfolio-btn" title="Add to Favorites">
                                <i class="fas fa-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="portfolio-item residential" data-aos="fade-up" data-aos-delay="500">
                <div class="portfolio-image">
                    <img src="../assets/12 (3).png" alt="Dining Area" onerror="this.src='../images/placeholder.jpg'">
                    <div class="portfolio-overlay">
                        <div class="portfolio-info">
                            <h3>Elegant Dining Area</h3>
                            <p>Sophisticated dining space with statement lighting</p>
                            <span class="portfolio-category">Residential</span>
                        </div>
                        <div class="portfolio-actions">
                            <button class="portfolio-btn" onclick="openPortfolioModal(6)" title="View Project Details">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="portfolio-btn" title="Add to Favorites">
                                <i class="fas fa-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="portfolio-footer">
            <button class="btn btn-outline">
                <i class="fas fa-images"></i>
                View All Projects
            </button>
        </div>
    </div>
</section>

<!-- Design Process -->
<section class="design-process">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Our Design Process</h2>
            <p class="section-subtitle">From initial consultation to final installation, we guide you through every step
            </p>
        </div>
        <div class="process-timeline">
            <div class="process-step" data-aos="fade-right">
                <div class="step-number">01</div>
                <div class="step-content">
                    <h3>Initial Consultation</h3>
                    <p>We meet to understand your vision, requirements, and budget. Site measurement and assessment
                        included.</p>
                    <div class="step-features">
                        <span><i class="fas fa-clock"></i> 1-2 Hours</span>
                        <span><i class="fas fa-money-bill"></i> Free Consultation</span>
                    </div>
                </div>
            </div>

            <div class="process-step" data-aos="fade-left">
                <div class="step-number">02</div>
                <div class="step-content">
                    <h3>Design Development</h3>
                    <p>Our team creates detailed design concepts, 3D visualizations, and material selections for your
                        approval.</p>
                    <div class="step-features">
                        <span><i class="fas fa-clock"></i> 5-7 Days</span>
                        <span><i class="fas fa-cube"></i> 3D Visualization</span>
                    </div>
                </div>
            </div>

            <div class="process-step" data-aos="fade-right">
                <div class="step-number">03</div>
                <div class="step-content">
                    <h3>Project Planning</h3>
                    <p>Detailed project timeline, cost breakdown, and procurement planning. Final approval and contract
                        signing.</p>
                    <div class="step-features">
                        <span><i class="fas fa-clock"></i> 2-3 Days</span>
                        <span><i class="fas fa-file-contract"></i> Contract & Timeline</span>
                    </div>
                </div>
            </div>

            <div class="process-step" data-aos="fade-left">
                <div class="step-number">04</div>
                <div class="step-content">
                    <h3>Implementation</h3>
                    <p>Professional installation, furniture placement, and styling. Quality checks and final touches
                        included.</p>
                    <div class="step-features">
                        <span><i class="fas fa-clock"></i> 2-4 Weeks</span>
                        <span><i class="fas fa-tools"></i> Full Installation</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Consultation Booking -->
<section class="consultation-booking">
    <div class="container">
        <div class="booking-content">
            <div class="booking-info">
                <h2>Ready to Transform Your Space?</h2>
                <p>Book a free consultation with our expert interior designers. Let's discuss your vision and create
                    something beautiful together.</p>

                <div class="consultation-benefits">
                    <div class="benefit-item">
                        <i class="fas fa-gift"></i>
                        <div>
                            <h4>Free Consultation</h4>
                            <p>Initial meeting and site assessment at no cost</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <i class="fas fa-cube"></i>
                        <div>
                            <h4>3D Visualization</h4>
                            <p>See your space before implementation</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <i class="fas fa-headset"></i>
                        <div>
                            <h4>Expert Support</h4>
                            <p>Ongoing support throughout the project</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="booking-form">
                <form class="consultation-form" id="consultationForm">
                    <h3>Book Your Free Consultation</h3>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="firstName">First Name</label>
                            <input type="text" id="firstName" name="firstName" required>
                        </div>
                        <div class="form-group">
                            <label for="lastName">Last Name</label>
                            <input type="text" id="lastName" name="lastName" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="projectType">Project Type</label>
                        <select id="projectType" name="projectType" required>
                            <option value="">Select project type</option>
                            <option value="residential">Residential Design</option>
                            <option value="commercial">Commercial Design</option>
                            <option value="renovation">Renovation & Remodeling</option>
                            <option value="consultation">Design Consultation</option>
                        </select>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="budget">Budget Range</label>
                            <select id="budget" name="budget" required>
                                <option value="">Select budget range</option>
                                <option value="100000-300000">LKR 100,000 - 300,000</option>
                                <option value="300000-500000">LKR 300,000 - 500,000</option>
                                <option value="500000-1000000">LKR 500,000 - 1,000,000</option>
                                <option value="1000000+">Above LKR 1,000,000</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="preferredDate">Preferred Date</label>
                            <input type="date" id="preferredDate" name="preferredDate" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="projectDetails">Project Details</label>
                        <textarea id="projectDetails" name="projectDetails" rows="4"
                            placeholder="Tell us about your project, style preferences, and any specific requirements..."></textarea>
                    </div>

                    <div class="form-group">
                        <label for="location">Project Location</label>
                        <input type="text" id="location" name="location" placeholder="City, Area" required>
                    </div>

                    <button type="submit" class="btn btn-primary btn-full">
                        <i class="fas fa-calendar-check"></i>
                        Book Free Consultation
                    </button>

                    <p class="form-note">
                        <i class="fas fa-info-circle"></i>
                        We'll contact you within 24 hours to confirm your consultation appointment.
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="testimonials">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">What Our Clients Say</h2>
            <p class="section-subtitle">Real experiences from our satisfied customers</p>
        </div>
        <div class="testimonials-grid">
            <div class="testimonial-card" data-aos="fade-up">
                <div class="testimonial-content">
                    <div class="rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p>"Callista transformed our living room beyond our expectations. The team was professional,
                        creative, and delivered exactly what we envisioned. Highly recommended!"</p>
                    <div class="testimonial-author">
                        <img src="../assets/p.jpeg" alt="Sarah Fernando"
                            onerror="this.src='../images/avatar-placeholder.jpg'">
                        <div>
                            <h4>Sarah Fernando</h4>
                            <span>Colombo 07</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="testimonial-card" data-aos="fade-up" data-aos-delay="100">
                <div class="testimonial-content">
                    <div class="rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p>"Our office renovation was completed on time and within budget. The modern design has
                        significantly improved our work environment and team productivity."</p>
                    <div class="testimonial-author">
                        <img src="../assets/p (2).jpeg" alt="Rajesh Gupta"
                            onerror="this.src='../images/avatar-placeholder.jpg'">
                        <div>
                            <h4>Rajesh Gupta</h4>
                            <span>Business Owner, Kandy</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="testimonial-card" data-aos="fade-up" data-aos-delay="200">
                <div class="testimonial-content">
                    <div class="rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p>"The attention to detail and quality of work is exceptional. Every corner of our home reflects
                        our personality while maintaining elegance and functionality."</p>
                    <div class="testimonial-author">
                        <img src="../assets/p (3).jpeg" alt="Priya Wickramasinghe"
                            onerror="this.src='../images/avatar-placeholder.jpg'">
                        <div>
                            <h4>Priya Wickramasinghe</h4>
                            <span>Galle</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Frequently Asked Questions</h2>
            <p class="section-subtitle">Everything you need to know about our interior design services</p>
        </div>
        <div class="faq-container">
            <div class="faq-item">
                <button class="faq-question">
                    <span>How long does a typical interior design project take?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>Project timelines vary depending on scope and complexity. A single room design typically takes
                        2-4 weeks, while complete home renovations can take 6-12 weeks. We provide detailed timelines
                        during the planning phase.</p>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">
                    <span>What is included in the design consultation?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>Our free consultation includes site measurement, discussion of your requirements and style
                        preferences, initial design ideas, budget estimation, and project timeline planning.</p>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">
                    <span>Do you provide 3D visualizations?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>Yes, we provide detailed 3D visualizations for all our design projects. This helps you see
                        exactly how your space will look before implementation begins.</p>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">
                    <span>Can you work within my existing budget?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>Absolutely! We design solutions to fit various budgets. During consultation, we'll discuss your
                        budget and create a design plan that maximizes value while achieving your goals.</p>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">
                    <span>Do you handle furniture procurement and installation?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>Yes, we handle everything from furniture selection and procurement to delivery and installation.
                        We work with trusted suppliers to ensure quality and timely delivery.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')

<script src="{{ asset('assets/js/interior.js') }}"></script>

<!-- Performance Optimization -->
<script>
    // Optimize footer loading
    document.addEventListener('DOMContentLoaded', function() {
        // Remove unused CSS rules for better performance
        const unusedCSS = document.querySelector('link[href*="marketplace.css"]');
        if (unusedCSS) unusedCSS.remove();
        
        // Lazy load footer images
        const footerImages = document.querySelectorAll('.footer img');
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        if (img.dataset.src) {
                            img.src = img.dataset.src;
                            img.removeAttribute('data-src');
                            imageObserver.unobserve(img);
                        }
                    }
                });
            });
            
            footerImages.forEach(img => imageObserver.observe(img));
        }
        
        // Preload critical images only
        const criticalImages = ['../assets/images/logo.png'];
        criticalImages.forEach(src => {
            const link = document.createElement('link');
            link.rel = 'preload';
            link.as = 'image';
            link.href = src;
            document.head.appendChild(link);
        });
    });
</script>

@endpush

@endsection
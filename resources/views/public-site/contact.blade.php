@extends('layouts.public-site')

@section('content')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/contact.css') }}">
@endpush

<!-- Contact Hero Section -->
<section class="contact-hero">
    <div class="overlay"></div>
    <div class="hero-image-container">
        <img src="../assets/contact.png" alt="Modern office workspace" class="hero-background-image" />
    </div>
    <div class="container">
        <div class="hero-content">
            <div class="hero-badge">


            </div>
            <h1>Get In Touch With Our Design Team</h1>
            <p>Ready to transform your space? We'd love to hear about your project and discuss how we can bring your
                vision to life. Reach out today for a free consultation.</p>

            <div class="contact-methods">
                <div class="contact-method">
                    <div class="method-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div class="method-info">
                        <h3>Call Us</h3>
                        <p>+94 11 234 5678</p>
                        <span>Mon-Fri 9AM-6PM LKT</span>
                    </div>
                </div>

                <div class="contact-method">
                    <div class="method-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="method-info">
                        <h3>Email Us</h3>
                        <p>hello@callistalk.com</p>
                        <span>Response within 24 hours</span>
                    </div>
                </div>

                <div class="contact-method">
                    <div class="method-icon">
                        <i class="fas fa-calendar"></i>
                    </div>
                    <div class="method-info">
                        <h3>Schedule Meeting</h3>
                        <p>Book a consultation</p>
                        <span>Virtual or in-person</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Spacer Section -->
<section class="section-spacer">
    <div class="container">
        <div class="spacer-content">
            <div class="spacer-line"></div>
            <div class="spacer-icon">
                <i class="fas fa-star"></i>
            </div>
            <div class="spacer-line"></div>
        </div>
    </div>
</section>


<!-- Contact Form Section -->
<section class="contact-form-section">
    <div class="container">
        <div class="contact-content">
            <div class="contact-info">
                <div class="section-header">
                    <span class="section-subtitle">Start Your Project</span>
                    <h2>Tell Us About Your Vision</h2>
                </div>
                <p>Whether you're planning a complete home renovation, designing a new office space, or just need expert
                    advice, we're here to help. Fill out the form and we'll get back to you within 24 hours.</p>

                <div class="consultation-benefits">
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-comments"></i>
                        </div>
                        <div class="benefit-content">
                            <h4>Free Initial Consultation</h4>
                            <p>60-minute session to discuss your project goals, timeline, and budget.</p>
                        </div>
                    </div>

                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-drafting-compass"></i>
                        </div>
                        <div class="benefit-content">
                            <h4>Custom Design Proposal</h4>
                            <p>Detailed project proposal with timeline, scope, and investment overview.</p>
                        </div>
                    </div>

                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <div class="benefit-content">
                            <h4>No Obligation</h4>
                            <p>Our consultation is completely free with no strings attached.</p>
                        </div>
                    </div>
                </div>

                <div class="urgent-contact">
                    <div class="urgent-info">
                        <i class="fas fa-clock"></i>
                        <div>
                            <h4>Need Urgent Assistance?</h4>
                            <p>Call us directly at <a href="tel:+15551234567">(555) 123-4567</a> for immediate support.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="contact-form">
                <form id="contact-form" class="consultation-form">
                    <h3>Project Inquiry Form</h3>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="firstName">First Name *</label>
                            <input type="text" id="firstName" name="firstName" required>
                        </div>
                        <div class="form-group">
                            <label for="lastName">Last Name *</label>
                            <input type="text" id="lastName" name="lastName" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="projectType">Project Type *</label>
                        <select id="projectType" name="projectType" required>
                            <option value="">Select project type</option>
                            <option value="residential-full">Full Home Design</option>
                            <option value="residential-room">Single Room Design</option>
                            <option value="commercial-office">Office Design</option>
                            <option value="commercial-retail">Retail Space</option>
                            <option value="commercial-restaurant">Restaurant/Hospitality</option>
                            <option value="consultation">Design Consultation</option>
                            <option value="renovation">Renovation Project</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="budget">Project Budget</label>
                            <select id="budget" name="budget">
                                <option value="">Select budget range</option>
                                <option value="under-25k">Under $25,000</option>
                                <option value="25k-50k">$25,000 - $50,000</option>
                                <option value="50k-100k">$50,000 - $100,000</option>
                                <option value="100k-250k">$100,000 - $250,000</option>
                                <option value="250k-500k">$250,000 - $500,000</option>
                                <option value="over-500k">Over $500,000</option>
                                <option value="not-sure">Not sure yet</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="timeline">Preferred Timeline</label>
                            <select id="timeline" name="timeline">
                                <option value="">Select timeline</option>
                                <option value="asap">As soon as possible</option>
                                <option value="1-3-months">1-3 months</option>
                                <option value="3-6-months">3-6 months</option>
                                <option value="6-12-months">6-12 months</option>
                                <option value="over-year">Over a year</option>
                                <option value="flexible">Flexible</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="location">Project Location</label>
                        <input type="text" id="location" name="location" placeholder="City, State">
                    </div>

                    <div class="form-group">
                        <label for="projectDescription">Tell us about your project *</label>
                        <textarea id="projectDescription" name="projectDescription" rows="5"
                            placeholder="Describe your vision, style preferences, specific needs, or any questions you have..."
                            required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="inspiration">How did you hear about us?</label>
                        <select id="inspiration" name="inspiration">
                            <option value="">Select an option</option>
                            <option value="google">Google Search</option>
                            <option value="social-media">Social Media</option>
                            <option value="referral">Friend/Family Referral</option>
                            <option value="magazine">Magazine/Publication</option>
                            <option value="website">Design Website/Blog</option>
                            <option value="past-client">Past Client</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="form-group checkbox-group">
                        <label class="checkbox-label">
                            <input type="checkbox" id="newsletter" name="newsletter">
                            <span class="checkmark"></span>
                            Subscribe to our newsletter for design tips and inspiration
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-full">
                        <i class="fas fa-paper-plane"></i>
                        Send My Inquiry
                    </button>

                    <div class="form-note">
                        <i class="fas fa-shield-alt"></i>
                        Your information is secure and will never be shared with third parties.
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Office Locations Section -->
<section class="locations-section">
    <div class="container">
        <div class="section-header text-center">
            <span class="section-subtitle">Visit Us</span>
            <h2>Our Studio Locations</h2>
            <p>Visit our showrooms to experience our design aesthetic firsthand and meet with our team in person.</p>
        </div>

        <div class="locations-grid">
            <div class="location-card">
                <div class="location-image">
                    <img src="../assets/offic.png" alt="Manhattan Studio">
                    <div class="location-badge">Main Studio</div>
                </div>
                <div class="location-info">
                    <h3>Manhattan Design Studio</h3>
                    <div class="location-details">
                        <div class="detail-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>123 Design Street, Creative District, NY 10001</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-phone"></i>
                            <span>(555) 123-4567</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-clock"></i>
                            <span>Mon-Fri: 9AM-6PM | Sat: 10AM-4PM</span>
                        </div>
                    </div>
                    <p>Our flagship studio featuring a full showroom, material library, and consultation spaces.</p>
                    <div class="location-actions">
                        <a href="#" class="btn btn-outline">Get Directions</a>
                        <a href="#" class="btn btn-primary">Schedule Visit</a>
                    </div>
                </div>
            </div>

            <div class="location-card">
                <div class="location-image">
                    <img src="../assets/offic.png" alt="Brooklyn Studio">
                    <div class="location-badge">Satellite Office</div>
                </div>
                <div class="location-info">
                    <h3>Brooklyn Showroom</h3>
                    <div class="location-details">
                        <div class="detail-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>456 Industrial Ave, DUMBO, Brooklyn, NY 11201</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-phone"></i>
                            <span>(555) 987-6543</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-clock"></i>
                            <span>Tue-Sat: 10AM-6PM | Sun: 12PM-4PM</span>
                        </div>
                    </div>
                    <p>Modern showroom space showcasing contemporary and industrial design elements.</p>
                    <div class="location-actions">
                        <a href="#" class="btn btn-outline">Get Directions</a>
                        <a href="#" class="btn btn-primary">Schedule Visit</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="map-section">
    <div class="container">
        <div class="section-header text-center">
            <span class="section-subtitle">Visit Our Studio</span>
            <h2>Find Us in Colombo</h2>
            <p>Located in the heart of Colombo, our studio is easily accessible and features our latest design
                collections.</p>
        </div>

        <div class="map-container">
            <div class="map-placeholder">
                <!-- Sri Lankan map centered on Colombo -->
                <iframe class="map-iframe" src="https://maps.google.com/maps?q=6.9271,79.8612&z=12&output=embed"
                    allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                    title="Callista LK Studio Location - Colombo, Sri Lanka">
                </iframe>
            </div>

            <div class="map-info">
                <h3>Easy to Find in Colombo</h3>
                <p>Our studio is conveniently located in Colombo with easy access to public transportation and parking
                    facilities.</p>

                <div class="transportation-info">
                    <div class="transport-item">
                        <i class="fas fa-bus"></i>
                        <div>
                            <h4>Public Transport</h4>
                            <p>Multiple bus routes and train stations nearby</p>
                        </div>
                    </div>

                    <div class="transport-item">
                        <i class="fas fa-car"></i>
                        <div>
                            <h4>Parking</h4>
                            <p>Complimentary parking for consultations</p>
                        </div>
                    </div>

                    <div class="transport-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <h4>Address</h4>
                            <p>123 Design Street, Colombo 03, Sri Lanka</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Social Media Section -->
<section class="social-media-section">
    <div class="container">
        <div class="section-header text-center">
            <span class="section-subtitle">Connect With Us</span>
            <h2>Follow Our Design Journey</h2>
            <p>Stay connected with Callista LK for the latest design inspiration, project updates, and furniture
                collections.</p>
        </div>

        <div class="social-media-grid">
            <div class="social-card" data-platform="facebook">
                <div class="social-icon-wrapper">
                    <div class="social-icon">
                        <i class="fab fa-facebook-f"></i>
                    </div>
                    <div class="social-glow"></div>
                </div>
                <div class="social-content">
                    <h3>Facebook</h3>
                    <p>Latest projects & behind-the-scenes</p>
                    <span class="follower-count">12.5K Followers</span>
                    <a href="#" class="social-btn">
                        <span>Follow Us</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="social-bg-pattern"></div>
            </div>

            <div class="social-card" data-platform="instagram">
                <div class="social-icon-wrapper">
                    <div class="social-icon">
                        <i class="fab fa-instagram"></i>
                    </div>
                    <div class="social-glow"></div>
                </div>
                <div class="social-content">
                    <h3>Instagram</h3>
                    <p>Design inspiration & lifestyle</p>
                    <span class="follower-count">25.3K Followers</span>
                    <a href="#" class="social-btn">
                        <span>Follow Us</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="social-bg-pattern"></div>
            </div>

            <div class="social-card" data-platform="youtube">
                <div class="social-icon-wrapper">
                    <div class="social-icon">
                        <i class="fab fa-youtube"></i>
                    </div>
                    <div class="social-glow"></div>
                </div>
                <div class="social-content">
                    <h3>YouTube</h3>
                    <p>Design tutorials & room tours</p>
                    <span class="follower-count">8.7K Subscribers</span>
                    <a href="#" class="social-btn">
                        <span>Subscribe</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="social-bg-pattern"></div>
            </div>

            <div class="social-card" data-platform="linkedin">
                <div class="social-icon-wrapper">
                    <div class="social-icon">
                        <i class="fab fa-linkedin-in"></i>
                    </div>
                    <div class="social-glow"></div>
                </div>
                <div class="social-content">
                    <h3>LinkedIn</h3>
                    <p>Professional insights & updates</p>
                    <span class="follower-count">5.2K Connections</span>
                    <a href="#" class="social-btn">
                        <span>Connect</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="social-bg-pattern"></div>
            </div>

            <div class="social-card" data-platform="pinterest">
                <div class="social-icon-wrapper">
                    <div class="social-icon">
                        <i class="fab fa-pinterest-p"></i>
                    </div>
                    <div class="social-glow"></div>
                </div>
                <div class="social-content">
                    <h3>Pinterest</h3>
                    <p>Design boards & inspiration</p>
                    <span class="follower-count">15.8K Followers</span>
                    <a href="#" class="social-btn">
                        <span>Follow Us</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="social-bg-pattern"></div>
            </div>

            <div class="social-card" data-platform="tiktok">
                <div class="social-icon-wrapper">
                    <div class="social-icon">
                        <i class="fab fa-tiktok"></i>
                    </div>
                    <div class="social-glow"></div>
                </div>
                <div class="social-content">
                    <h3>TikTok</h3>
                    <p>Quick design tips & trends</p>
                    <span class="follower-count">32.1K Followers</span>
                    <a href="#" class="social-btn">
                        <span>Follow Us</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="social-bg-pattern"></div>
            </div>
        </div>

        <!-- Newsletter CTA -->
        <div class="newsletter-cta">
            <div class="newsletter-content">
                <div class="newsletter-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="newsletter-text">
                    <h3>Stay Updated</h3>
                    <p>Get the latest design tips and exclusive offers delivered to your inbox</p>
                </div>
                <div class="newsletter-form">
                    <div class="input-group">
                        <input type="email" placeholder="Enter your email address" required>
                        <button type="submit" class="subscribe-btn">
                            <span>Subscribe</span>
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section">
    <div class="container">
        <div class="section-header text-center">
            <span class="section-subtitle">Common Questions</span>
            <h2>Frequently Asked Questions</h2>
            <p>Here are answers to some of the most common questions we receive about our design process and services.
            </p>
        </div>

        <div class="faq-container">
            <div class="faq-item">
                <button class="faq-question">
                    How much does an interior design project typically cost?
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>Project costs vary significantly based on scope, size, and complexity. Our residential projects
                        typically range from $25,000 to $500,000+. We provide detailed proposals after our initial
                        consultation so you know exactly what to expect.</p>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">
                    How long does a typical design project take?
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>Timeline depends on project scope. Single room designs typically take 6-12 weeks, while full home
                        projects can take 4-8 months. We'll provide a detailed timeline during your consultation.</p>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">
                    Do you work on projects outside of New York?
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>Yes! We work on projects nationwide and internationally. For projects outside the NYC area, we
                        offer virtual design services and can coordinate with local contractors and vendors.</p>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">
                    What's included in the initial consultation?
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>Our complimentary 60-minute consultation includes a space assessment, discussion of your goals
                        and style preferences, timeline review, and preliminary budget discussion. You'll leave with
                        actionable insights and next steps.</p>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">
                    Do you handle the construction and installation?
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>We coordinate all aspects of your project, working with trusted contractors, vendors, and
                        craftspeople. We handle project management, quality control, and timeline coordination so you
                        don't have to.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script src="{{ asset('assets/js/contact.js') }}"></script>
<script>
$(document).ready(function() {
    $('#contact-form').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var btn = form.find('button[type="submit"]');
        btn.prop('disabled', true);
        $.ajax({
            url: '{{ route('project-inquiry.store') }}',
            method: 'POST',
            data: form.serialize(),
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Inquiry Submitted!',
                    text: response.message || 'Your project inquiry has been received. We will contact you soon.'
                });
                form[0].reset();
            },
            error: function(xhr) {
                let msg = 'An error occurred. Please check your input.';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    msg = Object.values(xhr.responseJSON.errors).join('\n');
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Submission Failed',
                    text: msg
                });
            },
            complete: function() {
                btn.prop('disabled', false);
            }
        });
    });
});
</script>
@endpush

@endsection
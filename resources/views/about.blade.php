<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About Us - Nakawa Market Savings Group</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #2e7d32; /* Deep Green */
            --secondary: #4caf50; /* Medium Green */
            --accent: #d7ccc8; /* Light Beige */
            --light-beige: #f5f5f1; /* Very Light Beige */
            --dark-green: #1b5e20; /* Dark Green */
            --text-dark: #333333;
            --text-light: #f8f9fa;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            padding-top: 76px;
        }
        
        /* Navigation Styles */
        .navbar {
            background: rgba(245, 245, 241, 0.95) !important;
            backdrop-filter: blur(10px);
            padding: 1rem 0;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        
        .navbar.scrolled {
            background: rgba(245, 245, 241, 0.98) !important;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            display: flex;
            align-items: center;
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary) !important;
        }
        
        .logo-container {
            width: 50px;
            height: 50px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border: 2px solid var(--primary);
            overflow: hidden;
        }
        
        .logo-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }
        
        .logo-text {
            color: var(--primary);
            font-weight: 700;
            background: none;
            -webkit-text-fill-color: var(--primary);
        }
        
        .nav-link {
            color: var(--text-dark) !important;
            font-weight: 500;
            margin: 0 5px;
            padding: 8px 16px !important;
            border-radius: 25px;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .nav-link:hover {
            color: var(--primary) !important;
        }
        
        .nav-link:hover::after {
            width: 70%;
        }
        
        .nav-link.active {
            color: var(--primary) !important;
            font-weight: 600;
        }
        
        .nav-link.active::after {
            width: 70%;
        }
        
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary), var(--dark-green));
            border: none;
            border-radius: 25px;
            padding: 10px 25px;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(46, 125, 50, 0.3);
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(46, 125, 50, 0.4);
            color: white;
        }
        
        /* Hero Section */
        .page-hero {
            background: linear-gradient(135deg, var(--primary) 0%, var(--dark-green) 100%);
            color: white;
            padding: 100px 0 60px;
            position: relative;
            overflow: hidden;
        }
        
        .page-hero::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 300px;
            height: 300px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            transform: translate(100px, -100px);
        }
        
        .page-hero::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 200px;
            height: 200px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            transform: translate(-50px, 50px);
        }
        
        /* Feature Icons */
        .feature-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            transition: all 0.3s ease;
        }
        
        .feature-icon:hover {
            transform: scale(1.1) rotate(5deg);
        }
        
        .stat-card {
            padding: 2rem 1rem;
            border-radius: 15px;
            transition: all 0.3s ease;
            background: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            border: 1px solid rgba(0,0,0,0.05);
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        
        .bg-light-custom {
            background-color: var(--light-beige) !important;
        }
        
        .timeline {
            position: relative;
            padding-left: 2rem;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: var(--primary);
            border-radius: 2px;
        }
        
        .timeline-item {
            position: relative;
            margin-bottom: 2rem;
        }
        
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -2.3rem;
            top: 0.5rem;
            width: 12px;
            height: 12px;
            background: var(--primary);
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 0 0 3px var(--primary);
        }
        
        /* Professional Footer */
        .professional-footer {
            background: linear-gradient(135deg, var(--dark-green) 0%, #1a472a 100%);
            color: white;
            padding: 3rem 0 1rem;
            margin-top: 4rem;
        }
        
        .footer-logo {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .footer-links h5 {
            color: var(--accent);
            margin-bottom: 1rem;
            font-weight: 600;
        }
        
        .footer-links a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            display: block;
            margin-bottom: 0.5rem;
        }
        
        .footer-links a:hover {
            color: white;
            transform: translateX(5px);
        }
        
        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            margin-right: 10px;
            transition: all 0.3s ease;
        }
        
        .social-links a:hover {
            background: var(--primary);
            transform: translateY(-3px);
        }
        
        .footer-divider {
            border-color: rgba(255,255,255,0.2) !important;
            margin: 2rem 0;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .navbar-brand span {
                display: none;
            }
            
            .nav-link::after {
                display: none;
            }
            
            .page-hero {
                padding: 80px 0 40px;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
               
                <span class="logo-text">Nakawa Savings</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('faqs') }}">FAQs</a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i>Log in
                        </a>
                    </li>
                    <li class="nav-item ms-2">
                        <a class="btn btn-primary-custom" href="{{ route('register') }}">
                            <i class="fas fa-user-plus me-1"></i>Register
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="page-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-5 fw-bold mb-4">About Nakawa Savings Group</h1>
                    <p class="lead mb-0">Building financial resilience for market vendors since 2019</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Story Section -->
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="fw-bold text-primary mb-4">Our Story</h2>
                    <p class="text-muted mb-4">
                        Founded in 2019, Nakawa Market Savings Group emerged from the collective vision of local market vendors 
                        who recognized the need for a reliable, community-driven savings solution. What began as a small initiative 
                        among 15 dedicated vendors has blossomed into a thriving financial community.
                    </p>
                    <p class="text-muted">
                        Today, we proudly serve over 250 active members and manage savings exceeding UGX 150 million. Our journey 
                        reflects the power of unity, trust, and shared financial goals in transforming individual lives and 
                        strengthening our community.
                    </p>
                </div>
                <div class="col-lg-6 text-center">
                    <div class="feature-icon bg-primary text-white mx-auto">
                        <i class="fas fa-history fa-2x"></i>
                    </div>
                    <div class="stat-card mt-4">
                        <h4 class="text-primary">From Humble Beginnings</h4>
                        <p class="text-muted mb-0">Started with 15 vendors, now serving 250+ members</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision -->
    <section class="py-5 bg-light-custom">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6">
                    <div class="stat-card h-100 text-center">
                        <div class="feature-icon bg-success text-white mx-auto">
                            <i class="fas fa-bullseye fa-2x"></i>
                        </div>
                        <h3 class="text-success mb-3">Our Mission</h3>
                        <p class="text-muted">
                            To empower market vendors and small business owners with secure, accessible savings solutions 
                            that foster financial discipline, growth, and community prosperity through transparent operations 
                            and mutual support.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="stat-card h-100 text-center">
                        <div class="feature-icon bg-warning text-white mx-auto">
                            <i class="fas fa-eye fa-2x"></i>
                        </div>
                        <h3 class="text-warning mb-3">Our Vision</h3>
                        <p class="text-muted">
                            To become the leading community-based savings platform in Uganda, recognized for transforming 
                            lives through financial inclusion, education, and sustainable wealth creation for all members.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Journey -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-primary">Our Journey</h2>
                <p class="lead text-muted">Milestones that shaped our growth</p>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="timeline">
                        <div class="timeline-item">
                            <h5 class="fw-bold text-primary">2019 - Foundation</h5>
                            <p class="text-muted">Started with 15 founding members and a shared vision for community savings</p>
                        </div>
                        <div class="timeline-item">
                            <h5 class="fw-bold text-primary">2020 - Digital Transformation</h5>
                            <p class="text-muted">Launched our digital platform to enhance member experience and accessibility</p>
                        </div>
                        <div class="timeline-item">
                            <h5 class="fw-bold text-primary">2021 - Growth Phase</h5>
                            <p class="text-muted">Reached 100+ members and UGX 50M in total savings</p>
                        </div>
                        <div class="timeline-item">
                            <h5 class="fw-bold text-primary">2022 - Expansion</h5>
                            <p class="text-muted">Introduced new financial products and reached 200+ members</p>
                        </div>
                        <div class="timeline-item">
                            <h5 class="fw-bold text-primary">2023 - Milestone</h5>
                            <p class="text-muted">Surpassed UGX 150M in total savings with 250+ active members</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="py-5 bg-light-custom">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-primary">Our Values</h2>
                <p class="lead text-muted">The principles that guide everything we do</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="stat-card h-100 text-center">
                        <div class="feature-icon bg-primary text-white">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4>Trust & Security</h4>
                        <p class="text-muted">Your savings are protected with multiple layers of security and transparent operations.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card h-100 text-center">
                        <div class="feature-icon bg-success text-white">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4>Community First</h4>
                        <p class="text-muted">We believe in the power of collective growth and mutual support among members.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card h-100 text-center">
                        <div class="feature-icon bg-warning text-white">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h4>Financial Education</h4>
                        <p class="text-muted">Empowering members with knowledge to make informed financial decisions.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h2 class="fw-bold mb-4">Join Our Growing Community</h2>
                    <p class="lead mb-4">Become part of a savings group that truly cares about your financial success.</p>
                    <a href="{{ route('register') }}" class="btn btn-primary-custom btn-lg">
                        <i class="fas fa-user-plus me-2"></i>Start Your Journey Today
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Professional Footer -->
    <footer class="professional-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="footer-logo">
                        <div class="d-flex align-items-center">
                            <div class="logo-container me-3">
                                <i class="fas fa-piggy-bank text-primary"></i>
                            </div>
                            Nakawa Savings
                        </div>
                    </div>
                    <p class="mb-4" style="color: rgba(255,255,255,0.8);">
                        Empowering market vendors with secure savings solutions and financial growth opportunities since 2019.
                    </p>
                    <div class="social-links">
                        <a href="https://www.facebook.com" target="_blank" class="text-white"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.twitter.com" target="_blank" class="text-white"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.whatsapp.com" target="_blank" class="text-white"><i class="fab fa-whatsapp"></i></a>
                        <a href="https://www.linkedin.com" target="_blank" class="text-white"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6 mb-4">
                    <div class="footer-links">
                        <h5>Quick Links</h5>
                        <a href="{{ route('home') }}">Home</a>
                        <a href="{{ route('about') }}">About Us</a>
                        <a href="{{ route('faqs') }}">FAQs</a>
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="footer-links">
                        <h5>Services</h5>
                        <a href="#">Daily Savings</a>
                        <a href="#">Loans</a>
                        <a href="#">Financial Advice</a>
                        <a href="#">Business Support</a>
                        <a href="#">Member Training</a>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="footer-links">
                        <h5>Contact Info</h5>
                        <p style="color: rgba(255,255,255,0.8); margin-bottom: 1rem;">
                            <i class="fas fa-map-marker-alt me-2"></i>Nakawa Market, Kampala
                        </p>
                        <p style="color: rgba(255,255,255,0.8); margin-bottom: 1rem;">
                            <i class="fas fa-phone me-2"></i>+256 700 123 456
                        </p>
                        <p style="color: rgba(255,255,255,0.8); margin-bottom: 1rem;">
                            <i class="fas fa-envelope me-2"></i>info@nakawasavings.com
                        </p>
                        <p style="color: rgba(255,255,255,0.8);">
                            <i class="fas fa-clock me-2"></i>Mon-Fri: 8AM-6PM
                        </p>
                    </div>
                </div>
            </div>
            
            <hr class="footer-divider">
            
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0" style="color: rgba(255,255,255,0.7);">
                        &copy; 2024 Nakawa Market Savings Group. All rights reserved.
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" style="color: rgba(255,255,255,0.7); text-decoration: none; margin-left: 20px;">Privacy Policy</a>
                    <a href="#" style="color: rgba(255,255,255,0.7); text-decoration: none; margin-left: 20px;">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>
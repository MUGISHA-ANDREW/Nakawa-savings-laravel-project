<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nakawa Market Savings Group</title>
    
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
        
        .btn-outline-custom {
            border: 2px solid var(--primary);
            border-radius: 25px;
            padding: 10px 25px;
            font-weight: 600;
            color: var(--primary);
            transition: all 0.3s ease;
        }
        
        .btn-outline-custom:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
        }
        
        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--primary) 0%, var(--dark-green) 100%);
            color: white;
            padding: 150px 0 100px;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 400px;
            height: 400px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            transform: translate(150px, -150px);
        }
        
        .hero-section::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 300px;
            height: 300px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            transform: translate(-100px, 100px);
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .hero-section h1 {
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .hero-section .lead {
            font-size: 1.25rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }
        
        .btn-success {
            background: linear-gradient(135deg, var(--secondary), var(--primary));
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(46, 125, 50, 0.3);
        }
        
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(46, 125, 50, 0.4);
        }
        
        .btn-light-custom {
            background: rgba(255,255,255,0.2);
            border: 2px solid rgba(255,255,255,0.5);
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
        }
        
        .btn-light-custom:hover {
            background: white;
            color: var(--primary);
            transform: translateY(-2px);
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
        
        .stat-card h3 {
            font-weight: 700;
            margin: 1rem 0 0.5rem;
        }
        
        /* Section Backgrounds */
        .bg-light-custom {
            background-color: var(--light-beige) !important;
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
            .hero-section {
                padding: 120px 0 80px;
                text-align: center;
            }
            
            .hero-section h1 {
                font-size: 2.5rem;
            }
            
            .navbar-brand span {
                display: none;
            }
            
            .nav-link::after {
                display: none;
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
                        <a class="nav-link active" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">About</a>
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
    <section class="hero-section">
        <div class="container hero-content">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">Growing Together, Saving Together</h1>
                    <p class="lead mb-4">Join Nakawa Market's trusted savings community. Build your financial future with secure, transparent group savings.</p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="{{ route('register') }}" class="btn btn-success btn-lg">
                            <i class="fas fa-user-plus me-2"></i>Join Our Group
                        </a>
                        <a href="{{ route('about') }}" class="btn btn-light-custom btn-lg">
                            Learn More
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <div class="feature-icon mx-auto" style="background: rgba(255,255,255,0.2);">
                        <i class="fas fa-piggy-bank fa-4x text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="stat-card text-center">
                        <div class="feature-icon mx-auto bg-primary text-white">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                        <h3 class="text-primary">250+</h3>
                        <p class="text-muted">Active Members</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card text-center">
                        <div class="feature-icon mx-auto bg-success text-white">
                            <i class="fas fa-money-bill-wave fa-2x"></i>
                        </div>
                        <h3 class="text-success">UGX 150M+</h3>
                        <p class="text-muted">Total Savings</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card text-center">
                        <div class="feature-icon mx-auto bg-warning text-white">
                            <i class="fas fa-calendar-check fa-2x"></i>
                        </div>
                        <h3 class="text-warning">5+</h3>
                        <p class="text-muted">Years Operating</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card text-center">
                        <div class="feature-icon mx-auto bg-info text-white">
                            <i class="fas fa-handshake fa-2x"></i>
                        </div>
                        <h3 class="text-info">98%</h3>
                        <p class="text-muted">Member Satisfaction</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5 bg-light-custom">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Why Choose Nakawa Savings?</h2>
                <p class="lead text-muted">Experience financial growth with our secure and transparent system</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="stat-card h-100">
                        <div class="feature-icon bg-primary text-white">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4 class="text-center">Secure & Trusted</h4>
                        <p class="text-muted">Your savings are protected with advanced security measures and transparent tracking.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card h-100">
                        <div class="feature-icon bg-success text-white">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4 class="text-center">Growth Focused</h4>
                        <p class="text-muted">Watch your savings grow with competitive returns and disciplined financial management.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card h-100">
                        <div class="feature-icon bg-warning text-white">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h4 class="text-center">Digital Access</h4>
                        <p class="text-muted">Manage your savings anytime, anywhere with our easy-to-use digital platform.</p>
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
                    <h2 class="fw-bold mb-4">Ready to Start Your Savings Journey?</h2>
                    <p class="lead mb-4">Join hundreds of market vendors who are already building their financial future with us.</p>
                    <a href="{{ route('register') }}" class="btn btn-primary-custom btn-lg">
                        <i class="fas fa-user-plus me-2"></i>Become a Member Today
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

        // Add active class to current page
        document.addEventListener('DOMContentLoaded', function() {
            const currentLocation = location.pathname;
            const navLinks = document.querySelectorAll('.nav-link');
            
            navLinks.forEach(link => {
                if(link.getAttribute('href') === currentLocation) {
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>
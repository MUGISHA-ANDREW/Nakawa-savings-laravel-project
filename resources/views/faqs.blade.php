<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FAQs - Nakawa Market Savings Group</title>
    
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
        
        /* Accordion Styles */
        .accordion-button {
            font-weight: 600;
            padding: 1.25rem;
            border: none;
            background: white;
        }
        
        .accordion-button:not(.collapsed) {
            background: var(--light-beige);
            color: var(--primary);
            box-shadow: none;
        }
        
        .accordion-button:focus {
            box-shadow: none;
            border-color: var(--primary);
        }
        
        .accordion-item {
            border: 1px solid rgba(0,0,0,0.1);
            border-radius: 10px !important;
            margin-bottom: 1rem;
            overflow: hidden;
        }
        
        .accordion-body {
            padding: 1.25rem;
            background: white;
        }
        
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
        
        .stat-card {
            padding: 2rem 1rem;
            border-radius: 15px;
            transition: all 0.3s ease;
            background: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            border: 1px solid rgba(0,0,0,0.05);
        }
        
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
                        <a class="nav-link" href="{{ route('about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('faqs') }}">FAQs</a>
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
                    <h1 class="display-5 fw-bold mb-4">Frequently Asked Questions</h1>
                    <p class="lead mb-0">Find answers to common questions about our savings group</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQs Section -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <!-- Membership Questions -->
                    <div class="mb-5">
                        <h3 class="fw-bold mb-4 text-primary">
                            <i class="fas fa-users me-2"></i>Membership & Registration
                        </h3>
                        <div class="accordion" id="membershipAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#membership1">
                                        Who can join Nakawa Savings Group?
                                    </button>
                                </h2>
                                <div id="membership1" class="accordion-collapse collapse show" data-bs-parent="#membershipAccordion">
                                    <div class="accordion-body text-muted">
                                        Any vendor, small business owner, or resident operating in or around Nakawa Market area 
                                        is welcome to join. You must be 18 years or older and committed to regular savings.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#membership2">
                                        How do I register as a member?
                                    </button>
                                </h2>
                                <div id="membership2" class="accordion-collapse collapse" data-bs-parent="#membershipAccordion">
                                    <div class="accordion-body text-muted">
                                       Registration is simple! Click on the "Register" button at the top right of the page,
                                       fill out the registration form with your details, and submit. Once approved, you'll receive
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#membership3">
                                        Are there any membership fees?
                                    </button>
                                </h2>
                                <div id="membership3" class="accordion-collapse collapse" data-bs-parent="#membershipAccordion">
                                    <div class="accordion-body text-muted">
                                        No, there are no annual or hidden membership fees. We believe in transparent savings without extra costs.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Savings Questions -->
                    <div class="mb-5">
                        <h3 class="fw-bold mb-4 text-success">
                            <i class="fas fa-piggy-bank me-2"></i>Savings & Transactions
                        </h3>
                        <div class="accordion" id="savingsAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#savings1">
                                        What is the minimum savings amount?
                                    </button>
                                </h2>
                                <div id="savings1" class="accordion-collapse collapse show" data-bs-parent="#savingsAccordion">
                                    <div class="accordion-body text-muted">
                                        The minimum daily savings amount is UGX 1,000. However, you can save more based on 
                                        your capacity. Regular savings help build your financial discipline and grow your funds faster.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#savings2">
                                        How do I make deposits and withdrawals?
                                    </button>
                                </h2>
                                <div id="savings2" class="accordion-collapse collapse" data-bs-parent="#savingsAccordion">
                                    <div class="accordion-body text-muted">
                                        After logging into your member dashboard, you can initiate deposits. For deposits, you'll receive payment instructions.
                                        You can also visit our office for in-person transactions. We're here to assist you every step of the way!. We're open all working days from 8am to 5pm.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#savings3">
                                        Can I withdraw my savings anytime?
                                    </button>
                                </h2>
                                <div id="savings3" class="accordion-collapse collapse" data-bs-parent="#savingsAccordion">
                                    <div class="accordion-body text-muted">
                                        No, withdrawals can be made at the end of each year on 31 December of each year.   
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Security Questions -->
                    <div class="mb-5">
                        <h3 class="fw-bold mb-4 text-warning">
                            <i class="fas fa-shield-alt me-2"></i>Security & Trust
                        </h3>
                        <div class="accordion" id="securityAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#security1">
                                        How are my savings secured?
                                    </button>
                                </h2>
                                <div id="security1" class="accordion-collapse collapse show" data-bs-parent="#securityAccordion">
                                    <div class="accordion-body text-muted">
                                        Your savings are secured through multiple measures including bank guarantees, 
                                        transparent record-keeping, and regular audits. We maintain 100% reserve backing for all member savings 
                                        and follow strict financial protocols to ensure the safety of your funds.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#security2">
                                        Is my financial data secure?
                                    </button>
                                </h2>
                                <div id="security2" class="accordion-collapse collapse" data-bs-parent="#securityAccordion">
                                    <div class="accordion-body text-muted">
                                        Yes! We use bank-level security measures to protect your data. All transactions are 
                                        encrypted, and we regularly backup our systems. Your financial information is only 
                                        accessible to you and authorized admin personnel. We comply with all data protection regulations.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Technical Questions -->
                    <div class="mb-5">
                        <h3 class="fw-bold mb-4 text-info">
                            <i class="fas fa-laptop me-2"></i>Technical Support
                        </h3>
                        <div class="accordion" id="techAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#tech1">
                                        What if I forget my password?
                                    </button>
                                </h2>
                                <div id="tech1" class="accordion-collapse collapse show" data-bs-parent="#techAccordion">
                                    <div class="accordion-body text-muted">
                                        Click on "Forgot Password" on the login page. Enter your registered email address, 
                                        and we'll send you instructions to reset your password. If you need further assistance, 
                                        visit our office or call our support line.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#tech2">
                                        How do I track my savings?
                                    </button>
                                </h2>
                                <div id="tech2" class="accordion-collapse collapse" data-bs-parent="#techAccordion">
                                    <div class="accordion-body text-muted">
                                        Members receive monthly statements and can access their savings history through 
                                        our online portal or mobile app. You can also request statements at any time from 
                                        our office. All transactions are recorded in real-time for your convenience.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact CTA -->
                    <div class="text-center mt-5">
                        <div class="stat-card">
                            <div class="feature-icon bg-primary text-white mx-auto mb-3">
                                <i class="fas fa-question-circle fa-2x"></i>
                            </div>
                            <h4 class="fw-bold text-primary mb-3">Still Have Questions?</h4>
                            <p class="text-muted mb-4">Can't find the answer you're looking for? Our support team is here to help you.</p>
                            <div class="d-flex gap-3 justify-content-center flex-wrap">
                                <a href="mailto:support@nakawasavings.com" class="btn btn-primary-custom">
                                    <i class="fas fa-envelope me-2"></i>Email Support
                                </a>
                                <a href="tel:+256700123456" class="btn btn-outline-custom">
                                    <i class="fas fa-phone me-2"></i>Call Support
                                </a>
                            </div>
                        </div>
                    </div>
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
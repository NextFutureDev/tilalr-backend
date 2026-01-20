<!DOCTYPE html>
<html lang="{{ App::getLocale() }}" dir="{{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Sensing Nature</title>
        <!-- Favicon with cache-busting -->
        <link rel="icon" type="image/x-icon" href="{{ asset('assets/icon/favicon.ico') }}?v={{ file_exists(public_path('assets/icon/favicon.ico')) ? filemtime(public_path('assets/icon/favicon.ico')) : time() }}" />
        <!-- Bootstrap Icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Font Awesome Icons-->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet" />
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic" rel="stylesheet" type="text/css" />
        <!-- Import Changa font from Google Fonts for Arabic text -->
        <link href="https://fonts.googleapis.com/css2?family=Changa:wght@400;500;600;700&display=swap" rel="stylesheet">
        <!-- SimpleLightbox plugin CSS-->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.css" rel="stylesheet" />
        <!-- AOS (Animate On Scroll) CSS for Services section only -->
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
        <style>
        :root {
            --radius-card: 16px;
            --space-1: .25rem; --space-2: .5rem; --space-3: .75rem; --space-4: 1rem; --space-6: 1.5rem; --space-8: 2rem;
            --shadow-1: 0 4px 10px rgba(0,0,0,.08);
            --shadow-2: 0 12px 24px rgba(0,0,0,.14);
        }
        .card-soft { border-radius: var(--radius-card); box-shadow: var(--shadow-1); }
        .card-soft:hover { box-shadow: var(--shadow-2); }
        .rounded-16 { border-radius: var(--radius-card) !important; }
        .px-section { padding-left: var(--space-4); padding-right: var(--space-4); }
        .py-section { padding-top: calc(var(--space-8) + var(--space-6)); padding-bottom: var(--space-8); }
        .icon-xl { font-size: 3.5rem; }
        .text-soft { color: rgba(255,255,255,.85) !important; }

        /* Hide native scrollbars across browsers, keep scrolling */
        html { scrollbar-width: none; }
        body { -ms-overflow-style: none; }
        body::-webkit-scrollbar { width: 0; height: 0; }

        /* Custom scroll progress bar above navbar */
        .scroll-progress-track {
            position: fixed;
            top: 0; left: 0;
            height: 4px;
            width: 100%;
            background: #ffffff;
            z-index: 1199;
        }
        .scroll-progress-bar {
            position: fixed;
            top: 0; left: 0;
            height: 4px;
            width: 0%;
            background: #6EB744;
            z-index: 1200;
            box-shadow: 0 1px 2px rgba(0,0,0,.08);
        }
        /* Nudge navbar down slightly so bar is visible above */
        .has-progress #mainNav { top: 4px; }
        
        /* Make navbar background always white - even at the top */
        #mainNav {
            background-color: white !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1) !important;
            transition: background-color 0.3s ease !important;
        }
        
        /* Override any transparent/transparent states - force white always */
        #mainNav.navbar-shrink,
        #mainNav.navbar-scrolled,
        #mainNav:not(.navbar-shrink),
        #mainNav[style*="background"],
        #mainNav[style*="transparent"] {
            background-color: white !important;
        }
        
        /* Force white background on initial load */
        #mainNav {
            background-color: white !important;
            background: white !important;
        }
        
        /* Ensure navbar text is dark on white background */
        #mainNav .navbar-nav .nav-link {
            color: #333 !important;
        }
        /* Hover effect for home navbar links */
        #mainNav .navbar-nav .nav-link:hover,
        #mainNav .navbar-nav .nav-link:focus {
            color: #6EB744 !important;
            background-color: transparent !important;
            text-decoration: none !important;
            transform: none !important;
            box-shadow: none !important;
        }
        
        /* Home navbar hover background (only in mobile menu) */
        #mainNav .navbar-nav .nav-link { transition: background-color .25s ease, color .25s ease; border-radius: .5rem; }
        @media (max-width: 1399px) {
            #mainNav .navbar-nav .nav-link { margin: .125rem .5rem; padding: .75rem 1rem; }
            #mainNav .collapse.show .navbar-nav .nav-link:hover {
                color: #6EB744 !important;
                background-color: transparent !important;
                transform: none !important;
                box-shadow: none !important;
            }
            /* Make collapsed menu scrollable */
            #mainNav .navbar-collapse { max-height: calc(100vh - 100px); overflow-y: auto; }
        }
        
        #mainNav .navbar-brand {
            color: #333 !important;
        }
        
        #mainNav .navbar-brand:hover {
            color: #6EB744 !important;
        }
        
        #mainNav .dropdown-toggle {
            color: #333 !important;
        }
        
        #mainNav .dropdown-toggle:hover {
            color: #6EB744 !important;
        }
        
        #mainNav .dropdown-item {
            color: #333 !important;
        }
        
        #mainNav .dropdown-item { transition: color .25s ease; border-radius: .5rem; }
        @media (max-width: 1399px) {
            #mainNav .collapse.show .dropdown-item:hover {
                color: #6EB744 !important;
                background-color: transparent !important;
                transform: none !important;
                box-shadow: none !important;
            }
        }
        </style>

        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
                <style>
        /* Ensure floating widgets aren't clipped by page sections */
        body { overflow-x: clip; }
        .brand-logo { 
            height: 90px; 
            width: 320px; 
            transition: transform 0.3s ease;
            margin: 0;
            padding: 0;
        }
        /* Keep navbar logo fixed size on all screens */
        @media (max-width: 1399px) { .brand-logo { height: 90px; width: 320px; } }
        @media (max-width: 767px) { .brand-logo { height: 90px; width: 320px; } }
        @media (max-width: 575px) { .brand-logo { height: 90px; width: 220px; } }
        
        .navbar-brand:hover .brand-logo { transform: none !important; }
        
        /* Enhanced hero text styling (Arabic uses Changa) */
        .masthead h1 {
            font-size: 3.5rem !important;
            line-height: 1.2 !important;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3) !important;
            color: white !important;
        }
        
        /* Apply Changa font only when language is Arabic */
        [lang="ar"] .masthead h1,
        [dir="rtl"] .masthead h1 {
            font-family: "Changa", sans-serif !important;
        }
        
        /* Custom text styling (Arabic uses Changa) */
        .custom-text {
            font-size: 28px;
            color: white;
        }
        
        /* Apply Changa font only when language is Arabic */
        [lang="ar"] .custom-text,
        [dir="rtl"] .custom-text {
            font-family: "Changa", sans-serif;
        }
        
        .masthead p {
            font-size: 1.4rem !important;
            line-height: 1.6 !important;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3) !important;
        }
        
        /* Apply Changa font to subtitle only when language is Arabic */
        [lang="ar"] .masthead p,
        [dir="rtl"] .masthead p {
            font-family: "Changa", sans-serif !important;
            font-size: 2rem !important;
        }
        
        /* Hero Buttons Styling */
        .hero-buttons {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }
        
        .hero-buttons .btn {
            min-width: 160px;
            width: 200px;
            max-width: 300px;
            padding: 12px 24px;
            text-align: center;
            font-weight: 600;
            letter-spacing: 0.5px;
            position: relative;
            overflow: hidden;
            border: 2px solid;
            transition: all 0.3s ease;
            border-radius: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        /* Hero Buttons Container */
        .hero-buttons {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }
        
        /* Touch-friendly button styling for mobile */
        @media (hover: none) and (pointer: coarse) {
            .hero-buttons .btn {
                min-height: 48px;
                padding: 0.75rem 1.5rem;
            }
        }
        
        /* Learn More Button - Green to White */
        .hero-buttons .btn-primary {
            background-color: #6EB744 !important;
            border-color: #6EB744 !important;
            color: white !important;
        }
        
        .hero-buttons .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: white;
            transition: left 0.4s ease;
            z-index: 1;
        }
        
        .hero-buttons .btn-primary:hover::before {
            left: 0;
        }
        
        .hero-buttons .btn-primary:hover {
            color: #6EB744 !important;
            border-color: white !important;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }
        
        .hero-buttons .btn-primary span {
            position: relative;
            z-index: 2;
        }
        
        /* Contact Us Button - White to Green */
        .hero-buttons .btn-outline-light {
            background-color: white !important;
            border-color: white !important;
            color: #6EB744 !important;
        }
        
        .hero-buttons .btn-outline-light::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: #6EB744;
            transition: left 0.4s ease;
            z-index: 1;
        }
        
        .hero-buttons .btn-outline-light:hover::before {
            left: 0;
        }
        
        .hero-buttons .btn-outline-light:hover {
            color: white !important;
            border-color: #6EB744 !important;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }
        
        .hero-buttons .btn-outline-light span {
            position: relative;
            z-index: 2;
        }
        
        /* Social Media Icons Styling */
        .social-media-icons {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 1.5rem;
            margin-top: 2rem;
            flex-wrap: wrap;
        }
        
        .social-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.15);
            border: 2px solid rgba(255, 255, 255, 0.4);
            border-radius: 50%;
            color: white;
            font-size: 1.5rem;
            text-decoration: none;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .social-icon:hover {
            background: rgba(255, 255, 255, 0.25);
            border-color: rgba(255, 255, 255, 0.8);
            color: white;
            transform: translateY(-3px) scale(1.1);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            text-decoration: none;
        }
        
        /* Ensure Font Awesome Icons are visible */
        .social-icon i {
            display: block;
            font-style: normal;
            font-variant: normal;
            text-rendering: auto;
            line-height: 1;
            font-size: 1.5rem;
        }
        
        /* RTL Support for Hero Buttons */
        [dir="rtl"] .hero-buttons {
            flex-direction: column;
        }
        
        /* Responsive: side-by-side on large screens */
        @media (min-width: 992px) {
            .hero-buttons {
                flex-direction: row;
            }
            [dir="rtl"] .hero-buttons {
                flex-direction: row-reverse;
            }
        }
        
        [dir="rtl"] .hero-buttons .btn {
            margin-left: 1rem;
            margin-right: 0;
        }
        
        /* RTL Navbar Support */
        [dir="rtl"] #mainNav .navbar-nav .nav-link:hover { transform: none !important; }
        
        [dir="rtl"] .dropdown-item:hover {
            transform: translateX(-5px) !important;
        }
        
        [dir="rtl"] #mainNav .navbar-nav {
            margin-right: auto;
            margin-left: 0;
        }
        
        /* Enhanced about section text styling */
        .bg-primary h2 {
            font-size: 2.8rem !important;
            font-weight: 700 !important;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3) !important;
        }
        
        .bg-primary p {
            font-size: 1.3rem !important;
            line-height: 1.7 !important;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3) !important;
        }

        /* Justify text for About section and Mission/Vision cards on homepage */
        #about p { text-align: justify !important; }
        #vision-mission .card-text { text-align: justify !important; }
        
        /* Responsive text sizing */
        @media (max-width: 768px) {
            .masthead h1 {
                font-size: 2.5rem !important;
            }
            
            .masthead p {
                font-size: 1.2rem !important;
            }
            
            .bg-primary h2 {
                font-size: 2.2rem !important;
            }
            
            .bg-primary p {
                font-size: 1.1rem !important;
            }
            
            .custom-text {
                font-size: 24px !important;
            }
            
                    /* Mobile Hero Buttons */
        .hero-buttons {
            flex-direction: column;
            gap: 1rem;
            padding: 0 1rem;
        }
        
        .hero-buttons .btn {
            min-width: 220px;
            width: 100%;
            max-width: 300px;
            padding: 1rem 2rem;
            font-size: 1rem;
            border-radius: 50px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .hero-buttons .btn:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        
        .hero-buttons .btn:active {
            transform: translateY(-1px) scale(0.98);
        }
            
            /* Mobile Social Icons */
            .social-media-icons {
                gap: 1rem;
                margin-top: 1.5rem;
            }
            
            .social-icon {
                width: 45px;
                height: 45px;
                font-size: 1.3rem;
            }
        }
        
        /* Fix dropdown on mobile */
        @media (max-width: 768px) {
            .dropdown-menu {
                position: static !important;
                float: none !important;
                width: auto !important;
                margin-top: 0 !important;
                background-color: #fff !important;
                border: 1px solid #ccc !important;
                box-shadow: 0 6px 12px rgba(0,0,0,.175) !important;
                z-index: 1051 !important;
            }
            /* Guarantee visibility when Bootstrap adds .show */
            #navbarResponsive .dropdown-menu.show {
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
            }
            .dropdown-item {
                display: block !important;
                width: 100% !important;
                padding: 0.5rem 1rem !important;
                clear: both !important;
                font-weight: normal !important;
                color: #333 !important;
                text-align: center !important;
                white-space: nowrap !important;
                background: 0 0 !important;
                border: 0 !important;
            }
            /* Hover styling handled centrally; remove legacy override */
        }
        
        /* Enhanced mobile navbar styles */
        @media (max-width: 1399px) {
            #mainNav {
                padding: 0.75rem 0;
            }
            
            #mainNav .navbar-nav {
                margin-top: 1rem;
                padding: 1rem 0;
            }
            
            #mainNav .navbar-nav .nav-item {
                margin: 0.25rem 0;
            }
            
            #mainNav .navbar-nav .nav-link {
                padding: 0.75rem 1rem;
                text-align: center;
                border-radius: 0.5rem;
                margin: 0.25rem 0;
                transition: all 0.3s ease;
            }
            
            #mainNav .navbar-nav .nav-link:hover {
                background-color: transparent !important;
                transform: none !important;
                color: #6EB744 !important;
            }
            
            /* Ensure dropdown works properly on mobile */
            #mainNav .dropdown-menu {
                position: static !important;
                float: none !important;
                width: 100% !important;
                margin-top: 0.5rem !important;
                background-color: rgba(248, 249, 250, 0.95) !important;
                border: 1px solid rgba(110, 183, 68, 0.2) !important;
                box-shadow: 0 4px 12px rgba(0,0,0,.1) !important;
                border-radius: 0.5rem !important;
                z-index: 1055 !important;
                display: none !important;
            }
            
            #mainNav .dropdown-menu.show {
                display: block !important;
            }
            
            /* Prevent navbar collapse when dropdown is open */
            #mainNav .dropdown-menu.show ~ * {
                pointer-events: none;
            }
            
            #mainNav .dropdown-menu.show {
                pointer-events: auto;
            }
            
            #mainNav .dropdown-item {
                display: block !important;
                width: 100% !important;
                padding: 0.75rem 1rem !important;
                clear: both !important;
                font-weight: 600 !important;
                color: #333 !important;
                text-align: center !important;
                white-space: nowrap !important;
                background: 0 0 !important;
                border: 0 !important;
                border-radius: 0.25rem !important;
                margin: 0.125rem 0.5rem !important;
                transition: all 0.3s ease !important;
            }
            
            #mainNav .dropdown-item:hover {
                color: #6EB744 !important;
                background-color: transparent !important;
                transform: none !important;
            }
        }
        
        @media (max-width: 768px) {
            #mainNav {
                padding: 0.5rem 0;
            }
            
            #mainNav .navbar-nav .nav-link {
                font-size: 1rem !important;
                padding: 0.875rem 1rem;
            }
            
            #mainNav .navbar-toggler {
                padding: 0.5rem;
                border-radius: 0.5rem;
                transition: all 0.3s ease;
            }
            
            #mainNav .navbar-toggler:hover {
                background-color: rgba(110, 183, 68, 0.1);
            }
            
            #mainNav .navbar-toggler:focus {
                box-shadow: 0 0 0 0.2rem rgba(110, 183, 68, 0.25);
            }
        }
        
        @media (max-width: 576px) {
            #mainNav {
                padding: 0.375rem 0;
            }
            
            #mainNav .navbar-nav .nav-link {
                font-size: 0.95rem !important;
                padding: 0.75rem 0.875rem;
            }
            
            .dropdown-item {
                font-size: 0.9rem !important;
                padding: 0.625rem 0.875rem !important;
            }
            
            .masthead h1 {
                font-size: 2rem !important;
            }
            
            .masthead p {
                font-size: 1rem !important;
            }
            
            .bg-primary h2 {
                font-size: 1.8rem !important;
            }
            
            .bg-primary p {
                font-size: 1rem !important;
            }
            
            .custom-text {
                font-size: 20px !important;
            }
            
            /* Small Mobile Hero Buttons */
            .hero-buttons {
                gap: 0.75rem;
                padding: 0 0.5rem;
            }
            
            .hero-buttons .btn {
                min-width: 200px;
                font-size: 0.95rem;
                padding: 0.875rem 1.75rem;
                border-radius: 45px;
                font-weight: 700;
                letter-spacing: 0.5px;
            }
            
            .hero-buttons .btn:hover {
                transform: translateY(-2px) scale(1.01);
            }
            
            .hero-buttons .btn:active {
                transform: translateY(0) scale(0.99);
            }
            
            /* Small Mobile Social Icons */
            .social-icon {
                width: 40px;
                height: 40px;
                font-size: 1.1rem;
            }
        }
        
        /* Extra Small Mobile Screens (below 400px) */
        @media (max-width: 399px) {
            .hero-buttons {
                gap: 0.5rem;
                padding: 0 0.25rem;
            }
            
            .hero-buttons .btn {
                min-width: 180px;
                font-size: 0.9rem;
                padding: 0.8rem 1.5rem;
                border-radius: 40px;
                font-weight: 600;
            }
            
            .hero-buttons .btn:hover {
                transform: translateY(-1px) scale(1.005);
            }
        }
        
        /* Enhanced navbar text styling */
        .navbar-nav .nav-link {
            font-weight: 700 !important;
            font-size: 1.1rem !important;
            letter-spacing: 0.02em;
        }
        
        .navbar-brand {
            font-weight: 700 !important;
        }
        
        .dropdown-toggle {
            font-weight: 700 !important;
            font-size: 1.1rem !important;
        }
        
        .dropdown-item {
            font-weight: 600 !important;
            font-size: 1rem !important;
        }
        </style>
    </head>
    <body id="page-top" class="has-progress">
        <div class="scroll-progress-track"></div>
        <div class="scroll-progress-bar" id="scrollProgress"></div>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-xxl navbar-light fixed-top py-3" id="mainNav">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand d-flex align-items-center" href="#page-top">
                    @php
                        $logoFile = App::getLocale() == 'ar' ? 'logo-arabic.png' : 'logo.png';
                        $logoPath = "assets/img/{$logoFile}";
                    @endphp
                    <img src="{{ asset($logoPath) }}?v={{ file_exists(public_path($logoPath)) ? filemtime(public_path($logoPath)) : time() }}" alt="{{ __('messages.company_name') }} logo" class="brand-logo">
                </a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto my-2 my-lg-0">
                        <li class="nav-item"><a class="nav-link" href="#about">{{ __('messages.about') }}</a></li>
                        <!-- Removed Vision & Mission from home navbar per request -->
                        @if($services->count() > 0)
                        <li class="nav-item"><a class="nav-link" href="#services">{{ __('messages.services') }}</a></li>
                        @endif
                        @if($portfolios->count() > 0)
                        <li class="nav-item"><a class="nav-link" href="#portfolio">{{ __('messages.portfolio') }}</a></li>
                        @endif
                        @if($projects->count() > 0)
                        <li class="nav-item"><a class="nav-link" href="#projects">{{ __('messages.projects') }}</a></li>
                        @endif
                        @if($trainings->count() > 0)
                        <li class="nav-item"><a class="nav-link" href="#training">{{ __('messages.training') }}</a></li>
                        @endif
                        @if($teamMembers->count() > 0)
                        <li class="nav-item"><a class="nav-link" href="#team">{{ __('messages.team') }}</a></li>
                        @endif
                        <li class="nav-item"><a class="nav-link" href="#contact">{{ __('messages.contact') }}</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" aria-expanded="false">
                                {{ App::getLocale() == 'ar' ? 'العربية' : 'English' }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="languageDropdown">
                                <li><a class="dropdown-item" href="#" data-locale="en">English</a></li>
                                <li><a class="dropdown-item" href="#" data-locale="ar">العربية</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Masthead-->
        <header class="masthead">
            <div class="container px-4 px-lg-5 h-100">
                <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center">
                    <div class="col-lg-8 align-self-end">
                        <h1 class="text-white font-weight-bold" style="font-size: 3.5rem; line-height: 1.2; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
                            {{ $heroSection ? $heroSection->headline : __('messages.welcome') }}
                        </h1>
                        <hr class="divider" />
                    </div>
                    <div class="col-lg-8 align-self-baseline">
                        <p class="text-white mb-5" style="font-size: 1.4rem; line-height: 1.6; text-shadow: 1px 1px 2px rgba(0,0,0,0.3);">
                            {{ $heroSection ? $heroSection->paragraph : __('messages.deliver_precision') }}
                        </p>
                        
                        <!-- Hero Buttons -->
                        <div class="hero-buttons mb-4">
                            <a class="btn btn-primary btn-xl" href="#about">
                                <span>{{ __('messages.find_out_more') }}</span>
                            </a>
                            <a class="btn btn-outline-light btn-xl" href="https://wa.me/966501234567" target="_blank">
                                <span>{{ __('messages.contact_us') }}</span>
                            </a>
                        </div>
                        
                        <!-- Social Media Icons -->
                        <div class="social-media-icons">
                            @if($heroSection && $heroSection->linkedin_url)
                            <a href="{{ $heroSection->linkedin_url }}" target="_blank" class="social-icon" title="LinkedIn">
                                <i class="fab fa-linkedin"></i>
                            </a>
                            @endif
                            @if($heroSection && $heroSection->twitter_url)
                            <a href="{{ $heroSection->twitter_url }}" target="_blank" class="social-icon" title="X (Twitter)">
                                <i class="fab fa-x-twitter"></i>
                            </a>
                            @endif
                            @if($heroSection && $heroSection->facebook_url)
                            <a href="{{ $heroSection->facebook_url }}" target="_blank" class="social-icon" title="Facebook">
                                <i class="fab fa-facebook"></i>
                            </a>
                            @endif
                            @if($heroSection && $heroSection->instagram_url)
                            <a href="{{ $heroSection->instagram_url }}" target="_blank" class="social-icon" title="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            @endif
                            @if($heroSection && $heroSection->snapchat_url)
                            <a href="{{ $heroSection->snapchat_url }}" target="_blank" class="social-icon" title="Snapchat">
                                <i class="fab fa-snapchat"></i>
                            </a>
                            @endif
                            @if($heroSection && $heroSection->tiktok_url)
                            <a href="{{ $heroSection->tiktok_url }}" target="_blank" class="social-icon" title="TikTok">
                                <i class="fab fa-tiktok"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- About-->
        <section class="page-section bg-primary" id="about" data-aos="fade-up">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-lg-8 text-center" data-aos="fade-up" data-aos-delay="100">
                        <h2 class="text-white mt-0" style="font-size: 2.8rem; font-weight: 700; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">{{ $aboutSection ? $aboutSection->title : __('messages.we_got_what_you_need') }}</h2>
                        <hr class="divider divider-light" />
                        <p class="text-white mb-4" style="font-size: 1.3rem; line-height: 1.7; text-shadow: 1px 1px 2px rgba(0,0,0,0.3);">{{ $aboutSection ? $aboutSection->paragraph : __('messages.about_description') }}</p>
                        <a class="btn btn-light btn-xl" href="#services">{{ __('messages.get_started') }}</a>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Vision & Mission-->
        <section class="page-section" id="vision-mission">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <!-- Mission -->
                    <div class="col-lg-6 col-md-12 mb-5" data-aos="fade-up-right">
                        <div class="card h-100 shadow border-0" style="border-radius: 1.25rem; overflow: hidden;">
                            <!-- Mission Tab -->
                            <div class="card-header text-white text-center py-3" style="background: linear-gradient(135deg, #6EB744 0%, #5A8C43 100%); border: none;">
                                <h4 class="mb-0 fw-bold">{{ $aboutSection ? $aboutSection->mission_title : __('messages.our_mission') }}</h4>
                            </div>
                            <!-- Mission Content -->
                            <div class="card-body p-4 d-flex align-items-center" style="min-height: 140px;">
                                <div class="row align-items-center w-100">
                                    <div class="col-auto d-none d-md-block">
                                        <div class="mission-icon-wrapper text-center me-3">
                                            <i class="bi bi-bullseye text-primary" style="font-size: 3.5rem; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <p class="card-text text-muted mb-0" style="font-size: 1.1rem; line-height: 1.7;">
                                            {{ $aboutSection ? $aboutSection->mission_paragraph : __('messages.mission_description') }}
                                        </p>
                                    </div>
                                </div>
                                <!-- Decorative Flag -->
                                <div class="position-absolute d-none d-md-block" style="top: 10px; right: 15px;">
                                    <i class="bi bi-flag-fill text-white" style="font-size: 1.2rem; filter: drop-shadow(0 1px 2px rgba(0,0,0,0.3));"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Vision -->
                    <div class="col-lg-6 col-md-12 mb-5" data-aos="fade-up-right" data-aos-delay="150">
                        <div class="card h-100 shadow border-0" style="border-radius: 1.25rem; overflow: hidden;">
                            <!-- Vision Tab -->
                            <div class="card-header text-white text-center py-3" style="background: linear-gradient(135deg, #6EB744 0%, #497f2d 100%); border: none;">
                                <h4 class="mb-0 fw-bold">{{ $aboutSection ? $aboutSection->vision_title : __('messages.our_vision') }}</h4>
                            </div>
                            <!-- Vision Content -->
                            <div class="card-body p-4 d-flex align-items-center" style="min-height: 140px;">
                                <div class="row align-items-center w-100">
                                    <div class="col-auto d-none d-md-block">
                                        <div class="vision-icon-wrapper text-center me-3">
                                            <i class="bi bi-lightbulb-fill text-primary" style="font-size: 3.5rem; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <p class="card-text text-muted mb-0" style="font-size: 1.1rem; line-height: 1.7;">
                                            {{ $aboutSection ? $aboutSection->vision_paragraph : __('messages.vision_description') }}
                                        </p>
                                    </div>
                                </div>
                                <!-- Decorative Flag -->
                                <div class="position-absolute d-none d-md-block" style="top: 10px; right: 15px;">
                                    <i class="bi bi-flag-fill text-white" style="font-size: 1.2rem; filter: drop-shadow(0 1px 2px rgba(0,0,0,0.3));"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Services-->
        @if($services->count() > 0)
        <section class="page-section" id="services" data-aos="fade-up">
            <div class="container px-4 px-lg-5">
                                <div class="text-center" data-aos="fade-up" data-aos-delay="100">
                    <h2 class="text-center mt-0">{{ __('messages.our_services') }}</h2>
                    <hr class="divider" />
                        <p class="text-muted mb-5">{{ __('messages.we_got_what_you_need') }}</p>
                </div>
                
                <div class="row justify-content-center g-4 gy-4" lang="{{ app()->getLocale() }}">
                    @foreach($services as $service)
                        <div class="col-lg-3 col-md-6 col-sm-12 d-flex align-items-stretch mb-4" data-aos="zoom-in" data-aos-delay="{{ ($loop->index % 4) * 100 }}">
                            <div class="service-card" lang="{{ app()->getLocale() }}">
                                <div class="service-icon-container" style="width:86px;height:86px;position:absolute;top:-43px;left:50%;transform:translateX(-50%);background:#ffffff;border-radius:50%;box-shadow:0 8px 20px rgba(0,0,0,0.08);display:flex;align-items:center;justify-content:center;z-index:2;">
                                @if($service->icon)
                                        <img src="{{ asset('storage/' . $service->icon) }}" 
                                             alt="{{ $service->getTranslation('name', app()->getLocale()) }}" 
                                             class="service-icon"
                                             style="width:48px;height:48px;border-radius:12px;object-fit:contain;display:block;">
                                    @else
                                        <div class="service-icon-placeholder" style="width:56px;height:56px;border-radius:50%;background:#6EB744;display:flex;align-items:center;justify-content:center;">
                                            <i class="bi bi-gear-fill" style="font-size:1.6rem;color:#fff;"></i>
                                    </div>
                                @endif
                                </div>
                                <div class="service-info">
                                    <h4 class="service-name">{{ $service->getTranslation('name', app()->getLocale()) }}</h4>
                                    <p class="service-short-description">
                                        {{ $service->getTranslation('short_description', app()->getLocale()) }}
                                    </p>
                                    <a href="{{ route(app()->getLocale() . '.services.show', ['slug' => $service->slug]) }}" class="btn btn-read-more">
                                        {{ __('messages.read_more') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif
        
        <!-- Portfolio-->
        @if($portfolios->count() > 0)
        <section class="page-section" id="portfolio" data-aos="zoom-in-left">
            <div class="container-fluid p-0">
                <div class="row g-0">
                    @foreach($portfolios as $portfolio)
                        <div class="col-lg-4 col-sm-6" data-aos="zoom-in-left" data-aos-delay="{{ ($loop->index % 4) * 100 }}">
                            <a class="portfolio-box" href="{{ $portfolio->image ? asset('storage/' . $portfolio->image) : '#' }}" title="{{ $portfolio->getTranslation('name', app()->getLocale()) }}">
                                <div class="homepage-portfolio-image-container">
                                    @if($portfolio->image)
                                        <img src="{{ asset('storage/' . $portfolio->image) }}" 
                                             class="homepage-portfolio-image" 
                                             alt="{{ $portfolio->getTranslation('name', app()->getLocale()) }}" />
                                    @else
                                        <div class="homepage-portfolio-placeholder">
                                            <i class="bi bi-image text-muted" style="font-size: 2rem;"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="portfolio-box-caption">
                                    <div class="project-category text-white-50">{{ $portfolio->getTranslation('category', app()->getLocale()) ?? 'Portfolio' }}</div>
                                    <div class="project-name">{{ $portfolio->getTranslation('name', app()->getLocale()) }}</div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif
        <!-- Projects Section-->
        @if($projects->count() > 0)
        <section class="page-section bg-light" id="projects" data-aos="zoom-in-right">
            <div class="container px-4 px-lg-5">
                <div class="text-center mb-5" data-aos="zoom-in-right" data-aos-delay="100">
                    <h2 class="mb-2" style="font-size:2.5rem;font-weight:500;">{{ __('messages.our_projects') }}</h2>
                    <div style="width:60px;height:4px;background:#6EB744;margin:0.5rem auto 1.5rem auto;border-radius:2px;"></div>
                    <p class="text-muted" style="font-size:1.15rem;">{{ __('messages.explore_projects') }}</p>
                </div>
                <div class="row justify-content-center g-4">
                    @foreach($projects as $project)
                        <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="zoom-in-right" data-aos-delay="{{ ($loop->index % 4) * 100 }}">
                            <div class="card shadow border-0 h-100 project-card-custom" style="width: 370px; min-width: 300px; max-width: 370px; margin: 0 auto;">
                                @if($project->image)
                                    <img src="{{ asset('storage/' . $project->image) }}" class="card-img-top rounded-top" style="width:100%;height:220px;object-fit:cover;" alt="{{ $project->getTranslation('name', app()->getLocale()) }}">
                                @endif
                                <div class="card-body d-flex flex-column justify-content-between" style="padding:1.5rem 1.25rem 1.25rem 1.25rem;">
                                    <div>
                                        <h5 class="card-title mb-2" style="font-size:1.25rem;font-weight:500;">{{ $project->getTranslation('name', app()->getLocale()) }}</h5>
                                        @php
                                            $desc = $project->getTranslation('description', app()->getLocale());
                                            $desc = html_entity_decode($desc, ENT_QUOTES | ENT_HTML5);
                                            $desc = strip_tags($desc);
                                        @endphp
                                        <p class="card-text text-muted mb-3 project-desc-truncate">{{ $desc }}</p>
                                    </div>
                                    <a href="{{ route(app()->getLocale() . '.projects.show', ['slug' => $project->slug]) }}" class="btn btn-readmore mt-auto">{{ __('messages.read_more') }}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-5">
                    <button onclick="window.location.href='{{ route(app()->getLocale() . '.projects.index') }}'" class="btn btn-seeall">
                        {{ __('messages.see_all_projects') }}
                    </button>
                </div>
            </div>
        </section>
        @endif
        
        <!-- Training Programs-->
        @if($trainings->count() > 0)
        <section class="page-section" id="training" data-aos="fade-up" style="background: #f8f9fa;">
            <div class="container py-5" lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
                <div class="text-center mb-5" data-aos="fade-up" data-aos-delay="100">
                    <h1 class="mb-3" style="font-size:2.25rem;font-weight:600;">{{ __('messages.our_training') }}</h1>
                    <p class="text-muted">{{ __('messages.training_description') }}</p>
                </div>

                <div class="row g-4" lang="{{ app()->getLocale() }}">
                    @foreach($trainings as $training)
                        <div class="col-lg-3 col-md-6 col-sm-12 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="{{ ($loop->index % 4) * 100 }}">
                            <div class="training-feature-card" style="width:100%; background: #fff; border-radius: 12px; padding: 30px 20px; text-align: center; display: flex; flex-direction: column; align-items: center; justify-content: space-between; height: 380px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); transition: all 0.3s ease; border: 1px solid #f0f0f0; position: relative; z-index: 1;">
                                <div class="training-feature-icon" style="font-size: 3rem; color: #2d7ef7; margin-bottom: 20px; display: flex; align-items: center; justify-content: center; height: 70px; width: 70px; border-radius: 50%; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                    @if($training->icon)
                                        <img src="{{ $training->icon_url }}" alt="icon" style="height:45px;width:auto;"/>
                                    @else
                                        <i class="bi bi-mortarboard"></i>
                                    @endif
                                </div>
                                <h3 class="training-feature-title" style="font-size: 1.4rem; font-weight: 700; letter-spacing: .02em; margin: 0 0 15px 0; color: #2c3e50; line-height: 1.3;">{{ app()->getLocale() == 'ar' ? $training->name_ar : $training->name }}</h3>
                                <p class="training-feature-text" style="color: #6c757d; font-size: 15px; line-height: 1.6; margin: 0 0 20px 0; flex-grow: 1; display: flex; align-items: center; justify-content: center;">
                                    @php
                                        $short = app()->getLocale() == 'ar' ? ($training->short_description_ar ?? '') : ($training->short_description ?? '');
                                        if (! $short) {
                                            $desc = app()->getLocale() == 'ar' ? ($training->description_ar ?? '') : ($training->description ?? '');
                                            $desc = html_entity_decode($desc, ENT_QUOTES | ENT_HTML5);
                                            $desc = strip_tags($desc);
                                            $short = \Illuminate\Support\Str::limit(trim($desc), 180);
                                        }
                                    @endphp
                                    {{ $short }}
                                </p>
                                <a href="{{ route(app()->getLocale() . '.training.show', ['slug' => $training->slug]) }}" class="training-feature-link" style="color: #6EB744; text-decoration: none; font-weight: 600; font-size: 16px; transition: all 0.3s ease; position: relative; padding: 8px 0;">{{ __('messages.learn_more') }} @if(app()->getLocale() == 'en')→@else←@endif</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif
        
        <!-- Team Members Section-->
        @if($teamMembers->count() > 0)
        <section class="page-section bg-light" id="team" data-aos="zoom-out-down">
            <div class="container px-4 px-lg-5">
                <div class="text-center" data-aos="zoom-out-down" data-aos-delay="100">
                    <h2 class="mt-0">{{ __('messages.our_team') }}</h2>
                    <hr class="divider" />
                    <p class="text-muted mb-5">{{ __('messages.meet_the_team') }}</p>
                </div>
                <div class="team-slider-container" lang="{{ app()->getLocale() }}">
                    <div class="team-slider" id="homeTeamSlider">
                        @foreach($teamMembers as $member)
                            <div class="team-member-card" lang="{{ app()->getLocale() }}" data-aos="zoom-out-down" data-aos-delay="{{ ($loop->index % 4) * 100 }}">
                                <div class="member-image-container">
                                    @if($member->image)
                                        <img src="{{ asset('storage/' . $member->image) }}" 
                                             alt="{{ $member->getTranslation('name', app()->getLocale()) }}" 
                                             class="member-image">
                                    @else
                                        <div class="member-placeholder">
                                            <i class="bi bi-person-fill"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="member-info">
                                    <h5 class="member-role">
                                        @if($member->role_id && $member->roleRelation)
                                            {{ $member->roleRelation->title }}
                                        @else
                                        {{ $member->getTranslation('role', app()->getLocale()) }}
                                        @endif
                                    </h5>
                                    <h4 class="member-name">{{ $member->getTranslation('name', app()->getLocale()) }}</h4>
                                    <p class="member-bio">
                                        @if(app()->getLocale() === 'ar')
                                            {!! str_replace(['JavaScript', 'React', 'Node.js', 'Python', 'TensorFlow', 'CISSP', 'CEH', 'Scrum', 'Fortune 50'], 
                                                ['<span class="english-term">JavaScript</span>', 
                                                 '<span class="english-term">React</span>', 
                                                 '<span class="english-term">Node.js</span>', 
                                                 '<span class="english-term">Python</span>', 
                                                 '<span class="english-term">TensorFlow</span>', 
                                                 '<span class="english-term">CISSP</span>', 
                                                 '<span class="english-term">CEH</span>', 
                                                 '<span class="english-term">Scrum</span>', 
                                                 '<span class="english-term">Fortune 50</span>'], 
                                                $member->getTranslation('bio', app()->getLocale())) !!}
                                        @else
                                            {{ $member->getTranslation('bio', app()->getLocale()) }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    @if(count($teamMembers) > 3)
                        <div class="slider-controls">
                            <button class="slider-btn prev-btn">
                                <i class="bi bi-chevron-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}"></i>
                            </button>
                            <button class="slider-btn next-btn">
                                <i class="bi bi-chevron-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }}"></i>
                            </button>
                        </div>
                    @endif
                </div>
                <div class="text-center mt-4">
                    <a href="{{ route(app()->getLocale() . '.team.index') }}" class="btn btn-seeall">{{ __('messages.meet_the_team') }}</a>
                </div>
            </div>
        </section>
        @endif
        
        <!-- Contact-->
        <section class="page-section" id="contact" data-aos="zoom-out-right">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-lg-8 col-xl-6 text-center" data-aos="zoom-out-right" data-aos-delay="100">
                        <h2 class="mt-0">{{ __('messages.contact_us') }}</h2>
                        <hr class="divider" />
                        <p class="text-muted mb-5">{{ __('messages.contact_description') }}</p>
                    </div>
                </div>
                
                <!-- Contact Info Cards -->
                @if($contactInfos->count() > 0)
                <div class="row gx-4 gx-lg-5 justify-content-center mb-5">
                    @foreach($contactInfos as $contactInfo)
                        <div class="col-lg-4 col-md-6" data-aos="zoom-out-right" data-aos-delay="{{ ($loop->index % 4) * 100 }}">
                            <div class="contact-info-card">
                                <div class="text-center">
                                    <i class="bi {{ $contactInfo->icon }}" style="font-size: 3rem; color: white; margin-bottom: 1rem;"></i>
                                    <h5 class="mb-2 text-white">{{ $contactInfo->getTranslation('title', app()->getLocale()) }}</h5>
                                    <p class="mb-0 text-white">{{ $contactInfo->getTranslation('content', app()->getLocale()) }}</p>
                                    @if($contactInfo->type === 'phone' && $contactInfo->working_hours)
                                        <p class="working-hours text-white-50 small">{{ $contactInfo->working_hours }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @endif

                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-lg-8" data-aos="zoom-out-right" data-aos-delay="250">
                        <div class="contact-form-container">
                            <!-- Form Progress Indicator -->
                            <div class="form-progress mb-4">
                                <div class="progress-step active" data-step="1">
                                    <i class="bi bi-person"></i>
                                </div>
                                <div class="progress-step" data-step="2">
                                    <i class="bi bi-envelope"></i>
                                </div>
                                <div class="progress-step" data-step="3">
                                    <i class="bi bi-chat"></i>
                                </div>
                                <div class="progress-step" data-step="4">
                                    <i class="bi bi-check"></i>
                                </div>
                            </div>
                            <!-- Contact Form using Laravel -->
                            <form id="contactForm" method="POST" action="{{ route(app()->getLocale() . '.contact.store') }}" novalidate data-handler="blade">
                                @csrf
                                <!-- Name input-->
                                <div class="form-floating mb-3">
                                    <input class="form-control" name="name" id="name" type="text" placeholder="Enter your name..." required />
                                    <label for="name"><i class="bi bi-person me-2"></i>{{ __('messages.full_name') }}</label>
                                    <div class="invalid-feedback">{{ __('messages.name_required') }}</div>
                                    <div class="valid-feedback">{{ __('messages.looks_good') }}</div>
                                </div>
                                <!-- Email address input-->
                                <div class="form-floating mb-3">
                                    <input class="form-control" name="email" id="email" type="email" placeholder="name@example.com" required />
                                    <label for="email"><i class="bi bi-envelope me-2"></i>{{ __('messages.email_address') }}</label>
                                    <div class="invalid-feedback">{{ __('messages.valid_email_required') }}</div>
                                    <div class="valid-feedback">{{ __('messages.valid_email') }}</div>
                                </div>
                                <!-- Phone number input-->
                                <div class="form-floating mb-3">
                                    <input class="form-control" name="phone" id="phone" type="tel" placeholder="(123) 456-7890" />
                                    <label for="phone"><i class="bi bi-telephone me-2"></i>{{ __('messages.phone_number') }}</label>
                                    <div class="invalid-feedback">{{ __('messages.phone_invalid') }}</div>
                                    <div class="valid-feedback">{{ __('messages.valid_phone') }}</div>
                                </div>
                                <!-- Subject input -->
                                <div class="form-floating mb-3">
                                    <select class="form-control" name="subject" id="subject" required>
                                        <option value="">{{ __('messages.select_subject') }}</option>
                                        <option value="general">{{ __('messages.general_inquiry') }}</option>
                                        <option value="project">{{ __('messages.project_quote') }}</option>
                                        <option value="support">{{ __('messages.technical_support') }}</option>
                                        <option value="partnership">{{ __('messages.partnership') }}</option>
                                        <option value="other">{{ __('messages.other') }}</option>
                                    </select>
                                    <label for="subject"><i class="bi bi-tag me-2"></i>{{ __('messages.subject') }}</label>
                                    <div class="invalid-feedback">{{ __('messages.select_subject_required') }}</div>
                                    <div class="valid-feedback">{{ __('messages.subject_selected') }}</div>
                                </div>
                                <!-- Message input-->
                                <div class="form-floating mb-3">
                                    <textarea class="form-control" name="message" id="message" placeholder="Enter your message here..." style="height: 10rem" maxlength="1000" required></textarea>
                                    <label for="message"><i class="bi bi-chat-dots me-2"></i>{{ __('messages.message') }}</label>
                                    <div class="invalid-feedback">{{ __('messages.message_required') }}</div>
                                    <div class="valid-feedback">{{ __('messages.great_message') }}</div>
                                    <div class="character-counter">
                                        <span id="charCount">0</span>/1000 {{ __('messages.characters') }}
                                    </div>
                                </div>
                                <!-- Submit success message-->
                                <div class="d-none" id="submitSuccessMessage">
                                    <div class="form-success-message">
                                        <i class="bi bi-check-circle-fill fs-1 mb-3"></i>
                                        <h4>{{ __('messages.message_sent') }}</h4>
                                        <p>{{ __('messages.thank_you_contact') }}</p>
                                    </div>
                                </div>
                                <!-- Submit error message-->
                                <div class="d-none" id="submitErrorMessage">
                                    <div class="form-error-message">
                                        <i class="bi bi-exclamation-triangle-fill fs-1 mb-3"></i>
                                        <h4>{{ __('messages.oops') }}</h4>
                                        <p id="errorText">{{ __('messages.try_again') }}</p>
                                    </div>
                                </div>
                                <!-- Submit Button-->
                                <div class="d-grid">
                                    <button class="btn btn-submit btn-xl" id="submitButton" type="submit">
                                        <span class="btn-text">
                                            <i class="bi bi-send me-2"></i>{{ __('messages.send_message') }}
                                        </span>
                                        <span class="btn-loading d-none">
                                            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                            {{ __('messages.sending') }}
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- SimpleLightbox plugin JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.js"></script>
        <!-- Core theme JS-->
        <script src="{{ asset('js/scripts.js') }}"></script>
        <!-- AOS JS for Services section only -->
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
        // Professional AOS setup: reduced-motion, mobile tuning, scroll-only
        (function () {
            const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            const isMobile = window.matchMedia('(max-width: 575.98px)').matches;

            function stripAos() {
                document.querySelectorAll('[data-aos]').forEach(el => el.removeAttribute('data-aos'));
            }

            let initialized = false;
            function initAOS() {
                if (initialized) return; initialized = true;
                if (reduceMotion) { stripAos(); return; }
                AOS.init({
                    duration: 650,
                    easing: 'ease-out-cubic',
                    once: true,
                    offset: isMobile ? 100 : 140,
                    mirror: false
                });
            }

            // only after user interaction/scroll
            window.addEventListener('scroll', initAOS, { passive: true });
            document.addEventListener('click', e => {
                const a = e.target.closest('a[href^="#"]');
                if (!a) return;
                const h = a.getAttribute('href');
                if (['#services','#training','#portfolio','#projects','#team','#contact','#vision-mission'].includes(h)) {
                    setTimeout(initAOS, 50);
                }
            });

            // Fallback
            setTimeout(initAOS, 5000);
        })();
        // Scroll progress bar logic
        (function () {
            const bar = document.getElementById('scrollProgress');
            if (!bar) return;
            function updateBar() {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                const docHeight = document.documentElement.scrollHeight - window.innerHeight;
                const pct = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
                bar.style.width = pct + '%';
            }
            updateBar();
            window.addEventListener('scroll', updateBar, { passive: true });
            window.addEventListener('resize', updateBar);
        })();
        </script>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('contactForm');
            const submitButton = document.getElementById('submitButton');
            const successMsg = document.getElementById('submitSuccessMessage');
            const errorMsg = document.getElementById('submitErrorMessage');
            const errorText = document.getElementById('errorText');

            // Progress bar logic
            const steps = document.querySelectorAll('.progress-step');
            const fields = ['name', 'email', 'phone', 'subject', 'message'];
            
            function updateProgressSteps(currentStep) {
                steps.forEach((step, index) => {
                    step.classList.remove('active', 'completed');
                    if (index < currentStep) {
                        step.classList.add('completed');
                    } else if (index === currentStep) {
                        step.classList.add('active');
                    }
                });
            }
            
            // Form validation
            function validateField(field) {
                const value = field.value.trim();
                const fieldName = field.name;
                let isValid = true;
                
                // Remove existing validation classes
                field.classList.remove('is-valid', 'is-invalid');
                
                // Validate based on field type
                // Define validation messages
                const messages = {
                    name_min: {!! json_encode(__('messages.name_min')) !!},
                    valid_email_required: {!! json_encode(__('messages.valid_email_required')) !!},
                    phone_invalid: {!! json_encode(__('messages.phone_invalid')) !!},
                    select_subject_required: {!! json_encode(__('messages.select_subject_required')) !!},
                    message_min: {!! json_encode(__('messages.message_min')) !!}
                };

                switch(fieldName) {
                    case 'name':
                        if (value.length < 2) {
                            field.classList.add('is-invalid');
                            const fb = field.parentElement.querySelector('.invalid-feedback');
                            if (fb) fb.textContent = messages.name_min;
                            isValid = false;
                        } else {
                            field.classList.add('is-valid');
                        }
                        break;
                        
                    case 'email':
                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (!emailRegex.test(value)) {
                            field.classList.add('is-invalid');
                            const fb = field.parentElement.querySelector('.invalid-feedback');
                            if (fb) fb.textContent = messages.valid_email_required;
                            isValid = false;
                        } else {
                            field.classList.add('is-valid');
                        }
                        break;
                        
                    case 'phone':
                        if (value && value.length > 0) {
                            const phoneRegex = /^[\+]?[1-9][\d]{0,15}$/;
                            if (!phoneRegex.test(value.replace(/[\s\-\(\)]/g, ''))) {
                                field.classList.add('is-invalid');
                                const fb = field.parentElement.querySelector('.invalid-feedback');
                                if (fb) fb.textContent = messages.phone_invalid;
                                isValid = false;
                            } else {
                                field.classList.add('is-valid');
                            }
                        }
                        break;
                        
                    case 'subject':
                        if (!value) {
                            field.classList.add('is-invalid');
                            const fb = field.parentElement.querySelector('.invalid-feedback');
                            if (fb) fb.textContent = messages.select_subject_required;
                            isValid = false;
                        } else {
                            field.classList.add('is-valid');
                        }
                        break;
                        
                    case 'message':
                        if (value.length < 10) {
                            field.classList.add('is-invalid');
                            const fb = field.parentElement.querySelector('.invalid-feedback');
                            if (fb) fb.textContent = messages.message_min;
                            isValid = false;
                        } else {
                            field.classList.add('is-valid');
                        }
                        break;
                }
                
                return isValid;
            }
            
            // Add validation on blur
            fields.forEach(fieldName => {
                const field = document.getElementById(fieldName);
                if (field) {
                    field.addEventListener('blur', function() {
                        validateField(this);
                    });
                    
                    field.addEventListener('focus', function() {
                        const idx = fields.indexOf(fieldName);
                        updateProgressSteps(idx);
                    });
                }
            });
            
            updateProgressSteps(0);

            // Form submission
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Validate all fields
                let allValid = true;
                fields.forEach(fieldName => {
                    const field = document.getElementById(fieldName);
                    if (field && !validateField(field)) {
                        allValid = false;
                    }
                });
                
                if (!allValid) {
                    return;
                }
                
                submitButton.disabled = true;
                submitButton.querySelector('.btn-text').classList.add('d-none');
                submitButton.querySelector('.btn-loading').classList.remove('d-none');
                successMsg.classList.add('d-none');
                errorMsg.classList.add('d-none');
                
                const formData = new FormData(form);
                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json',
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    submitButton.disabled = false;
                    submitButton.querySelector('.btn-text').classList.remove('d-none');
                    submitButton.querySelector('.btn-loading').classList.add('d-none');
                    
                    if (data.success) {
                        // Reset form and validation states
                        form.reset();
                        resetFormValidation();
                        successMsg.classList.remove('d-none');
                        updateProgressSteps(0);
                        
                        // Hide success message after 5 seconds
                        setTimeout(() => {
                            successMsg.classList.add('d-none');
                        }, 5000);
                    } else {
                        errorText.textContent = data.message || '{{ __('messages.try_again') }}';
                        errorMsg.classList.remove('d-none');
                    }
                })
                .catch(error => {
                    submitButton.disabled = false;
                    submitButton.querySelector('.btn-text').classList.remove('d-none');
                    submitButton.querySelector('.btn-loading').classList.add('d-none');
                    errorText.textContent = '{{ __('messages.error_occurred') }}';
                    errorMsg.classList.remove('d-none');
                });
            });
            
            // Reset form validation
            function resetFormValidation() {
                fields.forEach(fieldName => {
                    const field = document.getElementById(fieldName);
                    if (field) {
                        field.classList.remove('is-valid', 'is-invalid');
                    }
                });
                
                // Reset character counter
                const charCount = document.getElementById('charCount');
                if (charCount) {
                    charCount.textContent = '0';
                }
                
                // Reset progress steps
                updateProgressSteps(0);
            }
            
            // Character counter
            const messageInput = document.getElementById('message');
            const charCount = document.getElementById('charCount');
            if (messageInput && charCount) {
                messageInput.addEventListener('input', function() {
                    charCount.textContent = this.value.length;
                });
            }
        });
        
        // Language switching function
        function switchLanguage(locale) {
            // Send only path + query + hash to avoid host/scheme issues
            const { pathname, search, hash } = window.location;
            const relative = `${pathname}${search}${hash}`;
            const languageSwitchUrl = `/switch-language/${locale}?current_url=${encodeURIComponent(relative)}`;
            
            window.location.href = languageSwitchUrl;
        }
        
        // Complete mobile dropdown solution
        document.addEventListener('DOMContentLoaded', function() {
            const navbarCollapse = document.querySelector('#navbarResponsive');
            const languageDropdown = document.querySelector('#languageDropdown');
            const dropdownMenu = document.querySelector('#languageDropdown + .dropdown-menu');
            const dropdownContainer = document.querySelector('.nav-item.dropdown');
            
            // Disable Bootstrap dropdown completely on mobile
            if (languageDropdown && dropdownMenu) {
                // Remove Bootstrap data attributes to prevent interference
                languageDropdown.removeAttribute('data-bs-toggle');
                languageDropdown.removeAttribute('data-bs-auto-close');
                languageDropdown.removeAttribute('aria-expanded');
                
                // Add custom click handler for dropdown toggle
                languageDropdown.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    // Toggle dropdown manually
                    const isOpen = dropdownMenu.classList.contains('show');
                    if (isOpen) {
                        dropdownMenu.classList.remove('show');
                        languageDropdown.setAttribute('aria-expanded', 'false');
                    } else {
                        dropdownMenu.classList.add('show');
                        languageDropdown.setAttribute('aria-expanded', 'true');
                    }
                });
            }
            
            // Handle dropdown items
            const dropdownItems = document.querySelectorAll('.dropdown-item');
            dropdownItems.forEach(function(item) {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const locale = this.getAttribute('data-locale');
                    if (locale) {
                        // Close dropdown
                        if (dropdownMenu) {
                            dropdownMenu.classList.remove('show');
                            languageDropdown.setAttribute('aria-expanded', 'false');
                        }
                        
                        // Switch language
                        switchLanguage(locale);
                    }
                });
            });
            
            // Prevent navbar collapse when dropdown is open
            if (navbarCollapse) {
                navbarCollapse.addEventListener('hide.bs.collapse', function(e) {
                    if (dropdownMenu && dropdownMenu.classList.contains('show')) {
                        e.preventDefault();
                        e.stopPropagation();
                        return false;
                    }
                });
            }
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.dropdown') && dropdownMenu) {
                    dropdownMenu.classList.remove('show');
                    if (languageDropdown) {
                        languageDropdown.setAttribute('aria-expanded', 'false');
                    }
                }
            });
            
            // Prevent any Bootstrap dropdown initialization
            if (window.bootstrap && window.bootstrap.Dropdown) {
                // Disable Bootstrap dropdown for our custom dropdown
                const dropdownElement = document.querySelector('#languageDropdown');
                if (dropdownElement) {
                    dropdownElement._dropdown = null;
                }
            }
            
            // Global prevention of navbar collapse when dropdown is open
            document.addEventListener('click', function(e) {
                const dropdownMenu = document.querySelector('#languageDropdown + .dropdown-menu');
                if (dropdownMenu && dropdownMenu.classList.contains('show')) {
                    // If clicking on dropdown or its children, prevent navbar collapse
                    if (e.target.closest('.dropdown')) {
                        e.stopPropagation();
                    }
                }
            });
            
            // Additional safety: prevent navbar toggler when dropdown is open
            const navbarToggler = document.querySelector('.navbar-toggler');
            if (navbarToggler) {
                navbarToggler.addEventListener('click', function(e) {
                    const dropdownMenu = document.querySelector('#languageDropdown + .dropdown-menu');
                    if (dropdownMenu && dropdownMenu.classList.contains('show')) {
                        e.preventDefault();
                        e.stopPropagation();
                        return false;
                    }
                });
            }
        });
        
        // Force navbar to be white from the beginning
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.getElementById('mainNav');
            if (navbar) {
                // Force white background immediately
                navbar.style.backgroundColor = 'white';
                navbar.style.background = 'white';
                navbar.classList.add('navbar-shrink'); // Add shrink class to ensure white background
            }
        });
        
        // Initialize AOS (Animate On Scroll) - TEMPORARILY DISABLED
        /*
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 800,        // Animation duration in milliseconds
                easing: 'ease-in-out', // Easing function
                once: true,           // Whether animation should happen only once
                mirror: false,        // Whether elements should animate out while scrolling past them
                offset: 100,         // Offset (in px) from the original trigger point
                delay: 0,            // Values from 0 to 3000, with step 50ms
                anchorPlacement: 'top-bottom' // Defines which position of the element regarding to window should trigger the animation
            });
        });
        */
        </script>
        <style>
        /* Remove gap between Portfolio and Projects sections */
        #portfolio {
            padding-bottom: 0 !important;
            margin-bottom: 0 !important;
        }
        
        .project-card-custom {
            width: 370px;
            min-width: 300px;
            max-width: 370px;
            margin: 0 auto;
        }
        
        /* Portfolio hover effects tuned for new green */
        .portfolio-box:hover .portfolio-box-caption {
            background: rgba(110, 183, 68, 0.85);
        }
        .homepage-portfolio-image-container:hover .homepage-portfolio-image {
            box-shadow: 0 12px 28px rgba(110, 183, 68, 0.28);
            transform: translateY(-2px);
            transition: all 0.25s ease;
        }
        
        .project-desc-truncate {
            display: -webkit-box !important;
            -webkit-line-clamp: 4 !important;
            -webkit-box-orient: vertical !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            height: 6.2em !important;
            line-height: 1.55 !important;
        }
        .btn-readmore {
            background: #6EB744;
            color: #fff;
            border: none;
            border-radius: 0.5rem;
            font-weight: 500;
            padding: 0.5rem 1.5rem;
            width: 140px;
            text-align: center;
            transition: background 0.2s, box-shadow 0.2s, transform 0.2s;
            box-shadow: 0 2px 8px rgba(110,183,68,0.08);
        }
        .btn-readmore:hover {
            background: #5A8C43;
            color: #fff;
            transform: translateY(-2px) scale(1.04);
            box-shadow: 0 4px 16px rgba(110,183,68,0.15);
        }
        .btn-seeall {
            background: #6EB744;
            color: #fff;
            border: none;
            border-radius: 2rem;
            font-weight: 600;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            font-size: 1.1rem;
            padding: 0.75rem 2.5rem;
            box-shadow: 0 2px 8px rgba(110,183,68,0.08);
            transition: background 0.2s, transform 0.15s;
            outline: none;
            cursor: pointer;
        }
        .btn-seeall:hover {
            background: #5A8C43;
            color: #fff;
            transform: scale(1.04);
        }
        .btn-seeall:active {
            transform: scale(0.97);
            background: #3e632d;
        }

        
        /* Team Member Cards Styling */
        .team-slider-container {
            position: relative;
            max-width: 100%;
            overflow: hidden;
            margin: 0 auto;
        }

        .team-slider {
            display: flex;
            transition: transform 0.5s ease-in-out;
            gap: 2rem;
            padding: 1rem 0;
            transform-origin: left center;
        }

        .team-member-card {
            min-width: 320px;
            max-width: 320px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease-in-out;
            border: 1px solid rgba(0, 123, 255, 0.1);
            position: relative;
            overflow: hidden;
        }

        .team-member-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #6EB744, #5A8C43);
        }

        .team-member-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(90, 140, 67, 0.2);
            border-color: rgba(90, 140, 67, 0.3);
        }

        .member-image-container {
            width: 160px;
            height: 160px;
            margin: 0 auto 1.5rem;
            position: relative;
        }

        .member-image {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: 0 4px 15px rgba(110, 183, 68, 0.2);
            transition: transform 0.3s ease;
        }

        .member-image:hover {
            transform: scale(1.05);
        }

        .member-placeholder {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: linear-gradient(135deg, #6EB744, #5A8C43);
            display: flex;
            align-items: center;
            justify-content: center;
            border: 4px solid #fff;
            box-shadow: 0 4px 15px rgba(110, 183, 68, 0.2);
        }

        .member-placeholder i {
            font-size: 3rem;
            color: #fff;
        }

        .member-info {
            text-align: center;
        }

        .member-role {
            color: #6c757d;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .member-name {
            color: #212529;
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .member-bio {
            color: #6c757d;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            min-height: 4.5rem;
        }




        .slider-controls {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 2rem;
        }

        .slider-btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6EB744, #6EB744);
            color: #fff;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(110, 183, 68, 0.3);
        }

        .slider-btn:hover {
            background: linear-gradient(135deg, #5A8C43, #497236);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(110, 183, 68, 0.4);
        }

        .slider-btn:active {
            transform: translateY(0);
        }
        
        .slider-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            background: linear-gradient(135deg, #ccc, #999);
        }
        
        .slider-btn:disabled:hover {
            transform: none;
            box-shadow: 0 4px 15px rgba(110, 183, 68, 0.3);
        }

        .slider-btn i {
            font-size: 1.2rem;
        }

        /* Responsive Design for Team Cards */
        @media (max-width: 768px) {
            .team-slider {
                gap: 1rem;
            }
            
            .team-member-card {
                min-width: 280px;
                max-width: 280px;
                padding: 1.5rem;
            }
            
            .member-image-container {
                width: 140px;
                height: 140px;
            }
            
            .member-name {
                font-size: 1.1rem;
            }
            
            .member-bio {
                font-size: 0.9rem;
                min-height: 4rem;
            }
        }

        @media (max-width: 576px) {
            .team-member-card {
                min-width: 260px;
                max-width: 260px;
                padding: 1.25rem;
            }
            
            .member-image-container {
                width: 120px;
                height: 120px;
            }
            
            .member-name {
                font-size: 1rem;
            }
            
            .member-bio {
                font-size: 0.85rem;
                min-height: 3.5rem;
            }
        }
        
        .working-hours {
            font-size: 0.9rem;
            color: #6c757d;
            font-style: italic;
            margin-top: 0.5rem;
            margin-bottom: 0;
        }
        
        /* RTL Support for Contact Form */
        [dir="rtl"] .form-floating .form-control:focus ~ label,
        [dir="rtl"] .form-floating .form-control:not(:placeholder-shown) ~ label {
            transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
            right: 1rem;
            left: auto;
            text-align: right;
        }
        
        [dir="rtl"] .invalid-feedback,
        [dir="rtl"] .valid-feedback {
            text-align: right;
        }
        
        [dir="rtl"] .form-progress {
            flex-direction: row-reverse;
        }
        
        [dir="rtl"] .character-counter {
            text-align: right;
        }
        
        /* Fix RTL form control positioning */
        [dir="rtl"] .form-floating .form-control {
            text-align: right;
            padding-right: 0.75rem; /* keep compact default when not focused */
            padding-left: 0.75rem;
        }
        
        [dir="rtl"] .form-floating label {
            text-align: right;
            right: 1rem;
            left: auto;
        }
        
        /* RTL Label positioning on focus and filled state */
        [dir="rtl"] .form-floating .form-control:focus ~ label,
        [dir="rtl"] .form-floating .form-control:not(:placeholder-shown) ~ label {
            right: 0.75rem;
            left: auto;
            transform: scale(0.85) translateY(-0.6rem) translateX(0.15rem);
        }
        
        /* RTL hover effects */
        [dir="rtl"] .form-floating .form-control:hover {
            border-color: #6EB744;
        }
        
        /* RTL label hover behavior */
        [dir="rtl"] .form-floating .form-control:hover ~ label {
            color: #6EB744;
        }
        
        [dir="rtl"] .btn-submit:hover { }
        
        /* Additional RTL fixes */
        [dir="rtl"] .form-floating .form-control:focus,
        [dir="rtl"] .form-floating .form-control.is-invalid,
        [dir="rtl"] .form-floating .form-control.is-valid { }
        
        /* Fix RTL placeholder text alignment */
        [dir="rtl"] .form-floating .form-control::placeholder {
            text-align: right;
        }
        
        /* Ensure proper RTL icon positioning */
        [dir="rtl"] .form-floating label i {
            margin-left: 0.5rem;
            margin-right: 0;
        }
        
        /* RTL form validation message positioning */
        [dir="rtl"] .form-floating .invalid-feedback,
        [dir="rtl"] .form-floating .valid-feedback {
            text-align: right;
        }
        
        /* RTL character counter positioning (mirror English) */
        [dir="rtl"] .character-counter { }
        
        /* RTL Team Slider Controls */
        [dir="rtl"] .slider-controls {
            flex-direction: row-reverse;
        }
        
        [dir="rtl"] .slider-btn.prev-btn {
            order: 2;
        }
        
        [dir="rtl"] .slider-btn.next-btn {
            order: 1;
        }
        
        /* RTL Team Slider Container */
        [dir="rtl"] .team-slider-container,
        [lang="ar"] .team-slider-container {
            direction: rtl;
            justify-content: flex-end;
        }
        
        [dir="rtl"] .team-slider,
        [lang="ar"] .team-slider {
            direction: ltr;
            transform-origin: right center;
            margin-left: 0;
            margin-right: auto;
        }
        
        /* RTL Team Member Cards */
        [dir="rtl"] .team-member-card,
        [lang="ar"] .team-member-card {
            order: -1;
        }
        
        /* RTL Card Flow Implementation */
        [lang="ar"] .team-slider-container {
            flex-direction: row-reverse;
            direction: rtl;
        }
        
        [lang="ar"] .team-member-card {
            text-align: right;
            direction: rtl;
        }
        
        [lang="ar"] .team-member-card .card-body {
            text-align: right;
            direction: rtl;
        }
        
        [lang="ar"] .team-member-card h5,
        [lang="ar"] .team-member-card p {
            text-align: right;
            direction: rtl;
        }
        /* Center role and name on Arabic cards */
        [lang="ar"] .team-member-card .member-role,
        [lang="ar"] .team-member-card .member-name {
            text-align: center !important;
            margin-left: auto;
            margin-right: auto;
        }
        
        /* Isolate English terms in Arabic cards */
        [lang="ar"] .team-member-card .english-term {
            direction: ltr;
            text-align: left;
            unicode-bidi: isolate;
            display: inline-block;
        }
        
        /* RTL Card Image Positioning */
        [lang="ar"] .team-member-card .card-img-top {
            margin-left: 0;
            margin-right: auto;
        }
        
        /* RTL Card Border and Shadow */
        [lang="ar"] .team-member-card {
            border-radius: 15px 15px 15px 15px;
        }
        
        /* Ensure proper RTL positioning for team slider */
        [lang="ar"] .team-slider-container {
            justify-content: flex-end;
        }
        
        [lang="ar"] .team-slider {
            transform-origin: right center;
        }
        
        /* Fix card order for Arabic layout */
        [lang="ar"] .team-slider {
            display: flex;
            flex-direction: row-reverse;
        }
        
        /* Mission & Vision Cards - Responsive Design */
        @media (max-width: 767.98px) {
            .mission-icon-wrapper,
            .vision-icon-wrapper {
                display: none !important;
            }
            
            .card-body .row .col {
                padding-left: 0;
                padding-right: 0;
                flex: 1;
                min-width: 0;
            }
            
            .card-body .row .col-auto {
                display: none !important;
            }
            
            .card-body .row {
                margin-left: 0;
                margin-right: 0;
            }
            
            .card-body {
                padding: 1.5rem !important;
            }
            
            .card-text {
                font-size: 1rem !important;
                line-height: 1.6 !important;
            }
        }

        /* Service Card Styling */
        #services .btn-read-more {
            display: inline-block !important;
            margin-top: auto !important;
            padding: 12px 24px !important;
            border: 2px solid #6EB744 !important;
            border-radius: 25px !important;
            color: #6EB744 !important;
            text-decoration: none !important;
            font-weight: 600 !important;
            cursor: pointer !important;
            background-color: transparent !important;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
            position: relative !important;
            overflow: hidden !important;
            font-size: 0.95rem !important;
            letter-spacing: 0.5px !important;
            align-self: center !important;
            min-width: 120px !important;
            text-align: center !important;
            box-shadow: 0 2px 8px rgba(110, 183, 68, 0.15) !important;
        }

        #services .btn-read-more::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.9), transparent);
            transition: left 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1;
        }

        #services .btn-read-more:hover::before {
            left: 100%;
        }

        /* Button hover effect removed - only card hover remains */

        /* Ensure button hover effect is triggered when hovering over the service card - Higher specificity */
        #services .service-card:hover .btn-read-more {
            background-color: white !important;
            color: #6EB744 !important;
            border-color: white !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 16px rgba(255, 255, 255, 0.3) !important;
        }
        
        /* Combined hover effect removed - only card hover remains */

        #services .btn-read-more span,
        #services .btn-read-more {
            position: relative;
            z-index: 2;
        }

        /* ===== SERVICE CARDS - REFACTORED & ORGANIZED ===== */
        
        /* Main Service Card Container */
        .service-card {
            width: 100%;
            background: linear-gradient(135deg, #f8f8f8 0%, #ffffff 100%);
            border-radius: 15px;
            padding: 3.25rem 2rem 2rem 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border: 2px solid transparent;
            position: relative;
            overflow: visible;
            height: 100%;
            min-height: 320px;
            text-align: center;
            cursor: pointer;
            margin-bottom: 2rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(110, 183, 68, 0.05) 0%, rgba(110, 183, 68, 0.02) 100%);
            border-radius: 15px;
            opacity: 0;
            transition: opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            pointer-events: none;
        }

        .service-card:hover::before {
            opacity: 1;
        }
        
        /* Ensure proper spacing between service cards */
        .service-card + .service-card {
            margin-top: 2rem;
        }


        .service-card:hover {
            background: linear-gradient(135deg, #6EB744 0%, #5A8C43 100%);
            border-color: #6EB744;
            color: #ffffff;
            box-shadow: 0 12px 24px rgba(110, 183, 68, 0.25);
            transform: translateY(-8px);
            min-height: 320px; /* Maintain consistent height on hover */
        }


        /* RTL Card Flow Implementation */
        [lang="ar"] .service-card {
            text-align: right;
            direction: rtl;
        }

        [lang="ar"] .service-card .service-info {
            text-align: right;
            direction: rtl;
        }

        [lang="ar"] .service-card h4,
        [lang="ar"] .service-card p {
            text-align: right;
            direction: rtl;
        }

        /* Service Cards - Mobile Responsive (767.98px and below) */
        @media (max-width: 767.98px) {
            .service-card {
                margin-bottom: 2rem !important;
                padding: 3rem 1.5rem 1.5rem 1.5rem !important;
                min-height: 280px;
            }
            
            .service-icon-container {
                width: 70px;
                height: 70px;
                top: -35px;
            }
            
            .service-icon {
                width: 40px;
                height: 40px;
            }
            
            .service-icon-placeholder {
                width: 48px;
                height: 48px;
            }
            
            .service-name {
                font-size: 1.3rem;
                margin-top: 1rem !important;
                padding-top: 0.5rem;
            }
            
            .service-short-description {
                font-size: 0.95rem;
                margin-top: 0.5rem;
            }
            
            .service-info {
                padding-top: 1rem;
            }
            
            .col-lg-3.col-md-6.col-sm-12 {
                margin-bottom: 2rem !important;
            }
            
                    /* Better spacing for service section */
        #services .row {
            margin-bottom: 2rem;
        }
        
        #services .col-sm-12 {
            margin-bottom: 2rem !important;
        }

        /* Training Card Styling - Force proper display */
        .training-feature-card {
            width: 100% !important;
            background: #fff !important;
            border-radius: 12px !important;
            padding: 30px 20px !important;
            text-align: center !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: space-between !important;
            height: 380px !important;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08) !important;
            transition: all 0.3s ease !important;
            border: 1px solid #f0f0f0 !important;
            position: relative !important;
            z-index: 1 !important;
        }
        
        .training-feature-card:hover {
            transform: translateY(-8px) !important;
            box-shadow: 0 8px 25px rgba(0,0,0,0.12) !important;
            border-color: #e0e0e0 !important;
        }

        
        .training-feature-icon img {
            height: 45px !important;
            width: auto !important;
        }
        
        .training-feature-title {
            font-size: 1.4rem !important;
            font-weight: 700 !important;
            letter-spacing: .02em !important;
            margin: 0 0 15px 0 !important;
            color: #2c3e50 !important;
            line-height: 1.3 !important;
        }
        
        .training-feature-text {
            color: #6c757d !important;
            font-size: 15px !important;
            line-height: 1.6 !important;
            margin: 0 0 20px 0 !important;
            flex-grow: 1 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
        
        .training-feature-link {
            color: #6EB744 !important;
            text-decoration: none !important;
            font-weight: 600 !important;
            font-size: 16px !important;
            transition: all 0.3s ease !important;
            position: relative !important;
            padding: 8px 0 !important;
        }
        
        .training-feature-link:hover { 
            color: #5aa43a !important;
            text-decoration: underline !important;
        }
        
        .training-feature-link::after {
            content: '' !important;
            position: absolute !important;
            width: 0 !important;
            height: 2px !important;
            bottom: 0 !important;
            left: 0 !important;
            background-color: #6EB744 !important;
            transition: width 0.3s ease !important;
        }
        
        .training-feature-link:hover::after {
            width: 100% !important;
        }


        /* Service Icon Styling */
        .service-icon-container {
            width: 86px;
            height: 86px;
            position: absolute;
            top: -43px;
            left: 50%;
            transform: translateX(-50%);
            background: #ffffff;
            border-radius: 50%;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
        }

        .service-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            object-fit: contain;
            transition: transform 0.2s ease;
            display: block;
        }

        .service-card:hover .service-icon {
            transform: scale(1.15) rotate(8deg);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            filter: brightness(1.1) contrast(1.1);
        }

        .service-icon-placeholder {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: #6EB744;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.2s ease;
        }

        .service-icon-placeholder i {
            font-size: 1.6rem;
            color: #fff;
            transition: transform 0.2s ease;
        }

        .service-card:hover .service-icon-placeholder {
            transform: scale(1.15) rotate(8deg);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            background-color: #5A8C43;
        }

        .service-card:hover .service-icon-placeholder i {
            transform: scale(1.1);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Service Content */
        .service-info {
            text-align: center;
            padding-top: 1rem;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .service-name {
            color: #333 !important;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            line-height: 1.2;
            transition: color 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .service-short-description {
            color: #333 !important;
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            min-height: 3rem;
            transition: color 0.4s cubic-bezier(0.4, 0.2, 0.2, 1);
        }

        /* Service Card Text Hover Effects - Consolidated */
        .service-card:hover .service-name,
        .service-card:hover .service-short-description,
        .service-card:hover h4.service-name,
        .service-card:hover p.service-short-description,
        #services .service-card:hover .service-name,
        #services .service-card:hover .service-short-description,
        [lang="ar"] .service-card:hover .service-name,
        [lang="ar"] .service-card:hover .service-short-description {
            color: #ffffff !important;
            transition: color 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .service-card:hover .service-icon-container {
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-read-more {
            display: inline-block !important;
            margin-top: auto !important; /* Push button to bottom */
            padding: 12px 24px !important;
            border: 2px solid #6EB744 !important;
            border-radius: 25px !important;
            color: #6EB744 !important;
            text-decoration: none !important;
            font-weight: 600 !important;
            cursor: pointer !important;
            background-color: transparent !important;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
            position: relative !important;
            overflow: hidden !important;
            font-size: 0.95rem !important;
            letter-spacing: 0.5px !important;
            align-self: center !important;
            min-width: 120px !important;
            text-align: center !important;
            box-shadow: 0 2px 8px rgba(110, 183, 68, 0.15) !important;
            /* Override Bootstrap button styles */
            --bs-btn-padding-x: 24px !important;
            --bs-btn-padding-y: 12px !important;
            --bs-btn-font-size: 0.95rem !important;
            --bs-btn-font-weight: 600 !important;
            --bs-btn-border-radius: 25px !important;
            --bs-btn-border-width: 2px !important;
            --bs-btn-color: #6EB744 !important;
            --bs-btn-bg: transparent !important;
            --bs-btn-border-color: #6EB744 !important;
            --bs-btn-hover-color: white !important;
            --bs-btn-hover-bg: #6EB744 !important;
            --bs-btn-hover-border-color: #6EB744 !important;
            --bs-btn-active-color: white !important;
            --bs-btn-active-bg: #5A8C43 !important;
            --bs-btn-active-border-color: #5A8C43 !important;
        }

        .btn-read-more::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }


        /* Service Cards - Tablet Responsive (768px and below) */
        @media (max-width: 768px) {
            .service-card {
                padding: 1.5rem;
            }
            
            .service-icon-container {
                width: 100px;
                height: 100px;
            }
            
            .service-name {
                font-size: 1.3rem;
            }
            
            .service-short-description {
                font-size: 0.95rem;
                min-height: 2.5rem;
            }
            
            .btn-read-more {
                padding: 10px 20px !important;
                font-size: 0.9rem !important;
                min-width: 110px !important;
            }
        }

        /* Service Cards - Small Mobile (576px and below) */
        @media (max-width: 576px) {
            .service-card {
                padding: 1.25rem;
            }
            
            .service-icon-container {
                width: 90px;
                height: 90px;
            }
            
            .service-name {
                font-size: 1.2rem;
            }
            
            .service-short-description {
                font-size: 0.9rem;
                min-height: 2rem;
            }
            
            .btn-read-more {
                padding: 8px 16px !important;
                font-size: 0.85rem !important;
                min-width: 100px !important;
            }
        }

        
        /* Minimal RTL form rules: mirror English behavior, start from right */
        [dir="rtl"] .form-floating { direction: rtl; }
        [dir="rtl"] .form-floating .form-control { text-align: right; }
        
        /* Footer Styling */
        .footer-logo {
            height: 80px !important;
            width: auto !important;
            transition: transform 0.3s ease;
        }
        
        .footer-logo:hover {
            transform: scale(1.05);
        }
        
        /* Company description width constraint */
        .footer .company-info p {
            max-width: 400px;
        }
        
        .privacy-links a:hover {
            color: #6EB744 !important;
            transition: color 0.3s ease;
        }
        
        .footer ul li a:hover {
            color: #6EB744 !important;
            transition: color 0.3s ease;
            text-decoration: none !important;
            transform: translateX(5px);
        }
        
        /* More specific selectors for quick links */
        .footer .list-unstyled li a:hover {
            color: #6EB744 !important;
            transition: color 0.3s ease;
            text-decoration: none !important;
            transform: translateX(5px);
        }
        
        .footer .text-center ul li a:hover {
            color: #6EB744 !important;
            transition: color 0.3s ease;
            text-decoration: none !important;
            transform: translateX(5px);
        }
        
        /* Generic quick links hover */
        .list-unstyled li a:hover {
            color: #6EB744 !important;
            transition: color 0.3s ease;
            text-decoration: none !important;
            transform: translateX(5px);
        }
        
        .text-center ul li a:hover {
            color: #6EB744 !important;
            transition: color 0.3s ease;
            text-decoration: none !important;
            transform: translateX(5px);
        }
        
        .btn-success {
            background-color: #25D366 !important;
            border-color: #25D366 !important;
            transition: all 0.3s ease;
        }
        
        .btn-success:hover {
            background-color: #128C7E !important;
            border-color: #128C7E !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
        }
        
        /* Social Media Icons - Using Homepage Style */
        .footer .social-media-icons {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            gap: 1rem;
            margin-top: 1rem;
            flex-wrap: wrap;
        }
        
        /* Footer Social Media Icons - Specific Styling to Avoid Conflicts */
        .footer .social-media-icons .social-icon,
        .footer .social-icon {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 45px !important;
            height: 45px !important;
            background: rgba(110, 183, 68, 0.1) !important;
            border: 2px solid rgba(110, 183, 68, 0.3) !important;
            border-radius: 50% !important;
            color: #6EB744 !important;
            font-size: 1.2rem !important;
            text-decoration: none !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 2px 8px rgba(110, 183, 68, 0.1) !important;
            position: relative !important;
            overflow: hidden !important;
        }
        
        .footer .social-media-icons .social-icon:hover,
        .footer .social-icon:hover {
            background: #6EB744 !important;
            border-color: #6EB744 !important;
            color: white !important;
            transform: translateY(-2px) scale(1.1) !important;
            box-shadow: 0 4px 15px rgba(110, 183, 68, 0.3) !important;
            text-decoration: none !important;
        }
        
      
        /* Footer Section Spacing */
        .footer .company-info,
        .footer .quick-links,
        .footer .contact-section {
            margin-bottom: 2rem;
        }
        
        .footer .contact-section:last-child {
            margin-bottom: 0;
        }
        
        /* Quick Links Centering */
        .footer .quick-links .text-center {
            width: 100%;
        }
        
        .footer .quick-links .text-center ul {
            display: inline-block;
            text-align: center;
        }
        .footer .quick-links .text-center ul li  {
            margin-bottom: 0;

        }
        
        /* RTL Footer Support */
        [dir="rtl"] .footer-logo {
            margin-left: 0;
            margin-right: 0;
        }
        
        [dir="rtl"] .privacy-links a {
            margin-left: 1rem;
            margin-right: 0;
        }
        
        [dir="rtl"] .privacy-links a:first-child {
            margin-left: 0;
        }
        
        /* Arabic Footer Specific Styles */
        [lang="ar"] .footer {
            padding: 3rem 0;
        }
        
        [lang="ar"] .footer .container {
            padding-right: 2rem;
            padding-left: 1rem;
        }
        
        /* RTL Layout for Arabic Footer */
        [lang="ar"] .footer .row {
            flex-direction: row-reverse;
        }
        
        [lang="ar"] .footer .company-info {
            padding-right: 0;
            padding-left: 2rem;
            text-align: right;
        }
        
        [lang="ar"] .footer .quick-links {
            padding-right: 1rem;
            padding-left: 1rem;
            text-align: center;
        }
        
        [lang="ar"] .footer .contact-section {
            padding-right: 2rem;
            padding-left: 0;
        }
        
        [lang="ar"] .footer .d-flex {
            margin-bottom: 1.5rem;
        }
        
        [lang="ar"] .footer h5 {
            margin-right: 1rem;
            margin-left: 0;
        }
        
        [lang="ar"] .footer p {
            margin-bottom: 1rem;
            line-height: 1.8;
            text-align: right;
        }
        

        
        [lang="ar"] .footer ul {
            margin-bottom: 1.5rem;
            text-align: center;
        }
        
        [lang="ar"] .footer ul li {
            margin-bottom: 0.8rem;
            text-align: center;
        }
        
        [lang="ar"] .footer ul li a:hover {
            transform: translateX(-5px);
        }
        
        [lang="ar"] .footer .list-unstyled li a:hover {
            transform: translateX(-5px);
        }
        
        [lang="ar"] .footer .text-center ul li a:hover {
            transform: translateX(-5px);
        }
        
        [lang="ar"] .list-unstyled li a:hover {
            transform: translateX(-5px);
        }
        
        [lang="ar"] .text-center ul li a:hover {
            transform: translateX(-5px);
        }
        
        [lang="ar"] .footer .btn {
            margin-top: 1rem;
            padding: 0.75rem 1.5rem;
        }
        
        [lang="ar"] .footer hr {
            margin: 2rem 0 1.5rem 0;
        }
        
        [lang="ar"] .footer .social-media-icons {
            justify-content: flex-end;
        }
        
        [lang="ar"] .footer .social-media-icons .social-icon {
            margin-left: 0.5rem;
            margin-right: 0;
        }
        [dir="rtl"] .form-floating label { right: 1rem; left: auto; text-align: right; }
        [dir="rtl"] .form-floating .form-control:focus ~ label,
        [dir="rtl"] .form-floating .form-control:not(:placeholder-shown) ~ label { right: 0.75rem; left: auto; }
        [dir="rtl"] .form-floating .form-control::placeholder { text-align: right; }

        </style>
        
        <script>
        // Homepage Team Slider Functionality
        let homeCurrentSlide = 0;
        const homeTotalSlides = {{ count($teamMembers) }};
        const homeSlidesPerView = 3;
        const homeMaxSlides = Math.max(0, homeTotalSlides - homeSlidesPerView);

        function slideHomeTeam(direction) {
            if (direction === 'next') {
                if (homeCurrentSlide < homeMaxSlides) {
                    homeCurrentSlide++;
                }
            } else if (direction === 'prev') {
                if (homeCurrentSlide > 0) {
                    homeCurrentSlide--;
                }
            }
            
            updateHomeSlider();
        }

        function updateHomeSlider() {
            const slider = document.getElementById('homeTeamSlider');
            if (!slider) return;
            
            const isRTL = document.documentElement.dir === 'rtl' || document.documentElement.lang === 'ar';
            const translateX = isRTL ? 
                (homeCurrentSlide * 340) : 
                -(homeCurrentSlide * 340);
            
            slider.style.transform = `translateX(${translateX}px)`;
            
            // Update button states
            const prevBtn = document.querySelector('.prev-btn');
            const nextBtn = document.querySelector('.next-btn');
            
            if (prevBtn) {
                prevBtn.disabled = homeCurrentSlide === 0;
                prevBtn.style.opacity = homeCurrentSlide === 0 ? '0.5' : '1';
            }
            
            if (nextBtn) {
                nextBtn.disabled = homeCurrentSlide === homeMaxSlides;
                nextBtn.style.opacity = homeCurrentSlide === homeMaxSlides ? '0.5' : '1';
            }
        }

        // Initialize homepage team slider
        document.addEventListener('DOMContentLoaded', function() {
            updateHomeSlider();
            
            // Add click event listeners to slider buttons
            const prevBtn = document.querySelector('.prev-btn');
            const nextBtn = document.querySelector('.next-btn');
            
            if (prevBtn) {
                prevBtn.addEventListener('click', function() {
                    slideHomeTeam('prev');
                });
            }
            
            if (nextBtn) {
                nextBtn.addEventListener('click', function() {
                    slideHomeTeam('next');
                });
            }
            
            // Reset slider position when language changes (for RTL/LTR switching)
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'attributes' && 
                        (mutation.attributeName === 'dir' || mutation.attributeName === 'lang')) {
                        
                        homeCurrentSlide = 0;
                        updateHomeSlider();
                        
                        // Update button icons for RTL/LTR
                        if (prevBtn && nextBtn) {
                            const prevIcon = prevBtn.querySelector('i');
                            const nextIcon = nextBtn.querySelector('i');
                            const isRTL = document.documentElement.dir === 'rtl' || document.documentElement.lang === 'ar';
                            
                            if (prevIcon && nextIcon) {
                                if (isRTL) {
                                    prevIcon.className = 'bi bi-chevron-right';
                                    nextIcon.className = 'bi bi-chevron-left';
                                } else {
                                    prevIcon.className = 'bi bi-chevron-left';
                                    nextIcon.className = 'bi bi-chevron-right';
                                }
                            }
                        }
                    }
                });
            });
            
            observer.observe(document.documentElement, {
                attributes: true,
                attributeFilter: ['dir', 'lang']
            });
            
            // Fix RTL form behavior
            if (document.documentElement.dir === 'rtl' || document.documentElement.lang === 'ar') {
                // Ensure proper RTL form validation display
                const formControls = document.querySelectorAll('.form-control');
                formControls.forEach(control => {
                    control.addEventListener('focus', function() {
                        this.style.textAlign = 'right';
                    });
                    
                    control.addEventListener('blur', function() {
                        if (this.value) {
                            this.style.textAlign = 'right';
                        }
                    });
                });
                
                // RTL form setup is now handled by CSS
                
                // Fix RTL progress steps
                const progressSteps = document.querySelectorAll('.progress-step');
                progressSteps.forEach(step => {
                    step.style.marginRight = '0';
                    step.style.marginLeft = '0.5rem';
                });
                
                // Fix RTL team slider controls
                if (prevBtn && nextBtn) {
                    // Swap button icons for RTL
                    const prevIcon = prevBtn.querySelector('i');
                    const nextIcon = nextBtn.querySelector('i');
                    
                    if (prevIcon && nextIcon) {
                        prevIcon.className = 'bi bi-chevron-right';
                        nextIcon.className = 'bi bi-chevron-left';
                    }
                }
            }
            
            // Initial button icon setup
            if (prevBtn && nextBtn) {
                const prevIcon = prevBtn.querySelector('i');
                const nextIcon = nextBtn.querySelector('i');
                const isRTL = document.documentElement.dir === 'rtl' || document.documentElement.lang === 'ar';
                
                if (prevIcon && nextIcon) {
                    if (isRTL) {
                        prevIcon.className = 'bi bi-chevron-right';
                        nextIcon.className = 'bi bi-chevron-left';
                    } else {
                        prevIcon.className = 'bi bi-chevron-left';
                        nextIcon.className = 'bi bi-chevron-right';
                    }
                }
            }
        });
        

        </script>
        
        <style>
        /* Project card styling */
        .project-card-custom {
            position: relative;
            transition: all 0.3s ease;
        }
        
        .project-card-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }
        </style>
        
                <!-- WhatsApp Component -->
        @include('components.whatsapp')
        
        <!-- Footer -->
        @include('components.footer')

    </body>
<!-- </html>  -->
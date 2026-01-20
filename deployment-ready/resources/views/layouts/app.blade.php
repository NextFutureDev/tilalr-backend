<!DOCTYPE html>
<html lang="{{ App::getLocale() }}" dir="{{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Projects') | Sensing Nature</title>
    <meta name="description" content="Sensing Nature - Professional consulting, development, engineering, meteorological and environmental services.">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/icon/favicon.ico') }}?v={{ file_exists(public_path('assets/icon/favicon.ico')) ? filemtime(public_path('assets/icon/favicon.ico')) : time() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    @if(App::getLocale() == 'ar')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.rtl.min.css">
    @endif
    <style>
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
        :root {
            --primary: #6EB744;
            --secondary: #212529;
            --accent: #343a40;
            --bg: #f8f9fa;
            --card-bg: #fff;
            --text: #212529;
            --radius: 1.25rem;
            --bs-primary: #6EB744;
            --bs-link-color: #6EB744;
            --bs-link-hover-color: #5A8C43;
            /* Global container sizing */
            --container-max: 1200px;
            --container-pad-sm: 0.75rem;
            --container-pad-md: 1rem;
            --container-pad-lg: 1.5rem;
        }
        html, body {
            font-family: 'Inter', Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
            font-size: 1.05rem;
        }
        .navbar {
            font-weight: 600;
            letter-spacing: 0.01em;
        }
        .navbar-nav .nav-link.active, .navbar-nav .nav-link:focus, .navbar-nav .nav-link:hover { color: var(--primary) !important; background: transparent !important; transform: none !important; box-shadow: none !important; }
        
        /* Enhanced navbar text styling */
        .navbar-nav .nav-link {
            font-weight: 700 !important;
            font-size: 1.4rem !important;
            letter-spacing: 0.02em;
        }
        
        .navbar-brand {
            font-weight: 700 !important;
        }
        
        .dropdown-toggle {
            font-weight: 700 !important;
            font-size: 1.2rem !important;
        }
        
        .dropdown-item {
            font-weight: 600 !important;
            font-size: 1rem !important;
        }
        
        /* Add spacing between navbar links on inner pages (desktop) */
        @media (min-width: 1400px) {
            .navbar-nav {
                gap: 1.5rem;
            }
        }
        .card {
            border-radius: var(--radius);
            background: var(--card-bg);
            box-shadow: 0 2px 12px rgba(44,62,80,0.08);
            transition: box-shadow 0.2s, transform 0.2s;
        }
        .card:hover {
            box-shadow: 0 8px 32px rgba(44,62,80,0.18), 0 1.5px 4px rgba(44,62,80,0.08);
            transform: translateY(-4px) scale(1.03);
        }
        .btn-primary, .btn-lg, .btn-submit {
            background: var(--primary) !important;
            border: none;
            border-radius: 2rem;
            font-weight: 600;
            letter-spacing: 0.02em;
            transition: background 0.2s, box-shadow 0.2s;
        }
        .btn-primary:hover, .btn-lg:hover, .btn-submit:hover {
            background: #5A8C43 !important;
            box-shadow: 0 4px 16px rgba(110,183,68,0.15);
        }
        .divider {
            width: 60px;
            height: 4px;
            background: var(--primary);
            margin: 1rem auto 2rem auto;
            border-radius: 2px;
        }
        h1, h2, h3, h4, h5, h6 {
            font-weight: 700;
            color: var(--accent);
        }
        .page-section {
            padding: 4rem 0 3rem 0;
        }
        @media (max-width: 1399px) {
            .page-section {
                padding: 2.5rem 0 2rem 0;
            }
            .card-img-top {
                height: 160px !important;
            }
        }
        /* Enhanced mobile navbar styles */
        @media (max-width: 1399px) {
            .navbar {
                padding: 0.75rem 0;
            }
            
            .navbar-nav {
                margin-top: 1rem;
                padding: 1rem 0;
            }
            
            .navbar-nav .nav-item {
                margin: 0.25rem 0;
            }
            
            .navbar-nav .nav-link {
                padding: 0.75rem 1rem;
                text-align: center;
                border-radius: 0.5rem;
                margin: 0.25rem 0;
                transition: all 0.3s ease;
            }
            
            .navbar-nav .nav-link:hover { background-color: transparent !important; transform: none !important; color: var(--primary) !important; box-shadow: none !important; }
            
            .dropdown-menu {
                position: static !important;
                float: none !important;
                width: 100% !important;
                margin-top: 0.5rem !important;
                background-color: rgba(248, 249, 250, 0.95) !important;
                border: 1px solid rgba(110, 183, 68, 0.2) !important;
                box-shadow: 0 4px 12px rgba(0,0,0,.1) !important;
                border-radius: 0.5rem !important;
            }
            
            .dropdown-item {
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
            
            .dropdown-item:hover { color: #6EB744 !important; background-color: transparent !important; transform: none !important; box-shadow: none !important; }
            /* Make collapsed menu scrollable */
            .navbar-collapse { max-height: calc(100vh - 100px); overflow-y: auto; }
        }
        
        @media (max-width: 767px) {
            .navbar-nav {
                text-align: center;
            }
            .card-img-top {
                height: 120px !important;
            }
            .page-section {
                padding: 1.5rem 0 1rem 0;
            }
            
            /* Enhanced mobile navbar */
            .navbar {
                padding: 0.5rem 0;
            }
            
            .navbar-nav .nav-link {
                font-size: 1.1rem !important;
                padding: 0.875rem 1rem;
            }
            
            .navbar-toggler {
                padding: 0.5rem;
                border-radius: 0.5rem;
                transition: all 0.3s ease;
            }
            
            .navbar-toggler:hover {
                background-color: rgba(110, 183, 68, 0.1);
            }
            
            .navbar-toggler:focus {
                box-shadow: 0 0 0 0.2rem rgba(110, 183, 68, 0.25);
            }
        }
        
        @media (max-width: 575px) {
            .navbar {
                padding: 0.375rem 0;
            }
            
            .navbar-nav .nav-link {
                font-size: 1.05rem !important;
                padding: 0.75rem 0.875rem;
            }
            
            .dropdown-item {
                font-size: 0.9rem !important;
                padding: 0.625rem 0.875rem !important;
            }
        }
        /* Hide native scrollbars and add top progress bar */
        html { scrollbar-width: none; }
        body { -ms-overflow-style: none; }
        body::-webkit-scrollbar { width: 0; height: 0; }
        .scroll-progress-track { position: fixed; top: 0; left: 0; height: 4px; width: 100%; background: #fff; z-index: 1199; }
        .scroll-progress-bar { position: fixed; top: 0; left: 0; height: 4px; width: 0%; background: #6EB744; z-index: 1200; box-shadow: 0 1px 2px rgba(0,0,0,.08); }
    </style>
</head>
<body class="has-progress">
    <div class="scroll-progress-track"></div>
    <div class="scroll-progress-bar" id="scrollProgress"></div>


    <nav class="navbar navbar-expand-xxl navbar-light bg-light fixed-top py-3">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand d-flex align-items-center" href="/{{ app()->getLocale() }}">
                @php
                    $logoFile = App::getLocale() == 'ar' ? 'logo-arabic.png' : 'logo.png';
                    $logoPath = "assets/img/{$logoFile}";
                @endphp
                <img src="{{ asset($logoPath) }}?v={{ file_exists(public_path($logoPath)) ? filemtime(public_path($logoPath)) : time() }}" alt="{{ __('messages.company_name') }} logo" class="brand-logo">
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="/{{ app()->getLocale() }}">{{ __('messages.home') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route(app()->getLocale() . '.projects.index') }}">{{ __('messages.projects') }}</a></li>
                    <!-- Remove Portfolio on non-home pages as requested -->
                    <!-- Keep team link but point to team page -->
                    <li class="nav-item"><a class="nav-link" href="{{ route(app()->getLocale() . '.training.index') }}">{{ __('messages.training') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route(app()->getLocale() . '.team.index') }}">{{ __('messages.team') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route(app()->getLocale() . '.contact.index') }}">{{ __('messages.contact') }}</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
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
    <main>
        @yield('content')
    </main>
    @php($routeName = \Illuminate\Support\Facades\Route::currentRouteName())
    @if(!in_array($routeName, ['en.home','ar.home']))
        @include('components.footer')
    @endif
    @include('components.whatsapp')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <style>
        /* Navbar Styling for Inner Pages */
        .navbar {
            background-color: white !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1) !important;
        }
        
        /* Add top padding to main content to account for fixed navbar */
        main {
            padding-top: 80px;
        }
        
        /* Responsive main content padding */
        @media (max-width: 1399px) {
            main {
                padding-top: 70px;
            }
        }
        
        @media (max-width: 767px) {
            main {
                padding-top: 60px;
            }
        }
        
        @media (max-width: 575px) {
            main {
                padding-top: 55px;
            }
        }

        /* =============================
           Global Container Standardization
           Applies a consistent container shell across pages
        ============================== */
        /* Direct content containers in pages */
        main > .container,
        main > section > .container,
        .page-section > .container {
            max-width: var(--container-max);
            margin-left: auto;
            margin-right: auto;
            padding-left: var(--container-pad-lg);
            padding-right: var(--container-pad-lg);
            width: 100%;
        }
        /* Tablet paddings */
        @media (min-width: 768px) and (max-width: 1023px) {
            main > .container,
            main > section > .container,
            .page-section > .container { padding-left: var(--container-pad-md); padding-right: var(--container-pad-md); }
        }
        /* Mobile paddings */
        @media (max-width: 767px) {
            main > .container,
            main > section > .container,
            .page-section > .container { padding-left: var(--container-pad-sm); padding-right: var(--container-pad-sm); }
        }
        /* Full-width containers still get consistent padding */
        main > .container-fluid,
        main > section > .container-fluid { padding-left: var(--container-pad-lg); padding-right: var(--container-pad-lg); }
        @media (min-width: 768px) and (max-width: 1023px) {
            main > .container-fluid,
            main > section > .container-fluid { padding-left: var(--container-pad-md); padding-right: var(--container-pad-md); }
        }
        @media (max-width: 767px) {
            main > .container-fluid,
            main > section > .container-fluid { padding-left: var(--container-pad-sm); padding-right: var(--container-pad-sm); }
        }
        
        /* Footer Styling */
        .footer-logo {
            transition: transform 0.3s ease;
        }
        
        .footer-logo:hover {
            transform: scale(1.05);
        }
        
        /* Company name and logo link styling */
        .footer a.d-flex:hover {
            text-decoration: none !important;
        }
        
        .footer a.d-flex:hover .footer-logo {
            transform: scale(1.05);
        }
        
        .footer a.d-flex:hover h5 {
            color: #6EB744 !important;
            transition: color 0.3s ease;
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
        
        /* Footer WhatsApp Button - Enhanced globally */
        .footer .btn-success {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important;
            max-width: 420px !important;
            min-width: 220px !important;
            padding: 0.85rem 1.5rem !important;
            margin: 0.75rem auto 1.25rem !important;
            white-space: nowrap !important;
            font-size: 1rem !important;
            border-radius: 999px !important;
        }
        @media (min-width: 768px) {
            .footer .btn-success { max-width: 460px !important; padding: 0.9rem 1.75rem !important; }
        }
        @media (min-width: 1200px) {
            .footer .btn-success { width: auto !important; min-width: 280px !important; margin: 0.5rem auto 1rem !important; }
        }
        
        /* Mobile Footer Override - Force center alignment */
        @media (max-width: 767px) {
            .footer .company-info,
            .footer .quick-links,
            .footer .contact-section {
                text-align: center !important;
            }
            
            .footer .company-info p {
                text-align: center !important;
            }
            
            .footer h6 {
                text-align: center !important;
            }
            
            .footer .quick-links .text-center ul {
                text-align: center !important;
            }
            
            .footer .quick-links .text-center ul li {
                text-align: center !important;
            }
            
            .footer .quick-links .text-center ul li a {
                text-align: center !important;
            }
            
            /* Copyright section centering */
            .footer .col-12.text-center {
                text-align: center !important;
            }
            
            .footer .col-12.text-center span {
                text-align: center !important;
                display: block !important;
            }
        }
        
        /* Footer Social Media Icons - Centered Flex Row */
        .footer .social-media-icons {
            display: flex !important;
            flex-wrap: wrap;
            justify-content: center !important;
            align-items: center !important;
            gap: 10px 10px;
            margin: 1rem auto 0 auto;
            max-width: none;
            width: 100%;
        }
        @media (min-width: 768px) {
            .footer .social-media-icons { flex-wrap: nowrap; }
        }

        .footer .social-media-icons .social-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            background: rgba(110, 183, 68, 0.1);
            border: 2px solid rgba(110, 183, 68, 0.3);
            border-radius: 50%;
            color: #6EB744;
            font-size: 1.2rem;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(110, 183, 68, 0.1);
        }
        
        .footer .social-media-icons .social-icon:hover {
            background: #6EB744;
            border-color: #6EB744;
            color: white;
            transform: translateY(-2px) scale(1.1);
            box-shadow: 0 4px 15px rgba(110, 183, 68, 0.3);
            text-decoration: none;
        }
        
        .footer .social-media-icons .social-icon i {
            font-size: 18px;
            color: #6EB744;
            transition: all 0.3s ease;
        }
        
        .footer .social-media-icons .social-icon:hover i {
            color: white;
        }
        
        .footer .social-media-icons .social-icon svg,
        .footer .social-icon svg {
            width: 20px !important;
            height: 20px !important;
            transition: all 0.3s ease !important;
            fill: #6EB744 !important;
            display: block !important;
        }
        
        .footer .social-media-icons .social-icon:hover svg,
        .footer .social-icon:hover svg {
            fill: white !important;
        }
        
        /* FontAwesome Icons Styling for Footer */
        .footer .social-media-icons .social-icon i,
        .footer .social-icon i {
            font-size: 18px !important;
            color: #6EB744 !important;
            transition: all 0.3s ease !important;
            display: block !important;
            width: 100% !important;
            height: 100% !important;
            line-height: 45px !important;
            text-align: center !important;
        }
        
        .footer .social-media-icons .social-icon:hover i,
        .footer .social-icon:hover i {
            color: white !important;
        }
        
        /* Generic social media icons for non-footer areas */
        .social-media-icons:not(.footer .social-media-icons) .social-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            background: rgba(110, 183, 68, 0.1);
            border: 2px solid rgba(110, 183, 68, 0.3);
            border-radius: 50%;
            color: #6EB744;
            font-size: 1.2rem;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(110, 183, 68, 0.1);
            position: relative;
            overflow: hidden;
        }
        
        .social-media-icons:not(.footer .social-media-icons) .social-icon:hover {
            background: #6EB744 !important;
            border-color: #6EB744 !important;
            color: white !important;
            transform: translateY(-2px) scale(1.1) !important;
            box-shadow: 0 4px 15px rgba(110, 183, 68, 0.3) !important;
            text-decoration: none !important;
        }
        
        .social-media-icons:not(.footer .social-media-icons) .social-icon svg {
            width: 20px !important;
            height: 20px !important;
            transition: all 0.3s ease;
            fill: #6EB744 !important;
            display: block !important;
        }
        
        .social-media-icons:not(.footer .social-media-icons) .social-icon:hover svg {
            fill: white !important;
        }
        
        /* Inner Pages Footer - Centered Content */
        
        /* Mobile Footer Centering */
        @media (max-width: 767px) {
            .footer {
                padding: 2rem 0 !important;
            }
            
            .footer .container {
                max-width: 500px;
                margin: 0 auto;
                padding-left: 1rem;
                padding-right: 1rem;
            }
            
            .footer .row {
                display: block;
            }
            
            .footer .company-info,
            .footer .quick-links,
            .footer .contact-section {
                text-align: center !important;
                margin-bottom: 2rem;
            }
            
            .footer .company-info p {
                max-width: none !important;
                width: 100%;
                text-align: center !important;
                padding: 0 0.5rem;
                line-height: 1.6;
                margin: 0 auto;
            }
            
            .footer .footer-logo {
                height: 60px !important;
                width: auto !important;
                margin: 0 auto !important;
                display: block !important;
            }
            
            .footer .quick-links .text-center {
                text-align: center !important;
            }
            
            .footer .quick-links .text-center ul {
                text-align: center !important;
                display: inline-block;
            }
            
            .footer .quick-links .text-center ul li {
                text-align: center !important;
            }
            
            .footer .quick-links .text-center ul li a {
                text-align: center !important;
            }
            
            .footer .social-media-icons {
                display: flex !important;
                flex-wrap: wrap;
                justify-content: center !important;
                align-items: center !important;
                gap: 8px 8px;
                max-width: none;
                margin: 1rem auto 0 !important;
            }
            
            .footer .btn {
                width: 100% !important;
                max-width: 460px !important;
                min-width: 220px !important;
                padding: 0.85rem 1.5rem !important;
                margin: 0.75rem auto 1.25rem !important;
                border-radius: 999px !important;
            }
        }
        
        /* Extra small mobile */
        @media (max-width: 575px) {
            .footer .container {
                max-width: 450px;
            }
            
            .footer .company-info p {
                padding: 0 0.25rem;
                font-size: 0.95rem;
            }
            
            .footer .footer-logo {
                height: 50px !important;
            }
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
            text-align: center !important;
        }
        
        /* RTL Navbar Support */
        [dir="rtl"] .navbar-nav .nav-link:hover { transform: none !important; }
        
        [dir="rtl"] .dropdown-item:hover { transform: none !important; }
        
        [dir="rtl"] .navbar-nav {
            margin-right: auto;
            margin-left: 0;
        }
        
        /* RTL Footer Support */
        [dir="rtl"] .footer-logo {
            margin-left: 1rem;
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
            padding-right: 0rem;
            padding-left: 1rem;
        }
        
        /* RTL Layout for Arabic Footer - keep natural order: company | quick links | contact */
        [lang="ar"] .footer .row {
            flex-direction: row !important;
        }
        
        /* RTL Layout for Arabic Footer - Reorder columns for proper RTL layout */
        [lang="ar"] .footer .row {
            flex-direction: row-reverse !important;
        }
        
        [lang="ar"] .footer .company-info {
            order: 3 !important;
            padding-right: 0 !important;
            padding-left: 0 !important;
        }
        /* Keep Arabic text right-aligned only on tablet/desktop. Mobile stays centered. */
        @media (min-width: 768px) {
            [lang="ar"] .footer .company-info { text-align: right; }
        }
        
        [lang="ar"] .footer .quick-links {
            order: 2 !important;
            padding-right: 1rem;
            padding-left: 1rem;
            text-align: center;
        }
        
        [lang="ar"] .footer .contact-section {
            order: 1 !important;
            padding-right: 0 !important;
            padding-left: 0 !important;
        }
        
        [lang="ar"] .footer .d-flex {
            margin-bottom: 1.5rem;
        }
        
        [lang="ar"] .footer h5 {
            margin-right: 0 !important;
            margin-left: 0;
        }
        [lang="ar"] .footer h6 {
            margin-right: 0 !important;
        }

        [lang="ar"] .footer .company-info {
            padding-right: 0 !important;
            padding-left: 0 !important;
        }
        
        [lang="ar"] .footer p {
            margin-bottom: 1rem;
            line-height: 1.8;
        }
        /* Keep Arabic paragraph text right-aligned only above mobile */
        @media (min-width: 768px) {
            [lang="ar"] .footer p { text-align: right; }
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
            justify-content: center !important;
        }
        
        [lang="ar"] .footer .social-media-icons .social-icon {
            margin-right: 0.5rem;
            margin-left: 0;
        }
        /* override footer paragraph width */
        .footer .company-desc{max-width:400px!important;}
        /* canonical quick link hover */
        .footer .list-unstyled li a:hover{color:#6EB744!important;transform:translateX(5px);text-decoration:none!important;}
        /* layout tweaks footer columns */
        @media (min-width: 992px) {
            .footer .company-info{flex:0 0 35%!important;max-width:35%!important;}
            .footer .quick-links{flex:0 0 20%!important;max-width:20%!important;}
        }
        
        /* Footer quick links hover effects - override !important */
        .footer-quick-link:hover {
            color: #6EB744 !important;
            text-decoration: underline !important;
            transition: all 0.3s ease;
        }

        /* Global: top spacing under navbar (applies to all pages, including training) */
        .page-section:first-of-type,
        main > section:first-of-type,
        main > .container:first-of-type { margin-top: 35px; }
        @media (min-width: 768px) and (max-width: 1023px) {
            .page-section:first-of-type,
            main > section:first-of-type,
            main > .container:first-of-type { margin-top: 40px; }
        }
        @media (min-width: 1024px) {
            .page-section:first-of-type,
            main > section:first-of-type,
            main > .container:first-of-type { margin-top: 50px; }
        }

        /* Navbar hover background (only active on small screens when burger menu is open) */
        .navbar-nav .nav-link,
        .dropdown-item { transition: background-color .25s ease, color .25s ease; border-radius: .5rem; }
        @media (max-width: 1399px) {
            /* Add comfortable spacing in mobile menu */
            .navbar-nav .nav-link { margin: .125rem .5rem; padding: .75rem 1rem; }
            /* Apply hover highlight only when the collapse is open */
            .navbar .collapse.show .navbar-nav .nav-link:hover,
            .navbar .collapse.show .navbar-nav .nav-link:focus { background-color: rgba(110, 183, 68, 0.12) !important; color: var(--primary) !important; }
            .navbar .collapse.show .dropdown-item:hover,
            .navbar .collapse.show .dropdown-item:focus { background-color: rgba(110, 183, 68, 0.12) !important; color: #6EB744 !important; }
        }
        
        /* Ensure contact button and social icons share the same width container on all pages */
        .footer .contact-section { display: flex; flex-direction: column; align-items: center; }
        .footer .contact-section .contact-content {
            width: 100%;
            max-width: 520px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .footer .contact-section .contact-content .btn-success { width: 100% !important; max-width: 100% !important; min-width: 0 !important; }
        .footer .contact-section .contact-content .social-media-icons { width: 100% !important; max-width: 100% !important; justify-content: center !important; flex-wrap: wrap !important; }
        @media (min-width: 768px) { .footer .contact-section .contact-content { max-width: 560px; } }
        @media (min-width: 1200px) { .footer .contact-section .contact-content { max-width: 640px; } }
    </style>
    <script>
        // Language switching function
        function switchLanguage(locale) {
            // Send only path + query + hash to avoid host/scheme issues
            const { pathname, search, hash } = window.location;
            const relative = `${pathname}${search}${hash}`;
            const languageSwitchUrl = `/switch-language/${locale}?current_url=${encodeURIComponent(relative)}`;
            
            window.location.href = languageSwitchUrl;
        }
        
        // Prevent navbar collapse when clicking on dropdown items
        document.addEventListener('DOMContentLoaded', function() {
            // Override Bootstrap's navbar collapse behavior for language dropdown
            const navbarToggler = document.querySelector('.navbar-toggler');
            const navbarCollapse = document.querySelector('#navbarNav');
            
            if (navbarToggler && navbarCollapse) {
                // Override the navbar toggler behavior
                navbarToggler.addEventListener('click', function(e) {
                    // Check if dropdown is open
                    const dropdown = document.querySelector('.dropdown-menu.show');
                    if (dropdown) {
                        e.preventDefault();
                        e.stopPropagation();
                        return false;
                    }
                });
            }
            
            // Handle dropdown items
            const dropdownItems = document.querySelectorAll('.dropdown-item');
            dropdownItems.forEach(function(item) {
                item.addEventListener('click', function(e) {
                    e.stopPropagation();
                    e.preventDefault();
                    
                    const locale = this.getAttribute('data-locale');
                    if (locale) {
                        // Close dropdown manually
                        const dropdown = this.closest('.dropdown');
                        if (dropdown) {
                            const dropdownMenu = dropdown.querySelector('.dropdown-menu');
                            if (dropdownMenu) {
                                dropdownMenu.classList.remove('show');
                            }
                        }
                        
                        // Switch language
                        switchLanguage(locale);
                    }
                });
            });
            
            // Handle dropdown toggle
            const dropdownToggle = document.querySelector('#languageDropdown');
            if (dropdownToggle) {
                dropdownToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }
            
            // Prevent navbar collapse when clicking anywhere in dropdown
            document.addEventListener('click', function(e) {
                if (e.target.closest('.dropdown')) {
                    e.stopPropagation();
                }
            });
        });
        // AOS init on page load for non-homepage pages
        (function () {
            const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            const isMobile = window.matchMedia('(max-width: 575.98px)').matches;
            function stripAos(){ document.querySelectorAll('[data-aos]').forEach(el=>el.removeAttribute('data-aos')); }
            
            // Check if this is the homepage
            const isHomepage = window.location.pathname === '/' || window.location.pathname === '/en' || window.location.pathname === '/ar';
            
            if (isHomepage) {
                // For homepage, keep scroll-triggered animations (handled in index.blade.php)
                return;
            }
            
            // For other pages, initialize AOS immediately on page load
            function initAOS(){ 
                if(reduceMotion){ stripAos(); return;} 
                AOS.init({ 
                    duration:650, 
                    easing:'ease-out-cubic', 
                    once:true, 
                    offset: 0, // No offset for immediate animation
                    mirror:false 
                }); 
            }
            
            // Initialize immediately on page load for non-homepage pages
            document.addEventListener('DOMContentLoaded', initAOS);
        })();
        // Top scroll progress bar
        (function(){ const bar=document.getElementById('scrollProgress'); if(!bar) return; function up(){ const t=window.pageYOffset||document.documentElement.scrollTop; const d=document.documentElement.scrollHeight - window.innerHeight; bar.style.width=(d>0?(t/d)*100:0)+'%'; } up(); window.addEventListener('scroll', up, {passive:true}); window.addEventListener('resize', up); })();
    </script>
</body>
</html>
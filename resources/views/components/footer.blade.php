<!-- Footer-->
<footer class="footer bg-light py-5">
    <style>
        .footer-quick-link:hover {
            color: #6EB744 !important;
            text-decoration: underline !important;
            transition: all 0.3s ease;
        }
        /* Inner-page footer enhancements */
        .footer .contact-section .contact-content { max-width: 460px; }
        .footer .contact-section .contact-content .btn-success { width: 100% !important; }
        .footer .contact-section .contact-content .social-media-icons { margin-top: 1rem !important; }
        @media (max-width: 991px) { .footer .contact-section .contact-content { max-width: 420px; } }
        @media (max-width: 767px) { .footer .contact-section .contact-content { max-width: 360px; } }
        @media (max-width: 575px) { .footer .contact-section .contact-content { max-width: 320px; } }
        
        /* More specific selector */
        footer .quick-links .footer-quick-link:hover {
            color: #6EB744 !important;
            text-decoration: underline !important;
            transition: all 0.3s ease;
        }
        
        /* Even more specific */
        footer .quick-links ul li a.footer-quick-link:hover {
            color: #6EB744 !important;
            text-decoration: underline !important;
            transition: all 0.3s ease;
        }
        
        /* Footer Social Media container — Centered row, wraps on very small screens */
        footer .social-media-icons {
            display: flex !important;
            flex-wrap: wrap;
            justify-content: center !important;
            align-items: center;
            gap: 10px 10px;
            margin-top: 0.75rem;
            padding: 0.25rem 0;
            width: 100%;
        }

        /* Footer Social Media Icons Styling — Match homepage */
        footer .social-media-icons .social-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            background: rgba(110, 183, 68, 0.1);
            border: 2px solid rgba(110, 183, 68, 0.3);
            border-radius: 50%;
            color: #6EB744 !important;
            font-size: 1.2rem;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(110, 183, 68, 0.1);
            position: relative;
            overflow: hidden;
            margin: 0 5px;
            margin-bottom: 10px;


        }
        
        /* Unified Contact Section container so button and icons share width */
        .footer .contact-section {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .footer .contact-section .contact-content {
            width: 100%;
            max-width: 520px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .footer .contact-section .contact-content .btn-success {
            width: 100% !important;
            max-width: 100% !important;
            min-width: 0 !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }
        .footer .contact-section .contact-content .social-media-icons {
            width: 100% !important;
            max-width: 100% !important;
            justify-content: center !important;
        }
        @media (min-width: 768px) {
            .footer .contact-section .contact-content { max-width: 560px; }
        }
        @media (min-width: 1200px) {
            .footer .contact-section .contact-content { max-width: 640px; }
        }
        
        footer .social-media-icons .social-icon:hover {
            background: #6EB744 !important;
            border-color: #6EB744 !important;
            color: white !important;
            transform: translateY(-2px) scale(1.1);
            box-shadow: 0 4px 15px rgba(110, 183, 68, 0.3);
            text-decoration: none;
        }
        
        /* Ensure Font Awesome Icons are visible */
        footer .social-media-icons .social-icon i {
            display: block;
            font-style: normal;
            font-variant: normal;
            text-rendering: auto;
            line-height: 45px;
            font-size: 18px;
            color: #6EB744 !important;
            width: 100%;
            height: 100%;
            text-align: center;
            transition: all 0.3s ease;
        }
        footer .social-media-icons .social-icon:hover i {
            color: #ffffff !important;
        }
        
        /* Footer logo hover effect */
        .footer-logo:hover {
            transform: scale(1.05);
        }
        
        /* WhatsApp Button - enhanced sizing and responsiveness */
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
        
        /* Tablet */
        @media (min-width: 768px) {
            .footer .btn-success {
                max-width: 460px !important;
                padding: 0.9rem 1.75rem !important;
            }
        }
        /* Desktop */
        @media (min-width: 1200px) {
            .footer .btn-success {
                width: auto !important;
                min-width: 280px !important;
                margin: 0.5rem auto 1rem !important;
            }
        }

        /* Responsive Design for Footer */
        
        /* Desktop (1024px and above) - Single horizontal row with 3 sections side-by-side */
        @media (min-width: 1024px) {
            .footer .row {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                width: 100%;
            }
            
            .footer .company-info {
                flex: 1;
                text-align: left;
                padding-right: 2rem;
            }
            
            .footer .quick-links {
                flex: 1;
                text-align: center;
                padding: 0 1rem;
            }
            
            .footer .contact-section {
                flex: 1;
                padding-left: 2rem;
            }
            
            .footer .company-info p {
                max-width: 100%;

            }
            /* Ensure social icons stay on one line on desktop */
            .footer .social-media-icons {
                flex-wrap: nowrap;
            }
        }
        
        /* Tablet (768px - 1023px) - Keep horizontal row layout with adjusted spacing */
        @media (min-width: 768px) and (max-width: 1023px) {
            .footer {
                padding: 2.5rem 0 !important;
            }
            
            .footer .container {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }
            
            .footer .row {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                width: 100%;
            }
            
            .footer .company-info {
                flex: 1;
                text-align: left;
                padding-right: 1.5rem;
            }
            
            .footer .quick-links {
                flex: 1;
                text-align: center;
                padding: 0 0.75rem;
            }
            
            .footer .contact-section {
                flex: 1;
                padding-left: 1.5rem;
            }
            
            .footer .company-info p {
                max-width: 100%;
                font-size: 0.95rem;
            }
            
            .footer .footer-logo {
                height: 70px !important;
            }
            /* Keep social icons in one row on tablets when space allows */
            .footer .social-media-icons {
                flex-wrap: nowrap;
            }
        }
        
        /* Mobile Override - Force center alignment for all screen sizes below 768px */
        @media (max-width: 767px) {
            .footer .company-info,
            .footer .quick-links,
            .footer .contact-section {
                text-align: center !important;
            }
            
            .footer .company-info p {
                text-align: center !important;
            }
        }
        
        /* Mobile (below 768px) - Stack sections vertically */
        @media (max-width: 767px) {
            .footer {
                padding: 2rem 0 !important;
            }
            
            .footer .container {
                padding-left: 0.5rem;
                padding-right: 0.5rem;
                max-width: 600px;
                margin: 0 auto;
            }
            
            .footer .row {
                display: block;
                width: 100%;
            }
            
            .footer .company-info,
            .footer .quick-links,
            .footer .contact-section {
                width: 100%;
                margin-bottom: 2.5rem;
                text-align: center !important;
                padding: 0;
            }
            
            .footer .company-info {
                margin-bottom: 2.5rem;
            }
            
            .footer .company-info p {
                max-width: none !important;
                width: 100%;
                text-align: center !important;
                padding: 0 0.25rem;
                line-height: 1.7;
                margin: 0 auto;
                font-size: 1rem;
            }
            
            .footer .quick-links {
                margin-bottom: 2.5rem;
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
            
            .footer .contact-section {
                margin-bottom: 1.5rem;
            }
            /* Unified contact container to constrain width of button and icons */
            .footer .contact-section {
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            .footer .contact-section .contact-content {
                width: 100%;
                max-width: 420px;
                margin: 0 auto;
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            .footer .contact-section .contact-content .btn-success {
                width: 100% !important;
                max-width: 100% !important;
                min-width: 0 !important;
            }
            .footer .contact-section .contact-content .social-media-icons {
                width: 100% !important;
                max-width: 100% !important;
                justify-content: center !important;
                flex-wrap: wrap !important;
            }
            
            .footer .footer-logo {
                height: 60px !important;
                width: auto !important;
                margin: 0 auto !important;
                display: block !important;
            }
            
            .footer .social-media-icons {
                display: flex !important;
                flex-wrap: wrap;
                justify-content: center !important;
                align-items: center;
                gap: 8px 8px;
                max-width: none;
                margin: 1rem auto 0 !important;
            }
            
            .footer .social-media-icons .social-icon {
                width: 40px;
                height: 40px;
                margin: 0;
            }
            
            .footer .social-media-icons .social-icon i {
                line-height: 40px;
                font-size: 16px;
            }
            
            .footer h6 {
                font-size: 1.1rem;
                margin-bottom: 1rem;
                text-align: center !important;
            }
            
            .footer .btn {
                width: 100% !important;
                max-width: 460px !important;
                min-width: 220px !important;
                padding: 0.85rem 1.5rem !important;
                margin: 0.75rem auto 1.25rem !important;
                display: inline-flex !important;
                white-space: nowrap !important;
                border-radius: 999px !important;
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
        
        /* Extra small screens (very small mobile) - below 576px */
        @media (max-width: 575px) {
            .footer .container {
                max-width: 500px;
            }
            
            .footer .company-info p {
                padding: 0 0.1rem;
                font-size: 0.95rem;
                line-height: 1.6;
            }
            
            .footer .social-media-icons {
                display: flex !important;
                flex-wrap: wrap;
                justify-content: center !important;
                align-items: center;
                gap: 6px 6px;
                max-width: none;
            }
            
            .footer .social-media-icons .social-icon {
                width: 35px;
                height: 35px;
            }
            
            .footer .social-media-icons .social-icon i {
                line-height: 35px;
                font-size: 14px;
            }
            
            .footer .footer-logo {
                height: 50px !important;
            }
        }
        
        /* RTL Support for responsive design */
        [dir="rtl"] .footer .social-media-icons {
            direction: rtl;
        }
        
        [lang="ar"] .footer .social-media-icons {
            justify-content: center;
        }
        
        /* Arabic specific responsive adjustments */
        [lang="ar"] .footer .company-info,
        [lang="ar"] .footer .quick-links,
        [lang="ar"] .footer .contact-section {
            text-align: center;
        }
        
        @media (max-width: 767px) {
            [lang="ar"] .footer .company-info,
            [lang="ar"] .footer .quick-links,
            [lang="ar"] .footer .contact-section {
                text-align: center;
            }
        }
        
        /* Final Mobile Override - Force specific footer elements to center */
        @media (max-width: 767px) {
            .footer .company-info {
                text-align: center !important;
                display: flex !important;
                flex-direction: column !important;
                align-items: center !important;
            }
            
            .footer .company-info p {
                text-align: center !important;
                max-width: 100% !important;
            }
            
            .footer .quick-links {
                text-align: center !important;
                display: flex !important;
                flex-direction: column !important;
                align-items: center !important;
            }
            
            .footer .quick-links .text-center {
                text-align: center !important;
                width: 100% !important;
            }
            
            .footer .quick-links .text-center ul {
                text-align: center !important;
                display: inline-block !important;
            }
            
            .footer .social-media-icons {
                display: flex !important;
                flex-wrap: wrap;
                justify-content: center !important;
                align-items: center !important;
                gap: 8px 8px;
                margin: 0 auto !important;
            }
        }
    </style>
    <div class="container px-4 px-lg-5">
        <div class="row">
            <!-- Company Info Section -->
            <div class="company-info">
                <div class="mb-3">
                    <a href="{{ route(app()->getLocale() . '.home') }}" class="text-decoration-none">
                        @php
                            $logoFile = App::getLocale() == 'ar' ? 'logo-arabic.png' : 'logo.png';
                            $logoPath = "assets/img/{$logoFile}";
                        @endphp
                        <img src="{{ asset($logoPath) }}?v={{ file_exists(public_path($logoPath)) ? filemtime(public_path($logoPath)) : time() }}" alt="{{ __('messages.company_name') }}" class="footer-logo" style="height: 80px; width: auto; transition: transform 0.3s ease;">
                    </a>
                </div>
                <p class="text-muted mb-0 company-desc">{{ __('messages.company_description') }}</p>
            </div>
            
            <!-- Quick Links Section -->
            <div class="quick-links">
                <div class="text-center w-100">
                    <h6 class="text-dark fw-bold mb-3">{{ __('messages.quick_links') }}</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route(app()->getLocale() . '.home') }}" class="text-muted text-decoration-none footer-quick-link">{{ __('messages.home') }}</a></li>
                        <li class="mb-2"><a href="{{ route(app()->getLocale() . '.projects.index') }}" class="text-muted text-decoration-none footer-quick-link">{{ __('messages.projects') }}</a></li>
                        <li class="mb-2"><a href="{{ route(app()->getLocale() . '.training.index') }}" class="text-muted text-decoration-none footer-quick-link">{{ __('messages.training') }}</a></li>
                        <li class="mb-2"><a href="{{ route(app()->getLocale() . '.team.index') }}" class="text-muted text-decoration-none footer-quick-link">{{ __('messages.our_team') }}</a></li>
                        <li class="mb-2"><a href="{{ route(app()->getLocale() . '.contact.index') }}" class="text-muted text-decoration-none footer-quick-link">{{ __('messages.contact_us') }}</a></li>
                    </ul>
                </div>
            </div>
            
            <!-- Contact Section -->
            <div class="contact-section">
                <h6 class="text-dark fw-bold mb-3">{{ __('messages.contact_us') }}</h6>
                <div class="contact-content">
                    <a href="https://wa.me/{{ \App\Models\AppSetting::first()->whatsapp_phone ?? '1234567890' }}" 
                       target="_blank" 
                       class="btn btn-success d-flex align-items-center justify-content-center mb-3">
                        <i class="fab fa-whatsapp me-2"></i>
                        {{ __('messages.whatsapp_contact') }}
                    </a>
                    
                    <!-- Social Media Icons - Using FontAwesome Icons (Hero Section Style) -->
                    <div class="social-media-icons">
                    @if(\App\Models\HeroSection::getActive() && \App\Models\HeroSection::getActive()->linkedin_url)
                    <a href="{{ \App\Models\HeroSection::getActive()->linkedin_url }}" target="_blank" class="social-icon" title="LinkedIn">
                        <i class="fab fa-linkedin"></i>
                    </a>
                    @endif
                    @if(\App\Models\HeroSection::getActive() && \App\Models\HeroSection::getActive()->twitter_url)
                    <a href="{{ \App\Models\HeroSection::getActive()->twitter_url }}" target="_blank" class="social-icon" title="X (Twitter)">
                        <i class="fab fa-x-twitter"></i>
                    </a>
                    @endif
                    @if(\App\Models\HeroSection::getActive() && \App\Models\HeroSection::getActive()->facebook_url)
                    <a href="{{ \App\Models\HeroSection::getActive()->facebook_url }}" target="_blank" class="social-icon" title="Facebook">
                        <i class="fab fa-facebook"></i>
                    </a>
                    @endif
                    @if(\App\Models\HeroSection::getActive() && \App\Models\HeroSection::getActive()->instagram_url)
                    <a href="{{ \App\Models\HeroSection::getActive()->instagram_url }}" target="_blank" class="social-icon" title="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    @endif
                    @if(\App\Models\HeroSection::getActive() && \App\Models\HeroSection::getActive()->snapchat_url)
                    <a href="{{ \App\Models\HeroSection::getActive()->snapchat_url }}" target="_blank" class="social-icon" title="Snapchat">
                        <i class="fab fa-snapchat-ghost"></i>
                    </a>
                    @endif
                    @if(\App\Models\HeroSection::getActive() && \App\Models\HeroSection::getActive()->tiktok_url)
                    <a href="{{ \App\Models\HeroSection::getActive()->tiktok_url }}" target="_blank" class="social-icon" title="TikTok">
                        <i class="fab fa-tiktok"></i>
                    </a>
                    @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Copyright Section -->
        <hr class="my-4">
        <div class="row">
            <div class="col-12 text-center">
                <span class="text-muted small">{{ __('messages.copyright') }} &copy; {{ date('Y') }} - {{ __('messages.company_name') }}</span>
            </div>
        </div>
    </div>
</footer>

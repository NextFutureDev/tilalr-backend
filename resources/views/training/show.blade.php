@extends('layouts.app')

@section('title', $training->name)

@section('content')
<div class="container py-5" style="max-width: 900px;" lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" data-aos="fade-up">
    <h1 class="mb-4" style="font-size:2.5rem;font-weight:600;color:#6EB744;text-align:center;" data-aos="fade-up" data-aos-delay="100">{{ app()->getLocale() == 'ar' ? $training->name_ar : $training->name }}</h1>
    
    @if($training->image)
    <div class="text-center mb-4" data-aos="fade-up" data-aos-delay="120">
        <img src="{{ $training->image_url }}" alt="{{ app()->getLocale() == 'ar' ? $training->name_ar : $training->name }}" class="img-fluid rounded" style="max-height: 400px; width: 100%; object-fit: cover;">
    </div>
    @endif
    
    <div style="font-size:1.2rem;line-height:1.8;color:#444;text-align:{{ app()->getLocale() == 'ar' ? 'right' : 'left' }};max-width:100%;direction:{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }};" data-aos="fade-up" data-aos-delay="150">
        {!! app()->getLocale() == 'ar' ? $training->description_ar : $training->description !!}
    </div>
    
    <div class="text-center mt-5" data-aos="zoom-in" data-aos-delay="200">
        <a href="https://wa.me/{{ config('app.whatsapp_number', '1234567890') }}?text={{ urlencode(__('messages.training_interest_message', ['training' => app()->getLocale() == 'ar' ? $training->name_ar : $training->name])) }}" 
           class="whatsapp-contact-link" 
           target="_blank">
            <i class="bi bi-whatsapp"></i>
            {{ __('messages.contact_us') }} @if(app()->getLocale() == 'en')→@else←@endif
        </a>
    </div>
    
    <div class="text-center mt-4" data-aos="fade-up" data-aos-delay="230">
        <a href="{{ route(app()->getLocale() . '.training.index') }}" class="back-to-training-btn">{{ __('messages.back_to_training') }}</a>
    </div>
</div>

<style>
/* RTL Support for Training Page */
[dir="rtl"] .container {
    text-align: right;
}

[dir="rtl"] h1 {
    text-align: center !important;
}

[dir="rtl"] .btn {
    text-align: center;
}

/* Ensure proper RTL text flow */
[dir="rtl"] div[style*="text-align:right"] {
    direction: rtl;
    text-align: right;
}

/* Fix button positioning in RTL */
[dir="rtl"] .text-center {
    text-align: center !important;
}

/* WhatsApp Contact Link Styling */
.whatsapp-contact-link {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 15px 35px;
    background: linear-gradient(135deg, #25D366, #128C7E);
    color: white;
    text-decoration: none;
    border-radius: 30px;
    font-size: 1.1rem;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(37, 211, 102, 0.2);
    border: none;
}

.whatsapp-contact-link:hover {
    background: linear-gradient(135deg, #128C7E, #25D366);
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(37, 211, 102, 0.4);
    color: white;
    text-decoration: none;
}

.whatsapp-contact-link i {
    font-size: 1.3rem;
}

/* Back to Training Button Styling */
.back-to-training-btn {
    display: inline-block;
    padding: 12px 30px;
    background: linear-gradient(135deg, #6EB744, #5aa43a);
    color: white;
    text-decoration: none;
    border-radius: 25px;
    font-size: 1rem;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 3px 12px rgba(110, 183, 68, 0.2);
    border: none;
}

.back-to-training-btn:hover {
    background: linear-gradient(135deg, #5aa43a, #4a8c2e);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(110, 183, 68, 0.3);
    color: white;
    text-decoration: none;
}

/* Image responsive styling */
.img-fluid {
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.1);
}
</style>
@endsection

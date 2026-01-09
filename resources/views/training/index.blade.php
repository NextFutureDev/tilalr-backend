@extends('layouts.app')

@section('title', __('messages.our_training', [], 'en'))

@section('content')
<style>
    /* Training Card Styling */
    .training-feature-card {
        width: 100%;
        background: #fff;
        border-radius: 12px;
        padding: 30px 20px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between;
        height: 380px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        border: 1px solid #f0f0f0;
    }
    
    .training-feature-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        border-color: #e0e0e0;
    }

    .training-feature-icon {
        font-size: 3rem;
        color: #2d7ef7;
        margin-bottom: 20px;
        display: flex; 
        align-items: center; 
        justify-content: center;
        height: 70px;
        width: 70px;
        border-radius: 50%;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .training-feature-icon img {
        height: 45px;
        width: auto;
    }
    
    .training-feature-title {
        font-size: 1.4rem;
        font-weight: 700;
        letter-spacing: .02em;
        margin: 0 0 15px 0;
        color: #2c3e50;
        line-height: 1.3;
    }
    
    .training-feature-text {
        color: #6c757d;
        font-size: 15px;
        line-height: 1.6;
        margin: 0 0 20px 0;
        flex-grow: 1;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .training-feature-link {
        color: #6EB744;
        text-decoration: none;
        font-weight: 600;
        font-size: 16px;
        transition: all 0.3s ease;
        position: relative;
        padding: 8px 0;
    }
    
    .training-feature-link:hover { 
        color: #5aa43a;
        text-decoration: none;
    }
    
    .training-feature-link::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: 0;
        @if(app()->getLocale() == 'ar')
            right: 0;
        @else
            left: 0;
        @endif
        background-color: #6EB744;
        transition: width 0.3s ease;
    }
    
    .training-feature-link:hover::after {
        width: 100%;
    }

    /* Empty state styling */
    .empty-state {
        padding: 3rem 1rem;
        background: #f8f9fa;
        border-radius: 1rem;
        border: 2px dashed #dee2e6;
    }

    .empty-state i {
        color: #6c757d;
        opacity: 0.6;
    }

    .empty-state h4 {
        color: #495057;
        font-weight: 500;
    }

    .empty-state p {
        color: #6c757d;
        font-size: 1.1rem;
        line-height: 1.6;
    }

    .empty-state .btn {
        padding: 0.75rem 2rem;
        font-weight: 500;
        border-radius: 0.5rem;
    }
</style>
<div class="container py-5" lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
    <div class="text-center mb-5" data-aos="fade-up">
        <h1 class="mb-3" style="font-size:2.25rem;font-weight:600;" data-aos="fade-up" data-aos-delay="100">{{ __('messages.our_training') }}</h1>
        <p class="text-muted" data-aos="fade-up" data-aos-delay="200">{{ __('messages.training_description') }}</p>
    </div>

    <div class="row g-4" lang="{{ app()->getLocale() }}">
        @if($trainings->count() > 0)
            @foreach($trainings as $training)
                <div class="col-lg-3 col-md-6 col-sm-12 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="{{ ($loop->index * 100) + 300 }}">
                    <div class="training-feature-card" style="width:100%">
                        <div class="training-feature-icon">
                            @if($training->icon)
                                <img src="{{ $training->icon_url }}" alt="icon" style="height:56px;width:auto;"/>
                            @else
                                <i class="bi bi-mortarboard"></i>
                            @endif
                        </div>
                        <h3 class="training-feature-title">{{ app()->getLocale() == 'ar' ? $training->name_ar : $training->name }}</h3>
                        <p class="training-feature-text">
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
                        <a href="{{ route(app()->getLocale() . '.training.show', ['slug' => $training->slug]) }}" class="training-feature-link">{{ __('messages.learn_more') }} @if(app()->getLocale() == 'en')→@else←@endif</a>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12 text-center">
                <div class="empty-state">
                    <i class="bi bi-mortarboard text-muted" style="font-size: 4rem; margin-bottom: 1rem;"></i>
                    <h4 class="text-muted mb-3">{{ __('messages.no_training_title') }}</h4>
                    <p class="text-muted mb-4">{{ __('messages.no_training_message') }}</p>
                    <a href="/{{ app()->getLocale() }}" class="btn btn-primary">{{ __('messages.back_to_home') }}</a>
                </div>
            </div>
        @endif
    </div>
    
    <!-- Back to Home Button -->
    <div class="text-center mt-5">
        <a href="/{{ app()->getLocale() }}" class="btn btn-primary btn-lg">
            <i class="bi bi-house-fill me-2"></i>{{ __('messages.back_to_home') }}
        </a>
    </div>
</div>
@endsection


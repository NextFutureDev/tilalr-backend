@extends('layouts.app')

@section('title', __('messages.portfolio', [], 'en'))

@section('content')
<section class="page-section bg-light" id="portfolio" style="padding-top: 2rem; padding-bottom: 2rem;">
    <div class="container px-4 px-lg-5">
        <div class="text-center">
            <h2 class="text-center mt-0">{{ __('messages.portfolio') }}</h2>
            <hr class="divider" />
            <p class="text-muted mb-5">{{ __('messages.browse_portfolio_items') }}</p>
        </div>
        <div class="row gx-4 gx-lg-5 justify-content-center align-items-stretch">
            @foreach($portfolios as $portfolio)
                <div class="col-lg-4 col-md-6 mb-4 d-flex align-items-stretch">
                    <div class="card shadow border-0 text-start w-100 portfolio-card" style="transition: box-shadow 0.2s; max-width: 400px; margin: 0 auto;">
                        <div class="portfolio-image-container">
                            @if($portfolio->image)
                                <img src="{{ asset('storage/' . $portfolio->image) }}" 
                                     class="portfolio-image" 
                                     alt="{{ $portfolio->name }}">
                            @else
                                <div class="portfolio-placeholder">
                                    <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                </div>
                            @endif
                        </div>
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <h5 class="card-title mb-2">{{ $portfolio->name }}</h5>
                                @if($portfolio->category)
                                    <div class="mb-2 text-primary small">
                                        <i class="bi bi-tag"></i> {{ $portfolio->category }}
                                    </div>
                                @endif
                            </div>
                            <div class="mt-auto">
                                <a href="{{ asset('storage/' . $portfolio->image) }}" 
                                   class="btn btn-outline-primary btn-sm" 
                                   target="_blank"
                                   title="View Full Image">
                                    <i class="bi bi-eye"></i> View Image
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4 d-flex justify-content-center">
            {{ $portfolios->links() }}
        </div>
    </div>
</section>

<style>
.portfolio-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.portfolio-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.portfolio-image-container {
    width: 300px;
    height: 200px;
    margin: 0 auto;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    border-radius: 0.375rem 0.375rem 0 0;
}

.portfolio-image {
    width: 300px;
    height: 200px;
    object-fit: cover;
    object-position: center;
    transition: transform 0.3s ease-in-out;
}

.portfolio-image:hover {
    transform: scale(1.05);
}

.portfolio-placeholder {
    width: 300px;
    height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    color: #6c757d;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .portfolio-image-container,
    .portfolio-image,
    .portfolio-placeholder {
        width: 100%;
        height: 180px;
    }
}

@media (max-width: 576px) {
    .portfolio-image-container,
    .portfolio-image,
    .portfolio-placeholder {
        width: 100%;
        height: 160px;
    }
}
</style>
@endsection 
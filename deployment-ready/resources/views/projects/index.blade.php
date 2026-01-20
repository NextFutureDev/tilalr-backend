@extends('layouts.app')

@section('title', __('messages.projects', [], 'en'))

@section('content')
<section class="page-section bg-light" id="projects" data-aos="zoom-in-right">
    <div class="container px-4 px-lg-5">
        <div class="text-center mb-5" data-aos="zoom-in-right" data-aos-delay="100">
            <h2 class="mb-2" style="font-size:2.5rem;font-weight:500;">{{ __('messages.our_projects') }}</h2>
            <div style="width:60px;height:4px;background:#6EB744;margin:0.5rem auto 1.5rem auto;border-radius:2px;"></div>
            <p class="text-muted" style="font-size:1.15rem;">{{ __('messages.explore_projects') }}</p>
        </div>
        <div class="row justify-content-center g-4">
            @if($projects->count() > 0)
                @foreach($projects as $project)
                    <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="zoom-in-right" data-aos-delay="{{ ($loop->index % 4) * 100 }}">
                        <div class="card shadow border-0 h-100 project-card-custom">
                            @if($project->image)
                                <img src="{{ asset('storage/' . $project->image) }}" class="card-img-top rounded-top project-image" alt="{{ $project->name }}">
                            @endif
                            <div class="card-body d-flex flex-column justify-content-between project-card-body">
                                <div>
                                    <h5 class="card-title mb-2 project-title">{{ $project->name }}</h5>
                                    @if($project->project_date)
                                        <div class="mb-2 small project-date">
                                            <i class="bi bi-calendar-event"></i>
                                            {{ \Carbon\Carbon::parse($project->project_date)->format('F j, Y') }}
                                        </div>
                                    @endif
                                    @php
                                        $desc = html_entity_decode($project->description, ENT_QUOTES | ENT_HTML5);
                                        $desc = strip_tags($desc);
                                    @endphp
                                    <p class="card-text text-muted mb-3 project-desc-truncate">{{ $desc }}</p>
                                </div>
                                <a href="{{ route(app()->getLocale() . '.projects.show', ['slug' => $project->slug]) }}" class="btn btn-readmore mt-auto">{{ __('messages.read_more') }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12 text-center">
                    <div class="empty-state">
                        <i class="bi bi-folder-x text-muted" style="font-size: 4rem; margin-bottom: 1rem;"></i>
                        <h4 class="text-muted mb-3">{{ __('messages.no_projects_title') }}</h4>
                        <p class="text-muted mb-4">{{ __('messages.no_projects_message') }}</p>
                        <a href="/{{ app()->getLocale() }}" class="btn btn-primary">{{ __('messages.back_to_home') }}</a>
                    </div>
                </div>
            @endif
        </div>
        <div class="mt-4 d-flex justify-content-center">
            {{ $projects->links() }}
        </div>
        
        <!-- Back to Home Button -->
        <div class="text-center mt-5">
            <a href="/{{ app()->getLocale() }}" class="btn btn-primary btn-lg">
                <i class="bi bi-house-fill me-2"></i>{{ __('messages.back_to_home') }}
            </a>
        </div>
    </div>
</section>
<style>
.project-card-custom { width: 370px; min-width: 300px; max-width: 370px; margin: 0 auto; border-radius: 1rem; overflow: hidden; }
.project-image { width: 100%; height: 220px; object-fit: cover; }
.project-card-body { padding: 1.5rem 1.25rem 1.25rem 1.25rem; }
.project-title { font-size: 1.25rem; font-weight: 600; color: #1f2937; }
.project-date { color: #6EB744; }
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
@endsection 
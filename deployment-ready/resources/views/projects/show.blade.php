@extends('layouts.app')

@section('title', $project->name)

@section('content')
<section class="page-section bg-light" id="project-details" data-aos="fade-up">
    <div class="container px-4 px-lg-5">
        <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="100">
            <div class="col-lg-8" data-aos="fade-up" data-aos-delay="150">
                <div class="card shadow border-0" style="border-radius: 1rem; overflow: hidden;" data-aos="zoom-in" data-aos-delay="200">
                    @if($project->image)
                        <img src="{{ asset('storage/' . $project->image) }}" class="card-img-top" style="width: 100%; max-height: 350px; object-fit: cover;" alt="{{ $project->name }}">
                    @endif
                    <div class="card-body" style="padding: 1.75rem 1.5rem;">
                        <h2 class="card-title mb-3" style="color:#1f2937; font-weight:700;">{{ $project->name }}</h2>
                        @if($project->project_date)
                            <div class="mb-3 small" style="color:#6EB744;">
                                <i class="bi bi-calendar-event"></i>
                                {{ \Carbon\Carbon::parse($project->project_date)->format('F j, Y') }}
                            </div>
                        @endif
                        @php
                            $desc = $project->description;
                            // Decode HTML entities so &nbsp; becomes a real space
                            $desc = html_entity_decode($desc, ENT_QUOTES | ENT_HTML5);
                            // Replace non‑breaking spaces with regular spaces
                            $desc = preg_replace('/\x{00A0}/u', ' ', $desc);
                            // Convert paragraph tags to newlines, then strip remaining tags
                            $desc = preg_replace('/<\s*\/\s*p\s*>/i', "\n", $desc);
                            $desc = preg_replace('/<\s*p[^>]*>/i', "\n", $desc);
                            $desc = strip_tags($desc);
                            // Normalize whitespace and trim
                            $desc = preg_replace('/\s+/', ' ', $desc);
                            $desc = trim($desc);
                        @endphp
                        <p class="card-text text-muted" style="line-height:1.7;">{!! nl2br(e($desc)) !!}</p>
                        <a href="{{ route(app()->getLocale() . '.projects.index') }}" class="btn mt-3" style="background:#6EB744;color:#fff;border:none;border-radius:0.5rem;padding:0.5rem 1.25rem;">{{ __('messages.back_to_projects') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection 
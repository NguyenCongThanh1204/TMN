@extends('layouts.app')

@section('content')
@push('preloads')
        <link rel="preload" as="image" href="{{ asset('images/ANH-WEB.webp') }}" fetchpriority="high">
    @endpush
    {{-- 1. HERO --}}
    @include('home.sections.hero')

{{-- 6. ABOUT --}}
    @include('home.sections.about')

{{-- 3. SERVICES --}}
    @include('home.sections.services')


        {{-- 4. PROJECTS --}}
    @include('home.sections.projects')
    
     {{-- 5. PROCESS --}}
    <!-- @include('home.sections.process') -->

    {{-- 2. STATS --}}
    <!-- @include('home.sections.stats') -->


   

    {{-- 8. TESTIMONIALS --}}
    @include('home.sections.testimonials')


 {{-- 7. NEWS --}}
    @include('home.sections.news')


@endsection
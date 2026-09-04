<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ $title ?? config('site.name') }}</title>
    <meta name="description" content="{{ $description ?? config('site.description') }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:title" content="{{ $title ?? config('site.name') }}">
    <meta property="og:description" content="{{ $description ?? config('site.description') }}">
    <meta property="og:type" content="website">
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
    <div class="min-h-screen">
        @include('components.navbar')
        <main>@yield('content')</main>
        @include('components.footer')
    </div>

    {{-- Gắn nút scroll to top tại đây --}}
    @include('components.scroll-to-top')

    @stack('scripts')
</body>
</html>
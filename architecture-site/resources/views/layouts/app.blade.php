<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ $title ?? config('site.name') }}</title>
    <meta name="description" content="{{ $description ?? config('site.description') }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">   
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:title" content="{{ $title ?? config('site.name') }}">
    <meta property="og:description" content="{{ $description ?? config('site.description') }}">
    <meta property="og:type" content="website">

    {{-- Thêm stack này để hỗ trợ đẩy thẻ preload ảnh LCP từ các view con --}}
    @stack('preloads')

    {{-- Plugin Alpine.js Collapse nạp trước khi Alpine khởi chạy --}}
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="antialiased font-sans text-slate-900 bg-white">

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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Cell-a')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/aboutus.css') }}">
    <link rel="stylesheet" href="{{ asset('css/beauty-community.css') }}">
    <link rel="stylesheet" href="{{ asset('css/loyalty.css') }}">
    <link rel="stylesheet" href="{{ asset('css/term-of-service.css') }}">
    <link rel="stylesheet" href="{{ asset('css/privacy-policy.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reseller-join-us.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reseller-official.css') }}">
</head>

<body>

    {{-- Navbar --}}
    @include('components.navbar')

    {{-- Main content --}}
    <main>
        @yield('content')
    </main>

    <!-- JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @include('components.footer')
</body>

</html>

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
    {{-- @vite(['resources/js/app.js']) --}}
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.9/dist/cdn.min.js"></script>
    
    @vite(['resources/css/app.css','resources/js/app.js'])


    @php
        $routeName = request()->path(); // contoh: 'dashboard', 'posts.edit'
    @endphp

    {{-- <link rel="stylesheet" href="{{ asset("css/{$routeName}.css") }}"> --}}


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

    {{-- <script type="module">
        console.log("runnn")
        import * as bootstrap from 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.esm.min.js';

        // Buat tersedia di script non-module

        
        console.log({ bootstrap })

        window.bootstrap = bootstrap;

        // (opsional) panggil kode inisialisasi langsung
        // contoh: const modal = new bootstrap.Modal(...);
    </script> --}}
    <script async src="https://cdn.jsdelivr.net/npm/es-module-shims@1/dist/es-module-shims.min.js" crossorigin="anonymous">
    </script>
    <script type="importmap">
    {
      "imports": {
        "@popperjs/core": "https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/esm/popper.min.js",
        "bootstrap": "https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.esm.min.js"
      }
    }
    </script>
    <script type="module">
        import * as bootstrap from 'bootstrap'

        //   new bootstrap.Popover(document.getElementById('popoverButton'))

        console.log("boot", bootstrap)
        window.bootstrap = bootstrap
    </script>
    {{-- Navbar --}}
    @include('components.navbar')

    {{-- Main content --}}
    <main>
        @yield('content')
    </main>

    <!-- JS Bootstrap -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}

    @include('components.footer')
</body>

</html>

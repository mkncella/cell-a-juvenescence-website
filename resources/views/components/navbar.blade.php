{{-- <nav class="navbar bg-white">
    <div class="container d-flex flex-column align-items-center py-3" style="max-width: 1440px; position: relative;">

        <!-- Ikon Profil di pojok kanan atas -->
        <div class="profile-wrapper">
            <a href="/login">
                <img src="/icons/login_icon.png" alt="Profile" class="profile-icon">
            </a>
        </div>

        <!-- Baris 1: Logo -->
        <div class="logo-wrapper">
            <a href="/">
                <img src="/icons/cella.png" alt="Cell-a Logo" class="logo-img">
            </a>
        </div>

        <!-- Baris 2: Menu -->
        <div class="menu-wrapper flex justify-center gap-2">
            <a href="/about-us">About Us</a>
            <a href="/essentials">Essentials</a>
            <div class="dropdown-programs">
                <span class="menu-link-programs">Our Programs</span>
                <div class="dropdown-programs-content">
                    <a href="/reseller-cell-a">Reseller</a>
                    <a href="#">Affiliate</a>
                </div>
            </div>
            <a href="/beauty-community">Beauty Community</a>
            <a href="/loyalty">Loyalty</a>
            <a href="#">Beauty Journals</a>
        </div>

    </div>
</nav>

<script>
    window.onload = function() {
        const currentPath = window.location.pathname;
        document.querySelectorAll('.menu-wrapper a').forEach(link => {
            if (link.getAttribute('href') === currentPath) {
                link.classList.add('active');
            }
        });
    };
</script> --}}


<nav x-data="{ open: false }" class="bg-white shadow-md fixed top-0 left-0 right-0 z-[1001]">
    <div class=" max-w-screen-xl mx-auto px-4 py-3 flex items-center justify-between">
        <!-- Logo -->
        <a href="/">
            <img src="/icons/cella.png" alt="Cell-a Logo" class="w-[120px] h-auto object-contain" />
        </a>

        <!-- Hamburger (mobile) -->
        <button @@click="open = !open" class="sm:hidden text-gray-600 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- Menu Desktop -->
        <div class="hidden sm:flex items-center gap-4 text-sm font-medium">
            <x-nav-link href="/about-us" label="About Us" />
            <x-nav-link href="/essentials" label="Essentials" />
            <div class="relative group">
                <span class="cursor-pointer transition-all hover:text-blue-600">Our Programs</span>
                <div class="absolute hidden gap-2 group-hover:block bg-white shadow-md p-2 rounded-md z-50 min-w-[150px] text-left">
                    {{-- <a href="/reseller-cell-a" class="block px-4 py-2 text-sm hover:bg-gray-100">Reseller</a> --}}
                    {{-- <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-100">Affiliate</a> --}}
                    <x-nav-link href="/reseller-fix" label="Reseller" mobile />
                    <x-nav-link href="#" label="Our Programs" mobile />
                </div>
            </div>
            <x-nav-link href="/beauty-community" label="Beauty Community" />
            <x-nav-link href="/loyalty" label="Loyalty" />
            <x-nav-link href="#" label="Beauty Journals" />
        </div>

        <!-- Login -->
        <div class="hidden sm:block">
            <a href="/login">
                <img src="/icons/login_icon.png" alt="Login" class="w-6 h-6 hover:opacity-70" />
            </a>
        </div>
    </div>

    <!-- Menu Mobile -->
    <div x-show="open" x-transition class="sm:hidden px-4 pb-4 space-y-2">
        <x-nav-link href="/about-us" label="About Us" mobile />
        <x-nav-link href="/essentials" label="Essentials" mobile />
        <div class="space-y-1">
            <span class="font-medium text-gray-700">Our Programs</span>
            <a href="/reseller-cell-a" class="block text-sm pl-4 text-gray-600 hover:text-blue-500">Reseller</a>
            <a href="#" class="block text-sm pl-4 text-gray-600 hover:text-blue-500">Affiliate</a>
        </div>
        <x-nav-link href="/beauty-community" label="Beauty Community" mobile />
        <x-nav-link href="/loyalty" label="Loyalty" mobile />
        <x-nav-link href="#" label="Beauty Journals" mobile />
        <div>
            <a href="/login">
                <img src="/icons/login_icon.png" alt="Login" class="w-6 h-6 hover:opacity-70" />
            </a>
        </div>
    </div>
</nav>

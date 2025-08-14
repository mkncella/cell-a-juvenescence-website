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


<nav x-show="false" x-data="{ isOpen: false }" class="bg-white shadow-md fixed top-0 left-0 right-0 z-[1001]">
    <div class=" max-w-screen-xl mx-auto px-4 py-3 flex items-center justify-between">
        <!-- Logo -->
        <a href="/">
            <img src="/icons/cella.png" alt="Cell-a Logo" class="w-[120px] h-auto object-contain" />
        </a>

        <!-- Hamburger (mobile) -->
        <button @@click="isOpen = !isOpen" class="sm:hidden text-gray-600 focus:outline-none">
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
                    {{-- <a href="/reseller-indonesia" class="block px-4 py-2 text-sm hover:bg-gray-100">Reseller</a> --}}
                    {{-- <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-100">Affiliate</a> --}}
                    <x-nav-link href="/indonesia-map" label="Reseller" />
                    <x-nav-link href="#" label="Our Programs" />
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
    <div x-show="isOpen" x-transition class="sm:hidden px-4 pb-4 space-y-2">
        <x-nav-link href="/about-us" label="About Us" mobile />
        <x-nav-link href="/essentials" label="Essentials" mobile />
        <div class="space-y-1">
            <span class="font-medium text-gray-700">Our Programs</span>
            <a href="/indonesia-map" class="block text-sm pl-4 text-gray-600 hover:text-blue-500">Reseller</a>
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


<nav x-show="false" x-ref="navbar" x-data="{ isOpen: false, offsetTop: 0 }" x-init="offsetTop = $refs.navbar.offsetHeight" class="fixed top-0 left-0 right-0 z-[1001] bg-white shadow-md px-4 py-3 flex items-center justify-between gap-4 sm:gap-8">

    {{-- logo app --}}
    <div class="logo-app">
        <a href="/">
            <img src="/icons/cella.png" alt="Cell-a Logo" class="w-[clamp(4rem,6vw,5rem)] object-center object-cover" />
        </a>
    </div>

    {{-- links - aside --}}
    <aside class="fixed sm:relative top-0 right-0 bottom-0 bg-white sm:bg-transparent flex sm:justify-center flex-col sm:flex-row items-start sm:items-center gap-2 transition-all duration-75 text-sm" :style="`top: ${ offsetTop }px;`" x-init="console.log('offsetTop:', offsetTop)">
        <a href="/about-us" class="!no-underline p-0.5 px-1 bg-gradient-to-r hover:bg-[#557fff] hover:!text-transparent bg-clip-text text-black">About Us</a>
        <a href="/essentials" class="!no-underline p-0.5 px-1 bg-gradient-to-r hover:bg-[#557fff] hover:!text-transparent bg-clip-text text-black">Essentials</a>
        <a href="/indonesia-map-2" class="!no-underline p-0.5 px-1 bg-gradient-to-r hover:bg-[#557fff] hover:!text-transparent bg-clip-text text-black">Become Our Partner</a>
        <a href="/about-us" class="!no-underline p-0.5 px-1 bg-gradient-to-r hover:bg-[#557fff] hover:!text-transparent bg-clip-text text-black">Beauty Community</a>
        <a href="/about-us" class="!no-underline p-0.5 px-1 bg-gradient-to-r hover:bg-[#557fff] hover:!text-transparent bg-clip-text text-black">Membership Loyalty</a>
        <a href="/about-us" class="!no-underline p-0.5 px-1 bg-gradient-to-r hover:bg-[#557fff] hover:!text-transparent bg-clip-text text-black">Beauty Journals</a>
    </aside>

    {{-- hamburger --}}
    <button @@click="isOpen = !isOpen" class="!self-end sm:hidden text-gray-600 focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>
    
</nav>


<nav x-data="{ 
    currentPath: window.location.pathname,
    isActive(href) {
        if (href === '/' && this.currentPath === '/') return true;
        if (href !== '/' && this.currentPath.startsWith(href)) return true;
        return false;
    }
}" class="bg-white border-gray-200 fixed top-0 left-0 w-[100dvw] z-[1005] py-2">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto px-4">
        <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="/icons/cella.png" alt="Cell-a Logo" class="w-[clamp(4rem,6vw,5rem)] object-center object-cover" />
        </a>

        <button data-collapse-toggle="navbar-multi-level" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200" aria-controls="navbar-multi-level" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
            </svg>
        </button>

        <div class="hidden w-full md:block md:w-auto" id="navbar-multi-level">
            <ul class="flex flex-col font-medium px-4 md:p-0 my-2 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white">
                <li>
                    <x-navbar-link href="/about-us">
                        About Us
                    </x-navbar-link>
                </li>
                {{-- <li>


                    <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar" 
                        data-dropdown-trigger="hover"
                        class="flex items-center justify-between w-full py-2 px-3 text-gray-900 hover:bg-gray-100 
                                md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:w-auto">
                        Dropdown
                        <x-icons.v></x-icons.v>
                    </button>
                
                    <!-- Dropdown menu -->
                    <div id="dropdownNavbar" 
                        class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44">
                        <ul class="py-2 text-sm text-gray-700 ">
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100">Dashboard</a>
                            </li>
                            <li aria-labelledby="dropdownNavbarLink">
                                <button id="doubleDropdownButton" data-dropdown-toggle="doubleDropdown" 
                                    data-dropdown-trigger="hover" 
                                    data-dropdown-placement="right-start"
                                    type="button"
                                    class="flex items-center justify-between w-full px-4 py-2 hover:bg-gray-100">
                                    Became Our Partner
                                    <svg class="w-2.5 h-2.5 ms-2.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="m1 1 4 4 4-4" />
                                    </svg>
                                </button>
                
                                <div id="doubleDropdown" 
                                    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44">
                                    <ul class="py-2 text-sm text-gray-700">
                                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Overview</a></li>
                                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">My downloads</a></li>
                                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Billing</a></li>
                                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Rewards</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100">Earnings</a>
                            </li>
                        </ul>
                    </div>


                </li> --}}
                <li class="inline-flex items-center">
                    <x-dropdown trigger="hover" contextId="BecameOurPartner" placement="bottom-start">
                        <x-slot:button x-bind:class="{ 'text-[#557fff]': isOpen }" class="!py-1 md:!p-0 md:!text-sm">
                            Became Our Partner
                            <x-icons.v></x-icons.v>
                        </x-slot:button>

                        <x-slot:dropdownMenu>
                            <ul class="text-sm text-gray-700 !pl-0">
                                <li>
                                    <x-dropdown trigger="hover" contextId="BecameOurPartner-reseller">
                                        <x-slot:button x-bind:class="{ 'text-[#557fff]': isOpen }">
                                            Reseller
                                            <x-icons.v></x-icons.v>
                                        </x-slot:button>

                                        <x-slot:dropdownMenu>
                                            <ul class="py-2 text-sm text-gray-700">
                                                <li>
                                                    <x-navbar-link href="/indonesia-map?official" >
                                                        Official
                                                    </x-navbar-link>
                                                </li>
                                                <li>
                                                    <x-navbar-link href="/indonesia-map?join-us">
                                                        Join Us
                                                    </x-navbar-link>
                                                </li>
                                            </ul>
                                        </x-slot:dropdownMenu>
                                    </x-dropdown>
                                </li>
                                <li>
                                    <x-dropdown trigger="hover">
                                        <x-slot:button x-bind:class="{ 'text-[#557fff]': isOpen }">
                                            Affiliate
                                            <x-icons.v/>
                                        </x-slot:button>

                                        <x-slot:dropdownMenu>
                                            <ul class="py-2 text-sm text-gray-700">
                                                <li>
                                                    <x-navbar-link href="#">
                                                        Join Us
                                                    </x-navbar-link>
                                                </li>
                                            </ul>
                                        </x-slot:dropdownMenu>
                                    </x-dropdown>
                                </li>
                            </ul>
                        </x-slot:dropdownMenu>
                    </x-dropdown>
                </li>
                <li>
                    <x-navbar-link href="/essentials">
                        Essentials
                    </x-navbar-link>
                </li>
                <li>
                    <x-navbar-link href="/indonesia-map-2">
                        Become Our Partne
                    </x-navbar-link>
                </li>
                <li>
                    <x-navbar-link href="/">
                        Beauty Community
                    </x-navbar-link>
                </li>
            </ul>
        </div>
    </div>
</nav>
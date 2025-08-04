@extends('layouts.app')

@section('title', 'Reseller Cell-a')

@section('content')

    <section class="reseller-tabs-section ">
        <div class="tab-wrapper !-mt-12">
            <div class="program-tabs">
                <button class="tab-button active" data-tab="join">Join Us</button>
                <button class="tab-button" data-tab="official">Official Reseller</button>
            </div>
        </div>


        <div class="tab-content" x-data="() => ({
            stores: @js($stores),
            markers: {},
            isRequestFocusMarker: false,
            selectedStoreId: 0,
            map: null,

            regions: {},
            provinces: [],
            cities: [],
            selectedProvince: null,
            selectedCity: null,

            get filteredCities() {
                const { selectedProvince, cities, regions, provinces } = this

                {{-- return cities --}}
                return !selectedProvince ? cities : regions[selectedProvince].cities
            },

            get filteredStore() {
                let _stores = this.stores

                const { selectedProvince, selectedCity } = this

                {{-- filter province --}}
                if (selectedProvince) {
                    _stores = _stores.filter(({ province }) => province == selectedProvince)
                }

                {{-- filter city --}}
                if (selectedCity) {
                    _stores = _stores.filter(({ city }) => city == selectedCity)
                }

                return _stores
            },

            init() {

                {{-- set regions(area) & provincies & cities --}}
                this.stores.forEach(({ province, city }) => {

                    if (!this.regions[province]) {
                        this.regions[province] = {
                            isSelected: false,
                            cities: [],
                            filterCities: {}
                        }
                    }

                    if (!this.regions[province].cities.includes(city)) {
                        this.regions[province].cities.push(city)
                        this.regions[province].filterCities[city] = false
                    }
                })

                this.provinces = [...new Set(Object.keys(this.regions))]
                this.cities = [...new Set(this.provinces.map((province) => this.regions[province].cities).flat())]
                
                {{-- init | create map --}}
                setTimeout(() => {
                    
                   
                }, 500)


            },
            focusMarker(id) {

            },
        })">
            <section class="tab-pane active" id="join">
                <section class="reseller-hero">
                    <img src="/images/joinus_reseller.jpg" alt="Hero Reseller" class="hero-img" />
                    <div class="reseller-content">
                        <p class="reseller-subtitle">BECOME OUR OFFICIAL PARTNER</p>
                        <h1 class="reseller-title">Join the Cell-a Reseller Program and Grow With Us</h1>
                        <p class="reseller-desc">
                            Share premium skincare solutions, promote our brand values, and<br />
                            represent Cella in your city.
                        </p>
                    </div>
                </section>

                <section class="benefit-section">
                    <h2 class="benefit-title">Benefit</h2>
                    <div class="benefit-list">
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <img src="/icons/resellerbenefit.svg" alt="Icon 1" />
                            </div>
                            <div class="benefit-text">
                                <h3>Lorem ipsum dolor sit amet consectetur.</h3>
                                <p>
                                    Lorem ipsum dolor sit amet consectetur. Ultrices dui ac et ornare dolor
                                    in faucibus aliquet feugiat. Cursus quis placerat integer hendrerit feugiat dolor.
                                </p>
                            </div>
                        </div>

                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <img src="/icons/resellerbenefit.svg" alt="Icon 2" />
                            </div>
                            <div class="benefit-text">
                                <h3>Lorem ipsum dolor sit amet consectetur.</h3>
                                <p>
                                    Lorem ipsum dolor sit amet consectetur. Ultrices dui ac et ornare dolor
                                    in faucibus aliquet feugiat. Cursus quis placerat integer hendrerit feugiat dolor.
                                </p>
                            </div>
                        </div>

                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <img src="/icons/resellerbenefit.svg" alt="Icon 3" />
                            </div>
                            <div class="benefit-text">
                                <h3>Lorem ipsum dolor sit amet consectetur.</h3>
                                <p>
                                    Lorem ipsum dolor sit amet consectetur. Ultrices dui ac et ornare dolor
                                    in faucibus aliquet feugiat. Cursus quis placerat integer hendrerit feugiat dolor.
                                </p>
                            </div>
                        </div>
                    </div>

                    <section class="reseller-steps">
                        <h2 class="reseller-steps-title">Step by Step Reseller</h2>
                        <div class="reseller-steps-container">
                            <!-- Gambar besar kiri -->
                            <div class="reseller-image">
                                <img src="images\gambar-step.jpg" alt="Reseller Illustration">
                            </div>

                            <!-- Timeline kanan -->
                            <div class="reseller-timeline">
                                <div class="step-box">
                                    <div class="step-card">
                                        <div class="step-icon"></div>
                                        <p class="step-text">Lorem ipsum sit amet consectetur elementum ?</p>
                                    </div>
                                    <div class="step-connector">
                                        <div class="dots-column">
                                            <div class="circle"></div>
                                            <div class="circle"></div>
                                            <div class="circle"></div>
                                            <div class="circle"></div>
                                            <div class="circle circle-large"></div> <!-- Lingkaran besar -->
                                            <div class="circle"></div>
                                            <div class="circle"></div>
                                            <div class="circle"></div>
                                            <div class="circle"></div>
                                        </div>
                                        <p class="connector-text">Lorem ipsum dolor sit amet consectetur. Pretium in
                                            volutpat aliquam nam penatibus odio auctor morbi nisi.</p>
                                    </div>

                                </div>

                                <!-- Step lainnya -->
                                <div class="step-card">
                                    <div class="step-icon"></div>
                                    <p class="step-text">Lorem ipsum sit amet consectetur elementum ?</p>
                                </div>
                                <div class="step-card">
                                    <div class="step-icon"></div>
                                    <p class="step-text">Lorem ipsum sit amet consectetur elementum ?</p>
                                </div>
                                <div class="step-card">
                                    <div class="step-icon"></div>
                                    <p class="step-text">Lorem ipsum sit amet consectetur elementum ?</p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="peluang-section">
                        <h2 class="peluang-heading">Peluang</h2>
                        <div class="peluang-container">

                            <div class="peluang-card">
                                <div class="peluang-icon-box">
                                    <img src="icons/icon-peluang.svg" alt="icon" class="peluang-icon">
                                </div>
                                <h3 class="peluang-title">Lorem ipsum dolor sit</h3>
                                <p class="peluang-text">
                                    Lorem ipsum dolor sit amet consectetur. In enim faucibus at
                                    varius tortor. Libero facilisis in ante quis id sed nullam cursus.
                                    Tempus feugiat nibh morbi dignissim dictum nam arcu nisl lobortis.
                                </p>
                            </div>

                            <div class="peluang-card">
                                <div class="peluang-icon-box">
                                    <img src="icons/icon-peluang.svg" alt="icon" class="peluang-icon">
                                </div>
                                <h3 class="peluang-title">Lorem ipsum dolor sit</h3>
                                <p class="peluang-text">
                                    Lorem ipsum dolor sit amet consectetur. In enim faucibus at
                                    varius tortor. Libero facilisis in ante quis id sed nullam cursus.
                                    Tempus feugiat nibh morbi dignissim dictum nam arcu nisl lobortis.
                                </p>
                            </div>

                            <div class="peluang-card">
                                <div class="peluang-icon-box">
                                    <img src="icons/icon-peluang.svg" alt="icon" class="peluang-icon">
                                </div>
                                <h3 class="peluang-title">Lorem ipsum dolor sit</h3>
                                <p class="peluang-text">
                                    Lorem ipsum dolor sit amet consectetur. In enim faucibus at
                                    varius tortor. Libero facilisis in ante quis id sed nullam cursus.
                                    Tempus feugiat nibh morbi dignissim dictum nam arcu nisl lobortis.
                                </p>
                            </div>

                            <div class="peluang-card">
                                <div class="peluang-icon-box">
                                    <img src="icons/icon-peluang.svg    " alt="icon" class="peluang-icon">
                                </div>
                                <h3 class="peluang-title">Lorem ipsum dolor sit</h3>
                                <p class="peluang-text">
                                    Lorem ipsum dolor sit amet consectetur. In enim faucibus at
                                    varius tortor. Libero facilisis in ante quis id sed nullam cursus.
                                    Tempus feugiat nibh morbi dignissim dictum nam arcu nisl lobortis.
                                </p>
                            </div>

                        </div>
                    </section>

                    <section class="bergabung-reseller-wrapper">

                        <img src="/images/bergabung_reseller.jpg" alt="Reseller Banner"
                            class="bergabung-reseller-background" />

                        <div class="bergabung-reseller-content">
                            <p class="bergabung-reseller-subtitle">Bergabung</p>
                            <h2 class="bergabung-reseller-title">Sebagai <span>Reseller</span></h2>
                            <p class="bergabung-reseller-description">
                                Lorem ipsum dolor sit amet consectetur. A diam non in congue vestibulum integer id
                                tristique. Natoque mauris aliquam sollicitudin penatibus sagittis tempus. Eu lacus nulla
                                pellentesque aliquam erat ut sed risus. Dis volutpat sed in vitae lobortis lacus felis. Eget
                                risus ultricies et ornare non condimentum lorem.
                            </p>
                            <div class="bergabung-reseller-buttons">
                                <a href="#" class="bergabung-reseller-btn">Gabung
                                    Reseller</a>
                                <a href="#" class="bergabung-reseller-btn bergabung-reseller-btn-wa">
                                    <img src="/icons/whatsapp.svg" alt="WhatsApp" class="icon-wa" />
                                    WhatsApp
                                </a>

                            </div>
                        </div>

                    </section>

                </section>

            </section>

            <section x-ref="officialReseller" class="tab-pane pt-16" id="official">
                <div id="map" 
                    x-data="() => ({
                        init() {
                            setTimeout(() => {

                                stores.forEach((loc, i) => {
                                    simplemaps_countrymap_mapdata.locations[i] = {
                                        name: loc.title, 
                                        lat: loc.lat, 
                                        lng: loc.lng, 
                                        description: loc.description || ''
                                    };
                                });
                                
                                simplemaps_countrymap.load();
                            }, 500)
                        }
                    })"
                    class="w-full h-96">
                </div>



                <!-- 1. PETA -->

                <!-- 2. DROPDOWN -->
                <div class="flex flex-wrap gap-4 md:gap-8">
                    <div x-data="{
                        isOpen: false,
                    }" class="relative w-64 pl-6 pt-8">
                        <!-- Button Trigger -->
                        <button @@click="isOpen = !isOpen"
                            class="w-full bg-white border border-gray-300 rounded-md shadow-sm px-4 py-2 text-left text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 flex justify-between items-center">
                            <span x-text="selectedProvince ?? 'Pilih Provinsi'"></span>
                            <svg class="w-4 h-4 transform transition-transform duration-200"
                                x-bind:class="{ 'rotate-180': isOpen }" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
    
                        <!-- Dropdown Menu -->
                        <ul x-show="isOpen" @click.outside="isOpen = false" x-transition
                            class="absolute z-10 mt-1 !pl-0 w-full bg-white border border-gray-300 rounded-md shadow-md max-h-60 overflow-y-auto">
                            <li>
                                <button @@click="(selectedProvince = null ,isOpen = false)"
                                    class="block w-full text-left px-4 py-2 text-sm hover:bg-blue-100"
                                >Pilih Semua</button>
                            </li>
                            <template x-for="province in provinces" x-bind:key="province">
                                <li>
                                    <button @@click="(selectedProvince = province, isOpen = false)"
                                            class="block w-full text-left px-4 py-2 text-sm hover:bg-blue-100"
                                            x-text="province"></button>
                                </li>
                            </template>
                        </ul>
                    </div>
                    
                    <div x-data="{
                        isOpen: false,
                    }" class="relative w-64 pl-6 pt-8">
                        <!-- Button Trigger -->
                        <button @@click="isOpen = !isOpen"
                            class="w-full bg-white border border-gray-300 rounded-md shadow-sm px-4 py-2 text-left text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 flex justify-between items-center">
                            <span x-text="selectedCity ?? 'Pilih Kota'"></span>
                            <svg class="w-4 h-4 transform transition-transform duration-200"
                                x-bind:class="{ 'rotate-180': isOpen }" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
    
                        <!-- Dropdown Menu -->
                        <ul x-show="isOpen" @click.outside="isOpen = false" x-transition
                            class="absolute z-10 !pl-0 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-md max-h-60 overflow-y-auto">
                            <li>
                                <button @@click="(selectedCity = null ,isOpen = false)"
                                    class="block w-full text-left px-4 py-2 text-sm hover:bg-blue-100"
                                >Pilih Semua</button>
                            </li>
                            <template x-for="city in filteredCities" x-bind:key="city">
                                <li>
                                    <button @@click="(selectedCity = city, isOpen = false)"
                                            class="block w-full text-left px-4 py-2 text-sm hover:bg-blue-100"
                                            x-text="city"></button>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>


                {{-- <div class="dropdown premium-dropdown">
                    <button class="btn btn-premium dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Pilih Provinsi
                        <span class="arrow"></span>
                    </button>
                    <ul class="dropdown-menu scrollable-dropdown">
                        <li><a class="dropdown-item filter-province" data-id="">Semua Provinsi</a></li>
                        @foreach ($provinces as $province)
                            <li>
                                <a class="dropdown-item filter-province" data-id="{{ $province->id }}">
                                    {{ $province->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                </div> --}}



                <!-- 3. DAFTAR TOKO -->
                <div class="store-grid" id="storeContainer">
                    <template x-for="(store, index) in filteredStore" x-bind:key="store.id + '' + index">
                        <div class="store-card" x-show="selectedStoreId ? selectedStoreId == store.id : true">
                            <h3 @@click="focusMarker(store.id)" class="cursor-pointer"><i class="bi bi-shop"></i> <span x-text="store.title"></span></h3>
                            <p><i class="bi bi-geo-alt"></i> <span x-text="store.address"></span></p>
                            <p><i class="bi bi-pin-map"></i>
                                <a x-bind:href="store.link" x-text="store.link" target="_blank"></a>
                            </p>
                            {{-- <p><i class="bi bi-telephone"></i>
                                <a href="tel:{{ $reseller->no_hp }}">{{ $reseller->no_hp }}</a>
                            </p> --}}
                            {{-- @if ($reseller->shopee)
                                <p><i class="bi bi-bag"></i> {{ $reseller->shopee }}</p>
                            @endif --}}
                            {{-- @if ($reseller->tiktok)
                                <p><i class="bi bi-shop-window"></i> {{ $reseller->tiktok }}</p>
                            @endif --}}
                        </div>
                    </template>
                </div>
            </section>
        </div>

    </section>

    @push("script")
        {{-- <script defer src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script> --}}
        <script defer src="{{ asset('html5countrymapv4.5/mapdata.js') }}"></script>
        <script defer src="{{ asset('html5countrymapv4.5/countrymap.js') }}"></script>
    @endpush
    @push("link")
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    @endpush

    @push("bottom-script")
    @endpush

    <script>
        const buttons = document.querySelectorAll('.tab-button');
        const panes = document.querySelectorAll('.tab-pane');

        function setActiveTab(tabId) {
            buttons.forEach(btn => {
                btn.classList.toggle('active', btn.getAttribute('data-tab') === tabId);
            });

            panes.forEach(pane => {
                pane.classList.toggle('active', pane.id === tabId);
            });
        }

        // Ambil query string dari URL
        function getQueryParam(param) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }

        document.addEventListener('DOMContentLoaded', () => {
            // Prioritaskan tab dari URL, jika tidak ada ambil dari localStorage, default ke 'join'
            const tabFromUrl = getQueryParam('tab');
            const savedTab = tabFromUrl || localStorage.getItem('activeTab') || 'join';

            setActiveTab(savedTab);
            localStorage.setItem('activeTab', savedTab); // pastikan tetap tersimpan
        });

        buttons.forEach(button => {
            button.addEventListener('click', () => {
                const tab = button.getAttribute('data-tab');
                localStorage.setItem('activeTab', tab);
                setActiveTab(tab);
            });
        });
    </script>
    <script>
        const dropdown = document.getElementById('provinsiDropdown');

        dropdown?.addEventListener('change', function() {
            const selectedProvince = this.value;
            if (selectedProvince) {
                window.location.href = `?province_id=${selectedProvince}`;
            }
        });
    </script>
    <script>
        document.querySelectorAll('.filter-province').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();

                const provinceId = this.getAttribute('data-id');

                fetch(`{{ route('reseller') }}?province_id=${provinceId}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('storeContainer').innerHTML = data.resellers;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
    </script>







@endsection

@extends('layouts.app')

@section('title', 'Reseller Cell-a')

@section('content')

    <section class="reseller-tabs-section">
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
                setTimeout(async () => {

                    let { stores, markers, isRequestFocusMarker, map } = this

                    this.map = L.map('map').setView(
                        {{-- [-2.4289, 108.0149], 5 --}}
                        [-2.5, 118.0], 4
                    );

                    {{-- close popup while zoom. beause the popup position gonna be broken --}}
                    let popupCloseTimeout = null

                    this.map.on('zoom', () => {
                        if (popupCloseTimeout) return // masih tunggu timeout sebelumnya

                        popupCloseTimeout = setTimeout(() => {
                            this.map.closePopup()
                            console.log('closed popup due to zoom')

                            popupCloseTimeout = null // reset
                        }, 100) // delay 100ms agar tidak spam
                    })

                    stores.forEach((store, i) => {

                        const { id, lat, lng, zoom, title, description, address, province, city } = store

                        const marker = L.marker([lat, lng], {
                            title, riseOnHover: true, draggable: false,
                        }).bindPopup(`
                            <h5 class='font-bold text-blue-200'>${ title }</h5>
                            <p>${ description }</p>
                            <p>${ address }</p>
                        `).addTo(this.map);

                        marker.on('popupopen', async e => {
                            if (this.isRequestFocusMarker) return this.isRequestFocusMarker = false

                            
                            {{-- in case where the filter province is selected for other province. samething for the city --}}
                            let { selectedProvince, selectedCity } = this

                            {{-- both of them --}}
                            if (selectedProvince && selectedProvince != province && selectedCity && selectedCity != city) {

                                console.log('Province and city are not selected!')
                                
                                const { isConfirmed } = await Swal.fire({ icon: 'info', title: 'Notifikasi', html: `Provinsi dan Kota yang dipilih adalah <bold class='font-bold'>${ selectedProvince } -> ${ selectedCity }</bold>. <br>klik 'Pilih ulang provinsi dan kota' untuk set ke <bold class='font-bold'>${ province }</bold> -> <bold class='font-bold'>${ city }</bold> guna menampilkan toko.`, showCancelButton: true, confirmButtonText: 'Pilih ulang provinsi dan kota', cancelButtonText: 'Batal' })
                                
                                if (!isConfirmed) return
    
                                this.selectedProvince = province
                                this.selectedCity = city

                            } else {
                                if (selectedProvince && selectedProvince != province) {
                                    console.log('Province are not selected!')
                                    
                                    const { isConfirmed } = await Swal.fire({ icon: 'info', title: 'Notifikasi', html: `Provinsi yang dipilih adalah <bold class='font-bold'>${ selectedProvince }</bold>. <br>klik 'Pilih ulang provinsi' untuk set ke <bold class='font-bold'>${ province }</bold> guna menampilkan toko.`, showCancelButton: true, confirmButtonText: 'Pilih ulang provinsi', cancelButtonText: 'Batal' })
                                    
                                    if (!isConfirmed) return
    
                                    this.selectedProvince = province
                                }
                                
                                if (selectedCity && selectedCity != city) {
                                    console.log('City are not selected!')
    
                                    const { isConfirmed } = await Swal.fire({ icon: 'info', title: 'Notifikasi', html: `Kota yang dipilih adalah <bold class='font-bold'>${ selectedCity }</bold>. <br>klik 'Pilih ulang kota' untuk set ke <bold class='font-bold'>${ city }</bold> guna menampilkan toko.`, showCancelButton: true, confirmButtonText: 'Pilih ulang kota', cancelButtonText: 'Batal' })
    
                                    if (!isConfirmed) return
    
                                    this.selectedCity = city
                                }
                            }
                            

                            this.selectedStoreId = id
                        })

                        marker.on('popupclose', () => {
                            // delete selectedStoreId
                            this.selectedStoreId = 0
                        })
                        markers[id] = marker
                    })

                    {{-- GEOJSON --}}
                    const response = await fetch('/maps/indonesia-province-simple.json');
                    const data = await response.json();

                    const geoJsonLayer = L.geoJSON(data, {
                        style: {
                            color: '#2563eb',         // Border: biru gelap
                            weight: 1,
                            fillColor: '#93c5fd',     // Default: biru muda
                            fillOpacity: 0.4,
                        },
                        onEachFeature: (feature, layer) => {
                            const name = feature.properties?.Propinsi || 'Tidak diketahui';

                            layer.bindPopup(`<strong>${name}</strong>`);
                        }
                    }).addTo(this.map);

                    // Buat FeatureCollection dari semua marker
                    const markerPoints = turf.featureCollection(
                        Object.values(markers).map(({ _latlng: { lat, lng } }) =>
                            turf.point([lng, lat])
                        )
                    );

                    // Loop setiap polygon
                    geoJsonLayer.eachLayer((layer) => {
                        const feature = layer.feature;

                        if (!feature || !feature.geometry || !['Polygon', 'MultiPolygon'].includes(feature.geometry.type)) {
                            return;
                        }

                        const polygon = turf.feature(feature.geometry);
                        const matched = turf.pointsWithinPolygon(markerPoints, polygon);
                        const hasMarkerInside = matched.features.length > 0;

                        const baseColor = hasMarkerInside ? '#3b82f6' : '#93c5fd'; // biru tua : biru muda
                        layer.options.originalColor = baseColor; // Simpan warna dasar

                        layer.setStyle({
                            fillColor: baseColor,
                            fillOpacity: 0.6,
                            color: '#2563eb',
                            weight: 1
                        });

                        // Hover effect (hanya 1 kali disini!)
                        layer.on('mouseover', function () {
                            this.setStyle({
                                fillColor: '#1d4ed8', // biru lebih gelap saat hover
                            });
                        });

                        layer.on('mouseout', function () {
                            this.setStyle({
                                fillColor: this.options.originalColor, // kembalikan ke warna dasar
                            });
                        });

                        // Supaya popup ikut layer saat digeser
                        layer.on('click', function () {
                            this.openPopup();
                        });
                    });

                }, 500)


            },
            focusMarker(id) {
                this.isRequestFocusMarker = true

                console.log('clicked title')
                
                const marker = this.markers[id]
                
                if (!marker) return console.log(id, this.markers)
                console.log('clicked title...')

                window.scrollTo({ top: 0, behavior: 'smooth' })

                setTimeout(() => {

                    let { lat, lng } = marker.getLatLng()

                    const zoom = this.map.getZoom()
                    lat += (Math.pow(2, (10 - zoom)) * 0.15)
                    
                    this.map.flyTo({ lat, lng }, zoom, {
                        animated: true,
                        duration: 1.2
                    })

                    this.map.once('moveend', () => {
                        setTimeout(() => {
                            marker.openPopup()
                        }, 50)
                    })

                }, 500)

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

            <section x-ref="officialReseller" class="tab-pane pt-8" id="official">
                <div class="px-[max(1.5%,1rem)]">
                    <div x-ref="map" id="map" class="h-96 w-full !scroll-mt-24 bg-gradient-to-b from-white to-blue-100"></div>
                </div>


                <!-- 1. PETA -->

                <!-- 2. DROPDOWN -->
                <div class="flex flex-wrap gap-4 md:gap-y-8 px-4 mt-6">
                    <div x-data="{
                        isOpen: false,
                    }" class="relative w-64">
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
                    }" class="relative w-64">
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
        <script defer src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@turf/turf@6/turf.min.js"></script>
    @endpush
    @push("link")
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
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

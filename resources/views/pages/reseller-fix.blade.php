@extends('layouts.app')

@section('title', 'Reseller Cell-a')

@section('content')

    <section class="reseller-tabs-section">
        <div class="tab-wrapper">
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

                    let { stores, markers, isRequestFocusMarker, map } = this

                    this.map = L.map('map', {
                        center: [-2.4289, 108.0149],
                        zoom: 5,
                        {{-- maxBounds: [
                            [-11, 94],
                            [7, 142]
                        ],
                        maxBoundsViscosity: 1.0  --}}
                    })//.setView([-2.4289, 108.0149], 5);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href=\'https://www.openstreetmap.org/copyright\'>OpenStreetMap</a> contributors'
                    }).addTo(this.map);

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
                                
                                const { isConfirmed } = await Swal.fire({ icon: 'info', title: 'Notifikasi', html: `Provinsi dan Kota yang dipilih adalah <bold>${ selectedProvince } -> ${ selectedCity }</bold>. <br>klik 'Pilih ulang provinsi dan kota' untuk set ke ${ province } -> ${ city } guna menampilkan toko.`, showCancelButton: true, confirmButtonText: 'Pilih ulang provinsi dan kota', cancelButtonText: 'Batal' })
                                
                                if (!isConfirmed) return
    
                                this.selectedProvince = province
                                this.selectedCity = city

                            } else {
                                if (selectedProvince && selectedProvince != province) {
                                    console.log('Province are not selected!')
                                    
                                    const { isConfirmed } = await Swal.fire({ icon: 'info', title: 'Notifikasi', html: `Provinsi yang dipilih adalah <bold>${ selectedProvince }</bold>. <br>klik 'Pilih ulang provinsi' untuk set ke ${ province } guna menampilkan toko.`, showCancelButton: true, confirmButtonText: 'Pilih ulang provinsi', cancelButtonText: 'Batal' })
                                    
                                    if (!isConfirmed) return
    
                                    this.selectedProvince = province
                                }
                                
                                if (selectedCity && selectedCity != city) {
                                    console.log('City are not selected!')
    
                                    const { isConfirmed } = await Swal.fire({ icon: 'info', title: 'Notifikasi', html: `Kota yang dipilih adalah <bold>${ selectedCity }</bold>. <br>klik 'Pilih ulang kota' untuk set ke ${ city } guna menampilkan toko.`, showCancelButton: true, confirmButtonText: 'Pilih ulang kota', cancelButtonText: 'Batal' })
    
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


                    const { bootstrap } = window
    
                    {{-- document.querySelectorAll('.dropdown-toggle').forEach((el) => {
                        new bootstrap.Dropdown(el);
                        console.log('jalo', { bootstrap })
                    }); --}}
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

                    lat += 0.004
                    
                    this.map.flyTo({ lat, lng }, 15, {
                        animated: true,
                        duration: 1.2
                    })
                    marker.openPopup()
                }, 1000)

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

            <section x-ref="officialReseller" class="tab-pane pt-24" id="official">
                <div class="px-[max(3%,1rem)]">
                    <div x-ref="map" id="map" class="h-88 w-full !scroll-mt-24"></div>
                </div>


                <!-- 1. PETA -->
                {{-- <section id="map-section">
                    <img src="/images/map-indonesia.svg" class="map-indonesia" alt="Peta Indonesia" class="map-image" />

                    <!-- Pin contoh -->
                    <img src="/icons/pin-provinsi.svg" class="pin" data-provinsi="aceh"
                        alt="Pin lokasi provinsi Aceh" style="top:32.5%; left:10.1%;" />
                    <img src="/icons/pin-provinsi.svg" class="pin" data-provinsi="sumatera-utara"
                        alt="Pin lokasi provinsi Sumatera Utara" style="top:40.3%; left:14.9%;" />
                    <img src="/icons/pin-provinsi.svg" class="pin" data-provinsi="sumatera-barat"
                        alt="Pin lokasi provinsi Sumatera Barat" style="top:53.5%; left:17.3%;" />
                    <img src="/icons/pin-provinsi.svg" class="pin" data-provinsi="riau"
                        alt="Pin lokasi provinsi Riau" style="top:48.2%; left:19.2%;" />
                    <img src="/icons/pin-provinsi.svg" class="pin" data-provinsi="kepulauan-riau"
                        alt="Pin lokasi provinsi Kepulauan Riau" style="top:47%; left:24.7%;" />
                    <img src="/icons/pin-provinsi.svg" class="pin" data-provinsi="jambi"
                        alt="Pin lokasi provinsi Jambi" style="top:56.5%; left:21.4%;" />
                    <img src="/icons/pin-provinsi.svg" class="pin" data-provinsi="bengkulu"
                        alt="Pin lokasi provinsi Bengkulu" style="top:61.4%; left:19.7%;" />
                    <img src="/icons/pin-provinsi.svg" class="pin" data-provinsi="sumatera-selatan"
                        alt="Pin lokasi provinsi Sumatera Selatan" style="top:62%; left:24.7%;" />
                    <img src="/icons/pin-provinsi.svg" class="pin" data-provinsi="bangka-belitung"
                        alt="Pin lokasi provinsi Bangka Belitung" style="top:58.1%; left:27.5%;" />
                    <img src="/icons/pin-provinsi.svg" class="pin" data-provinsi="lampung"
                        alt="Pin lokasi provinsi Lampung" style="top:69%; left:26%;" />
                    <img src="/icons/pin-provinsi.svg" class="pin" data-provinsi="banten"
                        alt="Pin lokasi provinsi Banten" style="top:74.4%; left: 27.6%;" />
                    <img src="/icons/pin-provinsi.svg" class="pin" data-provinsi="jakarta"
                        alt="Pin lokasi provinsi Jakarta" style="top: 72.9%; left: 29%;" />
                    <img src="/icons/pin-provinsi.svg" class="pin" data-provinsi="jawa-barat"
                        alt="Pin lokasi provinsi Jawa Barat" style="top:75.7%; left: 30.2%;" />
                    <img src="/icons/pin-provinsi.svg" class="pin" data-provinsi="jawa-tengah"
                        alt="Pin lokasi provinsi Jawa Tengah" style="top:76.2%; left:35.3%;" />
                    <img src="/icons/pin-provinsi.svg" class="pin" data-provinsi="diy"
                        alt="Pin lokasi provinsi DI Yogyakarta" style="top:79%; left:35.7%;" />
                    <img src="/icons/pin-provinsi.svg" class="pin" data-provinsi="jawa-timur"
                        alt="Pin lokasi provinsi Jawa Timur" style="top:77.7%; left:39.3%;" />
                    <img src="/icons/pin-provinsi.svg" class="pin" data-provinsi="bali"
                        alt="Pin lokasi provinsi Bali" style="top:80.7%; left:44.55%;" />
                    <img src="/icons/pin-provinsi.svg" class="pin" data-provinsi="ntb"
                        alt="Pin lokasi provinsi Nusa Tenggara Barat" style="top:81.1%; left:46.5%;" />
                    <img src="/icons/pin-provinsi.svg" class="pin" data-provinsi="ntt"
                        alt="Pin lokasi provinsi Nusa Tenggara Timur" style="top:86%; left:60.85%;" />
                    <img src="/icons/pin-provinsi.svg" class="pin" data-provinsi="kalimantan-barat"
                        alt="Pin lokasi provinsi Kalimantan Barat" style="top:50.6%; left:33.9%;" />
                    <img src="/icons/pin-provinsi.svg" class="pin" data-provinsi="kalimantan-tengah"
                        alt="Pin lokasi provinsi Kalimantan Tengah" style="top:58.6%; left:41.65%;" />
                    <img src="/icons/pin-provinsi.svg" class="pin" data-provinsi="kalimantan-selatan"
                        alt="Pin lokasi provinsi Kalimantan Selatan" style="top:62.3%; left:43.8%;" />
                    <img src="/icons/pin-provinsi.svg" class="pin" data-provinsi="kalimantan-timur"
                        alt="Pin lokasi provinsi Kalimantan Timur" style="top:51.5%; left:48.09%;" />
                    <img src="/icons/pin-provinsi.svg" class="pin" data-provinsi="kalimantan-utara"
                        alt="Pin lokasi provinsi Kalimantan Utara" style="top:40.3%; left:48.4%;" />
                    <img src="/icons/pin-provinsi.svg" class="pin" data-provinsi="sulawesi-utara"
                        alt="Pin lokasi provinsi Sulawesi Utara" style="top:45.4%; left:62.52%;" />
                    <img src="/icons/pin-provinsi.svg" class="pin" data-provinsi="gorontalo"
                        alt="Pin lokasi provinsi Gorontalo" style="top:48%; left:59%;" />
                    <img src="/icons/pin-provinsi.svg" class="pin" data-provinsi="sulawesi-tengah"
                        alt="Pin lokasi provinsi Sulawesi Tengah" style="top:53.7%; left:53.3%;" />
                    <img src="/icons/pin-provinsi.svg" class="pin" data-provinsi="sulawesi-barat"
                        alt="Pin lokasi provinsi Sulawesi Barat" style="top:59.5%; left:52%;" />
                    <img src="/icons/pin-provinsi.svg" class="pin" data-provinsi="sulawesi-selatan"
                        alt="Pin lokasi provinsi Sulawesi Selatan" style="top:68.5%; left:52.6%;" />
                    <img src="/icons/pin-provinsi.svg" class="pin" data-provinsi="sulawesi-tenggara"
                        alt="Pin lokasi provinsi Sulawesi Tenggara" style="top:64.7%; left:57.9%;" />
                    <img src="/icons/pin-provinsi.svg" class="pin" data-provinsi="maluku"
                        alt="Pin lokasi provinsi Maluku" style="top:61.5%; left:72.2%;" />
                    <img src="/icons/pin-provinsi.svg" class="pin" data-provinsi="maluku-utara"
                        alt="Pin lokasi provinsi Maluku Utara" style="top:47.8%; left:67.5%;" />
                    <img src="/icons/pin-provinsi.svg" class="pin" data-provinsi="papua"
                        alt="Pin lokasi provinsi Papua" style="top:59.8%; left:91.5%;" />
                    <img src="/icons/pin-provinsi.svg" class="pin" data-provinsi="papua-barat"
                        alt="Pin lokasi provinsi Papua Barat" style="top:53.6%; left:79.2%;" />
                    <img src="/icons/pin-provinsi.svg" class="pin" data-provinsi="papua-tengah"
                        alt="Pin lokasi provinsi Papua Tengah" style="top:62.15%; left:82.45%;" />
                    <img src="/icons/pin-provinsi.svg" class="pin" data-provinsi="papua-pegunungan"
                        alt="Pin lokasi provinsi Papua Pegunungan" style="top:64.2%; left:89.09%;" />
                    <img src="/icons/pin-provinsi.svg" class="pin" data-provinsi="papua-selatan"
                        alt="Pin lokasi provinsi Papua Selatan" style="top:80.5%; left:91.08%;" />
                    <img src="/icons/pin-provinsi.svg" class="pin" data-provinsi="papua-barat-daya"
                        alt="Pin lokasi provinsi Papua Barat Daya" style="top:53.8%; left:74.45%;" />

                </section> --}}

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
                                :class="{ 'rotate-180': isOpen }" fill="none" stroke="currentColor" stroke-width="2"
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
                                :class="{ 'rotate-180': isOpen }" fill="none" stroke="currentColor" stroke-width="2"
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
        <script defer src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    @endpush
    @push("link")
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    @endpush

    @push("bottom-script")
        <script defer>

            // window.markers = {}
            
            // setTimeout(() => {
            //     console.log(window.L)

            //     // Inisialisasi peta di tengah Indonesia
            //     var map = L?.map('map').setView([-2.4289, 108.0149], 5);

            //     window.map = map
    
            //     // Tambahkan tile layer dari OpenStreetMap
            //     L?.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            //         attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            //     }).addTo(map);

            //     map.on("click", e => {
            //         console.log("YOUR CLICKED:", e)
            //     })

            //     // const latlng = [
            //     //     [-6.245374173091761, 106.99056241157128]
            //     // ]

            //     const stores = @js($stores);

            //     console.log({ stores })

            //     const { markers } = window

                // stores.forEach((store, i) => {

                //     const { id, lat, lng, zoom, title, description, address } = store

                //     const marker = L.marker([lat, lng], {
                //         title, riseOnHover: true, draggable: false,
                //     }).bindPopup(`
                //         <h5 class="font-bold text-blue-200">${ title }</h5>
                //         <p>${ description }</p>
                //         <p>${ address }</p>
                //     `).addTo(map);

                //     marker.on("popupopen", e => {
                //         if (window.isRequestFocusMarker) return window.isRequestFocusMarker = false

                //         console.log("OPEN MANUAL", e)
                //         window.selectedStoreId = id
                //     })

                //     marker.on("popupclose", () => {
                //         // delete selectedStoreId
                //         window.selectedStoreId = 0
                //     })

                //     markers[id] = marker

            //         // marker.bindPopup("abvcd")
                    
            //         // marker
            //         // console.log({ marker })
            //         // if (i % 2) {
                        
            //         // } else {

            //         //     const popup = L.popup([lat, lng], {
            //         //         content: title
            //         //     }).addTo(map)
            //         // }
            //     })
    
            //     // Muat data toko dari API dan tambahkan pin
            //     // fetch('/api/stores')
            //     //     .then(response => response.json())
            //     //     .then(data => {
            //     //         data.forEach(store => {
            //     //             var marker = L.marker([store.latitude, store.longitude]).addTo(map);
            //     //             marker.bindPopup(`<b>${store.name}</b><br>${store.address}`);
            //     //         });
            //     //     });
            // }, 1000);
        </script>
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

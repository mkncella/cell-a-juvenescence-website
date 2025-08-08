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
            rewards: @js($rewards),
            markers: {},
            isRequestFocusMarker: false,
            selectedStoreId: 0,
            map: null,
            geoJsonLayer: null,

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

                    this.geoJsonLayer = geoJsonLayer;

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
                        
                        layer.isSelected = false

                        // Hover effect (hanya 1 kali disini!)
                        layer.on('mouseover', function () {
                            if (this.isSelected) return

                            this.setStyle({
                                fillColor: '#1d4ed8', // biru lebih gelap saat hover
                            });
                        });

                        layer.on('mouseout', function () {
                            if (this.isSelected) return

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
            highlightProvince(name) {
                // 1. Kembalikan warna provinsi sebelumnya
                this.resetProvinceHighlight()

                // 2. Cari layer dengan nama provinsi yang cocok
                let found = false;
                this.geoJsonLayer.eachLayer(layer => {
                    const layerName = layer.feature.properties?.Propinsi?.toUpperCase();
                    if (layerName === name.toUpperCase()) {
                        layer.isSelected = true
                        // Simpan referensinya
                        this.activeProvinceLayer = layer;
                        // Ubah warnanya
                        layer.setStyle({
                            fillColor: '#f59e0b', // misalnya warna orange
                            fillOpacity: 0.8
                        });
                        found = true;
                    }
                });

                if (!found) {
                    console.warn(`Provinsi '${name}' tidak ditemukan`);
                    this.activeProvinceLayer = null;
                }
            },
            resetProvinceHighlight() {
                if (this.activeProvinceLayer) {
                    this.activeProvinceLayer.setStyle({
                        fillColor: this.activeProvinceLayer.options.originalColor,
                        fillOpacity: 0.6
                    });
                    this.activeProvinceLayer.isSelected = false
                    this.activeProvinceLayer = null;
                }
            }
        })">
            <section class="tab-pane active" id="join">
                <section class="reseller-hero">
                    <img src="/images/joinus_reseller.jpg" alt="Hero Reseller" class="hero-img" />
                    <div class="reseller-content">
                        <p class="reseller-subtitle">BECOME OUR OFFICIAL PARTNER</p>
                        <h1 class="reseller-title">Join and Grow Together With Us</h1>
                        <p class="reseller-desc">
                            Share premium skincare solutions, promote our brand values, and<br />
                            represent Cell~a in your city.
                        </p>
                    </div>
                </section>

                <section x-show="false" class="benefit-section">
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

                <section x-show="true" class="py-12 px-4 sm:px-6 lg:px-12 bg-white">
                    <div class="max-w-7xl mx-auto text-center">
                        <h2 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-4">Benefits Bergabung sebagai Reseller</h2>
                        <p class="text-gray-600 text-base sm:text-lg mb-10">
                            Kami bantu kamu sukses jualan produk kecantikan tanpa ribet.
                        </p>

                        {{-- <div class="card-border relative p-[2px] rounded-2xl">
                            <div class="absolute inset-0 rounded-2xl animate-border z-0"></div>

                            <div class="relative z-10 bg-blue-50 rounded-[1rem] p-6 shadow-md hover:shadow-lg transition">
                                <div class="text-blue-600 text-4xl mb-4">💰</div>
                                <h3 class="text-xl font-semibold text-gray-800 mb-2">Harga Reseller yang Menguntungkan</h3>
                                <p class="text-gray-600 text-sm">
                                Nikmati potongan harga spesial dan margin tinggi dari setiap penjualan produk.
                                </p>
                            </div>
                        </div> --}}


                        <div class="gap-6 grid grid-cols-[repeat(auto-fit,minmax(18rem,21rem))] place-content-center">
                            <!-- Card 1 -->
                            {{-- <div class="bg-blue-50 rounded-2xl shadow-md p-6 hover:shadow-lg transition">
                                <div class="text-blue-600 text-4xl mb-4">
                                    💰
                                </div>
                                <h3 class="text-xl font-semibold text-gray-800 mb-2">Harga Reseller yang Menguntungkan</h3>
                                <p class="text-gray-600 text-sm">
                                    Nikmati potongan harga spesial dan margin tinggi dari setiap penjualan produk.
                                </p>
                            </div> --}}

                            <div class="card-border relative p-1 rounded-2xl">
                                <div class="absolute inset-0 rounded-2xl animate-border z-0"></div>

                                <div class="relative z-10  rounded-[1rem] p-6 shadow-md hover:shadow-lg transition">
                                    <div class="text-blue-600 text-4xl mb-4">💰</div>
                                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Harga Reseller yang Menguntungkan</h3>
                                    <p class="text-gray-600 text-sm">
                                    Nikmati potongan harga spesial dan margin tinggi dari setiap penjualan produk.
                                    </p>
                                </div>
                            </div>



                            <!-- Card 2 -->
                            <div class="conn-card-spin-1">
                                <div class="card-spin-1 bg-blue-50 rounded-2xl shadow-md p-6 hover:shadow-lg transition">
                                    <div class="text-blue-600 text-4xl mb-4">
                                        📦
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Bisa Jualan Tanpa Stok</h3>
                                    <p class="text-gray-600 text-sm">
                                        Langsung jual produk tanpa modal besar lewat sistem dropship kami.
                                    </p>
                                </div>
                            </div>

                            <!-- Card 3 -->
                            <div class="bg-blue-50 rounded-2xl shadow-md p-6 hover:shadow-lg transition">
                                <div class="text-blue-600 text-4xl mb-4">
                                    📢
                                </div>
                                <h3 class="text-xl font-semibold text-gray-800 mb-2">Dukungan Promosi Lengkap</h3>
                                <p class="text-gray-600 text-sm">
                                    Kami siapkan konten promosi, katalog, dan panduan jualan untuk bantu kamu berkembang.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                <section x-show="false" class="reward-section py-16 px-4 sm:px-6 lg:px-8 bg-blue-50" x-data="{ rewards: [
                    { title: 'Voucher Diskon Keren', detail: 'Belanja makin asyik—koinmu bisa ditukar jadi voucher diskon besar untuk semua produk.' },
                    { title: 'Gratisan Cantik', detail: 'Kumpulin poin, dapetin produk gratis atau sample limited-edition setiap bulannya.' },
                    { title: 'Jadi VIP Cell~a', detail: 'Raih status VIP, dapat pre-order duluan, undangan ke event, dan promo rahasia.' },
                ] }">
                    <div class="max-w-4xl mx-auto text-center mb-16">
                        <h2 class="text-3xl sm:text-4xl font-bold text-[#1A57DB]">Rewards Seru Buat Kamu!</h2>
                        <p class="mt-2 text-gray-600">Yuk lihat apa aja yang bisa kamu dapat kalau kamu join bareng Cell~a 💙</p>
                    </div>

                    <div class="space-y-12 relative max-w-3xl mx-auto">
                        <template x-for="(reward, index) in rewards" :key="index">
                            <div class="relative" x-data="{ open: false }">
                                <div
                                    class="cursor-pointer bg-white shadow-lg rounded-xl p-4 border-l-8 border-blue-600 hover:bg-blue-100 transition"
                                    @click="open = !open"
                                >
                                    <h3 class="text-xl font-semibold text-blue-800" x-text="reward.title"></h3>
                                </div>

                                <div
                                    x-show="open"
                                    x-transition
                                    class="mt-2 ml-6 p-4 bg-white shadow-md rounded-md text-gray-700 border border-blue-100"
                                >
                                    <p x-text="reward.detail"></p>
                                </div>

                                <!-- chain line -->
                                <div class="absolute left-3 top-full w-1 bg-blue-600 transition-all duration-300 origin-top"
                                    :style="open ? 'height: 60px' : 'height: 30px'">
                                </div>
                            </div>
                        </template>
                    </div>
                </section>

                <section x-show="true" class="reward-section py-16 px-4 mb-12 sm:px-6 lg:px-8 bg-blue-50 max-w-2xl mx-auto rounded-2xl shadow-lg p-6" x-data="{
                    {{-- rewards: [
                        { id: 1, title: 'Level 1 - Pemula Glow', requirement: 'Jual 10 produk', prize: 'Voucher Belanja 50k', icon: 'fa-solid fa-gift', bgColor: 'bg-pink-500' },
                        { id: 2, title: 'Level 2 - Rising Star', requirement: 'Jual 25 produk', prize: 'Skincare Premium', icon: 'fa-solid fa-star', bgColor: 'bg-yellow-500' },
                        { id: 3, title: 'Level 3 - Queen Glow', requirement: 'Jual 50 produk', prize: 'Hair Dryer Modern', icon: 'fa-solid fa-wind', bgColor: 'bg-purple-500' },
                        { id: 4, title: 'Level 4 - Glam Boss', requirement: 'Jual 80 produk', prize: 'Makeup Set Eksklusif', icon: 'fa-solid fa-magic', bgColor: 'bg-indigo-500' },
                        { id: 5, title: 'Level 5 - Diva', requirement: 'Jual 120 produk', prize: 'Smartwatch', icon: 'fa-solid fa-clock', bgColor: 'bg-green-500' },
                        { id: 6, title: 'Level 6 - Superstar', requirement: 'Jual 170 produk', prize: 'Smartphone', icon: 'fa-solid fa-mobile', bgColor: 'bg-blue-500' },
                        { id: 7, title: 'Level 7 - Royal Glow', requirement: 'Jual 230 produk', prize: 'Laptop', icon: 'fa-solid fa-laptop', bgColor: 'bg-red-500' },
                        { id: 8, title: 'Level 8 - Diamond Queen', requirement: 'Jual 300 produk', prize: 'Liburan Bali', icon: 'fa-solid fa-umbrella-beach', bgColor: 'bg-orange-500' },
                        { id: 9, title: 'Level 9 - Legend', requirement: 'Jual 500 produk', prize: 'Mobil', icon: 'fa-solid fa-car', bgColor: 'bg-teal-500' },
                    ], --}}
                    currentIndex: 0,
                    setIndex(i) { this.currentIndex = i },
                    next() { if (this.currentIndex < this.rewards.length - 1) this.currentIndex++ },
                    prev() { if (this.currentIndex > 0) this.currentIndex-- }
                }">
                    {{-- <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <template x-for="reward in rewards" x-bind:key="reward.level">
                            <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition flex flex-col">
                                <!-- Header -->
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center"
                                        :class="reward.bgColor">
                                        <i :class="reward.icon" class="text-white text-xl"></i>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-800" x-text="reward.title"></h3>
                                </div>

                                <!-- Requirement -->
                                <p class="text-gray-500 text-sm mb-2">
                                    Syarat: <span class="font-semibold" x-text="reward.requirement"></span>
                                </p>

                                <!-- Prize -->
                                <p class="text-gray-700 mb-4">
                                    Hadiah: <span class="font-semibold text-green-600" x-text="reward.prize"></span>
                                </p>

                                <!-- Action buttons -->
                                <div class="mt-auto flex gap-2">
                                    <button class="flex-1 bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600 transition">
                                        Ambil Reward
                                    </button>
                                    <button class="flex-1 border border-red-400 text-red-500 py-2 px-4 rounded-lg hover:bg-red-50 transition">
                                        Lewati
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div> --}}
                    <!-- Head: Level List -->
                    <div class="flex gap-3 overflow-x-auto pb-2 mb-4 scrollbar-hide">
                        <template x-for="(reward, i) in rewards" :key="reward.id">
                            <button 
                                class="flex-shrink-0 px-4 py-2 rounded-full border"
                                :class="currentIndex === i ? 'bg-pink-500 text-white border-pink-500' : 'bg-gray-100 text-gray-700 border-gray-300'"
                                @@click="setIndex(i)"
                                x-text="'Lv ' + reward.id"
                            ></button>
                        </template>
                    </div>

                    <!-- Body: Reward Detail -->
                    <div class="text-center">
                        <div class="flex justify-center mb-4">
                            <div class="w-16 h-16 flex items-center justify-center rounded-full text-white text-2xl"
                                :class="rewards[currentIndex].bgColor">
                                <i class="fa-solid fa-gift"></i>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2" x-text="rewards[currentIndex].title"></h3>
                        <p class="text-gray-500 mb-1">
                            Syarat: <span class="font-semibold" x-text="rewards[currentIndex].requirement"></span>
                        </p>
                        <p class="text-gray-700 mb-4">
                            Hadiah: <span class="font-semibold text-green-600" x-text="rewards[currentIndex].reward"></span>
                        </p>
                    </div>

                    <!-- Footer: Navigation Buttons -->
                    <div class="flex justify-between mt-6">
                        <button class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300" @@click="prev()">Prev</button>
                        <button class="px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600" @@click="next()">Next</button>
                    </div>

                </section>


                <section class="pt-12 px-4 sm:px-6 lg:px-12 bg-gradient-to-b bg-white" x-data="{
                    openStep: null, // hanya satu yang boleh open
                    steps: [
                        {
                            title: 'Isi Formulir Pendaftaran',
                            detail: 'Lengkapi data diri dan kontak kamu melalui form online yang kami sediakan.',
                        },
                        {
                            title: 'Tunggu Konfirmasi',
                            detail: 'Tim kami akan menghubungi kamu melalui WhatsApp atau email dalam 1x24 jam.',
                        },
                        {
                            title: 'Mulai Jualan Produk Cell~a',
                            detail: 'Setelah resmi bergabung, kamu akan mendapatkan akses katalog, harga reseller, dan materi promosi.',
                        },
                    ],
                }">
                    <div x-show="false" class="max-w-5xl mx-auto">
                        <h2 class="text-3xl sm:text-4xl font-bold text-[#1A57DB] text-center mb-16">Step by Step Reseller</h2>
                        
                        <div class="space-y-32 relative">
                            <template x-for="(step, index) in steps" :key="index">
                                <div class="relative">

                                    <!-- Box Title -->
                                    <div @click="openStep = openStep === index ? null : index" class="relative w-full sm:w-2/3 bg-white rounded-lg shadow-lg p-6 border-l-8 border-[#1A57DB] hover:bg-blue-50 transition cursor-pointer">
                                        <h3 class="font-bold text-xl text-[#1A57DB] mb-2" x-text="step.title"></h3>

                                        <!-- Chain: horizontal + vertical keluar dari kiri bawah -->
                                        <div class="absolute left-0 bottom-0 w-4 h-1 bg-[#1A57DB] z-10"></div>
                                        <div 
                                            class="absolute left-0 bottom-0 w-1 bg-[#1A57DB] z-10 origin-top transition-all duration-500 ease-in-out"
                                            :style="openStep === index ? 'height: 180px;' : 'height: 40px;'"
                                        ></div>
                                    </div>

                                    <!-- Detail di luar box, mengambang di gap -->
                                    <div x-show="openStep === index" x-transition
                                        class="absolute left-0 sm:left-1/3 w-full sm:w-2/3 bg-white rounded-md shadow p-1 border border-[#1A57DB] mt-4 z-20">
                                        <p class="text-gray-600 text-sm" x-text="step.detail"></p>
                                    </div>

                                </div>
                            </template>
                        </div>
                    </div>

                    <div x-show="true" class="ml-auto max-w-xl mt-8 flex flex-col gap-8 overflow-hidden">
                        <h2 class="text-3xl sm:text-4xl font-bold text-[#1A57DB] text-center mb-16">Step by Step Reseller</h2>

                        <div class="space-y-20 relative">
                            <template x-for="(step, index) in steps" x-bind:key="index">
                                <div class="relative" :id="`ell-${ index }`" x-transition x-data="{ isOpen: false }">
                                    <div class="absolute right-5 -bottom-[180%] sm:-bottom-[165%] origin-bottom bg-blue-700 transition-[height] duration-500 ease-in-out w-0.5" x-bind:style="!isOpen ? 'height: 0px' : 'height: 90px'"></div>
                                    
                                    <div @@click="isOpen = !isOpen" class="relative w-full flex items-center bg-[#F0F6FF] hover:bg-[#E1EDFF] rounded-lg shadow-lg border-l-8 border-blue-700  transition cursor-pointer p-2">
                                        <h4 class="font-semibold !text-sm sm:!text-lg px-6" x-text="step.title"></h4>
                                        
                                        <div class="absolute left-2 top-full origin-bottom bg-blue-700 transition-[height] duration-500 ease-in-out w-1" x-bind:style="!isOpen ? 'height: 0px' : 'height: 80px'"></div>
                                    </div>

                                    <p x-show="isOpen" x-text="step.detail" x-transition class="absolute px-12 py-2.5 text-sm"></p>
                                </div>
                            </template>
                            <div></div>
                        </div>
                    </div>
                    
                </section>
            </section>

            <section x-ref="officialReseller" class="tab-pane pt-8" id="official">

                <!-- 1. PETA -->
                <div class="px-[max(1.5%,1rem)]">
                    <div x-ref="map" id="map" class="h-96 w-full !scroll-mt-24 bg-gradient-to-b from-white to-blue-100"></div>
                </div>

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
                                <button @@click="(selectedProvince = null, isOpen = false, resetProvinceHighlight())"
                                    class="block w-full text-left px-4 py-2 text-sm hover:bg-blue-100"
                                >Pilih Semua</button>
                            </li>
                            <template x-for="province in provinces" x-bind:key="province">
                                <li>
                                    <button @@click="(selectedProvince = province, isOpen = false, highlightProvince(province))"
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
                            <p><i class="bi bi-geo-alt"></i>
                                <span x-text="store.address"></span>
                            </p>
                            <p x-show="store.link"><i class="bi bi-pin-map"></i>
                                <a x-bind:href="store.link" x-text="store.link" target="_blank"></a>
                            </p>
                            <p x-show="store.link_shopee">
                                <svg class="text-black aspect-square w-5" viewBox="0 0 192 192" xmlns="http://www.w3.org/2000/svg" fill="none"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path fill="currentColor" d="m29.004 157.064 5.987-.399-5.987.399ZM22 52v-6a6 6 0 0 0-5.987 6.4L22 52Zm140.996 105.064-5.987-.399 5.987.399ZM170 52l5.987.4A6 6 0 0 0 170 46v6ZM34.991 156.665 27.987 51.601l-11.974.798 7.005 105.064 11.973-.798Zm133.991.798 7.005-105.064-11.974-.798-7.004 105.064 11.973.798Zm-11.973-.798a10 10 0 0 1-9.978 9.335v12c11.582 0 21.181-8.98 21.951-20.537l-11.973-.798Zm-133.991.798C23.788 169.02 33.387 178 44.968 178v-12a10 10 0 0 1-9.977-9.335l-11.973.798ZM74 48c0-12.15 9.85-22 22-22V14c-18.778 0-34 15.222-34 34h12Zm22-22c12.15 0 22 9.85 22 22h12c0-18.778-15.222-34-34-34v12ZM22 58h148V46H22v12Zm22.969 120H147.03v-12H44.969v12Z"></path><path stroke="currentColor" stroke-linecap="round" stroke-width="12" d="M114 84H88c-7.732 0-14 6.268-14 14v0c0 7.732 6.268 14 14 14h4m-2 0h14c7.732 0 14 6.268 14 14v0c0 7.732-6.268 14-14 14H78"></path></g></svg>
                                <a x-bind:href="store.link_shopee" x-text="store.link_shopee" target="_blank"></a>
                            </p>
                            <p x-show="store.link_tiktok">
                                <svg class="aspect-square w-5" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M8.45095 19.7926C8.60723 18.4987 9.1379 17.7743 10.1379 17.0317C11.5688 16.0259 13.3561 16.5948 13.3561 16.5948V13.2197C13.7907 13.2085 14.2254 13.2343 14.6551 13.2966V17.6401C14.6551 17.6401 12.8683 17.0712 11.4375 18.0775C10.438 18.8196 9.90623 19.5446 9.7505 20.8385C9.74562 21.5411 9.87747 22.4595 10.4847 23.2536C10.3345 23.1766 10.1815 23.0889 10.0256 22.9905C8.68807 22.0923 8.44444 20.7449 8.45095 19.7926ZM22.0352 6.97898C21.0509 5.90039 20.6786 4.81139 20.5441 4.04639H21.7823C21.7823 4.04639 21.5354 6.05224 23.3347 8.02482L23.3597 8.05134C22.8747 7.7463 22.43 7.38624 22.0352 6.97898ZM28 10.0369V14.293C28 14.293 26.42 14.2312 25.2507 13.9337C23.6179 13.5176 22.5685 12.8795 22.5685 12.8795C22.5685 12.8795 21.8436 12.4245 21.785 12.3928V21.1817C21.785 21.6711 21.651 22.8932 21.2424 23.9125C20.709 25.246 19.8859 26.1212 19.7345 26.3001C19.7345 26.3001 18.7334 27.4832 16.9672 28.28C15.3752 28.9987 13.9774 28.9805 13.5596 28.9987C13.5596 28.9987 11.1434 29.0944 8.96915 27.6814C8.49898 27.3699 8.06011 27.0172 7.6582 26.6277L7.66906 26.6355C9.84383 28.0485 12.2595 27.9528 12.2595 27.9528C12.6779 27.9346 14.0756 27.9528 15.6671 27.2341C17.4317 26.4374 18.4344 25.2543 18.4344 25.2543C18.5842 25.0754 19.4111 24.2001 19.9423 22.8662C20.3498 21.8474 20.4849 20.6247 20.4849 20.1354V11.3475C20.5435 11.3797 21.2679 11.8347 21.2679 11.8347C21.2679 11.8347 22.3179 12.4734 23.9506 12.8889C25.1204 13.1864 26.7 13.2483 26.7 13.2483V9.91314C27.2404 10.0343 27.7011 10.0671 28 10.0369Z" fill="#EE1D52"></path> <path d="M26.7009 9.91314V13.2472C26.7009 13.2472 25.1213 13.1853 23.9515 12.8879C22.3188 12.4718 21.2688 11.8337 21.2688 11.8337C21.2688 11.8337 20.5444 11.3787 20.4858 11.3464V20.1364C20.4858 20.6258 20.3518 21.8484 19.9432 22.8672C19.4098 24.2012 18.5867 25.0764 18.4353 25.2553C18.4353 25.2553 17.4337 26.4384 15.668 27.2352C14.0765 27.9539 12.6788 27.9357 12.2604 27.9539C12.2604 27.9539 9.84473 28.0496 7.66995 26.6366L7.6591 26.6288C7.42949 26.4064 7.21336 26.1717 7.01177 25.9257C6.31777 25.0795 5.89237 24.0789 5.78547 23.7934C5.78529 23.7922 5.78529 23.791 5.78547 23.7898C5.61347 23.2937 5.25209 22.1022 5.30147 20.9482C5.38883 18.9122 6.10507 17.6625 6.29444 17.3494C6.79597 16.4957 7.44828 15.7318 8.22233 15.0919C8.90538 14.5396 9.6796 14.1002 10.5132 13.7917C11.4144 13.4295 12.3794 13.2353 13.3565 13.2197V16.5948C13.3565 16.5948 11.5691 16.028 10.1388 17.0317C9.13879 17.7743 8.60812 18.4987 8.45185 19.7926C8.44534 20.7449 8.68897 22.0923 10.0254 22.991C10.1813 23.0898 10.3343 23.1775 10.4845 23.2541C10.7179 23.5576 11.0021 23.8221 11.3255 24.0368C12.631 24.8632 13.7249 24.9209 15.1238 24.3842C16.0565 24.0254 16.7586 23.2167 17.0842 22.3206C17.2888 21.7611 17.2861 21.1978 17.2861 20.6154V4.04639H20.5417C20.6763 4.81139 21.0485 5.90039 22.0328 6.97898C22.4276 7.38624 22.8724 7.7463 23.3573 8.05134C23.5006 8.19955 24.2331 8.93231 25.1734 9.38216C25.6596 9.61469 26.1722 9.79285 26.7009 9.91314Z" fill="#000000"></path> <path d="M4.48926 22.7568V22.7594L4.57004 22.9784C4.56076 22.9529 4.53074 22.8754 4.48926 22.7568Z" fill="#69C9D0"></path> <path d="M10.5128 13.7916C9.67919 14.1002 8.90498 14.5396 8.22192 15.0918C7.44763 15.7332 6.79548 16.4987 6.29458 17.354C6.10521 17.6661 5.38897 18.9168 5.30161 20.9528C5.25223 22.1068 5.61361 23.2983 5.78561 23.7944C5.78543 23.7956 5.78543 23.7968 5.78561 23.798C5.89413 24.081 6.31791 25.0815 7.01191 25.9303C7.2135 26.1763 7.42963 26.4111 7.65924 26.6334C6.92357 26.1457 6.26746 25.5562 5.71236 24.8839C5.02433 24.0451 4.60001 23.0549 4.48932 22.7626C4.48919 22.7605 4.48919 22.7584 4.48932 22.7564V22.7527C4.31677 22.2571 3.95431 21.0651 4.00477 19.9096C4.09213 17.8736 4.80838 16.6239 4.99775 16.3108C5.4985 15.4553 6.15067 14.6898 6.92509 14.0486C7.608 13.4961 8.38225 13.0567 9.21598 12.7484C9.73602 12.5416 10.2778 12.3891 10.8319 12.2934C11.6669 12.1537 12.5198 12.1415 13.3588 12.2575V13.2196C12.3808 13.2349 11.4148 13.4291 10.5128 13.7916Z" fill="#69C9D0"></path> <path d="M20.5438 4.04635H17.2881V20.6159C17.2881 21.1983 17.2881 21.76 17.0863 22.3211C16.7575 23.2167 16.058 24.0253 15.1258 24.3842C13.7265 24.923 12.6326 24.8632 11.3276 24.0368C11.0036 23.823 10.7187 23.5594 10.4844 23.2567C11.5962 23.8251 12.5913 23.8152 13.8241 23.341C14.7558 22.9821 15.4563 22.1734 15.784 21.2774C15.9891 20.7178 15.9864 20.1546 15.9864 19.5726V3H20.4819C20.4819 3 20.4315 3.41188 20.5438 4.04635ZM26.7002 8.99104V9.9131C26.1725 9.79263 25.6609 9.61447 25.1755 9.38213C24.2352 8.93228 23.5026 8.19952 23.3594 8.0513C23.5256 8.1559 23.6981 8.25106 23.8759 8.33629C25.0192 8.88339 26.1451 9.04669 26.7002 8.99104Z" fill="#69C9D0"></path> </g></svg>
                                <a x-bind:href="store.link_tiktok" x-text="store.link_tiktok" target="_blank"></a>
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

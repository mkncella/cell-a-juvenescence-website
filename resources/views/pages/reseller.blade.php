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


        <div class="tab-content">
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

            <section class="tab-pane" id="official">
                <!-- 1. PETA -->
                <section id="map-section">
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

                </section>

                <!-- 2. DROPDOWN -->
                <div class="dropdown premium-dropdown">
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

                </div>



                <!-- 3. DAFTAR TOKO -->
                <div class="store-grid" id="storeContainer">
                    @foreach ($resellers as $reseller)
                        <div class="store-card">
                            <h3><i class="bi bi-shop"></i> {{ $reseller->nama_toko }}</h3>
                            <p><i class="bi bi-geo-alt"></i> {{ $reseller->alamat }}</p>
                            <p><i class="bi bi-telephone"></i>
                                <a href="tel:{{ $reseller->no_hp }}">{{ $reseller->no_hp }}</a>
                            </p>
                            @if ($reseller->shopee)
                                <p><i class="bi bi-bag"></i> {{ $reseller->shopee }}</p>
                            @endif
                            @if ($reseller->tiktok)
                                <p><i class="bi bi-shop-window"></i> {{ $reseller->tiktok }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>


            </section>
        </div>

    </section>

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

        dropdown.addEventListener('change', function() {
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

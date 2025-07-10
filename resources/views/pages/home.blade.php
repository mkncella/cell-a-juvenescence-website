@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <!-- Section luar carousel, biar bisa full-width -->
    <section class="carousel-section">
        <!-- Carousel utama -->
        <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000" data-bs-pause="false"
            data-bs-touch="true">

            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="/images/slide1.jpg" class="carousel-img" alt="Slide 1">
                </div>
                <div class="carousel-item">
                    <img src="/images/slide2.jpg" class="carousel-img" alt="Slide 2">
                </div>
                <div class="carousel-item">
                    <img src="/images/slide3.jpg" class="carousel-img" alt="Slide 3">
                </div>
            </div>

            <!-- Titik indikator -->
            <div class="carousel-indicators position-absolute bottom-0 mb-3">
                <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active"
                    aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
        </div>
    </section>

    <section class="features-section">
        <div class="features-container">
            <div class="feature-item">
                <img src="/icons/check-blue.svg" alt="check" class="check-icon">
                <span>Acne-prones skin safe</span>
            </div>
            <div class="feature-item">
                <img src="/icons/check-blue.svg" alt="check" class="check-icon">
                <span>BPOM Approved</span>
            </div>
            <div class="feature-item">
                <img src="/icons/check-blue.svg" alt="check" class="check-icon">
                <span>Innovative Formulations</span>
            </div>
            <div class="feature-item">
                <img src="/icons/check-blue.svg" alt="check" class="check-icon">
                <span>Advanced Technology</span>
            </div>
            <div class="feature-item">
                <img src="/icons/check-blue.svg" alt="check" class="check-icon">
                <span>Dermatology Tested</span>
            </div>
        </div>
    </section>

    <section class="ingredient-carousel-section">
        <div class="container">

            <!-- Judul -->
            <h2 class="text-center section-title">
                Cari Tahu <span class="highlight-text">Ingredient Produk</span>
            </h2>

            <!-- Navigation Tab -->
            <div class="ingredient-tabs text-center">
                <button class="tab-btn active" data-bs-target="#ingredientCarousel" data-bs-slide-to="0">Peptides</button>
                <button class="tab-btn" data-bs-target="#ingredientCarousel" data-bs-slide-to="1">Fulvic Acid</button>
                <button class="tab-btn" data-bs-target="#ingredientCarousel" data-bs-slide-to="2">Filmexel</button>
            </div>

            <!-- Carousel -->
            <div id="ingredientCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000"
                data-bs-pause="false">
                <button class="carousel-control-prev" type="button" data-bs-target="#ingredientCarousel"
                    data-bs-slide="prev">
                    <span class="carousel-prev-arrow" aria-hidden="true">❮</span>
                    <span class="visually-hidden">Previous</span>
                </button>

                <div class="carousel-inner">

                    <!-- Item 1 -->
                    <div class="carousel-item active">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-md-5 d-flex justify-content-center">
                                <img src="/images/peptides.jpg" alt="Peptides" class="carousel-img-ingredients">
                            </div>
                            <div class="col-md-4">
                                <h4 class="ingredient-title">Peptides</h4>
                                <div class="ingredient-description">
                                    <p>Lorem ipsum dolor sit amet consectetur. Condimentum sapien ipsum etiam pharetra nec
                                        in sit. Amet pulvinar ipsum a quis commodo purus interdum a sed. Diam sed tellus sed
                                        et elementum nec non venenatis. Ipsum lobortis odio mi sagittis...</p>
                                    <a href="#" class="read-more">Baca Selengkapnya ></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Item 2 -->
                    <div class="carousel-item">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-md-5 d-flex justify-content-center">
                                <img src="/images/fulvicacid.jpeg" alt="Fulvic Acid" class="carousel-img-ingredients">
                            </div>
                            <div class="col-md-4">
                                <h4 class="ingredient-title">Fulvic Acid</h4>
                                <div class="ingredient-description">
                                    <p>Lorem ipsum dolor sit amet consectetur. Condimentum sapien ipsum etiam pharetra nec
                                        in sit. Amet pulvinar ipsum a quis commodo purus interdum a sed. Diam sed tellus sed
                                        et elementum nec non venenatis. Ipsum lobortis odio mi sagittis...</p>
                                    <a href="#" class="read-more">Baca Selengkapnya ></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Item 3 -->
                    <div class="carousel-item">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-md-5 d-flex justify-content-center">
                                <img src="/images/filmexel.jpeg" alt="Filmexel" class="carousel-img-ingredients">
                            </div>
                            <div class="col-md-4">
                                <h4 class="ingredient-title">Filmexel</h4>
                                <div class="ingredient-description">
                                    <p>Lorem ipsum dolor sit amet consectetur. Condimentum sapien ipsum etiam pharetra nec
                                        in sit. Amet pulvinar ipsum a quis commodo purus interdum a sed. Diam sed tellus sed
                                        et elementum nec non venenatis. Ipsum lobortis odio mi sagittis...</p>
                                    <a href="#" class="read-more">Baca Selengkapnya ></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Panah Navigasi -->
                <button class="carousel-control-next" type="button" data-bs-target="#ingredientCarousel"
                    data-bs-slide="next">
                    <span class="carousel-next-arrow">❯</span>
                </button>
            </div>
        </div>
    </section>

    <section class="skin-concern-section">
        <div class="container">
            <!-- Judul -->
            <h2 class="skin-title">
                Skin <span class="skin-highlight">Concern</span>
            </h2>
            <p class="skin-description">
                Lorem ipsum dolor sit amet consectetur. Scelerisque porttitor lacus turpis?
            </p>

            <!-- Kartu Skin Concern -->
            <div class="skin-card-wrapper">
                <!-- Card 1 -->
                <div class="skin-card">
                    <div class="skin-image"></div>
                    <h4 class="skin-card-title">Kulit Berkomedo</h4>
                    <p class="skin-card-text">Bye komedo! Waktunya tampil dengan kulit mulus tanpa pori tersumbat!</p>
                    <a href="#" class="skin-link">Lihat Detail →</a>
                </div>

                <!-- Card 2 -->
                <div class="skin-card">
                    <div class="skin-image"></div>
                    <h4 class="skin-card-title">Kulit Berjerawat</h4>
                    <p class="skin-card-text">Coba ini dan rasakan perubahan! Jerawat pergi, percaya diri kembali!</p>
                    <a href="#" class="skin-link">Lihat Detail →</a>
                </div>

                <!-- Card 3 -->
                <div class="skin-card">
                    <div class="skin-image"></div>
                    <h4 class="skin-card-title">Kulit Kusam</h4>
                    <p class="skin-card-text">Rahasia kulit glowing tanpa kusam? Ini jawabannya!</p>
                    <a href="#" class="skin-link">Lihat Detail →</a>
                </div>

                <!-- Card 4 -->
                <div class="skin-card">
                    <div class="skin-image"></div>
                    <h4 class="skin-card-title">Kulit Sensitif</h4>
                    <p class="skin-card-text">Kulit mudah rewel? Pilih yang tepat & rasakan bedanya!</p>
                    <a href="#" class="skin-link">Lihat Detail →</a>
                </div>

                <!-- Card 5 -->
                <div class="skin-card">
                    <div class="skin-image"></div>
                    <h4 class="skin-card-title">Kulit Aging</h4>
                    <p class="skin-card-text">Jangan biarkan waktu mengalahkan kulitmu—ini solusinya!</p>
                    <a href="#" class="skin-link">Lihat Detail →</a>
                </div>
            </div>
        </div>
    </section>

    <section class="glow-container">
        <header class="glow-header">
            <h1 class="glow-title">
                Your <span class="glow-highlight">Glow</span>, Your <span class="glow-highlight">Story</span>
            </h1>
            <div class="glow-tabs">
                <img src="/images/after1.jpg" alt="Tab 1" class="glow-tab-img active">
                <img src="/images/after2.jpg" alt="Tab 2" class="glow-tab-img">
                <img src="/images/after3.jpg" alt="Tab 3" class="glow-tab-img">
            </div>
        </header>


        <div class="glow-carousel-wrapper">
            <button class="glow-control-prev" type="button">
                <span class="glow-arrow" aria-hidden="true">❮</span>
                <span class="visually-hidden">Previous</span>
            </button>
            <div class="glow-track">
                <main class="glow-main active">
                    <div class="glow-image-box">
                        <img src="/images/before1.jpg" alt="Before" class="glow-img">
                        <p class="glow-img-label">BEFORE</p>
                    </div>

                    <div class="glow-image-box">
                        <img src="/images/after1.jpg" alt="After" class="glow-img">
                        <p class="glow-img-label">AFTER</p>
                    </div>

                    <div class="glow-info-box">
                        <div>
                            <h2 class="glow-subtitle">Penggunaan Soft Peeling Gel</h2>
                            <p class="glow-text">
                                “Lorem ipsum dolor sit amet consectetur. Ipsum metus et vel est. Ac non massa viverra
                                tristique
                                lorem tincidunt in sed platea. Faucibus leo vitae fringilla risus. Ac massa tempor commodo
                                malesuada
                                egestas arcu eget.
                            </p>
                            <p class="glow-author">- Kim Kardashian, 23 Tahun</p>
                            <div class="glow-tags">
                                <span class="glow-tag">Anti-aging</span>
                                <span class="glow-tag">Bebas Komedo</span>
                                <span class="glow-tag">Glowing</span>
                                <span class="glow-tag">Bebas Jerawat</span>
                            </div>
                        </div>
                        <img src="/images/product1.png" alt="Product" class="glow-product">
                    </div>
                </main>

                <main class="glow-main">
                    <div class="glow-image-box">
                        <img src="/images/before2.jpg" alt="Before" class="glow-img">
                        <p class="glow-img-label">BEFORE</p>
                    </div>

                    <div class="glow-image-box">
                        <img src="/images/after2.jpg" alt="After" class="glow-img">
                        <p class="glow-img-label">AFTER</p>
                    </div>

                    <div class="glow-info-box">
                        <div>
                            <h2 class="glow-subtitle">Penggunaan Soft Peeling Gel</h2>
                            <p class="glow-text">
                                “Lorem ipsum dolor sit amet consectetur. Ipsum metus et vel est. Ac non massa viverra
                                tristique
                                lorem tincidunt in sed platea. Faucibus leo vitae fringilla risus. Ac massa tempor commodo
                                malesuada
                                egestas arcu eget.
                            </p>
                            <p class="glow-author">- Kim Kardashian, 23 Tahun</p>
                            <div class="glow-tags">
                                <span class="glow-tag">Anti-aging</span>
                                <span class="glow-tag">Bebas Komedo</span>
                                <span class="glow-tag">Glowing</span>
                                <span class="glow-tag">Bebas Jerawat</span>
                            </div>
                        </div>
                        <img src="/images/product2.png" alt="Product" class="glow-product">
                    </div>
                </main>

                <main class="glow-main">
                    <div class="glow-image-box">
                        <img src="/images/before3.jpg" alt="Before" class="glow-img">
                        <p class="glow-img-label">BEFORE</p>
                    </div>

                    <div class="glow-image-box">
                        <img src="/images/after3.jpg" alt="After" class="glow-img">
                        <p class="glow-img-label">AFTER</p>
                    </div>

                    <div class="glow-info-box">
                        <div>
                            <h2 class="glow-subtitle">Penggunaan Soft Peeling Gel</h2>
                            <p class="glow-text">
                                “Lorem ipsum dolor sit amet consectetur. Ipsum metus et vel est. Ac non massa viverra
                                tristique
                                lorem tincidunt in sed platea. Faucibus leo vitae fringilla risus. Ac massa tempor commodo
                                malesuada
                                egestas arcu eget.
                            </p>
                            <p class="glow-author">- Kim Kardashian, 23 Tahun</p>
                            <div class="glow-tags">
                                <span class="glow-tag">Anti-aging</span>
                                <span class="glow-tag">Bebas Komedo</span>
                                <span class="glow-tag">Glowing</span>
                                <span class="glow-tag">Bebas Jerawat</span>
                            </div>
                        </div>
                        <img src="/images/product3.png" alt="Product" class="glow-product">
                    </div>
                </main>
            </div>
            <button class="glow-control-next" type="button">
                <span class="glow-arrow" aria-hidden="true">❯</span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    <section class="homearticle-section">
        <div class="homearticle-container">
            <h2 class="homearticle-heading">
                Latest <span class="homearticle-highlight">News</span>
            </h2>

            <div class="homearticle-grid">
                <!-- Artikel Utama -->
                <div class="homearticle-main">
                    <img src="/images/article1.jpg" alt="Main Article" class="homearticle-image" />
                    <div class="homearticle-overlay">
                        <p class="homearticle-date">4 June 2025</p>
                        <h3 class="homearticle-title">Kulit Sehat Alami: Cara Merawat Wajah Tanpa Ribet</h3>
                    </div>
                </div>

                <!-- Artikel Kecil -->
                <div class="homearticle-side">
                    <div class="homearticle-sub">
                        <img src="/images/article2.jpg" alt="Sub Article 1" class="homearticle-image" />
                        <div class="homearticle-overlay">
                            <p class="homearticle-date">4 June 2025</p>
                            <h3 class="homearticle-title small">
                                Skincare Malam: Rutinitas Penting Sebelum Tidur yang Sering Diabaikan
                            </h3>
                        </div>
                    </div>
                    <div class="homearticle-sub">
                        <img src="/images/article3.jpg" alt="Sub Article 2" class="homearticle-image" />
                        <div class="homearticle-overlay">
                            <p class="homearticle-date">4 June 2025</p>
                            <h3 class="homearticle-title small">
                                5 Bahan Alami yang Ampuh Cerahkan Wajah Kusam
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="program-wrapper">
        <div class="program-card">
            <img src="/images/reseller.jpg" alt="Reseller Image" class="program-image">
            <div class="program-description">
                <p class="program-label">Bergabung Sebagai</p>
                <h2 class="program-title">Reseller</h2>
                <p class="program-text">
                    Lorem ipsum dolor sit amet consectetur. Gravida adipiscing id purus quis morbi pretium cursus.
                    At faucibus tempus enim bibendum mi habitasse vulputate mauris urna. Id eget et egestas etiam velit.
                </p>
            </div>
        </div>

        <div class="program-card">
            <img src="/images/affiliate.jpg" alt="Affiliate Image" class="program-image">
            <div class="program-description">
                <p class="program-label">Bergabung Sebagai</p>
                <h2 class="program-title">Affiliate</h2>
                <p class="program-text">
                    Lorem ipsum dolor sit amet consectetur. Gravida adipiscing id purus quis morbi pretium cursus.
                    At faucibus tempus enim bibendum mi habitasse vulputate mauris urna. Id eget et egestas etiam velit.
                </p>
            </div>
        </div>
    </section>

    <script>
        // Inisialisasi carousel jika belum otomatis
        const myCarouselElement = document.querySelector('#mainCarousel');

        // Inisialisasi instance Bootstrap Carousel
        const carousel = new bootstrap.Carousel(myCarouselElement, {
            interval: 3000, // Slide tiap 3 detik
            ride: 'carousel', // Aktifkan otomatis
            pause: false, // Jangan berhenti saat hover
            wrap: true // Loop ke awal setelah slide terakhir
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-btn');
            const carouselEl = document.querySelector('#ingredientCarousel');
            const carousel = bootstrap.Carousel.getInstance(carouselEl) || new bootstrap.Carousel(carouselEl);

            // Fungsi update tab yang aktif
            function updateActiveTab(index) {
                tabButtons.forEach((btn, i) => {
                    btn.classList.toggle('active', i === index);
                });
            }

            // Ketika klik tab (manual)
            tabButtons.forEach((btn, index) => {
                btn.addEventListener('click', () => {
                    carousel.to(index); // pindah ke slide
                    updateActiveTab(index); // update tab aktif
                });
            });

            // Ketika carousel bergeser otomatis / panah
            carouselEl.addEventListener('slide.bs.carousel', function(e) {
                updateActiveTab(e.to); // e.to = index tujuan
            });
        });
    </script>

    <script>
        const track = document.querySelector('.glow-track');
        const slides = document.querySelectorAll('.glow-main');
        const tabs = document.querySelectorAll('.glow-tab-img');
        const prevBtn = document.querySelector('.glow-control-prev');
        const nextBtn = document.querySelector('.glow-control-next');

        let index = 0;
        let intervalId;
        let isTransitioning = false;

        function showSlide(i) {
            if (isTransitioning) return; // ❌ Stop kalau masih transisi
            isTransitioning = true;

            // Boundaries
            if (i < 0) i = slides.length - 1;
            if (i >= slides.length) i = 0;
            index = i;

            // Geser track
            track.style.transform = `translateX(-${i * 100}%)`;

            // Update tab
            tabs.forEach(tab => tab.classList.remove('active'));
            if (tabs[i]) tabs[i].classList.add('active');

            // Debounce protection (disable input selama transisi)
            setTimeout(() => {
                isTransitioning = false;
            }, 600); // waktu harus sedikit lebih besar dari `transition` CSS

            // Reset interval
            resetAutoSlide();
        }

        function nextSlide() {
            showSlide(index + 1);
        }

        function resetAutoSlide() {
            clearInterval(intervalId);
            intervalId = setInterval(nextSlide, 3000);
        }

        // Event Listeners
        prevBtn.addEventListener('click', () => showSlide(index - 1));
        nextBtn.addEventListener('click', () => nextSlide());
        tabs.forEach((tab, i) => {
            tab.addEventListener('click', () => showSlide(i));
        });

        // Init on load
        window.addEventListener('load', () => {
            showSlide(0);
            intervalId = setInterval(nextSlide, 3000);
        });
    </script>

@endsection

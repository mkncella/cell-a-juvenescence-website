<nav class="navbar bg-white">
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
        <div class="menu-wrapper d-flex justify-content-center gap-4 flex-wrap">
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
</script>

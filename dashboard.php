<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daun Hijau Cafe</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body,
    html {
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        overflow-x: hidden;
    }

    .dashboard-section {
        height: 100vh;
        min-height: 100vh;
        background-image: url(https://images.unsplash.com/photo-1521017432531-fbd92d768814?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxjb2ZmZWUlMjBzaG9wJTIwaW50ZXJpb3J8ZW58MXx8fHwxNzYxNDgwMzI4fDA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral);
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        background-repeat: no-repeat;
        position: relative;
        margin: 0;
        padding: 0;
    }

    .dashboard-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .dashboard-content {
        position: relative;
        z-index: 10;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }

    .btn-custom-green {
        background-color: #198754;
        border-color: #198754;
        color: white;
        padding: 12px 28px;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s ease;
        font-size: 1.1rem;
    }

    .btn-custom-green:hover {
        background-color: #157347;
        border-color: #146c43;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }

    .btn-outline-white {
        border: 2px solid white;
        color: white;
        background-color: transparent;
        padding: 12px 28px;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s ease;
        font-size: 1.1rem;
    }

    .btn-outline-white:hover {
        background-color: white;
        color: #198754;
        border-color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }

    .hero-title {
        font-weight: 800;
        margin-bottom: 1.5rem;
        text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.7);
        line-height: 1.1;
    }

    .hero-subtitle {
        font-size: 1.75rem;
        margin-bottom: 1rem;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        font-weight: 500;
    }

    .hero-description {
        max-width: 600px;
        margin: 0 auto 3rem;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.6);
        font-size: 1.2rem;
        line-height: 1.6;
    }

    .navbar-custom {
        background-color: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(15px);
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        padding: 0.5rem 0;
    }

    .logo-container {
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    .logo-container:hover {
        transform: scale(1.02);
    }

    .logo-icon {
        background-color: #198754;
        padding: 10px;
        border-radius: 10px;
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .logo-title {
        color: #155724;
        font-weight: 700;
        margin: 0;
        font-size: 1.3rem;
    }

    .logo-subtitle {
        color: #198754;
        font-size: 0.8rem;
        margin: 0;
        font-weight: 500;
    }

    .nav-link-custom {
        color: #374151 !important;
        transition: all 0.3s ease;
        border: none;
        background: none;
        padding: 10px 16px;
        font-weight: 500;
        border-radius: 6px;
        margin: 0 4px;
    }

    .nav-link-custom:hover {
        color: #198754 !important;
        background-color: rgba(25, 135, 84, 0.1);
        transform: translateY(-1px);
    }

    .btn-order {
        background-color: #198754;
        border-color: #198754;
        color: white;
        transition: all 0.3s ease;
        padding: 10px 20px;
        font-weight: 600;
        border-radius: 8px;
        margin: 0 8px;
    }

    .btn-order:hover {
        background-color: #157347;
        border-color: #146c43;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(25, 135, 84, 0.3);
    }

    .btn-order.active {
        box-shadow: 0 0 0 3px rgba(25, 135, 84, 0.3);
    }

    .btn-login {
        color: #198754;
        border: none;
        background: none;
        transition: all 0.3s ease;
        padding: 10px 20px;
        font-weight: 600;
        border-radius: 8px;
        margin: 0 4px;
    }

    .btn-login:hover {
        background-color: rgba(25, 135, 84, 0.1);
        transform: translateY(-1px);
    }

    .btn-login.active {
        background-color: rgba(25, 135, 84, 0.15);
    }

    .btn-signup {
        border: 2px solid #198754;
        color: #198754;
        background: none;
        transition: all 0.3s ease;
        padding: 10px 20px;
        font-weight: 600;
        border-radius: 8px;
        margin: 0 4px;
    }

    .btn-signup:hover {
        background-color: #198754;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(25, 135, 84, 0.3);
    }

    .btn-signup.active {
        background-color: #198754;
        color: white;
        box-shadow: 0 0 0 3px rgba(25, 135, 84, 0.3);
    }

    .mobile-nav {
        border-top: 1px solid #e5e7eb;
        background-color: white;
    }

    .mobile-nav-link {
        display: block;
        width: 100%;
        text-align: left;
        padding: 14px 0;
        color: #374151;
        border: none;
        background: none;
        transition: all 0.3s ease;
        font-weight: 500;
        border-bottom: 1px solid #f3f4f6;
    }

    .mobile-nav-link:hover {
        color: #198754;
        background-color: rgba(25, 135, 84, 0.05);
        padding-left: 10px;
    }

    .mobile-auth-section {
        border-top: 1px solid #e5e7eb;
        padding-top: 1.5rem;
        margin-top: 1rem;
    }

    .mobile-btn-login {
        display: block;
        width: 100%;
        padding: 12px;
        color: #198754;
        border: 2px solid #198754;
        background: none;
        border-radius: 8px;
        margin-bottom: 12px;
        transition: all 0.3s ease;
        font-weight: 600;
    }

    .mobile-btn-login:hover {
        background-color: rgba(25, 135, 84, 0.1);
    }

    .mobile-btn-signup {
        display: block;
        width: 100%;
        padding: 12px;
        background-color: #198754;
        color: white;
        border: none;
        border-radius: 8px;
        transition: all 0.3s ease;
        font-weight: 600;
    }

    .mobile-btn-signup:hover {
        background-color: #157347;
        transform: translateY(-1px);
    }

    .content-section {
        min-height: 100vh;
        padding: 100px 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .section-content {
        text-align: center;
        max-width: 800px;
        padding: 0 20px;
    }

    .section-title {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 2rem;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    }

    .section-description {
        font-size: 1.3rem;
        line-height: 1.7;
        margin-bottom: 2rem;
    }

    .about-section {
        background: linear-gradient(to bottom, #ffffff, #f8f9fa);
        padding: 5rem 0;
    }

    .section-title {
        color: #155724;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .title-divider {
        width: 80px;
        height: 3px;
        background-color: #198754;
        margin: 0 auto 1.5rem;
    }

    .feature-card {
        background: white;
        padding: 2.5rem 1.5rem;
        border-radius: 1rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        text-align: center;
        height: 100%;
    }

    .feature-card:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        transform: translateY(-5px);
    }

    .feature-icon {
        width: 64px;
        height: 64px;
        background-color: #d1e7dd;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
    }

    .feature-icon i {
        font-size: 1.75rem;
        color: #198754;
    }

    .feature-title {
        color: #212529;
        font-weight: 600;
        margin-bottom: 1rem;
        font-size: 1.25rem;
    }

    .feature-description {
        color: #6c757d;
        line-height: 1.6;
    }

    .about-image {
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        overflow: hidden;
    }

    .about-image img {
        width: 100%;
        height: 400px;
        object-fit: cover;
    }

    .story-title {
        color: #212529;
        font-weight: 700;
        margin-bottom: 1.5rem;
        font-size: 2rem;
    }

    .story-text {
        color: #6c757d;
        line-height: 1.7;
        margin-bottom: 1.5rem;
        font-size: 1.1rem;
    }

    .lead-text {
        font-size: 1.25rem;
        color: #6c757d;
        line-height: 1.6;
    }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-custom navbar-expand-lg fixed-top">
        <div class="container">
            <!-- Logo -->
            <div class="logo-container d-flex align-items-center" onclick="scrollToSection('home')">
                <div class="logo-icon me-3">
                    <i class="bi bi-cup-hot text-white fs-5"></i>
                </div>
                <div>
                    <h2 class="logo-title">Daun Hijau Cafe</h2>
                    <p class="logo-subtitle">Indonesian Coffee Experience</p>
                </div>
            </div>

            <!-- Mobile Menu Button -->
            <button class="navbar-toggler d-lg-none border-0 shadow-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#mobileNav">
                <i class="bi bi-list fs-4"></i>
            </button>

            <!-- Desktop Navigation -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav ms-auto align-items-center">
                    <!-- Navigation Items -->
                    <button class="nav-link-custom nav-link mx-1" onclick="handleNavClick('home')">Home</button>
                    <button class="nav-link-custom nav-link mx-1" onclick="handleNavClick('about')">About Us</button>
                    <button class="nav-link-custom nav-link mx-1" onclick="handleNavClick('menu')">Menu</button>
                    <button class="nav-link-custom nav-link mx-1" onclick="handleNavClick('news')">News</button>
                    <button class="nav-link-custom nav-link mx-1" onclick="handleNavClick('contact')">Contact
                        Us</button>

                    <!-- Order Button -->
                    <button class="btn btn-order ms-3 d-flex align-items-center" onclick="handleOrderClick()"
                        id="orderButton">
                        <i class="bi bi-cart me-2"></i>
                        Order Now
                    </button>

                    <!-- Auth Buttons -->
                    <div class="d-flex align-items-center ms-3">
                        <button class="btn-login me-2" onclick="handleLoginClick()" id="loginButton">
                            Masuk
                        </button>
                        <button class="btn-signup d-flex align-items-center" onclick="handleSignupClick()"
                            id="signupButton">
                            <i class="bi bi-person me-2"></i>
                            Daftar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div class="collapse d-lg-none mobile-nav" id="mobileNav">
            <div class="container py-3">
                <!-- Navigation Items -->
                <button class="mobile-nav-link" onclick="handleNavClick('home')">Home</button>
                <button class="mobile-nav-link" onclick="handleNavClick('about')">About Us</button>
                <button class="mobile-nav-link" onclick="handleNavClick('menu')">Menu</button>
                <button class="mobile-nav-link" onclick="handleNavClick('news')">News</button>
                <button class="mobile-nav-link" onclick="handleNavClick('contact')">Contact Us</button>

                <!-- Order Button -->
                <button class="btn btn-order w-100 mt-3 d-flex align-items-center justify-content-center py-3"
                    onclick="handleOrderClick()">
                    <i class="bi bi-cart me-2"></i>
                    Order Now
                </button>

                <!-- Auth Buttons -->
                <div class="mobile-auth-section">
                    <button class="mobile-btn-login py-3" onclick="handleLoginClick()">
                        Masuk
                    </button>
                    <button class="mobile-btn-signup d-flex align-items-center justify-content-center py-3"
                        onclick="handleSignupClick()">
                        <i class="bi bi-person me-2"></i>
                        Daftar
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <!-- Home Section -->
        <section id="home" class="dashboard-section">
            <div class="dashboard-overlay"></div>
            <div class="dashboard-content text-center text-white">
                <h1 class="hero-title display-1 fw-bold">Daun Hijau Cafe</h1>
                <p class="hero-subtitle">Pengalaman Kopi Indonesia yang Autentik</p>
                <p class="hero-description">
                    Nikmati cita rasa kopi nusantara yang kaya dengan suasana yang hangat dan nyaman.
                    Setiap tegukan membawa cerita dari berbagai penjuru Indonesia.
                </p>

                <!-- Tombol -->
                <div class="d-flex gap-4 justify-content-center flex-wrap">
                    <a href="menu.html" class="btn btn-custom-green btn-lg">
                        Lihat Menu
                    </a>

                    <button class="btn btn-outline-white btn-lg" onclick="scrollToContact()">
                        Hubungi Kami
                    </button>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section id="about" class="about-section py-4">
            <div class="container">
                <!-- Header Section -->
                <div class="text-center mb-5">
                    <h2 class="section-title display-4 fw-bold">Tentang Kami</h2>
                    <div class="title-divider"></div>
                    <p class="lead-text mx-auto" style="max-width: 600px;">
                        Daun Hijau Cafe adalah tempat di mana tradisi kopi Indonesia bertemu dengan kenyamanan modern
                    </p>
                </div>

                <!-- Story Section -->
                <div class="row align-items-center mb-5">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="about-image">
                            <img src="https://images.unsplash.com/photo-1650100458608-824a54559caa?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxjb2ZmZWUlMjBiZWFucyUyMGVzcHJlc3NvfGVufDF8fHx8MTc2MTQ0MTU3Mnww&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral"
                                alt="Coffee Beans" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <h3 class="story-title">Cerita Kami</h3>
                        <p class="story-text">
                            Didirikan pada tahun 2020, Daun Hijau Cafe lahir dari kecintaan kami terhadap kopi
                            Indonesia.
                            Kami percaya bahwa setiap biji kopi memiliki cerita unik yang layak untuk dibagikan.
                        </p>
                        <p class="story-text">
                            Dari pegunungan Gayo hingga lereng Gunung Ijen, kami menghadirkan cita rasa terbaik
                            dari seluruh nusantara ke dalam setiap cangkir yang kami sajikan.
                        </p>
                        <p class="story-text">
                            Di Daun Hijau Cafe, kami tidak hanya menyajikan kopi, tetapi juga menciptakan
                            pengalaman yang menghubungkan Anda dengan kekayaan budaya kopi Indonesia.
                        </p>
                    </div>
                </div>

                <!-- Features Section -->
                <div class="row g-4">
                    <!-- Feature 1 - Kopi Berkualitas -->
                    <div class="col-md-4">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-cup-hot"></i>
                            </div>
                            <h4 class="feature-title">Kopi Berkualitas</h4>
                            <p class="feature-description">
                                Biji kopi pilihan dari berbagai daerah di Indonesia
                            </p>
                        </div>
                    </div>

                    <!-- Feature 2 - Dibuat dengan Cinta -->
                    <div class="col-md-4">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-heart"></i>
                            </div>
                            <h4 class="feature-title">Dibuat dengan Cinta</h4>
                            <p class="feature-description">
                                Setiap cangkir dibuat dengan perhatian dan dedikasi
                            </p>
                        </div>
                    </div>

                    <!-- Feature 3 - Ramah Lingkungan -->
                    <div class="col-md-4">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-tree"></i>
                            </div>
                            <h4 class="feature-title">Ramah Lingkungan</h4>
                            <p class="feature-description">
                                Kami mendukung praktik pertanian berkelanjutan
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Menu Section -->
        <section id="menu" class="content-section">
            <div class="section-content">
                <h2 class="section-title">Our Menu</h2>
                <p class="section-description">
                    Jelajahi berbagai pilihan kopi spesialti dari berbagai daerah di Indonesia,
                    disajikan dengan teknik terbaik oleh barista profesional kami.
                </p>
            </div>
        </section>

        <!-- News Section -->
        <section id="news" class="content-section">
            <div class="section-content">
                <h2 class="section-title">Latest News</h2>
                <p class="section-description">
                    Dapatkan informasi terbaru tentang event, promo, dan perkembangan terbaru
                    dari Daun Hijau Cafe.
                </p>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="content-section">
            <div class="section-content">
                <h2 class="section-title">Contact Us</h2>
                <p class="section-description">
                    Hubungi kami untuk informasi lebih lanjut, reservasi, atau partnership.
                    Kami siap melayani Anda dengan sepenuh hati.
                </p>
            </div>
        </section>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
    let currentPage = "home";

    function scrollToSection(id) {
        const element = document.getElementById(id);
        if (element) {
            element.scrollIntoView({
                behavior: 'smooth'
            });
        }
    }

    function handleNavClick(id) {
        scrollToSection(id);
        // Tutup mobile menu jika terbuka
        const mobileNav = document.getElementById('mobileNav');
        if (mobileNav.classList.contains('show')) {
            const bsCollapse = new bootstrap.Collapse(mobileNav);
            bsCollapse.hide();
        }
    }

    function handleOrderClick() {
        // Simulasi navigasi ke halaman order
        currentPage = "order";
        alert('Navigating to Order Page');

        // Update active state
        updateActiveState();

        // Tutup mobile menu jika terbuka
        const mobileNav = document.getElementById('mobileNav');
        if (mobileNav.classList.contains('show')) {
            const bsCollapse = new bootstrap.Collapse(mobileNav);
            bsCollapse.hide();
        }
    }

    function handleLoginClick() {
        // Navigasi ke halaman login
        currentPage = "login";
        window.location.href = 'login.php';

        // Update active state
        updateActiveState();
    }

    function handleSignupClick() {
        // Navigasi ke halaman signup
        currentPage = "signup";
        window.location.href = 'register.php';

        // Update active state
        updateActiveState();
    }

    function scrollToContact() {
        scrollToSection('contact');
    }

    function updateActiveState() {
        // Reset semua active states
        const orderButton = document.getElementById('orderButton');
        const loginButton = document.getElementById('loginButton');
        const signupButton = document.getElementById('signupButton');

        // Remove active classes
        orderButton.classList.remove('active');
        loginButton.classList.remove('active');
        signupButton.classList.remove('active');

        // Add active class based on current page
        switch (currentPage) {
            case 'order':
                orderButton.classList.add('active');
                break;
            case 'login':
                loginButton.classList.add('active');
                break;
            case 'signup':
                signupButton.classList.add('active');
                break;
        }
    }

    // Event listener untuk logo
    document.querySelector('.logo-container').addEventListener('click', function() {
        handleNavClick('home');
    });

    // Initialize active state
    updateActiveState();
    </script>
</body>

</html>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation - Daun Hijau Cafe</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
    .navbar-custom {
        background-color: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .logo-container {
        cursor: pointer;
    }

    .logo-icon {
        background-color: #198754;
        padding: 8px;
        border-radius: 8px;
    }

    .logo-title {
        color: #155724;
        font-weight: 600;
        margin: 0;
        font-size: 1.1rem;
    }

    .logo-subtitle {
        color: #198754;
        font-size: 0.75rem;
        margin: 0;
    }

    .nav-link-custom {
        color: #374151 !important;
        transition: color 0.3s;
        border: none;
        background: none;
        padding: 8px 12px;
    }

    .nav-link-custom:hover {
        color: #198754 !important;
    }

    .btn-order {
        background-color: #198754;
        border-color: #198754;
        color: white;
        transition: all 0.3s;
    }

    .btn-order:hover {
        background-color: #157347;
        border-color: #146c43;
    }

    .btn-order.active {
        box-shadow: 0 0 0 2px rgba(25, 135, 84, 0.5);
    }

    .btn-login {
        color: #198754;
        border: none;
        background: none;
        transition: all 0.3s;
        padding: 8px 16px;
    }

    .btn-login:hover {
        background-color: rgba(25, 135, 84, 0.1);
    }

    .btn-login.active {
        background-color: rgba(25, 135, 84, 0.1);
    }

    .btn-signup {
        border: 2px solid #198754;
        color: #198754;
        background: none;
        transition: all 0.3s;
        padding: 8px 16px;
    }

    .btn-signup:hover {
        background-color: #198754;
        color: white;
    }

    .btn-signup.active {
        background-color: #198754;
        color: white;
    }

    .mobile-nav {
        border-top: 1px solid #e5e7eb;
    }

    .mobile-nav-link {
        display: block;
        width: 100%;
        text-align: left;
        padding: 12px 0;
        color: #374151;
        border: none;
        background: none;
        transition: color 0.3s;
    }

    .mobile-nav-link:hover {
        color: #198754;
    }

    .mobile-auth-section {
        border-top: 1px solid #e5e7eb;
        padding-top: 1rem;
    }

    .mobile-btn-login {
        display: block;
        width: 100%;
        padding: 10px;
        color: #198754;
        border: 1px solid #198754;
        background: none;
        border-radius: 8px;
        margin-bottom: 8px;
        transition: all 0.3s;
    }

    .mobile-btn-login:hover {
        background-color: rgba(25, 135, 84, 0.1);
    }

    .mobile-btn-signup {
        display: block;
        width: 100%;
        padding: 10px;
        background-color: #198754;
        color: white;
        border: none;
        border-radius: 8px;
        transition: all 0.3s;
    }

    .mobile-btn-signup:hover {
        background-color: #157347;
    }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-custom navbar-expand-lg fixed-top">
        <div class="container">
            <!-- Logo -->
            <div class="logo-container d-flex align-items-center" onclick="scrollToSection('home')">
                <div class="logo-icon me-2">
                    <i class="bi bi-cup-hot text-white"></i>
                </div>
                <div>
                    <h2 class="logo-title">Daun Hijau Cafe</h2>
                    <p class="logo-subtitle">Indonesian Coffee Experience</p>
                </div>
            </div>

            <!-- Mobile Menu Button -->
            <button class="navbar-toggler d-lg-none border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#mobileNav">
                <i class="bi bi-list"></i>
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
                <button class="btn btn-order w-100 mt-2 d-flex align-items-center justify-content-center"
                    onclick="handleOrderClick()">
                    <i class="bi bi-cart me-2"></i>
                    Order Now
                </button>

                <!-- Auth Buttons -->
                <div class="mobile-auth-section">
                    <button class="mobile-btn-login" onclick="handleLoginClick()">
                        Masuk
                    </button>
                    <button class="mobile-btn-signup d-flex align-items-center justify-content-center"
                        onclick="handleSignupClick()">
                        <i class="bi bi-person me-2"></i>
                        Daftar
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Content Placeholder -->
    <div style="height: 2000px; padding-top: 100px;">
        <div class="container">
            <div id="home" style="height: 500px; background: #f8f9fa; padding: 20px; margin-bottom: 20px;">
                <h2>Home Section</h2>
                <p>Scroll ke section ini dengan mengklik "Home" di navigasi</p>
            </div>
            <div id="about" style="height: 500px; background: #e9ecef; padding: 20px; margin-bottom: 20px;">
                <h2>About Us Section</h2>
                <p>Scroll ke section ini dengan mengklik "About Us" di navigasi</p>
            </div>
            <div id="menu" style="height: 500px; background: #dee2e6; padding: 20px; margin-bottom: 20px;">
                <h2>Menu Section</h2>
                <p>Scroll ke section ini dengan mengklik "Menu" di navigasi</p>
            </div>
            <div id="news" style="height: 500px; background: #ced4da; padding: 20px; margin-bottom: 20px;">
                <h2>News Section</h2>
                <p>Scroll ke section ini dengan mengklik "News" di navigasi</p>
            </div>
            <div id="contact" style="height: 500px; background: #adb5bd; padding: 20px; margin-bottom: 20px;">
                <h2>Contact Us Section</h2>
                <p>Scroll ke section ini dengan mengklik "Contact Us" di navigasi</p>
            </div>
        </div>
    </div>

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

        // Tutup mobile menu jika terbuka
        const mobileNav = document.getElementById('mobileNav');
        if (mobileNav.classList.contains('show')) {
            const bsCollapse = new bootstrap.Collapse(mobileNav);
            bsCollapse.hide();
        }
    }

    function handleSignupClick() {
        // Navigasi ke halaman signup
        currentPage = "signup";
        window.location.href = 'register.php';

        // Update active state
        updateActiveState();

        // Tutup mobile menu jika terbuka
        const mobileNav = document.getElementById('mobileNav');
        if (mobileNav.classList.contains('show')) {
            const bsCollapse = new bootstrap.Collapse(mobileNav);
            bsCollapse.hide();
        }
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
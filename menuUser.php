<?php
session_start();
require_once 'env.php';

$queryMenus = "SELECT * FROM products";
$resultMenus = $koneksi->query($queryMenus);

$menuItems = [];
if ($resultMenus->num_rows > 0) {
    while($row = $resultMenus->fetch_assoc()) {
        $menuItems[] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'description' => $row['description'],
            'price' => number_format($row['price'], 0, ',', '.'),
            'category' => $row['category']
        ];
    }
}

$coffeeItems = array_filter($menuItems, fn($item) => $item['category'] === 'coffee');
$minumanItems = array_filter($menuItems, fn($item) => $item['category'] === 'minuman');
$makananItems = array_filter($menuItems, fn($item) => $item['category'] === 'makanan');

$searchQuery = $_POST['search'] ?? '';

$filteredAllItems = array_filter($menuItems, function($item) use ($searchQuery) {
    return empty($searchQuery) || 
           stripos($item['name'], $searchQuery) !== false || 
           stripos($item['description'], $searchQuery) !== false;
});

$filteredCoffeeItems = array_filter($coffeeItems, function($item) use ($searchQuery) {
    return empty($searchQuery) || 
           stripos($item['name'], $searchQuery) !== false || 
           stripos($item['description'], $searchQuery) !== false;
});

$filteredMinumanItems = array_filter($minumanItems, function($item) use ($searchQuery) {
    return empty($searchQuery) || 
           stripos($item['name'], $searchQuery) !== false || 
           stripos($item['description'], $searchQuery) !== false;
});

$filteredMakananItems = array_filter($makananItems, function($item) use ($searchQuery) {
    return empty($searchQuery) || 
           stripos($item['name'], $searchQuery) !== false || 
           stripos($item['description'], $searchQuery) !== false;
});
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Lengkap - Daun Hijau Cafe</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
    :root {
        --primary-green: #198754;
        --dark-green: #155724;
        --light-green: #d1e7dd;
    }

    body {
        background-color: #f8f9fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        line-height: 1.6;
        padding-top: 80px; /* Added for fixed navbar */
    }

    /* NEW NAVBAR STYLES from idk.html */
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
        text-decoration: none;
    }

    .nav-link-custom:hover,
    .nav-link-custom.active {
        color: #198754 !important;
        background-color: rgba(25, 135, 84, 0.1);
        transform: translateY(-1px);
        text-decoration: none;
    }

    .btn-login {
        border: 2px solid #198754;
        color: #198754;
        background: none;
        transition: all 0.3s ease;
        padding: 10px 20px;
        font-weight: 600;
        border-radius: 8px;
        margin: 0 4px;
        text-decoration: none;
        display: inline-block;
    }

    .btn-login:hover {
        background-color: #198754;
        color: white;
        transform: translateY(-1px);
        text-decoration: none;
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
        text-decoration: none;
        display: block;
    }

    .btn-order:hover {
        background-color: #157347;
        border-color: #146c43;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(25, 135, 84, 0.3);
        color: white;
        text-decoration: none;
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
        text-decoration: none;
    }

    .mobile-nav-link:hover,
    .mobile-nav-link.active {
        color: #198754;
        background-color: rgba(25, 135, 84, 0.05);
        padding-left: 10px;
        text-decoration: none;
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
        text-decoration: none;
        text-align: center;
    }

    .mobile-btn-login:hover {
        background-color: rgba(25, 135, 84, 0.1);
        text-decoration: none;
    }

    /* EXISTING MENU PAGE STYLES */
    .container-custom {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }

    .page-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .page-title {
        color: var(--dark-green);
        font-weight: 700;
        margin-bottom: 0.5rem;
        font-size: 2.5rem;
    }

    .page-subtitle {
        color: #6c757d;
        font-size: 1.1rem;
    }

    .search-section {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }

    .search-box {
        position: relative;
        max-width: 500px;
        margin: 0 auto;
    }

    .search-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
    }

    .search-input {
        padding-left: 3rem;
        border-radius: 25px;
        border: 2px solid #e9ecef;
        font-size: 1rem;
    }

    .search-input:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25);
    }

    /* Improved Tabs Navigation */
    .nav-tabs-custom {
        border: none;
        background: transparent;
        padding: 0;
        margin-bottom: 2rem;
        display: flex;
        justify-content: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .nav-tabs-custom .nav-item {
        flex: 0 1 auto;
    }

    .nav-tabs-custom .nav-link {
        border: 2px solid var(--primary-green) !important;
        border-radius: 25px;
        padding: 0.75rem 1.5rem;
        color: var(--primary-green) !important;
        font-weight: 600;
        background: white;
        transition: all 0.3s ease;
        min-width: 120px;
        text-align: center;
        white-space: nowrap;
    }

    .nav-tabs-custom .nav-link:hover {
        background-color: var(--light-green);
        color: var(--dark-green) !important;
        border-color: var(--dark-green) !important;
        transform: translateY(-2px);
    }

    .nav-tabs-custom .nav-link.active {
        background: linear-gradient(135deg, var(--primary-green), var(--dark-green));
        color: white !important;
        border-color: var(--primary-green) !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(25, 135, 84, 0.3);
    }

    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .menu-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
        overflow: hidden;
    }

    .menu-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    }

    .menu-card-body {
        padding: 1.5rem;
    }

    .menu-item-name {
        color: var(--dark-green);
        font-weight: 700;
        font-size: 1.3rem;
        margin-bottom: 0.75rem;
    }

    .menu-item-description {
        color: #6c757d;
        margin-bottom: 1.5rem;
        line-height: 1.5;
        font-size: 0.95rem;
    }

    .menu-item-price {
        color: var(--primary-green);
        font-weight: 700;
        font-size: 1.3rem;
        margin-bottom: 1.5rem;
    }

    .btn-order-menu {
        background: var(--primary-green);
        border: none;
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
        width: 100%;
        font-size: 1rem;
    }

    .btn-order-menu:hover {
        background: var(--dark-green);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(25, 135, 84, 0.3);
    }

    .cta-section {
        background: linear-gradient(135deg, var(--primary-green), var(--dark-green));
        border-radius: 15px;
        padding: 3rem 2rem;
        text-align: center;
        color: white;
        margin-top: 3rem;
    }

    .cta-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .cta-description {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 2rem;
    }

    .btn-cta {
        background: white;
        color: var(--primary-green);
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 25px;
        font-weight: 700;
        font-size: 1.1rem;
        transition: all 0.3s ease;
    }

    .btn-cta:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(255, 255, 255, 0.3);
    }

    .no-items {
        text-align: center;
        color: #6c757d;
        font-style: italic;
        padding: 3rem;
        background: white;
        border-radius: 12px;
        border: 2px dashed #dee2e6;
    }

    @media (max-width: 768px) {
        .container-custom {
            padding: 1rem 0.5rem;
        }

        .page-title {
            font-size: 2rem;
        }

        .menu-grid {
            grid-template-columns: 1fr;
        }

        .nav-tabs-custom {
            gap: 0.5rem;
        }

        .nav-tabs-custom .nav-link {
            min-width: 110px;
            padding: 0.6rem 1rem;
            font-size: 0.9rem;
        }
    }

    @media (max-width: 576px) {
        .nav-tabs-custom {
            flex-direction: column;
            align-items: center;
        }
        
        .nav-tabs-custom .nav-link {
            min-width: 200px;
            padding: 0.75rem 1.5rem;
        }
        
        .menu-card-body {
            padding: 1.25rem;
        }
        
        .menu-item-name {
            font-size: 1.2rem;
        }
        
        .menu-item-price {
            font-size: 1.2rem;
        }
    }
    </style>
</head>

<body>
    <!-- NEW NAVBAR from idk.html -->
    <nav class="navbar navbar-custom navbar-expand-lg fixed-top">
        <div class="container">
            <!-- Logo -->
            <a class="logo-container d-flex align-items-center text-decoration-none" href="dashboard.php">
                <div class="logo-icon me-3">
                    <i class="bi bi-cup-hot text-white fs-5"></i>
                </div>
                <div>
                    <h2 class="logo-title">Daun Hijau Cafe</h2>
                    <p class="logo-subtitle">Indonesian Coffee Experience</p>
                </div>
            </a>

            <!-- Mobile Menu Button -->
            <button class="navbar-toggler d-lg-none border-0 shadow-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#mobileNav">
                <i class="bi bi-list fs-4"></i>
            </button>

            <!-- Desktop Navigation -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav ms-auto align-items-center">
                    <!-- Navigation Items -->
                    <a class="nav-link-custom nav-link mx-1" href="dashboard.php">Home</a>
                    <a class="nav-link-custom nav-link mx-1" href="dashboard.php#about">About Us</a>
                    <a class="nav-link-custom nav-link active mx-1" href="menuUser.php">Menu</a>
                    <a class="nav-link-custom nav-link mx-1" href="dashboard.php#news">News</a>
                    <a class="nav-link-custom nav-link mx-1" href="dashboard.php#contact">Contact Us</a>

                    <!-- Auth Buttons -->
                    <div class="align-items-center ms-0">
                        <a class="btn-login me-0" href="login.php" id="loginButton">
                            Masuk
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div class="collapse d-lg-none mobile-nav" id="mobileNav">
            <div class="container py-3">
                <!-- Navigation Items -->
                <a class="mobile-nav-link" href="dashboard.php">Home</a>
                <a class="mobile-nav-link" href="dashboard.php#about">About Us</a>
                <a class="mobile-nav-link active" href="menuUser.php">Menu</a>
                <a class="mobile-nav-link" href="dashboard.php#news">News</a>
                <a class="mobile-nav-link" href="dashboard.php#contact">Contact Us</a>

                <!-- Order Button -->
                <a class="btn btn-order w-100 mt-3 d-flex align-items-center justify-content-center py-3" href="order.php">
                    <i class="bi bi-cart me-2"></i>
                    Order Now
                </a>

                <!-- Auth Buttons -->
                <div class="mobile-auth-section">
                    <a class="mobile-btn-login py-3" href="login.php">
                        Masuk
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- EXISTING MENU CONTENT (unchanged) -->
    <div class="container-custom">
        <!-- Page Header -->
        <section id="menus">
            <div class="page-header">
                <h1 class="page-title">Menu Lengkap</h1>
                <p class="page-subtitle">Jelajahi semua pilihan kopi, minuman, dan makanan kami</p>
            </div>
        </section>

        <!-- Search Section -->
        <div class="search-section">
            <form method="POST" action="">
                <div class="search-box">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" 
                    name="search" 
                    class="form-control search-input" 
                    placeholder="Cari menu..."
                    value="<?php echo htmlspecialchars($searchQuery); ?>">
                </div>
            </form>
        </div>
        
            
        <!-- Improved Tabs Navigation with All Menu -->
        <ul class="nav nav-tabs nav-tabs-custom" id="menuTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all"
                    type="button" role="tab">
                    Semua Menu 
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="coffee-tab" data-bs-toggle="tab" data-bs-target="#coffee"
                    type="button" role="tab">
                    Coffee (<?php echo count($filteredCoffeeItems); ?>)
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="minuman-tab" data-bs-toggle="tab" data-bs-target="#minuman"
                    type="button" role="tab">
                    Minuman (<?php echo count($filteredMinumanItems); ?>)
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="makanan-tab" data-bs-toggle="tab" data-bs-target="#makanan" type="button"
                    role="tab">
                    Makanan (<?php echo count($filteredMakananItems); ?>)
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="menuTabsContent">
            <!-- All Menu Tab -->
            <div class="tab-pane fade show active" id="all" role="tabpanel">
                <?php if (empty($filteredAllItems)): ?>
                    <div class="no-items">
                        Tidak ada menu yang ditemukan
                    </div>
                <?php else: ?>
                    <div class="menu-grid">
                        <?php foreach ($filteredAllItems as $item): ?>
                            <div class="menu-card">
                                <div class="menu-card-body">
                                    <h3 class="menu-item-name"><?php echo htmlspecialchars($item['name']); ?></h3>
                                    <p class="menu-item-description"><?php echo htmlspecialchars($item['description']); ?></p>
                                    <p class="menu-item-price">Rp <?php echo $item['price']; ?></p>
                                    <button class="btn-order-menu" onclick="window.location.href='order.php?item_id=<?php echo $item['id']; ?>'">
                                        Pesan
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Coffee Tab -->
            <div class="tab-pane fade" id="coffee" role="tabpanel">
                <?php if (empty($filteredCoffeeItems)): ?>
                    <div class="no-items">
                        Tidak ada menu coffee yang ditemukan
                    </div>
                <?php else: ?>
                    <div class="menu-grid">
                        <?php foreach ($filteredCoffeeItems as $item): ?>
                            <div class="menu-card">
                                <div class="menu-card-body">
                                    <h3 class="menu-item-name"><?php echo htmlspecialchars($item['name']); ?></h3>
                                    <p class="menu-item-description"><?php echo htmlspecialchars($item['description']); ?></p>
                                    <p class="menu-item-price">Rp <?php echo $item['price']; ?></p>
                                    <button class="btn-order-menu" onclick="window.location.href='order.php?item_id=<?php echo $item['id']; ?>'">
                                        Pesan
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Minuman Tab -->
            <div class="tab-pane fade" id="minuman" role="tabpanel">
                <?php if (empty($filteredMinumanItems)): ?>
                    <div class="no-items">
                        Tidak ada menu minuman yang ditemukan
                    </div>
                <?php else: ?>
                    <div class="menu-grid">
                        <?php foreach ($filteredMinumanItems as $item): ?>
                            <div class="menu-card">
                                <div class="menu-card-body">
                                    <h3 class="menu-item-name"><?php echo htmlspecialchars($item['name']); ?></h3>
                                    <p class="menu-item-description"><?php echo htmlspecialchars($item['description']); ?></p>
                                    <p class="menu-item-price">Rp <?php echo $item['price']; ?></p>
                                    <button class="btn-order-menu" onclick="window.location.href='order.php?item_id=<?php echo $item['id']; ?>'">
                                        Pesan
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Makanan Tab -->
            <div class="tab-pane fade" id="makanan" role="tabpanel">
                <?php if (empty($filteredMakananItems)): ?>
                    <div class="no-items">
                        Tidak ada menu makanan yang ditemukan
                    </div>
                <?php else: ?>
                    <div class="menu-grid">
                        <?php foreach ($filteredMakananItems as $item): ?>
                            <div class="menu-card">
                                <div class="menu-card-body">
                                    <h3 class="menu-item-name"><?php echo htmlspecialchars($item['name']); ?></h3>
                                    <p class="menu-item-description"><?php echo htmlspecialchars($item['description']); ?></p>
                                    <p class="menu-item-price">Rp <?php echo $item['price']; ?></p>
                                    <button class="btn-order-menu" onclick="window.location.href='order.php?item_id=<?php echo $item['id']; ?>'">
                                        Pesan
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Bottom CTA -->
        <div class="cta-section">
            <h2 class="cta-title">Siap Untuk Memesan?</h2>
            <p class="cta-description">
                Nikmati pengalaman coffee shop terbaik dengan berbagai pilihan menu yang lezat. 
                Pesan sekarang dan dapatkan promo menarik!
            </p>
            <button onclick="handleNavClick('menus')" class="btn btn-cta">
                
                    <i class="bi bi-cart me-2"></i>Mulai Pesan
                
            </button>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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
    </script>
</body>
</html>
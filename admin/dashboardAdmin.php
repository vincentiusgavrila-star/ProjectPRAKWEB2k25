<?php 
session_start();
include 'env.php';

if(!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin'){
    header("location:../login.php");
    exit();
}

$queryUsers = "SELECT * FROM users";
$resultUsers = $koneksi->query($queryUsers);

$queryMenus = "SELECT * FROM products";
$resultMenus = $koneksi->query($queryMenus);

$queryOrders = "SELECT o.*, u.username, p.name as product_name, p.price as product_price
                FROM orders o
                JOIN users u ON o.user_id = u.id_user
                JOIN products p ON o.product_id = p.id
                ORDER BY o.order_date ASC";
$resultOrders = $koneksi->query($queryOrders);

// Get contact messages count
$queryMessagesCount = "SELECT COUNT(*) as total_messages FROM contact_messages";
$resultMessagesCount = $koneksi->query($queryMessagesCount);
$messagesCount = $resultMessagesCount->fetch_assoc();

$queryNewsCount = "SELECT COUNT(*) as total_news FROM news";
$resultNewsCount = $koneksi->query($queryNewsCount);
$newsCount = $resultNewsCount->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Daun Hijau Cafe</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
    :root {
        --primary-green: #198754;
        --dark-green: #155724;
        --light-green: #d1e7dd;
        --hover-green: #157347;
    }

    body {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        min-height: 100vh;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .admin-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }

    .admin-header {
        margin-bottom: 2rem;
    }

    .btn-back {
        background: none;
        border: 1px solid #dee2e6;
        color: #6c757d;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        transition: all 0.3s ease;
        margin-bottom: 1rem;
    }

    .btn-back:hover {
        background-color: var(--light-green);
        border-color: var(--primary-green);
        color: var(--dark-green);
    }

    .page-title {
        color: var(--dark-green);
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .page-subtitle {
        color: #6c757d;
    }

    .nav-tabs-custom {
        border: none;
        background: white;
        border-radius: 12px;
        padding: 0.5rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }

    .nav-tabs-custom .nav-link {
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        color: #6c757d;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .nav-tabs-custom .nav-link:hover {
        background-color: var(--light-green);
        color: var(--dark-green);
    }

    .nav-tabs-custom .nav-link.active {
        background: linear-gradient(135deg, var(--primary-green), var(--dark-green));
        color: white;
    }

    .dashboard-card {
        background: white;
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }

    .card-header-custom {
        background: white;
        border: none;
        padding: 1.5rem 1.5rem 0.5rem;
    }

    .card-title {
        color: var(--dark-green);
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .card-description {
        color: #6c757d;
        margin-bottom: 1rem;
    }

    .btn-add {
        background: linear-gradient(135deg, var(--primary-green), var(--dark-green));
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(25, 135, 84, 0.3);
    }

    .btn-view-messages {
        background: none;
        border: 2px solid var(--primary-green);
        color: var(--primary-green);
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }

    .btn-view-messages:hover {
        background-color: var(--primary-green);
        color: white;
        transform: translateY(-2px);
    }

    .table-custom {
        margin: 0;
    }

    .table-custom thead th {
        background-color: var(--light-green);
        color: var(--dark-green);
        font-weight: 600;
        border: none;
        padding: 1rem 0.75rem;
    }

    .table-custom tbody td {
        padding: 1rem 0.75rem;
        vertical-align: middle;
        border-color: #e9ecef;
    }

    .table-custom tbody tr:hover {
        background-color: #f8f9fa;
    }

    .messages-quickview {
        background: white;
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }

    .messages-header {
        background: linear-gradient(135deg, var(--primary-green), var(--dark-green));
        color: white;
        padding: 1.5rem;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }

    .messages-body {
        padding: 1.5rem;
    }

    .message-preview {
        display: flex;
        align-items: center;
        padding: 1rem;
        border-bottom: 1px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .message-preview:last-child {
        border-bottom: none;
    }

    .message-preview:hover {
        background-color: #f8f9fa;
    }

    .message-avatar {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, var(--primary-green), var(--dark-green));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        margin-right: 1rem;
    }

    .message-content {
        flex: 1;
    }

    .message-sender {
        font-weight: 600;
        color: var(--dark-green);
        margin: 0;
    }

    .message-text {
        color: #6c757d;
        margin: 0;
        font-size: 0.9rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 300px;
    }

    .message-date {
        color: #6c757d;
        font-size: 0.8rem;
        text-align: right;
    }

    .badge-status {
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .badge-new {
        background-color: #dc3545;
        color: white;
    }

    .btn-action {
        background: none;
        border: 1px solid #dee2e6;
        color: #6c757d;
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        transition: all 0.3s ease;
        margin-left: 0.25rem;
    }

    .btn-action:hover {
        background-color: #f8f9fa;
    }

    .btn-action.delete:hover {
        background-color: #f8d7da;
        border-color: #f1aeb5;
        color: #dc3545;
    }

    .text-truncate-custom {
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .btn-news {
        background: linear-gradient(135deg, #0d6efd, #0a58ca);
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }

    .btn-news:hover {
        background: linear-gradient(135deg, #0a58ca, #084298);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
    }

    @media (max-width: 768px) {
        .admin-container {
            padding: 1rem 0.5rem;
        }

        .table-responsive {
            font-size: 0.875rem;
        }

        .btn-action {
            padding: 0.25rem 0.5rem;
        }

        .nav-tabs-custom .nav-link {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }

        .message-text {
            max-width: 200px;
        }
    }
    </style>
</head>

<body>
    <div class="admin-container">
        <!-- Header -->
        <div class="admin-header">
            <button class="btn btn-back" onclick="handleBack()">
                <i class="bi bi-arrow-left me-2"></i>
                Logout
            </button>
            <h1 class="page-title display-5 fw-bold">Admin Dashboard</h1>
            <p class="page-subtitle">Manage users, menu items, orders, news, and customer messages</p>

            <!-- Quick Navigation to Messages -->
            <div class="mt-3">
                <a href="logUser.php" class="btn btn-view-messages">
                    <i class="bi bi-chat-square-text me-2"></i>
                    View All Customer Messages
                    <?php if ($messagesCount['total_messages'] > 0): ?>
                    <span class="badge bg-primary ms-2"><?php echo $messagesCount['total_messages']; ?> messages</span>
                    <?php endif; ?>
                </a>
                <a href="manageNews.php" class="btn btn-view-messages">
                    <i class="bi bi-newspaper me-2"></i>
                    View All News
                    <?php if ($newsCount['total_news'] > 0): ?>
                    <span class="badge bg-primary text-light ms-2"><?php echo $newsCount['total_news']; ?> news</span>
                    <?php endif; ?>
                </a>
            </div>
        </div>

        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs nav-tabs-custom nav-fill" id="adminTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="users-tab" data-bs-toggle="tab" data-bs-target="#users"
                    type="button" role="tab">
                    Users
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="menu-tab" data-bs-toggle="tab" data-bs-target="#menu" type="button"
                    role="tab">
                    Menu
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders" type="button"
                    role="tab">
                    Orders
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="news-tab" data-bs-toggle="tab" data-bs-target="#news" type="button"
                    role="tab">
                    <i class="bi bi-newspaper me-1"></i>News
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="adminTabsContent">
            <!-- Users Tab -->
            <div class="tab-pane fade show active" id="users" role="tabpanel">
                <div class="card dashboard-card">
                    <div class="card-header-custom">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h3 class="card-title">All Users</h3>
                                <p class="card-description">A list of all registered users in the system</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-custom table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    if(mysqli_num_rows($resultUsers) > 0){
                                        $id = 0;
                                        while($row = mysqli_fetch_assoc($resultUsers)){
                                            $id += 1;
                                            echo "<tr>";
                                            echo "<td>".$id."</td>";
                                            echo "<td>".$row['username']."</td>";
                                            echo "<td>".$row['email']."</td>";
                                            echo "<td>
                                                <div class='text-end'>
                                                    <button class='btn btn-action delete'>
                                                        <a href='deleteUsers.php?username=". $row['username'] ."'>
                                                        <i class='bi bi-trash text-danger'></i>
                                                        </a>
                                                    </button>
                                                </div>
                                            </td>";
                                            echo "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Menu Tab -->
            <div class="tab-pane fade" id="menu" role="tabpanel">
                <div class="card dashboard-card">
                    <div class="card-header-custom">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h3 class="card-title">All Menu Items</h3>
                                <p class="card-description">Manage your cafe menu items</p>
                            </div>
                            <button class="btn btn-add" onclick="handleAddMenu()">
                                <i class="bi bi-plus me-2"></i>
                                Add Menu
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-custom table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Description</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    if(mysqli_num_rows($resultMenus) > 0){
                                        $id = 0;
                                        while($row = mysqli_fetch_assoc($resultMenus)){
                                            $id += 1;
                                            echo "<tr>";
                                            echo "<td>".$id."</td>";
                                            echo "<td>".$row['id']."</td>";
                                            echo "<td>".$row['name']."</td>";
                                            echo "<td>".$row['category']."</td>";
                                            echo "<td>Rp " . number_format($row['price'], 0, ',', '.') . "</td>";
                                            echo "<td>".$row['description']."</td>";
                                            echo "<td>
                                                <div class='text-end'>
                                                    <button class='btn btn-action'>
                                                        <a href='editMenus.php?id=".$row['id']."'
                                                        <i class='bi bi-pencil'></i>
                                                        </a>
                                                    </button>
                                                    <button class='btn btn-action delete'>
                                                        <a href='deleteMenus.php?id=".$row['id']."'
                                                        <i class='bi bi-trash text-danger'></i>
                                                        </a>
                                                    </button>
                                                </div>
                                            </td>";
                                            echo "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Orders Tab -->
            <div class="tab-pane fade" id="orders" role="tabpanel">
                <div class="card dashboard-card">
                    <div class="card-header-custom">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h3 class="card-title">All Orders</h3>
                                <p class="card-description">View and manage customer orders</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-custom table-hover">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer</th>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Total Price</th>
                                        <th>Notes</th>
                                        <th>Order Date</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    if(mysqli_num_rows($resultOrders) > 0){
                                        $orderCount = 0;
                                        while($row = mysqli_fetch_assoc($resultOrders)){
                                            $orderCount += 1;
                                            $totalPrice = $row['quantity'] * $row['product_price'];
                                            $formattedDate = date('Y-m-d H:i', strtotime($row['order_date']));
                                            echo "<tr>";
                                            echo "<td>ORD-" . str_pad($orderCount, 3, '0', STR_PAD_LEFT) . "</td>";
                                            echo "<td>".$row['username']."</td>";
                                            echo "<td>".$row['product_name']."</td>";
                                            echo "<td>".$row['quantity']."</td>";
                                            echo "<td>Rp " . number_format($totalPrice, 0, ',', '.') . "</td>";
                                            echo "<td class='text-truncate-custom' title='".$row['notes']."'>".$row['notes']."</td>";
                                            echo "<td>".$formattedDate."</td>";
                                            echo "<td>
                                                <div class='text-end'>
                                                    <a href='editOrders.php?id=".$row['id']."' class='btn btn-action'>
                                            <i class='bi bi-pencil'></i>
                                        </a>
                                        <a href='deleteOrders.php?id=".$row['id']."' class='btn btn-action delete'
                                           onclick='return confirm(\"Apakah Anda yakin ingin menghapus order ini?\")'>
                                            <i class='bi bi-trash text-danger'></i>
                                        </a>
                                                </div>
                                            </td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='8' class='text-center py-4'>No orders found</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- News Tab -->
            <div class="tab-pane fade" id="news" role="tabpanel">
                <div class="card dashboard-card">
                    <div class="card-header-custom">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h3 class="card-title">News Management</h3>
                                <p class="card-description">Manage news and announcements for your website</p>
                            </div>
                            <a href="manageNews.php" class="btn btn-add">
                                <i class="bi bi-plus me-2"></i>
                                Add News
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card border-0 bg-light">
                                    <div class="card-body text-center">
                                        <i class="bi bi-newspaper display-4 text-primary mb-3"></i>
                                        <h5>News Articles</h5>
                                        <p class="text-muted">Create and manage news content</p>
                                        <a href="manageNews.php" class="btn btn-primary">
                                            Go to News Manager
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-0 bg-light">
                                    <div class="card-body text-center">
                                        <i class="bi bi-image display-4 text-success mb-3"></i>
                                        <h5>Media Gallery</h5>
                                        <p class="text-muted">Upload and manage news images</p>
                                        <button class="btn btn-outline-success" onclick="handleMediaGallery()">
                                            View Gallery
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick News Stats -->
                        <div class="row mt-4">
                            <div class="col-md-3">
                                <div class="text-center p-3 border rounded">
                                    <h4 class="text-primary mb-1"><?php echo $newsCount['total_news']; ?></h4>
                                    <small class="text-muted">Total News</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center p-3 border rounded">
                                    <h4 class="text-success mb-1">
                                        <?php 
                                        $queryRecentNews = "SELECT COUNT(*) as recent_news FROM news WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
                                        $resultRecentNews = $koneksi->query($queryRecentNews);
                                        $recentNews = $resultRecentNews->fetch_assoc();
                                        echo $recentNews['recent_news'];
                                        ?>
                                    </h4>
                                    <small class="text-muted">This Week</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center p-3 border rounded">
                                    <h4 class="text-info mb-1">
                                        <?php 
                                        $queryWithImages = "SELECT COUNT(*) as with_images FROM news WHERE gambar IS NOT NULL AND gambar != ''";
                                        $resultWithImages = $koneksi->query($queryWithImages);
                                        $withImages = $resultWithImages->fetch_assoc();
                                        echo $withImages['with_images'];
                                        ?>
                                    </h4>
                                    <small class="text-muted">With Images</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center p-3 border rounded">
                                    <h4 class="text-warning mb-1">
                                        <?php 
                                        $queryTodayNews = "SELECT COUNT(*) as today_news FROM news WHERE DATE(created_at) = CURDATE()";
                                        $resultTodayNews = $koneksi->query($queryTodayNews);
                                        $todayNews = $resultTodayNews->fetch_assoc();
                                        echo $todayNews['today_news'];
                                        ?>
                                    </h4>
                                    <small class="text-muted">Today</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Messages Preview -->
        <div class="messages-quickview">
            <div class="messages-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">Recent Customer Messages</h4>
                        <p class="mb-0">Latest messages from customers</p>
                    </div>
                    <a href="logUser.php" class="btn btn-light">
                        View All <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
            <div class="messages-body">
                <?php
                // Get latest 5 messages for preview
                $queryRecentMessages = "SELECT cm.*, u.username 
                                      FROM contact_messages cm 
                                      LEFT JOIN users u ON cm.user_id = u.id_user 
                                      ORDER BY cm.created_at DESC 
                                      LIMIT 5";
                $resultRecentMessages = $koneksi->query($queryRecentMessages);
                
                if (mysqli_num_rows($resultRecentMessages) > 0): 
                    while($message = mysqli_fetch_assoc($resultRecentMessages)):
                ?>
                <div class="message-preview">
                    <div class="message-avatar">
                        <?php echo strtoupper(substr($message['name'], 0, 1)); ?>
                    </div>
                    <div class="message-content">
                        <h6 class="message-sender">
                            <?php echo htmlspecialchars($message['name']); ?>
                        </h6>
                        <p class="message-text" title="<?php echo htmlspecialchars($message['message']); ?>">
                            <?php echo htmlspecialchars($message['message']); ?>
                        </p>
                    </div>
                    <div class="message-date">
                        <?php echo date('M j', strtotime($message['created_at'])); ?>
                    </div>
                </div>
                <?php 
                    endwhile;
                else: 
                ?>
                <div class="text-center py-4">
                    <i class="bi bi-chat-square-text display-4 text-muted"></i>
                    <p class="text-muted mt-2">No messages yet</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    function handleBack() {
        window.location.href = '../index.php?pesan=reset';
    }

    function handleAddMenu() {
        window.location.href = 'formMenuAdmin.php';
    }

    function handleMediaGallery() {
        window.location.href = './gallery.php';

    }
    </script>
</body>

</html>
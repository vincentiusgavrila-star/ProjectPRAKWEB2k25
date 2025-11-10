<?php 
include 'env.php';

$queryUsers = "SELECT * FROM users";
$resultUsers = $koneksi->query($queryUsers);
$queryMenus = "SELECT * FROM products";
$resultMenus = $koneksi->query($queryMenus);



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

    .badge-status {
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .badge-completed {
        background-color: #d1e7dd;
        color: #0f5132;
    }

    .badge-processing {
        background-color: #cfe2ff;
        color: #052c65;
    }

    .badge-pending {
        background-color: #fff3cd;
        color: #664d03;
    }

    .badge-available {
        background-color: #d1e7dd;
        color: #0f5132;
    }

    .badge-popular {
        background-color: transparent;
        border: 1px solid #fd7e14;
        color: #fd7e14;
        padding: 0.25rem 0.5rem;
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
    }
    </style>
</head>

<body>
    <div class="admin-container">
        <!-- Header -->
        <div class="admin-header">
            <button class="btn btn-back" onclick="handleBack()">
                <i class="bi bi-arrow-left me-2"></i>
                Back to Home
            </button>
            <h1 class="page-title display-5 fw-bold">Admin Dashboard</h1>
            <p class="page-subtitle">Manage users, menu items, and orders</p>
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
                                                    <button class='btn btn-action'>
                                                        <i class='bi bi-pencil'></i>
                                                    </button>
                                                    <button class='btn btn-action delete'>
                                                        <i class='bi bi-trash text-danger'></i>
                                                    </button>
                                                </div>
                                            </td>";
                                            echo "</tr>";
                                        }
                                    }
                                    ?>
                                    <!-- <tr>
                                        <td>1</td>
                                        <td>Ahmad Rizki</td>
                                        <td>ahmad.rizki@email.com</td>
                                        <td>081234567890</td>
                                        <td>2024-01-15</td>
                                        <td class="text-end">
                                            <button class="btn btn-action">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-action delete">
                                                <i class="bi bi-trash text-danger"></i>
                                            </button>
                                        </td>
                                    </tr> -->
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
                                            echo "<td>".$row['name']."</td>";
                                            echo "<td>".$row['category']."</td>";
                                            echo "<td>".$row['price']."</td>";
                                            echo "<td>".$row['description']."</td>";
                                            echo "<td>
                                                <div class='text-end'>
                                                    <button class='btn btn-action'>
                                                        <i class='bi bi-pencil'></i>
                                                    </button>
                                                    <button class='btn btn-action delete'>
                                                        <i class='bi bi-trash text-danger'></i>
                                                    </button>
                                                </div>
                                            </td>";
                                            echo "</tr>";
                                        }
                                    }
                                    ?>
                                    <!-- <tr>
                                        <td>1</td>
                                        <td>Kopi Aceh Gayo</td>
                                        <td>Coffee</td>
                                        <td>Rp 25.000</td>
                                        <td><span class="badge badge-status badge-available">Available</span></td>
                                        <td><span class="badge badge-popular">Popular</span></td>
                                        <td class="text-end">
                                            <button class="btn btn-action">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-action delete">
                                                <i class="bi bi-trash text-danger"></i>
                                            </button>
                                        </td>
                                    </tr> -->
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
                                        <th>Items</th>
                                        <th>Total</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>ORD-001</td>
                                        <td>Ahmad Rizki</td>
                                        <td class="text-truncate-custom">Kopi Aceh Gayo (2), Croissant (1)</td>
                                        <td>Rp 68.000</td>
                                        <td>Dine-in</td>
                                        <td><span class="badge badge-status badge-completed">Completed</span></td>
                                        <td>2024-11-10</td>
                                        <td class="text-end">
                                            <button class="btn btn-action">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-action delete">
                                                <i class="bi bi-trash text-danger"></i>
                                            </button>
                                        </td>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    function handleBack() {
        window.location.href = 'dashboard.php';
    }

    function handleAddMenu() {
        window.location.href = 'formMenuAdmin.php';
    }
    </script>
</body>

</html>
<?php
session_start();
include 'env.php';

if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("location: ../login.php");
    exit();
}


$query = "SELECT cm.*, u.username, u.email as user_email FROM contact_messages cm LEFT JOIN users u ON cm.user_id = u.id_user ORDER BY cm.created_at DESC";
$result = $koneksi->query($query);
$contactMessages = [];
if ($result) {
    $contactMessages = $result->fetch_all(MYSQLI_ASSOC);
}

if (isset($_GET['delete_id'])) {
    $delete_id = $koneksi->real_escape_string($_GET['delete_id']);
    $delete_query = "DELETE FROM contact_messages WHERE id = '$delete_id'";
    if ($koneksi->query($delete_query)) {
        $success = "Pesan berhasil dihapus!";
        header("Location: logUser.php?success=" . urlencode($success));
        exit();
    } else {
        $error = "Gagal menghapus pesan.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Customer - Daun Hijau Cafe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

    .messages-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }

    .page-header {
        margin-bottom: 2rem;
    }

    .btn-back {
        background: none;
        border: 2px solid var(--primary-green);
        color: var(--primary-green);
        padding: 0.5rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        margin-bottom: 1rem;
    }

    .btn-back:hover {
        background-color: var(--primary-green);
        color: white;
        transform: translateY(-2px);
    }

    .page-title {
        color: var(--dark-green);
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .page-subtitle {
        color: #6c757d;
    }

    .stats-card {
        background: white;
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-item {
        text-align: center;
        padding: 1rem;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary-green);
        margin-bottom: 0.5rem;
    }

    .stat-label {
        color: #6c757d;
        font-weight: 600;
    }

    .message-card {
        background: white;
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
        border-left: 5px solid var(--primary-green);
    }

    .message-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    .message-header {
        padding: 1.5rem 1.5rem 0.5rem;
        border-bottom: 1px solid #e9ecef;
    }

    .message-body {
        padding: 1rem 1.5rem;
    }

    .message-footer {
        padding: 0.5rem 1.5rem 1.5rem;
        border-top: 1px solid #e9ecef;
        background: #f8f9fa;
        border-bottom-left-radius: 15px;
        border-bottom-right-radius: 15px;
    }

    .user-avatar {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, var(--primary-green), var(--dark-green));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.2rem;
    }

    .message-meta {
        flex: 1;
    }

    .sender-name {
        font-weight: 700;
        color: var(--dark-green);
        margin-bottom: 0.25rem;
    }

    .sender-email {
        color: #6c757d;
        font-size: 0.9rem;
    }

    .message-date {
        color: #6c757d;
        font-size: 0.85rem;
    }

    .message-content {
        line-height: 1.6;
        color: #495057;
        white-space: pre-wrap;
    }

    .badge-custom {
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .badge-registered {
        background-color: var(--light-green);
        color: var(--dark-green);
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

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        color: #dee2e6;
    }

    .filter-buttons {
        margin-bottom: 2rem;
    }

    .btn-filter {
        border: 2px solid #dee2e6;
        background: white;
        color: #6c757d;
        padding: 0.5rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        margin-right: 0.5rem;
        transition: all 0.3s ease;
    }

    .btn-filter.active {
        background: var(--primary-green);
        border-color: var(--primary-green);
        color: white;
    }

    .btn-filter:hover {
        border-color: var(--primary-green);
        color: var(--primary-green);
    }

    @media (max-width: 768px) {
        .messages-container {
            padding: 1rem 0.5rem;
        }

        .message-header {
            padding: 1rem 1rem 0.5rem;
        }

        .message-body {
            padding: 0.75rem 1rem;
        }

        .message-footer {
            padding: 0.5rem 1rem 1rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }
    }
    </style>
</head>

<body>
    <div class="messages-container">
        <!-- Header -->
        <div class="page-header">
            <button class="btn btn-back" onclick="handleBack()">
                <i class="bi bi-arrow-left me-2"></i>
                Kembali ke Dashboard
            </button>
            <h1 class="page-title display-5 fw-bold">Pesan Customer</h1>
            <p class="page-subtitle">Kelola semua pesan dan feedback dari customer</p>
        </div>

        <!-- Success/Error Messages -->
        <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?php echo htmlspecialchars($_GET['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?php echo $error; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <!-- Statistics -->
        <div class="stats-card">
            <div class="row">
                <div class="col-md-6">
                    <div class="stat-item">
                        <div class="stat-number"><?php echo count($contactMessages); ?></div>
                        <div class="stat-label">Total Pesan</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="stat-item">
                        <div class="stat-number">
                            <?php 
                            $registeredCount = 0;
                            foreach ($contactMessages as $msg) {
                                if ($msg['user_id']) $registeredCount++;
                            }
                            echo $registeredCount;
                            ?>
                        </div>
                        <div class="stat-label">User Terdaftar</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Buttons -->
        <div class="filter-buttons">
            <button class="btn btn-filter active" onclick="filterMessages('all')">Semua Pesan</button>
            <button class="btn btn-filter" onclick="filterMessages('registered')">User Terdaftar</button>
        </div>

        <!-- Messages List -->
        <div id="messagesList">
            <?php if (empty($contactMessages)): ?>
            <div class="empty-state">
                <i class="bi bi-chat-square-text"></i>
                <h4>Belum ada pesan</h4>
                <p>Belum ada customer yang mengirimkan pesan.</p>
            </div>
            <?php else: ?>
            <?php foreach ($contactMessages as $message): ?>
            <div class="message-card" data-type="registered">
                <div class="message-header">
                    <div class="d-flex align-items-start">
                        <div class="user-avatar me-3">
                            <?php echo strtoupper(substr($message['name'], 0, 1)); ?>
                        </div>
                        <div class="message-meta">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="sender-name">
                                        <?php echo htmlspecialchars($message['name']); ?>
                                        <span class="badge badge-custom badge-registered ms-1">
                                            <i class="bi bi-person-check me-1"></i>User Terdaftar
                                        </span>
                                    </div>
                                    <div class="sender-email">
                                        <?php echo htmlspecialchars($message['email']); ?>
                                        <?php if ($message['user_id'] && $message['user_email']): ?>
                                        <small class="text-muted">
                                            (<?php echo htmlspecialchars($message['user_email']); ?>)
                                        </small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <div class="message-date">
                                        <i class="bi bi-clock me-1"></i>
                                        <?php echo date('d M Y H:i', strtotime($message['created_at'])); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="message-body">
                    <div class="message-content">
                        <?php echo nl2br(htmlspecialchars($message['message'])); ?>
                    </div>
                </div>

                <div class="message-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                User ID: <?php echo $message['user_id']; ?>
                            </small>
                        </div>
                        <div class="action-buttons">
                            <a href="mailto:<?php echo htmlspecialchars($message['email']); ?>" class="btn btn-action"
                                title="Balas via Email">
                                <i class="bi bi-reply"></i>
                            </a>

                            <a href="pesanUser.php?delete_id=<?php echo $message['id']; ?>"
                                class="btn btn-action delete"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus pesan ini?')"
                                title="Hapus Pesan">
                                <i class="bi bi-trash"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    function handleBack() {
        window.location.href = 'dashboardAdmin.php';
    }

    function filterMessages(type) {
        const messages = document.querySelectorAll('.message-card');
        const filterButtons = document.querySelectorAll('.btn-filter');

        // Update active button
        filterButtons.forEach(btn => btn.classList.remove('active'));
        event.target.classList.add('active');

        // Filter messages
        messages.forEach(message => {
            switch (type) {
                case 'all':
                    message.style.display = 'block';
                    break;
                case 'registered':
                    message.style.display = 'block'; // Semua pesan sekarang dari user terdaftar
                    break;
            }
        });
    }

    // Auto-hide alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });
    });
    </script>
</body>

</html>
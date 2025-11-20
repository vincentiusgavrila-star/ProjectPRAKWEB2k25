<?php 
include 'env.php';
session_start();

$contact_success = '';
$contact_error = '';

if (isset($_SESSION['success'])) {
    $contact_success = $_SESSION['success'];
    unset($_SESSION['success']);
}

if (isset($_SESSION['error'])) {
    $contact_error = $_SESSION['error'];
    unset($_SESSION['error']);
}

if (isset($_SESSION['contact_errors'])) {
    $contact_errors = $_SESSION['contact_errors'];
    unset($_SESSION['contact_errors']);
}


if(isset($_GET['pesan'])){
    $notif = $_GET['pesan'];
        if ($notif == "gagal") {
            echo"<script>alert('Login Dulu')</script>";
        } elseif ($notif == "logout") {
            echo"<script>alert('Logout')</script>";
        } elseif ($notif == "belum") {
            echo"<script>alert('Login Dulu')</script>";
        } elseif($notif == "reset"){
            unset($_SESSION['username']);
    }
}

function getMenuItems($koneksi, $category) {
    $stmt = $koneksi->prepare("SELECT * FROM products WHERE category = ? ORDER BY name");
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();

    $items = [];
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }

    $stmt->close();
    return $items;
}

$coffeeItems = getMenuItems($koneksi, 'coffee');
$nonCoffeeItems = getMenuItems($koneksi, 'minuman');
$foodItems = getMenuItems($koneksi, 'makanan');

$isLoggedIn = isset($_SESSION['username']);
$userName = '';
$userEmail = '';

if ($isLoggedIn) {
    $userName = $_SESSION['username'];
    $userEmail = isset($_SESSION['email']) ? $_SESSION['email'] : '';

    if (empty($userEmail) && isset($_SESSION['user_id'])) {
        $stmt = $koneksi->prepare("SELECT email FROM users WHERE id_user = ?");
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($userData = $result->fetch_assoc()) {
            $userEmail = $userData['email'];
        }
        $stmt->close();
    }
}
?>


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
        border: 2px solid #198754;
        color: #198754;
        background: none;
        transition: all 0.3s ease;
        padding: 10px 20px;
        font-weight: 600;
        border-radius: 8px;
        margin: 0 4px;
    }

    .btn-login:hover {
        /* background-color: rgba(25, 135, 84, 0.1); */
        background-color: #198754;
        color: white;
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

    .menu-section {
        background: white;
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

    .section-description {
        color: #6c757d;
        max-width: 600px;
        margin: 0 auto 2rem;
    }

    .menu-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        height: 100%;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .menu-card:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        transform: translateY(-5px);
    }

    .menu-card-body {
        padding: 1.5rem;
    }

    .menu-item-header {
        display: flex;
        justify-content: between;
        align-items: flex-start;
        margin-bottom: 0.75rem;
    }

    .menu-item-name {
        color: #212529;
        font-weight: 600;
        font-size: 1.1rem;
        margin: 0;
        flex: 1;
    }

    .menu-item-price {
        color: #198754;
        font-weight: 700;
        font-size: 1.1rem;
        white-space: nowrap;
        margin-left: 1rem;
    }

    .menu-item-description {
        color: #6c757d;
        line-height: 1.5;
        margin: 0;
    }

    .nav-tabs-custom {
        border: none;
        justify-content: center;
        margin-bottom: 3rem;
    }

    .nav-tabs-custom .nav-link {
        border: 2px solid #e9ecef;
        border-radius: 50px;
        padding: 0.75rem 2rem;
        margin: 0 0.5rem;
        color: #6c757d;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .nav-tabs-custom .nav-link:hover {
        border-color: #198754;
        color: #198754;
    }

    .nav-tabs-custom .nav-link.active {
        background: linear-gradient(135deg, #198754, #155724);
        border-color: #198754;
        color: white;
    }

    .btn-order-now {
        background: linear-gradient(135deg, #198754, #155724);
        border: none;
        color: white;
        padding: 0.75rem 2rem;
        font-weight: 600;
        border-radius: 50px;
        transition: all 0.3s ease;
        margin-bottom: 2rem;
    }

    .btn-order-now:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(25, 135, 84, 0.3);
    }

    .tab-content {
        margin-top: 2rem;
    }

    @media (max-width: 768px) {
        .nav-tabs-custom .nav-link {
            padding: 0.5rem 1rem;
            margin: 0.25rem;
            font-size: 0.9rem;
        }

        .menu-section {
            padding: 3rem 0;
        }
    }

    .news-section {
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

    .section-description {
        color: #6c757d;
        max-width: 600px;
        margin: 0 auto 2rem;
    }

    .news-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        overflow: hidden;
        height: 100%;
    }

    .news-card:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        transform: translateY(-5px);
    }

    .news-image {
        height: 200px;
        overflow: hidden;
        position: relative;
    }

    .news-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .news-card:hover .news-image img {
        transform: scale(1.05);
    }

    .news-content {
        padding: 1.5rem;
    }

    .news-date {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #198754;
        font-size: 0.9rem;
        margin-bottom: 1rem;
        font-weight: 500;
    }

    .news-title {
        color: #212529;
        font-weight: 600;
        font-size: 1.2rem;
        margin-bottom: 1rem;
        line-height: 1.4;
    }

    .news-description {
        color: #6c757d;
        line-height: 1.6;
        margin: 0;
    }

    .news-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #e9ecef;
    }

    @media (max-width: 768px) {
        .news-section {
            padding: 3rem 0;
        }

        .news-image {
            height: 180px;
        }
    }

    .contact-section {
        background: white;
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

    .section-description {
        color: #6c757d;
        max-width: 600px;
        margin: 0 auto 2rem;
    }

    .contact-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .contact-card:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        transform: translateY(-2px);
    }

    .contact-form-card {
        height: 100%;
    }

    .form-label {
        color: #495057;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .form-control,
    .form-select {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 12px 16px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #198754;
        box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25);
    }

    textarea.form-control {
        resize: vertical;
        min-height: 120px;
    }

    .btn-contact {
        background: linear-gradient(135deg, #198754, #155724);
        border: none;
        color: white;
        padding: 14px 28px;
        font-weight: 600;
        border-radius: 12px;
        transition: all 0.3s ease;
        font-size: 1.1rem;
        width: 100%;
    }

    .btn-contact:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(25, 135, 84, 0.3);
        background: linear-gradient(135deg, #157347, #198754);
    }

    .contact-info-card {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1.5rem;
        margin-bottom: 1rem;
    }

    .contact-icon {
        background-color: #d1e7dd;
        padding: 12px;
        border-radius: 12px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .contact-icon i {
        font-size: 1.25rem;
        color: #198754;
    }

    .contact-info-content h5 {
        color: #212529;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .contact-info-content p {
        color: #6c757d;
        margin: 0;
    }

    .map-container {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        margin-top: 1.5rem;
    }

    .map-container iframe {
        display: block;
        border: none;
    }

    .form-success {
        background: linear-gradient(135deg, #d3f9d8, #b2f2bb);
        border: 2px solid #51cf66;
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        color: #2b8a3e;
        font-weight: 600;
        display: none;
    }

    .login-required {
        background: linear-gradient(135deg, #fff3cd, #ffeaa7);
        border: 2px solid #ffc107;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .login-required-icon {
        font-size: 3rem;
        color: #ffc107;
        margin-bottom: 1rem;
    }

    .login-required h4 {
        color: #856404;
        margin-bottom: 1rem;
    }

    .login-required p {
        color: #856404;
        margin-bottom: 1.5rem;
    }

    .btn-login-required {
        background: linear-gradient(135deg, #198754, #155724);
        border: none;
        color: white;
        padding: 12px 24px;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn-login-required:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(25, 135, 84, 0.3);
        color: white;
    }

    @media (max-width: 768px) {
        .contact-section {
            padding: 3rem 0;
        }

        .contact-info-card {
            padding: 1rem;
        }

        .map-container {
            height: 250px;
        }
    }

    .footer {
        background: linear-gradient(135deg, #155724, #198754);
        color: white;
        padding: 3rem 0 1rem;
    }

    .footer-brand {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .footer-logo {
        background-color: #198754;
        padding: 0.5rem;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .footer-logo i {
        font-size: 1.5rem;
        color: white;
    }

    .footer-brand h3 {
        color: white;
        margin: 0;
        font-weight: 700;
    }

    .footer-description {
        color: #c6f6d5;
        margin-bottom: 1.5rem;
        line-height: 1.6;
    }

    .social-links {
        display: flex;
        gap: 0.75rem;
    }

    .social-link {
        background-color: #0f5132;
        padding: 0.75rem;
        border-radius: 8px;
        color: white;
        text-decoration: none;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .social-link:hover {
        background-color: #198754;
        transform: translateY(-2px);
        color: white;
    }

    .social-link i {
        font-size: 1.25rem;
    }

    .footer-heading {
        color: white;
        font-weight: 600;
        margin-bottom: 1rem;
        font-size: 1.1rem;
    }

    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-links li {
        margin-bottom: 0.5rem;
    }

    .footer-links a {
        color: #c6f6d5;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .footer-links a:hover {
        color: white;
    }

    .contact-info {
        list-style: none;
        padding: 0;
        margin: 0;
        color: #c6f6d5;
    }

    .contact-info li {
        margin-bottom: 0.5rem;
        line-height: 1.5;
    }

    .footer-divider {
        border-top: 1px solid #0f5132;
        margin: 2rem 0 1rem;
    }

    .footer-copyright {
        color: #c6f6d5;
        text-align: center;
        margin: 0;
    }

    .back-to-top {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        background: linear-gradient(135deg, #198754, #155724);
        color: white;
        border: none;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        z-index: 1000;
    }

    .back-to-top:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        color: white;
    }

    @media (max-width: 768px) {
        .footer {
            padding: 2rem 0 1rem;
        }

        .footer-brand {
            justify-content: center;
            text-align: center;
        }

        .social-links {
            justify-content: center;
        }

        .back-to-top {
            bottom: 1rem;
            right: 1rem;
            width: 45px;
            height: 45px;
        }
    }

    .navbar-nav .d-flex.align-items-center {
        gap: 12px;
    }

    .user-info-container {
        background-color: rgba(25, 135, 84, 0.1);
        padding: 8px 12px;
        border-radius: 8px;
        border: 1px solid rgba(25, 135, 84, 0.2);
    }

    .user-info-text {
        color: #155724;
        font-weight: 600;
        font-size: 0.9rem;
    }

    @media (min-width: 992px) {
        .navbar-nav .nav-link-custom {
            margin: 0 6px;
        }

        .navbar-nav .d-flex.align-items-center {
            margin-left: 20px;
            padding-left: 20px;
            border-left: 1px solid #e5e7eb;
        }
    }


    @media (max-width: 991.98px) {
        .mobile-auth-section .rounded {
            margin: 0 -0.75rem;
        }
    }


    .user-info-container:hover {
        background-color: rgba(25, 135, 84, 0.15);
        transition: all 0.3s ease;
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

                    <!-- Auth Buttons -->
                    <div class="d-flex align-items-center ms-3">
                        <?php if ($isLoggedIn): ?>
                        <!-- User Info dengan Layout yang Lebih Baik -->
                        <div class="d-flex align-items-center me-3 p-2 rounded"
                            style="background-color: rgba(25, 135, 84, 0.1);">
                            <i class="bi bi-person-circle me-2 text-success"></i>
                            <span class="text-dark fw-medium"><?php echo htmlspecialchars($userName); ?></span>
                        </div>
                        <a href="logout.php" class="btn btn-login d-flex align-items-center">
                            <i class="bi bi-box-arrow-right me-1"></i>
                            Logout
                        </a>
                        <?php else: ?>
                        <button class="btn-login me-2" onclick="handleLoginClick()" id="loginButton">
                            Masuk
                        </button>
                        <?php endif; ?>
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

                <!-- Auth Buttons -->
                <div class="mobile-auth-section">
                    <?php if ($isLoggedIn): ?>
                    <!-- User Info di Mobile -->
                    <div class="text-center mb-3 p-3 rounded" style="background-color: rgba(25, 135, 84, 0.1);">
                        <i class="bi bi-person-circle me-2 text-success"></i>
                        <strong><?php echo htmlspecialchars($userName); ?></strong>
                    </div>
                    <a href="logout.php"
                        class="mobile-btn-login py-3 text-center d-flex align-items-center justify-content-center">
                        <i class="bi bi-box-arrow-right me-2"></i>
                        Logout
                    </a>
                    <?php else: ?>
                    <button class="mobile-btn-login py-3" onclick="handleLoginClick()">
                        Masuk
                    </button>
                    <?php endif; ?>
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
                    <a href="menuUser.php" class="btn btn-custom-green btn-lg">
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
        <section id="menu" class="menu-section">
            <div class="container">
                <!-- Header Section -->
                <div class="text-center mb-5">
                    <h2 class="section-title display-4 fw-bold">Menu Kami</h2>
                    <div class="title-divider"></div>
                    <p class="section-description">
                        Nikmati berbagai pilihan kopi, minuman, dan makanan yang lezat
                    </p>
                    <button class="btn btn-order-now" onclick="handleOrderNow()">
                        <i class="bi bi-cart me-2"></i>
                        Pesan Sekarang
                    </button>
                </div>

                <!-- Tabs Navigation -->
                <ul class="nav nav-tabs nav-tabs-custom" id="menuTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="coffee-tab" data-bs-toggle="tab" data-bs-target="#coffee"
                            type="button" role="tab">
                            Coffee (<?php echo count($coffeeItems); ?>)
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="non-coffee-tab" data-bs-toggle="tab" data-bs-target="#non-coffee"
                            type="button" role="tab">
                            Non-Coffee (<?php echo count($nonCoffeeItems); ?>)
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="food-tab" data-bs-toggle="tab" data-bs-target="#food" type="button"
                            role="tab">
                            Foods & Snacks (<?php echo count($foodItems); ?>)
                        </button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content" id="menuTabsContent">
                    <!-- Coffee Tab -->
                    <div class="tab-pane fade show active" id="coffee" role="tabpanel">
                        <div class="row g-4">
                            <?php if (empty($coffeeItems)): ?>
                            <div class="col-12">
                                <div class="empty-state">
                                    <i class="bi bi-cup"></i>
                                    <h5>Belum ada menu coffee</h5>
                                    <p>Silakan tambahkan menu coffee melalui panel admin</p>
                                </div>
                            </div>
                            <?php else: ?>
                            <?php foreach ($coffeeItems as $item): ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="card menu-card">
                                    <div class="card-body menu-card-body">
                                        <div class="menu-item-header">
                                            <h5 class="menu-item-name"><?php echo htmlspecialchars($item['name']); ?>
                                            </h5>
                                            <div class="menu-item-price">Rp
                                                <?php echo number_format($item['price'], 0, ',', '.'); ?></div>
                                        </div>
                                        <p class="menu-item-description">
                                            <?php echo htmlspecialchars($item['description']); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Non-Coffee Tab -->
                    <div class="tab-pane fade" id="non-coffee" role="tabpanel">
                        <div class="row g-4">
                            <?php if (empty($nonCoffeeItems)): ?>
                            <div class="col-12">
                                <div class="empty-state">
                                    <i class="bi bi-cup-straw"></i>
                                    <h5>Belum ada menu non-coffee</h5>
                                    <p>Silakan tambahkan menu minuman melalui panel admin</p>
                                </div>
                            </div>
                            <?php else: ?>
                            <?php foreach ($nonCoffeeItems as $item): ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="card menu-card">
                                    <div class="card-body menu-card-body">
                                        <div class="menu-item-header">
                                            <h5 class="menu-item-name"><?php echo htmlspecialchars($item['name']); ?>
                                            </h5>
                                            <div class="menu-item-price">Rp
                                                <?php echo number_format($item['price'], 0, ',', '.'); ?></div>
                                        </div>
                                        <p class="menu-item-description">
                                            <?php echo htmlspecialchars($item['description']); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Food Tab -->
                    <div class="tab-pane fade" id="food" role="tabpanel">
                        <div class="row g-4">
                            <?php if (empty($foodItems)): ?>
                            <div class="col-12">
                                <div class="empty-state">
                                    <i class="bi bi-egg-fried"></i>
                                    <h5>Belum ada menu makanan</h5>
                                    <p>Silakan tambahkan menu makanan melalui panel admin</p>
                                </div>
                            </div>
                            <?php else: ?>
                            <?php foreach ($foodItems as $item): ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="card menu-card">
                                    <div class="card-body menu-card-body">
                                        <div class="menu-item-header">
                                            <h5 class="menu-item-name"><?php echo htmlspecialchars($item['name']); ?>
                                            </h5>
                                            <div class="menu-item-price">Rp
                                                <?php echo number_format($item['price'], 0, ',', '.'); ?></div>
                                        </div>
                                        <p class="menu-item-description">
                                            <?php echo htmlspecialchars($item['description']); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- News Section -->
        <section id="news" class="news-section">
            <div class="container">
                <!-- Header Section -->
                <div class="text-center mb-5">
                    <h2 class="section-title display-4 fw-bold">Berita & Update</h2>
                    <div class="title-divider"></div>
                    <p class="section-description">
                        Ikuti berita terbaru dan event dari Daun Hijau Cafe
                    </p>
                </div>

                <!-- News Grid -->
                <div class="row g-4">
                    <!-- News Item 1 -->
                    <div class="col-md-6 col-lg-4">
                        <div class="card news-card">
                            <div class="news-image">
                                <img src="https://images.unsplash.com/photo-1521017432531-fbd92d768814?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxjb2ZmZWUlMjBzaG9wJTIwaW50ZXJpb3J8ZW58MXx8fHwxNzYxNDgwMzI4fDA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral"
                                    alt="Grand Opening Cabang Baru">
                            </div>
                            <div class="news-content">
                                <div class="news-date">
                                    <i class="bi bi-calendar"></i>
                                    <span>15 Oktober 2025</span>
                                </div>
                                <h4 class="news-title">Grand Opening Cabang Baru</h4>
                                <p class="news-description">
                                    Daun Hijau Cafe membuka cabang baru di Depok, Yogyakarta dengan konsep yang lebih
                                    luas dan
                                    nyaman.
                                </p>

                            </div>
                        </div>
                    </div>

                    <!-- News Item 2 -->
                    <div class="col-md-6 col-lg-4">
                        <div class="card news-card">
                            <div class="news-image">
                                <img src="https://images.unsplash.com/photo-1628394726060-37cc4da4cf03?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxjYWZlJTIwZm9vZCUyMHBhc3RyeXxlbnwxfHx8fDE3NjE0ODE0Njd8MA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral"
                                    alt="Menu Spesial Musim Hujan">
                            </div>
                            <div class="news-content">
                                <div class="news-date">
                                    <i class="bi bi-calendar"></i>
                                    <span>1 Oktober 2025</span>
                                </div>
                                <h4 class="news-title">Menu Spesial Musim Hujan</h4>
                                <p class="news-description">
                                    Coba menu spesial kami untuk musim hujan: Hot Ginger Coffee dan Pisang Goreng
                                    Cokelat.
                                </p>

                            </div>
                        </div>
                    </div>

                    <!-- News Item 3 -->
                    <div class="col-md-6 col-lg-4">
                        <div class="card news-card">
                            <div class="news-image">
                                <img src="https://images.unsplash.com/photo-1650100458608-824a54559caa?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxjb2ZmZWUlMjBiZWFucyUyMGVzcHJlc3NvfGVufDF8fHx8MTc2MTQ0MTU3Mnww&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral"
                                    alt="Workshop Brewing Kopi">
                            </div>
                            <div class="news-content">
                                <div class="news-date">
                                    <i class="bi bi-calendar"></i>
                                    <span>20 September 2025</span>
                                </div>
                                <h4 class="news-title">Workshop Brewing Kopi</h4>
                                <p class="news-description">
                                    Ikuti workshop brewing kopi bersama barista profesional kami setiap akhir pekan.
                                </p>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="contact-section">
            <div class="container">
                <!-- Header Section -->
                <div class="text-center mb-5">
                    <h2 class="section-title display-4 fw-bold">Hubungi Kami</h2>
                    <div class="title-divider"></div>
                    <p class="section-description">
                        Ada pertanyaan atau ingin memberikan saran? Kami siap mendengar dari Anda
                    </p>
                </div>

                <!-- Success/Error Messages -->
                <?php if (!empty($contact_success)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <?php echo htmlspecialchars($contact_success); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <?php if (!empty($contact_error)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <?php echo htmlspecialchars($contact_error); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <?php if (isset($contact_errors) && !empty($contact_errors)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <ul class="mb-0">
                        <?php foreach ($contact_errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <div class="row g-4">
                    <!-- Contact Form -->
                    <div class="col-lg-6">
                        <?php if (!$isLoggedIn): ?>
                        <!-- Login Required Message -->
                        <div class="login-required">
                            <div class="login-required-icon">
                                <i class="bi bi-person-x"></i>
                            </div>
                            <h4>Login Diperlukan</h4>
                            <p>Anda harus login terlebih dahulu untuk dapat mengirim pesan kepada kami.</p>
                            <a href="login.php" class="btn btn-login-required">
                                <i class="bi bi-box-arrow-in-right me-2"></i>
                                Login Sekarang
                            </a>
                        </div>
                        <?php else: ?>
                        <!-- Contact Form (Only for logged in users) -->
                        <div class="card contact-card contact-form-card">
                            <div class="card-body p-4">
                                <div class="alert alert-info mb-4">
                                    <i class="bi bi-info-circle me-2"></i>
                                    Anda login sebagai <strong><?php echo htmlspecialchars($userName); ?></strong>.
                                    Form akan terisi otomatis dengan data profil Anda.
                                </div>
                                <form id="contactForm" method="POST" action="prosesPesan.php">
                                    <div class="mb-4">
                                        <label for="name" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="<?php echo htmlspecialchars($userName); ?>" readonly>
                                        <small class="text-muted">Nama diambil dari profil Anda</small>
                                    </div>

                                    <div class="mb-4">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="<?php echo htmlspecialchars($userEmail); ?>" readonly>
                                        <small class="text-muted">Email diambil dari profil Anda</small>
                                    </div>

                                    <div class="mb-4">
                                        <label for="message" class="form-label">Pesan</label>
                                        <textarea class="form-control" id="message" name="message" rows="6"
                                            placeholder="Tulis pesan Anda di sini..." required></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-contact">
                                        <i class="bi bi-send me-2"></i>
                                        Kirim Pesan
                                    </button>
                                </form>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Contact Information -->
                    <div class="col-lg-6">
                        <!-- Contact Info Cards -->
                        <div class="card contact-card">
                            <div class="card-body p-0">
                                <!-- Alamat -->
                                <div class="contact-info-card">
                                    <div class="contact-icon">
                                        <i class="bi bi-geo-alt"></i>
                                    </div>
                                    <div class="contact-info-content">
                                        <h5>Alamat</h5>
                                        <p>Seturan, Yogyakarta, Indonesia</p>
                                    </div>
                                </div>

                                <!-- Telepon -->
                                <div class="contact-info-card">
                                    <div class="contact-icon">
                                        <i class="bi bi-telephone"></i>
                                    </div>
                                    <div class="contact-info-content">
                                        <h5>Telepon</h5>
                                        <p>+62 812-3456-7890</p>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="contact-info-card">
                                    <div class="contact-icon">
                                        <i class="bi bi-envelope"></i>
                                    </div>
                                    <div class="contact-info-content">
                                        <h5>Email</h5>
                                        <p>hello@daunhijau.cafe</p>
                                    </div>
                                </div>

                                <!-- Jam Buka -->
                                <div class="contact-info-card">
                                    <div class="contact-icon">
                                        <i class="bi bi-clock"></i>
                                    </div>
                                    <div class="contact-info-content">
                                        <h5>Jam Buka</h5>
                                        <p>Senin - Minggu: 08.00 - 22.00 WIB</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Map -->
                        <div class="map-container">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.2886889191843!2d110.40976931477668!3d-7.753964594389584!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a59bda325e5f1%3A0x60fd0f56e6e1c239!2sSeturan%2C%20Caturtunggal%2C%20Kec.%20Depok%2C%20Kabupaten%20Sleman%2C%20Daerah%20Istimewa%20Yogyakarta!5e0!3m2!1sen!2sid!4v1698234567890"
                                width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade" title="Daun Hijau Cafe Location">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Footer -->
        <footer class="footer">
            <div class="container">
                <div class="row g-4">
                    <!-- Brand Section -->
                    <div class="col-lg-6">
                        <div class="footer-brand">
                            <div class="footer-logo">
                                <i class="bi bi-cup-hot"></i>
                            </div>
                            <h3>Daun Hijau Cafe</h3>
                        </div>
                        <p class="footer-description">
                            Menghadirkan pengalaman kopi Indonesia yang autentik dengan cita rasa yang kaya dan suasana
                            yang hangat.
                        </p>
                        <div class="social-links">
                            <a href="#" class="social-link" aria-label="Facebook">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="#" class="social-link" aria-label="Instagram">
                                <i class="bi bi-instagram"></i>
                            </a>
                            <a href="#" class="social-link" aria-label="Twitter">
                                <i class="bi bi-twitter"></i>
                            </a>
                            <a href="#" class="social-link" aria-label="TikTok">
                                <i class="bi bi-tiktok"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="col-lg-3 col-md-6">
                        <h4 class="footer-heading">Link Cepat</h4>
                        <ul class="footer-links">
                            <li>
                                <a href="#home" class="smooth-scroll">Home</a>
                            </li>
                            <li>
                                <a href="#about" class="smooth-scroll">Tentang Kami</a>
                            </li>
                            <li>
                                <a href="#menu" class="smooth-scroll">Menu</a>
                            </li>
                            <li>
                                <a href="#news" class="smooth-scroll">Berita</a>
                            </li>
                            <li>
                                <a href="#contact" class="smooth-scroll">Kontak</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div class="col-lg-3 col-md-6">
                        <h4 class="footer-heading">Kontak</h4>
                        <ul class="contact-info">
                            <li>
                                <i class="bi bi-geo-alt me-2"></i>
                                Seturan, Yogyakarta
                            </li>
                            <li>Indonesia</li>
                            <li>
                                <i class="bi bi-telephone me-2"></i>
                                +62 812-3456-7890
                            </li>
                            <li>
                                <i class="bi bi-envelope me-2"></i>
                                hello@daunhijau.cafe
                            </li>
                            <li>
                                <i class="bi bi-clock me-2"></i>
                                Setiap Hari: 08.00 - 22.00
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Divider -->
                <div class="footer-divider"></div>

                <!-- Copyright -->
                <div class="row">
                    <div class="col-12">
                        <p class="footer-copyright">
                            &copy; 2025 Daun Hijau Cafe. All rights reserved. |
                            <a href="#" class="text-decoration-none text-light ms-1">Privacy Policy</a> |
                            <a href="#" class="text-decoration-none text-light ms-1">Terms of Service</a>
                        </p>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Back to Top Button -->
        <a href="#home" class="back-to-top smooth-scroll">
            <i class="bi bi-arrow-up"></i>
        </a>
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
        if (orderButton) orderButton.classList.remove('active');
        if (loginButton) loginButton.classList.remove('active');
        if (signupButton) signupButton.classList.remove('active');

        // Add active class based on current page
        switch (currentPage) {
            case 'order':
                if (orderButton) orderButton.classList.add('active');
                break;
            case 'login':
                if (loginButton) loginButton.classList.add('active');
                break;
            case 'signup':
                if (signupButton) signupButton.classList.add('active');
                break;
        }
    }

    // Event listener untuk logo
    document.querySelector('.logo-container').addEventListener('click', function() {
        handleNavClick('home');
    });

    // Initialize active state
    updateActiveState();

    function handleOrderNow() {
        // Redirect ke halaman order atau tampilkan modal order
        // alert('Redirect ke halaman pemesanan...');
        window.location.href = 'menuUser.php';
    }

    // Contact form handling
    document.addEventListener('DOMContentLoaded', function() {
        const contactForm = document.getElementById('contactForm');

        if (contactForm) {
            contactForm.addEventListener('submit', function() {
                // Hanya tambah loading state, biarkan form submit normal
                const submitBtn = contactForm.querySelector('button[type="submit"]');
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Mengirim...';
                submitBtn.disabled = true;
            });
        }
    });
    // Optional: Add active state to menu cards on click
    document.addEventListener('DOMContentLoaded', function() {
        const menuCards = document.querySelectorAll('.menu-card');

        menuCards.forEach(card => {
            card.addEventListener('click', function() {
                // Remove active class from all cards
                menuCards.forEach(c => c.classList.remove('active'));
                // Add active class to clicked card
                this.classList.add('active');
            });
        });
        const smoothScrollLinks = document.querySelectorAll('.smooth-scroll');

        smoothScrollLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();

                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);

                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Show/hide back to top button based on scroll position
        const backToTopButton = document.querySelector('.back-to-top');

        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopButton.style.display = 'flex';
            } else {
                backToTopButton.style.display = 'none';
            }
        });

        // Initialize back to top button visibility
        backToTopButton.style.display = 'none';

        // Add loading animation to social links
        const socialLinks = document.querySelectorAll('.social-link');

        socialLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();

                // Add click animation
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 150);

                // Simulate social media redirect (replace with actual links)
                const platform = this.getAttribute('aria-label').toLowerCase();
                alert(`Redirecting to ${platform}...`);
                // window.location.href = this.href; // Uncomment for actual links
            });
        });
    });
    </script>
</body>

</html>
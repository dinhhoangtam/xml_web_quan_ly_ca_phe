<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Coffee Shop'; ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Work+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="<?php echo BASE_URL; ?>products" class="logo">
                <span class="logo-icon">☕</span>
                <span class="logo-text">COFFEE HOUSE</span>
            </a>
            
            <div class="nav-links">
                <a href="<?php echo BASE_URL; ?>products">Sản phẩm</a>
                
                <?php if (isLoggedIn()): ?>
                    <a href="<?php echo BASE_URL; ?>orders">Đơn hàng</a>
                    
                    <?php if (isAdmin()): ?>
                        <a href="<?php echo BASE_URL; ?>admin/dashboard">Quản trị</a>
                    <?php endif; ?>
                    
                    <a href="<?php echo BASE_URL; ?>cart" class="cart-link">
                        <span class="cart-icon">🛒</span>
                        <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                            <span class="cart-badge"><?php echo count($_SESSION['cart']); ?></span>
                        <?php endif; ?>
                    </a>
                    
                    <div class="user-menu">
                        <span class="user-name"><?php echo $_SESSION['user_name']; ?></span>
                        <a href="<?php echo BASE_URL; ?>logout" class="btn-logout">Đăng xuất</a>
                    </div>
                <?php else: ?>
                    <a href="<?php echo BASE_URL; ?>login" class="btn-primary">Đăng nhập</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <main class="main-content">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

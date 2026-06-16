<?php
// Controller thống kê

if (!isAdmin()) {
    redirect('login');
}

require_once BASE_PATH . '/app/Models/order.php';
require_once BASE_PATH . '/app/Models/product.php';
require_once BASE_PATH . '/app/Models/user.php';

$orderModel = new OrderModel();
$productModel = new ProductModel();
$userModel = new UserModel();

// Dashboard
if ($action === 'dashboard' || $action === 'index') {
    // Thống kê tổng quan
    $orderStats = $orderModel->getStats();
    $products = $productModel->getAll();
    $users = $userModel->getAll();
    $recentOrders = array_slice($orderModel->getAll(), -10, 10, true);
    
    require_once BASE_PATH . '/app/Views/admin/dashboard.php';
}

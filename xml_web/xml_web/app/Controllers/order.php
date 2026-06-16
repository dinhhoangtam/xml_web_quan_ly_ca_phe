<?php
// Controller đơn hàng

require_once BASE_PATH . '/app/Models/order.php';
require_once BASE_PATH . '/app/Models/product.php';

$orderModel = new OrderModel();
$productModel = new ProductModel();

// Giỏ hàng
if ($controller === 'cart') {
    // Thêm vào giỏ
    if ($action === 'add') {
        $productId = $_POST['product_id'] ?? '';
        $quantity = (int)($_POST['quantity'] ?? 1);
        
        $product = $productModel->getById($productId);
        
        if ($product) {
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
            
            if (isset($_SESSION['cart'][$productId])) {
                $_SESSION['cart'][$productId]['quantity'] += $quantity;
            } else {
                $_SESSION['cart'][$productId] = [
                    'id' => (string)$product->id,
                    'name' => (string)$product->name,
                    'price' => (float)$product->price,
                    'image' => (string)$product->image,
                    'quantity' => $quantity
                ];
            }
            
            $_SESSION['success'] = 'Đã thêm vào giỏ hàng!';
        }
        
        redirect('cart');
    }
    
    // Cập nhật giỏ
    if ($action === 'update') {
        $productId = $_POST['product_id'] ?? '';
        $quantity = (int)($_POST['quantity'] ?? 1);
        
        if (isset($_SESSION['cart'][$productId])) {
            if ($quantity > 0) {
                $_SESSION['cart'][$productId]['quantity'] = $quantity;
            } else {
                unset($_SESSION['cart'][$productId]);
            }
        }
        
        redirect('cart');
    }
    
    // Xóa khỏi giỏ
    if ($action === 'remove') {
        $productId = $_GET['id'] ?? '';
        
        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        }
        
        redirect('cart');
    }
    
    // Xóa toàn bộ giỏ
    if ($action === 'clear') {
        unset($_SESSION['cart']);
        redirect('cart');
    }
    
    // Hiển thị giỏ hàng
    if ($action === 'index' || empty($action)) {
        $cart = $_SESSION['cart'] ?? [];
        $total = 0;
        
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        require_once BASE_PATH . '/app/Views/orders/cart.php';
    }
}

// Thanh toán
if ($controller === 'checkout') {
    if (!isLoggedIn()) {
        $_SESSION['error'] = 'Vui lòng đăng nhập để thanh toán!';
        redirect('login');
    }
    
    $cart = $_SESSION['cart'] ?? [];
    
    if (empty($cart)) {
        $_SESSION['error'] = 'Giỏ hàng trống!';
        redirect('cart');
    }
    
    // Xử lý thanh toán
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user = getCurrentUser();
        
        $items = [];
        $total = 0;
        
        foreach ($cart as $item) {
            $items[] = [
                'product_id' => $item['id'],
                'product_name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'subtotal' => $item['price'] * $item['quantity']
            ];
            
            $total += $item['price'] * $item['quantity'];
            
            // Cập nhật tồn kho
            $productModel->updateStock($item['id'], $item['quantity']);
        }
        
        $orderData = [
            'user_id' => (string)$user->id,
            'customer_name' => $_POST['name'] ?? (string)$user->n,
            'customer_email' => $_POST['email'] ?? (string)$user->email,
            'customer_phone' => $_POST['phone'] ?? (string)$user->phone,
            'customer_address' => $_POST['address'] ?? (string)$user->address,
            'payment_method' => $_POST['payment_method'] ?? 'cod',
            'total_amount' => $total,
            'items' => $items
        ];
        
        $orderId = $orderModel->create($orderData);
        
        // Xóa giỏ hàng
        unset($_SESSION['cart']);
        
        $_SESSION['success'] = 'Đặt hàng thành công!';
        $_SESSION['order_id'] = $orderId;
        
        redirect('order/success');
    }
    
    // Hiển thị form thanh toán
    $user = getCurrentUser();
    $total = 0;
    
    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    
    require_once BASE_PATH . '/app/Views/orders/checkout.php';
}

// Đơn hàng thành công
if ($controller === 'order' && $action === 'success') {
    $orderId = $_SESSION['order_id'] ?? '';
    $order = $orderModel->getById($orderId);
    
    require_once BASE_PATH . '/app/Views/orders/order_success.php';
}

// Đơn hàng của tôi
if ($controller === 'orders' && $action === 'index') {
    if (!isLoggedIn()) {
        redirect('login');
    }
    
    $userId = $_SESSION['user_id'];
    $orders = $orderModel->getByUser($userId);
    
    require_once BASE_PATH . '/app/Views/orders/my_orders.php';
}

// Chi tiết đơn hàng
if ($controller === 'order' && $action === 'detail') {
    if (!isLoggedIn()) {
        redirect('login');
    }
    
    $orderId = $_GET['id'] ?? '';
    $order = $orderModel->getById($orderId);
    
    if (!$order) {
        $_SESSION['error'] = 'Đơn hàng không tồn tại!';
        redirect('orders');
    }
    
    // Kiểm tra quyền xem đơn hàng
    if (!isAdmin() && (string)$order->user_id !== $_SESSION['user_id']) {
        $_SESSION['error'] = 'Bạn không có quyền xem đơn hàng này!';
        redirect('orders');
    }
    
    require_once BASE_PATH . '/app/Views/orders/detail.php';
}

// Quản lý đơn hàng (Admin)
if ($controller === 'orders' && $action === 'manage') {
    if (!isAdmin()) {
        redirect('login');
    }
    
    $orders = $orderModel->getAll();
    
    require_once BASE_PATH . '/app/Views/orders/manage_orders.php';
}

// Cập nhật trạng thái (Admin)
if ($controller === 'order' && $action === 'update_status') {
    if (!isAdmin()) {
        redirect('login');
    }
    
    $orderId = $_POST['order_id'] ?? '';
    $status = $_POST['status'] ?? '';
    
    if ($orderModel->updateStatus($orderId, $status)) {
        $_SESSION['success'] = 'Cập nhật trạng thái thành công!';
    } else {
        $_SESSION['error'] = 'Có lỗi xảy ra!';
    }
    
    redirect('orders/manage');
}

// In hóa đơn
if ($controller === 'order' && $action === 'print') {
    $orderId = $_GET['id'] ?? '';
    $order = $orderModel->getById($orderId);
    
    if (!$order) {
        $_SESSION['error'] = 'Đơn hàng không tồn tại!';
        redirect('orders');
    }
    
    require_once BASE_PATH . '/app/Views/orders/print.php';
}

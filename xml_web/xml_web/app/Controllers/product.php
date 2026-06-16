<?php
// Controller sản phẩm

require_once BASE_PATH . '/app/Models/product.php';

$productModel = new ProductModel();

// Danh sách sản phẩm
if ($action === 'index') {
    $keyword = $_GET['search'] ?? '';
    $category = $_GET['category'] ?? '';
    
    if ($keyword) {
        $products = $productModel->search($keyword);
    } elseif ($category) {
        $products = $productModel->getByCategory($category);
    } else {
        $products = $productModel->getAll();
    }
    
    $categories = $productModel->getCategories();
    
    require_once BASE_PATH . '/app/Views/products/index.php';
}

// Chi tiết sản phẩm
if ($action === 'detail') {
    $id = $_GET['id'] ?? '';
    $product = $productModel->getById($id);
    
    if (!$product) {
        $_SESSION['error'] = 'Sản phẩm không tồn tại!';
        redirect('products');
    }
    
    require_once BASE_PATH . '/app/Views/products/detail.php';
}

// Thêm sản phẩm (Admin)
if ($action === 'add') {
    if (!isAdmin()) {
        redirect('login');
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'name' => $_POST['name'] ?? '',
            'price' => $_POST['price'] ?? 0,
            'description' => $_POST['description'] ?? '',
            'category' => $_POST['category'] ?? '',
            'image' => $_POST['image'] ?? '',
            'stock' => $_POST['stock'] ?? 0
        ];
        
        if ($productModel->add($data)) {
            $_SESSION['success'] = 'Thêm sản phẩm thành công!';
            redirect('products');
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra!';
        }
    }
    
    require_once BASE_PATH . '/app/Views/products/add.php';
}

// Sửa sản phẩm (Admin)
if ($action === 'edit') {
    if (!isAdmin()) {
        redirect('login');
    }
    
    $id = $_GET['id'] ?? '';
    $product = $productModel->getById($id);
    
    if (!$product) {
        $_SESSION['error'] = 'Sản phẩm không tồn tại!';
        redirect('products');
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'name' => $_POST['name'] ?? '',
            'price' => $_POST['price'] ?? 0,
            'description' => $_POST['description'] ?? '',
            'category' => $_POST['category'] ?? '',
            'image' => $_POST['image'] ?? '',
            'stock' => $_POST['stock'] ?? 0
        ];
        
        if ($productModel->update($id, $data)) {
            $_SESSION['success'] = 'Cập nhật sản phẩm thành công!';
            redirect('products');
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra!';
        }
    }
    
    require_once BASE_PATH . '/app/Views/products/edit.php';
}

// Xóa sản phẩm (Admin)
if ($action === 'delete') {
    if (!isAdmin()) {
        redirect('login');
    }
    
    $id = $_GET['id'] ?? '';
    
    if ($productModel->delete($id)) {
        $_SESSION['success'] = 'Xóa sản phẩm thành công!';
    } else {
        $_SESSION['error'] = 'Có lỗi xảy ra!';
    }
    
    redirect('products');
}

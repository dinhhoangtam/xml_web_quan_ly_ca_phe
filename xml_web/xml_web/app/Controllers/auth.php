<?php
// Controller xác thực

require_once BASE_PATH . '/app/Models/user.php';

$userModel = new UserModel();

// Xử lý đăng nhập
if ($controller === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    $user = $userModel->login($email, $password);
    
    if ($user) {
        $_SESSION['user_id'] = (string)$user->id;
        $_SESSION['user_name'] = (string)$user->n;
        $_SESSION['user_email'] = (string)$user->email;
        $_SESSION['role'] = (string)$user->role;
        
        if ((string)$user->role === 'admin') {
            redirect('admin/dashboard');
        } else {
            redirect('products');
        }
    } else {
        $_SESSION['error'] = 'Email hoặc mật khẩu không đúng!';
        redirect('login');
    }
}

// Xử lý đăng ký
if ($controller === 'register' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'name' => $_POST['name'] ?? '',
        'email' => $_POST['email'] ?? '',
        'password' => $_POST['password'] ?? '',
        'phone' => $_POST['phone'] ?? '',
        'address' => $_POST['address'] ?? '',
        'role' => 'user'
    ];
    
    if ($userModel->register($data)) {
        $_SESSION['success'] = 'Đăng ký thành công! Vui lòng đăng nhập.';
        redirect('login');
    } else {
        $_SESSION['error'] = 'Email đã tồn tại hoặc có lỗi xảy ra!';
        redirect('register');
    }
}

// Xử lý đăng xuất
if ($controller === 'logout') {
    session_destroy();
    redirect('login');
}

// Hiển thị form đăng nhập
if ($controller === 'login' && $action === 'index') {
    require_once BASE_PATH . '/app/Views/auth/login.php';
}

// Hiển thị form đăng ký
if ($controller === 'register' && $action === 'index') {
    require_once BASE_PATH . '/app/Views/auth/register.php';
}

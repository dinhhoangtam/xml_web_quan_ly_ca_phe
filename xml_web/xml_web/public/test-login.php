<?php
/**
 * Test đăng nhập
 * Kiểm tra xem mật khẩu có hoạt động không
 */

require_once '../core/config.php';
require_once '../core/lib.php';
require_once '../app/Models/user.php';

echo "<h1>Test Đăng Nhập</h1>";

$userModel = new UserModel();

// Test Admin
echo "<h2>Test Admin</h2>";
$admin = $userModel->login('admin', '1');
if ($admin) {
    echo "✅ Admin đăng nhập thành công!<br>";
    echo "Name: " . $admin->n . "<br>";
    echo "Role: " . $admin->role . "<br>";
} else {
    echo "❌ Admin đăng nhập thất bại!<br>";
}

echo "<hr>";

// Test User
echo "<h2>Test User</h2>";
$user = $userModel->login('user', '1');
if ($user) {
    echo "✅ User đăng nhập thành công!<br>";
    echo "Name: " . $user->n . "<br>";
    echo "Role: " . $user->role . "<br>";
} else {
    echo "❌ User đăng nhập thất bại!<br>";
}

echo "<hr>";

// Hiển thị thông tin debug
echo "<h2>Debug Info</h2>";
$users = $userModel->getAll();
foreach ($users as $u) {
    echo "<p>";
    echo "Email: " . $u->email . "<br>";
    echo "Password Hash: " . substr($u->password, 0, 20) . "...<br>";
    echo "Role: " . $u->role . "<br>";
    echo "</p>";
}

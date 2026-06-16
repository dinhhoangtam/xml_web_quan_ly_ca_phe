<?php
/**
 * Script setup ban đầu
 * Chạy file này để tạo tài khoản admin và user với mật khẩu đúng
 */

require_once 'core/config.php';
require_once 'core/lib.php';

// Tạo hash mật khẩu
$adminPassword = password_hash('1', PASSWORD_DEFAULT);
$userPassword = password_hash('1', PASSWORD_DEFAULT);

// Tạo file users.xml
$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><root></root>');

// Thêm Admin
$admin = $xml->addChild('user');
$admin->addChild('id', 'USR20250101001');
$admin->addChild('n', 'Admin Coffee');
$admin->addChild('email', 'admin');
$admin->addChild('password', $adminPassword);
$admin->addChild('phone', '0123456789');
$admin->addChild('address', 'Cà Mau, Việt Nam');
$admin->addChild('role', 'admin');
$admin->addChild('created_at', date('Y-m-d H:i:s'));

// Thêm User
$user = $xml->addChild('user');
$user->addChild('id', 'USR20250101002');
$user->addChild('n', 'Nguyễn Văn User');
$user->addChild('email', 'user');
$user->addChild('password', $userPassword);
$user->addChild('phone', '0987654321');
$user->addChild('address', '123 Đường ABC, Quận 1, TP.HCM');
$user->addChild('role', 'user');
$user->addChild('created_at', date('Y-m-d H:i:s'));

// Lưu file
$dom = new DOMDocument('1.0', 'UTF-8');
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
$dom->loadXML($xml->asXML());
$dom->save(XML_PATH . 'users.xml');

echo "✅ Setup thành công!\n\n";
echo "📧 Tài khoản Admin:\n";
echo "   Username: admin\n";
echo "   Password: 1\n\n";
echo "📧 Tài khoản User:\n";
echo "   Username: user\n";
echo "   Password: 1\n\n";
echo "🔐 Mật khẩu đã được mã hóa an toàn!\n";

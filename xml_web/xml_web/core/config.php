<?php
// Cấu hình chính của ứng dụng
define('BASE_PATH', dirname(__DIR__));
define('XML_PATH', BASE_PATH . '/storage/xml/');
define('BASE_URL', '/xml_web/public/');

// Cấu hình session
session_start();

// Thông tin ngân hàng
define('BANK_ACCOUNT', '7204205173204');
define('BANK_NAME', 'Agribank');
define('BANK_QR_API', 'https://img.vietqr.io/image/');

// Timezone
date_default_timezone_set('Asia/Ho_Chi_Minh');

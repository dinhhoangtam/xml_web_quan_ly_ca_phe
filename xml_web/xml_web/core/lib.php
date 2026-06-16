<?php
// Thư viện hàm tiện ích

// Load XML file
function loadXML($filename) {
    $filepath = XML_PATH . $filename;
    if (!file_exists($filepath)) {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><root></root>');
        $xml->asXML($filepath);
    }
    return simplexml_load_file($filepath);
}

// Save XML file
function saveXML($xml, $filename) {
    $filepath = XML_PATH . $filename;
    $dom = new DOMDocument('1.0', 'UTF-8');
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->loadXML($xml->asXML());
    return $dom->save($filepath);
}

// Generate unique ID
function generateID($prefix = '') {
    return $prefix . date('YmdHis') . rand(1000, 9999);
}

// Format currency
function formatCurrency($amount) {
    // Convert SimpleXMLElement to float if needed
    if ($amount instanceof SimpleXMLElement) {
        $amount = (float)(string)$amount;
    }
    return number_format((float)$amount, 0, ',', '.') . ' ₫';
}

// Check login
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Check admin
function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

// Redirect
function redirect($path) {
    header('Location: ' . BASE_URL . $path);
    exit;
}

// Get current user
function getCurrentUser() {
    if (!isLoggedIn()) return null;
    
    $users = loadXML('users.xml');
    foreach ($users->user as $user) {
        if ((string)$user->id === $_SESSION['user_id']) {
            return $user;
        }
    }
    return null;
}

// Sanitize input
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Format date
function formatDate($date) {
    return date('d/m/Y H:i', strtotime($date));
}

// Generate QR code URL for payment
function generateQRCode($amount, $content) {
    $bankCode = 'agribank';
    $accountNo = BANK_ACCOUNT;
    $template = 'compact';
    $description = urlencode($content);
    
    return BANK_QR_API . "{$bankCode}-{$accountNo}-{$template}.jpg?amount={$amount}&addInfo={$description}";
}

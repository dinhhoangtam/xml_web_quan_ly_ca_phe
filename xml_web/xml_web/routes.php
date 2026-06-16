<?php
// Định tuyến URL

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = str_replace(BASE_URL, '', $uri);
$uri = trim($uri, '/');

// Default route
if (empty($uri)) {
    $uri = 'products';
}

// Parse route
$segments = explode('/', $uri);
$controller = $segments[0];
$action = $segments[1] ?? 'index';

// Map routes
$routes = [
    // Products
    'products' => 'app/Controllers/product.php',
    'product' => 'app/Controllers/product.php',
    
    // Orders
    'cart' => 'app/Controllers/order.php',
    'checkout' => 'app/Controllers/order.php',
    'orders' => 'app/Controllers/order.php',
    'order' => 'app/Controllers/order.php',
    
    // Auth
    'login' => 'app/Controllers/auth.php',
    'logout' => 'app/Controllers/auth.php',
    'register' => 'app/Controllers/auth.php',
    
    // Admin
    'admin' => 'app/Controllers/stats.php',
    'stats' => 'app/Controllers/stats.php',
    
    // Export/Import
    'export' => 'app/Controllers/export.php',
    'import' => 'app/Controllers/import.php',
];

// Load controller
if (isset($routes[$controller])) {
    require_once BASE_PATH . '/' . $routes[$controller];
} else {
    http_response_code(404);
    echo "404 - Page Not Found";
}

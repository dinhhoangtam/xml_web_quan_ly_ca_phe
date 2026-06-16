<?php
// Controller nhập dữ liệu

if (!isAdmin()) {
    redirect('login');
}

// Import XML
if ($action === 'xml' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['xml_file']) && $_FILES['xml_file']['error'] === 0) {
        $tmpFile = $_FILES['xml_file']['tmp_name'];
        $type = $_POST['type'] ?? 'products';
        
        try {
            $importedXml = simplexml_load_file($tmpFile);
            
            if ($type === 'products') {
                $filename = 'coffees.xml';
            } elseif ($type === 'orders') {
                $filename = 'orders.xml';
            } else {
                $filename = 'users.xml';
            }
            
            // Backup file hiện tại
            $currentFile = XML_PATH . $filename;
            if (file_exists($currentFile)) {
                copy($currentFile, XML_PATH . 'backup_' . $filename);
            }
            
            // Lưu file mới
            $dom = new DOMDocument('1.0', 'UTF-8');
            $dom->preserveWhiteSpace = false;
            $dom->formatOutput = true;
            $dom->loadXML($importedXml->asXML());
            $dom->save($currentFile);
            
            $_SESSION['success'] = 'Import dữ liệu thành công!';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Lỗi import: ' . $e->getMessage();
        }
    } else {
        $_SESSION['error'] = 'Vui lòng chọn file XML!';
    }
    
    redirect('admin/dashboard');
}

// Hiển thị form import
if ($action === 'index') {
    require_once BASE_PATH . '/app/Views/admin/import.php';
}

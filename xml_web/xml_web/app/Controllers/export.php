<?php
// Controller xuất dữ liệu

if (!isAdmin()) {
    redirect('login');
}

require_once BASE_PATH . '/app/Models/product.php';
require_once BASE_PATH . '/app/Models/order.php';

$productModel = new ProductModel();
$orderModel = new OrderModel();

// Export Excel
if ($action === 'excel') {
    $type = $_GET['type'] ?? 'products';
    
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="' . $type . '_' . date('Y-m-d') . '.xls"');
    
    echo '<html><head><meta charset="utf-8"></head><body>';
    echo '<table border="1">';
    
    if ($type === 'products') {
        $products = $productModel->getAll();
        echo '<tr><th>ID</th><th>Tên sản phẩm</th><th>Giá</th><th>Danh mục</th><th>Tồn kho</th><th>Ngày tạo</th></tr>';
        
        foreach ($products as $product) {
            echo '<tr>';
            echo '<td>' . $product->id . '</td>';
            echo '<td>' . $product->name . '</td>';
            echo '<td>' . $product->price . '</td>';
            echo '<td>' . $product->category . '</td>';
            echo '<td>' . $product->stock . '</td>';
            echo '<td>' . $product->created_at . '</td>';
            echo '</tr>';
        }
    } elseif ($type === 'orders') {
        $orders = $orderModel->getAll();
        echo '<tr><th>Mã đơn</th><th>Khách hàng</th><th>Tổng tiền</th><th>Thanh toán</th><th>Trạng thái</th><th>Ngày đặt</th></tr>';
        
        foreach ($orders as $order) {
            echo '<tr>';
            echo '<td>' . $order->id . '</td>';
            echo '<td>' . $order->customer_name . '</td>';
            echo '<td>' . $order->total_amount . '</td>';
            echo '<td>' . $order->payment_method . '</td>';
            echo '<td>' . $order->status . '</td>';
            echo '<td>' . $order->created_at . '</td>';
            echo '</tr>';
        }
    }
    
    echo '</table>';
    echo '</body></html>';
    exit;
}

// Export PDF
if ($action === 'pdf') {
    $type = $_GET['type'] ?? 'products';
    
    require_once BASE_PATH . '/vendor/tcpdf/tcpdf.php';
    
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');
    $pdf->SetCreator('Coffee Shop');
    $pdf->SetTitle('Báo cáo ' . $type);
    $pdf->SetMargins(15, 15, 15);
    $pdf->AddPage();
    
    // Font hỗ trợ tiếng Việt
    $pdf->SetFont('dejavusans', '', 10);
    
    $html = '<h1>Báo cáo ' . $type . '</h1>';
    $html .= '<table border="1" cellpadding="5">';
    
    if ($type === 'products') {
        $products = $productModel->getAll();
        $html .= '<tr style="background-color: #f0f0f0;">
                    <th>ID</th><th>Tên SP</th><th>Giá</th><th>Danh mục</th><th>Tồn kho</th>
                  </tr>';
        
        foreach ($products as $product) {
            $html .= '<tr>';
            $html .= '<td>' . $product->id . '</td>';
            $html .= '<td>' . $product->name . '</td>';
            $html .= '<td>' . formatCurrency($product->price) . '</td>';
            $html .= '<td>' . $product->category . '</td>';
            $html .= '<td>' . $product->stock . '</td>';
            $html .= '</tr>';
        }
    } elseif ($type === 'orders') {
        $orders = $orderModel->getAll();
        $html .= '<tr style="background-color: #f0f0f0;">
                    <th>Mã đơn</th><th>Khách hàng</th><th>Tổng tiền</th><th>Trạng thái</th>
                  </tr>';
        
        foreach ($orders as $order) {
            $html .= '<tr>';
            $html .= '<td>' . $order->id . '</td>';
            $html .= '<td>' . $order->customer_name . '</td>';
            $html .= '<td>' . formatCurrency($order->total_amount) . '</td>';
            $html .= '<td>' . $order->status . '</td>';
            $html .= '</tr>';
        }
    }
    
    $html .= '</table>';
    
    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output($type . '_' . date('Y-m-d') . '.pdf', 'D');
    exit;
}

// Export XML
if ($action === 'xml') {
    $type = $_GET['type'] ?? 'products';
    
    header('Content-Type: application/xml');
    header('Content-Disposition: attachment; filename="' . $type . '_' . date('Y-m-d') . '.xml"');
    
    if ($type === 'products') {
        $xml = loadXML('coffees.xml');
    } elseif ($type === 'orders') {
        $xml = loadXML('orders.xml');
    } else {
        $xml = loadXML('users.xml');
    }
    
    $dom = new DOMDocument('1.0', 'UTF-8');
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->loadXML($xml->asXML());
    
    echo $dom->saveXML();
    exit;
}

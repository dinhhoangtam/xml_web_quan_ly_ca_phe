<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa đơn #<?php echo $order->id; ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Courier New', monospace; 
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
            background: white;
        }
        .invoice { 
            border: 2px solid #000; 
            padding: 30px;
        }
        .header { 
            text-align: center; 
            border-bottom: 2px dashed #000;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .header h1 { 
            font-size: 32px; 
            margin-bottom: 10px;
        }
        .info-section { 
            margin: 20px 0;
        }
        .info-row { 
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
        }
        .items-table { 
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .items-table th,
        .items-table td { 
            border: 1px solid #000;
            padding: 10px;
            text-align: left;
        }
        .items-table th { 
            background: #f0f0f0;
            font-weight: bold;
        }
        .total-section { 
            border-top: 2px dashed #000;
            padding-top: 20px;
            margin-top: 20px;
        }
        .total-row { 
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            font-size: 18px;
        }
        .grand-total { 
            font-size: 24px;
            font-weight: bold;
            border-top: 2px solid #000;
            padding-top: 10px;
            margin-top: 10px;
        }
        .footer { 
            text-align: center;
            margin-top: 30px;
            border-top: 2px dashed #000;
            padding-top: 20px;
        }
        .print-btn { 
            background: #000;
            color: white;
            border: none;
            padding: 15px 30px;
            font-size: 16px;
            cursor: pointer;
            margin: 20px 0;
        }
        @media print {
            .print-btn { display: none; }
            body { padding: 0; }
        }
    </style>
</head>
<body>
    <button onclick="window.print()" class="print-btn">🖨️ IN HÓA ĐƠN</button>
    
    <div class="invoice">
        <div class="header">
            <h1>☕ COFFEE HOUSE</h1>
            <p>Cà Mau, Việt Nam</p>
            <p>Hotline: 0123 456 789</p>
            <p style="margin-top: 15px; font-size: 20px; font-weight: bold;">HÓA ĐƠN BÁN HÀNG</p>
        </div>
        
        <div class="info-section">
            <div class="info-row">
                <strong>Mã đơn hàng:</strong>
                <span><?php echo $order->id; ?></span>
            </div>
            <div class="info-row">
                <strong>Ngày đặt:</strong>
                <span><?php echo formatDate($order->created_at); ?></span>
            </div>
        </div>
        
        <div class="info-section">
            <h3 style="margin-bottom: 10px;">THÔNG TIN KHÁCH HÀNG</h3>
            <div class="info-row">
                <strong>Họ tên:</strong>
                <span><?php echo $order->customer_name; ?></span>
            </div>
            <div class="info-row">
                <strong>Số điện thoại:</strong>
                <span><?php echo $order->customer_phone; ?></span>
            </div>
            <div class="info-row">
                <strong>Email:</strong>
                <span><?php echo $order->customer_email; ?></span>
            </div>
            <div class="info-row">
                <strong>Địa chỉ:</strong>
                <span><?php echo $order->customer_address; ?></span>
            </div>
        </div>
        
        <table class="items-table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Sản phẩm</th>
                    <th>Đơn giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $stt = 1;
                foreach ($order->items->item as $item): 
                ?>
                    <tr>
                        <td><?php echo $stt++; ?></td>
                        <td><?php echo $item->product_name; ?></td>
                        <td><?php echo formatCurrency($item->price); ?></td>
                        <td><?php echo $item->quantity; ?></td>
                        <td><strong><?php echo formatCurrency($item->subtotal); ?></strong></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <div class="total-section">
            <div class="info-row">
                <strong>Phương thức thanh toán:</strong>
                <span>
                    <?php echo $order->payment_method === 'cod' ? 
                        'Thanh toán khi nhận hàng (COD)' : 
                        'Chuyển khoản ngân hàng'; ?>
                </span>
            </div>
            
            <div class="total-row">
                <span>Tạm tính:</span>
                <span><?php echo formatCurrency($order->total_amount); ?></span>
            </div>
            <div class="total-row">
                <span>Phí vận chuyển:</span>
                <span>Miễn phí</span>
            </div>
            <div class="total-row grand-total">
                <span>TỔNG CỘNG:</span>
                <span><?php echo formatCurrency($order->total_amount); ?></span>
            </div>
        </div>
        
        <div class="footer">
            <p style="font-style: italic;">Cảm ơn quý khách đã mua hàng!</p>
            <p style="margin-top: 10px;">Hotline hỗ trợ: 0123 456 789</p>
        </div>
    </div>
</body>
</html>

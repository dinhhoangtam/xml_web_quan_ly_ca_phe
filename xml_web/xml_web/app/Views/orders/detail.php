<?php $pageTitle = 'Chi tiết đơn hàng'; ?>
<?php require_once BASE_PATH . '/app/Views/layouts/header.php'; ?>

<div class="container">
    <div class="page-header">
        <h1>Chi tiết đơn hàng</h1>
        <a href="<?php echo BASE_URL; ?>orders" class="btn-back">← Quay lại</a>
    </div>
    
    <div class="order-detail-container">
        <div class="order-detail-card">
            <div class="detail-section">
                <h3>Thông tin đơn hàng</h3>
                <div class="detail-row">
                    <span>Mã đơn hàng:</span>
                    <strong><?php echo $order->id; ?></strong>
                </div>
                <div class="detail-row">
                    <span>Ngày đặt:</span>
                    <strong><?php echo formatDate($order->created_at); ?></strong>
                </div>
                <div class="detail-row">
                    <span>Trạng thái:</span>
                    <?php
                    $statusClass = 'status-' . $order->status;
                    $statusText = [
                        'pending' => 'Đang xử lý',
                        'processing' => 'Đang giao',
                        'completed' => 'Hoàn thành',
                        'cancelled' => 'Đã hủy'
                    ];
                    ?>
                    <span class="status-badge <?php echo $statusClass; ?>">
                        <?php echo $statusText[(string)$order->status]; ?>
                    </span>
                </div>
            </div>
            
            <div class="detail-section">
                <h3>Thông tin khách hàng</h3>
                <div class="detail-row">
                    <span>Họ tên:</span>
                    <strong><?php echo $order->customer_name; ?></strong>
                </div>
                <div class="detail-row">
                    <span>Email:</span>
                    <strong><?php echo $order->customer_email; ?></strong>
                </div>
                <div class="detail-row">
                    <span>Số điện thoại:</span>
                    <strong><?php echo $order->customer_phone; ?></strong>
                </div>
                <div class="detail-row">
                    <span>Địa chỉ giao hàng:</span>
                    <strong><?php echo $order->customer_address; ?></strong>
                </div>
            </div>
            
            <div class="detail-section">
                <h3>Sản phẩm</h3>
                <div class="order-items-detail">
                    <?php foreach ($order->items->item as $item): ?>
                        <div class="item-detail">
                            <div class="item-info">
                                <h4><?php echo $item->product_name; ?></h4>
                                <p>Giá: <?php echo formatCurrency($item->price); ?> x <?php echo $item->quantity; ?></p>
                            </div>
                            <div class="item-total">
                                <strong><?php echo formatCurrency($item->subtotal); ?></strong>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <div class="detail-section">
                <h3>Thanh toán</h3>
                <div class="detail-row">
                    <span>Phương thức:</span>
                    <strong>
                        <?php echo $order->payment_method === 'cod' ? 
                            '💵 Thanh toán khi nhận hàng' : 
                            '🏦 Chuyển khoản ngân hàng'; ?>
                    </strong>
                </div>
                <div class="detail-row">
                    <span>Tổng tiền:</span>
                    <strong class="total-price"><?php echo formatCurrency($order->total_amount); ?></strong>
                </div>
            </div>
            
            <div class="detail-actions">
                <a href="<?php echo BASE_URL; ?>order/print?id=<?php echo $order->id; ?>" 
                   class="btn-print" target="_blank">
                    🖨️ In hóa đơn
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.order-detail-container {
    max-width: 800px;
    margin: 0 auto;
}

.order-detail-card {
    background: white;
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.detail-section {
    margin-bottom: 30px;
    padding-bottom: 30px;
    border-bottom: 2px dashed var(--accent);
}

.detail-section:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.detail-section h3 {
    font-family: 'Playfair Display', serif;
    font-size: 24px;
    color: var(--primary);
    margin-bottom: 20px;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid #f0f0f0;
}

.detail-row:last-child {
    border-bottom: none;
}

.order-items-detail {
    margin-top: 20px;
}

.item-detail {
    display: flex;
    justify-content: space-between;
    padding: 15px;
    background: var(--light);
    border-radius: 12px;
    margin-bottom: 15px;
}

.item-detail:last-child {
    margin-bottom: 0;
}

.item-info h4 {
    color: var(--primary);
    margin-bottom: 8px;
}

.item-info p {
    color: #666;
    font-size: 14px;
}

.item-total {
    font-size: 20px;
    font-weight: 700;
    color: var(--secondary);
}

.total-price {
    font-size: 28px;
    color: var(--secondary);
}

.detail-actions {
    margin-top: 30px;
    text-align: center;
}
</style>

<?php require_once BASE_PATH . '/app/Views/layouts/footer.php'; ?>

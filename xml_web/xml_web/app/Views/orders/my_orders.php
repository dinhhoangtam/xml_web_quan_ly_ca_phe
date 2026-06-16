<?php $pageTitle = 'Đơn hàng của tôi'; ?>
<?php require_once BASE_PATH . '/app/Views/layouts/header.php'; ?>

<div class="container">
    <div class="page-header">
        <h1>Đơn hàng của tôi</h1>
    </div>
    
    <?php if (empty($orders)): ?>
        <div class="empty-state">
            <p>Bạn chưa có đơn hàng nào</p>
            <a href="<?php echo BASE_URL; ?>products" class="btn-primary">Mua sắm ngay</a>
        </div>
    <?php else: ?>
        <div class="orders-list">
            <?php foreach ($orders as $order): ?>
                <div class="order-card">
                    <div class="order-header">
                        <div>
                            <h3>Đơn hàng #<?php echo $order->id; ?></h3>
                            <p class="order-date"><?php echo formatDate($order->created_at); ?></p>
                        </div>
                        
                        <div class="order-status">
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
                                <?php echo $statusText[(string)$order->status] ?? 'Không xác định'; ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="order-items-preview">
                        <?php foreach ($order->items->item as $item): ?>
                            <div class="order-item-preview">
                                <span><?php echo $item->product_name; ?> x<?php echo $item->quantity; ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="order-footer">
                        <div class="order-total">
                            <span>Tổng tiền:</span>
                            <strong><?php echo formatCurrency($order->total_amount); ?></strong>
                        </div>
                        
                        <div class="order-actions">
                            <a href="<?php echo BASE_URL; ?>order/detail?id=<?php echo $order->id; ?>" 
                               class="btn-view">Xem chi tiết</a>
                            <a href="<?php echo BASE_URL; ?>order/print?id=<?php echo $order->id; ?>" 
                               class="btn-print" target="_blank">In hóa đơn</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once BASE_PATH . '/app/Views/layouts/footer.php'; ?>

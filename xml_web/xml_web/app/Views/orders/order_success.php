<?php $pageTitle = 'Đặt hàng thành công'; ?>
<?php require_once BASE_PATH . '/app/Views/layouts/header.php'; ?>

<div class="container">
    <div class="success-container">
        <div class="success-icon">✓</div>
        <h1>Đặt hàng thành công!</h1>
        <p>Cảm ơn bạn đã đặt hàng. Chúng tôi sẽ liên hệ với bạn sớm nhất.</p>
        
        <?php if ($order): ?>
            <div class="order-info-card">
                <h3>Thông tin đơn hàng</h3>
                <div class="info-row">
                    <span>Mã đơn hàng:</span>
                    <strong><?php echo $order->id; ?></strong>
                </div>
                <div class="info-row">
                    <span>Tổng tiền:</span>
                    <strong><?php echo formatCurrency($order->total_amount); ?></strong>
                </div>
                <div class="info-row">
                    <span>Phương thức thanh toán:</span>
                    <strong><?php echo $order->payment_method === 'cod' ? 'Thanh toán khi nhận hàng' : 'Chuyển khoản'; ?></strong>
                </div>
                <div class="info-row">
                    <span>Trạng thái:</span>
                    <strong class="status-pending">Đang xử lý</strong>
                </div>
            </div>
            
            <div class="success-actions">
                <a href="<?php echo BASE_URL; ?>order/print?id=<?php echo $order->id; ?>" 
                   class="btn-print" target="_blank">🖨️ In hóa đơn</a>
                <a href="<?php echo BASE_URL; ?>orders" class="btn-primary">Xem đơn hàng</a>
                <a href="<?php echo BASE_URL; ?>products" class="btn-secondary">Tiếp tục mua sắm</a>
            </div>
            
            <?php if ((string)$order->payment_method === 'transfer'): ?>
                <div class="payment-reminder">
                    <h4>Lưu ý:</h4>
                    <p>Vui lòng chuyển khoản theo thông tin đã cung cấp để hoàn tất đơn hàng.</p>
                    <p>Sau khi chuyển khoản, đơn hàng của bạn sẽ được xử lý trong vòng 24h.</p>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<?php require_once BASE_PATH . '/app/Views/layouts/footer.php'; ?>

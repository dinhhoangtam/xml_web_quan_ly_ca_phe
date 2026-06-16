<?php $pageTitle = 'Thanh toán'; ?>
<?php require_once BASE_PATH . '/app/Views/layouts/header.php'; ?>

<div class="container">
    <div class="page-header">
        <h1>Thanh toán đơn hàng</h1>
    </div>
    
    <div class="checkout-container">
        <div class="checkout-form">
            <form method="POST" action="<?php echo BASE_URL; ?>checkout" id="checkoutForm">
                <h3>Thông tin giao hàng</h3>
                
                <div class="form-group">
                    <label>Họ tên *</label>
                    <input type="text" name="name" value="<?php echo $user->n ?? ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" value="<?php echo $user->email ?? ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Số điện thoại *</label>
                    <input type="tel" name="phone" value="<?php echo $user->phone ?? ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Địa chỉ giao hàng *</label>
                    <textarea name="address" rows="3" required><?php echo $user->address ?? ''; ?></textarea>
                </div>
                
                <h3>Phương thức thanh toán</h3>
                
                <div class="payment-methods">
                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="cod" checked onchange="togglePaymentInfo()">
                        <div class="payment-card">
                            <span class="payment-icon">💵</span>
                            <div>
                                <strong>Thanh toán khi nhận hàng (COD)</strong>
                                <p>Thanh toán bằng tiền mặt khi nhận hàng</p>
                            </div>
                        </div>
                    </label>
                    
                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="transfer" onchange="togglePaymentInfo()">
                        <div class="payment-card">
                            <span class="payment-icon">🏦</span>
                            <div>
                                <strong>Chuyển khoản ngân hàng</strong>
                                <p>Quét mã QR để thanh toán</p>
                            </div>
                        </div>
                    </label>
                </div>
                
                <div id="qrCodeSection" class="qr-section" style="display: none;">
                    <h4>Quét mã QR để thanh toán</h4>
                    <div class="qr-container">
                        <?php 
                        $orderContent = 'Thanh toan don hang ' . date('YmdHis');
                        $qrUrl = generateQRCode($total, $orderContent);
                        ?>
                        <img src="<?php echo $qrUrl; ?>" alt="QR Code" class="qr-image">
                    </div>
                    <div class="bank-info">
                        <p><strong>Ngân hàng:</strong> <?php echo BANK_NAME; ?></p>
                        <p><strong>Số tài khoản:</strong> <?php echo BANK_ACCOUNT; ?></p>
                        <p><strong>Số tiền:</strong> <?php echo formatCurrency($total); ?></p>
                        <p><strong>Nội dung:</strong> <?php echo $orderContent; ?></p>
                    </div>
                </div>
                
                <button type="submit" class="btn-submit-order">Đặt hàng</button>
            </form>
        </div>
        
        <div class="checkout-summary">
            <h3>Đơn hàng của bạn</h3>
            
            <div class="order-items">
                <?php foreach ($cart as $item): ?>
                    <div class="order-item">
                        <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>">
                        <div class="order-item-info">
                            <p><?php echo $item['name']; ?></p>
                            <span>x<?php echo $item['quantity']; ?></span>
                        </div>
                        <strong><?php echo formatCurrency($item['price'] * $item['quantity']); ?></strong>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="order-total">
                <div class="total-row">
                    <span>Tạm tính:</span>
                    <strong><?php echo formatCurrency($total); ?></strong>
                </div>
                <div class="total-row">
                    <span>Phí vận chuyển:</span>
                    <strong>Miễn phí</strong>
                </div>
                <div class="total-row grand-total">
                    <span>Tổng cộng:</span>
                    <strong><?php echo formatCurrency($total); ?></strong>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePaymentInfo() {
    const transferRadio = document.querySelector('input[name="payment_method"][value="transfer"]');
    const qrSection = document.getElementById('qrCodeSection');
    
    if (transferRadio.checked) {
        qrSection.style.display = 'block';
    } else {
        qrSection.style.display = 'none';
    }
}
</script>

<?php require_once BASE_PATH . '/app/Views/layouts/footer.php'; ?>

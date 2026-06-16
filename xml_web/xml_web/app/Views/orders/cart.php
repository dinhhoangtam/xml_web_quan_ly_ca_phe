<?php $pageTitle = 'Giỏ hàng'; ?>
<?php require_once BASE_PATH . '/app/Views/layouts/header.php'; ?>

<div class="container">
    <div class="page-header">
        <h1>Giỏ hàng của bạn</h1>
    </div>
    
    <?php if (empty($cart)): ?>
        <div class="empty-cart">
            <div class="empty-icon">🛒</div>
            <h2>Giỏ hàng trống</h2>
            <p>Hãy thêm sản phẩm vào giỏ hàng để tiếp tục mua sắm</p>
            <a href="<?php echo BASE_URL; ?>products" class="btn-primary">Mua sắm ngay</a>
        </div>
    <?php else: ?>
        <div class="cart-container">
            <div class="cart-items">
                <?php foreach ($cart as $productId => $item): ?>
                    <div class="cart-item">
                        <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" class="cart-item-image">
                        
                        <div class="cart-item-info">
                            <h3><?php echo $item['name']; ?></h3>
                            <p class="cart-item-price"><?php echo formatCurrency($item['price']); ?></p>
                        </div>
                        
                        <div class="cart-item-quantity">
                            <form method="POST" action="<?php echo BASE_URL; ?>cart/update" class="quantity-form">
                                <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                                <button type="submit" name="quantity" value="<?php echo $item['quantity'] - 1; ?>" 
                                        class="qty-btn">−</button>
                                <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" 
                                       min="1" readonly class="qty-input">
                                <button type="submit" name="quantity" value="<?php echo $item['quantity'] + 1; ?>" 
                                        class="qty-btn">+</button>
                            </form>
                        </div>
                        
                        <div class="cart-item-total">
                            <strong><?php echo formatCurrency($item['price'] * $item['quantity']); ?></strong>
                        </div>
                        
                        <a href="<?php echo BASE_URL; ?>cart/remove?id=<?php echo $productId; ?>" 
                           class="cart-item-remove"
                           onclick="return confirm('Xóa sản phẩm này khỏi giỏ hàng?')">🗑️</a>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="cart-summary">
                <h3>Tổng đơn hàng</h3>
                
                <div class="summary-row">
                    <span>Tạm tính:</span>
                    <strong><?php echo formatCurrency($total); ?></strong>
                </div>
                
                <div class="summary-row">
                    <span>Phí vận chuyển:</span>
                    <strong>Miễn phí</strong>
                </div>
                
                <div class="summary-total">
                    <span>Tổng cộng:</span>
                    <strong class="total-amount"><?php echo formatCurrency($total); ?></strong>
                </div>
                
                <a href="<?php echo BASE_URL; ?>checkout" class="btn-checkout">Tiến hành thanh toán</a>
                
                <a href="<?php echo BASE_URL; ?>products" class="btn-continue">Tiếp tục mua sắm</a>
                
                <a href="<?php echo BASE_URL; ?>cart/clear" class="btn-clear-cart"
                   onclick="return confirm('Xóa toàn bộ giỏ hàng?')">Xóa giỏ hàng</a>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require_once BASE_PATH . '/app/Views/layouts/footer.php'; ?>

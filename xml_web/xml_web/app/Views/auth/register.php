<?php $pageTitle = 'Đăng ký'; ?>
<?php require_once BASE_PATH . '/app/Views/layouts/header.php'; ?>

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1>Tạo tài khoản</h1>
            <p>Đăng ký để bắt đầu mua sắm</p>
        </div>
        
        <form method="POST" action="<?php echo BASE_URL; ?>register" class="auth-form">
            <div class="form-group">
                <label>Họ tên</label>
                <input type="text" name="name" required placeholder="Nguyễn Văn A">
            </div>
            
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required placeholder="your@email.com">
            </div>
            
            <div class="form-group">
                <label>Số điện thoại</label>
                <input type="tel" name="phone" placeholder="0123456789">
            </div>
            
            <div class="form-group">
                <label>Địa chỉ</label>
                <textarea name="address" rows="3" placeholder="Địa chỉ giao hàng"></textarea>
            </div>
            
            <div class="form-group">
                <label>Mật khẩu</label>
                <input type="password" name="password" required placeholder="••••••••">
            </div>
            
            <button type="submit" class="btn-submit">Đăng ký</button>
        </form>
        
        <div class="auth-footer">
            <p>Đã có tài khoản? <a href="<?php echo BASE_URL; ?>login">Đăng nhập</a></p>
        </div>
    </div>
</div>

<?php require_once BASE_PATH . '/app/Views/layouts/footer.php'; ?>

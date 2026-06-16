<?php $pageTitle = 'Đăng nhập'; ?>
<?php require_once BASE_PATH . '/app/Views/layouts/header.php'; ?>

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1>Chào mừng trở lại</h1>
            <p>Đăng nhập để tiếp tục mua sắm</p>
        </div>
        
        <form method="POST" action="<?php echo BASE_URL; ?>login" class="auth-form">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="email" required placeholder="admin hoặc user">
            </div>
            
            <div class="form-group">
                <label>Mật khẩu</label>
                <input type="password" name="password" required placeholder="1">
            </div>
            
            <button type="submit" class="btn-submit">Đăng nhập</button>
        </form>
        
        <div class="auth-footer">
            <p>Chưa có tài khoản? <a href="<?php echo BASE_URL; ?>register">Đăng ký ngay</a></p>
        </div>
        
        <div class="demo-accounts">
            <h4>Tài khoản demo:</h4>
            <p><strong>Admin:</strong> admin / 1</p>
            <p><strong>User:</strong> user / 1</p>
        </div>
    </div>
</div>

<?php require_once BASE_PATH . '/app/Views/layouts/footer.php'; ?>

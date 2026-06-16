<?php $pageTitle = 'Thêm sản phẩm'; ?>
<?php require_once BASE_PATH . '/app/Views/layouts/header.php'; ?>

<div class="container">
    <div class="page-header">
        <h1>Thêm sản phẩm mới</h1>
        <a href="<?php echo BASE_URL; ?>products" class="btn-back">← Quay lại</a>
    </div>
    
    <div class="form-container">
        <form method="POST" action="<?php echo BASE_URL; ?>product/add" class="product-form">
            <div class="form-row">
                <div class="form-group">
                    <label>Tên sản phẩm *</label>
                    <input type="text" name="name" required>
                </div>
                
                <div class="form-group">
                    <label>Giá (VNĐ) *</label>
                    <input type="number" name="price" required min="0">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Danh mục *</label>
                    <select name="category" required>
                        <option value="">-- Chọn danh mục --</option>
                        <option value="Cà phê rang xay">Cà phê rang xay</option>
                        <option value="Cà phê hòa tan">Cà phê hòa tan</option>
                        <option value="Cà phê pha máy">Cà phê pha máy</option>
                        <option value="Cà phê phin">Cà phê phin</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Số lượng *</label>
                    <input type="number" name="stock" required min="0">
                </div>
            </div>
            
            <div class="form-group">
                <label>URL hình ảnh *</label>
                <input type="url" name="image" required placeholder="https://example.com/image.jpg">
            </div>
            
            <div class="form-group">
                <label>Mô tả *</label>
                <textarea name="description" rows="5" required></textarea>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn-submit">Thêm sản phẩm</button>
                <a href="<?php echo BASE_URL; ?>products" class="btn-cancel">Hủy</a>
            </div>
        </form>
    </div>
</div>

<?php require_once BASE_PATH . '/app/Views/layouts/footer.php'; ?>

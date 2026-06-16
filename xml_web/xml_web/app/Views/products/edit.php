<?php $pageTitle = 'Chỉnh sửa sản phẩm'; ?>
<?php require_once BASE_PATH . '/app/Views/layouts/header.php'; ?>

<div class="container">
    <div class="page-header">
        <h1>Chỉnh sửa sản phẩm</h1>
        <a href="<?php echo BASE_URL; ?>products" class="btn-back">← Quay lại</a>
    </div>
    
    <div class="form-container">
        <form method="POST" action="<?php echo BASE_URL; ?>product/edit?id=<?php echo $product->id; ?>" class="product-form">
            <div class="form-row">
                <div class="form-group">
                    <label>Tên sản phẩm *</label>
                    <input type="text" name="name" value="<?php echo $product->n; ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Giá (VNĐ) *</label>
                    <input type="number" name="price" value="<?php echo $product->price; ?>" required min="0">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Danh mục *</label>
                    <select name="category" required>
                        <option value="Cà phê rang xay" <?php echo $product->category === 'Cà phê rang xay' ? 'selected' : ''; ?>>Cà phê rang xay</option>
                        <option value="Cà phê hòa tan" <?php echo $product->category === 'Cà phê hòa tan' ? 'selected' : ''; ?>>Cà phê hòa tan</option>
                        <option value="Cà phê pha máy" <?php echo $product->category === 'Cà phê pha máy' ? 'selected' : ''; ?>>Cà phê pha máy</option>
                        <option value="Cà phê phin" <?php echo $product->category === 'Cà phê phin' ? 'selected' : ''; ?>>Cà phê phin</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Số lượng *</label>
                    <input type="number" name="stock" value="<?php echo $product->stock; ?>" required min="0">
                </div>
            </div>
            
            <div class="form-group">
                <label>URL hình ảnh *</label>
                <input type="url" name="image" value="<?php echo $product->image; ?>" required>
            </div>
            
            <div class="form-group">
                <label>Mô tả *</label>
                <textarea name="description" rows="5" required><?php echo $product->description; ?></textarea>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn-submit">Cập nhật</button>
                <a href="<?php echo BASE_URL; ?>products" class="btn-cancel">Hủy</a>
            </div>
        </form>
    </div>
</div>

<?php require_once BASE_PATH . '/app/Views/layouts/footer.php'; ?>

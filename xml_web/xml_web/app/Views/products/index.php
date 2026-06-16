<?php $pageTitle = 'Sản phẩm'; ?>
<?php require_once BASE_PATH . '/app/Views/layouts/header.php'; ?>

<div class="container">
    <!-- Hero Section -->
    <div class="hero-section">
        <h1 class="hero-title">Khám phá hương vị cà phê</h1>
        <p class="hero-subtitle">Từng giọt cà phê là một câu chuyện riêng</p>
    </div>
    
    <!-- Filter & Search -->
    <div class="filter-section">
        <form method="GET" action="<?php echo BASE_URL; ?>products" class="search-form">
            <input type="text" name="search" placeholder="Tìm kiếm cà phê..." 
                   value="<?php echo $_GET['search'] ?? ''; ?>">
            <button type="submit">🔍</button>
        </form>
        
        <div class="category-filter">
            <a href="<?php echo BASE_URL; ?>products" 
               class="category-btn <?php echo empty($_GET['category']) ? 'active' : ''; ?>">
                Tất cả
            </a>
            
            <?php foreach ($categories as $cat): ?>
                <a href="<?php echo BASE_URL; ?>products?category=<?php echo urlencode($cat); ?>" 
                   class="category-btn <?php echo ($_GET['category'] ?? '') === $cat ? 'active' : ''; ?>">
                    <?php echo $cat; ?>
                </a>
            <?php endforeach; ?>
        </div>
        
        <?php if (isAdmin()): ?>
            <a href="<?php echo BASE_URL; ?>product/add" class="btn-add-product">+ Thêm sản phẩm</a>
        <?php endif; ?>
    </div>
    
    <!-- Products Grid -->
    <div class="products-grid">
        <?php if (empty($products)): ?>
            <div class="empty-state">
                <p>Không tìm thấy sản phẩm nào</p>
            </div>
        <?php else: ?>
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <div class="product-image">
                        <img src="<?php echo $product->image; ?>" 
                             alt="<?php echo $product->n; ?>">
                        
                        <?php if ((int)$product->stock < 10): ?>
                            <span class="stock-badge">Còn <?php echo $product->stock; ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="product-info">
                        <span class="product-category"><?php echo $product->category; ?></span>
                        <h3 class="product-name"><?php echo $product->n; ?></h3>
                        <p class="product-description"><?php echo substr($product->description, 0, 80); ?>...</p>
                        
                        <div class="product-footer">
                            <span class="product-price"><?php echo formatCurrency($product->price); ?></span>
                            
                            <div class="product-actions">
                                <?php if (isLoggedIn()): ?>
                                    <form method="POST" action="<?php echo BASE_URL; ?>cart/add" class="add-to-cart-form">
                                        <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn-add-cart">
                                            🛒 Thêm
                                        </button>
                                    </form>
                                <?php endif; ?>
                                
                                <?php if (isAdmin()): ?>
                                    <a href="<?php echo BASE_URL; ?>product/edit?id=<?php echo $product->id; ?>" 
                                       class="btn-edit">✏️</a>
                                    <a href="<?php echo BASE_URL; ?>product/delete?id=<?php echo $product->id; ?>" 
                                       class="btn-delete"
                                       onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">🗑️</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php require_once BASE_PATH . '/app/Views/layouts/footer.php'; ?>

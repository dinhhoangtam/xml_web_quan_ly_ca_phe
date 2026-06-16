<?php $pageTitle = 'Quản trị'; ?>
<?php require_once BASE_PATH . '/app/Views/layouts/header.php'; ?>

<div class="container">
    <div class="page-header">
        <h1>Bảng điều khiển</h1>
    </div>
    
    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">📦</div>
            <div class="stat-info">
                <h3>Tổng đơn hàng</h3>
                <p class="stat-number"><?php echo $orderStats['count']; ?></p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">💰</div>
            <div class="stat-info">
                <h3>Doanh thu</h3>
                <p class="stat-number"><?php echo formatCurrency($orderStats['total']); ?></p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">⏳</div>
            <div class="stat-info">
                <h3>Đang xử lý</h3>
                <p class="stat-number"><?php echo $orderStats['pending']; ?></p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">✅</div>
            <div class="stat-info">
                <h3>Hoàn thành</h3>
                <p class="stat-number"><?php echo $orderStats['completed']; ?></p>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="quick-actions">
        <h2>Quản lý nhanh</h2>
        <div class="action-buttons">
            <a href="<?php echo BASE_URL; ?>products" class="action-btn">
                <span class="action-icon">📦</span>
                <span>Quản lý sản phẩm</span>
            </a>
            <a href="<?php echo BASE_URL; ?>orders/manage" class="action-btn">
                <span class="action-icon">📋</span>
                <span>Quản lý đơn hàng</span>
            </a>
            <a href="<?php echo BASE_URL; ?>product/add" class="action-btn">
                <span class="action-icon">➕</span>
                <span>Thêm sản phẩm</span>
            </a>
        </div>
    </div>
    
    <!-- Export/Import Section -->
    <div class="data-management">
        <h2>Quản lý dữ liệu</h2>
        
        <div class="management-grid">
            <div class="management-card">
                <h3>📤 Xuất dữ liệu</h3>
                <p>Xuất dữ liệu sang Excel, PDF hoặc XML</p>
                
                <div class="export-buttons">
                    <h4>Sản phẩm:</h4>
                    <a href="<?php echo BASE_URL; ?>export/excel?type=products" class="btn-export">
                        📊 Excel
                    </a>
                    <a href="<?php echo BASE_URL; ?>export/pdf?type=products" class="btn-export">
                        📄 PDF
                    </a>
                    <a href="<?php echo BASE_URL; ?>export/xml?type=products" class="btn-export">
                        📋 XML
                    </a>
                </div>
                
                <div class="export-buttons">
                    <h4>Đơn hàng:</h4>
                    <a href="<?php echo BASE_URL; ?>export/excel?type=orders" class="btn-export">
                        📊 Excel
                    </a>
                    <a href="<?php echo BASE_URL; ?>export/pdf?type=orders" class="btn-export">
                        📄 PDF
                    </a>
                    <a href="<?php echo BASE_URL; ?>export/xml?type=orders" class="btn-export">
                        📋 XML
                    </a>
                </div>
            </div>
            
            <div class="management-card">
                <h3>📥 Nhập dữ liệu</h3>
                <p>Import dữ liệu từ file XML</p>
                
                <form method="POST" action="<?php echo BASE_URL; ?>import/xml" 
                      enctype="multipart/form-data" class="import-form">
                    <div class="form-group">
                        <label>Loại dữ liệu:</label>
                        <select name="type" required>
                            <option value="products">Sản phẩm</option>
                            <option value="orders">Đơn hàng</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>File XML:</label>
                        <input type="file" name="xml_file" accept=".xml" required>
                    </div>
                    
                    <button type="submit" class="btn-import">📥 Import</button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Recent Orders -->
    <div class="recent-orders">
        <h2>Đơn hàng gần đây</h2>
        
        <?php if (empty($recentOrders)): ?>
            <p>Chưa có đơn hàng nào</p>
        <?php else: ?>
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Mã đơn</th>
                            <th>Khách hàng</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Ngày đặt</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_slice($recentOrders, -10) as $order): ?>
                            <tr>
                                <td><?php echo $order->id; ?></td>
                                <td><?php echo $order->customer_name; ?></td>
                                <td><?php echo formatCurrency($order->total_amount); ?></td>
                                <td>
                                    <span class="status-badge status-<?php echo $order->status; ?>">
                                        <?php
                                        $statuses = [
                                            'pending' => 'Đang xử lý',
                                            'processing' => 'Đang giao',
                                            'completed' => 'Hoàn thành',
                                            'cancelled' => 'Đã hủy'
                                        ];
                                        echo $statuses[(string)$order->status];
                                        ?>
                                    </span>
                                </td>
                                <td><?php echo formatDate($order->created_at); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once BASE_PATH . '/app/Views/layouts/footer.php'; ?>

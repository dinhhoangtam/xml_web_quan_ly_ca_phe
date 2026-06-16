<?php $pageTitle = 'Quản lý đơn hàng'; ?>
<?php require_once BASE_PATH . '/app/Views/layouts/header.php'; ?>

<div class="container">
    <div class="page-header">
        <h1>Quản lý đơn hàng</h1>
        <a href="<?php echo BASE_URL; ?>admin/dashboard" class="btn-back">← Dashboard</a>
    </div>
    
    <?php if (empty($orders)): ?>
        <div class="empty-state">
            <p>Chưa có đơn hàng nào</p>
        </div>
    <?php else: ?>
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th>Khách hàng</th>
                        <th>Số điện thoại</th>
                        <th>Tổng tiền</th>
                        <th>Thanh toán</th>
                        <th>Trạng thái</th>
                        <th>Ngày đặt</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><strong><?php echo $order->id; ?></strong></td>
                            <td><?php echo $order->customer_name; ?></td>
                            <td><?php echo $order->customer_phone; ?></td>
                            <td><strong><?php echo formatCurrency($order->total_amount); ?></strong></td>
                            <td>
                                <?php echo $order->payment_method === 'cod' ? '💵 COD' : '🏦 Chuyển khoản'; ?>
                            </td>
                            <td>
                                <form method="POST" action="<?php echo BASE_URL; ?>order/update_status" 
                                      class="status-form">
                                    <input type="hidden" name="order_id" value="<?php echo $order->id; ?>">
                                    <select name="status" onchange="this.form.submit()" 
                                            class="status-select status-<?php echo $order->status; ?>">
                                        <option value="pending" <?php echo $order->status === 'pending' ? 'selected' : ''; ?>>
                                            Đang xử lý
                                        </option>
                                        <option value="processing" <?php echo $order->status === 'processing' ? 'selected' : ''; ?>>
                                            Đang giao
                                        </option>
                                        <option value="completed" <?php echo $order->status === 'completed' ? 'selected' : ''; ?>>
                                            Hoàn thành
                                        </option>
                                        <option value="cancelled" <?php echo $order->status === 'cancelled' ? 'selected' : ''; ?>>
                                            Đã hủy
                                        </option>
                                    </select>
                                </form>
                            </td>
                            <td><?php echo formatDate($order->created_at); ?></td>
                            <td>
                                <div class="table-actions">
                                    <a href="<?php echo BASE_URL; ?>order/detail?id=<?php echo $order->id; ?>" 
                                       class="btn-icon" title="Xem chi tiết">👁️</a>
                                    <a href="<?php echo BASE_URL; ?>order/print?id=<?php echo $order->id; ?>" 
                                       class="btn-icon" title="In hóa đơn" target="_blank">🖨️</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php require_once BASE_PATH . '/app/Views/layouts/footer.php'; ?>

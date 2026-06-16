<?php
// Model đơn hàng

class OrderModel {
    private $xml;
    private $filename = 'orders.xml';
    
    public function __construct() {
        $this->xml = loadXML($this->filename);
    }
    
    // Tạo đơn hàng mới
    public function create($data) {
        $order = $this->xml->addChild('order');
        $order->addChild('id', generateID('ORD'));
        $order->addChild('user_id', $data['user_id']);
        $order->addChild('customer_name', sanitize($data['customer_name']));
        $order->addChild('customer_email', sanitize($data['customer_email']));
        $order->addChild('customer_phone', sanitize($data['customer_phone']));
        $order->addChild('customer_address', sanitize($data['customer_address']));
        $order->addChild('payment_method', sanitize($data['payment_method']));
        $order->addChild('total_amount', $data['total_amount']);
        $order->addChild('status', 'pending');
        $order->addChild('created_at', date('Y-m-d H:i:s'));
        
        // Thêm items
        $items = $order->addChild('items');
        foreach ($data['items'] as $item) {
            $orderItem = $items->addChild('item');
            $orderItem->addChild('product_id', $item['product_id']);
            $orderItem->addChild('product_name', sanitize($item['product_name']));
            $orderItem->addChild('price', $item['price']);
            $orderItem->addChild('quantity', $item['quantity']);
            $orderItem->addChild('subtotal', $item['subtotal']);
        }
        
        saveXML($this->xml, $this->filename);
        return (string)$order->id;
    }
    
    // Lấy tất cả đơn hàng
    public function getAll() {
        return $this->xml->order ?? [];
    }
    
    // Lấy đơn hàng theo ID
    public function getById($id) {
        foreach ($this->xml->order as $order) {
            if ((string)$order->id === $id) {
                return $order;
            }
        }
        return null;
    }
    
    // Lấy đơn hàng theo user
    public function getByUser($userId) {
        $results = [];
        foreach ($this->xml->order as $order) {
            if ((string)$order->user_id === $userId) {
                $results[] = $order;
            }
        }
        return array_reverse($results); // Mới nhất trước
    }
    
    // Cập nhật trạng thái
    public function updateStatus($id, $status) {
        foreach ($this->xml->order as $order) {
            if ((string)$order->id === $id) {
                $order->status = $status;
                $order->updated_at = date('Y-m-d H:i:s');
                return saveXML($this->xml, $this->filename);
            }
        }
        return false;
    }
    
    // Xóa đơn hàng
    public function delete($id) {
        $index = 0;
        foreach ($this->xml->order as $order) {
            if ((string)$order->id === $id) {
                unset($this->xml->order[$index]);
                return saveXML($this->xml, $this->filename);
            }
            $index++;
        }
        return false;
    }
    
    // Thống kê
    public function getStats() {
        $total = 0;
        $count = 0;
        $pending = 0;
        $completed = 0;
        
        foreach ($this->xml->order as $order) {
            $count++;
            $total += (float)$order->total_amount;
            
            if ((string)$order->status === 'pending') {
                $pending++;
            } elseif ((string)$order->status === 'completed') {
                $completed++;
            }
        }
        
        return [
            'total' => $total,
            'count' => $count,
            'pending' => $pending,
            'completed' => $completed,
            'average' => $count > 0 ? $total / $count : 0
        ];
    }
}

<?php
// Model sản phẩm

class ProductModel {
    private $xml;
    private $filename = 'coffees.xml';
    
    public function __construct() {
        $this->xml = loadXML($this->filename);
    }
    
    // Lấy tất cả sản phẩm
    public function getAll() {
        return $this->xml->product ?? [];
    }
    
    // Lấy sản phẩm theo ID
    public function getById($id) {
        foreach ($this->xml->product as $product) {
            if ((string)$product->id === $id) {
                return $product;
            }
        }
        return null;
    }
    
    // Thêm sản phẩm mới
    public function add($data) {
        $product = $this->xml->addChild('product');
        $product->addChild('id', generateID('PRD'));
        $product->addChild('n', sanitize($data['name']));
        $product->addChild('price', sanitize($data['price']));
        $product->addChild('description', sanitize($data['description']));
        $product->addChild('category', sanitize($data['category']));
        $product->addChild('image', sanitize($data['image']));
        $product->addChild('stock', sanitize($data['stock']));
        $product->addChild('created_at', date('Y-m-d H:i:s'));
        
        return saveXML($this->xml, $this->filename);
    }
    
    // Cập nhật sản phẩm
    public function update($id, $data) {
        foreach ($this->xml->product as $product) {
            if ((string)$product->id === $id) {
                $product->n = sanitize($data['name']);
                $product->price = sanitize($data['price']);
                $product->description = sanitize($data['description']);
                $product->category = sanitize($data['category']);
                $product->image = sanitize($data['image']);
                $product->stock = sanitize($data['stock']);
                $product->updated_at = date('Y-m-d H:i:s');
                
                return saveXML($this->xml, $this->filename);
            }
        }
        return false;
    }
    
    // Xóa sản phẩm
    public function delete($id) {
        $index = 0;
        foreach ($this->xml->product as $product) {
            if ((string)$product->id === $id) {
                unset($this->xml->product[$index]);
                return saveXML($this->xml, $this->filename);
            }
            $index++;
        }
        return false;
    }
    
    // Tìm kiếm sản phẩm
    public function search($keyword) {
        $results = [];
        foreach ($this->xml->product as $product) {
            if (stripos((string)$product->n, $keyword) !== false ||
                stripos((string)$product->description, $keyword) !== false ||
                stripos((string)$product->category, $keyword) !== false) {
                $results[] = $product;
            }
        }
        return $results;
    }
    
    // Lấy sản phẩm theo danh mục
    public function getByCategory($category) {
        $results = [];
        foreach ($this->xml->product as $product) {
            if ((string)$product->category === $category) {
                $results[] = $product;
            }
        }
        return $results;
    }
    
    // Lấy danh mục
    public function getCategories() {
        $categories = [];
        foreach ($this->xml->product as $product) {
            $cat = (string)$product->category;
            if (!in_array($cat, $categories)) {
                $categories[] = $cat;
            }
        }
        return $categories;
    }
    
    // Cập nhật số lượng tồn kho
    public function updateStock($id, $quantity) {
        foreach ($this->xml->product as $product) {
            if ((string)$product->id === $id) {
                $product->stock = (int)$product->stock - $quantity;
                return saveXML($this->xml, $this->filename);
            }
        }
        return false;
    }
}

<?php
// Model người dùng

class UserModel {
    private $xml;
    private $filename = 'users.xml';
    
    public function __construct() {
        $this->xml = loadXML($this->filename);
    }
    
    // Đăng ký người dùng
    public function register($data) {
        // Kiểm tra email đã tồn tại
        if ($this->getByEmail($data['email'])) {
            return false;
        }
        
        $user = $this->xml->addChild('user');
        $user->addChild('id', generateID('USR'));
        $user->addChild('name', sanitize($data['name']));
        $user->addChild('email', sanitize($data['email']));
        $user->addChild('password', password_hash($data['password'], PASSWORD_DEFAULT));
        $user->addChild('phone', sanitize($data['phone'] ?? ''));
        $user->addChild('address', sanitize($data['address'] ?? ''));
        $user->addChild('role', $data['role'] ?? 'user');
        $user->addChild('created_at', date('Y-m-d H:i:s'));
        
        return saveXML($this->xml, $this->filename);
    }
    
    // Đăng nhập
    public function login($email, $password) {
        $user = $this->getByEmail($email);
        if ($user && password_verify($password, (string)$user->password)) {
            return $user;
        }
        return false;
    }
    
    // Lấy user theo email
    public function getByEmail($email) {
        foreach ($this->xml->user as $user) {
            if ((string)$user->email === $email) {
                return $user;
            }
        }
        return null;
    }
    
    // Lấy user theo ID
    public function getById($id) {
        foreach ($this->xml->user as $user) {
            if ((string)$user->id === $id) {
                return $user;
            }
        }
        return null;
    }
    
    // Lấy tất cả user
    public function getAll() {
        return $this->xml->user ?? [];
    }
    
    // Cập nhật thông tin
    public function update($id, $data) {
        foreach ($this->xml->user as $user) {
            if ((string)$user->id === $id) {
                $user->name = sanitize($data['name']);
                $user->phone = sanitize($data['phone']);
                $user->address = sanitize($data['address']);
                $user->updated_at = date('Y-m-d H:i:s');
                
                return saveXML($this->xml, $this->filename);
            }
        }
        return false;
    }
    
    // Đổi mật khẩu
    public function changePassword($id, $newPassword) {
        foreach ($this->xml->user as $user) {
            if ((string)$user->id === $id) {
                $user->password = password_hash($newPassword, PASSWORD_DEFAULT);
                return saveXML($this->xml, $this->filename);
            }
        }
        return false;
    }
}

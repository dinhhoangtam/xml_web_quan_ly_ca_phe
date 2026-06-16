# 📦 Hướng dẫn cài đặt Coffee Shop

## Cài đặt trên XAMPP (Windows)

### Bước 1: Cài đặt XAMPP
1. Tải XAMPP từ: https://www.apachefriends.org
2. Cài đặt XAMPP vào thư mục mặc định: `C:\xampp`
3. Khởi động Apache từ XAMPP Control Panel

### Bước 2: Giải nén website
1. Giải nén file `xml_web.zip`
2. Copy thư mục `xml_web` vào: `C:\xampp\htdocs\`
3. Cấu trúc sẽ là: `C:\xampp\htdocs\xml_web\`

### Bước 3: Cấu hình
1. Mở file `xml_web/core/config.php`
2. Đảm bảo BASE_URL là:
   ```php
   define('BASE_URL', '/xml_web/public/');
   ```

### Bước 4: Cấp quyền
1. Click chuột phải vào thư mục `xml_web/storage`
2. Chọn Properties > Security
3. Cho phép Full Control cho Users

### Bước 5: Truy cập
Mở trình duyệt và truy cập:
```
http://localhost/xml_web/public/
```

---

## Cài đặt trên WAMP (Windows)

### Bước 1: Cài đặt WAMP
1. Tải WAMP từ: https://www.wampserver.com
2. Cài đặt WAMP
3. Khởi động WAMP (icon màu xanh lá)

### Bước 2: Giải nén
1. Giải nén file `xml_web.zip`
2. Copy vào: `C:\wamp64\www\`
3. Cấu trúc: `C:\wamp64\www\xml_web\`

### Bước 3: Cấu hình
Giống như XAMPP, cấu hình BASE_URL trong `core/config.php`

### Bước 4: Truy cập
```
http://localhost/xml_web/public/
```

---

## Cài đặt trên Linux/Ubuntu

### Bước 1: Cài đặt Apache và PHP
```bash
sudo apt update
sudo apt install apache2
sudo apt install php libapache2-mod-php
sudo systemctl restart apache2
```

### Bước 2: Giải nén website
```bash
sudo unzip xml_web.zip -d /var/www/html/
```

### Bước 3: Cấp quyền
```bash
sudo chmod -R 777 /var/www/html/xml_web/storage/xml/
sudo chown -R www-data:www-data /var/www/html/xml_web/
```

### Bước 4: Cấu hình
```bash
sudo nano /var/www/html/xml_web/core/config.php
```
Đảm bảo BASE_URL đúng

### Bước 5: Truy cập
```
http://localhost/xml_web/public/
```

---

## Cài đặt trên macOS

### Bước 1: Enable PHP built-in
macOS đã có sẵn PHP, chỉ cần enable:
```bash
sudo nano /etc/apache2/httpd.conf
```
Uncomment dòng:
```
LoadModule php_module libexec/apache2/libphp.so
```

### Bước 2: Giải nén
```bash
sudo unzip xml_web.zip -d /Library/WebServer/Documents/
```

### Bước 3: Cấp quyền
```bash
sudo chmod -R 777 /Library/WebServer/Documents/xml_web/storage/xml/
```

### Bước 4: Khởi động Apache
```bash
sudo apachectl start
```

### Bước 5: Truy cập
```
http://localhost/xml_web/public/
```

---

## Cài đặt với Docker

### Bước 1: Tạo Dockerfile
```dockerfile
FROM php:7.4-apache
COPY xml_web/ /var/www/html/xml_web/
RUN chmod -R 777 /var/www/html/xml_web/storage/xml/
EXPOSE 80
```

### Bước 2: Build và Run
```bash
docker build -t coffee-shop .
docker run -p 80:80 coffee-shop
```

### Bước 3: Truy cập
```
http://localhost/xml_web/public/
```

---

## Kiểm tra cài đặt

### 1. Kiểm tra PHP
```bash
php -v
```
Cần PHP >= 7.4

### 2. Kiểm tra quyền ghi
```bash
touch xml_web/storage/xml/test.txt
```
Nếu tạo được file là OK

### 3. Kiểm tra Apache
```bash
# Linux/macOS
sudo systemctl status apache2

# Windows
Xem XAMPP Control Panel
```

---

## Troubleshooting

### Lỗi 404 Not Found
**Nguyên nhân:** BASE_URL không đúng
**Giải pháp:** 
1. Mở `core/config.php`
2. Sửa `BASE_URL` cho đúng với cấu trúc thư mục

### Lỗi Permission Denied
**Nguyên nhân:** Không có quyền ghi file
**Giải pháp:**
```bash
# Linux/macOS
sudo chmod -R 777 storage/xml/

# Windows
Click chuột phải > Properties > Security > Full Control
```

### Không hiển thị sản phẩm
**Nguyên nhân:** File XML bị lỗi hoặc không tồn tại
**Giải pháp:**
1. Kiểm tra file `storage/xml/coffees.xml` có tồn tại
2. Kiểm tra cấu trúc XML hợp lệ
3. Restore từ backup nếu cần

### QR Code không hiển thị
**Nguyên nhân:** Server không kết nối được internet
**Giải pháp:**
- Đảm bảo server có kết nối internet
- QR API cần internet để tải ảnh

### Lỗi Session
**Nguyên nhân:** PHP session không hoạt động
**Giải pháp:**
```bash
# Tạo thư mục session
sudo mkdir -p /var/lib/php/sessions
sudo chmod 777 /var/lib/php/sessions
```

---

## Cấu hình nâng cao

### Enable mod_rewrite (Apache)
```bash
# Linux
sudo a2enmod rewrite
sudo systemctl restart apache2

# Windows XAMPP
Đã enable mặc định
```

### Tăng upload file size
Mở `php.ini`:
```ini
upload_max_filesize = 20M
post_max_size = 20M
```

### Enable error reporting (Dev only)
Mở `core/config.php`:
```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

---

## Backup và Restore

### Backup
1. Backup thư mục `storage/xml/`
2. Copy 3 file:
   - coffees.xml
   - orders.xml
   - users.xml

### Restore
1. Copy file XML đã backup
2. Paste vào `storage/xml/`
3. Cấp quyền 777

---

## Update

### Cập nhật phiên bản mới
1. Backup dữ liệu XML
2. Giải nén phiên bản mới
3. Copy file XML từ backup vào
4. Kiểm tra config.php

---

## Security Tips

1. **Đổi mật khẩu mặc định** ngay sau khi cài đặt
2. **Không public thư mục storage** ra ngoài
3. **Enable HTTPS** khi deploy production
4. **Backup định kỳ** dữ liệu XML
5. **Giới hạn quyền** thư mục chỉ 755 khi production

---

## Liên hệ hỗ trợ

Nếu gặp vấn đề khi cài đặt:
- Email: contact@coffeehouse.vn
- Hotline: 0123 456 789

---

**Chúc bạn cài đặt thành công!** ☕

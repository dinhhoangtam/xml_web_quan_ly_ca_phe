# ☕ Coffee Shop - Website Bán Cà Phê với XML

Website bán cà phê hiện đại được xây dựng bằng PHP và XML, có đầy đủ tính năng admin và user.

## 🌟 Tính năng

### Dành cho Khách hàng (User)
- 🔐 Đăng ký / Đăng nhập tài khoản
- 🛍️ Xem danh sách sản phẩm cà phê
- 🔍 Tìm kiếm và lọc sản phẩm theo danh mục
- 🛒 Thêm sản phẩm vào giỏ hàng
- 💳 Thanh toán qua:
  - COD (Thanh toán khi nhận hàng)
  - Chuyển khoản ngân hàng (QR Code)
- 📦 Quản lý đơn hàng của mình
- 🖨️ In hóa đơn

### Dành cho Quản trị viên (Admin)
- 📊 Dashboard thống kê tổng quan
- ➕ Thêm / ✏️ Sửa / 🗑️ Xóa sản phẩm
- 📋 Quản lý đơn hàng
- 🔄 Cập nhật trạng thái đơn hàng
- 📤 Xuất dữ liệu:
  - Excel (.xls)
  - PDF (.pdf)
  - XML (.xml)
- 📥 Nhập dữ liệu từ file XML

## 🚀 Cài đặt

### Yêu cầu hệ thống
- PHP >= 7.4
- Web Server (Apache/Nginx)
- Quyền ghi file trong thư mục `storage/xml/`

### Hướng dẫn cài đặt

1. **Giải nén file zip** vào thư mục web server của bạn:
   ```
   /htdocs/xml_web/
   hoặc
   /var/www/html/xml_web/
   ```

2. **Cấu hình quyền truy cập** cho thư mục storage:
   ```bash
   chmod -R 777 storage/xml/
   ```

3. **Cấu hình BASE_URL** trong file `core/config.php`:
   ```php
   define('BASE_URL', '/xml_web/public/');
   ```
   
   Nếu bạn đặt ở thư mục khác, thay đổi đường dẫn cho phù hợp.

4. **Truy cập website**:
   ```
   http://localhost/xml_web/public/
   ```

## 👤 Tài khoản demo

### Admin
- **Email:** admin@coffee.vn
- **Mật khẩu:** admin123

### User
- **Email:** user@coffee.vn
- **Mật khẩu:** user123

## 📂 Cấu trúc thư mục

```
xml_web/
├── app/
│   ├── Controllers/      # Các controller
│   ├── Models/           # Các model xử lý dữ liệu
│   └── Views/            # Giao diện
├── public/               # Thư mục public
│   ├── index.php         # Entry point
│   └── assets/           # CSS, JS, hình ảnh
├── core/                 # Core files
│   ├── config.php        # Cấu hình
│   └── lib.php           # Thư viện hàm
├── storage/
│   └── xml/              # Lưu trữ dữ liệu XML
│       ├── coffees.xml   # Sản phẩm
│       ├── orders.xml    # Đơn hàng
│       └── users.xml     # Người dùng
└── routes.php            # Định tuyến
```

## 💳 Thanh toán

### Thanh toán khi nhận hàng (COD)
- Khách hàng chọn phương thức COD
- Thanh toán bằng tiền mặt khi nhận hàng

### Chuyển khoản ngân hàng
- Hệ thống tự động tạo mã QR VietQR
- **Ngân hàng:** Agribank
- **Số tài khoản:** 7204205173204
- Quét mã QR bằng app ngân hàng để thanh toán

## 🖨️ In hóa đơn

- Sau khi đặt hàng thành công, click nút "In hóa đơn"
- Hóa đơn sẽ mở trong tab mới
- Sử dụng Ctrl+P hoặc nút "In hóa đơn" để in

## 📊 Xuất/Nhập dữ liệu

### Xuất dữ liệu
1. Đăng nhập với tài khoản Admin
2. Vào Dashboard
3. Chọn loại dữ liệu cần xuất (Sản phẩm/Đơn hàng)
4. Chọn định dạng (Excel/PDF/XML)
5. File sẽ tự động tải về

### Nhập dữ liệu
1. Đăng nhập với tài khoản Admin
2. Vào Dashboard
3. Chọn "Nhập dữ liệu"
4. Chọn loại dữ liệu
5. Upload file XML
6. Click "Import"

## 🎨 Giao diện

Website được thiết kế với:
- **Font chữ:** Playfair Display (tiêu đề) + Work Sans (nội dung)
- **Màu sắc:** Tông nâu cafe sang trọng
- **Hiệu ứng:** Animations mượt mà, hover effects
- **Responsive:** Tương thích mọi thiết bị

## 🔧 Tùy chỉnh

### Thay đổi thông tin ngân hàng
Mở file `core/config.php`:
```php
define('BANK_ACCOUNT', 'SỐ_TÀI_KHOẢN_CỦA_BẠN');
define('BANK_NAME', 'TÊN_NGÂN_HÀNG');
```

### Thêm danh mục sản phẩm mới
Mở file `app/Views/products/add.php` và thêm option mới:
```html
<option value="Tên danh mục mới">Tên danh mục mới</option>
```

## 🐛 Xử lý lỗi

### Lỗi không tải được trang
- Kiểm tra đường dẫn BASE_URL trong `core/config.php`
- Kiểm tra mod_rewrite đã bật trên Apache

### Lỗi không ghi được file
- Cấp quyền 777 cho thư mục `storage/xml/`
- Kiểm tra PHP có quyền ghi file

### Lỗi không hiển thị sản phẩm
- Kiểm tra file `storage/xml/coffees.xml` có tồn tại
- Kiểm tra cấu trúc XML đúng định dạng

## 📱 Liên hệ hỗ trợ

- **Email:** contact@coffeehouse.vn
- **Hotline:** 0123 456 789
- **Địa chỉ:** Cà Mau, Việt Nam

## 📄 License

Dự án này được phát triển cho mục đích học tập và thương mại.

## 🙏 Credits

- **Icons:** Unicode Emoji
- **Images:** Unsplash (mẫu demo)
- **QR Code:** VietQR API
- **Fonts:** Google Fonts

---

**Phát triển bởi Coffee House Team** ☕
Phiên bản: 1.0.0
Ngày cập nhật: Tháng 12, 2024

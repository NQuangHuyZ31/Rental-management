# Hosty – Hệ thống quản lý nhà trọ

![enter image description here](https://res.cloudinary.com/whr-clound/image/upload/v1765272311/cayvwwf1eeynsckmi0cf.png)
Hosty là hệ thống hỗ trợ chủ trọ trong việc quản lý phòng, hoá đơn, người thuê và các tiện ích liên quan. Hệ thống được xây dựng nhằm tối ưu hóa quy trình vận hành, giảm thiểu công việc thủ công, tiết kiệm thời gian và tăng tính chính xác.

## 🚀 Tính năng chính

-   **Đăng nhập/Đăng ký/Quên mật khẩu**

-   **Tìm kiếm phòng trọ**

-   **Xem thông tin phòng đang thuê/Xem thông tin hóa đơn/Thanh toán hóa đơn qua QR code**

-   **Gửi yêu cầu hỗ trợ/Báo cáo bài đăng**

-   **Quản lý nhà trọ**: Thêm/sửa/xoá nhà trọ, theo dõi tình trạng phòng.

-   **Quản lý phòng trọ**: Thêm/sửa/xoá phòng, theo dõi tình trạng phòng.
-   **Quản lý người thuê**: Lưu trữ thông tin khách thuê.
-   **Quản lý tài sản/Quản lý dịch vụ **
-   **Quản lý hoá đơn**: Tự động tạo hoá đơn theo kỳ, theo dõi thanh toán.
-   **Duyệt bài đăng**
-   **Quản lý tài khoản người dùng**
-   **Phân quyền người dùng**

-   **Bảo mật SQL Injection, XSS, CSRF,...**

---

# 🛠️ Hướng dẫn setup source để chạy

## 1. Yêu cầu hệ thống

-   **PHP >= 8.1**
-   **Composer**
-   **MySQL >= 5.7** hoặc **MariaDB**
-   **Node.js >= 16** + **NPM/Yarn**

## 2. Chuẩn bị

-   **Tải phần mềm xampp**: [https://www.apachefriends.org/download.html](https://www.apachefriends.org/download.html)
-   **Nodejs**: [https://nodejs.org/en/download](https://nodejs.org/en/download)

-   **Composer**: [https://getcomposer.org/](https://getcomposer.org/)

-   Công cụ hỗ trợ code: vscode,...

## 3. Clone source

-   **Tải source code tại**: [https://github.com/NQuangHuyZ31/Rental-management](https://github.com/NQuangHuyZ31/Rental-management).
-   Giải nén forder source vào thư mục htdocs của forder xampp
    Hoặc clone source
-   Mở forder xampp -> vào thư mục htdocs -> tạo forder
-   Mở vscode -> truy cập vào forder vừa tạo và nhập lên

```bash
git clone https://github.com/NQuangHuyZ31/Rental-management.git
cd Rental-management
```

## 4. Cài đặt thư viện backend

```bash
composer install
```

## 5. Cài đặt thư viện frontend

```bash
npm install
# hoặc
yarn install

```

-   Vào forder Public -> js -> tìm file app.js
-   Tìm dòng: appURL: '/Rental-management/',
-   Sửa lại theo đường dẫn của bạn để có thể chạy js

## 6. Tạo database

-   Tạo csdl từ phpmyadmin của ứng dụng xampp
-   Nhập file csdl từ forder database của source

## 7. Tạo file môi trường

-   Copy file .env.example và xóa đuôi .example
-   Thêm thông tin

```bash
APP_NAME="rental-management"  #tên ứng dụng

APP_ENV="local" #Môi trường ứng dụng

APP_URL="http://example.com" #Link truy cập ứng dụng

ROOT_SITE_URL="C:/xampp-v8.2/htdocs/Rental-management" #expamle: "home/user/user123/public_html/"

# Cấu hình database
DB_HOST="localhost"

DB_USER="root"

DB_PASS=""

DB_NAME="database_name"

# key dùng để xác thực tài khoản khi đăng ký
VERIFY_ACCOUNT_KEY=""

# Cấu hình Cloudinary nếu cần upload hình ảnh lên cloudinary
CLOUD_NAME=""

CLOUD_API_KEY=""

CLOUD_API_SECRET=""

```

## 8. Chạy queue

Các chức năng có gửi mail hoặc upload hình ảnh lên cloudinary cần chạy queue để co thể thực hiện
Mỗi khi chạy sẽ duy trì trong 1 phút, nếu muốn chạy lại thì phải chạy lại câu lệnh

```bash
#Câu lệnh chạy queue
php queue-worker.php
```

## 9. Thanh toán

Chức năng thanh toán qua QR code sử dụng api của sepay để theo dõi biến động số dư.
Cách cấu hình xem tại đây:

# Hướng dẫn tích hợp thanh toán

Hướng dẫn chi tiết để thiết lập hệ thống thanh toán với Sepay

1. Đăng ký Sepay

2. Liên kết ngân hàng

3. Tích hợp Webhook

## Bước 1: Đăng ký tài khoản Sepay

Tạo tài khoản Sepay để sử dụng dịch vụ thanh toán

### 📋

![Sepay Register](https://hosty.shoplands.store/public/images/image.png)

### 🔗 Liên kết đăng ký:

[Đăng ký Sepay](https://sepay.vn/register)

## Bước 2: Liên kết tài khoản ngân hàng

Kết nối tài khoản ngân hàng với Sepay để nhận thanh toán

### 🏦 Đăng nhập vào sepay -> Mục ngân hàng -> chọn kết nối tài khoản

![Sepay Bank](https://hosty.shoplands.store/public/images/guide-1.png)

### - Chọn ngân hàng và nhập thông tin tài khoản

## Bước 3: Tạo API key

Tạo API key để xác thực webhook từ Sepay

### 🏦 Đăng nhập vào sepay -> Mục Cấu hình công ty -> API access -> Thêm API key

![Sepay Bank](https://hosty.shoplands.store/public/images/guide-2.png)

### - Copy lại API key

## Bước 4: Tích hợp Webhook

Cấu hình webhook để thanh toán tự động

### 🔗 Webhook URL:

URL chỉ là ví dụ, có thể thay đổi tùy theo domain của bạn
`https://hosty.shoplands.store/customer/payment/callback`

### ⚙️ Cấu hình trong Sepay:

1.  1. Chọn tích hợp webhook
2.  2. Chọn thêm webhook
3.  3. Nhập thông tin webhook
4.  4. Copy url webhook ở trên và nhập vào

![Sepay Webhook](https://hosty.shoplands.store/public/images/guide-3.png)

1.  5. Kiểu chứng thực chọn API Key
2.  6. Nhập API key vừa tạo

![Sepay Webhook](https://hosty.shoplands.store/public/images/guide-4.png)

### - Lưu webhook

## Bước 5: Lưu thông tin trên hệ thống hosty

Lưu thông tin trên hệ thống hosty

### Đăng nhập vào hệ thống hosty -> Mục Cài đặt chung -> Thanh toán -> Thêm thông tin ngân hàng

![Sepay Webhook](https://hosty.shoplands.store/public/images/guide-5.png)

### Nhập thông tin ngân hàng và lưu (API key là API key từ Sepay được cấu hình vào webhook)

## 10. Bật/tắt log

Bạn có thể bật/tắt log sql khi chạy hệ thống:

-   Vào forder Core của source -> tìm file QueryBuilder.php.
-   Tìm dòng: protected $logsql = true;
-   Set false nếu muốn tắt và true nếu muốn bật.

# ✔️ Hoàn tất

Sau khi thực hiện các bước trên, hệ thống Hosty đã sẵn sàng để sử dụng.

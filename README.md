# QUẢN LÝ PHÒNG KHÁM NHA KHOA T&A

## 1. GIỚI THIỆU

### 1.1 Mục đích
Hệ thống Quản lý phòng khám nha khoa T&A được phát triển nhằm giúp bệnh nhân dễ dàng đặt lịch khám bệnh tại phòng khám nha khoa, giúp quản lý lịch hẹn hiệu quả cho phòng khám nha khoa và cải thiện trải nghiệm sử dụng dịch vụ cho người dùng.

### 1.2 Phạm vi
Hệ thống cung cấp các chức năng:
- Đăng ký, đăng nhập tài khoản người dùng
- Xem thông tin về chuyên khoa và bác sĩ
- Đặt lịch khám bệnh trực tuyến
- Quản lý lịch hẹn cho bác sĩ
- Quản trị hệ thống toàn diện cho quản trị viên

### 1.3 Đối tượng sử dụng
- **Bệnh nhân/Người dùng cuối**: Người có nhu cầu đặt lịch sử dụng dịch vụ nha khoa
- **Bác sĩ**: Người quản lý và xác nhận lịch hẹn khám
- **Quản trị viên**: Người quản lý toàn bộ hệ thống

## 2. MÔ TẢ TỔNG QUAN

### 2.1 Mô hình hệ thống
Hệ thống được phát triển theo mô hình web application với các thành phần:
- **Frontend**: HTML, CSS, JavaScript, Bootstrap 5
- **Backend**: PHP
- **Cơ sở dữ liệu**: MySQL

### 2.2 Các chức năng chính
1. **Xem thông tin nha khoa**
   - Xem danh sách chuyên khoa của phòng khám
   - Xem danh sách bác sĩ theo chuyên khoa
   - Xem thông tin chi tiết bác sĩ
   - Xem tin tức và dịch vụ của phòng khám

2. **Đặt lịch khám**
   - Chọn dịch vụ và bác sĩ
   - Chọn ngày và giờ khám
   - Điền thông tin cá nhân
   - Mô tả triệu chứng
   - Xác nhận và theo dõi lịch hẹn



## 3. YÊU CẦU CHỨC NĂNG CHI TIẾT

### 3.1 Phân hệ người dùng (Bệnh nhân)

#### 3.1.1 Đăng ký và đăng nhập
- Đăng ký tài khoản với họ tên, email, mật khẩu
- Đăng nhập bằng email và mật khẩu
- Khôi phục mật khẩu qua email

#### 3.1.2 Xem thông tin
- Xem danh sách chuyên khoa của phòng khám
- Xem thông tin chi tiết về chuyên khoa của phòng khám
- Xem danh sách bác sĩ của từng chuyên khoa
- Xem thông tin chi tiết về bác sĩ (chuyên môn, kinh nghiệm, lịch làm việc)
- Xem tin tức và bài viết về sức khỏe
- Xem thông tin về các dịch vụ của phòng khám

#### 3.1.3 Đặt lịch khám
- Chọn chuyên khoa và dịch vụ
- Chọn bác sĩ
- Chọn ngày và giờ khám
- Điền thông tin cá nhân (họ tên, giới tính, năm sinh, số điện thoại, địa chỉ)
- Mô tả triệu chứng
- Xem chi phí dịch vụ
- Xác nhận đặt lịch
- Nhận thông báo xác nhận qua email

#### 3.1.4 Quản lý lịch hẹn
- Xem danh sách lịch hẹn đã đặt
- Xem chi tiết lịch hẹn
- Hủy hoặc thay đổi lịch hẹn

### 3.2 Phân hệ bác sĩ

#### 3.2.1 Quản lý lịch hẹn
- Xem danh sách lịch hẹn theo ngày, tuần
- Lọc lịch hẹn theo trạng thái (chờ xác nhận, đã xác nhận, đã hủy)
- Xem chi tiết lịch hẹn và thông tin bệnh nhân
- Xác nhận hoặc hủy lịch hẹn

#### 3.2.2 Quản lý thông tin cá nhân
- Cập nhật thông tin cá nhân
- Cập nhật lịch làm việc

### 3.3 Phân hệ quản trị viên

#### 3.3.1 Tổng quan hệ thống
- Xem thống kê tổng quan (số lượng lịch hẹn, số bác sĩ, số bệnh nhân)
#### 3.3.2 Quản lý bác sĩ
- Thêm, sửa, xóa thông tin bác sĩ
- Phân công bác sĩ theo chuyên khoa của phòng khám

#### 3.3.3 Quản lý bệnh nhân
- Xem danh sách bệnh nhân
- Xem chi tiết thông tin bệnh nhân

#### 3.3.4 Quản lý chuyên khoa của phòng khám 
- Thêm, sửa, xóa chuyên khoa
- Quản lý thông tin chi tiết về chuyên khoa

#### 3.3.5 Quản lý dịch vụ
- Thêm, sửa, xóa dịch vụ
- Cập nhật giá dịch vụ

## 4. YÊU CẦU PHI CHỨC NĂNG

### 4.1 Giao diện người dùng
- Giao diện thân thiện, dễ sử dụng
- Tương thích với các thiết bị di động (responsive design)
- Thời gian phản hồi nhanh

### 4.2 Bảo mật
- Mã hóa thông tin đăng nhập
- Bảo mật thông tin cá nhân của bệnh nhân
- Phân quyền truy cập cho từng loại người dùng

## 5. KẾ HOẠCH TRIỂN KHAI

### 5.1 Yêu cầu hệ thống
- **Web server**: Apache
- **PHP**: Phiên bản 7.4 trở lên
- **MySQL**: Phiên bản 5.7 trở lên

### 5.2 Hướng dẫn cài đặt
1. Cài đặt XAMPP (bao gồm Apache, MySQL, PHP)
2. Clone mã nguồn vào thư mục htdocs
3. Tạo cơ sở dữ liệu và import schema
4. Cấu hình kết nối cơ sở dữ liệu
5. Truy cập trang web qua localhost

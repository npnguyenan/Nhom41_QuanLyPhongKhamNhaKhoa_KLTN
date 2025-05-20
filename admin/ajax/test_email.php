<?php
/**
 * Xử lý gửi email kiểm tra từ trang cài đặt
 */

// Kết nối đến database
require_once '../../includes/db_connect.php';

// Load các hàm tiện ích
require_once '../../includes/functions.php';

// Kiểm tra phiên đăng nhập
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['vai_tro'] !== 'admin') {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Không có quyền truy cập']);
    exit;
}

// Kiểm tra request là POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ']);
    exit;
}

// Lấy dữ liệu từ request
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['email']) || empty($data['email'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Vui lòng nhập địa chỉ email']);
    exit;
}

$to = $data['email'];
$subject = isset($data['subject']) && !empty($data['subject']) ? $data['subject'] : 'Kiểm tra cấu hình email';

// Lấy thông tin từ cài đặt
$site_name = get_setting('site_name', 'Hệ thống đặt lịch khám');
$site_url = get_setting('site_url', '');
$site_logo = get_setting('site_logo', '');
$logo_url = !empty($site_logo) && !empty($site_url) ? $site_url . '/' . $site_logo : '';

// Tạo nội dung email
$message = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        .logo { max-height: 80px; }
        h1 { color: #2b579a; font-size: 24px; margin-bottom: 20px; }
        .content { background-color: #f8f9fa; padding: 20px; border-left: 4px solid #2b579a; }
        .footer { font-size: 12px; color: #777; margin-top: 30px; padding-top: 10px; border-top: 1px solid #eee; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            ' . (!empty($logo_url) ? '<img src="' . $logo_url . '" alt="' . $site_name . '" class="logo">' : '') . '
            <h1>' . $site_name . '</h1>
        </div>
        
        <div class="content">
            <h2>Email kiểm tra thành công!</h2>
            <p>Đây là email kiểm tra từ hệ thống đặt lịch khám. Nếu bạn nhận được email này, có nghĩa là cấu hình SMTP của bạn hoạt động chính xác.</p>
            <p>Thời gian gửi: ' . date('Y-m-d H:i:s') . '</p>
        </div>
        
        <div class="footer">
            <p>Email này được gửi tự động từ hệ thống ' . $site_name . '.</p>
        </div>
    </div>
</body>
</html>
';

// Gửi email
$result = send_email($to, $subject, $message);

// Trả về kết quả
header('Content-Type: application/json');
if ($result) {
    echo json_encode(['success' => true, 'message' => 'Gửi email kiểm tra thành công! Vui lòng kiểm tra hộp thư của bạn.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Không thể gửi email. Vui lòng kiểm tra lại cấu hình.']);
}
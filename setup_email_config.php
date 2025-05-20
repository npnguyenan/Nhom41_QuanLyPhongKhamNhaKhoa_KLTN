<?php
/**
 * Công cụ kiểm tra và cài đặt cấu hình email
 * File này sẽ kiểm tra tất cả các thành phần cần thiết để gửi email và chẩn đoán lỗi
 */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Công cụ kiểm tra cấu hình email</h1>";

// 1. Kiểm tra kết nối cơ sở dữ liệu
echo "<h2>1. Kiểm tra kết nối cơ sở dữ liệu</h2>";
try {
    require_once 'includes/db_connect.php';
    echo "<p style='color: green;'>✓ Kết nối cơ sở dữ liệu thành công</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Lỗi kết nối cơ sở dữ liệu: " . $e->getMessage() . "</p>";
    exit();
}

// 2. Kiểm tra cài đặt PHP
echo "<h2>2. Kiểm tra cài đặt PHP</h2>";

// Kiểm tra phiên bản PHP
echo "<p>Phiên bản PHP: <strong>" . phpversion() . "</strong></p>";

// Kiểm tra các extension cần thiết
$required_extensions = ['openssl', 'mbstring', 'curl', 'fileinfo', 'mysqli'];
$missing_extensions = [];

foreach ($required_extensions as $ext) {
    if (!extension_loaded($ext)) {
        $missing_extensions[] = $ext;
        echo "<p style='color: red;'>✗ Extension <strong>$ext</strong> chưa được cài đặt</p>";
    } else {
        echo "<p style='color: green;'>✓ Extension <strong>$ext</strong> đã được cài đặt</p>";
    }
}

if (!empty($missing_extensions)) {
    echo "<p style='color: orange;'>Để kích hoạt các extension còn thiếu, mở file php.ini và bỏ comment (xóa dấu ; ở đầu dòng) các extension trên</p>";
    echo "<p>Vị trí file php.ini: " . php_ini_loaded_file() . "</p>";
}

// 3. Kiểm tra thư PHPMailer
echo "<h2>3. Kiểm tra thư viện PHPMailer</h2>";
if (file_exists('PHPMailer/src/PHPMailer.php')) {
    echo "<p style='color: green;'>✓ Tìm thấy thư viện PHPMailer</p>";
    
    try {
        // Nạp các lớp PHPMailer
        require_once 'PHPMailer/src/Exception.php';
        require_once 'PHPMailer/src/PHPMailer.php';
        require_once 'PHPMailer/src/SMTP.php';
        
        echo "<p style='color: green;'>✓ Đã nạp các class PHPMailer thành công</p>";
    } catch (Exception $e) {
        echo "<p style='color: red;'>✗ Lỗi khi nạp PHPMailer: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p style='color: red;'>✗ Không tìm thấy thư mục PHPMailer/src/PHPMailer.php</p>";
}

// 4. Kiểm tra cấu hình SMTP
echo "<h2>4. Kiểm tra cấu hình SMTP</h2>";

// Load functions
require_once 'includes/functions.php';

$smtp_host = get_setting('smtp_host', '');
$smtp_port = get_setting('smtp_port', '587');
$smtp_username = get_setting('smtp_username', '');
$smtp_password = get_setting('smtp_password', '');
$smtp_secure = get_setting('smtp_secure', 'tls');
$site_email = get_setting('site_email', '');

if (empty($smtp_host) || empty($smtp_username) || empty($smtp_password)) {
    echo "<p style='color: red;'>✗ Cấu hình SMTP chưa đầy đủ. Vui lòng cấu hình trong trang quản trị.</p>";
    echo "<ul>";
    echo "<li>Host: " . ($smtp_host ? $smtp_host : "<span style='color:red'>Chưa cấu hình</span>") . "</li>";
    echo "<li>Port: " . ($smtp_port ? $smtp_port : "<span style='color:red'>Chưa cấu hình</span>") . "</li>";
    echo "<li>Username: " . ($smtp_username ? $smtp_username : "<span style='color:red'>Chưa cấu hình</span>") . "</li>";
    echo "<li>Password: " . ($smtp_password ? "<span style='color:green'>Đã cấu hình</span>" : "<span style='color:red'>Chưa cấu hình</span>") . "</li>";
    echo "<li>Secure: " . ($smtp_secure ? $smtp_secure : "<span style='color:red'>Chưa cấu hình</span>") . "</li>";
    echo "<li>Site email: " . ($site_email ? $site_email : "<span style='color:red'>Chưa cấu hình</span>") . "</li>";
    echo "</ul>";
} else {
    echo "<p style='color: green;'>✓ Cấu hình SMTP đã đầy đủ</p>";
    echo "<ul>";
    echo "<li>Host: " . $smtp_host . "</li>";
    echo "<li>Port: " . $smtp_port . "</li>";
    echo "<li>Username: " . $smtp_username . "</li>";
    echo "<li>Password: <span style='color:green'>Đã cấu hình</span></li>";
    echo "<li>Secure: " . $smtp_secure . "</li>";
    echo "<li>Site email: " . ($site_email ?: $smtp_username) . "</li>";
    echo "</ul>";
}

// 5. Thử gửi email với chế độ debug
echo "<h2>5. Kiểm tra gửi email với chế độ debug</h2>";

if (isset($_POST['send_test'])) {
    $to = $_POST['test_email'];
    $subject = "Kiểm tra cấu hình email - " . date('Y-m-d H:i:s');
    
    // Tự tạo object PHPMailer để có thể xem lỗi
  
    
    $mail = new PHPMailer(true);
    
    try {
        // Output buffering để bắt debug
        ob_start();
        
        // Cấu hình debug
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->Debugoutput = function($str, $level) {
            echo htmlspecialchars($str);
        };
        
        // Cấu hình máy chủ
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';
        
        // Sử dụng SMTP
        $mail->isSMTP();
        $mail->Host = $smtp_host;
        $mail->SMTPAuth = true;
        $mail->Username = $smtp_username;
        $mail->Password = $smtp_password;
        
        // Cài đặt phương thức bảo mật
        if ($smtp_secure == 'tls') {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        } elseif ($smtp_secure == 'ssl') {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        } else {
            $mail->SMTPSecure = '';
            $mail->SMTPAutoTLS = false;
        }
        
        $mail->Port = intval($smtp_port);
        
        // Người gửi và người nhận
        $mail->setFrom($site_email ?: $smtp_username, 'Test System');
        $mail->addAddress($to);
        
        // Nội dung
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = '<h1>Xin chào!</h1><p>Đây là email kiểm tra từ hệ thống. Nếu bạn nhận được email này nghĩa là cấu hình email của bạn đã hoạt động!</p>';
        $mail->AltBody = 'Đây là email kiểm tra từ hệ thống. Nếu bạn nhận được email này nghĩa là cấu hình email của bạn đã hoạt động!';
        
        // Gửi email
        $mail->send();
        
        $debug_output = ob_get_clean();
        echo "<div style='background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 20px;'>";
        echo "<pre>" . $debug_output . "</pre>";
        echo "</div>";
        
        echo "<p style='color: green; font-weight: bold;'>✓ Gửi email thành công đến " . htmlspecialchars($to) . "</p>";
    } catch (Exception $e) {
        $debug_output = ob_get_clean();
        echo "<div style='background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 20px;'>";
        echo "<pre>" . $debug_output . "</pre>";
        echo "</div>";
        
        echo "<p style='color: red; font-weight: bold;'>✗ Không thể gửi email: " . htmlspecialchars($mail->ErrorInfo) . "</p>";
        
        // Gợi ý khắc phục dựa trên lỗi
        if (strpos($mail->ErrorInfo, 'Could not authenticate') !== false) {
            echo "<p style='color: orange;'><strong>Gợi ý:</strong> Tên người dùng hoặc mật khẩu SMTP không chính xác. Nếu bạn đang sử dụng Gmail, hãy đảm bảo rằng bạn đã sử dụng mật khẩu ứng dụng.</p>";
        }
        
        if (strpos($mail->ErrorInfo, 'Could not connect to SMTP host') !== false) {
            echo "<p style='color: orange;'><strong>Gợi ý:</strong> Không thể kết nối đến máy chủ SMTP. Kiểm tra lại host, port và tường lửa.</p>";
        }
        
        if (strpos($mail->ErrorInfo, 'stream_socket_enable_crypto') !== false) {
            echo "<p style='color: orange;'><strong>Gợi ý:</strong> Vấn đề với mã hóa kết nối. Hãy thử đổi phương thức bảo mật từ TLS sang SSL hoặc ngược lại.</p>";
        }
        
        if (strpos($mail->ErrorInfo, 'instantiate mail function') !== false) {
            echo "<p style='color: orange;'><strong>Gợi ý:</strong> PHP không thể khởi tạo hàm mail(). Đảm bảo PHP được cấu hình với SMTP server hoặc Sendmail đúng cách trong php.ini.</p>";
        }
    }
}

?>

<h2>6. Gửi email kiểm tra</h2>
<form method="post">
    <div style="margin-bottom: 15px;">
        <label for="test_email" style="display: block; margin-bottom: 5px;">Địa chỉ email nhận:</label>
        <input type="email" id="test_email" name="test_email" required style="width: 300px; padding: 8px;">
    </div>
    <button type="submit" name="send_test" style="padding: 8px 15px; background-color: #0d6efd; color: white; border: none; border-radius: 4px; cursor: pointer;">Gửi email kiểm tra</button>
</form>

<h2>7. Cài đặt SMTP Gmail</h2>
<p>Nếu bạn đang sử dụng Gmail, hãy làm theo các bước sau:</p>
<ol>
    <li>Đăng nhập vào tài khoản Google</li>
    <li>Truy cập <a href="https://myaccount.google.com/security" target="_blank">Cài đặt bảo mật</a></li>
    <li>Bật xác thực 2 bước (nếu chưa bật)</li>
    <li>Tạo "Mật khẩu ứng dụng" mới cho ứng dụng web</li>
    <li>Sử dụng mật khẩu ứng dụng này trong cài đặt SMTP</li>
</ol>

<h3>Cài đặt SMTP cho Gmail:</h3>
<ul>
    <li>SMTP Host: smtp.gmail.com</li>
    <li>SMTP Port: 587</li>
    <li>SMTP Secure: TLS</li>
    <li>SMTP Username: your.email@gmail.com</li>
    <li>SMTP Password: [Mật khẩu ứng dụng đã tạo]</li>
</ul>

<h2>8. Cài đặt SMTP cho các dịch vụ phổ biến khác</h2>

<h3>Outlook/Hotmail:</h3>
<ul>
    <li>SMTP Host: smtp.office365.com</li>
    <li>SMTP Port: 587</li>
    <li>SMTP Secure: TLS</li>
</ul>

<h3>Yahoo Mail:</h3>
<ul>
    <li>SMTP Host: smtp.mail.yahoo.com</li>
    <li>SMTP Port: 587 hoặc 465</li>
    <li>SMTP Secure: TLS hoặc SSL</li>
</ul>

<p style="margin-top: 30px; color: #666;">Công cụ tạo bởi hệ thống | Thời gian: <?php echo date('Y-m-d H:i:s'); ?></p>
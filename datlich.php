<?php
session_start();
require_once 'includes/db_connect.php';
require_once 'includes/functions.php';
$isLogged = is_logged_in();
if ($isLogged) {
    $user = get_logged_in_user();
    $patient = get_patient_info($user['id']);
}

// Thiết lập tiêu đề trang cho head.php
$GLOBALS['page_title'] = 'Đặt lịch khám';

// Get settings
$site_name = get_setting('site_name', 'Nha Khoa T&A');
$site_working_hours = get_setting('site_working_hours', 'Thứ 2 - Thứ 6: 8:00 - 17:00');
$primary_color = get_setting('primary_color', '#0d6efd');
$appointment_fee = get_setting('appointment_fee', '0');
$examination_fee = get_setting('examination_fee', '500000');
$primary_color_rgb = hex_to_rgb($primary_color);

// Format fee
$formatted_exam_fee = number_format($examination_fee, 0, ',', '.') . 'đ';
$formatted_appointment_fee = ($appointment_fee > 0) ? number_format($appointment_fee, 0, ',', '.') . 'đ' : 'Miễn phí';
$formatted_total = number_format($examination_fee + $appointment_fee, 0, ',', '.') . 'đ';

// Helper function to convert hex color to RGB
function hex_to_rgb($hex) {
    $hex = str_replace('#', '', $hex);
    
    if(strlen($hex) == 3) {
        $r = hexdec(substr($hex, 0, 1).substr($hex, 0, 1));
        $g = hexdec(substr($hex, 1, 1).substr($hex, 1, 1));
        $b = hexdec(substr($hex, 2, 1).substr($hex, 2, 1));
    } else {
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
    }
    
    return "$r, $g, $b";
}

// Check if service_id is passed in URL
$selected_service_id = isset($_GET['service_id']) ? intval($_GET['service_id']) : 0;

// Fetch service info if service_id is provided
$service_info = null;
$selected_specialty_id = 0; // Initialize selected specialty ID variable
if ($selected_service_id > 0) {
    $stmt = $conn->prepare("SELECT d.id, d.ten_dichvu, d.gia_coban, c.ten_chuyenkhoa, c.id as chuyenkhoa_id 
                           FROM dichvu d 
                           LEFT JOIN chuyenkhoa c ON d.chuyenkhoa_id = c.id 
                           WHERE d.id = ? AND d.trangthai = 1");
    $stmt->bind_param("i", $selected_service_id);
    $stmt->execute();
    $service_info = $stmt->get_result()->fetch_assoc();
    
    // If a valid service was found, update the examination fee and set selected specialty
    if ($service_info) {
        $examination_fee = $service_info['gia_coban'];
        $formatted_exam_fee = number_format($examination_fee, 0, ',', '.') . 'đ';
        $formatted_total = number_format($examination_fee + $appointment_fee, 0, ',', '.') . 'đ';
        
        // Set selected specialty ID for doctor filtering
        $selected_specialty_id = !empty($service_info['chuyenkhoa_id']) ? $service_info['chuyenkhoa_id'] : 0;
    }
}

// Fetch active services
$services = $conn->query("SELECT id, ten_dichvu FROM dichvu WHERE trangthai=1");

// Check if doctor_id is passed in URL
$selected_doctor_id = isset($_GET['doctor_id']) ? intval($_GET['doctor_id']) : 0;

// Fetch doctor info if doctor_id is provided
$doctor_info = null;
if ($selected_doctor_id > 0) {
    $stmt = $conn->prepare("SELECT b.id, b.ho_ten, c.ten_chuyenkhoa FROM bacsi b 
                            JOIN chuyenkhoa c ON b.chuyenkhoa_id = c.id 
                            WHERE b.id = ?");
    $stmt->bind_param("i", $selected_doctor_id);
    $stmt->execute();
    $doctor_info = $stmt->get_result()->fetch_assoc();
}

// Fetch all active doctors
$doctors = $conn->query("SELECT b.id, b.ho_ten, c.ten_chuyenkhoa, c.id as chuyenkhoa_id
                         FROM bacsi b 
                         JOIN chuyenkhoa c ON b.chuyenkhoa_id = c.id 
                         ORDER BY c.ten_chuyenkhoa, b.ho_ten");

// Group doctors by specialty
$doctors_by_specialty = [];
if ($doctors) {
    while ($doc = $doctors->fetch_assoc()) {
        if (!isset($doctors_by_specialty[$doc['chuyenkhoa_id']])) {
            $doctors_by_specialty[$doc['chuyenkhoa_id']] = [
                'name' => $doc['ten_chuyenkhoa'],
                'doctors' => []
            ];
        }
        $doctors_by_specialty[$doc['chuyenkhoa_id']]['doctors'][] = $doc;
    }
    // Reset result pointer
    $doctors->data_seek(0);
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <?php include 'includes/head.php'; ?>
    <style>
        :root {
            --primary-color: <?php echo $primary_color; ?>;
            --primary-color-rgb: <?php echo $primary_color_rgb; ?>;
        }
        
        .booking-container {
            padding: 50px 0;
            background-color: #f8f9fa;
        }
        
        .booking-header {
            text-align: center;
            margin-bottom: 30px;
            color: var(--primary-color);
        }
        
        .booking-form {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
            padding: 30px;
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            font-weight: 600;
            margin-bottom: 8px;
            display: block;
            color: #333;
        }
        
        .form-group label i {
            margin-right: 8px;
            color: var(--primary-color);
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(var(--primary-color-rgb), 0.25);
        }
        
        .doctor-info {
            background-color: rgba(var(--primary-color-rgb), 0.1);
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            border-left: 5px solid var(--primary-color);
        }
        
        .doctor-details h2 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }
        
        .clinic-address {
            display: flex;
            align-items: center;
            font-size: 1rem;
            color: #6c757d;
        }
        
        .clinic-address i {
            margin-right: 10px;
            color: var(--primary-color);
        }
        
        .gender-group {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .price-details {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-top: 15px;
        }
        
        .price-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #dee2e6;
        }
        
        .price-row.total {
            border-bottom: none;
            font-weight: 700;
            font-size: 1.1rem;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 2px solid #dee2e6;
        }
        
        .price {
            font-weight: 600;
        }
        
        .free {
            color: #198754;
            font-weight: 600;
        }
        
        .total-price {
            color: var(--primary-color);
            font-weight: 700;
        }
        
        .payment-info {
            margin-top: 30px;
            margin-bottom: 30px;
        }
        
        .payment-info h3 {
            font-size: 1.3rem;
            margin-bottom: 15px;
            color: #333;
            padding-bottom: 10px;
            border-bottom: 1px solid #dee2e6;
        }
        
        .booking-note {
            margin-top: 30px;
        }
        
        .booking-note h4 {
            margin-bottom: 10px;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 10px 30px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .btn-primary:hover, .btn-primary:focus {
            background-color: rgba(var(--primary-color-rgb), 0.9);
            border-color: rgba(var(--primary-color-rgb), 0.9);
            box-shadow: 0 0 0 0.25rem rgba(var(--primary-color-rgb), 0.25);
        }
        
        .terms-agreement {
            margin-top: 20px;
            font-size: 0.9rem;
            color: #6c757d;
        }
        
        .terms-agreement a {
            color: var(--primary-color);
            text-decoration: none;
        }
        
        .terms-agreement a:hover {
            text-decoration: underline;
        }
        
        /* Responsive styles */
        @media (max-width: 768px) {
            .booking-form {
                padding: 20px;
            }
        }
        
        /* Custom select styles */
        select.form-control {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1em;
        }
        
        /* Specialized doctor select */
        .specialty-group {
            margin-top: 15px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 10px;
        }
        
        .specialty-header {
            font-weight: 600;
            color: var(--primary-color);
            padding-bottom: 5px;
            margin-bottom: 10px;
            border-bottom: 1px dashed #ced4da;
        }
        
        .doctor-option {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px dotted #eee;
        }
        
        .doctor-option:last-child {
            border-bottom: none;
        }
        
        /* Date picker enhancements */
        input[type="date"] {
            position: relative;
        }
        
        input[type="date"]::-webkit-calendar-picker-indicator {
            background: transparent;
            bottom: 0;
            color: transparent;
            cursor: pointer;
            height: auto;
            left: 0;
            position: absolute;
            right: 0;
            top: 0;
            width: auto;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <?php include 'includes/header.php'; ?>

    <div class="booking-container">
        <div class="container">
            <div class="booking-header">
                <h1>ĐẶT LỊCH KHÁM</h1>
                <p class="lead">Đặt lịch nhanh chóng và tiết kiệm thời gian chờ đợi</p>
                <?php if ($doctor_info): ?>
                <div class="doctor-info">
                    <div class="doctor-details">
                        <h2>Bác sĩ: <?php echo htmlspecialchars($doctor_info['ho_ten']); ?></h2>
                        <div class="clinic-address">
                            <i class="fas fa-stethoscope"></i>
                            Chuyên khoa: <?php echo htmlspecialchars($doctor_info['ten_chuyenkhoa']); ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php if ($service_info): ?>
                <div class="doctor-info">
                    <div class="doctor-details">
                        <h2>Dịch vụ: <?php echo htmlspecialchars($service_info['ten_dichvu']); ?></h2>
                        <div class="clinic-address">
                            <i class="fas fa-tag"></i>
                            Chuyên khoa: <?php echo htmlspecialchars($service_info['ten_chuyenkhoa']); ?>
                        </div>
                        <div class="clinic-address mt-2">
                            <i class="fas fa-money-bill-wave"></i>
                            Giá dịch vụ: <?php echo $formatted_exam_fee; ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <div class="booking-form">
                <form action="process_booking.php" method="POST" id="booking-form">
                    <?php if (!$isLogged): ?>
                        <div class="alert alert-warning">
                            <i class="fas fa-info-circle"></i> Bạn chưa đăng nhập. <a href="dangnhap.php?redirect=datlich.php" class="alert-link">Đăng nhập</a> để lưu thông tin lịch hẹn vào tài khoản.
                        </div>
                        <div class="form-group">
                            <label for="fullname">
                                <i class="fas fa-user"></i>
                                Họ tên bệnh nhân (bắt buộc)
                            </label>
                            <input type="text" id="fullname" name="fullname" class="form-control" required>
                            <small class="form-text text-muted">Hãy ghi rõ Họ Và Tên, viết hoa những chữ cái đầu tiên, ví dụ: Trần Văn Phú</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fas fa-venus-mars"></i> Giới tính</label>
                                    <div class="form-check form-check-inline mt-2">
                                        <input type="radio" id="male" name="gender" value="Nam" class="form-check-input" required>
                                        <label for="male" class="form-check-label">Nam</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="female" name="gender" value="Nữ" class="form-check-input">
                                        <label for="female" class="form-check-label">Nữ</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="birthyear">
                                        <i class="fas fa-calendar"></i>
                                        Năm sinh (bắt buộc)
                                    </label>
                                    <input type="number" id="birthyear" name="birthyear" class="form-control" min="1900" max="<?php echo date('Y'); ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">
                                        <i class="fas fa-phone"></i>
                                        Số điện thoại liên hệ (bắt buộc)
                                    </label>
                                    <input type="tel" id="phone" name="phone" class="form-control" pattern="[0-9]{10}" title="Số điện thoại gồm 10 chữ số" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">
                                        <i class="fas fa-envelope"></i>
                                        Địa chỉ email
                                    </label>
                                    <input type="email" id="email" name="email" class="form-control">
                                    <small class="form-text text-muted">Chúng tôi sẽ gửi xác nhận lịch hẹn qua email này</small>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <input type="hidden" name="benhnhan_id" value="<?php echo $patient['id']; ?>">
                        <div class="alert alert-success">
                            <i class="fas fa-user-check"></i> Xin chào, <strong><?php echo htmlspecialchars($patient['ho_ten']); ?></strong>! Bạn đang đặt lịch với thông tin cá nhân đã lưu.
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dichvu">
                                    <i class="fas fa-procedures"></i>
                                    Chọn dịch vụ
                                </label>
                                <select id="dichvu" name="dichvu" class="form-control" required>
                                    <option value="">-- Chọn dịch vụ --</option>
                                    <?php 
                                    if ($services) {
                                        while ($sv = $services->fetch_assoc()): ?>
                                            <option value="<?php echo $sv['id']; ?>" <?php echo ($selected_service_id == $sv['id']) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($sv['ten_dichvu']); ?>
                                            </option>
                                        <?php endwhile; 
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="doctor">
                                    <i class="fas fa-user-md"></i>
                                    Chọn bác sĩ
                                </label>
                                <select id="doctor" name="doctor" class="form-control" required>
                                    <option value="">-- Chọn bác sĩ --</option>
                                    <?php foreach ($doctors_by_specialty as $specialty): ?>
                                        <optgroup label="<?php echo htmlspecialchars($specialty['name']); ?>">
                                            <?php foreach ($specialty['doctors'] as $doc): ?>
                                                <option value="<?php echo $doc['id']; ?>" <?php echo ($selected_doctor_id == $doc['id']) ? 'selected' : ''; ?>>
                                                    BS. <?php echo htmlspecialchars($doc['ho_ten']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </optgroup>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="appointment-date">
                                    <i class="far fa-calendar-alt"></i>
                                    Chọn ngày khám
                                </label>
                                <?php
                                // Set minimum date to today
                                $min_date = date('Y-m-d');
                                // Set maximum date to 30 days from now
                                $max_date = date('Y-m-d', strtotime('+30 days'));
                                ?>
                                <input type="date" id="appointment-date" name="appointment-date" class="form-control" 
                                       min="<?php echo $min_date; ?>" 
                                       max="<?php echo $max_date; ?>" required>
                                <small class="form-text text-muted">Chỉ có thể đặt lịch trong vòng 30 ngày kể từ hôm nay</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="appointment-time">
                                    <i class="far fa-clock"></i>
                                    Chọn giờ khám
                                </label>
                                <select id="appointment-time" name="appointment-time" class="form-control" required>
                                    <option value="">-- Chọn giờ khám --</option>
                                    <optgroup label="Buổi sáng">
                                        <option value="08:00">08:00 - 08:30</option>
                                        <option value="08:30">08:30 - 09:00</option>
                                        <option value="09:00">09:00 - 09:30</option>
                                        <option value="09:30">09:30 - 10:00</option>
                                        <option value="10:00">10:00 - 10:30</option>
                                        <option value="10:30">10:30 - 11:00</option>
                                    </optgroup>
                                    <optgroup label="Buổi chiều">
                                        <option value="14:00">14:00 - 14:30</option>
                                        <option value="14:30">14:30 - 15:00</option>
                                        <option value="15:00">15:00 - 15:30</option>
                                        <option value="15:30">15:30 - 16:00</option>
                                        <option value="16:00">16:00 - 16:30</option>
                                        <option value="16:30">16:30 - 17:00</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="address-group"><i class="fas fa-map-marker-alt"></i> Địa chỉ</label>
                        <div class="row" id="address-group">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select id="province" name="province" class="form-control" required>
                                        <option value="">-- Chọn Tỉnh/Thành --</option>
                                    </select>
                                    <input type="hidden" name="province_text" id="province_text">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select id="district" name="district" class="form-control" required disabled>
                                        <option value="">-- Chọn Quận/Huyện --</option>
                                    </select>
                                    <input type="hidden" name="district_text" id="district_text">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select id="ward" name="ward" class="form-control" required disabled>
                                        <option value="">-- Chọn Phường/Xã --</option>
                                    </select>
                                    <input type="hidden" name="ward_text" id="ward_text">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address">
                            <i class="fas fa-home"></i>
                            Địa chỉ cụ thể
                        </label>
                        <input type="text" id="address" name="address" class="form-control" placeholder="Số nhà, tên đường,...">
                    </div>

                    <div class="form-group">
                        <label for="reason">
                            <i class="fas fa-notes-medical"></i>
                            Triệu chứng / Lý do khám
                        </label>
                        <textarea id="reason" name="reason" class="form-control" rows="3" placeholder="Mô tả ngắn gọn các triệu chứng hoặc lý do bạn muốn khám bệnh"></textarea>
                    </div>

                    <div class="payment-info">
                        <h3>Hình thức thanh toán</h3>
                        <div class="form-check">
                            <input type="radio" id="payment_clinic" name="payment_method" value="clinic" class="form-check-input" checked>
                            <label for="payment_clinic" class="form-check-label">Thanh toán sau tại cơ sở y tế</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" id="payment_online" name="payment_method" value="online" class="form-check-input">
                            <label for="payment_online" class="form-check-label">Thanh toán online (đang phát triển)</label>
                        </div>

                        <div class="price-details">
                            <div class="price-row">
                                <span>Giá khám</span>
                                <span class="price"><?php echo $formatted_exam_fee; ?></span>
                            </div>
                            <div class="price-row">
                                <span>Phí đặt lịch</span>
                                <span class="<?php echo ($appointment_fee > 0) ? 'price' : 'free'; ?>"><?php echo $formatted_appointment_fee; ?></span>
                            </div>
                            <div class="price-row total">
                                <span>Tổng cộng</span>
                                <span class="total-price"><?php echo $formatted_total; ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="booking-note">
                        <div class="alert alert-info">
                            <h4><i class="fas fa-info-circle"></i> LƯU Ý</h4>
                            <p>Thông tin anh/chị cung cấp sẽ được sử dụng làm hồ sơ khám bệnh, khi điền thông tin anh/chị vui lòng:</p>
                            <ul>
                                <li>Ghi rõ họ và tên, viết hoa những chữ cái đầu tiên, ví dụ: Trần Văn Phú</li>
                                <li>Điền đầy đủ, đúng và vui lòng kiểm tra lại thông tin trước khi ấn "Xác nhận"</li>
                                <li>Quý khách vui lòng đến cơ sở y tế trước 15-30 phút so với giờ hẹn để hoàn tất thủ tục</li>
                                <li>Mang theo giấy tờ tùy thân (CCCD/CMND) khi đến khám</li>
                            </ul>
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary btn-lg">Xác nhận đặt khám</button>
                    </div>

                    <div class="terms-agreement text-center">
                        <small>Bằng việc xác nhận đặt khám, bạn đã hoàn toàn đồng ý với <a href="#">Điều khoản sử dụng</a> dịch vụ của chúng tôi.</small>
                    </div>
                </form>
            </div>
            
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-headset fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">Hỗ trợ đặt lịch</h5>
                            <p class="card-text">Gọi cho chúng tôi nếu bạn cần trợ giúp khi đặt lịch khám</p>
                            <a href="tel:19001234" class="btn btn-outline-primary">1900 1234</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-calendar-check fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">Lịch sử đặt khám</h5>
                            <p class="card-text">Xem, hủy hoặc đổi lịch các cuộc hẹn đã đặt</p>
                            <a href="lichsu_datlich.php" class="btn btn-outline-primary">Xem lịch sử</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-question-circle fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">Câu hỏi thường gặp</h5>
                            <p class="card-text">Tìm câu trả lời cho các thắc mắc về đặt lịch khám</p>
                            <a href="faq.php" class="btn btn-outline-primary">Xem câu hỏi</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Date validation - disable weekends and past dates
        const dateInput = document.getElementById('appointment-date');
        
        dateInput.addEventListener('input', function() {
            const selectedDate = new Date(this.value);
            const dayOfWeek = selectedDate.getDay(); // 0 is Sunday, 6 is Saturday
            
            // Check if weekend (uncomment if weekends should be disabled)
            /*
            if (dayOfWeek === 0 || dayOfWeek === 6) {
                alert('Không thể đặt lịch vào ngày cuối tuần. Vui lòng chọn ngày khác.');
                this.value = '';
            }
            */
        });
        
        // Variables for form elements
        const serviceSelect = document.getElementById('dichvu');
        const doctorSelect = document.getElementById('doctor');
        const examFeeElem = document.querySelector('.price-row:first-child .price');
        const totalPriceElem = document.querySelector('.price-row.total .total-price');
        const appointmentFee = <?php echo $appointment_fee; ?>;
        
        // State tracking
        let lastSelectedServiceId = <?php echo $selected_service_id ?: 'null'; ?>;
        let lastSelectedDoctorId = <?php echo $selected_doctor_id ?: 'null'; ?>;
        let lastSpecialtyId = <?php echo $selected_specialty_id ?: 'null'; ?>;
        let userInitiatedAction = true; // Flag to track whether action was initiated by user
        let isUpdatingService = false;  // Flag to prevent recursive calls
        let isUpdatingDoctor = false;   // Flag to prevent recursive calls
        
        // Function to update examination fee and total in the price details section
        function updatePriceDisplay(examFee) {
            const formattedExamFee = new Intl.NumberFormat('vi-VN').format(examFee) + 'đ';
            const totalFee = examFee + appointmentFee;
            const formattedTotal = new Intl.NumberFormat('vi-VN').format(totalFee) + 'đ';
            
            examFeeElem.textContent = formattedExamFee;
            totalPriceElem.textContent = formattedTotal;
        }
        
        // Function to filter doctors by specialty ID
        function filterDoctorsBySpecialty(specialtyId, shouldClearSelection = true) {
            if (isUpdatingDoctor) return; // Prevent recursive calls
            
            isUpdatingDoctor = true;
            
            // Always clear doctor selection if specialty has changed and shouldClearSelection is true
            if (shouldClearSelection && lastSpecialtyId !== specialtyId && doctorSelect.value) {
                doctorSelect.value = '';
                lastSelectedDoctorId = null;
                removeDoctorInfo();
            }
            
            // Show loading state
            doctorSelect.disabled = true;
            doctorSelect.innerHTML = '<option value="">Đang tải...</option>';
            
            fetch(`filter_doctors.php?specialty_id=${specialtyId}`)
                .then(response => response.json())
                .then(data => {
                    // Reset the doctor select
                    doctorSelect.innerHTML = '<option value="">-- Chọn bác sĩ --</option>';
                    
                    if (data.status === 'success' && data.doctors.length > 0) {
                        // Group all doctors in one optgroup with the specialty name
                        const optgroup = document.createElement('optgroup');
                        optgroup.label = 'Bác sĩ phù hợp với dịch vụ';
                        
                        data.doctors.forEach(doctor => {
                            const option = document.createElement('option');
                            option.value = doctor.id;
                            option.textContent = `BS. ${doctor.name}`;
                            optgroup.appendChild(option);
                        });
                        
                        doctorSelect.appendChild(optgroup);
                        doctorSelect.disabled = false;
                        
                        // Update state
                        lastSpecialtyId = specialtyId;
                    } else {
                        // No doctors found for this specialty
                        doctorSelect.innerHTML = '<option value="">-- Không có bác sĩ phù hợp --</option>';
                        doctorSelect.disabled = true;
                    }
                    
                    isUpdatingDoctor = false;
                })
                .catch(error => {
                    console.error('Error fetching doctors:', error);
                    doctorSelect.innerHTML = '<option value="">-- Lỗi tải danh sách bác sĩ --</option>';
                    doctorSelect.disabled = true;
                    isUpdatingDoctor = false;
                });
        }
        
        // Function to filter services by specialty ID
        function filterServicesBySpecialty(specialtyId, shouldClearSelection = true) {
            if (isUpdatingService) return; // Prevent recursive calls
            
            isUpdatingService = true;
            
            // Always clear service selection if specialty has changed and shouldClearSelection is true
            if (shouldClearSelection && lastSpecialtyId !== specialtyId && serviceSelect.value) {
                serviceSelect.value = '';
                lastSelectedServiceId = null;
                removeServiceInfo();
            }
            
            // Show loading state
            serviceSelect.disabled = true;
            serviceSelect.innerHTML = '<option value="">Đang tải...</option>';
            
            fetch(`filter_services_by_specialty.php?specialty_id=${specialtyId}`)
                .then(response => response.json())
                .then(data => {
                    // Reset the service select
                    serviceSelect.innerHTML = '<option value="">-- Chọn dịch vụ --</option>';
                    
                    if (data.status === 'success' && data.services.length > 0) {
                        data.services.forEach(service => {
                            const option = document.createElement('option');
                            option.value = service.id;
                            option.textContent = service.name;
                            option.dataset.price = service.price;
                            option.dataset.priceFormat = service.price_format;
                            serviceSelect.appendChild(option);
                        });
                        serviceSelect.disabled = false;
                        
                        // Update state
                        lastSpecialtyId = specialtyId;
                    } else {
                        // No services found for this specialty
                        serviceSelect.innerHTML = '<option value="">-- Không có dịch vụ phù hợp --</option>';
                        serviceSelect.disabled = true;
                    }
                    
                    isUpdatingService = false;
                })
                .catch(error => {
                    console.error('Error fetching services:', error);
                    serviceSelect.innerHTML = '<option value="">-- Lỗi tải danh sách dịch vụ --</option>';
                    serviceSelect.disabled = true;
                    isUpdatingService = false;
                });
        }
        
        // Function to update or create doctor info display
        function createOrUpdateDoctorInfo(doctorName, specialty) {
            // Check if doctor info element already exists
            let doctorInfoEl = document.querySelector('.doctor-info:not(.service-info)');
            
            if (!doctorInfoEl) {
                // Create new doctor info element if it doesn't exist
                doctorInfoEl = document.createElement('div');
                doctorInfoEl.className = 'doctor-info';
                
                // Find the booking-header element to insert into
                const bookingHeader = document.querySelector('.booking-header');
                
                // Create the inner HTML structure
                doctorInfoEl.innerHTML = `
                    <div class="doctor-details">
                        <h2>Bác sĩ: <span class="doctor-name"></span></h2>
                        <div class="clinic-address">
                            <i class="fas fa-stethoscope"></i>
                            Chuyên khoa: <span class="doctor-specialty"></span>
                        </div>
                    </div>
                `;
                
                // Insert the new element at the beginning of booking-header
                if (bookingHeader) {
                    bookingHeader.insertBefore(doctorInfoEl, bookingHeader.firstChild);
                }
            }
            
            // Update the doctor info content
            doctorInfoEl.querySelector('.doctor-name').textContent = doctorName;
            doctorInfoEl.querySelector('.doctor-specialty').textContent = specialty;
            
            // Make the element visible
            doctorInfoEl.style.display = 'block';
        }
        
        // Function to update service info display
        function createOrUpdateServiceInfo(serviceData) {
            // Check if service info element already exists
            let serviceInfoEl = document.querySelector('.doctor-info.service-info');
            
            if (!serviceInfoEl) {
                // Create new service info element if it doesn't exist
                serviceInfoEl = document.createElement('div');
                serviceInfoEl.className = 'doctor-info service-info';
                
                // Find the booking-header element to insert after
                const bookingHeader = document.querySelector('.booking-header');
                
                // Create the inner HTML structure
                serviceInfoEl.innerHTML = `
                    <div class="doctor-details">
                        <h2>Dịch vụ: <span class="service-name"></span></h2>
                        <div class="clinic-address">
                            <i class="fas fa-tag"></i>
                            Chuyên khoa: <span class="service-specialty"></span>
                        </div>
                        <div class="clinic-address mt-2">
                            <i class="fas fa-money-bill-wave"></i>
                            Giá dịch vụ: <span class="service-price"></span>
                        </div>
                    </div>
                `;
                
                // Insert the new element
                if (bookingHeader) {
                    // Insert after the doctor-info if it exists, otherwise after the booking header
                    const doctorInfo = document.querySelector('.doctor-info:not(.service-info)');
                    if (doctorInfo) {
                        doctorInfo.after(serviceInfoEl);
                    } else {
                        bookingHeader.appendChild(serviceInfoEl);
                    }
                }
            }
            
            // Update the service info content
            const serviceName = serviceData.ten_dichvu || serviceData.name || 
                (serviceSelect.selectedIndex > 0 ? serviceSelect.options[serviceSelect.selectedIndex].text : '');
            
            serviceInfoEl.querySelector('.service-name').textContent = serviceName;
            serviceInfoEl.querySelector('.service-specialty').textContent = serviceData.ten_chuyenkhoa || serviceData.specialty || '';
            serviceInfoEl.querySelector('.service-price').textContent = serviceData.gia_format || serviceData.price_format || '';
            
            // Make the element visible
            serviceInfoEl.style.display = 'block';
        }
        
        // Remove service info when no service is selected
        function removeServiceInfo() {
            const serviceInfoEl = document.querySelector('.doctor-info.service-info');
            if (serviceInfoEl) {
                serviceInfoEl.style.display = 'none';
            }
        }
        
        // Remove doctor info when no doctor is selected
        function removeDoctorInfo() {
            const doctorInfoEl = document.querySelector('.doctor-info:not(.service-info)');
            if (doctorInfoEl) {
                doctorInfoEl.style.display = 'none';
            }
        }
        
        // Function to show compatibility warning
        function showCompatibilityWarning(message) {
            // Check if a warning already exists
            let warningEl = document.getElementById('compatibility-warning');
            
            if (!warningEl) {
                // Create new warning
                warningEl = document.createElement('div');
                warningEl.id = 'compatibility-warning';
                warningEl.className = 'alert alert-warning mt-2';
                warningEl.innerHTML = `<i class="fas fa-exclamation-triangle"></i> ${message}`;
                
                // Insert after the dropdown that was just changed
                const formGroup = (userInitiatedAction === 'service') 
                    ? serviceSelect.closest('.form-group')
                    : doctorSelect.closest('.form-group');
                    
                formGroup.appendChild(warningEl);
            } else {
                warningEl.innerHTML = `<i class="fas fa-exclamation-triangle"></i> ${message}`;
                warningEl.style.display = 'block';
            }
            
            // Hide the warning after 5 seconds
            setTimeout(() => {
                if (warningEl.parentNode) {
                    warningEl.style.display = 'none';
                }
            }, 5000);
        }
        
        // Event listener for service selection
        serviceSelect.addEventListener('change', function() {
            userInitiatedAction = 'service';
            const serviceId = this.value;
            
            if (serviceId) {
                // Fetch the service details and specialty
                fetch(`get_service_specialty.php?service_id=${serviceId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            // Update UI with service info
                            createOrUpdateServiceInfo(data);
                            
                            // Update price
                            updatePriceDisplay(data.gia);
                            
                            // Store selected service ID
                            const previousServiceId = lastSelectedServiceId;
                            lastSelectedServiceId = serviceId;
                            
                            // ALWAYS filter doctors when service changes to a different specialty
                            if (lastSpecialtyId !== data.chuyenkhoa_id) {
                                lastSpecialtyId = data.chuyenkhoa_id;
                                filterDoctorsBySpecialty(data.chuyenkhoa_id);
                                
                                // Reset doctor selection if specialty has changed
                                if (previousServiceId && doctorSelect.value) {
                                    // Check if current doctor is from a different specialty
                                    fetch(`get_doctor_specialty.php?doctor_id=${doctorSelect.value}`)
                                        .then(response => response.json())
                                        .then(doctorData => {
                                            if (doctorData.status === 'success' && 
                                                doctorData.chuyenkhoa_id != data.chuyenkhoa_id) {
                                                // Reset doctor selection as it's not compatible with the new service
                                                doctorSelect.value = '';
                                                lastSelectedDoctorId = null;
                                                removeDoctorInfo();
                                                showCompatibilityWarning('Bác sĩ đã chọn không phù hợp với dịch vụ mới. Vui lòng chọn bác sĩ khác.');
                                            }
                                        })
                                        .catch(error => console.error('Error:', error));
                                }
                            }
                        } else {
                            console.error('Error fetching service info:', data.message);
                            removeServiceInfo();
                            lastSelectedServiceId = null;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        removeServiceInfo();
                        lastSelectedServiceId = null;
                    });
            } else {
                // Reset when no service is selected
                removeServiceInfo();
                lastSelectedServiceId = null;
                
                // Only reset doctor select if no doctor is selected
                if (!lastSelectedDoctorId) {
                    resetDoctorSelect();
                }
            }
        });
        
        // Event listener for doctor selection
        doctorSelect.addEventListener('change', function() {
            userInitiatedAction = 'doctor';
            const doctorId = this.value;
            
            if (doctorId) {
                const selectedOption = this.options[this.selectedIndex];
                const doctorName = selectedOption.textContent;
                let specialty = '';
                
                // If we have access to optgroup, get the specialty from there
                if (selectedOption.parentNode.tagName === 'OPTGROUP') {
                    specialty = selectedOption.parentNode.label;
                }
                
                // Update doctor info in UI
                createOrUpdateDoctorInfo(doctorName, specialty);
                
                // Store selected doctor ID
                const previousDoctorId = lastSelectedDoctorId;
                lastSelectedDoctorId = doctorId;
                
                // Get the doctor's specialty ID and filter services
                fetch(`get_doctor_specialty.php?doctor_id=${doctorId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            // ALWAYS filter services when doctor changes to a different specialty
                            if (lastSpecialtyId !== data.chuyenkhoa_id) {
                                lastSpecialtyId = data.chuyenkhoa_id;
                                filterServicesBySpecialty(data.chuyenkhoa_id);
                                
                                // Reset service selection if specialty has changed
                                if (previousDoctorId && serviceSelect.value) {
                                    // Check if current service is from a different specialty
                                    fetch(`get_service_specialty.php?service_id=${serviceSelect.value}`)
                                        .then(response => response.json())
                                        .then(serviceData => {
                                            if (serviceData.status === 'success' && 
                                                serviceData.chuyenkhoa_id != data.chuyenkhoa_id) {
                                                // Reset service selection as it's not compatible with the new doctor
                                                serviceSelect.value = '';
                                                lastSelectedServiceId = null;
                                                removeServiceInfo();
                                                showCompatibilityWarning('Dịch vụ đã chọn không phù hợp với bác sĩ mới. Vui lòng chọn dịch vụ khác.');
                                            }
                                        })
                                        .catch(error => console.error('Error:', error));
                                }
                            }
                        } else {
                            console.error('Error fetching doctor specialty:', data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            } else {
                // Reset when no doctor is selected
                removeDoctorInfo();
                lastSelectedDoctorId = null;
                
                // Only reset service select if no service is selected
                if (!lastSelectedServiceId) {
                    resetServiceSelect();
                }
            }
        });
        
        // Function to reset service select to original state
        function resetServiceSelect() {
            fetch('get_all_services.php')
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        serviceSelect.innerHTML = '<option value="">-- Chọn dịch vụ --</option>';
                        data.services.forEach(service => {
                            const option = document.createElement('option');
                            option.value = service.id;
                            option.textContent = service.ten_dichvu;
                            serviceSelect.appendChild(option);
                        });
                        serviceSelect.disabled = false;
                    }
                })
                .catch(() => {
                    // Fallback: Reload the page to restore original state
                    location.reload();
                });
        }
        
        // Function to reset doctor select to original state
        function resetDoctorSelect() {
            doctorSelect.innerHTML = '<option value="">-- Chọn bác sĩ --</option>';
            
            <?php if (!empty($doctors_by_specialty)): ?>
            // Restore original specialty groups
            <?php foreach ($doctors_by_specialty as $spec_id => $specialty): ?>
                var optgroup = document.createElement('optgroup');
                optgroup.label = '<?php echo addslashes($specialty['name']); ?>';
                
                <?php foreach ($specialty['doctors'] as $doc): ?>
                var option = document.createElement('option');
                option.value = <?php echo $doc['id']; ?>;
                option.textContent = 'BS. <?php echo addslashes($doc['ho_ten']); ?>';
                optgroup.appendChild(option);
                <?php endforeach; ?>
                
                doctorSelect.appendChild(optgroup);
            <?php endforeach; ?>
            <?php endif; ?>
            
            doctorSelect.disabled = false;
        }
        
        // Initialize with pre-selected options if they exist
        const preSelectedServiceId = '<?php echo $selected_service_id; ?>';
        const preSelectedDoctorId = '<?php echo $selected_doctor_id; ?>';
        const preSelectedSpecialtyId = '<?php echo $selected_specialty_id; ?>';
        
        if (preSelectedServiceId > 0) {
            lastSelectedServiceId = preSelectedServiceId;
            lastSpecialtyId = preSelectedSpecialtyId;
            
            // If specialty is known, filter doctors
            if (preSelectedSpecialtyId > 0) {
                filterDoctorsBySpecialty(preSelectedSpecialtyId);
            }
        } else if (preSelectedDoctorId > 0) {
            lastSelectedDoctorId = preSelectedDoctorId;
            
            // Get doctor's specialty and filter services
            fetch(`get_doctor_specialty.php?doctor_id=${preSelectedDoctorId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        lastSpecialtyId = data.chuyenkhoa_id;
                        filterServicesBySpecialty(data.chuyenkhoa_id);
                    }
                })
                .catch(error => console.error('Error:', error));
        }
        
        // Location API integration
        const provinceSelect = document.getElementById('province');
        const districtSelect = document.getElementById('district');
        const wardSelect = document.getElementById('ward');
        const provinceText = document.getElementById('province_text');
        const districtText = document.getElementById('district_text');
        const wardText = document.getElementById('ward_text');
        
        // Load provinces
        fetch('https://vapi.vnappmob.com/api/v2/province/')
            .then(res => res.json())
            .then(data => data.results.forEach(item => {
                const opt = document.createElement('option');
                opt.value = item.province_id;
                opt.textContent = item.province_name;
                provinceSelect.appendChild(opt);
            }));
            
        // On province change
        provinceSelect.addEventListener('change', function() {
            const pid = this.value;
            provinceText.value = this.options[this.selectedIndex].text;
            districtSelect.innerHTML = '<option value="">-- Chọn Quận/Huyện --</option>';
            wardSelect.innerHTML = '<option value="">-- Chọn Phường/Xã --</option>';
            wardSelect.disabled = true;
            if (!pid) { districtSelect.disabled = true; return; }
            districtSelect.disabled = false;
            fetch(`https://vapi.vnappmob.com/api/v2/province/district/${pid}`)
                .then(res => res.json())
                .then(data => data.results.forEach(item => {
                    const opt = document.createElement('option');
                    opt.value = item.district_id;
                    opt.textContent = item.district_name;
                    districtSelect.appendChild(opt);
                }));
        });
        
        // On district change
        districtSelect.addEventListener('change', function() {
            const did = this.value;
            districtText.value = this.options[this.selectedIndex].text;
            wardSelect.innerHTML = '<option value="">-- Chọn Phường/Xã --</option>';
            if (!did) { wardSelect.disabled = true; return; }
            wardSelect.disabled = false;
            fetch(`https://vapi.vnappmob.com/api/v2/province/ward/${did}`)
                .then(res => res.json())
                .then(data => data.results.forEach(item => {
                    const opt = document.createElement('option');
                    opt.value = item.ward_id;
                    opt.textContent = item.ward_name;
                    wardSelect.appendChild(opt);
                }));
        });
        
        // On ward change
        wardSelect.addEventListener('change', function() {
            wardText.value = this.options[this.selectedIndex].text;
        });
        
        // Form validation
        const form = document.getElementById('booking-form');
        form.addEventListener('submit', function(event) {
            // Additional validation can be added here
            // For example, check if the selected time slot is available
        });
    });
    </script>
</body>
</html>
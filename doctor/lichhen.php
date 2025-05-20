<?php
// Kiểm tra quyền truy cập
require_once 'includes/auth_check.php';

// Lấy thông tin bác sĩ đang đăng nhập
$user = get_logged_in_user();
$doctor_id = null;

$stmt = $conn->prepare("SELECT id, ho_ten FROM bacsi WHERE nguoidung_id = ?");
$stmt->bind_param('i', $user['id']);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $doctor = $result->fetch_assoc();
    $doctor_id = $doctor['id'];
}

// Xử lý các hành động
$action = isset($_GET['action']) ? $_GET['action'] : '';
$appointment_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$success_message = '';
$error_message = '';

// Nếu có thông báo từ session
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}
if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
}

// Xử lý cập nhật trạng thái lịch hẹn
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $post_action = $_POST['action'];
    $appointment_id = isset($_POST['appointment_id']) ? intval($_POST['appointment_id']) : 0;
    
    // Xác nhận lịch hẹn
    if ($post_action === 'confirm' && $appointment_id > 0) {
        $stmt = $conn->prepare("UPDATE lichhen SET trang_thai = 'confirmed' WHERE id = ? AND bacsi_id = ?");
        $stmt->bind_param('ii', $appointment_id, $doctor_id);
        if ($stmt->execute() && $stmt->affected_rows > 0) {
            $success_message = "Đã xác nhận lịch hẹn thành công!";
            // Gửi email thông báo cho bệnh nhân
            $email_stmt = $conn->prepare(
                "SELECT bn.email, bn.ho_ten, lh.ma_lichhen, lh.ngay_hen, lh.gio_hen, lh.dichvu_id, 
                        bs.ho_ten AS doctor_name, dv.ten_dichvu, ck.ten_chuyenkhoa
                 FROM lichhen lh
                 JOIN benhnhan bn ON lh.benhnhan_id = bn.id
                 JOIN bacsi bs ON lh.bacsi_id = bs.id
                 LEFT JOIN dichvu dv ON lh.dichvu_id = dv.id
                 LEFT JOIN chuyenkhoa ck ON bs.chuyenkhoa_id = ck.id
                 WHERE lh.id = ?"
            );
            $email_stmt->bind_param('i', $appointment_id);
            $email_stmt->execute();
            $email_result = $email_stmt->get_result();
            if ($email_result && $email_result->num_rows > 0) {
                // Lấy các cài đặt từ hệ thống
                $phongkham_ten = get_setting('phongkham_ten', 'Phòng khám');
                $phongkham_diachi = get_setting('phongkham_diachi', '');
                $phongkham_phone = get_setting('phongkham_dienthoai', '');
                $phongkham_email = get_setting('phongkham_email', '');
                $phongkham_logo = get_setting('phongkham_logo', '');
                $base_url = get_setting('base_url', '');
                
                $row = $email_result->fetch_assoc();
                $to = $row['email'];
                $subject = "[" . $phongkham_ten . "] Xác nhận lịch hẹn " . $row['ma_lichhen'];
                
                // Định dạng ngày, giờ hiển thị thân thiện
                $formatted_date = date('d/m/Y', strtotime($row['ngay_hen']));
                $formatted_time = $row['gio_hen'];
                
                // Xây dựng email có định dạng HTML đẹp mắt
                $message = '<!DOCTYPE html>
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
                        .confirmation-box { background-color: #f5f5f5; border-left: 4px solid #2b579a; padding: 15px; margin-bottom: 20px; }
                        .appointment-details { margin-bottom: 20px; }
                        .appointment-details table { width: 100%; border-collapse: collapse; }
                        .appointment-details td { padding: 8px 0; }
                        .label { font-weight: bold; width: 140px; }
                        .footer { font-size: 12px; color: #777; margin-top: 30px; padding-top: 10px; border-top: 1px solid #eee; }
                        .button { display: inline-block; background-color: #2b579a; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px; margin-top: 15px; }
                    </style>
                </head>
                <body>
                    <div class="container">
                        <div class="header">
                            ' . (!empty($phongkham_logo) ? '<img src="' . $base_url . '/' . $phongkham_logo . '" alt="' . $phongkham_ten . '" class="logo">' : '') . '
                            <h1>' . $phongkham_ten . '</h1>
                        </div>
                        
                        <p>Kính chào <strong>' . htmlspecialchars($row['ho_ten']) . '</strong>,</p>
                        
                        <div class="confirmation-box">
                            <p>Lịch hẹn của bạn đã được <strong>Bác sĩ ' . $row['doctor_name'] . '</strong> xác nhận.</p>
                        </div>
                        
                        <div class="appointment-details">
                            <h3>Chi tiết lịch hẹn:</h3>
                            <table>
                                <tr>
                                    <td class="label">Mã lịch hẹn:</td>
                                    <td><strong>' . $row['ma_lichhen'] . '</strong></td>
                                </tr>
                                <tr>
                                    <td class="label">Ngày khám:</td>
                                    <td>' . $formatted_date . '</td>
                                </tr>
                                <tr>
                                    <td class="label">Giờ khám:</td>
                                    <td>' . $formatted_time . '</td>
                                </tr>
                                <tr>
                                    <td class="label">Dịch vụ:</td>
                                    <td>' . $row['ten_dichvu'] . '</td>
                                </tr>
                                <tr>
                                    <td class="label">Chuyên khoa:</td>
                                    <td>' . $row['ten_chuyenkhoa'] . '</td>
                                </tr>
                                <tr>
                                    <td class="label">Bác sĩ:</td>
                                    <td>' . $row['doctor_name'] . '</td>
                                </tr>
                            </table>
                        </div>
                        
                        <p>Vui lòng có mặt trước giờ hẹn 15 phút để làm thủ tục.</p>
                        <p>Nếu bạn cần thay đổi hoặc hủy lịch hẹn, vui lòng thông báo cho chúng tôi sớm nhất có thể.</p>
                        
                        ' . (!empty($base_url) ? '<a href="' . $base_url . '/tracuu.php?code=' . $row['ma_lichhen'] . '" class="button">Xem chi tiết lịch hẹn</a>' : '') . '
                        
                        <div class="footer">
                            <p><strong>' . $phongkham_ten . '</strong></p>
                            ' . (!empty($phongkham_diachi) ? '<p>Địa chỉ: ' . $phongkham_diachi . '</p>' : '') . '
                            ' . (!empty($phongkham_phone) ? '<p>Điện thoại: ' . $phongkham_phone . '</p>' : '') . '
                            ' . (!empty($phongkham_email) ? '<p>Email: ' . $phongkham_email . '</p>' : '') . '
                        </div>
                    </div>
                </body>
                </html>';
                
                // Gửi email với template HTML mới
                send_email($to, $subject, $message);
                
                // Ghi log thành công gửi email
                $log_file = '../logs/email_logs_' . date('Y-m') . '.log';
                $log_message = date('Y-m-d H:i:s') . " | SENT | To: $to | Subject: $subject | AppointmentID: $appointment_id\n";
                file_put_contents($log_file, $log_message, FILE_APPEND);
            }
        } else {
            $error_message = "Không thể xác nhận lịch hẹn. Vui lòng thử lại!";
        }
    } 
    // Hủy lịch hẹn
    elseif ($post_action === 'cancel' && $appointment_id > 0) {
        $ly_do = isset($_POST['ly_do']) ? trim($_POST['ly_do']) : '';
        if (empty($ly_do)) {
            $error_message = "Vui lòng nhập lý do hủy lịch hẹn!";
        } else {
            // Thêm ghi chú hủy lịch
            $stmt = $conn->prepare("UPDATE lichhen SET trang_thai = 'cancelled', ghi_chu = CONCAT(IFNULL(ghi_chu,''), '\n(', CURDATE(), ') Bác sĩ hủy: ', ?) WHERE id = ? AND bacsi_id = ?");
            $stmt->bind_param('sii', $ly_do, $appointment_id, $doctor_id);
            if ($stmt->execute() && $stmt->affected_rows > 0) {
                $success_message = "Đã hủy lịch hẹn thành công!";
            } else {
                $error_message = "Không thể hủy lịch hẹn. Vui lòng thử lại!";
            }
        }
    }
    // Hoàn thành lịch hẹn và thêm kết quả khám
    elseif ($post_action === 'complete' && $appointment_id > 0) {
        $chan_doan = isset($_POST['chan_doan']) ? trim($_POST['chan_doan']) : '';
        $ket_qua = isset($_POST['ket_qua']) ? trim($_POST['ket_qua']) : '';
        $don_thuoc = isset($_POST['don_thuoc']) ? trim($_POST['don_thuoc']) : '';
        $loi_dan = isset($_POST['loi_dan']) ? trim($_POST['loi_dan']) : '';
        
        if (empty($chan_doan)) {
            $_SESSION['error_message'] = "Vui lòng nhập chẩn đoán!";
        } else {
            // Bắt đầu transaction
            $conn->begin_transaction();
            
            try {
                // Cập nhật trạng thái lịch hẹn - sử dụng thoi_diem_hoanthanh thay vì ngay_kham
                $stmt = $conn->prepare("UPDATE lichhen SET trang_thai = 'completed', thoi_diem_hoanthanh = NOW() WHERE id = ? AND bacsi_id = ?");
                $stmt->bind_param('ii', $appointment_id, $doctor_id);
                $stmt->execute();
                
                if ($stmt->affected_rows === 0) {
                    throw new Exception("Không thể cập nhật trạng thái lịch hẹn");
                }
                
                // Kiểm tra xem đã có kết quả khám chưa
                $stmt = $conn->prepare("SELECT id FROM ketqua_kham WHERE lichhen_id = ?");
                $stmt->bind_param('i', $appointment_id);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    // Cập nhật kết quả khám hiện có
                    $stmt = $conn->prepare("UPDATE ketqua_kham SET chan_doan = ?, mo_ta = ?, don_thuoc = ?, ghi_chu = ?, ngay_capnhat = NOW() WHERE lichhen_id = ?");
                    $stmt->bind_param('ssssi', $chan_doan, $ket_qua, $don_thuoc, $loi_dan, $appointment_id);
                } else {
                    // Thêm kết quả khám mới - không có cột bacsi_id trong bảng
                    $stmt = $conn->prepare("INSERT INTO ketqua_kham (lichhen_id, chan_doan, mo_ta, don_thuoc, ghi_chu) VALUES (?, ?, ?, ?, ?)");
                    $stmt->bind_param('issss', $appointment_id, $chan_doan, $ket_qua, $don_thuoc, $loi_dan);
                }
                
                if (!$stmt->execute()) {
                    throw new Exception("Không thể lưu kết quả khám: " . $stmt->error);
                }
                
                // Commit transaction
                $conn->commit();
                
                $_SESSION['success_message'] = "Đã cập nhật kết quả khám bệnh thành công!";
            } catch (Exception $e) {
                // Rollback nếu có lỗi
                $conn->rollback();
                $_SESSION['error_message'] = "Đã xảy ra lỗi: " . $e->getMessage();
            }
        }
    }
    
    // Sau khi xử lý, chuyển hướng để refresh trang
    header("Location: lichhen.php" . ($action ? "?action=$action" . ($appointment_id ? "&id=$appointment_id" : "") : ""));
    exit;
}

// Thiết lập bộ lọc và phân trang
$current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$items_per_page = 10;
$filter = [];

// Lọc theo trạng thái
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
if (!empty($status_filter)) {
    $filter['status'] = $status_filter;
}

// Lọc theo ngày
$date_filter = isset($_GET['date']) ? $_GET['date'] : '';
if (!empty($date_filter)) {
    $filter['date'] = $date_filter;
}

// Lọc theo tìm kiếm
$search_filter = isset($_GET['search']) ? $_GET['search'] : '';
if (!empty($search_filter)) {
    $filter['search'] = $search_filter;
}

// Lọc theo khoảng thời gian (tuần)
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
if (!empty($start_date) && !empty($end_date)) {
    $filter['start_date'] = $start_date;
    $filter['end_date'] = $end_date;
}

// Xác định chế độ xem (danh sách hoặc lịch)
$view_mode = isset($_GET['view']) ? $_GET['view'] : 'list';

// Lấy dữ liệu cho xem theo thời gian biểu (nếu đang ở chế độ xem lịch)
$schedule_data = [];
$selected_day = isset($_GET['day']) ? $_GET['day'] : '';

if ($view_mode === 'calendar') {
    // Xác định ngày bắt đầu và kết thúc của tuần hiện tại nếu không có lọc
    if (empty($start_date) || empty($end_date)) {
        $today = new DateTime();
        $current_day_of_week = $today->format('N'); // 1 (Thứ 2) đến 7 (Chủ Nhật)
        
        $week_start = clone $today;
        $week_start->modify('-' . ($current_day_of_week - 1) . ' days'); // Đặt về Thứ 2
        
        $week_end = clone $week_start;
        $week_end->modify('+6 days'); // Đến Chủ Nhật
        
        $start_date = $week_start->format('Y-m-d');
        $end_date = $week_end->format('Y-m-d');
        
        $filter['start_date'] = $start_date;
        $filter['end_date'] = $end_date;
    }
    
    // Xây dựng thời gian biểu
    $current_date = new DateTime($start_date);
    $end_date_obj = new DateTime($end_date);
    
    while ($current_date <= $end_date_obj) {
        $day = $current_date->format('Y-m-d');
        
        // Đếm số lượng lịch hẹn trong ngày
        $count_sql = "SELECT 
                        COUNT(*) as total,
                        SUM(CASE WHEN trang_thai = 'pending' THEN 1 ELSE 0 END) as pending,
                        SUM(CASE WHEN trang_thai = 'confirmed' THEN 1 ELSE 0 END) as confirmed,
                        SUM(CASE WHEN trang_thai = 'completed' THEN 1 ELSE 0 END) as completed,
                        SUM(CASE WHEN trang_thai = 'cancelled' THEN 1 ELSE 0 END) as cancelled
                    FROM lichhen 
                    WHERE bacsi_id = ? AND ngay_hen = ?";
        
        $stmt = $conn->prepare($count_sql);
        $stmt->bind_param('is', $doctor_id, $day);
        $stmt->execute();
        $counts = $stmt->get_result()->fetch_assoc();
        
        $schedule_data[$day] = [
            'day_name' => $current_date->format('l'), // Tên của ngày (Thứ 2, Thứ 3...)
            'day_number' => $current_date->format('d'), // Số ngày
            'month' => $current_date->format('m'), // Tháng
            'counts' => $counts
        ];
        
        $current_date->modify('+1 day');
    }
    
    // Nếu có ngày được chọn, lấy danh sách chi tiết các lịch hẹn
    if (!empty($selected_day)) {
        $day_appointments_sql = "SELECT lh.*, bn.ho_ten AS patient_name, dv.ten_dichvu AS service_name
                                FROM lichhen lh
                                LEFT JOIN benhnhan bn ON lh.benhnhan_id = bn.id
                                LEFT JOIN dichvu dv ON lh.dichvu_id = dv.id
                                WHERE lh.bacsi_id = ? AND lh.ngay_hen = ?
                                ORDER BY lh.gio_hen ASC";
                                
        $stmt = $conn->prepare($day_appointments_sql);
        $stmt->bind_param('is', $doctor_id, $selected_day);
        $stmt->execute();
        $day_appointments = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}

// Lấy một lịch hẹn cụ thể nếu được yêu cầu
$appointment = null;
if ($action === 'view' && $appointment_id > 0) {
    $stmt = $conn->prepare(
        "SELECT lh.*, bn.ho_ten AS patient_name, bn.dien_thoai AS patient_phone, 
                bn.email AS patient_email, bn.nam_sinh AS patient_birth_year, bn.gioi_tinh AS patient_gender,
                bn.dia_chi AS patient_address, dv.ten_dichvu AS service_name, dv.gia_coban AS service_price,
                ck.ten_chuyenkhoa AS specialty_name
         FROM lichhen lh
         LEFT JOIN benhnhan bn ON lh.benhnhan_id = bn.id
         LEFT JOIN dichvu dv ON lh.dichvu_id = dv.id
         LEFT JOIN bacsi bs ON lh.bacsi_id = bs.id
         LEFT JOIN chuyenkhoa ck ON bs.chuyenkhoa_id = ck.id
         WHERE lh.id = ? AND lh.bacsi_id = ?"
    );
    $stmt->bind_param('ii', $appointment_id, $doctor_id);
    $stmt->execute();
    $appointment = $stmt->get_result()->fetch_assoc();
    
    // Lấy kết quả khám bệnh nếu có
    if ($appointment) {
        $stmt = $conn->prepare("SELECT * FROM ketqua_kham WHERE lichhen_id = ?");
        $stmt->bind_param('i', $appointment_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $medical_result = $result->fetch_assoc();
            $appointment = array_merge($appointment, $medical_result);
        }
    }
}
// Danh sách tất cả các lịch hẹn
else {
    // Xây dựng câu truy vấn SQL với bộ lọc
    $where_clauses = ["lh.bacsi_id = ?"];
    $params = [$doctor_id];
    $types = "i";
    
    if (!empty($filter['status'])) {
        $where_clauses[] = "lh.trang_thai = ?";
        $params[] = $filter['status'];
        $types .= "s";
    }
    
    if (!empty($filter['date'])) {
        $where_clauses[] = "lh.ngay_hen = ?";
        $params[] = $filter['date'];
        $types .= "s";
    }
    
    if (!empty($filter['search'])) {
        $search_term = "%" . $filter['search'] . "%";
        $where_clauses[] = "(bn.ho_ten LIKE ? OR lh.ma_lichhen LIKE ?)";
        $params[] = $search_term;
        $params[] = $search_term;
        $types .= "ss";
    }
    
    $where_clause = implode(" AND ", $where_clauses);
    
    // Đếm tổng số lượng lịch hẹn phù hợp với bộ lọc
    $count_sql = "SELECT COUNT(*) as total 
                  FROM lichhen lh 
                  LEFT JOIN benhnhan bn ON lh.benhnhan_id = bn.id
                  WHERE $where_clause";
    $stmt = $conn->prepare($count_sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $total_items = $stmt->get_result()->fetch_assoc()['total'];
    $total_pages = ceil($total_items / $items_per_page);
    
    // Điều chỉnh trang hiện tại nếu vượt quá tổng số trang
    if ($current_page > $total_pages && $total_pages > 0) {
        $current_page = $total_pages;
    }
    
    // Tính vị trí bắt đầu
    $start = ($current_page - 1) * $items_per_page;
    
    // Lấy danh sách lịch hẹn với phân trang
    $sql = "SELECT lh.*, bn.ho_ten AS patient_name, dv.ten_dichvu AS service_name
            FROM lichhen lh
            LEFT JOIN benhnhan bn ON lh.benhnhan_id = bn.id
            LEFT JOIN dichvu dv ON lh.dichvu_id = dv.id
            WHERE $where_clause
            ORDER BY 
              CASE WHEN lh.ngay_hen = CURDATE() THEN 0 ELSE 1 END,
              lh.ngay_hen ASC, 
              lh.gio_hen ASC
            LIMIT ?, ?";
    
    $stmt = $conn->prepare($sql);
    // Bind parameters dynamically including pagination limits
    $params[] = $start;
    $params[] = $items_per_page;
    $bind_types = $types . 'ii';
    // Prepare arguments for bind_param (needs references)
    $bind_args = [];
    $bind_args[] = &$bind_types;
    foreach ($params as $key => $val) {
        $bind_args[] = &$params[$key];
    }
    call_user_func_array([$stmt, 'bind_param'], $bind_args);
    $stmt->execute();
    $appointments = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $action === 'view' ? 'Chi tiết lịch hẹn' : 'Quản lý lịch hẹn'; ?> - Bác sĩ Portal</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Bootstrap Datepicker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }
        .search-filter {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }
        .appointments-table {
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }
        .appointment-card {
            background-color: #fff;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        .appointment-detail {
            margin-bottom: 15px;
        }
        .appointment-detail-label {
            font-weight: 600;
            color: #6c757d;
            margin-bottom: 5px;
        }
        .appointment-detail-value {
            font-size: 16px;
        }
        .patient-info-card {
            background-color: #f8f9fa;
            border-left: 3px solid #0d6efd;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .service-info-card {
            background-color: #f8f9fa;
            border-left: 3px solid #20c997;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .medical-form-card {
            background-color: #f8f9fa;
            border-left: 3px solid #fd7e14;
            padding: 15px;
            border-radius: 5px;
        }
        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }
        .table-action {
            width: 120px;
            text-align: center;
        }
        .detail-section-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #dee2e6;
        }
        .mobile-appointment-card {
            margin-bottom: 15px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            background-color: #fff;
        }
        
        /* Cải tiến giao diện thời gian biểu */
        .calendar-day {
            height: 140px;
            border: 1px solid #e9ecef;
            background-color: #fff;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.04);
        }
        .calendar-day:hover {
            box-shadow: 0 8px 15px rgba(0,0,0,0.1);
            transform: translateY(-5px);
        }
        .calendar-day-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            position: relative;
            z-index: 2;
        }
        .calendar-day-number {
            font-size: 22px;
            font-weight: 700;
            color: #212529;
        }
        .calendar-day-name {
            font-size: 14px;
            font-weight: 600;
            color: #6c757d;
            padding-top: 5px;
        }
        .calendar-stats {
            display: flex;
            flex-wrap: wrap;
            margin-top: 8px;
            position: relative;
            z-index: 2;
        }
        .calendar-stat {
            margin-right: 12px;
            margin-bottom: 10px;
            font-size: 13px;
            display: flex;
            align-items: center;
        }
        .calendar-stat .badge {
            margin-right: 5px;
            height: 20px;
            min-width: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .calendar-day-today {
            border: 2px solid #0d6efd;
            background-color: #f0f7ff;
        }
        .calendar-day-today::after {
            content: "Hôm nay";
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #0d6efd;
            color: #fff;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 500;
        }
        .calendar-day-selected {
            border: 2px solid #20c997;
            background-color: #f0fff8;
        }
        .nav-pills .nav-link {
            color: #495057;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 20px;
            transition: all 0.2s;
        }
        .nav-pills .nav-link.active {
            background-color: #0d6efd;
            color: #fff;
            box-shadow: 0 4px 8px rgba(13, 110, 253, 0.25);
        }
        .date-range-picker {
            display: flex;
            gap: 12px;
            align-items: center;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
        }
        .date-range-picker .input-group-text {
            background-color: #0d6efd;
            color: white;
            border: none;
        }
        .date-range-picker .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }
        .date-range-label {
            font-weight: 600;
            margin-bottom: 8px;
            color: #495057;
            display: flex;
            align-items: center;
        }
        .date-range-label i {
            margin-right: 8px;
            color: #0d6efd;
        }
        .day-appointments {
            margin-top: 30px;
            background-color: #fff;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            border-top: 4px solid #20c997;
        }
        .day-appointments h4 {
            font-weight: 600;
            color: #343a40;
            display: flex;
            align-items: center;
        }
        .day-appointments h4 i {
            margin-right: 10px;
            color: #20c997;
        }
        .day-appointments .table {
            margin-top: 15px;
        }
        .day-appointments .table th {
            font-weight: 600;
            color: #495057;
            border-bottom-width: 1px;
        }
        .view-mode-selector {
            background-color: #f8f9fa;
            border-radius: 50px;
            padding: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .calendar-day-content {
            position: relative;
            z-index: 2;
        }
        .calendar-day-bg-icon {
            position: absolute;
            bottom: -15px;
            right: -15px;
            font-size: 70px;
            opacity: 0.05;
            color: #0d6efd;
            transform: rotate(10deg);
        }
        .calendar-weekday-label {
            background-color: #f8f9fa;
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 600;
            color: #495057;
            margin-bottom: 15px;
            display: inline-block;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .appointment-count-badge {
            font-size: 14px;
            padding: 5px 10px;
            margin-left: 10px;
        }
        .appointment-time {
            font-weight: 500;
            color: #0d6efd;
        }
        .dashboard-stats {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 25px;
        }
        .stat-card {
            flex: 1;
            min-width: 200px;
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            text-align: center;
            border-bottom: 3px solid transparent;
            transition: transform 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .stat-card-blue {
            border-bottom-color: #0d6efd;
        }
        .stat-card-green {
            border-bottom-color: #20c997;
        }
        .stat-card-warning {
            border-bottom-color: #ffc107;
        }
        .stat-card-danger {
            border-bottom-color: #dc3545;
        }
        .stat-number {
            font-size: 24px;
            font-weight: 700;
            margin: 10px 0;
        }
        .stat-label {
            color: #6c757d;
            font-size: 14px;
            font-weight: 500;
        }
        .stat-card i {
            font-size: 28px;
            margin-bottom: 15px;
        }
        .stat-card-blue i {
            color: #0d6efd;
        }
        .stat-card-green i {
            color: #20c997;
        }
        .stat-card-warning i {
            color: #ffc107;
        }
        .stat-card-danger i {
            color: #dc3545;
        }
        @media (max-width: 767.98px) {
            .desktop-only {
                display: none;
            }
            .filter-row .col-md-3 {
                margin-bottom: 10px;
            }
            .appointment-actions {
                display: flex;
                flex-direction: column;
                gap: 10px;
            }
            .appointment-actions .btn {
                width: 100%;
            }
            .appointment-detail-value {
                font-size: 14px;
            }
            .calendar-day {
                height: auto;
                min-height: 130px;
            }
            .date-range-picker {
                flex-direction: column;
                width: 100%;
            }
            .date-range-picker .input-group {
                margin-bottom: 10px;
            }
            .dashboard-stats {
                flex-direction: column;
            }
            .stat-card {
                margin-bottom: 10px;
            }
        }
        @media (min-width: 768px) {
            .mobile-only {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include 'includes/sidebar.php'; ?>

            <!-- Main Content -->
            <main class="col main-content p-4">
                <?php if ($action === 'view' && $appointment): ?>
                    <!-- Chi tiết lịch hẹn -->
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
                        <h1 class="h2">Chi tiết lịch hẹn</h1>
                        <div>
                            <a href="lichhen.php" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Quay lại
                            </a>
                        </div>
                    </div>

                    <?php if (!empty($success_message)): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo $success_message; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($error_message)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo $error_message; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <div class="appointment-card">
                        <div class="row">
                            <div class="col-lg-8">
                                <!-- Appointment Status -->
                                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                                    <div class="mb-2 mb-md-0">
                                        <h4 class="mb-1">Mã lịch hẹn: <?php echo $appointment['ma_lichhen']; ?></h4>
                                        <div class="text-muted">
                                            Ngày tạo: <?php echo date('d/m/Y', strtotime($appointment['ngay_tao'])); ?>
                                        </div>
                                    </div>
                                    <div>
                                        <?php
                                            $status_class = "";
                                            $status_text = "";
                                            switch($appointment['trang_thai']) {
                                                case 'pending':
                                                    $status_class = "bg-warning text-dark";
                                                    $status_text = "Chờ xác nhận";
                                                    break;
                                                case 'confirmed':
                                                    $status_class = "bg-primary";
                                                    $status_text = "Đã xác nhận";
                                                    break;
                                                case 'completed':
                                                    $status_class = "bg-success";
                                                    $status_text = "Đã hoàn thành";
                                                    break;
                                                case 'cancelled':
                                                    $status_class = "bg-danger";
                                                    $status_text = "Đã hủy";
                                                    break;
                                                default:
                                                    $status_class = "bg-secondary";
                                                    $status_text = ucfirst($appointment['trang_thai']);
                                            }
                                        ?>
                                        <span class="badge <?php echo $status_class; ?> p-2"><?php echo $status_text; ?></span>
                                    </div>
                                </div>

                                <!-- Patient Info -->
                                <div class="patient-info-card mb-4">
                                    <h5 class="detail-section-title">
                                        <i class="fas fa-user-injured me-2"></i> Thông tin bệnh nhân
                                    </h5>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="appointment-detail-label">Họ và tên</div>
                                            <div class="appointment-detail-value"><?php echo $appointment['patient_name']; ?></div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="appointment-detail-label">Giới tính / Năm sinh</div>
                                            <div class="appointment-detail-value">
                                                <?php echo $appointment['patient_gender']; ?> / 
                                                <?php echo $appointment['patient_birth_year']; ?> 
                                                (<?php echo date('Y') - $appointment['patient_birth_year']; ?> tuổi)
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="appointment-detail-label">Số điện thoại</div>
                                            <div class="appointment-detail-value"><?php echo $appointment['patient_phone']; ?></div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="appointment-detail-label">Email</div>
                                            <div class="appointment-detail-value"><?php echo $appointment['patient_email'] ?: 'Không có'; ?></div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="appointment-detail-label">Địa chỉ</div>
                                            <div class="appointment-detail-value"><?php echo $appointment['patient_address']; ?></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Appointment Info -->
                                <div class="service-info-card mb-4">
                                    <h5 class="detail-section-title">
                                        <i class="fas fa-calendar-alt me-2"></i> Thông tin lịch hẹn
                                    </h5>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="appointment-detail-label">Ngày khám</div>
                                            <div class="appointment-detail-value">
                                                <?php echo date('d/m/Y', strtotime($appointment['ngay_hen'])); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="appointment-detail-label">Giờ khám</div>
                                            <div class="appointment-detail-value">
                                                <?php echo $appointment['gio_hen']; ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="appointment-detail-label">Chuyên khoa</div>
                                            <div class="appointment-detail-value"><?php echo $appointment['specialty_name']; ?></div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="appointment-detail-label">Dịch vụ</div>
                                            <div class="appointment-detail-value"><?php echo $appointment['service_name']; ?></div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="appointment-detail-label">Giá dịch vụ</div>
                                            <div class="appointment-detail-value"><?php echo number_format($appointment['service_price'], 0, ',', '.'); ?> VNĐ</div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="appointment-detail-label">Thanh toán</div>
                                            <div class="appointment-detail-value">
                                                <?php if (isset($appointment['thanh_toan']) && $appointment['thanh_toan'] == 'paid'): ?>
                                                    <span class="badge bg-success">Đã thanh toán</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning text-dark">Chưa thanh toán</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="appointment-detail-label">Lý do khám</div>
                                            <div class="appointment-detail-value"><?php echo $appointment['ly_do'] ?: 'Không có'; ?></div>
                                        </div>
                                        <?php if (!empty($appointment['ghi_chu'])): ?>
                                        <div class="col-md-12 mt-2">
                                            <div class="appointment-detail-label">Ghi chú</div>
                                            <div class="appointment-detail-value">
                                                <pre class="border p-2 bg-light" style="white-space: pre-wrap;"><?php echo $appointment['ghi_chu']; ?></pre>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <?php if ($appointment['trang_thai'] === 'pending'): ?>
                                    <!-- Các action cho lịch hẹn đang chờ xác nhận -->
                                    <div class="appointment-actions d-flex gap-2">
                                        <form method="POST" class="me-2">
                                            <input type="hidden" name="action" value="confirm">
                                            <input type="hidden" name="appointment_id" value="<?php echo $appointment['id']; ?>">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-check-circle me-1"></i> Xác nhận lịch hẹn
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelAppointmentModal">
                                            <i class="fas fa-times-circle me-1"></i> Hủy lịch hẹn
                                        </button>
                                    </div>
                                <?php elseif ($appointment['trang_thai'] === 'confirmed'): ?>
                                    <!-- Các action cho lịch hẹn đã xác nhận -->
                                    <div class="appointment-actions d-flex gap-2">
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#completeAppointmentModal">
                                            <i class="fas fa-check-double me-1"></i> Hoàn thành khám
                                        </button>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelAppointmentModal">
                                            <i class="fas fa-times-circle me-1"></i> Hủy lịch hẹn
                                        </button>
                                    </div>
                                <?php elseif ($appointment['trang_thai'] === 'completed'): ?>
                                    <!-- Medical Results for completed appointments -->
                                    <div class="medical-form-card">
                                        <h5 class="detail-section-title">
                                            <i class="fas fa-file-medical me-2"></i> Kết quả khám bệnh
                                        </h5>
                                        
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <div class="appointment-detail-label">Chẩn đoán</div>
                                                <div class="appointment-detail-value"><?php echo $appointment['chan_doan']; ?></div>
                                            </div>
                                            <?php if (!empty($appointment['ket_qua'])): ?>
                                            <div class="col-md-12 mb-3">
                                                <div class="appointment-detail-label">Kết quả khám</div>
                                                <div class="appointment-detail-value">
                                                    <pre class="border p-2 bg-light" style="white-space: pre-wrap;"><?php echo $appointment['ket_qua']; ?></pre>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                            <?php if (!empty($appointment['don_thuoc'])): ?>
                                            <div class="col-md-12 mb-3">
                                                <div class="appointment-detail-label">Đơn thuốc</div>
                                                <div class="appointment-detail-value">
                                                    <pre class="border p-2 bg-light" style="white-space: pre-wrap;"><?php echo $appointment['don_thuoc']; ?></pre>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                            <?php if (!empty($appointment['loi_dan'])): ?>
                                            <div class="col-md-12">
                                                <div class="appointment-detail-label">Lời dặn</div>
                                                <div class="appointment-detail-value">
                                                    <pre class="border p-2 bg-light" style="white-space: pre-wrap;"><?php echo $appointment['loi_dan']; ?></pre>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                            
                                            <div class="col-md-12 mt-3">
                                                <a href="includes/view_medical_record.php?id=<?php echo isset($appointment['id']) ? $appointment['id'] : 0; ?>" class="btn btn-primary" target="_blank">
                                                    <i class="fas fa-file-download me-1"></i> Tải xuống kết quả khám
                                                </a>
                                                <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editResultModal">
                                                    <i class="fas fa-edit me-1"></i> Chỉnh sửa kết quả
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Danh sách lịch hẹn -->
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
                        <h1 class="h2">Quản lý lịch hẹn</h1>
                        <div class="view-mode-selector">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a class="nav-link <?php echo $view_mode === 'list' ? 'active' : ''; ?>" href="?view=list">
                                        <i class="fas fa-list me-1"></i> Danh sách
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo $view_mode === 'calendar' ? 'active' : ''; ?>" href="?view=calendar">
                                        <i class="fas fa-calendar-alt me-1"></i> Thời gian biểu
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <?php if (!empty($success_message)): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo $success_message; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($error_message)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo $error_message; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <div class="search-filter mb-4">
                        <form method="GET" action="lichhen.php">
                            <?php if ($view_mode === 'calendar'): ?>
                                <input type="hidden" name="view" value="calendar">
                                
                                <?php 
                                    // Calculate date difference to show in heading
                                    $start_obj = !empty($filter['start_date']) ? new DateTime($filter['start_date']) : null;
                                    $end_obj = !empty($filter['end_date']) ? new DateTime($filter['end_date']) : null;
                                    
                                    if ($start_obj && $end_obj) {
                                        $date_diff = $start_obj->diff($end_obj)->days + 1;
                                    }
                                ?>
                                
                                <?php if (!empty($filter['start_date']) && !empty($filter['end_date'])): ?>
                                    <div class="dashboard-stats">
                                        <?php 
                                            // Tính tổng số lượng lịch hẹn trong khoảng thời gian đã chọn
                                            $stat_sql = "SELECT 
                                                COUNT(*) as total,
                                                SUM(CASE WHEN trang_thai = 'pending' THEN 1 ELSE 0 END) as pending,
                                                SUM(CASE WHEN trang_thai = 'confirmed' THEN 1 ELSE 0 END) as confirmed,
                                                SUM(CASE WHEN trang_thai = 'completed' THEN 1 ELSE 0 END) as completed,
                                                SUM(CASE WHEN trang_thai = 'cancelled' THEN 1 ELSE 0 END) as cancelled
                                            FROM lichhen 
                                            WHERE bacsi_id = ? AND ngay_hen BETWEEN ? AND ?";
                                            
                                            $stmt = $conn->prepare($stat_sql);
                                            $stmt->bind_param('iss', $doctor_id, $filter['start_date'], $filter['end_date']);
                                            $stmt->execute();
                                            $stat_result = $stmt->get_result()->fetch_assoc();
                                        ?>
                                        <div class="stat-card stat-card-blue">
                                            <i class="fas fa-calendar-check"></i>
                                            <div class="stat-number"><?php echo $stat_result['total']; ?></div>
                                            <div class="stat-label">Tổng số lịch hẹn</div>
                                        </div>
                                        <div class="stat-card stat-card-warning">
                                            <i class="fas fa-clock"></i>
                                            <div class="stat-number"><?php echo $stat_result['pending']; ?></div>
                                            <div class="stat-label">Chờ xác nhận</div>
                                        </div>
                                        <div class="stat-card stat-card-green">
                                            <i class="fas fa-check-circle"></i>
                                            <div class="stat-number"><?php echo $stat_result['confirmed']; ?></div>
                                            <div class="stat-label">Đã xác nhận</div>
                                        </div>
                                        <div class="stat-card stat-card-danger">
                                            <i class="fas fa-times-circle"></i>
                                            <div class="stat-number"><?php echo $stat_result['cancelled']; ?></div>
                                            <div class="stat-label">Đã hủy</div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="card mb-4">
                                    <div class="card-header bg-primary bg-opacity-10">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-calendar-alt text-primary me-2"></i>
                                            <h5 class="mb-0">Chọn khoảng thời gian</h5>
                                            <?php if (isset($date_diff)): ?>
                                                <span class="badge bg-primary ms-2"><?php echo $date_diff; ?> ngày</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-md-5">
                                                <label class="form-label fw-medium">Từ ngày:</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light">
                                                        <i class="fas fa-calendar-day"></i>
                                                    </span>
                                                    <input type="date" class="form-control" name="start_date" id="start-date" value="<?php echo $filter['start_date'] ?? ''; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <label class="form-label fw-medium">Đến ngày:</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light">
                                                        <i class="fas fa-calendar-day"></i>
                                                    </span>
                                                    <input type="date" class="form-control" name="end_date" id="end-date" value="<?php echo $filter['end_date'] ?? ''; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label d-md-block d-none">&nbsp;</label>
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas fa-filter me-1"></i> Áp dụng
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex mt-3 justify-content-end">
                                            <?php if (!empty($filter['start_date']) && !empty($filter['end_date'])): ?>
                                            <a href="?view=calendar" class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-times me-1"></i> Xóa bộ lọc
                                            </a>
                                            <?php endif; ?>
                                            
                                            <div class="dropdown ms-2">
                                                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" id="quickDateRanges" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-magic me-1"></i> Chọn nhanh
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="quickDateRanges">
                                                    <li><a class="dropdown-item quick-date" href="#" data-range="today">Hôm nay</a></li>
                                                    <li><a class="dropdown-item quick-date" href="#" data-range="tomorrow">Ngày mai</a></li>
                                                    <li><a class="dropdown-item quick-date" href="#" data-range="this-week">Tuần này</a></li>
                                                    <li><a class="dropdown-item quick-date" href="#" data-range="next-week">Tuần tới</a></li>
                                                    <li><a class="dropdown-item quick-date" href="#" data-range="this-month">Tháng này</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="row g-3 filter-row">
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                                            <input type="text" class="form-control" placeholder="Tìm kiếm..." name="search" value="<?php echo $search_filter; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-filter"></i></span>
                                            <select class="form-select" name="status">
                                                <option value="" <?php echo empty($status_filter) ? 'selected' : ''; ?>>Tất cả trạng thái</option>
                                                <option value="pending" <?php echo $status_filter === 'pending' ? 'selected' : ''; ?>>Chờ xác nhận</option>
                                                <option value="confirmed" <?php echo $status_filter === 'confirmed' ? 'selected' : ''; ?>>Đã xác nhận</option>
                                                <option value="completed" <?php echo $status_filter === 'completed' ? 'selected' : ''; ?>>Đã hoàn thành</option>
                                                <option value="cancelled" <?php echo $status_filter === 'cancelled' ? 'selected' : ''; ?>>Đã hủy</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                            <input type="date" class="form-control" placeholder="Chọn ngày" name="date" value="<?php echo $date_filter; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-end">
                                        <button type="submit" class="btn btn-primary me-2">
                                            <i class="fas fa-filter me-1"></i> Lọc
                                        </button>
                                        <?php if (!empty($status_filter) || !empty($date_filter) || !empty($search_filter)): ?>
                                        <a href="lichhen.php" class="btn btn-outline-secondary">
                                            <i class="fas fa-times me-1"></i> Xóa bộ lọc
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </form>
                    </div>

                    <?php if ($view_mode === 'calendar'): ?>
                        <!-- Calendar View -->
                        <?php
                            // Group days by week
                            $weeks = [];
                            $week_num = 0;
                            $current_week_days = [];
                            
                            // Get the start day of week (Monday = 1)
                            $start_day_of_week = (new DateTime($filter['start_date']))->format('N');
                            $day_count = 0;
                            
                            foreach ($schedule_data as $date => $day_data) {
                                $day_count++;
                                $current_week_days[] = ['date' => $date, 'data' => $day_data];
                                
                                // If we reach Sunday or the last day, start a new week
                                if ((($start_day_of_week + $day_count - 1) % 7 === 0) || count($schedule_data) === $day_count) {
                                    $weeks[] = $current_week_days;
                                    $current_week_days = [];
                                }
                            }
                        ?>
                        
                        <?php foreach ($weeks as $week_index => $week): ?>
                            <h5 class="calendar-weekday-label">
                                <i class="fas fa-calendar-week me-2"></i>
                                Tuần <?php echo $week_index + 1; ?>
                            </h5>
                            <div class="row">
                                <?php foreach ($week as $day): ?>
                                    <?php 
                                        $date = $day['date'];
                                        $day_data = $day['data'];
                                        $is_today = (date('Y-m-d') === $date);
                                        $is_selected = ($selected_day === $date);
                                        $day_class = 'calendar-day';
                                        
                                        if ($is_today) $day_class .= ' calendar-day-today';
                                        if ($is_selected) $day_class .= ' calendar-day-selected';
                                        
                                        // Đổi tên ngày sang tiếng Việt
                                        $day_name = '';
                                        switch ($day_data['day_name']) {
                                            case 'Monday': $day_name = 'Thứ Hai'; break;
                                            case 'Tuesday': $day_name = 'Thứ Ba'; break;
                                            case 'Wednesday': $day_name = 'Thứ Tư'; break;
                                            case 'Thursday': $day_name = 'Thứ Năm'; break;
                                            case 'Friday': $day_name = 'Thứ Sáu'; break;
                                            case 'Saturday': $day_name = 'Thứ Bảy'; break;
                                            case 'Sunday': $day_name = 'Chủ Nhật'; break;
                                        }
                                    ?>
                                    <div class="col-md-3 col-6">
                                        <a href="?view=calendar&start_date=<?php echo $filter['start_date']; ?>&end_date=<?php echo $filter['end_date']; ?>&day=<?php echo $date; ?>" 
                                           class="text-decoration-none">
                                            <div class="<?php echo $day_class; ?>">
                                                <div class="calendar-day-bg-icon">
                                                    <i class="fas fa-calendar-day"></i>
                                                </div>
                                                <div class="calendar-day-content">
                                                    <div class="calendar-day-header">
                                                        <div class="calendar-day-name"><?php echo $day_name; ?></div>
                                                        <div class="calendar-day-number"><?php echo $day_data['day_number']; ?>/<?php echo $day_data['month']; ?></div>
                                                    </div>
                                                    <div class="calendar-stats">
                                                        <div class="calendar-stat">
                                                            <span class="badge bg-primary"><?php echo $day_data['counts']['total']; ?></span> Tổng
                                                        </div>
                                                        <?php if ($day_data['counts']['pending'] > 0): ?>
                                                        <div class="calendar-stat">
                                                            <span class="badge bg-warning text-dark"><?php echo $day_data['counts']['pending']; ?></span> Chờ
                                                        </div>
                                                        <?php endif; ?>
                                                        <?php if ($day_data['counts']['confirmed'] > 0): ?>
                                                        <div class="calendar-stat">
                                                            <span class="badge bg-info"><?php echo $day_data['counts']['confirmed']; ?></span> Đã xác nhận
                                                        </div>
                                                        <?php endif; ?>
                                                        <?php if ($day_data['counts']['completed'] > 0): ?>
                                                        <div class="calendar-stat">
                                                            <span class="badge bg-success"><?php echo $day_data['counts']['completed']; ?></span> Hoàn thành
                                                        </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>

                        <?php if (!empty($selected_day) && isset($day_appointments)): ?>
                            <div class="day-appointments">
                                <h4>
                                    <i class="fas fa-calendar-day"></i>
                                    Chi tiết lịch hẹn ngày <?php echo date('d/m/Y', strtotime($selected_day)); ?>
                                    <span class="badge bg-primary appointment-count-badge"><?php echo count($day_appointments); ?> lịch hẹn</span>
                                </h4>
                                
                                <?php if (count($day_appointments) > 0): ?>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th width="10%">Giờ hẹn</th>
                                                    <th width="15%">Mã lịch hẹn</th>
                                                    <th width="25%">Bệnh nhân</th>
                                                    <th width="25%">Dịch vụ</th>
                                                    <th width="15%">Trạng thái</th>
                                                    <th width="10%" class="text-center">Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($day_appointments as $apt): ?>
                                                    <tr>
                                                        <td class="appointment-time"><?php echo $apt['gio_hen']; ?></td>
                                                        <td><?php echo $apt['ma_lichhen']; ?></td>
                                                        <td><?php echo $apt['patient_name']; ?></td>
                                                        <td><?php echo $apt['service_name']; ?></td>
                                                        <td>
                                                            <?php
                                                                switch($apt['trang_thai']) {
                                                                    case 'pending':
                                                                        echo '<span class="badge bg-warning text-dark">Chờ xác nhận</span>';
                                                                        break;
                                                                    case 'confirmed':
                                                                        echo '<span class="badge bg-primary">Đã xác nhận</span>';
                                                                        break;
                                                                    case 'completed':
                                                                        echo '<span class="badge bg-success">Đã hoàn thành</span>';
                                                                        break;
                                                                    case 'cancelled':
                                                                        echo '<span class="badge bg-danger">Đã hủy</span>';
                                                                        break;
                                                                    default:
                                                                        echo '<span class="badge bg-secondary">' . ucfirst($apt['trang_thai']) . '</span>';
                                                                }
                                                            ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="lichhen.php?action=view&id=<?php echo $apt['id']; ?>" class="btn btn-sm btn-info">
                                                                <i class="fas fa-eye"></i> Chi tiết
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Không có lịch hẹn nào vào ngày này.
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        
                    <?php elseif (count($appointments) > 0): ?>
                        <!-- Desktop view -->
                        <div class="desktop-only">
                            <div class="appointments-table">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Mã lịch hẹn</th>
                                            <th>Bệnh nhân</th>
                                            <th>Ngày hẹn</th>
                                            <th>Giờ hẹn</th>
                                            <th>Dịch vụ</th>
                                            <th>Trạng thái</th>
                                            <th class="table-action">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($appointments as $apt): ?>
                                            <tr>
                                                <td><?php echo $apt['ma_lichhen']; ?></td>
                                                <td><?php echo $apt['patient_name']; ?></td>
                                                <td><?php echo date('d/m/Y', strtotime($apt['ngay_hen'])); ?></td>
                                                <td><?php echo $apt['gio_hen']; ?></td>
                                                <td><?php echo $apt['service_name']; ?></td>
                                                <td>
                                                    <?php
                                                        switch($apt['trang_thai']) {
                                                            case 'pending':
                                                                echo '<span class="badge bg-warning text-dark">Chờ xác nhận</span>';
                                                                break;
                                                            case 'confirmed':
                                                                echo '<span class="badge bg-primary">Đã xác nhận</span>';
                                                                break;
                                                            case 'completed':
                                                                echo '<span class="badge bg-success">Đã hoàn thành</span>';
                                                                break;
                                                            case 'cancelled':
                                                                echo '<span class="badge bg-danger">Đã hủy</span>';
                                                                break;
                                                            default:
                                                                echo '<span class="badge bg-secondary">' . ucfirst($apt['trang_thai']) . '</span>';
                                                        }
                                                    ?>
                                                </td>
                                                <td class="text-center">
                                                    <a href="lichhen.php?action=view&id=<?php echo $apt['id']; ?>" class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i> Chi tiết
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Mobile view -->
                        <div class="mobile-only">
                            <?php foreach($appointments as $apt): ?>
                                <div class="mobile-appointment-card">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="mb-0"><?php echo $apt['ma_lichhen']; ?></h6>
                                        <?php
                                            switch($apt['trang_thai']) {
                                                case 'pending':
                                                    echo '<span class="badge bg-warning text-dark">Chờ xác nhận</span>';
                                                    break;
                                                case 'confirmed':
                                                    echo '<span class="badge bg-primary">Đã xác nhận</span>';
                                                    break;
                                                case 'completed':
                                                    echo '<span class="badge bg-success">Đã hoàn thành</span>';
                                                    break;
                                                case 'cancelled':
                                                    echo '<span class="badge bg-danger">Đã hủy</span>';
                                                    break;
                                                default:
                                                    echo '<span class="badge bg-secondary">' . ucfirst($apt['trang_thai']) . '</span>';
                                            }
                                        ?>
                                    </div>
                                    <div class="mb-2"><strong>Bệnh nhân:</strong> <?php echo $apt['patient_name']; ?></div>
                                    <div class="mb-2">
                                        <strong>Thời gian:</strong> 
                                        <?php echo date('d/m/Y', strtotime($apt['ngay_hen'])); ?> 
                                        lúc <?php echo $apt['gio_hen']; ?>
                                    </div>
                                    <div class="mb-3"><strong>Dịch vụ:</strong> <?php echo $apt['service_name']; ?></div>
                                    <div class="text-center">
                                        <a href="lichhen.php?action=view&id=<?php echo $apt['id']; ?>" class="btn btn-sm btn-info w-100">
                                            <i class="fas fa-eye me-1"></i> Xem chi tiết
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Pagination -->
                        <?php if ($total_pages > 1): ?>
                            <div class="d-flex justify-content-center mt-4">
                                <nav>
                                    <ul class="pagination">
                                        <?php if ($current_page > 1): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=<?php echo $current_page-1; ?>&status=<?php echo $status_filter; ?>&date=<?php echo $date_filter; ?>&search=<?php echo $search_filter; ?>">
                                                <i class="fas fa-angle-left"></i>
                                            </a>
                                        </li>
                                        <?php endif; ?>
                                        
                                        <?php
                                        $start_page = max(1, $current_page - 2);
                                        $end_page = min($start_page + 4, $total_pages);
                                        
                                        if ($end_page - $start_page < 4 && $start_page > 1) {
                                            $start_page = max(1, $end_page - 4);
                                        }
                                        
                                        for ($i = $start_page; $i <= $end_page; $i++): 
                                        ?>
                                            <li class="page-item <?php echo $i == $current_page ? 'active' : ''; ?>">
                                                <a class="page-link" href="?page=<?php echo $i; ?>&status=<?php echo $status_filter; ?>&date=<?php echo $date_filter; ?>&search=<?php echo $search_filter; ?>">
                                                    <?php echo $i; ?>
                                                </a>
                                            </li>
                                        <?php endfor; ?>
                                        
                                        <?php if ($current_page < $total_pages): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=<?php echo $current_page+1; ?>&status=<?php echo $status_filter; ?>&date=<?php echo $date_filter; ?>&search=<?php echo $search_filter; ?>">
                                                <i class="fas fa-angle-right"></i>
                                            </a>
                                        </li>
                                        <?php endif; ?>
                                    </ul>
                                </nav>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="alert alert-info">
                            Không tìm thấy lịch hẹn nào phù hợp.
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </main>
        </div>
    </div>

    <!-- Modal hủy lịch hẹn -->
    <div class="modal fade" id="cancelAppointmentModal" tabindex="-1" aria-labelledby="cancelAppointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelAppointmentModalLabel">Hủy lịch hẹn</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <input type="hidden" name="action" value="cancel">
                        <input type="hidden" name="appointment_id" value="<?php echo $appointment_id; ?>">
                        
                        <div class="mb-3">
                            <label for="ly_do" class="form-label">Lý do hủy <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="ly_do" name="ly_do" rows="3" required></textarea>
                        </div>
                        
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-danger">Xác nhận hủy</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal hoàn thành lịch hẹn -->
    <div class="modal fade" id="completeAppointmentModal" tabindex="-1" aria-labelledby="completeAppointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="completeAppointmentModalLabel">Hoàn thành lịch hẹn & Cập nhật kết quả khám</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="completeAppointmentForm">
                        <input type="hidden" name="action" value="complete">
                        <input type="hidden" name="appointment_id" value="<?php echo isset($appointment['id']) ? $appointment['id'] : 0; ?>">
                        
                        <div class="mb-3">
                            <label for="chan_doan" class="form-label">Chẩn đoán <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="chan_doan" name="chan_doan" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="ket_qua" class="form-label">Kết quả khám</label>
                            <textarea class="form-control" id="ket_qua" name="ket_qua" rows="3"></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="don_thuoc" class="form-label">Đơn thuốc</label>
                            <textarea class="form-control" id="don_thuoc" name="don_thuoc" rows="3" placeholder="VD: 1. Paracetamol 500mg - Uống 1 viên khi sốt trên 38.5 độ"></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="loi_dan" class="form-label">Lời dặn</label>
                            <textarea class="form-control" id="loi_dan" name="loi_dan" rows="2"></textarea>
                        </div>
                        
                        <div class="alert alert-info">
                            <div class="d-flex">
                                <div class="me-2">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                <div>
                                    <p class="mb-0">Hoàn thành lịch hẹn sẽ cập nhật trạng thái lịch hẹn thành "Đã hoàn thành" và lưu thông tin kết quả khám bệnh.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-success">Hoàn thành khám</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal chỉnh sửa kết quả khám -->
    <div class="modal fade" id="editResultModal" tabindex="-1" aria-labelledby="editResultModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editResultModalLabel">Chỉnh sửa kết quả khám</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="editResultForm">
                        <input type="hidden" name="action" value="complete">
                        <input type="hidden" name="appointment_id" value="<?php echo isset($appointment['id']) ? $appointment['id'] : 0; ?>">
                        
                        <div class="mb-3">
                            <label for="edit_chan_doan" class="form-label">Chẩn đoán <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_chan_doan" name="chan_doan" value="<?php echo htmlspecialchars($appointment['chan_doan'] ?? ''); ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="edit_ket_qua" class="form-label">Kết quả khám</label>
                            <textarea class="form-control" id="edit_ket_qua" name="ket_qua" rows="3"><?php echo htmlspecialchars($appointment['ket_qua'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="edit_don_thuoc" class="form-label">Đơn thuốc</label>
                            <textarea class="form-control" id="edit_don_thuoc" name="don_thuoc" rows="3"><?php echo htmlspecialchars($appointment['don_thuoc'] ?? ''); ?></textarea>
                            <small class="text-muted">VD: 1. Paracetamol 500mg - Uống 1 viên khi sốt trên 38.5 độ</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="edit_loi_dan" class="form-label">Lời dặn</label>
                            <textarea class="form-control" id="edit_loi_dan" name="loi_dan" rows="2"><?php echo htmlspecialchars($appointment['loi_dan'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-success">Lưu thay đổi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap Datepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.vi.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        $(document).ready(function() {
            // Toggle quick action dropdown menu
            $('.action-toggle').on('click', function(e) {
                e.preventDefault();
                $(this).next('.dropdown-menu').toggleClass('show');
            });
            
            // Handle weekly date range selection
            $('#start-date, #end-date').on('change', function() {
                var startDate = $('#start-date').val();
                var endDate = $('#end-date').val();
                
                if (startDate && endDate) {
                    // Calculate the difference in days
                    var start = new Date(startDate);
                    var end = new Date(endDate);
                    var diffTime = Math.abs(end - start);
                    var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    
                    // Warn if the range is too large
                    if (diffDays > 14) {
                        alert('Khoảng thời gian quá dài (hơn 14 ngày). Vui lòng chọn khoảng thời gian ngắn hơn để hiển thị tốt nhất.');
                    }
                }
            });
            
            // Add animations to stat cards
            $('.stat-card').each(function(index) {
                $(this).delay(index * 100).animate({
                    opacity: 1,
                    top: 0
                }, 500);
            });
            
            // Add hover effects to calendar days
            $('.calendar-day').hover(
                function() {
                    $(this).addClass('shadow-lg');
                },
                function() {
                    $(this).removeClass('shadow-lg');
                }
            );
            
            // Add click animation to calendar days
            $('.calendar-day').on('click', function() {
                $(this).addClass('pulse');
                setTimeout(function() {
                    $('.calendar-day').removeClass('pulse');
                }, 300);
            });
            
            // Add automatic selection of next week when current range ends
            $('#end-date').on('change', function() {
                if ($(this).val() && $('#start-date').val()) {
                    var currentEndDate = new Date($(this).val());
                    
                    // Add animation to submit button to attract attention
                    $('.date-range-picker button[type="submit"]').addClass('btn-pulse');
                    setTimeout(function() {
                        $('.date-range-picker button[type="submit"]').removeClass('btn-pulse');
                    }, 1000);
                }
            });
            
            // Close alerts after 5 seconds
            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);
            
            // Initialize tooltip
            $('[data-bs-toggle="tooltip"]').tooltip();
            
            // Add ripple effect to buttons
            $('.btn').on('click', function(e) {
                var x = e.pageX - $(this).offset().left;
                var y = e.pageY - $(this).offset().top;
                
                var $ripple = $('<span class="btn-ripple"></span>');
                $ripple.css({
                    top: y,
                    left: x
                });
                
                $(this).append($ripple);
                
                setTimeout(function() {
                    $ripple.remove();
                }, 700);
            });
            
            // Add quick date range selection functionality
            $('.quick-date').click(function(e) {
                e.preventDefault();
                
                let today = new Date();
                let startDate = new Date();
                let endDate = new Date();
                
                switch($(this).data('range')) {
                    case 'today':
                        // Start and end are both today
                        break;
                    case 'tomorrow':
                        startDate.setDate(today.getDate() + 1);
                        endDate.setDate(today.getDate() + 1);
                        break;
                    case 'this-week':
                        // Start is today, end is Sunday
                        let dayOfWeek = today.getDay(); // 0 is Sunday
                        let daysUntilSunday = dayOfWeek === 0 ? 0 : 7 - dayOfWeek;
                        endDate.setDate(today.getDate() + daysUntilSunday);
                        break;
                    case 'next-week':
                        // Start is next Monday, end is next Sunday
                        let currDayOfWeek = today.getDay(); // 0 is Sunday
                        let daysUntilNextMonday = currDayOfWeek === 0 ? 1 : 8 - currDayOfWeek;
                        startDate.setDate(today.getDate() + daysUntilNextMonday);
                        endDate.setDate(startDate.getDate() + 6);
                        break;
                    case 'this-month':
                        // Start is today, end is last day of month
                        startDate = today;
                        endDate = new Date(today.getFullYear(), today.getMonth() + 1, 0);
                        break;
                }
                
                // Format dates as YYYY-MM-DD for input fields
                $('#start-date').val(formatDateForInput(startDate));
                $('#end-date').val(formatDateForInput(endDate));
                
                // Submit the form
                $(this).closest('form').submit();
            });
            
            // Helper function to format date as YYYY-MM-DD
            function formatDateForInput(date) {
                let month = (date.getMonth() + 1).toString().padStart(2, '0');
                let day = date.getDate().toString().padStart(2, '0');
                return `${date.getFullYear()}-${month}-${day}`;
            }
        });
    </script>
    
    <style>
        /* Animation styles */
        .stat-card {
            opacity: 0;
            position: relative;
            top: 20px;
        }
        
        .btn-pulse {
            animation: pulse 1s infinite;
        }
        
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(13, 110, 253, 0.7);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(13, 110, 253, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(13, 110, 253, 0);
            }
        }
        
        .pulse {
            animation: pulse-animation 0.5s;
        }
        
        @keyframes pulse-animation {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(0.98);
            }
            100% {
                transform: scale(1);
            }
        }
        
        .btn-ripple {
            position: absolute;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            transform: scale(0);
            animation: ripple 0.6s linear;
            pointer-events: none;
        }
        
        @keyframes ripple {
            to {
                transform: scale(2.5);
                opacity: 0;
            }
        }
        
        /* Improved date range picker styling */
        .card-header {
            border-bottom: 1px solid rgba(0,0,0,.125);
        }
        
        .form-label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 0.3rem;
        }
        
        .input-group .form-control:focus {
            z-index: auto;
        }
    </style>
</body>
</html>
<?php
header('Content-Type: application/json');
require_once 'includes/db_connect.php';
require_once 'includes/functions.php';

// Kiểm tra phương thức yêu cầu
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Phương thức không được hỗ trợ']);
    exit;
}

// Lấy tham số từ request
$ma_lichhen = isset($_GET['ma_lichhen']) ? trim($_GET['ma_lichhen']) : '';
$sdt = isset($_GET['sdt']) ? trim($_GET['sdt']) : '';

// Xác thực dữ liệu đầu vào
if (empty($ma_lichhen) || empty($sdt)) {
    http_response_code(400);
    echo json_encode(['error' => 'Thiếu thông tin cần thiết']);
    exit;
}

try {
    // Truy vấn thông tin lịch hẹn
    $stmt = $conn->prepare("
        SELECT l.trang_thai, l.ngay_hen, l.gio_hen, 
               bn.ho_ten AS patient_name, 
               b.ho_ten AS doctor_name, 
               c.ten_chuyenkhoa AS specialty_name, 
               d.ten_dichvu AS service_name,
               k.id AS record_id
        FROM lichhen l
        JOIN benhnhan bn ON l.benhnhan_id = bn.id
        JOIN bacsi b ON l.bacsi_id = b.id
        JOIN chuyenkhoa c ON b.chuyenkhoa_id = c.id
        LEFT JOIN dichvu d ON l.dichvu_id = d.id
        LEFT JOIN ketqua_kham k ON k.lichhen_id = l.id
        WHERE l.ma_lichhen = ? AND bn.dien_thoai = ?
    ");

    $stmt->bind_param("ss", $ma_lichhen, $sdt);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        http_response_code(404);
        echo json_encode(['error' => 'Không tìm thấy thông tin lịch hẹn']);
        exit;
    }

    $appointment = $result->fetch_assoc();
    $stmt->close();

    // Chuẩn bị dữ liệu trả về
    $response = [
        'status' => $appointment['trang_thai'],
        'status_name' => get_status_name($appointment['trang_thai']),
        'status_badge' => get_status_badge($appointment['trang_thai']),
        'status_icon' => get_status_icon($appointment['trang_thai']),
        'has_record' => !empty($appointment['record_id']),
        'record_id' => $appointment['record_id'],
        'record_url' => !empty($appointment['record_id']) ? 
            'view_public_record.php?id=' . $appointment['record_id'] . '&code=' . md5($ma_lichhen . $sdt) : null,
        'patient_name' => $appointment['patient_name'],
        'doctor_name' => $appointment['doctor_name'],
        'specialty_name' => $appointment['specialty_name'],
        'service_name' => $appointment['service_name'],
        'appointment_date' => date('d/m/Y', strtotime($appointment['ngay_hen'])),
        'appointment_time' => date('H:i', strtotime($appointment['gio_hen']))
    ];

    // Ghi log nếu cần
    file_put_contents(
        'logs/status_check_' . date('Y-m') . '.log',
        date('Y-m-d H:i:s') . " | Status check for: $ma_lichhen | $sdt | Status: {$appointment['trang_thai']}\n",
        FILE_APPEND
    );

    echo json_encode($response);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Lỗi server: ' . $e->getMessage()]);
    
    // Ghi log lỗi
    file_put_contents(
        'logs/user_errors_' . date('Y-m') . '.log',
        date('Y-m-d H:i:s') . " | Error in status API: " . $e->getMessage() . "\n",
        FILE_APPEND
    );
}
?>
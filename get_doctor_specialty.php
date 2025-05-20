<?php
// get_doctor_specialty.php - Endpoint to fetch doctor's specialty information
header('Content-Type: application/json');
require_once 'includes/db_connect.php';

// Check if doctor ID is provided
if (!isset($_GET['doctor_id']) || empty($_GET['doctor_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Thiếu thông tin bác sĩ']);
    exit;
}

$doctor_id = intval($_GET['doctor_id']);

// Fetch doctor's specialty information
$stmt = $conn->prepare("SELECT 
    b.id, 
    b.ho_ten, 
    b.chuyenkhoa_id, 
    c.ten_chuyenkhoa
FROM bacsi b 
LEFT JOIN chuyenkhoa c ON b.chuyenkhoa_id = c.id 
WHERE b.id = ?");
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();

$doctor = $result->fetch_assoc();

if (!$doctor) {
    echo json_encode(['status' => 'error', 'message' => 'Không tìm thấy bác sĩ']);
    exit;
}

echo json_encode([
    'status' => 'success',
    'doctor_id' => $doctor['id'],
    'ho_ten' => $doctor['ho_ten'],
    'chuyenkhoa_id' => $doctor['chuyenkhoa_id'],
    'ten_chuyenkhoa' => $doctor['ten_chuyenkhoa']
]);
?>
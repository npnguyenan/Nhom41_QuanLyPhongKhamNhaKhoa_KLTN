<?php
// get_service_specialty.php - Endpoint to fetch service details and its specialty
header('Content-Type: application/json');
require_once 'includes/db_connect.php';

// Check if service ID is provided
if (!isset($_GET['service_id']) || empty($_GET['service_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Thiếu thông tin dịch vụ']);
    exit;
}

$service_id = intval($_GET['service_id']);

// Fetch service details with specialty information
$stmt = $conn->prepare("SELECT 
    d.id, 
    d.ten_dichvu, 
    d.gia_coban, 
    d.chuyenkhoa_id, 
    c.ten_chuyenkhoa
FROM dichvu d 
LEFT JOIN chuyenkhoa c ON d.chuyenkhoa_id = c.id 
WHERE d.id = ? AND d.trangthai = 1");
$stmt->bind_param("i", $service_id);
$stmt->execute();
$result = $stmt->get_result();

$service = $result->fetch_assoc();

if (!$service) {
    echo json_encode(['status' => 'error', 'message' => 'Không tìm thấy dịch vụ']);
    exit;
}

// Format the price for display
$service['gia_format'] = number_format($service['gia_coban'], 0, ',', '.') . 'đ';

echo json_encode([
    'status' => 'success',
    'id' => $service['id'],
    'ten_dichvu' => $service['ten_dichvu'],
    'gia' => $service['gia_coban'],
    'gia_format' => $service['gia_format'],
    'chuyenkhoa_id' => $service['chuyenkhoa_id'],
    'ten_chuyenkhoa' => $service['ten_chuyenkhoa']
]);
?>
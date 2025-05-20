<?php
// filter_services.php - Endpoint to fetch services based on doctor ID
header('Content-Type: application/json');
require_once 'includes/db_connect.php';

// Validate doctor_id
if (!isset($_GET['doctor_id']) || empty($_GET['doctor_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Thiếu thông tin bác sĩ']);
    exit;
}

$doctor_id = intval($_GET['doctor_id']);

// Get specialty of the doctor
$stmt = $conn->prepare("SELECT chuyenkhoa_id FROM bacsi WHERE id = ?");
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();
$doc = $result->fetch_assoc();
if (!$doc) {
    echo json_encode(['status' => 'error', 'message' => 'Không tìm thấy bác sĩ']);
    exit;
}

$specialty_id = intval($doc['chuyenkhoa_id']);

// Fetch active services for this specialty
$stmt2 = $conn->prepare("SELECT id, ten_dichvu, gia_coban FROM dichvu WHERE trangthai = 1 AND chuyenkhoa_id = ? ORDER BY ten_dichvu");
$stmt2->bind_param("i", $specialty_id);
$stmt2->execute();
$result2 = $stmt2->get_result();

$services = [];
while ($row = $result2->fetch_assoc()) {
    $services[] = [
        'id' => $row['id'], 
        'name' => $row['ten_dichvu'],
        'price' => $row['gia_coban'],
        'price_format' => number_format($row['gia_coban'], 0, ',', '.') . 'đ'
    ];
}

echo json_encode([
    'status' => 'success', 
    'services' => $services, 
    'specialty_id' => $specialty_id
]);
exit;
?>
<?php
// filter_services_by_specialty.php - Endpoint to fetch services by specialty ID
header('Content-Type: application/json');
require_once 'includes/db_connect.php';

// Check if specialty ID is provided
if (!isset($_GET['specialty_id']) || empty($_GET['specialty_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Thiếu thông tin chuyên khoa']);
    exit;
}

$specialty_id = intval($_GET['specialty_id']);

// Fetch active services for this specialty
$stmt = $conn->prepare("SELECT 
                        id, 
                        ten_dichvu, 
                        gia_coban 
                      FROM dichvu 
                      WHERE trangthai = 1 AND chuyenkhoa_id = ? 
                      ORDER BY ten_dichvu");
$stmt->bind_param("i", $specialty_id);
$stmt->execute();
$result = $stmt->get_result();

$services = [];
while ($row = $result->fetch_assoc()) {
    $services[] = [
        'id' => $row['id'], 
        'name' => $row['ten_dichvu'],
        'price' => $row['gia_coban'],
        'price_format' => number_format($row['gia_coban'], 0, ',', '.') . 'đ'
    ];
}

echo json_encode(['status' => 'success', 'services' => $services]);
?>
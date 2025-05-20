<?php
// filter_doctors.php - Endpoint to fetch doctors by specialty ID
header('Content-Type: application/json');
require_once 'includes/db_connect.php';

// Check if specialty ID is provided
if (!isset($_GET['specialty_id']) || empty($_GET['specialty_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Thiếu thông tin chuyên khoa']);
    exit;
}

$specialty_id = intval($_GET['specialty_id']);

// Fetch doctors by specialty ID - Removed trangthai condition as it doesn't exist
$stmt = $conn->prepare("SELECT id, ho_ten FROM bacsi WHERE chuyenkhoa_id = ? ORDER BY ho_ten");
$stmt->bind_param("i", $specialty_id);
$stmt->execute();
$result = $stmt->get_result();

$doctors = [];
while ($row = $result->fetch_assoc()) {
    $doctors[] = [
        'id' => $row['id'],
        'name' => $row['ho_ten']
    ];
}

echo json_encode(['status' => 'success', 'doctors' => $doctors]);
?>
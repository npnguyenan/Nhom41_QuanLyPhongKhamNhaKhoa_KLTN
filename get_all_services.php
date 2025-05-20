<?php
// get_all_services.php - Endpoint to fetch all active services
header('Content-Type: application/json');
require_once 'includes/db_connect.php';

// Fetch all active services
$stmt = $conn->prepare("SELECT 
                        d.id, 
                        d.ten_dichvu, 
                        d.gia_coban, 
                        d.chuyenkhoa_id, 
                        c.ten_chuyenkhoa 
                      FROM dichvu d 
                      LEFT JOIN chuyenkhoa c ON d.chuyenkhoa_id = c.id 
                      WHERE d.trangthai = 1 
                      ORDER BY ten_dichvu");
$stmt->execute();
$result = $stmt->get_result();

$services = [];
while ($row = $result->fetch_assoc()) {
    // Format the price for display
    $row['gia_format'] = number_format($row['gia_coban'], 0, ',', '.') . 'đ';
    
    $services[] = $row;
}

echo json_encode([
    'status' => 'success',
    'services' => $services
]);
?>
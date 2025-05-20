<?php
// Kiểm tra quyền truy cập
require_once 'includes/auth_check.php';

// Lấy thông tin nhân viên đang đăng nhập
$user = get_logged_in_user();
$staff_id = null;

$stmt = $conn->prepare("SELECT id, ho_ten FROM nhanvien WHERE nguoidung_id = ?");
$stmt->bind_param('i', $user['id']);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $staff = $result->fetch_assoc();
    $staff_id = $staff['id'];
}

// Dashboard statistics
$today = date('Y-m-d');
$stats = [];

// Lấy thống kê lịch hẹn cho ngày hôm nay
$sql_today = "SELECT 
    COUNT(*) as total,
    SUM(CASE WHEN trang_thai = 'pending' THEN 1 ELSE 0 END) as pending,
    SUM(CASE WHEN trang_thai = 'confirmed' THEN 1 ELSE 0 END) as confirmed,
    SUM(CASE WHEN trang_thai = 'completed' THEN 1 ELSE 0 END) as completed,
    SUM(CASE WHEN trang_thai = 'cancelled' THEN 1 ELSE 0 END) as cancelled
FROM lichhen 
WHERE ngay_hen = ?";

$stmt = $conn->prepare($sql_today);
$stmt->bind_param('s', $today);
$stmt->execute();
$stats['today'] = $stmt->get_result()->fetch_assoc();

// Lấy thống kê tuần này
$week_start = date('Y-m-d', strtotime('monday this week'));
$week_end = date('Y-m-d', strtotime('sunday this week'));

$sql_week = "SELECT 
    COUNT(*) as total,
    SUM(CASE WHEN trang_thai = 'pending' THEN 1 ELSE 0 END) as pending,
    SUM(CASE WHEN trang_thai = 'confirmed' THEN 1 ELSE 0 END) as confirmed,
    SUM(CASE WHEN trang_thai = 'completed' THEN 1 ELSE 0 END) as completed,
    SUM(CASE WHEN trang_thai = 'cancelled' THEN 1 ELSE 0 END) as cancelled
FROM lichhen 
WHERE ngay_hen BETWEEN ? AND ?";

$stmt = $conn->prepare($sql_week);
$stmt->bind_param('ss', $week_start, $week_end);
$stmt->execute();
$stats['week'] = $stmt->get_result()->fetch_assoc();

// Lấy danh sách lịch hẹn hôm nay
$sql_appointments = "SELECT lh.*, bn.ho_ten AS patient_name, bs.ho_ten AS doctor_name, dv.ten_dichvu AS service_name
                    FROM lichhen lh
                    LEFT JOIN benhnhan bn ON lh.benhnhan_id = bn.id
                    LEFT JOIN bacsi bs ON lh.bacsi_id = bs.id
                    LEFT JOIN dichvu dv ON lh.dichvu_id = dv.id
                    WHERE lh.ngay_hen = ?
                    ORDER BY lh.gio_hen ASC";

$stmt = $conn->prepare($sql_appointments);
$stmt->bind_param('s', $today);
$stmt->execute();
$today_appointments = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang quản lý - Nhân viên</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }
        .stats-card {
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            padding: 20px;
            margin-bottom: 20px;
            transition: transform 0.3s;
        }
        .stats-card:hover {
            transform: translateY(-5px);
        }
        .stats-card h3 {
            font-size: 18px;
            margin-bottom: 15px;
            color: #333;
        }
        .stats-number {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .stats-label {
            font-size: 0.9rem;
            color: #6c757d;
        }
        .bg-gradient-primary {
            background: linear-gradient(45deg, #4e73df 0%, #6d8bf8 100%);
            color: white;
        }
        .bg-gradient-success {
            background: linear-gradient(45deg, #1cc88a 0%, #3ee7a6 100%);
            color: white;
        }
        .bg-gradient-info {
            background: linear-gradient(45deg, #36b9cc 0%, #5ce0fa 100%);
            color: white;
        }
        .bg-gradient-warning {
            background: linear-gradient(45deg, #f6c23e 0%, #f8d684 100%);
            color: white;
        }
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        .appointment-card {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }
        .appointment-card:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transform: translateY(-3px);
        }
        .appointment-time {
            font-weight: 600;
            color: #4e73df;
        }
        .appointment-patient {
            font-weight: 500;
            font-size: 18px;
            color: #333;
        }
        .appointment-service {
            color: #6c757d;
        }
        .appointment-doctor {
            font-style: italic;
            color: #343a40;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include 'includes/sidebar.php'; ?>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Trang tổng quan</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <a href="lichhen.php" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-calendar-alt me-1"></i> Quản lý lịch hẹn
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="stats-card bg-gradient-primary">
                            <h3>Tổng số lịch hẹn hôm nay</h3>
                            <div class="stats-number"><?php echo $stats['today']['total'] ?? 0; ?></div>
                            <div class="stats-label">Lịch hẹn</div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="stats-card bg-gradient-success">
                            <h3>Đã xác nhận</h3>
                            <div class="stats-number"><?php echo $stats['today']['confirmed'] ?? 0; ?></div>
                            <div class="stats-label">Lịch hẹn</div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="stats-card bg-gradient-info">
                            <h3>Chờ xác nhận</h3>
                            <div class="stats-number"><?php echo $stats['today']['pending'] ?? 0; ?></div>
                            <div class="stats-label">Lịch hẹn</div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="stats-card bg-gradient-warning">
                            <h3>Đã hoàn thành</h3>
                            <div class="stats-number"><?php echo $stats['today']['completed'] ?? 0; ?></div>
                            <div class="stats-label">Lịch hẹn</div>
                        </div>
                    </div>
                </div>

                <!-- Weekly Statistics -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Thống kê tuần này (<?php echo date('d/m/Y', strtotime($week_start)); ?> - <?php echo date('d/m/Y', strtotime($week_end)); ?>)</h6>
                        <a href="lichhen.php?view=calendar" class="btn btn-sm btn-primary">Xem theo lịch</a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Tổng số lịch hẹn</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $stats['week']['total'] ?? 0; ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    Đã xác nhận</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $stats['week']['confirmed'] ?? 0; ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card border-left-info shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                    Chờ xác nhận</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $stats['week']['pending'] ?? 0; ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                    Đã hoàn thành</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $stats['week']['completed'] ?? 0; ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-check-double fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Today's Appointments -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Lịch hẹn hôm nay (<?php echo date('d/m/Y'); ?>)</h6>
                    </div>
                    <div class="card-body">
                        <?php if (count($today_appointments) > 0): ?>
                            <?php foreach ($today_appointments as $appointment): ?>
                                <div class="appointment-card">
                                    <div class="row align-items-center">
                                        <div class="col-md-2">
                                            <div class="appointment-time"><?php echo date('H:i', strtotime($appointment['gio_hen'])); ?></div>
                                            <?php 
                                                $status_class = '';
                                                $status_text = '';
                                                switch($appointment['trang_thai']) {
                                                    case 'pending':
                                                        $status_class = 'bg-warning';
                                                        $status_text = 'Chờ xác nhận';
                                                        break;
                                                    case 'confirmed':
                                                        $status_class = 'bg-success';
                                                        $status_text = 'Đã xác nhận';
                                                        break;
                                                    case 'completed':
                                                        $status_class = 'bg-primary';
                                                        $status_text = 'Hoàn thành';
                                                        break;
                                                    case 'cancelled':
                                                        $status_class = 'bg-danger';
                                                        $status_text = 'Đã hủy';
                                                        break;
                                                }
                                            ?>
                                            <span class="badge <?php echo $status_class; ?> status-badge mt-2"><?php echo $status_text; ?></span>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="appointment-patient"><?php echo $appointment['patient_name']; ?></div>
                                            <div class="appointment-service"><?php echo $appointment['service_name'] ?? 'Không có dịch vụ'; ?></div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="appointment-doctor">
                                                <i class="fas fa-user-md me-1"></i> Bác sĩ: <?php echo $appointment['doctor_name']; ?>
                                            </div>
                                            <div class="text-muted small">
                                                <i class="fas fa-id-card me-1"></i> Mã: <?php echo $appointment['ma_lichhen']; ?>
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <a href="lichhen.php?action=view&id=<?php echo $appointment['id']; ?>" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i> Chi tiết
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="alert alert-info">
                                Không có lịch hẹn nào cho ngày hôm nay.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>

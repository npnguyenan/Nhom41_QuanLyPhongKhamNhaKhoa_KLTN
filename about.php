<?php
// Thiết lập tiêu đề trang cho head.php
$GLOBALS['page_title'] = 'Giới thiệu';
require_once 'includes/functions.php';
include_once 'includes/page_banner.php';

// Lấy thông tin từ cài đặt
$site_name = get_setting('site_name', 'Nha Khoa T&A');
$about_image = get_setting('about_image', 'assets/img/anh-gioithieu.jpg');
$about_content = get_setting('about_content', '');
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <?php include 'includes/head.php'; ?>
    <link rel="stylesheet" href="assets/css/pages/about.css">
</head>
<body>
    <!-- Header -->
    <?php include 'includes/header.php'; ?>

    <!-- Banner -->
    <?php display_page_banner('Giới thiệu', 'Chào mừng bạn đến với Nha Khoa T&A '); ?>

    <!-- Main Content -->
    <div class="container my-5">
        <div class="row">
            <div class="col-md-6">
                <img src="<?php echo $about_image; ?>" alt="<?php echo htmlspecialchars($site_name); ?>" class="img-fluid rounded">
            </div>
            <div class="col-md-6">
                <?php if (!empty($about_content)): ?>
                    <?php echo $about_content; ?>
                <?php else: ?>
                    <h2>Chúng tôi là ai?</h2>
                    <p>
                        <?php echo htmlspecialchars($site_name); ?> được thành lập với sứ mệnh cung cấp dịch vụ chăm sóc sức khỏe chất lượng cao cho cộng đồng. 
                        Chúng tôi tự hào là một trong những phòng khám hàng đầu trong khu vực, với đội ngũ bác sĩ chuyên môn cao và 
                        trang thiết bị hiện đại.
                    </p>
                    <h2>Giá trị cốt lõi</h2>
                    <ul>
                        <li>Chất lượng dịch vụ</li>
                        <li>Đội ngũ bác sĩ chuyên nghiệp</li>
                        <li>Chăm sóc tận tâm</li>
                        <li>Đổi mới và sáng tạo</li>
                    </ul>
                <?php endif; ?>
            </div>
        </div>

        <div class="mt-5">
            <h2>Cam kết của chúng tôi</h2>
            <p>
                Nha khoa T&A cam kết mang đến dịch vụ điều trị chất lượng cao với đội ngũ bác sĩ giỏi và tận tâm, trang thiết bị hiện đại, quy trình vô trùng tuyệt đối, chi phí minh bạch, không phát sinh, cùng chính sách bảo hành rõ ràng và chăm sóc dài lâu, đồng hành trọn đời cùng sức khỏe và nụ cười của bạn.
                
            </p>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>
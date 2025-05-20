<?php
// Kết nối đến database
require_once 'includes/db_connect.php';
require_once 'includes/functions.php';

// Thiết lập tiêu đề trang cho head.php
$GLOBALS['page_title'] = 'Trang chủ';

// Lấy danh sách chuyên khoa
$specialties_query = "SELECT * FROM chuyenkhoa ORDER BY id LIMIT 6";
$specialties_result = $conn->query($specialties_query);
$specialties = [];
if ($specialties_result && $specialties_result->num_rows > 0) {
    while ($row = $specialties_result->fetch_assoc()) {
        $specialties[] = $row;
    }
}

// Lấy danh sách tất cả chuyên khoa cho dropdown tìm kiếm
$all_specialties_query = "SELECT * FROM chuyenkhoa ORDER BY ten_chuyenkhoa ASC";
$all_specialties_result = $conn->query($all_specialties_query);
$all_specialties = [];
if ($all_specialties_result && $all_specialties_result->num_rows > 0) {
    while ($row = $all_specialties_result->fetch_assoc()) {
        $all_specialties[] = $row;
    }
}

// Lấy tin tức mới nhất
$news_query = "SELECT * FROM tintuc WHERE trang_thai = 'published' ORDER BY ngay_dang DESC LIMIT 3";
$news_result = $conn->query($news_query);
$news_items = [];
if ($news_result && $news_result->num_rows > 0) {
    while ($row = $news_result->fetch_assoc()) {
        $news_items[] = $row;
    }
}

// Lấy danh sách bác sĩ nổi bật
$doctors_query = "SELECT b.*, c.ten_chuyenkhoa 
                 FROM bacsi b 
                 JOIN chuyenkhoa c ON b.chuyenkhoa_id = c.id 
                 ORDER BY b.id LIMIT 4";
$doctors_result = $conn->query($doctors_query);
$doctors = [];
if ($doctors_result && $doctors_result->num_rows > 0) {
    while ($row = $doctors_result->fetch_assoc()) {
        $doctors[] = $row;
    }
}

// Lấy thông số từ cài đặt
$banner_subtitle = get_setting('banner_subtitle', 'Dễ dàng - Nhanh chóng - Tiện lợi');
$banner_img = get_setting('banner_image', 'assets/img/banner.jpg');
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <?php include 'includes/head.php'; ?>
</head>
<body>
    <!-- Header -->
    <?php include 'includes/header.php'; ?>


    <!-- Banner Section -->
<section class="home" style="
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: url('https://preview.colorlib.com/theme/medex/images/bg_2.jpg.webp') no-repeat;
    background-size: cover;
    background-position: center;
    position: relative;
">
  <div style="
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(30, 131, 255, 0.5); /* Blue with 50% opacity */
    z-index: 0;
  "></div>
  <div style="max-width: 700px; text-align: center; color: white; position: relative; z-index: 1;">
    <h1 style="font-size: 64px; font-weight: bold; margin: 0; color: white;">
      NHA KHOA T&A<br>THẨM MỸ RĂNG SỨ
    </h1>
    <p style="margin: 24px 0; font-size: 20px; color: white;">
      Nụ cười tươi sáng không chỉ đẹp mà còn là sức khỏe. Chúng tôi luôn bên bạn trên hành trình bảo vệ sức khỏe răng miệng.
    </p>
    <a href="datlich.php" style="
      background-color:rgb(22, 174, 244);
      color: white;
      padding: 16px 32px;
      font-size: 18px;
      text-decoration: none;
      border-radius: 6px;
      display: inline-block;
      margin-top: 10px;
      font-weight: bold
    ">
      Đặt Lịch Ngay
    </a>
  </div>
</section>


    <!-- Featured Specialties -->
    <section class="specialties">
        <div class="container">
            <h2 class="section-title">Các dịch vụ nổi bật</h2>
            <div class="row">
                <?php if (empty($specialties)): ?>
                    <div class="col-12 text-center">
                        <p>Chưa có dịch vụ nào được thêm vào hệ thống.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($specialties as $specialty): ?>
                    <div class="col-md-4 mb-4">
                        <div class="specialty-card">
                            <div class="specialty-icon">
                                <?php if (!empty($specialty['icon'])): ?>
                                    <i class="fas <?php echo $specialty['icon']; ?>"></i>
                                <?php else: ?>
                                    <i class="fas fa-stethoscope"></i>
                                <?php endif; ?>
                            </div>
                            <h3><?php echo htmlspecialchars($specialty['ten_chuyenkhoa']); ?></h3>
                            <p><?php echo !empty($specialty['mota']) ? htmlspecialchars(substr($specialty['mota'], 0, 100)) . '...' : 'Chuyên khoa y tế chất lượng cao'; ?></p>
                            <a href="chuyenkhoa_chitiet.php?id=<?php echo $specialty['id']; ?>" class="btn btn-outline-primary">Xem chi tiết</a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="text-center mt-4">
                <a href="chuyenkhoa.php" class="btn btn-primary">Xem tất cả các dịch vụ</a>
            </div>
        </div>
    </section>

    <!-- Featured Doctors -->
    <section class="featured-doctors">
        <div class="container">
            <h2 class="section-title">Bác sĩ nổi bật</h2>
            <div class="row">
                <?php if (empty($doctors)): ?>
                    <div class="col-12 text-center">
                        <p>Chưa có bác sĩ nào được thêm vào hệ thống.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($doctors as $doctor): ?>
                    <div class="col-md-3 mb-4">
                        <div class="doctor-card">
                            <div class="doctor-image">
                                <?php if (!empty($doctor['hinh_anh'])): ?>
                                    <img src="<?php echo htmlspecialchars($doctor['hinh_anh']); ?>" alt="<?php echo htmlspecialchars($doctor['ho_ten']); ?>" class="img-fluid">
                                <?php else: ?>
                                    <img src="assets/img/bacsi/default-doctor.png" alt="Default Doctor Image" class="img-fluid">
                                <?php endif; ?>
                            </div>
                            <h3><?php echo htmlspecialchars($doctor['ho_ten']); ?></h3>
                            <p>Chuyên khoa: <?php echo htmlspecialchars($doctor['ten_chuyenkhoa']); ?></p>
                            <a href="chitiet_bacsi.php?id=<?php echo $doctor['id']; ?>" class="btn btn-outline-primary">Xem chi tiết</a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Tin Tức -->
    <section class="health-news">
        <div class="container">
            <h2 class="section-title">Tin tức sức khỏe</h2>
            <div class="row">
                <?php if (empty($news_items)): ?>
                    <div class="col-12 text-center">
                        <p>Chưa có tin tức nào được đăng.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($news_items as $news): ?>
                    <div class="col-md-4 mb-4">
                        <div class="news-card">
                            <?php if (!empty($news['hinh_anh'])): ?>
                                <img src="<?php echo htmlspecialchars($news['hinh_anh']); ?>" alt="<?php echo htmlspecialchars($news['tieu_de']); ?>" class="news-image">
                            <?php else: ?>
                                <img src="assets/img/blog-2.png" alt="Default News Image" class="news-image">
                            <?php endif; ?>
                            <div class="news-content">
                                <div class="news-date">
                                    <i class="far fa-calendar-alt"></i> <?php echo date('d/m/Y', strtotime($news['ngay_dang'])); ?>
                                </div>
                                <h3><?php echo htmlspecialchars($news['tieu_de']); ?></h3>
                                <?php 
                                    // Tạo mô tả ngắn từ nội dung
                                    $excerpt = strip_tags($news['noi_dung']);
                                    $excerpt = substr($excerpt, 0, 150) . '...';
                                ?>
                                <p><?php echo $excerpt; ?></p>
                                <a href="chitiet_tintuc.php?id=<?php echo $news['id']; ?>" class="read-more">Đọc thêm <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="text-center mt-4">
                <a href="tintuc.php" class="btn btn-primary">Xem tất cả tin tức</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>
    <?php include 'includes/chat.php'; ?>


    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>
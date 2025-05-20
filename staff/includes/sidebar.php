<?php
// Lấy tên file đang chạy
$current_page = basename($_SERVER['SCRIPT_NAME']);
?>
<!-- Sidebar -->
<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?php echo $current_page == 'index.php' ? 'active' : ''; ?>" href="index.php">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    Trang tổng quan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $current_page == 'lichhen.php' ? 'active' : ''; ?>" href="lichhen.php">
                    <i class="fas fa-calendar-alt me-2"></i>
                    Quản lý lịch hẹn
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $current_page == 'profile.php' ? 'active' : ''; ?>" href="profile.php">
                    <i class="fas fa-user-circle me-2"></i>
                    Hồ sơ cá nhân
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">
                    <i class="fas fa-sign-out-alt me-2"></i>
                    Đăng xuất
                </a>
            </li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span>Truy cập nhanh</span>
        </h6>
        <ul class="nav flex-column mb-2">
            <li class="nav-item">
                <a class="nav-link" href="../index.php" target="_blank">
                    <i class="fas fa-home me-2"></i>
                    Trang chủ
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../contact.php" target="_blank">
                    <i class="fas fa-phone-alt me-2"></i>
                    Liên hệ
                </a>
            </li>
        </ul>
    </div>
</nav>
<style>
    .sidebar {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        z-index: 100;
        box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
        overflow-y: auto;
    }
    .sidebar .nav-link {
        font-weight: 500;
        color: #333;
        padding: 0.75rem 1rem;
        border-left: 3px solid transparent;
    }
    .sidebar .nav-link:hover {
        background-color: #f8f9fa;
        border-left: 3px solid #ddd;
    }
    .sidebar .nav-link.active {
        color: #0d6efd;
        border-left: 3px solid #0d6efd;
    }
    .sidebar .nav-link i {
        width: 20px;
        text-align: center;
    }
    .main-content {
        margin-left: 16.666667%;
        padding-top: 20px;
    }
    @media (max-width: 767.98px) {
        .sidebar {
            position: static;
            width: 100%;
            height: auto;
            box-shadow: none;
        }
        .main-content {
            margin-left: 0;
        }
    }
</style>

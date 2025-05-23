<?php
// Kiểm tra quyền truy cập
require_once 'includes/auth_check.php';

// Kết nối đến cơ sở dữ liệu
require_once 'includes/db_connect.php';

// Xử lý khi form được submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'save_settings') {
        foreach ($_POST as $key => $value) {
            if ($key !== 'action') {
                // Cập nhật giá trị trong cơ sở dữ liệu
                $stmt = $conn->prepare("UPDATE caidat_website SET ten_value = ? WHERE ten_key = ?");
                $stmt->bind_param("ss", $value, $key);
                $stmt->execute();
            }
        }

        // Xử lý tải lên logo
        if (isset($_FILES['site_logo']) && $_FILES['site_logo']['error'] === UPLOAD_ERR_OK) {
            $target_dir = "../assets/img/";
            
            // Kiểm tra và tạo thư mục nếu không tồn tại
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0755, true);
            }
            
            $file_extension = pathinfo($_FILES['site_logo']['name'], PATHINFO_EXTENSION);
            $new_filename = "logo." . $file_extension;
            $target_file = $target_dir . $new_filename;
            
            // Tải lên tệp
            if (move_uploaded_file($_FILES['site_logo']['tmp_name'], $target_file)) {
                $logo_path = "assets/img/" . $new_filename;
                $stmt = $conn->prepare("UPDATE caidat_website SET ten_value = ? WHERE ten_key = 'site_logo'");
                $stmt->bind_param("s", $logo_path);
                $stmt->execute();
            }
        }
        
        // Xử lý tải lên favicon
        if (isset($_FILES['site_favicon']) && $_FILES['site_favicon']['error'] === UPLOAD_ERR_OK) {
            $target_dir = "../assets/img/";
            
            // Kiểm tra và tạo thư mục nếu không tồn tại
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0755, true);
            }
            
            $file_extension = pathinfo($_FILES['site_favicon']['name'], PATHINFO_EXTENSION);
            $new_filename = "favicon." . $file_extension;
            $target_file = $target_dir . $new_filename;
            
            // Tải lên tệp
            if (move_uploaded_file($_FILES['site_favicon']['tmp_name'], $target_file)) {
                $favicon_path = "assets/img/" . $new_filename;
                $stmt = $conn->prepare("UPDATE caidat_website SET ten_value = ? WHERE ten_key = 'site_favicon'");
                $stmt->bind_param("s", $favicon_path);
                $stmt->execute();
            }
        }
        
        // Làm mới cache cài đặt
        clearSettingsCache();
        
        // Thông báo thành công
        $success_message = "Lưu cài đặt thành công!";
    } elseif (isset($_POST['action']) && $_POST['action'] === 'sync_settings') {
        // Đồng bộ cài đặt
        if (syncSettings()) {
            $success_message = "Đồng bộ cài đặt thành công!";
        } else {
            $error_message = "Có lỗi xảy ra khi đồng bộ cài đặt.";
        }
    }
}

/**
 * Xóa cache cài đặt để đảm bảo lấy dữ liệu mới
 */
function clearSettingsCache() {
    // Ghi vào file cache thời gian cập nhật mới nhất
    $cache_file = "../includes/settings_cache.php";
    $cache_content = "<?php\n";
    $cache_content .= "// Thời gian cập nhật cài đặt mới nhất\n";
    $cache_content .= "\$settings_last_updated = ".time().";\n";
    $cache_content .= "?>";
    
    file_put_contents($cache_file, $cache_content);
}

/**
 * Đồng bộ cài đặt trên toàn hệ thống
 */
function syncSettings() {
    global $conn;
    try {
        // 1. Tạo file cache lưu các cài đặt phổ biến
        $settings_query = "SELECT ten_key, ten_value FROM caidat_website";
        $settings_result = $conn->query($settings_query);
        
        if (!$settings_result) {
            return false;
        }
        
        $settings = [];
        while ($row = $settings_result->fetch_assoc()) {
            $settings[$row['ten_key']] = $row['ten_value'];
        }
        
        // 2. Tạo file cài đặt để sử dụng
        $settings_file = "../includes/settings_data.php";
        
        $file_content = "<?php\n";
        $file_content .= "// File được sinh tự động từ phần cài đặt hệ thống\n";
        $file_content .= "// Cập nhật lần cuối: " . date("Y-m-d H:i:s") . "\n\n";
        $file_content .= "\$settings_data = [\n";
        
        foreach ($settings as $key => $value) {
            // Xử lý các giá trị đặc biệt
            if (is_numeric($value)) {
                $file_content .= "    '{$key}' => {$value},\n";
            } else {
                $file_content .= "    '{$key}' => '".addslashes($value)."',\n";
            }
        }
        
        $file_content .= "];\n?>";
        
        file_put_contents($settings_file, $file_content);
        
        // 3. Cập nhật phiên bản cài đặt
        $version_file = "../includes/settings_version.php";
        $version_content = "<?php\n";
        $version_content .= "/**\n";
        $version_content .= " * File quản lý phiên bản cài đặt để đảm bảo đồng bộ trên toàn hệ thống\n";
        $version_content .= " * File này được tự động cập nhật khi cài đặt thay đổi\n";
        $version_content .= " */\n\n";
        $version_content .= "// Phiên bản cài đặt hiện tại\n";
        $version_content .= "\$settings_version = " . time() . ";\n\n";
        $version_content .= "// Thời gian cập nhật cuối cùng\n";
        $version_content .= "\$settings_last_updated = '" . date('Y-m-d H:i:s') . "';\n";
        $version_content .= "?>";
        
        file_put_contents($version_file, $version_content);
        
        // 4. Xóa file cache để đảm bảo lấy dữ liệu mới
        clearSettingsCache();
        
        return true;
    } catch (Exception $e) {
        error_log("Lỗi đồng bộ cài đặt: " . $e->getMessage());
        return false;
    }
}

// Lấy tất cả các cài đặt từ cơ sở dữ liệu
$settings = [];
$result = $conn->query("SELECT * FROM caidat_website ORDER BY nhom, thu_tu");

while ($row = $result->fetch_assoc()) {
    $group = $row['nhom'];
    if (!isset($settings[$group])) {
        $settings[$group] = [];
    }
    $settings[$group][] = $row;
}

// Lấy danh sách các nhóm
$groups = [
    'general' => 'Cài đặt chung',
    'contact' => 'Thông tin liên hệ',
    'social' => 'Mạng xã hội',
    'appearance' => 'Giao diện',
    'feature' => 'Tính năng'
];

?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cài đặt Website - Nha Khoa T&A</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="asset/admin.css">
    <style>
        .settings-container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        
        .tab-pane {
            padding: 20px 0;
        }
        
        .setting-group {
            margin-bottom: 30px;
        }
        
        .setting-item {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        
        .setting-item:last-child {
            border-bottom: none;
        }
        
        .form-label {
            font-weight: 600;
        }
        
        .form-text {
            font-size: 0.85rem;
        }
        
        .nav-pills .nav-link {
            color: #333;
        }
        
        .nav-pills .nav-link.active {
            background-color: #0d6efd;
            color: white;
        }
        
        .image-preview {
            max-width: 150px;
            max-height: 150px;
            margin-top: 10px;
        }
        
        .color-preview {
            display: inline-block;
            width: 30px;
            height: 30px;
            border-radius: 5px;
            margin-left: 10px;
            border: 1px solid #ddd;
            vertical-align: middle;
        }
        
        .banner-settings-section {
            border-top: 1px solid #eee;
            margin-top: 20px;
            padding-top: 20px;
        }
        
        .banner-settings-title {
            font-weight: 600;
            margin-bottom: 15px;
        }
        
        .overlay-preview {
            width: 100%;
            height: 80px;
            margin-top: 10px;
            background-image: url('../assets/img/sample-bg.jpg');
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include 'includes/sidebar.php'; ?>

            <!-- Main Content -->
            <div class="col-md-12 main-content  mt-5 ">
            <div class="content-wrapper">

                <div class="content-header d-flex justify-content-between align-items-center ">
                    <h2 class="page-title">Cài đặt Website</h2>
                </div>

                <?php if (isset($success_message)): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo $success_message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php elseif (isset($error_message)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $error_message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="settings-container">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="save_settings">
                        
                        <!-- Nav tabs -->
                        <ul class="nav nav-pills mb-4" id="settingsTabs" role="tablist">
                            <?php $active = true; foreach($groups as $key => $name): ?>
                                <?php if(isset($settings[$key])): ?>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link <?php echo $active ? 'active' : ''; ?>" 
                                                id="<?php echo $key; ?>-tab" 
                                                data-bs-toggle="pill" 
                                                data-bs-target="#<?php echo $key; ?>" 
                                                type="button" 
                                                role="tab"
                                                aria-controls="<?php echo $key; ?>" 
                                                aria-selected="<?php echo $active ? 'true' : 'false'; ?>">
                                            <?php echo $name; ?>
                                        </button>
                                    </li>
                                    <?php $active = false; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            
                            <!-- Thêm tab Email vào menu (không thêm bằng JavaScript) -->
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="email-settings-tab" data-bs-toggle="pill" 
                                        data-bs-target="#email-settings" type="button" role="tab" 
                                        aria-controls="email-settings" aria-selected="false">
                                    <i class="fas fa-envelope me-1"></i> Email
                                </button>
                            </li>
                        </ul>

                        <!-- Tab content -->
                        <div class="tab-content" id="settingsTabContent">
                            <?php $active = true; foreach($groups as $group_key => $group_name): ?>
                                <?php if(isset($settings[$group_key])): ?>
                                    <div class="tab-pane fade <?php echo $active ? 'show active' : ''; ?>" 
                                         id="<?php echo $group_key; ?>" 
                                         role="tabpanel" 
                                         aria-labelledby="<?php echo $group_key; ?>-tab">
                                        
                                        <div class="setting-group">
                                            <?php foreach($settings[$group_key] as $setting): ?>
                                                <div class="setting-item">
                                                    <?php if($setting['loai'] === 'text'): ?>
                                                        <div class="mb-3">
                                                            <label for="<?php echo $setting['ten_key']; ?>" class="form-label">
                                                                <?php echo $setting['mo_ta']; ?>
                                                            </label>
                                                            <input type="text" 
                                                                   class="form-control" 
                                                                   id="<?php echo $setting['ten_key']; ?>" 
                                                                   name="<?php echo $setting['ten_key']; ?>"
                                                                   value="<?php echo htmlspecialchars($setting['ten_value']); ?>">
                                                        </div>
                                                    <?php elseif($setting['loai'] === 'textarea'): ?>
                                                        <div class="mb-3">
                                                            <label for="<?php echo $setting['ten_key']; ?>" class="form-label">
                                                                <?php echo $setting['mo_ta']; ?>
                                                            </label>
                                                            <textarea class="form-control" 
                                                                      id="<?php echo $setting['ten_key']; ?>" 
                                                                      name="<?php echo $setting['ten_key']; ?>" 
                                                                      rows="3"><?php echo htmlspecialchars($setting['ten_value']); ?></textarea>
                                                        </div>
                                                    <?php elseif($setting['loai'] === 'image'): ?>
                                                        <div class="mb-3">
                                                            <label for="<?php echo $setting['ten_key']; ?>" class="form-label">
                                                                <?php echo $setting['mo_ta']; ?>
                                                            </label>
                                                            <input type="file" 
                                                                   class="form-control" 
                                                                   id="<?php echo $setting['ten_key']; ?>" 
                                                                   name="<?php echo $setting['ten_key']; ?>"
                                                                   accept="image/*">
                                                            <div class="form-text">Để trống nếu không muốn thay đổi</div>
                                                            
                                                            <?php if (!empty($setting['ten_value'])): ?>
                                                                <div class="mt-2">
                                                                    <p>Hiện tại:</p>
                                                                    <img src="../<?php echo $setting['ten_value']; ?>" 
                                                                         alt="<?php echo $setting['mo_ta']; ?>" 
                                                                         class="image-preview">
                                                                    <input type="hidden" 
                                                                           name="<?php echo $setting['ten_key']; ?>_current" 
                                                                           value="<?php echo htmlspecialchars($setting['ten_value']); ?>">
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    <?php elseif($setting['loai'] === 'boolean'): ?>
                                                        <div class="mb-3 form-check form-switch">
                                                            <input type="checkbox" 
                                                                   class="form-check-input" 
                                                                   id="<?php echo $setting['ten_key']; ?>" 
                                                                   name="<?php echo $setting['ten_key']; ?>"
                                                                   value="1"
                                                                   <?php echo $setting['ten_value'] == '1' ? 'checked' : ''; ?>>
                                                            <label class="form-check-label" for="<?php echo $setting['ten_key']; ?>">
                                                                <?php echo $setting['mo_ta']; ?>
                                                            </label>
                                                        </div>
                                                    <?php elseif($setting['loai'] === 'number'): ?>
                                                        <div class="mb-3">
                                                            <label for="<?php echo $setting['ten_key']; ?>" class="form-label">
                                                                <?php echo $setting['mo_ta']; ?>
                                                            </label>
                                                            <input type="number" 
                                                                   class="form-control" 
                                                                   id="<?php echo $setting['ten_key']; ?>" 
                                                                   name="<?php echo $setting['ten_key']; ?>"
                                                                   value="<?php echo htmlspecialchars($setting['ten_value']); ?>">
                                                        </div>
                                                    <?php elseif($setting['loai'] === 'color'): ?>
                                                        <div class="mb-3">
                                                            <label for="<?php echo $setting['ten_key']; ?>" class="form-label">
                                                                <?php echo $setting['mo_ta']; ?>
                                                            </label>
                                                            <div class="input-group">
                                                                <input type="color" 
                                                                       class="form-control form-control-color" 
                                                                       id="<?php echo $setting['ten_key']; ?>" 
                                                                       name="<?php echo $setting['ten_key']; ?>"
                                                                       value="<?php echo htmlspecialchars($setting['ten_value']); ?>">
                                                                <input type="text" 
                                                                       class="form-control" 
                                                                       value="<?php echo htmlspecialchars($setting['ten_value']); ?>"
                                                                       onchange="document.getElementById('<?php echo $setting['ten_key']; ?>').value = this.value">
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endforeach; ?>
                                            
                                            <?php if($group_key === 'appearance'): ?>
                                                <!-- Banner Settings Section -->
                                                <div class="banner-settings-section">
                                                    <h4 class="banner-settings-title">Cài đặt Banner Trang</h4>
                                                    
                                                    <!-- Banner Background Image -->
                                                    <div class="setting-item">
                                                        <div class="mb-3">
                                                            <label for="page_banner_bg" class="form-label">Hình nền Banner</label>
                                                            <input type="file" 
                                                                   class="form-control" 
                                                                   id="page_banner_bg" 
                                                                   name="page_banner_bg"
                                                                   accept="image/*">
                                                            <div class="form-text">Ảnh nền được sử dụng cho banner đầu các trang</div>
                                                            
                                                            <?php 
                                                            $banner_bg_query = $conn->query("SELECT ten_value FROM caidat_website WHERE ten_key = 'page_banner_bg'");
                                                            $banner_bg = $banner_bg_query->fetch_assoc()['ten_value'] ?? '';
                                                            if (!empty($banner_bg)): 
                                                            ?>
                                                                <div class="mt-2">
                                                                    <p>Hiện tại:</p>
                                                                    <img src="../<?php echo $banner_bg; ?>" 
                                                                         alt="Banner Background" 
                                                                         class="image-preview">
                                                                    <input type="hidden" 
                                                                           name="page_banner_bg_current" 
                                                                           value="<?php echo htmlspecialchars($banner_bg); ?>">
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Banner Overlay Color -->
                                                    <div class="setting-item">
                                                        <div class="mb-3">
                                                            <label for="page_banner_overlay" class="form-label">Màu overlay Banner</label>
                                                            <input type="text" 
                                                                   class="form-control" 
                                                                   id="page_banner_overlay" 
                                                                   name="page_banner_overlay"
                                                                   value="<?php 
                                                                    $overlay_query = $conn->query("SELECT ten_value FROM caidat_website WHERE ten_key = 'page_banner_overlay'");
                                                                    echo htmlspecialchars($overlay_query->fetch_assoc()['ten_value'] ?? 'rgba(0, 0, 0, 0.6)');
                                                                   ?>"
                                                                   placeholder="rgba(0, 0, 0, 0.6)">
                                                            <div class="form-text">Định dạng RGBA với độ trong suốt (VD: rgba(0, 0, 0, 0.6))</div>
                                                            <div class="overlay-preview" id="overlay_preview">Xem trước lớp phủ</div>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Banner Height -->
                                                    <div class="setting-item">
                                                        <div class="mb-3">
                                                            <label for="page_banner_height" class="form-label">Chiều cao Banner</label>
                                                            <input type="text" 
                                                                   class="form-control" 
                                                                   id="page_banner_height" 
                                                                   name="page_banner_height"
                                                                   value="<?php 
                                                                    $height_query = $conn->query("SELECT ten_value FROM caidat_website WHERE ten_key = 'page_banner_height'");
                                                                    echo htmlspecialchars($height_query->fetch_assoc()['ten_value'] ?? '200px');
                                                                   ?>"
                                                                   placeholder="200px">
                                                            <div class="form-text">Chiều cao của banner (VD: 200px, 15rem, 30vh)</div>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Banner Padding -->
                                                    <div class="setting-item">
                                                        <div class="mb-3">
                                                            <label for="page_banner_padding" class="form-label">Padding Banner</label>
                                                            <input type="text" 
                                                                   class="form-control" 
                                                                   id="page_banner_padding" 
                                                                   name="page_banner_padding"
                                                                   value="<?php 
                                                                    $padding_query = $conn->query("SELECT ten_value FROM caidat_website WHERE ten_key = 'page_banner_padding'");
                                                                    echo htmlspecialchars($padding_query->fetch_assoc()['ten_value'] ?? '50px 0');
                                                                   ?>"
                                                                   placeholder="50px 0">
                                                            <div class="form-text">Khoảng cách đệm trong banner (VD: 50px 0, 2rem 1rem)</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php $active = false; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>

                            <!-- Tab Email Settings -->
                            <div class="tab-pane fade" id="email-settings" role="tabpanel" aria-labelledby="email-settings-tab">
                                <div class="card border-0 shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Cấu hình Email</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <div class="alert alert-info">
                                                <i class="fas fa-info-circle me-2"></i> Cấu hình SMTP để gửi email thông báo cho bệnh nhân
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="smtp_host" class="form-label">SMTP Host</label>
                                                    <input type="text" class="form-control" id="smtp_host" name="smtp_host" value="<?php echo get_setting('smtp_host', ''); ?>" placeholder="smtp.gmail.com">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="smtp_port" class="form-label">SMTP Port</label>
                                                    <input type="text" class="form-control" id="smtp_port" name="smtp_port" value="<?php echo get_setting('smtp_port', '587'); ?>" placeholder="587">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="smtp_username" class="form-label">SMTP Username</label>
                                                    <input type="text" class="form-control" id="smtp_username" name="smtp_username" value="<?php echo get_setting('smtp_username', ''); ?>" placeholder="your-email@gmail.com">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="smtp_password" class="form-label">SMTP Password</label>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control" id="smtp_password" name="smtp_password" value="<?php echo get_setting('smtp_password', ''); ?>" placeholder="Mật khẩu hoặc mã ứng dụng">
                                                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="smtp_password">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                    <small class="form-text text-muted">Với Gmail, bạn cần sử dụng <a href="https://support.google.com/accounts/answer/185833" target="_blank">mã ứng dụng</a></small>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="smtp_secure" class="form-label">Phương thức bảo mật</label>
                                                    <select class="form-select" id="smtp_secure" name="smtp_secure">
                                                        <option value="tls" <?php echo get_setting('smtp_secure', 'tls') == 'tls' ? 'selected' : ''; ?>>TLS</option>
                                                        <option value="ssl" <?php echo get_setting('smtp_secure', 'tls') == 'ssl' ? 'selected' : ''; ?>>SSL</option>
                                                        <option value="none" <?php echo get_setting('smtp_secure', 'tls') == 'none' ? 'selected' : ''; ?>>Không có</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="site_email" class="form-label">Email hệ thống</label>
                                                    <input type="email" class="form-control" id="site_email" name="site_email" value="<?php echo get_setting('site_email', ''); ?>" placeholder="no-reply@yourdomain.com">
                                                    <small class="form-text text-muted">Email hiển thị khi gửi thông báo cho người dùng</small>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-3">
                                            <button type="button" class="btn btn-info" id="test-email-btn">
                                                <i class="fas fa-paper-plane me-1"></i> Gửi email kiểm tra
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> Lưu cài đặt
                            </button>
                        </div>
                    </form>

                    <form action="" method="POST" class="mt-4">
                        <input type="hidden" name="action" value="sync_settings">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-secondary">
                                <i class="fas fa-sync me-2"></i> Đồng bộ cài đặt
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>
    </div>

    <!-- Modal kiểm tra email -->
    <div class="modal fade" id="testEmailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Gửi email kiểm tra</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="test-email-form">
                        <div class="mb-3">
                            <label for="test_email" class="form-label">Địa chỉ email nhận</label>
                            <input type="email" class="form-control" id="test_email" name="test_email" required>
                        </div>
                        <div class="mb-3">
                            <label for="test_subject" class="form-label">Tiêu đề</label>
                            <input type="text" class="form-control" id="test_subject" name="test_subject" value="Kiểm tra cấu hình email">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="send-test-email-btn">Gửi</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Xử lý xem trước hình ảnh khi chọn file
            const imageInputs = document.querySelectorAll('input[type="file"]');
            
            imageInputs.forEach(input => {
                input.addEventListener('change', function() {
                    if (this.files && this.files[0]) {
                        const img = this.parentElement.querySelector('.image-preview');
                        if (img) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                img.src = e.target.result;
                            }
                            reader.readAsDataURL(this.files[0]);
                        } else {
                            const newImg = document.createElement('img');
                            newImg.classList.add('image-preview');
                            
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                newImg.src = e.target.result;
                            }
                            reader.readAsDataURL(this.files[0]);
                            
                            this.parentElement.appendChild(document.createElement('p')).innerText = 'Xem trước:';
                            this.parentElement.appendChild(newImg);
                        }
                    }
                });
            });

            // Banner overlay preview
            const overlayInput = document.getElementById('page_banner_overlay');
            const overlayPreview = document.getElementById('overlay_preview');
            
            if (overlayInput && overlayPreview) {
                // Initial preview
                overlayPreview.style.backgroundColor = overlayInput.value;
                
                // Update on change
                overlayInput.addEventListener('input', function() {
                    overlayPreview.style.backgroundColor = this.value;
                });
            }

            // Toggle password visibility
            const togglePasswordButtons = document.querySelectorAll('.toggle-password');
            togglePasswordButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const passwordInput = document.getElementById(targetId);
                    
                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        this.querySelector('i').classList.remove('fa-eye');
                        this.querySelector('i').classList.add('fa-eye-slash');
                    } else {
                        passwordInput.type = 'password';
                        this.querySelector('i').classList.remove('fa-eye-slash');
                        this.querySelector('i').classList.add('fa-eye');
                    }
                });
            });
            
            // Xử lý nút gửi email kiểm tra
            const testEmailBtn = document.getElementById('test-email-btn');
            if (testEmailBtn) {
                testEmailBtn.addEventListener('click', function() {
                    // Lấy giá trị cấu hình hiện tại từ form
                    const smtpHost = document.getElementById('smtp_host').value;
                    const smtpPort = document.getElementById('smtp_port').value;
                    const smtpUsername = document.getElementById('smtp_username').value;
                    const smtpPassword = document.getElementById('smtp_password').value;
                    
                    // Kiểm tra cấu hình SMTP có đầy đủ không
                    if (!smtpHost || !smtpPort || !smtpUsername || !smtpPassword) {
                        alert('Vui lòng nhập đầy đủ thông tin cấu hình SMTP trước khi kiểm tra.');
                        return;
                    }
                    
                    // Hiển thị modal
                    const testEmailModal = new bootstrap.Modal(document.getElementById('testEmailModal'));
                    testEmailModal.show();
                    
                    // Xử lý nút gửi trong modal
                    const sendTestEmailBtn = document.getElementById('send-test-email-btn');
                    sendTestEmailBtn.onclick = function() {
                        const testEmail = document.getElementById('test_email').value;
                        const testSubject = document.getElementById('test_subject').value;
                        
                        if (!testEmail) {
                            alert('Vui lòng nhập địa chỉ email nhận.');
                            return;
                        }
                        
                        // Hiển thị trạng thái đang gửi
                        sendTestEmailBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Đang gửi...';
                        sendTestEmailBtn.disabled = true;
                        
                        // Gửi request AJAX
                        fetch('ajax/test_email.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                email: testEmail,
                                subject: testSubject
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            // Đóng modal
                            testEmailModal.hide();
                            
                            // Hiển thị thông báo
                            if (data.success) {
                                alert(data.message);
                            } else {
                                alert('Lỗi: ' + data.message);
                            }
                            
                            // Khôi phục trạng thái nút
                            sendTestEmailBtn.innerHTML = 'Gửi';
                            sendTestEmailBtn.disabled = false;
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Đã xảy ra lỗi khi gửi email kiểm tra. Vui lòng thử lại sau.');
                            
                            // Khôi phục trạng thái nút
                            sendTestEmailBtn.innerHTML = 'Gửi';
                            sendTestEmailBtn.disabled = false;
                            
                            // Đóng modal
                            testEmailModal.hide();
                        });
                    };
                });
            }
        });
    </script>
</body>
</html>

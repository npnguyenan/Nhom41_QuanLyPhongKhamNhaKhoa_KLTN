-- SQL to update the database schema to add "nhanvien" (staff) role
-- First, alter the nguoidung table to include 'nhanvien' in the vai_tro enum
ALTER TABLE nguoidung 
MODIFY COLUMN vai_tro ENUM('admin', 'bacsi', 'benhnhan', 'nhanvien') NOT NULL;

-- Create staff (nhanvien) table
CREATE TABLE IF NOT EXISTS nhanvien (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nguoidung_id INT UNIQUE,
    ho_ten VARCHAR(100) NOT NULL,
    dien_thoai VARCHAR(20),
    email VARCHAR(100),
    dia_chi TEXT,
    hinh_anh VARCHAR(255),
    ngay_tao DATETIME DEFAULT CURRENT_TIMESTAMP,
    ngay_capnhat DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (nguoidung_id) REFERENCES nguoidung(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert demo staff account (password: staff123)
INSERT INTO nguoidung (email, mat_khau, vai_tro) 
VALUES ('staff@example.com', '$2y$10$0msDAdfhxMPMG/fejZgQg.Tl1fqcvMrT4aTgotEIAM2SxrBKbUVmC', 'nhanvien');

-- Get the ID of the newly inserted user
SET @new_user_id = LAST_INSERT_ID();

-- Insert staff info 
INSERT INTO nhanvien (nguoidung_id, ho_ten, dien_thoai, email) 
VALUES (@new_user_id, 'Nhân Viên Demo', '0987654321', 'staff@example.com');

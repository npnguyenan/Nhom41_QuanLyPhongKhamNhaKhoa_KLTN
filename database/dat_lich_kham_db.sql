-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2025 at 08:45 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dat_lich_kham_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bacsi`
--

CREATE TABLE `bacsi` (
  `id` int(11) NOT NULL,
  `nguoidung_id` int(11) DEFAULT NULL,
  `ho_ten` varchar(100) NOT NULL,
  `chuyenkhoa_id` int(11) DEFAULT NULL,
  `nam_sinh` int(11) DEFAULT NULL,
  `gioi_tinh` enum('Nam','Nữ','Khác') DEFAULT 'Nam',
  `dien_thoai` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `dia_chi` text DEFAULT NULL,
  `hinh_anh` varchar(255) DEFAULT NULL,
  `mo_ta` text DEFAULT NULL,
  `bang_cap` text DEFAULT NULL,
  `kinh_nghiem` text DEFAULT NULL,
  `ngay_tao` datetime DEFAULT current_timestamp(),
  `ngay_capnhat` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bacsi`
--

INSERT INTO `bacsi` (`id`, `nguoidung_id`, `ho_ten`, `chuyenkhoa_id`, `nam_sinh`, `gioi_tinh`, `dien_thoai`, `email`, `dia_chi`, `hinh_anh`, `mo_ta`, `bang_cap`, `kinh_nghiem`, `ngay_tao`, `ngay_capnhat`) VALUES
(1, NULL, 'BS. Nguyễn Thế Lâm', 3, 1980, 'Nam', '0987654321', 'bs.lam@example.com', '', 'assets/img/bacsi/1747068459_20jun2024084938gmtupload00000654-1.jpg', '<p data-start=\"637\" data-end=\"714\"><em data-start=\"669\" data-end=\"714\"><span class=\"_fadeIn_m1hgl_8\">Chuyên </span><span class=\"_fadeIn_m1hgl_8\">khoa: </span><span class=\"_fadeIn_m1hgl_8\">Bọc </span><span class=\"_fadeIn_m1hgl_8\">răng </span><span class=\"_fadeIn_m1hgl_8\">sứ – </span><span class=\"_fadeIn_m1hgl_8\">Nha </span><span class=\"_fadeIn_m1hgl_8\">khoa </span><span class=\"_fadeIn_m1hgl_8\">thẩm </span><span class=\"_fadeIn_m1hgl_8\">mỹ</span></em></p><ul data-start=\"716\" data-end=\"1081\">\r\n<li data-start=\"846\" data-end=\"916\">\r\n<p data-start=\"848\" data-end=\"916\"><span class=\"_fadeIn_m1hgl_8\">Đã </span><span class=\"_fadeIn_m1hgl_8\">thực </span><span class=\"_fadeIn_m1hgl_8\">hiện </span><span class=\"_fadeIn_m1hgl_8\">thành </span><span class=\"_fadeIn_m1hgl_8\">công </span><span class=\"_fadeIn_m1hgl_8\">hơn </span><span class=\"_fadeIn_m1hgl_8\">1000 </span><span class=\"_fadeIn_m1hgl_8\">ca </span><span class=\"_fadeIn_m1hgl_8\">bọc </span><span class=\"_fadeIn_m1hgl_8\">răng </span><span class=\"_fadeIn_m1hgl_8\">sứ </span><span class=\"_fadeIn_m1hgl_8\">toàn </span><span class=\"_fadeIn_m1hgl_8\">hàm </span><span class=\"_fadeIn_m1hgl_8\">và </span><span class=\"_fadeIn_m1hgl_8\">đơn </span><span class=\"_fadeIn_m1hgl_8\">lẻ</span></p>\r\n</li>\r\n<li data-start=\"917\" data-end=\"992\">\r\n<p data-start=\"919\" data-end=\"992\"><span class=\"_fadeIn_m1hgl_8\">Thường </span><span class=\"_fadeIn_m1hgl_8\">xuyên </span><span class=\"_fadeIn_m1hgl_8\">tham </span><span class=\"_fadeIn_m1hgl_8\">gia </span><span class=\"_fadeIn_m1hgl_8\">các </span><span class=\"_fadeIn_m1hgl_8\">hội </span><span class=\"_fadeIn_m1hgl_8\">thảo </span><span class=\"_fadeIn_m1hgl_8\">chuyên </span><span class=\"_fadeIn_m1hgl_8\">ngành </span><span class=\"_fadeIn_m1hgl_8\">tại </span><span class=\"_fadeIn_m1hgl_8\">Hàn </span><span class=\"_fadeIn_m1hgl_8\">Quốc, </span><span class=\"_fadeIn_m1hgl_8\">Singapore</span></p>\r\n</li>\r\n<li data-start=\"993\" data-end=\"1081\">\r\n<p data-start=\"995\" data-end=\"1081\"><span class=\"_fadeIn_m1hgl_8\">Phong </span><span class=\"_fadeIn_m1hgl_8\">cách </span><span class=\"_fadeIn_m1hgl_8\">làm </span><span class=\"_fadeIn_m1hgl_8\">việc </span><span class=\"_fadeIn_m1hgl_8\">nhẹ </span><span class=\"_fadeIn_m1hgl_8\">nhàng, </span><span class=\"_fadeIn_m1hgl_8\">tận </span><span class=\"_fadeIn_m1hgl_8\">tâm </span><span class=\"_fadeIn_m1hgl_8\">và </span><span class=\"_fadeIn_m1hgl_8\">luôn </span><span class=\"_fadeIn_m1hgl_8\">đặt </span><span class=\"_fadeIn_m1hgl_8\">trải </span><span class=\"_fadeIn_m1hgl_8\">nghiệm </span><span class=\"_fadeIn_m1hgl_8\">khách </span><span class=\"_fadeIn_m1hgl_8\">hàng </span><span class=\"_fadeIn_m1hgl_8\">lên </span><span class=\"_fadeIn_m1hgl_8\">hàng </span><span class=\"_fadeIn_m1hgl_8\">đầu</span></p></li></ul>', '<ul data-start=\"716\" data-end=\"1081\"><li data-start=\"716\" data-end=\"777\"><p data-start=\"718\" data-end=\"777\"><span class=\"_fadeIn_m1hgl_8\">Tốt&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">nghiệp&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">Bác&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">sĩ&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">Răng –&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">Hàm –&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">Mặt,&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">Đại&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">học&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">Y&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">Dược&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">TP.</span><span class=\"_fadeIn_m1hgl_8\">HCM</span></p></li></ul>', '<div>Trên 8 năm kinh nghiệm trong lĩnh vực phục hình răng sứ thẩm mỹ</div>', '2025-04-24 16:01:21', '2025-05-13 11:30:43'),
(2, NULL, 'BS. Trần Thị Mai', 5, 1985, 'Nữ', '0987654322', 'bs.mai@example.com', '324 lê duẩn', 'assets/img/bacsi/1747068662_1717570573-37632348-ti-n-s-bac-s-tr-n-th-hoang-nga.jpg', '<p data-start=\"1088\" data-end=\"1167\"><em data-start=\"1114\" data-end=\"1167\"><span class=\"_fadeIn_m1hgl_8\">Chuyên </span><span class=\"_fadeIn_m1hgl_8\">khoa: </span><span class=\"_fadeIn_m1hgl_8\">Cấy </span><span class=\"_fadeIn_m1hgl_8\">ghép </span><span class=\"_fadeIn_m1hgl_8\">Implant – </span><span class=\"_fadeIn_m1hgl_8\">Tiểu </span><span class=\"_fadeIn_m1hgl_8\">phẫu </span><span class=\"_fadeIn_m1hgl_8\">răng </span><span class=\"_fadeIn_m1hgl_8\">khôn</span></em></p><ul data-start=\"1169\" data-end=\"1481\">\r\n<li data-start=\"1301\" data-end=\"1343\">\r\n<p data-start=\"1303\" data-end=\"1343\"><span class=\"_fadeIn_m1hgl_8\">Thành </span><span class=\"_fadeIn_m1hgl_8\">thạo </span><span class=\"_fadeIn_m1hgl_8\">kỹ </span><span class=\"_fadeIn_m1hgl_8\">thuật </span><span class=\"_fadeIn_m1hgl_8\">All-</span><span class=\"_fadeIn_m1hgl_8\">on-</span><span class=\"_fadeIn_m1hgl_8\">4, </span><span class=\"_fadeIn_m1hgl_8\">All-</span><span class=\"_fadeIn_m1hgl_8\">on-</span><span class=\"_fadeIn_m1hgl_8\">6</span></p>\r\n</li>\r\n<li data-start=\"1344\" data-end=\"1410\">\r\n<p data-start=\"1346\" data-end=\"1410\"><span class=\"_fadeIn_m1hgl_8\">Đã </span><span class=\"_fadeIn_m1hgl_8\">điều </span><span class=\"_fadeIn_m1hgl_8\">trị </span><span class=\"_fadeIn_m1hgl_8\">hơn </span><span class=\"_fadeIn_m1hgl_8\">5000 </span><span class=\"_fadeIn_m1hgl_8\">ca </span><span class=\"_fadeIn_m1hgl_8\">nhổ </span><span class=\"_fadeIn_m1hgl_8\">răng </span><span class=\"_fadeIn_m1hgl_8\">khôn </span><span class=\"_fadeIn_m1hgl_8\">không </span><span class=\"_fadeIn_m1hgl_8\">đau </span><span class=\"_fadeIn_m1hgl_8\">bằng </span><span class=\"_fadeIn_m1hgl_8\">Piezotome</span></p>\r\n</li>\r\n<li data-start=\"1411\" data-end=\"1481\">\r\n<p data-start=\"1413\" data-end=\"1481\"><span class=\"_fadeIn_m1hgl_8\">Tận </span><span class=\"_fadeIn_m1hgl_8\">tâm, </span><span class=\"_fadeIn_m1hgl_8\">kỹ </span><span class=\"_fadeIn_m1hgl_8\">lưỡng, </span><span class=\"_fadeIn_m1hgl_8\">đề </span><span class=\"_fadeIn_m1hgl_8\">cao </span><span class=\"_fadeIn_m1hgl_8\">an </span><span class=\"_fadeIn_m1hgl_8\">toàn </span><span class=\"_fadeIn_m1hgl_8\">và </span><span class=\"_fadeIn_m1hgl_8\">hiệu </span><span class=\"_fadeIn_m1hgl_8\">quả </span><span class=\"_fadeIn_m1hgl_8\">lâu </span><span class=\"_fadeIn_m1hgl_8\">dài </span><span class=\"_fadeIn_m1hgl_8\">cho </span><span class=\"_fadeIn_m1hgl_8\">khách </span><span class=\"_fadeIn_m1hgl_8\">hàng</span></p></li></ul>', '<span class=\"_fadeIn_m1hgl_8\">Bác </span><span class=\"_fadeIn_m1hgl_8\">sĩ </span><span class=\"_fadeIn_m1hgl_8\">Răng – </span><span class=\"_fadeIn_m1hgl_8\">Hàm – </span><span class=\"_fadeIn_m1hgl_8\">Mặt, </span><span class=\"_fadeIn_m1hgl_8\">Đại </span><span class=\"_fadeIn_m1hgl_8\">học </span><span class=\"_fadeIn_m1hgl_8\">Y </span><span class=\"_fadeIn_m1hgl_8\">Dược </span><span class=\"_fadeIn_m1hgl_8\">TP.</span><span class=\"_fadeIn_m1hgl_8\">HCM</span><br data-start=\"281\" data-end=\"284\">\r\n<span class=\"_fadeIn_m1hgl_8\">Chứng </span><span class=\"_fadeIn_m1hgl_8\">chỉ </span><span class=\"_fadeIn_m1hgl_8\">điều </span><span class=\"_fadeIn_m1hgl_8\">trị </span><span class=\"_fadeIn_m1hgl_8\">nội </span><span class=\"_fadeIn_m1hgl_8\">nha </span><span class=\"_fadeIn_m1hgl_8\">nâng </span><span class=\"_fadeIn_m1hgl_8\">cao </span><span class=\"_fadeIn_m1hgl_8\">tại </span><span class=\"_fadeIn_m1hgl_8\">Viện </span><span class=\"_fadeIn_m1hgl_8\">Đào </span><span class=\"_fadeIn_m1hgl_8\">tạo </span><span class=\"_fadeIn_m1hgl_8\">Nha </span><span class=\"_fadeIn_m1hgl_8\">khoa </span><span class=\"_fadeIn_m1hgl_8\">Pháp – </span><span class=\"_fadeIn_m1hgl_8\">Việt (</span><span class=\"_fadeIn_m1hgl_8\">PFV)</span>', '<div>Hơn 10 năm kinh nghiệm điều trị các ca mất răng phức tạp</div>', '2025-04-24 16:01:21', '2025-05-13 16:42:10'),
(3, NULL, 'BS. Lê Văn Hùng', 4, 1975, 'Nam', '0987654323', 'bs.hung@example.com', '550 lê đức thọ', 'assets/img/bacsi/1747068699_1717571752-1351456842-th-c-s-bac-s-nguy-n-qu-c-t.jpg', '<p data-start=\"1488\" data-end=\"1557\"><em data-start=\"1509\" data-end=\"1557\"><span class=\"_fadeIn_m1hgl_8\">Chuyên </span><span class=\"_fadeIn_m1hgl_8\">khoa: </span><span class=\"_fadeIn_m1hgl_8\">Niềng </span><span class=\"_fadeIn_m1hgl_8\">răng </span><span class=\"_fadeIn_m1hgl_8\">chỉnh </span><span class=\"_fadeIn_m1hgl_8\">nha – </span><span class=\"_fadeIn_m1hgl_8\">Invisalign</span></em></p><ul data-start=\"1559\" data-end=\"1893\">\r\n<li data-start=\"1698\" data-end=\"1760\">\r\n<p data-start=\"1700\" data-end=\"1760\"><span class=\"_fadeIn_m1hgl_8\">Đã </span><span class=\"_fadeIn_m1hgl_8\">điều </span><span class=\"_fadeIn_m1hgl_8\">trị </span><span class=\"_fadeIn_m1hgl_8\">thành </span><span class=\"_fadeIn_m1hgl_8\">công </span><span class=\"_fadeIn_m1hgl_8\">nhiều </span><span class=\"_fadeIn_m1hgl_8\">ca </span><span class=\"_fadeIn_m1hgl_8\">sai </span><span class=\"_fadeIn_m1hgl_8\">lệch </span><span class=\"_fadeIn_m1hgl_8\">khớp </span><span class=\"_fadeIn_m1hgl_8\">cắn </span><span class=\"_fadeIn_m1hgl_8\">phức </span><span class=\"_fadeIn_m1hgl_8\">tạp</span></p>\r\n</li>\r\n<li data-start=\"1761\" data-end=\"1818\">\r\n<p data-start=\"1763\" data-end=\"1818\"><span class=\"_fadeIn_m1hgl_8\">Tư </span><span class=\"_fadeIn_m1hgl_8\">vấn </span><span class=\"_fadeIn_m1hgl_8\">tận </span><span class=\"_fadeIn_m1hgl_8\">tình, </span><span class=\"_fadeIn_m1hgl_8\">sát </span><span class=\"_fadeIn_m1hgl_8\">sao </span><span class=\"_fadeIn_m1hgl_8\">theo </span><span class=\"_fadeIn_m1hgl_8\">từng </span><span class=\"_fadeIn_m1hgl_8\">giai </span><span class=\"_fadeIn_m1hgl_8\">đoạn </span><span class=\"_fadeIn_m1hgl_8\">điều </span><span class=\"_fadeIn_m1hgl_8\">trị</span></p>\r\n</li>\r\n<li data-start=\"1819\" data-end=\"1893\">\r\n<p data-start=\"1821\" data-end=\"1893\"><span class=\"_fadeIn_m1hgl_8\">Khách </span><span class=\"_fadeIn_m1hgl_8\">hàng </span><span class=\"_fadeIn_m1hgl_8\">đánh </span><span class=\"_fadeIn_m1hgl_8\">giá </span><span class=\"_fadeIn_m1hgl_8\">cao </span><span class=\"_fadeIn_m1hgl_8\">sự </span><span class=\"_fadeIn_m1hgl_8\">chuyên </span><span class=\"_fadeIn_m1hgl_8\">nghiệp, </span><span class=\"_fadeIn_m1hgl_8\">thân </span><span class=\"_fadeIn_m1hgl_8\">thiện </span><span class=\"_fadeIn_m1hgl_8\">và </span><span class=\"_fadeIn_m1hgl_8\">chăm </span><span class=\"_fadeIn_m1hgl_8\">sóc </span><span class=\"_fadeIn_m1hgl_8\">chu </span><span class=\"_fadeIn_m1hgl_8\">đáo</span></p></li></ul>', '<ul data-start=\"1559\" data-end=\"1893\"><li data-start=\"1559\" data-end=\"1625\"><p data-start=\"1561\" data-end=\"1625\"><span class=\"_fadeIn_m1hgl_8\">Chuyên&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">gia&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">niềng&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">răng&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">trong&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">suốt&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">Invisalign&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">Certified&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">Provider</span></p></li></ul>', '<p>Hơn 7 năm kinh nghiệm điều trị chỉnh nha bằng mắc cài và khay trong</p>', '2025-04-24 16:01:21', '2025-05-13 11:31:35'),
(4, NULL, 'BS. Phạm Thị Hoa', 1, 1982, 'Nữ', '0987654324', 'bs.hoa@example.com', '220 nguyễn oanh', 'assets/img/bacsi/1747068680_1727240112-47870822-pho-giao-s-ti-n-s-bac-s-le-th-ong-ph-ng.jpg', '<p data-start=\"206\" data-end=\"267\"><em data-start=\"206\" data-end=\"267\"><span class=\"_fadeIn_m1hgl_8\">Chuyên </span><span class=\"_fadeIn_m1hgl_8\">khoa: </span><span class=\"_fadeIn_m1hgl_8\">Khám </span><span class=\"_fadeIn_m1hgl_8\">và </span><span class=\"_fadeIn_m1hgl_8\">điều </span><span class=\"_fadeIn_m1hgl_8\">trị </span><span class=\"_fadeIn_m1hgl_8\">tổng </span><span class=\"_fadeIn_m1hgl_8\">quát – </span><span class=\"_fadeIn_m1hgl_8\">Nha </span><span class=\"_fadeIn_m1hgl_8\">khoa </span><span class=\"_fadeIn_m1hgl_8\">dự </span><span class=\"_fadeIn_m1hgl_8\">phòng</span></em></p><ul data-start=\"269\" data-end=\"621\">\r\n<li data-start=\"408\" data-end=\"489\">\r\n<p data-start=\"410\" data-end=\"489\"><span class=\"_fadeIn_m1hgl_8\">Chuyên </span><span class=\"_fadeIn_m1hgl_8\">xử </span><span class=\"_fadeIn_m1hgl_8\">lý </span><span class=\"_fadeIn_m1hgl_8\">các </span><span class=\"_fadeIn_m1hgl_8\">trường </span><span class=\"_fadeIn_m1hgl_8\">hợp </span><span class=\"_fadeIn_m1hgl_8\">viêm </span><span class=\"_fadeIn_m1hgl_8\">nướu, </span><span class=\"_fadeIn_m1hgl_8\">viêm </span><span class=\"_fadeIn_m1hgl_8\">nha </span><span class=\"_fadeIn_m1hgl_8\">chu, </span><span class=\"_fadeIn_m1hgl_8\">sâu </span><span class=\"_fadeIn_m1hgl_8\">răng </span><span class=\"_fadeIn_m1hgl_8\">và </span><span class=\"_fadeIn_m1hgl_8\">điều </span><span class=\"_fadeIn_m1hgl_8\">trị </span><span class=\"_fadeIn_m1hgl_8\">tủy</span></p>\r\n</li>\r\n<li data-start=\"490\" data-end=\"551\">\r\n<p data-start=\"492\" data-end=\"551\"><span class=\"_fadeIn_m1hgl_8\">Luôn </span><span class=\"_fadeIn_m1hgl_8\">cẩn </span><span class=\"_fadeIn_m1hgl_8\">thận, </span><span class=\"_fadeIn_m1hgl_8\">chính </span><span class=\"_fadeIn_m1hgl_8\">xác </span><span class=\"_fadeIn_m1hgl_8\">và </span><span class=\"_fadeIn_m1hgl_8\">nhẹ </span><span class=\"_fadeIn_m1hgl_8\">nhàng </span><span class=\"_fadeIn_m1hgl_8\">trong </span><span class=\"_fadeIn_m1hgl_8\">từng </span><span class=\"_fadeIn_m1hgl_8\">thao </span><span class=\"_fadeIn_m1hgl_8\">tác</span></p>\r\n</li>\r\n<li data-start=\"552\" data-end=\"621\">\r\n<p data-start=\"554\" data-end=\"621\"><span class=\"_fadeIn_m1hgl_8\">Được </span><span class=\"_fadeIn_m1hgl_8\">khách </span><span class=\"_fadeIn_m1hgl_8\">hàng </span><span class=\"_fadeIn_m1hgl_8\">đánh </span><span class=\"_fadeIn_m1hgl_8\">giá </span><span class=\"_fadeIn_m1hgl_8\">cao </span><span class=\"_fadeIn_m1hgl_8\">bởi </span><span class=\"_fadeIn_m1hgl_8\">thái </span><span class=\"_fadeIn_m1hgl_8\">độ </span><span class=\"_fadeIn_m1hgl_8\">tận </span><span class=\"_fadeIn_m1hgl_8\">tình </span><span class=\"_fadeIn_m1hgl_8\">và </span><span class=\"_fadeIn_m1hgl_8\">tư </span><span class=\"_fadeIn_m1hgl_8\">vấn </span><span class=\"_fadeIn_m1hgl_8\">rõ </span><span class=\"_fadeIn_m1hgl_8\">ràng</span></p></li></ul>', '<ul data-start=\"269\" data-end=\"621\"><li data-start=\"269\" data-end=\"311\"><p data-start=\"271\" data-end=\"311\"><span class=\"_fadeIn_m1hgl_8\">Bác&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">sĩ&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">Răng&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">Hàm&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">Mặt –&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">Đại&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">học&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">Y&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">Hà&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">Nội</span></p></li></ul>', '<div>Trên 12 năm kinh nghiệm trong khám, phát hiện và điều trị các bệnh lý răng miệng thường gặp</div>', '2025-04-24 16:01:21', '2025-05-13 11:31:46'),
(5, NULL, 'BS. Hoàng Quang Long', 10, 1978, 'Nam', '0987654325', 'bs.long@example.com', '330 thống nhất', 'assets/img/bacsi/1747068005_bsi_rang.jpg', '<p data-start=\"656\" data-end=\"700\"><em data-start=\"656\" data-end=\"700\"><span class=\"_fadeIn_m1hgl_8\">Chuyên </span><span class=\"_fadeIn_m1hgl_8\">khoa: </span><span class=\"_fadeIn_m1hgl_8\">Nhổ </span><span class=\"_fadeIn_m1hgl_8\">răng – </span><span class=\"_fadeIn_m1hgl_8\">Tiểu </span><span class=\"_fadeIn_m1hgl_8\">phẫu </span><span class=\"_fadeIn_m1hgl_8\">nha </span><span class=\"_fadeIn_m1hgl_8\">khoa</span></em></p><ul data-start=\"702\" data-end=\"1078\">\r\n<li data-start=\"828\" data-end=\"911\">\r\n<p data-start=\"830\" data-end=\"911\"><span class=\"_fadeIn_m1hgl_8\">Hơn </span><span class=\"_fadeIn_m1hgl_8\">3000 </span><span class=\"_fadeIn_m1hgl_8\">ca </span><span class=\"_fadeIn_m1hgl_8\">nhổ </span><span class=\"_fadeIn_m1hgl_8\">răng </span><span class=\"_fadeIn_m1hgl_8\">được </span><span class=\"_fadeIn_m1hgl_8\">thực </span><span class=\"_fadeIn_m1hgl_8\">hiện </span><span class=\"_fadeIn_m1hgl_8\">thành </span><span class=\"_fadeIn_m1hgl_8\">công, </span><span class=\"_fadeIn_m1hgl_8\">nhanh </span><span class=\"_fadeIn_m1hgl_8\">chóng </span><span class=\"_fadeIn_m1hgl_8\">và </span><span class=\"_fadeIn_m1hgl_8\">không </span><span class=\"_fadeIn_m1hgl_8\">biến </span><span class=\"_fadeIn_m1hgl_8\">chứng</span></p>\r\n</li>\r\n<li data-start=\"912\" data-end=\"983\">\r\n<p data-start=\"914\" data-end=\"983\"><span class=\"_fadeIn_m1hgl_8\">Sử </span><span class=\"_fadeIn_m1hgl_8\">dụng </span><span class=\"_fadeIn_m1hgl_8\">công </span><span class=\"_fadeIn_m1hgl_8\">nghệ </span><span class=\"_fadeIn_m1hgl_8\">siêu </span><span class=\"_fadeIn_m1hgl_8\">âm </span><span class=\"_fadeIn_m1hgl_8\">Piezotome </span><span class=\"_fadeIn_m1hgl_8\">giúp </span><span class=\"_fadeIn_m1hgl_8\">giảm </span><span class=\"_fadeIn_m1hgl_8\">đau </span><span class=\"_fadeIn_m1hgl_8\">và </span><span class=\"_fadeIn_m1hgl_8\">hồi </span><span class=\"_fadeIn_m1hgl_8\">phục </span><span class=\"_fadeIn_m1hgl_8\">nhanh</span></p>\r\n</li>\r\n<li data-start=\"984\" data-end=\"1078\">\r\n<p data-start=\"986\" data-end=\"1078\"><span class=\"_fadeIn_m1hgl_8\">Được </span><span class=\"_fadeIn_m1hgl_8\">biết </span><span class=\"_fadeIn_m1hgl_8\">đến </span><span class=\"_fadeIn_m1hgl_8\">với </span><span class=\"_fadeIn_m1hgl_8\">phong </span><span class=\"_fadeIn_m1hgl_8\">cách </span><span class=\"_fadeIn_m1hgl_8\">làm </span><span class=\"_fadeIn_m1hgl_8\">việc </span><span class=\"_fadeIn_m1hgl_8\">tỉ </span><span class=\"_fadeIn_m1hgl_8\">mỉ, </span><span class=\"_fadeIn_m1hgl_8\">kỹ </span><span class=\"_fadeIn_m1hgl_8\">lưỡng </span><span class=\"_fadeIn_m1hgl_8\">và </span><span class=\"_fadeIn_m1hgl_8\">giải </span><span class=\"_fadeIn_m1hgl_8\">thích </span><span class=\"_fadeIn_m1hgl_8\">kỹ </span><span class=\"_fadeIn_m1hgl_8\">trước </span><span class=\"_fadeIn_m1hgl_8\">mỗi </span><span class=\"_fadeIn_m1hgl_8\">ca </span><span class=\"_fadeIn_m1hgl_8\">điều </span><span class=\"_fadeIn_m1hgl_8\">trị</span></p></li></ul>', '<ul data-start=\"702\" data-end=\"1078\"><li data-start=\"702\" data-end=\"748\"><p data-start=\"704\" data-end=\"748\"><span class=\"_fadeIn_m1hgl_8\">Bác&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">sĩ&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">chuyên&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">khoa&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">I –&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">Nha&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">khoa&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">phẫu&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">thuật</span></p></li></ul>', '<div>Chứng chỉ chuyên sâu về tiểu phẫu răng khôn</div><div> xử lý răng mọc ngầm, mọc lệch</div>', '2025-04-24 16:01:21', '2025-05-13 11:26:54'),
(6, 3, 'BS. Lê Văn Duy ', 2, 1990, 'Nam', '0123123123', 'vanduy@gmail.com', '10 y ơn ', 'assets/img/bacsi/1747068083_bsi_hohap.jpg', '<p data-start=\"1112\" data-end=\"1177\"><em data-start=\"1112\" data-end=\"1177\"><span class=\"_fadeIn_m1hgl_8\">Chuyên </span><span class=\"_fadeIn_m1hgl_8\">khoa: </span><span class=\"_fadeIn_m1hgl_8\">Niềng </span><span class=\"_fadeIn_m1hgl_8\">răng </span><span class=\"_fadeIn_m1hgl_8\">mắc </span><span class=\"_fadeIn_m1hgl_8\">cài – </span><span class=\"_fadeIn_m1hgl_8\">Chỉnh </span><span class=\"_fadeIn_m1hgl_8\">nha </span><span class=\"_fadeIn_m1hgl_8\">trẻ </span><span class=\"_fadeIn_m1hgl_8\">em </span><span class=\"_fadeIn_m1hgl_8\">và </span><span class=\"_fadeIn_m1hgl_8\">người </span><span class=\"_fadeIn_m1hgl_8\">lớn</span></em></p><ul data-start=\"1179\" data-end=\"1533\">\r\n<li data-start=\"1294\" data-end=\"1388\">\r\n<p data-start=\"1296\" data-end=\"1388\"><span class=\"_fadeIn_m1hgl_8\">Kinh </span><span class=\"_fadeIn_m1hgl_8\">nghiệm </span><span class=\"_fadeIn_m1hgl_8\">hơn </span><span class=\"_fadeIn_m1hgl_8\">8 </span><span class=\"_fadeIn_m1hgl_8\">năm </span><span class=\"_fadeIn_m1hgl_8\">điều </span><span class=\"_fadeIn_m1hgl_8\">trị </span><span class=\"_fadeIn_m1hgl_8\">chỉnh </span><span class=\"_fadeIn_m1hgl_8\">nha </span><span class=\"_fadeIn_m1hgl_8\">mắc </span><span class=\"_fadeIn_m1hgl_8\">cài, </span><span class=\"_fadeIn_m1hgl_8\">niềng </span><span class=\"_fadeIn_m1hgl_8\">răng </span><span class=\"_fadeIn_m1hgl_8\">cho </span><span class=\"_fadeIn_m1hgl_8\">trẻ </span><span class=\"_fadeIn_m1hgl_8\">và </span><span class=\"_fadeIn_m1hgl_8\">người </span><span class=\"_fadeIn_m1hgl_8\">trưởng </span><span class=\"_fadeIn_m1hgl_8\">thành</span></p>\r\n</li>\r\n<li data-start=\"1389\" data-end=\"1466\">\r\n<p data-start=\"1391\" data-end=\"1466\"><span class=\"_fadeIn_m1hgl_8\">Tư </span><span class=\"_fadeIn_m1hgl_8\">vấn </span><span class=\"_fadeIn_m1hgl_8\">sát </span><span class=\"_fadeIn_m1hgl_8\">sao, </span><span class=\"_fadeIn_m1hgl_8\">luôn </span><span class=\"_fadeIn_m1hgl_8\">đồng </span><span class=\"_fadeIn_m1hgl_8\">hành </span><span class=\"_fadeIn_m1hgl_8\">cùng </span><span class=\"_fadeIn_m1hgl_8\">khách </span><span class=\"_fadeIn_m1hgl_8\">hàng </span><span class=\"_fadeIn_m1hgl_8\">trong </span><span class=\"_fadeIn_m1hgl_8\">suốt </span><span class=\"_fadeIn_m1hgl_8\">quá </span><span class=\"_fadeIn_m1hgl_8\">trình </span><span class=\"_fadeIn_m1hgl_8\">niềng</span></p>\r\n</li>\r\n<li data-start=\"1467\" data-end=\"1533\">\r\n<p data-start=\"1469\" data-end=\"1533\"><span class=\"_fadeIn_m1hgl_8\">Kiên </span><span class=\"_fadeIn_m1hgl_8\">nhẫn, </span><span class=\"_fadeIn_m1hgl_8\">thân </span><span class=\"_fadeIn_m1hgl_8\">thiện </span><span class=\"_fadeIn_m1hgl_8\">và </span><span class=\"_fadeIn_m1hgl_8\">rất </span><span class=\"_fadeIn_m1hgl_8\">được </span><span class=\"_fadeIn_m1hgl_8\">phụ </span><span class=\"_fadeIn_m1hgl_8\">huynh – </span><span class=\"_fadeIn_m1hgl_8\">học </span><span class=\"_fadeIn_m1hgl_8\">sinh </span><span class=\"_fadeIn_m1hgl_8\">tin </span><span class=\"_fadeIn_m1hgl_8\">tưởng</span></p></li></ul>', '<ul data-start=\"1179\" data-end=\"1533\"><li data-start=\"1179\" data-end=\"1226\"><p data-start=\"1181\" data-end=\"1226\"><span class=\"_fadeIn_m1hgl_8\">Bác&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">sĩ&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">Răng&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">Hàm&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">Mặt –&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">Đại&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">học&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">Y&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">Dược&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">TP.</span><span class=\"_fadeIn_m1hgl_8\">HCM</span></p></li></ul>', '<div>Đào tạo chuyên sâu về chỉnh nha tại Đại học Mahidol (Thái Lan)</div>', '2025-04-24 16:07:45', '2025-05-13 11:29:54'),
(7, 5, 'BS. Hoàng Văn Minh', 5, 2000, 'Nam', '0987654325', 'trancong406@gmail.com', '320 ngô quyền ', 'assets/img/bacsi/1747064723_bsi_dalieu.jpg', '<p><span class=\"_fadeIn_m1hgl_8\">Chuyên </span><span class=\"_fadeIn_m1hgl_8\">gia </span><span class=\"_fadeIn_m1hgl_8\">Nha </span><span class=\"_fadeIn_m1hgl_8\">khoa </span><span class=\"_fadeIn_m1hgl_8\">Tổng </span><span class=\"_fadeIn_m1hgl_8\">quát &amp; </span><span class=\"_fadeIn_m1hgl_8\">Thẩm </span><span class=\"_fadeIn_m1hgl_8\">mỹ</span></p>', '<p><span class=\"_fadeIn_m1hgl_8\">Tốt </span><span class=\"_fadeIn_m1hgl_8\">nghiệp </span><span class=\"_fadeIn_m1hgl_8\">Bác </span><span class=\"_fadeIn_m1hgl_8\">sĩ </span><span class=\"_fadeIn_m1hgl_8\">Răng – </span><span class=\"_fadeIn_m1hgl_8\">Hàm – </span><span class=\"_fadeIn_m1hgl_8\">Mặt, </span><span class=\"_fadeIn_m1hgl_8\">Đại </span><span class=\"_fadeIn_m1hgl_8\">học </span><span class=\"_fadeIn_m1hgl_8\">Y </span><span class=\"_fadeIn_m1hgl_8\">Dược </span><span class=\"_fadeIn_m1hgl_8\">TP. </span><span class=\"_fadeIn_m1hgl_8\">Hồ </span><span class=\"_fadeIn_m1hgl_8\">Chí </span><span class=\"_fadeIn_m1hgl_8\">Minh</span><br data-start=\"371\" data-end=\"374\">\r\n<span class=\"_fadeIn_m1hgl_8\">Đào </span><span class=\"_fadeIn_m1hgl_8\">tạo </span><span class=\"_fadeIn_m1hgl_8\">chuyên </span><span class=\"_fadeIn_m1hgl_8\">sâu </span><span class=\"_fadeIn_m1hgl_8\">về </span><span class=\"_fadeIn_m1hgl_8\">phục </span><span class=\"_fadeIn_m1hgl_8\">hình </span><span class=\"_fadeIn_m1hgl_8\">răng </span><span class=\"_fadeIn_m1hgl_8\">thẩm </span><span class=\"_fadeIn_m1hgl_8\">mỹ </span><span class=\"_fadeIn_m1hgl_8\">tại </span><span class=\"_fadeIn_m1hgl_8\">Hàn </span><span class=\"_fadeIn_m1hgl_8\">Quốc</span></p>', '<p><span class=\"_fadeIn_m1hgl_8\">Hơn </span><span class=\"_fadeIn_m1hgl_8\">10 </span><span class=\"_fadeIn_m1hgl_8\">năm </span><span class=\"_fadeIn_m1hgl_8\">kinh </span><span class=\"_fadeIn_m1hgl_8\">nghiệm </span><span class=\"_fadeIn_m1hgl_8\">trong </span><span class=\"_fadeIn_m1hgl_8\">lĩnh </span><span class=\"_fadeIn_m1hgl_8\">vực </span><span class=\"_fadeIn_m1hgl_8\">nha </span><span class=\"_fadeIn_m1hgl_8\">khoa </span><span class=\"_fadeIn_m1hgl_8\">tổng </span><span class=\"_fadeIn_m1hgl_8\">quát </span><span class=\"_fadeIn_m1hgl_8\">và </span><span class=\"_fadeIn_m1hgl_8\">thẩm </span><span class=\"_fadeIn_m1hgl_8\">mỹ</span><br data-start=\"525\" data-end=\"528\">\r\n<span class=\"_fadeIn_m1hgl_8\">Đã </span><span class=\"_fadeIn_m1hgl_8\">thực </span><span class=\"_fadeIn_m1hgl_8\">hiện </span><span class=\"_fadeIn_m1hgl_8\">hơn </span><span class=\"_fadeIn_m1hgl_8\">2.000 </span><span class=\"_fadeIn_m1hgl_8\">ca </span><span class=\"_fadeIn_m1hgl_8\">phục </span><span class=\"_fadeIn_m1hgl_8\">hình </span><span class=\"_fadeIn_m1hgl_8\">răng </span><span class=\"_fadeIn_m1hgl_8\">sứ </span><span class=\"_fadeIn_m1hgl_8\">và </span><span class=\"_fadeIn_m1hgl_8\">dán </span><span class=\"_fadeIn_m1hgl_8\">veneer</span></p>', '2025-04-27 21:56:47', '2025-05-13 11:29:12'),
(8, 8, 'Trần Trọng Tín ', 3, 2002, 'Nam', '0944492947', 'trongtinabc@gmail.com', '330 thống nhất', 'assets/img/bacsi/1747070008_bsi_timmach.jpg', '<span class=\"_fadeIn_m1hgl_8\">Chuyên </span><span class=\"_fadeIn_m1hgl_8\">gia </span><span class=\"_fadeIn_m1hgl_8\">Chỉnh </span><span class=\"_fadeIn_m1hgl_8\">nha &amp; </span><span class=\"_fadeIn_m1hgl_8\">Niềng </span><span class=\"_fadeIn_m1hgl_8\">răng</span>', '<span class=\"_fadeIn_m1hgl_8\">Bác </span><span class=\"_fadeIn_m1hgl_8\">sĩ </span><span class=\"_fadeIn_m1hgl_8\">Răng – </span><span class=\"_fadeIn_m1hgl_8\">Hàm – </span><span class=\"_fadeIn_m1hgl_8\">Mặt, </span><span class=\"_fadeIn_m1hgl_8\">Đại </span><span class=\"_fadeIn_m1hgl_8\">học </span><span class=\"_fadeIn_m1hgl_8\">Y </span><span class=\"_fadeIn_m1hgl_8\">Hà </span><span class=\"_fadeIn_m1hgl_8\">Nội</span><br data-start=\"993\" data-end=\"996\">\r\n<span class=\"_fadeIn_m1hgl_8\">Chứng </span><span class=\"_fadeIn_m1hgl_8\">chỉ </span><span class=\"_fadeIn_m1hgl_8\">Chỉnh </span><span class=\"_fadeIn_m1hgl_8\">nha </span><span class=\"_fadeIn_m1hgl_8\">chuyên </span><span class=\"_fadeIn_m1hgl_8\">sâu </span><span class=\"_fadeIn_m1hgl_8\">từ </span><span class=\"_fadeIn_m1hgl_8\">Viện </span><span class=\"_fadeIn_m1hgl_8\">Răng </span><span class=\"_fadeIn_m1hgl_8\">Hàm </span><span class=\"_fadeIn_m1hgl_8\">Mặt </span><span class=\"_fadeIn_m1hgl_8\">Trung </span><span class=\"_fadeIn_m1hgl_8\">ương</span>', 'Trên 8 năm làm việc chuyên sâu trong lĩnh vực chỉnh nha', '2025-05-13 00:13:28', '2025-05-13 11:32:34'),
(9, 9, 'BS. Lê Thị Hoàng Phúc', 3, 1989, 'Nam', '0987653567', 'bs.phuc@example.com', '312 nguyễn oanh', 'assets/img/bacsi/1747127476_1667892272-1217513203-custom.jpg', '<p><span class=\"_fadeIn_m1hgl_8\">Bác </span><span class=\"_fadeIn_m1hgl_8\">sĩ </span><span class=\"_fadeIn_m1hgl_8\">Răng – </span><span class=\"_fadeIn_m1hgl_8\">Hàm – </span><span class=\"_fadeIn_m1hgl_8\">Mặt, </span><span class=\"_fadeIn_m1hgl_8\">Đại </span><span class=\"_fadeIn_m1hgl_8\">học </span><span class=\"_fadeIn_m1hgl_8\">Y </span><span class=\"_fadeIn_m1hgl_8\">Dược </span><span class=\"_fadeIn_m1hgl_8\">Cần </span><span class=\"_fadeIn_m1hgl_8\">Thơ</span><br></p>', '<p><span class=\"_fadeIn_m1hgl_8\">Đào </span><span class=\"_fadeIn_m1hgl_8\">tạo </span><span class=\"_fadeIn_m1hgl_8\">Implant </span><span class=\"_fadeIn_m1hgl_8\">nâng </span><span class=\"_fadeIn_m1hgl_8\">cao </span><span class=\"_fadeIn_m1hgl_8\">tại </span><span class=\"_fadeIn_m1hgl_8\">Đức </span><span class=\"_fadeIn_m1hgl_8\">và </span><span class=\"_fadeIn_m1hgl_8\">Thụy </span><span class=\"_fadeIn_m1hgl_8\">Sĩ</span></p>', '<p><span class=\"_fadeIn_m1hgl_8\">12 </span><span class=\"_fadeIn_m1hgl_8\">năm </span><span class=\"_fadeIn_m1hgl_8\">kinh </span><span class=\"_fadeIn_m1hgl_8\">nghiệm </span><span class=\"_fadeIn_m1hgl_8\">trong </span><span class=\"_fadeIn_m1hgl_8\">điều </span><span class=\"_fadeIn_m1hgl_8\">trị </span><span class=\"_fadeIn_m1hgl_8\">mất </span><span class=\"_fadeIn_m1hgl_8\">răng </span><span class=\"_fadeIn_m1hgl_8\">bằng </span><span class=\"_fadeIn_m1hgl_8\">cấy </span><span class=\"_fadeIn_m1hgl_8\">ghép </span><span class=\"_fadeIn_m1hgl_8\">implant ,</span><span class=\"_fadeIn_m1hgl_8\">Hơn </span><span class=\"_fadeIn_m1hgl_8\">1.000 </span><span class=\"_fadeIn_m1hgl_8\">ca </span><span class=\"_fadeIn_m1hgl_8\">implant </span><span class=\"_fadeIn_m1hgl_8\">thành </span><span class=\"_fadeIn_m1hgl_8\">công </span><span class=\"_fadeIn_m1hgl_8\">với </span><span class=\"_fadeIn_m1hgl_8\">nhiều </span><span class=\"_fadeIn_m1hgl_8\">dòng </span><span class=\"_fadeIn_m1hgl_8\">trụ </span><span class=\"_fadeIn_m1hgl_8\">khác </span><span class=\"_fadeIn_m1hgl_8\">nhau</span></p>', '2025-05-13 16:00:43', '2025-05-13 16:11:16'),
(10, 10, 'BS. Phạm Nhật Linh', 2, 1976, 'Nam', '0944452122', 'bs.linh@example.com', '576 ngô quyền ', 'assets/img/bacsi/1747127446_1667892080-1016371248-custom.jpg', '<p><span class=\"_fadeIn_m1hgl_8\">Chuyên </span><span class=\"_fadeIn_m1hgl_8\">gia </span><span class=\"_fadeIn_m1hgl_8\">Nha </span><span class=\"_fadeIn_m1hgl_8\">khoa </span><span class=\"_fadeIn_m1hgl_8\">Trẻ </span><span class=\"_fadeIn_m1hgl_8\">em</span></p>', '<p><span class=\"_fadeIn_m1hgl_8\">Tốt </span><span class=\"_fadeIn_m1hgl_8\">nghiệp </span><span class=\"_fadeIn_m1hgl_8\">Bác </span><span class=\"_fadeIn_m1hgl_8\">sĩ </span><span class=\"_fadeIn_m1hgl_8\">Răng – </span><span class=\"_fadeIn_m1hgl_8\">Hàm – </span><span class=\"_fadeIn_m1hgl_8\">Mặt, </span><span class=\"_fadeIn_m1hgl_8\">Đại </span><span class=\"_fadeIn_m1hgl_8\">học </span><span class=\"_fadeIn_m1hgl_8\">Y </span><span class=\"_fadeIn_m1hgl_8\">Dược </span><span class=\"_fadeIn_m1hgl_8\">Huế</span><br data-start=\"350\" data-end=\"353\">\r\n<span class=\"_fadeIn_m1hgl_8\">Khóa </span><span class=\"_fadeIn_m1hgl_8\">đào </span><span class=\"_fadeIn_m1hgl_8\">tạo </span><span class=\"_fadeIn_m1hgl_8\">chuyên </span><span class=\"_fadeIn_m1hgl_8\">sâu </span><span class=\"_fadeIn_m1hgl_8\">về </span><span class=\"_fadeIn_m1hgl_8\">nha </span><span class=\"_fadeIn_m1hgl_8\">khoa </span><span class=\"_fadeIn_m1hgl_8\">trẻ </span><span class=\"_fadeIn_m1hgl_8\">em </span><span class=\"_fadeIn_m1hgl_8\">tại </span><span class=\"_fadeIn_m1hgl_8\">Đại </span><span class=\"_fadeIn_m1hgl_8\">học </span><span class=\"_fadeIn_m1hgl_8\">Mahidol (</span><span class=\"_fadeIn_m1hgl_8\">Thái </span><span class=\"_fadeIn_m1hgl_8\">Lan)</span></p>', '<p><span class=\"_fadeIn_m1hgl_8\">Hơn </span><span class=\"_fadeIn_m1hgl_8\">6 </span><span class=\"_fadeIn_m1hgl_8\">năm </span><span class=\"_fadeIn_m1hgl_8\">điều </span><span class=\"_fadeIn_m1hgl_8\">trị </span><span class=\"_fadeIn_m1hgl_8\">răng </span><span class=\"_fadeIn_m1hgl_8\">miệng </span><span class=\"_fadeIn_m1hgl_8\">cho </span><span class=\"_fadeIn_m1hgl_8\">trẻ </span><span class=\"_fadeIn_m1hgl_8\">nhỏ</span><br data-start=\"494\" data-end=\"497\">\r\n<span class=\"_fadeIn_m1hgl_8\">Đặc </span><span class=\"_fadeIn_m1hgl_8\">biệt </span><span class=\"_fadeIn_m1hgl_8\">có </span><span class=\"_fadeIn_m1hgl_8\">kinh </span><span class=\"_fadeIn_m1hgl_8\">nghiệm </span><span class=\"_fadeIn_m1hgl_8\">xử </span><span class=\"_fadeIn_m1hgl_8\">lý </span><span class=\"_fadeIn_m1hgl_8\">các </span><span class=\"_fadeIn_m1hgl_8\">trường </span><span class=\"_fadeIn_m1hgl_8\">hợp </span><span class=\"_fadeIn_m1hgl_8\">bé </span><span class=\"_fadeIn_m1hgl_8\">sợ </span><span class=\"_fadeIn_m1hgl_8\">nha </span><span class=\"_fadeIn_m1hgl_8\">sĩ, </span><span class=\"_fadeIn_m1hgl_8\">bé </span><span class=\"_fadeIn_m1hgl_8\">tăng </span><span class=\"_fadeIn_m1hgl_8\">động</span></p>', '2025-05-13 16:03:26', '2025-05-13 16:10:46'),
(11, NULL, 'BS. Vũ Thanh Tùng', 5, 1970, 'Nam', '0987606467', 'bs.tung@example.com', '143 y ơn ', 'assets/img/bacsi/1747127435_1666750887-1616272448-custom.jpeg', '<p><span class=\"_fadeIn_m1hgl_8\">Chuyên </span><span class=\"_fadeIn_m1hgl_8\">gia </span><span class=\"_fadeIn_m1hgl_8\">Phẫu </span><span class=\"_fadeIn_m1hgl_8\">thuật </span><span class=\"_fadeIn_m1hgl_8\">Nha </span><span class=\"_fadeIn_m1hgl_8\">khoa &amp; </span><span class=\"_fadeIn_m1hgl_8\">Tiểu </span><span class=\"_fadeIn_m1hgl_8\">phẫu</span></p>', '<p><span class=\"_fadeIn_m1hgl_8\">Bác </span><span class=\"_fadeIn_m1hgl_8\">sĩ </span><span class=\"_fadeIn_m1hgl_8\">Răng – </span><span class=\"_fadeIn_m1hgl_8\">Hàm – </span><span class=\"_fadeIn_m1hgl_8\">Mặt, </span><span class=\"_fadeIn_m1hgl_8\">Đại </span><span class=\"_fadeIn_m1hgl_8\">học </span><span class=\"_fadeIn_m1hgl_8\">Y </span><span class=\"_fadeIn_m1hgl_8\">Dược </span><span class=\"_fadeIn_m1hgl_8\">TP.</span><span class=\"_fadeIn_m1hgl_8\">HCM</span><br data-start=\"1018\" data-end=\"1021\">\r\n<span class=\"_fadeIn_m1hgl_8\">Chứng </span><span class=\"_fadeIn_m1hgl_8\">chỉ </span><span class=\"_fadeIn_m1hgl_8\">phẫu </span><span class=\"_fadeIn_m1hgl_8\">thuật </span><span class=\"_fadeIn_m1hgl_8\">răng </span><span class=\"_fadeIn_m1hgl_8\">khôn </span><span class=\"_fadeIn_m1hgl_8\">và </span><span class=\"_fadeIn_m1hgl_8\">tiểu </span><span class=\"_fadeIn_m1hgl_8\">phẫu </span><span class=\"_fadeIn_m1hgl_8\">nha </span><span class=\"_fadeIn_m1hgl_8\">khoa </span><span class=\"_fadeIn_m1hgl_8\">nâng </span><span class=\"_fadeIn_m1hgl_8\">cao</span></p>', '<p><span class=\"_fadeIn_m1hgl_8\">9 </span><span class=\"_fadeIn_m1hgl_8\">năm </span><span class=\"_fadeIn_m1hgl_8\">kinh </span><span class=\"_fadeIn_m1hgl_8\">nghiệm </span><span class=\"_fadeIn_m1hgl_8\">phẫu </span><span class=\"_fadeIn_m1hgl_8\">thuật </span><span class=\"_fadeIn_m1hgl_8\">răng </span><span class=\"_fadeIn_m1hgl_8\">khôn </span><span class=\"_fadeIn_m1hgl_8\">khó, </span><span class=\"_fadeIn_m1hgl_8\">tiểu </span><span class=\"_fadeIn_m1hgl_8\">phẫu </span><span class=\"_fadeIn_m1hgl_8\">nha </span><span class=\"_fadeIn_m1hgl_8\">chu</span><br data-start=\"1170\" data-end=\"1173\">\r\n<span class=\"_fadeIn_m1hgl_8\">Là </span><span class=\"_fadeIn_m1hgl_8\">thành </span><span class=\"_fadeIn_m1hgl_8\">viên </span><span class=\"_fadeIn_m1hgl_8\">Hội </span><span class=\"_fadeIn_m1hgl_8\">Phẫu </span><span class=\"_fadeIn_m1hgl_8\">thuật </span><span class=\"_fadeIn_m1hgl_8\">Răng </span><span class=\"_fadeIn_m1hgl_8\">Hàm </span><span class=\"_fadeIn_m1hgl_8\">Mặt </span><span class=\"_fadeIn_m1hgl_8\">Việt </span><span class=\"_fadeIn_m1hgl_8\">Nam</span></p>', '2025-05-13 16:06:35', '2025-05-13 16:10:35'),
(12, NULL, 'Đặng Hồng Nhung', 2, 1986, 'Nữ', '0987907435', 'bs.nhung@example.com', ' nguyễn oanh', 'assets/img/bacsi/1747127421_1706861879-1294050950-custom.jpg', '<p><span class=\"_fadeIn_m1hgl_8\">Chuyên </span><span class=\"_fadeIn_m1hgl_8\">gia </span><span class=\"_fadeIn_m1hgl_8\">Tư </span><span class=\"_fadeIn_m1hgl_8\">vấn &amp; </span><span class=\"_fadeIn_m1hgl_8\">Phục </span><span class=\"_fadeIn_m1hgl_8\">hình </span><span class=\"_fadeIn_m1hgl_8\">tháo </span><span class=\"_fadeIn_m1hgl_8\">lắp</span></p>', '<p><span class=\"_fadeIn_m1hgl_8\">Tốt </span><span class=\"_fadeIn_m1hgl_8\">nghiệp </span><span class=\"_fadeIn_m1hgl_8\">Đại </span><span class=\"_fadeIn_m1hgl_8\">học </span><span class=\"_fadeIn_m1hgl_8\">Y </span><span class=\"_fadeIn_m1hgl_8\">Dược </span><span class=\"_fadeIn_m1hgl_8\">Cần </span><span class=\"_fadeIn_m1hgl_8\">Thơ</span><br data-start=\"1644\" data-end=\"1647\">\r\n<span class=\"_fadeIn_m1hgl_8\">Đào </span><span class=\"_fadeIn_m1hgl_8\">tạo </span><span class=\"_fadeIn_m1hgl_8\">nâng </span><span class=\"_fadeIn_m1hgl_8\">cao </span><span class=\"_fadeIn_m1hgl_8\">phục </span><span class=\"_fadeIn_m1hgl_8\">hình </span><span class=\"_fadeIn_m1hgl_8\">tháo </span><span class=\"_fadeIn_m1hgl_8\">lắp </span><span class=\"_fadeIn_m1hgl_8\">và </span><span class=\"_fadeIn_m1hgl_8\">toàn </span><span class=\"_fadeIn_m1hgl_8\">hàm </span><span class=\"_fadeIn_m1hgl_8\">giả </span><span class=\"_fadeIn_m1hgl_8\">tại </span><span class=\"_fadeIn_m1hgl_8\">Nhật </span><span class=\"_fadeIn_m1hgl_8\">Bản</span></p>', '<p><span class=\"_fadeIn_m1hgl_8\">Hơn </span><span class=\"_fadeIn_m1hgl_8\">15 </span><span class=\"_fadeIn_m1hgl_8\">năm </span><span class=\"_fadeIn_m1hgl_8\">trong </span><span class=\"_fadeIn_m1hgl_8\">lĩnh </span><span class=\"_fadeIn_m1hgl_8\">vực </span><span class=\"_fadeIn_m1hgl_8\">phục </span><span class=\"_fadeIn_m1hgl_8\">hình </span><span class=\"_fadeIn_m1hgl_8\">tháo </span><span class=\"_fadeIn_m1hgl_8\">lắp </span><span class=\"_fadeIn_m1hgl_8\">và </span><span class=\"_fadeIn_m1hgl_8\">răng </span><span class=\"_fadeIn_m1hgl_8\">giả </span><span class=\"_fadeIn_m1hgl_8\">cho </span><span class=\"_fadeIn_m1hgl_8\">người </span><span class=\"_fadeIn_m1hgl_8\">lớn </span><span class=\"_fadeIn_m1hgl_8\">tuổi</span><br data-start=\"1813\" data-end=\"1816\">\r\n<span class=\"_fadeIn_m1hgl_8\">Được </span><span class=\"_fadeIn_m1hgl_8\">đánh </span><span class=\"_fadeIn_m1hgl_8\">giá </span><span class=\"_fadeIn_m1hgl_8\">cao </span><span class=\"_fadeIn_m1hgl_8\">bởi </span><span class=\"_fadeIn_m1hgl_8\">bệnh </span><span class=\"_fadeIn_m1hgl_8\">nhân </span><span class=\"_fadeIn_m1hgl_8\">cao </span><span class=\"_fadeIn_m1hgl_8\">tuổi </span><span class=\"_fadeIn_m1hgl_8\">về </span><span class=\"_fadeIn_m1hgl_8\">sự </span><span class=\"_fadeIn_m1hgl_8\">tận </span><span class=\"_fadeIn_m1hgl_8\">tâm </span><span class=\"_fadeIn_m1hgl_8\">và </span><span class=\"_fadeIn_m1hgl_8\">dễ </span><span class=\"_fadeIn_m1hgl_8\">hiểu </span><span class=\"_fadeIn_m1hgl_8\">khi </span><span class=\"_fadeIn_m1hgl_8\">tư </span><span class=\"_fadeIn_m1hgl_8\">vấn</span></p>', '2025-05-13 16:07:46', '2025-05-13 16:10:21');

-- --------------------------------------------------------

--
-- Table structure for table `benhnhan`
--

CREATE TABLE `benhnhan` (
  `id` int(11) NOT NULL,
  `nguoidung_id` int(11) DEFAULT NULL,
  `ho_ten` varchar(100) NOT NULL,
  `nam_sinh` int(11) NOT NULL,
  `gioi_tinh` enum('Nam','Nữ','Khác') DEFAULT 'Nam',
  `dien_thoai` varchar(20) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `dia_chi` text DEFAULT NULL,
  `cmnd_cccd` varchar(20) DEFAULT NULL,
  `nhom_mau` varchar(10) DEFAULT NULL,
  `di_ung` text DEFAULT NULL,
  `ngay_tao` datetime DEFAULT current_timestamp(),
  `ngay_capnhat` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `benhnhan`
--

INSERT INTO `benhnhan` (`id`, `nguoidung_id`, `ho_ten`, `nam_sinh`, `gioi_tinh`, `dien_thoai`, `email`, `dia_chi`, `cmnd_cccd`, `nhom_mau`, `di_ung`, `ngay_tao`, `ngay_capnhat`) VALUES
(1, NULL, 'Nguyễn Văn A', 1990, 'Nam', '0123456789', 'nguyenvana@email.com', 'Hà Nội', NULL, NULL, NULL, '2025-04-24 16:01:21', NULL),
(2, NULL, 'Trần Thị B', 1995, 'Nữ', '0987654321', 'tranthib@email.com', 'Hồ Chí Minh', NULL, NULL, NULL, '2025-04-24 16:01:21', NULL),
(3, NULL, 'Lê Văn C', 1988, 'Nam', '0934567890', 'levanc@email.com', 'Đà Nẵng', NULL, NULL, NULL, '2025-04-24 16:01:21', NULL),
(4, NULL, 'Phạm Thị D', 1992, 'Nữ', '0912345678', 'phamthid@email.com', 'Hải Phòng', NULL, NULL, NULL, '2025-04-24 16:01:21', NULL),
(5, 2, 'bá nam', 2025, 'Nam', '0382802406', 'abc@gmail.com', 'da nâng', NULL, '', '', '2025-04-24 16:02:05', '2025-05-13 17:22:57'),
(6, 4, 'ko nhớ', 2025, 'Nam', '0382802222', 'user@gmail.com', 'àdfasdfasdf, Phường/Xã: Xã Lùng Khấu Nhin, Quận/Huyện: Huyện Mường Khương, Tỉnh/Thành: Tỉnh Lào Cai', '0123123123', 'A', 'dsadsa', '2025-04-24 16:47:42', '2025-04-26 00:49:41'),
(7, NULL, 'Tiến Trần Công', 2000, 'Nam', '0382802111', 'trancongtien406@gmail.com', 'da nâng, Phường/Xã: Xã Chiềng Khay, Quận/Huyện: Huyện Quỳnh Nhai, Tỉnh/Thành: Tỉnh Sơn La', NULL, NULL, NULL, '2025-04-27 20:48:38', NULL),
(8, NULL, 'Tiến Trần Công', 2003, 'Nam', '0382802406', 'trancongtien406@gmail.com', 'da nâng, Phường/Xã: Phường Khuê Mỹ, Quận/Huyện: Quận Ngũ Hành Sơn, Tỉnh/Thành: Thành phố Đà Nẵng', NULL, NULL, NULL, '2025-04-27 23:54:24', NULL),
(9, 6, '0', 2008, 'Nam', '0382802406', 'tientc.21it@vku.udn.vn', 'Nhĩ Trung, Gio Hải, Gio Linh, Quảng Trị, Phường/Xã: Xã Pu Sam Cáp, Quận/Huyện: Huyện Sìn Hồ, Tỉnh/Thành: Tỉnh Lai Châu', NULL, NULL, NULL, '2025-05-07 20:53:07', '2025-05-07 20:55:42'),
(10, 7, 'Trọng Tín', 2002, 'Nam', '0944492947', 'trongtinacong@gmail.com', '324 nguyễn tất thành, Phường/Xã: Xã Lâm Sơn, Quận/Huyện: Huyện Chi Lăng, Tỉnh/Thành: Tỉnh Lạng Sơn', '20094991', 'A', '', '2025-05-12 16:29:52', '2025-05-13 15:52:19'),
(11, NULL, 'Trần Trọng Tín', 2022, 'Nam', '0944492947', 'trongtinacong@gmail.com', '324 nguyễn tất thành, Phường/Xã: Phường Cống Vị, Quận/Huyện: Quận Ba Đình, Tỉnh/Thành: Thành phố Hà Nội', NULL, NULL, NULL, '2025-05-12 23:58:07', NULL),
(12, NULL, 'Trần Trọng Tín', 2000, 'Nam', '0944492947', 'trongtinacong@gmail.com', '324 nguyễn tất thành, Phường/Xã: Phường Thanh Khê Đông, Quận/Huyện: Quận Thanh Khê, Tỉnh/Thành: Thành phố Đà Nẵng', NULL, NULL, NULL, '2025-05-16 20:47:06', NULL),
(13, NULL, 'tín', 2000, 'Nam', '0944929498', 'trongtinacong@gmail.com', '1, Phường/Xã: Phường Trung Tâm, Quận/Huyện: Thị xã Nghĩa Lộ, Tỉnh/Thành: Tỉnh Yên Bái', NULL, NULL, NULL, '2025-05-16 20:49:24', NULL),
(14, NULL, 'Nguyen Van A', 1982, 'Nữ', '0901000001', 'user1@example.com', '367 Trần Hưng Đạo, Phường Bến Thành, Quận 1, Thành phố Đà Nẵng', '123456789000', 'O+', 'Không', '2025-05-19 01:43:05', NULL),
(15, NULL, 'Tran Thi B', 2004, 'Nam', '0901000002', 'user2@example.com', '221 Nguyễn Huệ, Phường Bến Nghé, Thành phố Cần Thơ, Tỉnh Thừa Thiên Huế', '123456789001', 'A-', 'Phấn hoa', '2025-05-19 01:43:05', NULL),
(16, NULL, 'Le Van C', 1996, 'Nam', '0901000003', 'user3@example.com', '382 Lý Thường Kiệt, Phường Phước Ninh, Quận 1, Tỉnh Quảng Nam', '123456789002', 'O-', 'Thuốc', '2025-05-19 01:43:05', NULL),
(17, NULL, 'Pham Thi D', 1975, 'Nam', '0901000004', 'user4@example.com', '65 Lê Lợi, Phường Hòa Khánh Nam, Quận Ninh Kiều, Thành phố Hà Nội', '123456789003', 'AB-', 'Thuốc', '2025-05-19 01:43:05', NULL),
(18, NULL, 'Hoang Van E', 1987, 'Nam', '0901000005', 'user5@example.com', '383 Nguyễn Huệ, Phường Bến Thành, Quận 1, Tỉnh Thừa Thiên Huế', '123456789004', 'O+', 'Không', '2025-05-19 01:43:05', NULL),
(19, NULL, 'Do Thi F', 1995, 'Nữ', '0901000006', 'user6@example.com', '252 Hùng Vương, Phường Thanh Khê Đông, Quận Hải Châu, Tỉnh Quảng Nam', '123456789005', 'AB+', 'Không', '2025-05-19 01:43:05', NULL),
(20, NULL, 'Nguyen Van G', 2005, 'Nam', '0901000007', 'user7@example.com', '372 Hải Phòng, Phường Thanh Khê Đông, Quận Hải Châu, Thành phố Hà Nội', '123456789006', 'A-', 'Hải sản', '2025-05-19 01:43:05', NULL),
(21, NULL, 'Tran Thi H', 1983, 'Nam', '0901000008', 'user8@example.com', '332 Nguyễn Tất Thành, Phường Phước Ninh, Quận Hoàn Kiếm, Thành phố Hà Nội', '123456789007', 'AB+', 'Thuốc', '2025-05-19 01:43:05', NULL),
(22, NULL, 'Le Van I', 2001, 'Nữ', '0901000009', 'user9@example.com', '296 Lê Lợi, Phường Thạch Thang, Quận Hoàn Kiếm, Tỉnh Thừa Thiên Huế', '123456789008', 'AB-', 'Không khí lạnh', '2025-05-19 01:43:05', NULL),
(23, NULL, 'Pham Thi J', 1998, 'Nam', '0901000010', 'user10@example.com', '422 Nguyễn Huệ, Phường Phước Ninh, Quận Hải Châu, Thành phố Đà Nẵng', '123456789009', 'O+', 'Không', '2025-05-19 01:43:05', NULL),
(24, NULL, 'Nguyen Van K', 1981, 'Nữ', '0901000011', 'user11@example.com', '419 Lê Lợi, Phường Bến Thành, Quận Ninh Kiều, Tỉnh Quảng Nam', '123456789010', 'A-', 'Phấn hoa', '2025-05-19 01:43:05', NULL),
(25, NULL, 'Tran Thi L', 1998, 'Nữ', '0901000012', 'user12@example.com', '183 Trần Hưng Đạo, Phường Vĩnh Ninh, Quận Hoàn Kiếm, Tỉnh Thừa Thiên Huế', '123456789011', 'A-', 'Không khí lạnh', '2025-05-19 01:43:05', NULL),
(26, NULL, 'Le Van M', 1990, 'Nam', '0901000013', 'user13@example.com', '36 Tôn Đức Thắng, Phường Bến Thành, Quận 1, Thành phố Hồ Chí Minh', '123456789012', 'B+', 'Trứng', '2025-05-19 01:43:05', NULL),
(27, NULL, 'Pham Thi N', 1987, 'Nữ', '0901000014', 'user14@example.com', '459 Lê Lợi, Phường Phước Ninh, Thành phố Huế, Thành phố Đà Nẵng', '123456789013', 'O+', 'Hải sản', '2025-05-19 01:43:05', NULL),
(28, NULL, 'Nguyen Van O', 1984, 'Nam', '0901000015', 'user15@example.com', '296 Trần Hưng Đạo, Phường An Cựu, Thành phố Huế, Tỉnh Thừa Thiên Huế', '123456789014', 'AB-', 'Phấn hoa', '2025-05-19 01:43:05', NULL),
(29, NULL, 'Tran Thi P', 1980, 'Nam', '0901000016', 'user16@example.com', '88 Phan Chu Trinh, Phường Hòa Khánh Nam, Quận Hoàn Kiếm, Thành phố Hà Nội', '123456789015', 'O-', 'Trứng', '2025-05-19 01:43:05', NULL),
(30, NULL, 'Le Van Q', 1987, 'Nữ', '0901000017', 'user17@example.com', '86 Lý Thường Kiệt, Phường Trần Hưng Đạo, Quận 1, Thành phố Hà Nội', '123456789016', 'B-', 'Trứng', '2025-05-19 01:43:05', NULL),
(31, NULL, 'Pham Thi R', 1978, 'Nam', '0901000018', 'user18@example.com', '424 Lý Thường Kiệt, Phường Bến Thành, Quận Liên Chiểu, Thành phố Hồ Chí Minh', '123456789017', 'O+', 'Thuốc', '2025-05-19 01:43:05', NULL),
(32, NULL, 'Nguyen Van S', 1978, 'Nam', '0901000019', 'user19@example.com', '130 Hùng Vương, Phường Vĩnh Ninh, Quận 1, Tỉnh Thừa Thiên Huế', '123456789018', 'AB-', 'Thuốc', '2025-05-19 01:43:05', NULL),
(33, NULL, 'Tran Thi T', 1978, 'Nữ', '0901000020', 'user20@example.com', '52 Nguyễn Huệ, Phường Hòa Khánh Nam, Thành phố Huế, Thành phố Hà Nội', '123456789019', 'AB+', 'Trứng', '2025-05-19 01:43:05', NULL),
(34, NULL, 'Le Van U', 1982, 'Nam', '0901000021', 'user21@example.com', '427 Nguyễn Tất Thành, Phường Bến Thành, Quận Hải Châu, Tỉnh Quảng Nam', '123456789020', 'AB+', 'Hải sản', '2025-05-19 01:43:05', NULL),
(35, NULL, 'Pham Thi V', 1986, 'Nữ', '0901000022', 'user22@example.com', '142 Nguyễn Huệ, Phường Trần Hưng Đạo, Quận Liên Chiểu, Thành phố Hồ Chí Minh', '123456789021', 'O-', 'Thuốc', '2025-05-19 01:43:05', NULL),
(36, NULL, 'Nguyen Van W', 1981, 'Nam', '0901000023', 'user23@example.com', '123 Hùng Vương, Phường Vĩnh Ninh, Quận Thanh Khê, Tỉnh Thừa Thiên Huế', '123456789022', 'AB-', 'Hải sản', '2025-05-19 01:43:05', NULL),
(37, NULL, 'Tran Thi X', 1979, 'Nam', '0901000024', 'user24@example.com', '125 Hùng Vương, Phường Phước Ninh, Quận Hoàn Kiếm, Thành phố Hồ Chí Minh', '123456789023', 'B-', 'Thuốc', '2025-05-19 01:43:05', NULL),
(38, NULL, 'Le Van Y', 1984, 'Nam', '0901000025', 'user25@example.com', '197 Phan Chu Trinh, Phường An Cựu, Quận Ninh Kiều, Tỉnh Thừa Thiên Huế', '123456789024', 'O-', 'Thuốc', '2025-05-19 01:43:05', NULL),
(39, NULL, 'Pham Thi Z', 1983, 'Nữ', '0901000026', 'user26@example.com', '451 Nguyễn Trãi, Phường An Cựu, Quận Thanh Khê, Thành phố Đà Nẵng', '123456789025', 'O+', 'Hải sản', '2025-05-19 01:43:05', NULL),
(40, NULL, 'Nguyen Van AA', 1988, 'Nữ', '0901000027', 'user27@example.com', '56 Tôn Đức Thắng, Phường Bến Nghé, Quận 1, Tỉnh Thừa Thiên Huế', '123456789026', 'O+', 'Trứng', '2025-05-19 01:43:05', NULL),
(41, NULL, 'Tran Thi BB', 1997, 'Nữ', '0901000028', 'user28@example.com', '22 Phan Chu Trinh, Phường An Cựu, Quận Liên Chiểu, Tỉnh Quảng Nam', '123456789027', 'B-', 'Trứng', '2025-05-19 01:43:05', NULL),
(42, NULL, 'Le Van CC', 1998, 'Nam', '0901000029', 'user29@example.com', '110 Hải Phòng, Phường Bến Thành, Quận Ninh Kiều, Tỉnh Quảng Nam', '123456789028', 'B-', 'Phấn hoa', '2025-05-19 01:43:05', NULL),
(43, NULL, 'Pham Thi DD', 1978, 'Nam', '0901000030', 'user30@example.com', '154 Hùng Vương, Phường Bến Thành, Thành phố Huế, Thành phố Hà Nội', '123456789029', 'O+', 'Thuốc', '2025-05-19 01:43:05', NULL),
(44, NULL, 'Nguyen Van EE', 1977, 'Nam', '0901000031', 'user31@example.com', '34 Hùng Vương, Phường Cái Khế, Quận Thanh Khê, Thành phố Hồ Chí Minh', '123456789030', 'AB-', 'Thuốc', '2025-05-19 01:43:05', NULL),
(45, NULL, 'Tran Thi FF', 1994, 'Nữ', '0901000032', 'user32@example.com', '439 Phan Chu Trinh, Phường Phước Ninh, Quận 1, Thành phố Đà Nẵng', '123456789031', 'O-', 'Hải sản', '2025-05-19 01:43:05', NULL),
(46, NULL, 'Le Van GG', 1975, 'Nam', '0901000033', 'user33@example.com', '345 Nguyễn Trãi, Phường Cái Khế, Quận Liên Chiểu, Tỉnh Quảng Nam', '123456789032', 'O+', 'Trứng', '2025-05-19 01:43:05', NULL),
(47, NULL, 'Pham Thi HH', 1998, 'Nữ', '0901000034', 'user34@example.com', '276 Nguyễn Trãi, Phường Phước Ninh, Thành phố Huế, Tỉnh Thừa Thiên Huế', '123456789033', 'O+', 'Không khí lạnh', '2025-05-19 01:43:05', NULL),
(48, NULL, 'Nguyen Van II', 1992, 'Nam', '0901000035', 'user35@example.com', '111 Hải Phòng, Phường Vĩnh Ninh, Quận 1, Tỉnh Quảng Nam', '123456789034', 'O+', 'Phấn hoa', '2025-05-19 01:43:05', NULL),
(49, NULL, 'Tran Thi JJ', 1996, 'Nữ', '0901000036', 'user36@example.com', '30 Nguyễn Tất Thành, Phường Bến Nghé, Thành phố Cần Thơ, Tỉnh Quảng Nam', '123456789035', 'AB+', 'Không khí lạnh', '2025-05-19 01:43:05', NULL),
(50, NULL, 'Le Van KK', 2004, 'Nữ', '0901000037', 'user37@example.com', '471 Trần Hưng Đạo, Phường Vĩnh Ninh, Thành phố Cần Thơ, Thành phố Hà Nội', '123456789036', 'O+', 'Không', '2025-05-19 01:43:05', NULL),
(51, NULL, 'Pham Thi LL', 1977, 'Nam', '0901000038', 'user38@example.com', '426 Nguyễn Trãi, Phường Trần Hưng Đạo, Quận Hải Châu, Thành phố Đà Nẵng', '123456789037', 'B-', 'Thuốc', '2025-05-19 01:43:05', NULL),
(52, NULL, 'Nguyen Van MM', 1975, 'Nam', '0901000039', 'user39@example.com', '346 Nguyễn Tất Thành, Phường Vĩnh Ninh, Quận 1, Tỉnh Thừa Thiên Huế', '123456789038', 'O+', 'Không khí lạnh', '2025-05-19 01:43:05', NULL),
(53, NULL, 'Tran Thi NN', 2001, 'Nam', '0901000040', 'user40@example.com', '106 Lý Thường Kiệt, Phường Trần Hưng Đạo, Quận Hoàn Kiếm, Tỉnh Quảng Nam', '123456789039', 'B+', 'Phấn hoa', '2025-05-19 01:43:05', NULL),
(54, NULL, 'Le Van OO', 1986, 'Nữ', '0901000041', 'user41@example.com', '423 Hùng Vương, Phường An Cựu, Quận Ninh Kiều, Thành phố Hồ Chí Minh', '123456789040', 'O+', 'Thuốc', '2025-05-19 01:43:05', NULL),
(55, NULL, 'Pham Thi PP', 1997, 'Nam', '0901000042', 'user42@example.com', '427 Trần Hưng Đạo, Phường Bến Nghé, Quận Hải Châu, Thành phố Hà Nội', '123456789041', 'O+', 'Không khí lạnh', '2025-05-19 01:43:05', NULL),
(56, NULL, 'Nguyen Van QQ', 1988, 'Nữ', '0901000043', 'user43@example.com', '66 Phan Chu Trinh, Phường Thanh Khê Đông, Thành phố Huế, Thành phố Đà Nẵng', '123456789042', 'B-', 'Phấn hoa', '2025-05-19 01:43:05', NULL),
(57, NULL, 'Tran Thi RR', 1991, 'Nam', '0901000044', 'user44@example.com', '6 Phan Chu Trinh, Phường Vĩnh Ninh, Quận 1, Tỉnh Thừa Thiên Huế', '123456789043', 'O-', 'Không khí lạnh', '2025-05-19 01:43:05', NULL),
(58, NULL, 'Le Van SS', 2000, 'Nữ', '0901000045', 'user45@example.com', '236 Nguyễn Tất Thành, Phường Thạch Thang, Quận Ninh Kiều, Tỉnh Thừa Thiên Huế', '123456789044', 'A+', 'Phấn hoa', '2025-05-19 01:43:05', NULL),
(59, NULL, 'Pham Thi TT', 1994, 'Nam', '0901000046', 'user46@example.com', '143 Hùng Vương, Phường Hòa Khánh Nam, Quận Ninh Kiều, Thành phố Đà Nẵng', '123456789045', 'B+', 'Thuốc', '2025-05-19 01:43:05', NULL),
(60, NULL, 'Nguyen Van UU', 1986, 'Nam', '0901000047', 'user47@example.com', '149 Nguyễn Trãi, Phường Phước Ninh, Thành phố Huế, Tỉnh Thừa Thiên Huế', '123456789046', 'O+', 'Hải sản', '2025-05-19 01:43:05', NULL),
(61, NULL, 'Tran Thi VV', 1995, 'Nam', '0901000048', 'user48@example.com', '356 Nguyễn Huệ, Phường Phước Ninh, Quận Ninh Kiều, Tỉnh Quảng Nam', '123456789047', 'A-', 'Trứng', '2025-05-19 01:43:05', NULL),
(62, NULL, 'Le Van WW', 1995, 'Nữ', '0901000049', 'user49@example.com', '363 Tôn Đức Thắng, Phường Hòa Khánh Nam, Quận Hoàn Kiếm, Thành phố Hồ Chí Minh', '123456789048', 'AB+', 'Trứng', '2025-05-19 01:43:05', NULL),
(63, NULL, 'Pham Thi XX', 1998, 'Nam', '0901000050', 'user50@example.com', '443 Lê Lợi, Phường Thanh Khê Đông, Quận 1, Thành phố Hồ Chí Minh', '123456789049', 'B+', 'Phấn hoa', '2025-05-19 01:43:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `caidat_website`
--

CREATE TABLE `caidat_website` (
  `id` int(11) NOT NULL,
  `ten_key` varchar(50) NOT NULL,
  `ten_value` text DEFAULT NULL,
  `mo_ta` varchar(255) DEFAULT NULL,
  `loai` enum('text','textarea','image','boolean','number','color') DEFAULT 'text',
  `nhom` varchar(50) DEFAULT 'general',
  `thu_tu` int(11) DEFAULT 0,
  `ngay_tao` datetime DEFAULT current_timestamp(),
  `ngay_capnhat` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `caidat_website`
--

INSERT INTO `caidat_website` (`id`, `ten_key`, `ten_value`, `mo_ta`, `loai`, `nhom`, `thu_tu`, `ngay_tao`, `ngay_capnhat`) VALUES
(1, 'site_name', 'Nha Khoa T&A', 'Tên website', 'text', 'general', 1, '2025-04-24 16:01:21', '2025-05-12 23:00:07'),
(2, 'site_description', 'Chăm sóc sức khỏe cho răng bạn một cách toàn diện. Chúng tôi không chỉ mang đến nụ cười hoàn hảo, mà còn giúp bạn duy trì sức khỏe răng miệng lâu dài.', 'Mô tả ngắn về website', 'textarea', 'general', 2, '2025-04-24 16:01:21', '2025-05-12 23:00:07'),
(3, 'site_logo', 'assets/img/logo.png', 'Logo website', 'image', 'general', 3, '2025-04-24 16:01:21', '2025-05-13 00:20:54'),
(4, 'site_favicon', 'assets/img/favicon.jpg', 'Favicon website', 'image', 'general', 4, '2025-04-24 16:01:21', '2025-05-13 00:23:07'),
(5, 'site_phone', '0944 492 947', 'Số điện thoại liên hệ', 'text', 'contact', 5, '2025-04-24 16:01:21', '2025-05-12 23:01:29'),
(6, 'site_email', 'trongtinacong@gmail.com', 'Email liên hệ', 'text', 'contact', 6, '2025-04-24 16:01:21', '2025-05-12 23:00:07'),
(7, 'site_address', '350/18/35 Lê Đức Thọ, Gò Vấp, TP.HCM', 'Địa chỉ phòng khám', 'textarea', 'contact', 7, '2025-04-24 16:01:21', '2025-05-12 23:01:29'),
(8, 'site_working_hours', 'Thứ 2 - Thứ 6: 7:30 - 17:00\r\nThứ 7: 7:30 - 12:00\r\nChủ nhật: Nghỉ', 'Giờ làm việc', 'textarea', 'contact', 8, '2025-04-24 16:01:21', '2025-04-24 20:34:09'),
(9, 'site_facebook', 'https://facebook.com/nhakhoat&a', 'Facebook', 'text', 'social', 9, '2025-04-24 16:01:21', '2025-05-12 23:02:07'),
(10, 'site_maps', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.858237982653!2d106.68427047508925!3d10.822158889329394!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3174deb3ef536f31%3A0x8b7bb8b7c956157b!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBDw7RuZyBuZ2hp4buHcCBUUC5IQ00!5e0!3m2!1svi!2s!4v1747126064646!5m2!1svi!2s\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 'Google Maps Embed', 'textarea', 'contact', 10, '2025-04-24 16:01:21', '2025-05-13 15:48:01'),
(11, 'site_primary_color', '#0d6efd', 'Màu chủ đạo', 'color', 'appearance', 11, '2025-04-24 16:01:21', NULL),
(12, 'site_enable_appointment', '1', 'Bật/tắt chức năng đặt lịch khám', 'boolean', 'feature', 12, '2025-04-24 16:01:21', NULL),
(13, 'primary_color', '#005bac', 'Màu chính của trang web', 'color', 'appearance', 10, '2025-04-24 20:33:27', NULL),
(14, 'secondary_color', '#6c757d', 'Màu phụ của trang web', 'color', 'appearance', 20, '2025-04-24 20:33:27', NULL),
(15, 'accent_color', '#28a745', 'Màu nhấn của trang web', 'color', 'appearance', 30, '2025-04-24 20:33:27', NULL),
(16, 'font_family', 'Roboto, sans-serif', 'Font chữ chính của trang web', 'text', 'appearance', 40, '2025-04-24 20:33:27', NULL),
(17, 'header_bg_color', '#ffffff', 'Màu nền của header', 'color', 'appearance', 50, '2025-04-24 20:33:27', NULL),
(18, 'footer_bg_color', '#f8f9fa', 'Màu nền của footer', 'color', 'appearance', 60, '2025-04-24 20:33:27', NULL),
(19, 'banner_title', 'Đặt lịch khám trực tuyến', 'Tiêu đề banner trang chủ', 'text', 'feature', 10, '2025-04-24 20:33:27', NULL),
(20, 'banner_subtitle', 'Dễ dàng - Nhanh chóng - Tiện lợi', 'Mô tả ngắn banner trang chủ', 'text', 'feature', 20, '2025-04-24 20:33:27', NULL),
(21, 'banner_image', 'assets/img/banner.jpg', 'Ảnh nền của banner trang chủ', 'image', 'feature', 30, '2025-04-24 20:33:27', NULL),
(27, 'site_twitter', 'https://twitter.com/nhakhoat&a', 'Link Twitter', 'text', 'social', 20, '2025-04-24 20:33:27', '2025-05-12 23:02:07'),
(28, 'site_instagram', 'https://instagram.com/nhakhoat&a', 'Link Instagram', 'text', 'social', 30, '2025-04-24 20:33:27', '2025-05-12 23:02:07'),
(29, 'site_youtube', 'https://youtube.com/nhakhoat&a', 'Link YouTube', 'text', 'social', 40, '2025-04-24 20:33:27', '2025-05-12 23:02:07'),
(31, 'site_keywords', 'phòng khám nha khoa , đặt lịch khám, bác sĩ, chuyên khoa, dịch vụ y tế, Gò Vấp , TP.HCM', 'Từ khóa SEO', 'text', 'general', 30, '2025-04-24 20:33:27', '2025-05-12 23:00:07'),
(32, 'enable_booking', '1', 'Cho phép đặt lịch khám', 'boolean', 'feature', 10, '2025-04-24 20:33:27', NULL),
(33, 'enable_registration', '1', 'Cho phép đăng ký tài khoản mới', 'boolean', 'feature', 20, '2025-04-24 20:33:27', NULL),
(34, 'auto_confirm_booking', '1', 'Tự động xác nhận đặt lịch', 'boolean', 'feature', 30, '2025-04-24 20:33:27', '2025-05-12 23:04:48'),
(65, 'about_image', 'assets/img/anh-gioithieu.jpg', 'Ảnh trang giới thiệu', 'image', 'feature', 40, '2025-04-24 21:04:36', NULL),
(66, 'about_content', 'Chào mừng bạn đến với Nha khoa T&A – nơi chăm sóc nụ cười của bạn bằng sự tận tâm, chuyên môn và công nghệ hiện đại.\r\n\r\nChúng tôi tự hào là địa chỉ nha khoa uy tín, cung cấp đầy đủ các dịch vụ từ khám – điều trị – phục hình – thẩm mỹ nha khoa, với đội ngũ bác sĩ giàu kinh nghiệm và trang thiết bị tiên tiến.\r\n\r\nTại T&A, mỗi khách hàng đều được tư vấn và lên phác đồ điều trị cá nhân hóa, đảm bảo hiệu quả, an toàn và tối ưu chi phí. Dù bạn đang tìm kiếm giải pháp cho răng sâu, mất răng, lệch khớp cắn, hay mong muốn có nụ cười trắng sáng tự nhiên, chúng tôi luôn sẵn sàng đồng hành cùng bạn.\r\n\r\nNha khoa T&A – Đồng hành vì nụ cười khỏe mạnh, tự tin và rạng rỡ!', 'Nội dung trang giới thiệu', 'textarea', 'feature', 50, '2025-04-24 21:04:36', '2025-05-12 23:04:48'),
(67, 'site_hotline', '0944 492 947', 'Số hotline khẩn cấp', 'text', 'contact', 25, '2025-04-24 21:04:36', '2025-05-12 23:01:29'),
(68, 'site_support_phone', '012 345 6789', 'Số điện thoại tư vấn', 'text', 'contact', 26, '2025-04-24 21:04:36', NULL),
(69, 'site_support_email', 'support@trongtin.com', 'Email hỗ trợ', 'text', 'contact', 35, '2025-04-24 21:04:36', '2025-05-12 23:01:29'),
(70, 'site_advise_email', 'tuvan@trongtin.com', 'Email tư vấn', 'text', 'contact', 36, '2025-04-24 21:04:36', '2025-05-12 23:01:29'),
(71, 'contact_image', 'assets/img/anh-gioithieu.jpg', 'Ảnh nền trang liên hệ', 'image', 'feature', 60, '2025-04-24 21:04:36', NULL),
(72, 'service_title', 'Dịch vụ nha khoa', 'Tiêu đề trang dịch vụ', 'text', 'feature', 70, '2025-04-24 21:04:36', '2025-05-12 23:04:48'),
(73, 'service_subtitle', 'Chăm sóc sức khỏe răng toàn diện với đội ngũ bác sĩ chuyên nghiệp', 'Mô tả ngắn trang dịch vụ', 'text', 'feature', 80, '2025-04-24 21:04:36', '2025-05-12 23:04:48'),
(74, 'service_banner_image', '', 'Ảnh banner trang dịch vụ', 'image', 'feature', 90, '2025-04-24 21:04:36', NULL),
(75, 'doctors_title', 'Đội ngũ bác sĩ nha khoa', 'Tiêu đề trang bác sĩ', 'text', 'feature', 100, '2025-04-24 21:04:36', '2025-05-13 15:49:18'),
(76, 'doctors_subtitle', 'Các bác sĩ chuyên nghiệp và giàu kinh nghiệm của chúng tôi', 'Mô tả ngắn trang bác sĩ', 'text', 'feature', 110, '2025-04-24 21:04:36', NULL),
(77, 'doctors_banner_image', '', 'Ảnh banner trang bác sĩ', 'image', 'feature', 120, '2025-04-24 21:04:36', NULL),
(78, 'specialties_title', 'Chuyên khoa', 'Tiêu đề trang chuyên khoa', 'text', 'feature', 130, '2025-04-24 21:04:36', NULL),
(79, 'specialties_subtitle', 'Các chuyên khoa khám và điều trị tại phòng khám', 'Mô tả ngắn trang chuyên khoa', 'text', 'feature', 140, '2025-04-24 21:04:36', NULL),
(80, 'specialties_banner_image', '', 'Ảnh banner trang chuyên khoa', 'image', 'feature', 150, '2025-04-24 21:04:36', NULL),
(88, 'smtp_host', 'smtp.gmail.com', 'Địa chỉ máy chủ SMTP', '', 'text', 1, '2025-04-27 23:06:33', '2025-04-28 00:23:57'),
(89, 'smtp_port', '587', 'Cổng SMTP', '', 'number', 2, '2025-04-27 23:06:33', NULL),
(90, 'smtp_encryption', 'tls', 'Phương thức mã hóa', '', 'select', 3, '2025-04-27 23:06:33', NULL),
(91, 'smtp_username', 'trongtinacong@gmail.com', 'Tài khoản email gửi', '', 'text', 4, '2025-04-27 23:06:33', '2025-05-12 23:00:07'),
(92, 'smtp_password', 'bsmu qgir tnpl zkse', 'Mật khẩu email', '', 'password', 5, '2025-04-27 23:06:33', '2025-04-28 01:02:32'),
(93, 'email_from_name', 'Phòng khám Lộc Bình', 'Tên người gửi email', '', 'text', 6, '2025-04-27 23:06:33', NULL),
(94, 'email_test', '', 'Email nhận thử nghiệm', '', 'text', 7, '2025-04-27 23:06:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` int(11) NOT NULL,
  `sender` enum('user','admin') NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat_messages`
--

INSERT INTO `chat_messages` (`id`, `sender`, `message`, `created_at`) VALUES
(4, 'user', 'xin chào tôi cần giúp đỡ', '2025-05-16 19:41:23');

-- --------------------------------------------------------

--
-- Table structure for table `chitieu`
--

CREATE TABLE `chitieu` (
  `id` int(11) NOT NULL,
  `thang` int(11) NOT NULL,
  `loai` varchar(100) DEFAULT NULL,
  `ten` varchar(255) DEFAULT NULL,
  `so_luong` int(11) DEFAULT 1,
  `gia` decimal(15,2) DEFAULT NULL,
  `ngay` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chitieu`
--

INSERT INTO `chitieu` (`id`, `thang`, `loai`, `ten`, `so_luong`, `gia`, `ngay`) VALUES
(1, 2, 'dịch vụ', 'Nhổ răng', 2, 5000000.00, '2025-02-02'),
(2, 5, 'dịch vụ', 'Khám răng', 3, 666666.00, '2025-05-10'),
(3, 8, 'thuốc', 'Thuốc tê', 5, 200000.00, '2025-08-15');

-- --------------------------------------------------------

--
-- Table structure for table `chuyenkhoa`
--

CREATE TABLE `chuyenkhoa` (
  `id` int(11) NOT NULL,
  `ten_chuyenkhoa` varchar(100) NOT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `mota` text DEFAULT NULL,
  `hinh_anh` varchar(255) DEFAULT NULL,
  `ngay_tao` datetime DEFAULT current_timestamp(),
  `ngay_capnhat` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chuyenkhoa`
--

INSERT INTO `chuyenkhoa` (`id`, `ten_chuyenkhoa`, `icon`, `mota`, `hinh_anh`, `ngay_tao`, `ngay_capnhat`) VALUES
(1, 'Khám răng tổng quát', 'fa-heart', 'Là bước kiểm tra định kỳ toàn bộ khoang miệng: răng, nướu, khớp cắn... nhằm phát hiện sớm các vấn đề như sâu răng, viêm nướu, cao răng, răng khôn, lệch hàm,...', 'assets/img/chuyenkhoa/1747065438_khamtongquat.jpg', '2025-04-24 16:01:21', '2025-05-12 22:57:18'),
(2, 'Niềng răng mắc cài', '', 'Là phương pháp chỉnh nha truyền thống sử dụng hệ thống mắc cài và dây cung để dịch chuyển răng về đúng vị trí. Hiệu quả cao trong các trường hợp răng lệch lạc, hô, móm, chen chúc hoặc sai khớp cắn. Có nhiều loại như mắc cài kim loại, mắc cài sứ và mắc cài tự đóng.', 'assets/img/chuyenkhoa/1747065343_niengrangmaccai.jpg', '2025-04-24 16:01:21', '2025-05-12 23:06:30'),
(3, 'Bọc răng sứ', 'fa-allergies', 'Bọc răng sứ là phương pháp phục hình thẩm mỹ, giúp cải thiện hình dạng, màu sắc và chức năng của răng. Bác sĩ sẽ mài bớt lớp men răng bên ngoài, sau đó chụp một mão răng sứ được thiết kế riêng lên trên răng thật. Răng sứ có độ bền cao, màu sắc tự nhiên như răng thật và có thể tồn tại từ 10–15 năm nếu chăm sóc đúng cách.', 'assets/img/chuyenkhoa/1747065119_bocrangsu.jpg', '2025-04-24 16:01:21', '2025-05-12 22:51:59'),
(4, 'Niềng răng trong suốt ', 'fa-stethoscope', 'Niềng răng trong suốt (hay Invisalign) là phương pháp chỉnh nha hiện đại sử dụng các khay niềng bằng nhựa trong suốt, được thiết kế riêng theo cấu trúc răng của từng người. Các khay này sẽ nhẹ nhàng dịch chuyển răng về đúng vị trí mà không cần mắc cài hay dây kim loại.', 'assets/img/chuyenkhoa/1747065373_niengrangtrongsuot.jpg', '2025-04-24 16:01:21', '2025-05-12 23:07:37'),
(5, 'Trồng răng Implant', 'fa-eye', 'Trồng răng Implant là phương pháp phục hình răng mất hiện đại nhất hiện nay, sử dụng trụ titanium cấy trực tiếp vào xương hàm để thay thế cho chân răng thật. Sau khi trụ Implant tích hợp ổn định với xương, bác sĩ sẽ gắn mão răng sứ lên trên, tạo thành chiếc răng hoàn chỉnh cả về thẩm mỹ lẫn chức năng.', 'assets/img/chuyenkhoa/1747065235_trongrangimplant.jpg', '2025-04-24 16:01:21', '2025-05-12 22:53:55'),
(10, 'Nhổ răng thường', NULL, 'Là thủ thuật loại bỏ răng bị hư hỏng nặng, mọc lệch (răng khôn), hoặc hỗ trợ điều trị chỉnh nha. Quy trình được thực hiện an toàn, vô trùng và nhanh chóng, đảm bảo hạn chế đau và biến chứng.', 'assets/img/chuyenkhoa/1747065412_nhorangthuong.jpg', '2025-04-27 20:54:01', '2025-05-12 22:56:52');

-- --------------------------------------------------------

--
-- Table structure for table `dichvu`
--

CREATE TABLE `dichvu` (
  `id` int(11) NOT NULL,
  `ten_dichvu` varchar(150) NOT NULL,
  `chuyenkhoa_id` int(11) DEFAULT NULL,
  `gia_coban` decimal(10,2) NOT NULL,
  `hinh_anh` varchar(255) DEFAULT NULL,
  `mota_ngan` text DEFAULT NULL,
  `chi_tiet` text DEFAULT NULL,
  `trangthai` tinyint(4) DEFAULT 1,
  `ngay_tao` datetime DEFAULT current_timestamp(),
  `ngay_capnhat` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dichvu`
--

INSERT INTO `dichvu` (`id`, `ten_dichvu`, `chuyenkhoa_id`, `gia_coban`, `hinh_anh`, `mota_ngan`, `chi_tiet`, `trangthai`, `ngay_tao`, `ngay_capnhat`) VALUES
(7, 'Bọc răng sứ thẩm mỹ toàn hàm', 3, 40000000.00, 'assets/img/services/1747066703_images.jpg', 'Là phương pháp bọc sứ cho toàn bộ các răng hàm trên, hàm dưới (hoặc cả hai) nhằm cải thiện thẩm mỹ, màu sắc và khớp cắn.', 'Khám, tư vấn dáng răng – màu răng theo gương mặt.\r\n\r\nMài răng nhẹ và lấy dấu.\r\n\r\nGắn răng tạm (thử thẩm mỹ trước khi làm răng thật).\r\n\r\nLắp răng sứ vĩnh viễn.', 1, '2025-05-12 23:18:23', '2025-05-13 11:22:22'),
(8, 'Thay mão sứ cũ', 3, 2000000.00, 'assets/img/services/1747066761_images (1).jpg', 'Loại bỏ mão sứ đã hư, đổi màu, không khít hoặc gây viêm nướu – thay bằng mão sứ mới thẩm mỹ và bền chắc hơn.', 'Khám và đánh giá mão sứ hiện tại.\r\n\r\nGỡ mão sứ cũ bằng dụng cụ chuyên dụng.\r\n\r\nVệ sinh, xử lý cùi răng.\r\n\r\nLấy dấu và gắn răng tạm.\r\n\r\nLắp mão sứ mới (zirconia, sứ Emax...).', 1, '2025-05-12 23:19:21', '2025-05-13 11:22:09'),
(9, 'Cấy ghép Implant đơn lẻ', 5, 18000000.00, 'assets/img/services/1747066862_images (3).jpg', 'Là phương pháp phục hồi 1 răng đã mất bằng cách cấy trụ titanium vào xương hàm, sau đó gắn răng sứ lên trên.', 'Thăm khám, chụp phim 3D CT Cone Beam.\r\n\r\nLập kế hoạch điều trị, chọn loại trụ Implant.\r\n\r\nGây tê và cấy trụ Implant vào xương hàm.\r\n\r\nĐợi tích hợp xương (2–6 tháng).\r\n\r\nGắn Abutment + mão răng sứ.', 1, '2025-05-12 23:21:02', '2025-05-13 11:21:54'),
(10, 'Ghép xương hàm, nâng xoang (hỗ trợ Implant)', 5, 5000000.00, 'assets/img/services/1747066894_images (2).jpg', 'Bù đắp phần xương bị tiêu sau mất răng để đủ điều kiện cấy Implant.', 'Tăng chiều cao xương hàm trên (vùng gần xoang hàm) để đủ trụ Implant.\r\n\r\nNâng xoang kín (ít xâm lấn).\r\n\r\nNâng xoang hở (với vùng xương quá mỏng).\r\n\r\nThời gian lành thương: 4–6 tháng.', 1, '2025-05-12 23:21:34', '2025-05-13 11:21:42'),
(11, 'Niềng răng mắc cài kim loại thường', 2, 25000000.00, 'assets/img/services/1747066966_images (4).jpg', 'Sử dụng hệ thống mắc cài và dây cung bằng kim loại để kéo răng về vị trí đúng.', 'Hiệu quả cao, ổn định.\r\n\r\nChi phí thấp nhất trong các loại niềng.\r\n\r\nCó thể nhìn thấy rõ mắc cài khi cười, nói.\r\n\r\nPhù hợp: Từ lệch nhẹ đến lệch nặng, kể cả sai khớp cắn.\r\n\r\nThời gian điều trị: 18–24 tháng.', 1, '2025-05-12 23:22:46', '2025-05-13 11:21:24'),
(12, 'Niềng răng chỉnh khớp cắn hô, móm, lệch lạc', 2, 50000000.00, 'assets/img/services/1747067011_nieng-rang-mac-cai-kim-loai-1.jpg', 'Phương pháp điều chỉnh các sai lệch khớp cắn nghiêm trọng', 'Niềng mắc cài (kim loại, sứ).\r\n\r\nNiềng trong suốt (Invisalign, Clear Aligner).\r\n\r\nThời gian điều trị: 18–30 tháng, tùy độ nặng.\r\n\r\nCó thể cần: nhổ răng, minivis, hoặc phẫu thuật hàm phối hợp (trường hợp nặng)', 1, '2025-05-12 23:23:31', '2025-05-13 11:21:12'),
(13, 'Niềng răng Clear Aligner', 4, 30000000.00, 'assets/img/services/1747067168_nieng-rang-trong-suot-1.jpg', 'Hệ thống niềng răng trong suốt sử dụng các khay nhựa thiết kế riêng biệt, thường được sản xuất nội địa (ví dụ eCligner, 3D Clear...).', 'Phù hợp: Lệch lạc nhẹ đến trung bình.\r\n\r\nThời gian điều trị: ~12–18 tháng.\r\n\r\nThẩm mỹ cao, dễ tháo lắp.\r\n\r\nChi phí thấp hơn Invisalign.\r\n\r\nLưu ý: Hiệu quả phụ thuộc vào mức độ lệch và sự tuân thủ đeo khay đủ giờ/ngày.', 1, '2025-05-12 23:26:08', '2025-05-13 11:19:37'),
(16, 'Niềng răng trong suốt Invisalign cấp độ nhẹ – trung bình – phức tạp', 4, 42000000.00, 'assets/img/services/1747067249_20230203_nieng-rang-trong-suot-1.jpg', 'Niềng răng trong suốt Invisalign là phương pháp niềng răng không dùng đến mắc cài', 'Trong suốt, gần như không nhìn thấy.\r\n\r\nCó thể tháo ra khi ăn và vệ sinh.\r\n\r\nÍt đau, ít tái khám hơn so với mắc cài.', 1, '2025-05-12 23:27:29', '2025-05-13 11:19:06'),
(17, 'Nhổ răng sữa (cho trẻ em)', 10, 200000.00, 'assets/img/services/1747109394_Nha-trẻ-em-1.png', 'Loại bỏ răng sữa đã đến thời kỳ thay nhưng chưa rụng hoặc mọc lệch, gây cản trở răng vĩnh viễn mọc đúng vị trí.', 'Khám tổng quát và tư vấn cho phụ huynh.\r\n\r\nGây tê nhẹ bằng gel hoặc thuốc xịt (hạn chế đau).\r\n\r\nNhổ răng bằng dụng cụ chuyên dụng dành cho trẻ.\r\n\r\nTheo dõi, hướng dẫn chăm sóc sau nhổ.\r\n\r\nƯu điểm: Nhanh chóng, nhẹ nhàng, an toàn cho trẻ nhỏ.', 1, '2025-05-12 23:29:06', '2025-05-13 11:18:50'),
(18, 'Nhổ răng vĩnh viễn (sâu hư, lung lay, nứt gãy...)', 10, 500000.00, 'assets/img/services/1747067376_co-nhat-thiet-phai-nho-rang-sau-khong.png', 'Loại bỏ răng không còn khả năng phục hồi để tránh ảnh hưởng các răng khác hoặc gây viêm nhiễm.', 'Thăm khám, chụp X-quang kiểm tra tình trạng răng.\r\n\r\nGây tê tại chỗ.\r\n\r\nDùng kìm và bẩy để nhổ răng.\r\n\r\nKiểm tra ổ răng và cầm máu.\r\n\r\nHướng dẫn chăm sóc sau nhổ và kê thuốc giảm đau, kháng sinh nếu cần.\r\n\r\nThời gian thực hiện: 15–30 phút/răng.\r\n\r\n', 1, '2025-05-12 23:29:36', '2025-05-13 11:08:02'),
(19, 'Nhổ răng khôn mọc lệch, mọc ngầm', 10, 1000000.00, 'assets/img/services/1747067396_20200917_rang-khon-02.jpg', 'Loại bỏ răng khôn gây đau nhức, viêm nướu, hoặc đe dọa đến các răng kế cận.', 'Khám và chụp X-quang để xác định vị trí răng.\r\n\r\nGây tê hoặc gây mê cục bộ.\r\n\r\nTiểu phẫu nhổ răng bằng dụng cụ chuyên dụng.\r\n\r\nKhâu vết thương và kê đơn thuốc sau nhổ.\r\n\r\nThời gian thực hiện: 30–60 phút/răng.\r\n\r\nLưu ý sau nhổ: Nghỉ ngơi, chườm lạnh, dùng thuốc đúng liều.', 0, '2025-05-12 23:29:56', '2025-05-13 11:18:34'),
(20, 'Khám, tư vấn sức khỏe răng miệng định kỳ', 1, 200000.00, 'assets/img/services/1747067490_quy-trinh-kham-nha-khoa-tong-quat-tai-trung-tam-nha-khoa-ngoc-trai-2.png', 'Kiểm tra tổng quát sức khỏe răng miệng, bao gồm răng, nướu, lưỡi và khoang miệng.', 'Khám lâm sàng bằng mắt và dụng cụ chuyên dụng.\r\n\r\nChụp X-quang (nếu cần) để phát hiện sâu răng, viêm chân răng, xương hàm…\r\n\r\nTư vấn về tình trạng răng miệng hiện tại.\r\n\r\nHướng dẫn vệ sinh răng miệng đúng cách.\r\n\r\nLập kế hoạch điều trị (nếu có vấn đề phát hiện).\r\n\r\nTần suất khuyến nghị: 6 tháng/lần.', 1, '2025-05-12 23:31:30', '2025-05-13 11:18:12'),
(21, 'Lấy cao răng, đánh bóng răng', 1, 300000.00, 'assets/img/services/1747067534_quy-trinh-boc-rang-su.png', 'Loại bỏ mảng bám và vết ố trên răng, giúp răng sạch hơn, sáng hơn và ngăn ngừa viêm nướu.', '\r\nLoại bỏ cao răng (vôi răng) bám quanh thân răng và dưới nướu – nguyên nhân chính gây viêm nướu, tụt lợi, hôi miệng. \r\n\r\nThời gian thực hiện: 15–30 phút\r\n\r\nTần suất khuyến nghị: 3–6 tháng/lần\r\nNgăn ngừa viêm nướu, nha chu\r\nGiúp răng sạch, sáng, hơi thở thơm mát\r\nHạn chế ố vàng do mảng bám lâu ngày', 1, '2025-05-12 23:32:14', '2025-05-13 11:18:01');

-- --------------------------------------------------------

--
-- Table structure for table `don_thuoc`
--

CREATE TABLE `don_thuoc` (
  `id` int(11) NOT NULL,
  `lichhen_id` int(11) NOT NULL,
  `thuoc_id` int(11) NOT NULL,
  `lieu_dung` varchar(100) NOT NULL,
  `so_luong` int(11) NOT NULL,
  `cach_dung` text DEFAULT NULL,
  `ngay_tao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `don_thuoc`
--

INSERT INTO `don_thuoc` (`id`, `lichhen_id`, `thuoc_id`, `lieu_dung`, `so_luong`, `cach_dung`, `ngay_tao`) VALUES
(1, 4, 4, '1 viên/ngày', 10, 'Uống sau bữa ăn sáng', '2025-04-24 16:01:21'),
(2, 4, 1, '1 viên x 3 lần/ngày', 30, 'Uống sau bữa ăn', '2025-04-24 16:01:21');

-- --------------------------------------------------------

--
-- Table structure for table `ketqua_kham`
--

CREATE TABLE `ketqua_kham` (
  `id` int(11) NOT NULL,
  `lichhen_id` int(11) NOT NULL,
  `chan_doan` text NOT NULL,
  `mo_ta` text DEFAULT NULL,
  `don_thuoc` text DEFAULT NULL,
  `ghi_chu` text DEFAULT NULL,
  `ngay_tao` datetime DEFAULT current_timestamp(),
  `ngay_capnhat` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ketqua_kham`
--

INSERT INTO `ketqua_kham` (`id`, `lichhen_id`, `chan_doan`, `mo_ta`, `don_thuoc`, `ghi_chu`, `ngay_tao`, `ngay_capnhat`) VALUES
(1, 4, 'Viêm da dị ứng', 'Phát ban đỏ trên vùng cổ và tay', NULL, 'Nên tránh tiếp xúc với chất tẩy rửa có hóa chất mạnh', '2025-04-24 16:01:21', NULL),
(2, 6, 'tốt', 'fdasf', 'fadsf', 'fadsfsdf', '2025-04-24 17:10:14', NULL),
(3, 14, 'đau răng', 'răng sâu', '1 liều thuốc đau răng', 'đánh răng', '2025-05-14 12:57:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lichhen`
--

CREATE TABLE `lichhen` (
  `id` int(11) NOT NULL,
  `ma_lichhen` varchar(20) NOT NULL,
  `benhnhan_id` int(11) NOT NULL,
  `bacsi_id` int(11) NOT NULL,
  `dichvu_id` int(11) DEFAULT NULL,
  `ngay_hen` date NOT NULL,
  `gio_hen` time NOT NULL,
  `ly_do` text DEFAULT NULL,
  `phi_kham` decimal(10,2) DEFAULT NULL,
  `trang_thai` enum('pending','confirmed','completed','cancelled') DEFAULT 'pending',
  `thoi_diem_hoanthanh` datetime DEFAULT NULL,
  `thoi_diem_huy` datetime DEFAULT NULL,
  `ghi_chu` text DEFAULT NULL,
  `phong_kham` varchar(50) DEFAULT NULL,
  `ngay_tao` datetime DEFAULT current_timestamp(),
  `ngay_capnhat` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lichhen`
--

INSERT INTO `lichhen` (`id`, `ma_lichhen`, `benhnhan_id`, `bacsi_id`, `dichvu_id`, `ngay_hen`, `gio_hen`, `ly_do`, `phi_kham`, `trang_thai`, `thoi_diem_hoanthanh`, `thoi_diem_huy`, `ghi_chu`, `phong_kham`, `ngay_tao`, `ngay_capnhat`) VALUES
(1, 'APT12345', 1, 1, NULL, '2025-04-24', '09:00:00', 'Đau ngực khi vận động', 500000.00, 'pending', NULL, NULL, NULL, 'Phòng 101', '2025-04-24 16:01:21', NULL),
(2, 'APT12346', 2, 5, NULL, '2025-04-25', '10:30:00', 'Giảm thị lực', 450000.00, 'confirmed', NULL, NULL, NULL, 'Phòng 202', '2025-04-24 16:01:21', NULL),
(3, 'APT12347', 3, 4, NULL, '2025-04-26', '14:00:00', 'Khám sức khỏe định kỳ', 600000.00, 'confirmed', NULL, NULL, NULL, 'Phòng 301', '2025-04-24 16:01:21', NULL),
(4, 'APT12348', 4, 3, NULL, '2025-04-17', '08:00:00', 'Nổi mẩn đỏ trên da', 400000.00, 'completed', NULL, NULL, NULL, 'Phòng 105', '2025-04-24 16:01:21', NULL),
(5, 'APT12349', 1, 2, NULL, '2025-04-10', '15:30:00', 'Kiểm tra sức khỏe tổng quát', 300000.00, 'cancelled', NULL, NULL, NULL, 'Phòng 201', '2025-04-24 16:01:21', NULL),
(6, 'APT8EF930F2', 6, 6, NULL, '2025-04-25', '10:30:00', 'đau mũi', 500000.00, 'completed', '2025-04-24 17:10:14', NULL, NULL, NULL, '2025-04-24 16:48:31', '2025-04-24 17:10:14'),
(7, 'APTCE048D4A', 6, 6, NULL, '2025-04-26', '09:30:00', 'fadsfadsfasdfadsf', 500000.00, 'cancelled', NULL, '2025-04-27 20:52:25', 'Muốn thay đổi cơ sở y tế', NULL, '2025-04-24 21:38:24', '2025-04-27 20:52:25'),
(8, 'APT83140159', 6, 2, NULL, '2025-04-27', '09:30:00', 'fadsfasdfadsfadsfas', 300000.00, 'cancelled', NULL, '2025-04-27 20:51:49', 'Đã khỏi bệnh', NULL, '2025-04-26 00:36:49', '2025-04-27 20:51:49'),
(9, 'APT5B6510F4', 7, 2, NULL, '2025-04-28', '09:30:00', 'fdasfdasfadsfadsfadsfasfadsf', 300000.00, 'pending', NULL, NULL, NULL, NULL, '2025-04-27 20:48:38', NULL),
(10, 'APT140F157C', 8, 6, NULL, '2025-04-29', '10:00:00', 'fdsafadsfads', 450000.00, 'confirmed', NULL, NULL, NULL, NULL, '2025-04-27 23:54:24', '2025-04-28 01:04:02'),
(11, 'APT65E89E6F', 9, 6, NULL, '2025-05-16', '14:30:00', 'fdsafasdfadsfasdf', 450000.00, 'confirmed', NULL, NULL, NULL, NULL, '2025-05-07 20:55:42', '2025-05-07 20:56:04'),
(12, 'APT89FBC10F', 11, 1, 7, '2025-05-30', '14:30:00', 'đau răng hàm mặt', 1500000.00, 'pending', NULL, NULL, NULL, NULL, '2025-05-12 23:58:07', NULL),
(13, 'APT8E128B23', 10, 4, 21, '2025-05-13', '16:00:00', 'đau răng hàm mặt', 1000000.00, 'pending', NULL, NULL, NULL, NULL, '2025-05-12 23:59:13', NULL),
(14, 'APT84312B24', 10, 8, 8, '2025-05-14', '15:00:00', 'đau răng', 2000000.00, 'completed', '2025-05-14 12:57:49', NULL, NULL, NULL, '2025-05-13 15:52:19', '2025-05-14 12:57:49'),
(15, 'APT1DADE5B2', 12, 7, 10, '2025-05-17', '15:00:00', '123', 5000000.00, 'pending', NULL, NULL, NULL, NULL, '2025-05-16 20:47:06', NULL),
(16, 'APT26471A4C', 13, 8, 7, '2025-05-16', '08:00:00', '1', 40000000.00, 'confirmed', NULL, NULL, NULL, NULL, '2025-05-16 20:49:24', '2025-05-16 20:50:19'),
(17, 'APT120001', 1, 2, NULL, '2025-06-01', '09:00:00', 'Khám tổng quát', 300000.00, 'confirmed', NULL, NULL, 'Vui lòng đến đúng giờ.', 'Phòng 101', '2025-05-19 01:43:18', NULL),
(18, 'APT120002', 3, 4, NULL, '2025-06-02', '10:30:00', 'Đau răng', 250000.00, 'pending', NULL, NULL, NULL, 'Phòng 202', '2025-05-19 01:43:18', NULL),
(19, 'APT120003', 2, 1, NULL, '2025-06-03', '11:00:00', 'Tư vấn dinh dưỡng', 350000.00, 'confirmed', NULL, NULL, 'Vui lòng đến đúng giờ.', 'Phòng 303', '2025-05-19 01:43:18', NULL),
(20, 'APT120004', 5, 3, NULL, '2025-06-04', '08:30:00', 'Khám định kỳ', 300000.00, 'completed', '2025-06-04 08:30:00', NULL, NULL, 'Phòng 404', '2025-05-19 01:43:18', NULL),
(21, 'APT120005', 6, 2, NULL, '2025-06-05', '14:00:00', 'Đau răng', 400000.00, 'pending', NULL, NULL, NULL, 'Phòng 505', '2025-05-19 01:43:18', NULL),
(22, 'APT120006', 4, 5, NULL, '2025-06-06', '13:30:00', 'Khám chuyên khoa', 250000.00, 'cancelled', NULL, '2025-06-06 13:30:00', 'Vui lòng đến đúng giờ.', 'Phòng 101', '2025-05-19 01:43:18', NULL),
(23, 'APT120007', 7, 6, NULL, '2025-06-07', '09:30:00', 'Tư vấn dinh dưỡng', 300000.00, 'confirmed', NULL, NULL, NULL, 'Phòng 202', '2025-05-19 01:43:18', NULL),
(24, 'APT120008', 8, 1, NULL, '2025-06-08', '15:00:00', 'Khám tổng quát', 200000.00, 'pending', NULL, NULL, NULL, 'Phòng 303', '2025-05-19 01:43:18', NULL),
(25, 'APT120009', 9, 3, NULL, '2025-06-09', '10:00:00', 'Đau răng', 250000.00, 'completed', '2025-06-09 10:00:00', NULL, NULL, 'Phòng 404', '2025-05-19 01:43:18', NULL),
(26, 'APT120010', 10, 7, NULL, '2025-06-10', '08:00:00', 'Khám chuyên khoa', 350000.00, 'pending', NULL, NULL, NULL, 'Phòng 505', '2025-05-19 01:43:18', NULL),
(27, 'APT120011', 11, 2, NULL, '2025-06-11', '09:45:00', 'Khám tổng quát', 300000.00, 'confirmed', NULL, NULL, NULL, 'Phòng 101', '2025-05-19 01:43:18', NULL),
(28, 'APT120012', 12, 5, NULL, '2025-06-12', '16:00:00', 'Tư vấn dinh dưỡng', 200000.00, 'cancelled', NULL, '2025-06-12 16:00:00', 'Vui lòng đến đúng giờ.', 'Phòng 202', '2025-05-19 01:43:18', NULL),
(29, 'APT120013', 13, 8, NULL, '2025-06-13', '11:30:00', 'Khám định kỳ', 250000.00, 'completed', '2025-06-13 11:30:00', NULL, NULL, 'Phòng 303', '2025-05-19 01:43:18', NULL),
(30, 'APT120014', 2, 4, NULL, '2025-06-14', '14:30:00', 'Khám chuyên khoa', 300000.00, 'pending', NULL, NULL, NULL, 'Phòng 404', '2025-05-19 01:43:18', NULL),
(31, 'APT120015', 3, 6, NULL, '2025-06-15', '13:00:00', 'Đau răng', 350000.00, 'confirmed', NULL, NULL, 'Vui lòng đến đúng giờ.', 'Phòng 505', '2025-05-19 01:43:18', NULL),
(32, 'APT120016', 4, 1, NULL, '2025-06-16', '09:00:00', 'Khám tổng quát', 300000.00, 'pending', NULL, NULL, NULL, 'Phòng 101', '2025-05-19 01:43:18', NULL),
(33, 'APT120017', 5, 2, NULL, '2025-06-17', '10:30:00', 'Tư vấn dinh dưỡng', 250000.00, 'completed', '2025-06-17 10:30:00', NULL, NULL, 'Phòng 202', '2025-05-19 01:43:18', NULL),
(34, 'APT120018', 6, 3, NULL, '2025-06-18', '11:00:00', 'Khám định kỳ', 400000.00, 'confirmed', NULL, NULL, NULL, 'Phòng 303', '2025-05-19 01:43:18', NULL),
(35, 'APT120019', 7, 4, NULL, '2025-06-19', '08:30:00', 'Đau răng', 200000.00, 'cancelled', NULL, '2025-06-19 08:30:00', 'Vui lòng đến đúng giờ.', 'Phòng 404', '2025-05-19 01:43:18', NULL),
(36, 'APT120020', 8, 5, NULL, '2025-06-20', '14:00:00', 'Khám chuyên khoa', 300000.00, 'pending', NULL, NULL, NULL, 'Phòng 505', '2025-05-19 01:43:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `nguoidung`
--

CREATE TABLE `nguoidung` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mat_khau` varchar(255) NOT NULL,
  `vai_tro` enum('admin','bacsi','benhnhan','nhanvien') NOT NULL,
  `trang_thai` tinyint(4) DEFAULT 1,
  `ngay_tao` datetime DEFAULT current_timestamp(),
  `ngay_capnhat` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nguoidung`
--

INSERT INTO `nguoidung` (`id`, `email`, `mat_khau`, `vai_tro`, `trang_thai`, `ngay_tao`, `ngay_capnhat`) VALUES
(1, 'admin@example.com', '$2y$10$HsrH9Jjm1tAx0Ju5WROe5OdajgusFeWiyfsiA9ZsBfeUszs/Byz8q', 'admin', 1, '2025-04-24 16:01:21', '2025-04-24 16:02:22'),
(2, 'abc@gmail.com', '$2y$10$HsrH9Jjm1tAx0Ju5WROe5OdajgusFeWiyfsiA9ZsBfeUszs/Byz8q', 'benhnhan', 1, '2025-04-24 16:02:05', NULL),
(3, 'trancongtien406@gmail.com', '$2y$10$HsrH9Jjm1tAx0Ju5WROe5OdajgusFeWiyfsiA9ZsBfeUszs/Byz8q', 'bacsi', 1, '2025-04-24 16:07:45', '2025-04-24 16:46:41'),
(4, 'user@gmail.com', '$2y$10$KIkI/JzLCxXujore6fsI8.CQ1mTqwZYsxPgjac1cI.NOzL/eUXEaq', 'benhnhan', 1, '2025-04-24 16:47:42', NULL),
(5, 'trancong406@gmail.com', '$2y$10$4E/b3vjAF0ETC9Xph6Q72.yWSJO3bo/Kbje9poNXsvy2pCokXuX5m', 'bacsi', 1, '2025-04-27 21:56:47', NULL),
(6, 'tientc.21it@vku.udn.vn', '$2y$10$.kPlpNXjTCJhZnV5oTJVaubADrLzb2OLJoEYbCpd3FjdkmpNgsLBS', 'benhnhan', 1, '2025-05-07 20:53:07', NULL),
(7, 'trongtinacong@gmail.com', '$2y$10$VVlp0xlnl4XtCQe0gBrSPejOXugJViLESCmxPsqh.yAAjx0M2T23G', 'benhnhan', 1, '2025-05-12 16:29:52', NULL),
(8, 'trongtinabc@gmail.com', '$2y$10$8XEiTJJ5Q2nOPNDieWLY9evhHHcpuvnNx.LcrlBM2uTO6KJwgLJ5q', 'bacsi', 1, '2025-05-13 00:13:28', '2025-05-13 00:15:25'),
(9, 'bs.phuc@example.com', '$2y$10$OOUbBUSMVzOgSKoKwv0HTuNKufFjRRL8usyDsCQUzrm/gHgAD5zcW', 'bacsi', 1, '2025-05-13 16:00:43', NULL),
(10, 'bs.linh@example.com', '$2y$10$nKDBAXOnEfMNH8Mr5dUqL.bgERt8XkRMMG5XPZM4dk0YCPPhvq5ee', 'bacsi', 1, '2025-05-13 16:03:26', NULL),
(11, 'staff@example.com', '$2y$10$0msDAdfhxMPMG/fejZgQg.Tl1fqcvMrT4aTgotEIAM2SxrBKbUVmC', 'nhanvien', 1, '2025-05-19 01:27:38', NULL);


-- --------------------------------------------------------

--
-- Table structure for table `nhanvien`
--

CREATE TABLE `nhanvien` (
  `id` int(11) NOT NULL,
  `nguoidung_id` int(11) DEFAULT NULL,
  `ho_ten` varchar(100) NOT NULL,
  `dien_thoai` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `dia_chi` text DEFAULT NULL,
  `hinh_anh` varchar(255) DEFAULT NULL,
  `ngay_tao` datetime DEFAULT current_timestamp(),
  `ngay_capnhat` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nhanvien`
--

INSERT INTO `nhanvien` (`id`, `nguoidung_id`, `ho_ten`, `dien_thoai`, `email`, `dia_chi`, `hinh_anh`, `ngay_tao`, `ngay_capnhat`) VALUES
(1, 11, 'Nhân Viên Demo', '0987654321', 'staff@example.com', NULL, NULL, '2025-05-19 01:27:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `thuoc`
--

CREATE TABLE `thuoc` (
  `id` int(11) NOT NULL,
  `ten_thuoc` varchar(150) NOT NULL,
  `don_vi` varchar(20) NOT NULL,
  `gia` decimal(10,2) NOT NULL,
  `huong_dan_chung` text DEFAULT NULL,
  `ngay_tao` datetime DEFAULT current_timestamp(),
  `ngay_capnhat` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `thuoc`
--

INSERT INTO `thuoc` (`id`, `ten_thuoc`, `don_vi`, `gia`, `huong_dan_chung`, `ngay_tao`, `ngay_capnhat`) VALUES
(1, 'Paracetamol', 'Viên', 10000.00, 'Giảm đau, hạ sốt', '2025-04-24 16:01:21', NULL),
(2, 'Amoxicillin', 'Viên', 15000.00, 'Kháng sinh điều trị các bệnh nhiễm trùng', '2025-04-24 16:01:21', NULL),
(3, 'Omeprazole', 'Viên', 20000.00, 'Điều trị bệnh dạ dày', '2025-04-24 16:01:21', NULL),
(4, 'Loratadine', 'Viên', 12000.00, 'Trị dị ứng', '2025-04-24 16:01:21', NULL),
(5, 'Simvastatin', 'Viên', 25000.00, 'Giảm cholesterol', '2025-04-24 16:01:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tintuc`
--

CREATE TABLE `tintuc` (
  `id` int(11) NOT NULL,
  `tieu_de` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `danh_muc` varchar(50) NOT NULL,
  `noi_dung` text NOT NULL,
  `hinh_anh` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `trang_thai` enum('published','draft','scheduled') DEFAULT 'draft',
  `luot_xem` int(11) DEFAULT 0,
  `nguoi_tao` int(11) DEFAULT NULL,
  `ngay_dang` datetime DEFAULT NULL,
  `ngay_tao` datetime DEFAULT current_timestamp(),
  `ngay_capnhat` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tintuc`
--

INSERT INTO `tintuc` (`id`, `tieu_de`, `slug`, `danh_muc`, `noi_dung`, `hinh_anh`, `meta_title`, `meta_description`, `tags`, `trang_thai`, `luot_xem`, `nguoi_tao`, `ngay_dang`, `ngay_tao`, `ngay_capnhat`) VALUES
(1, 'Phòng ngừa các bệnh hô hấp mùa nắng nóng', NULL, 'medicine', '<p>Mùa nắng nóng không chỉ là thời điểm gây khó chịu vì nhiệt độ cao mà còn tiềm ẩn nhiều nguy cơ mắc các bệnh về đường hô hấp.&nbsp;</p>', 'assets/img/tintuc/1747068817_blog-4.png', '', '', '', 'draft', 1, NULL, NULL, '2025-04-24 16:01:21', '2025-05-12 23:54:59'),
(2, 'Chế độ ăn cho người bệnh tim mạch', NULL, 'nutrition', '<p>Người bệnh tim mạch cần có chế độ ăn khoa học và lành mạnh để hỗ trợ điều trị bệnh...</p>', NULL, NULL, NULL, NULL, 'published', 4, NULL, '2025-04-24 16:01:21', '2025-04-24 16:01:21', '2025-05-07 20:57:20'),
(3, 'Chăm sóc răng miệng đúng cách', NULL, 'health', '<p>Răng miệng khỏe mạnh là cửa ngõ cho sức khỏe tổng thể. Việc chăm sóc răng miệng đúng cách giúp phòng ngừa nhiều bệnh...</p>', 'assets/img/tintuc/1747068843_blog-3.png', '', '', '', 'published', 1, NULL, '2025-04-24 16:01:21', '2025-04-24 16:01:21', '2025-05-12 23:54:03'),
(4, 'Vaccine mới trong phòng chống các bệnh truyền nhiễm', NULL, 'medicine', '<p>Các loại vaccine mới đã và đang được phát triển nhằm phòng chống hiệu quả các bệnh truyền nhiễm...</p>', NULL, NULL, NULL, NULL, 'scheduled', 0, NULL, '2025-05-01 16:01:21', '2025-04-24 16:01:21', NULL),
(5, 'Yoga và các bài tập thể dục cho người bận rộn', NULL, 'lifestyle', '<p>Với lịch trình bận rộn, nhiều người khó có thời gian để tập thể dục. Bài viết giới thiệu các bài tập yoga ngắn phù hợp cho người bận rộn...</p>', 'assets/img/tintuc/1747068828_blog-5.png', '', '', '', 'draft', 0, NULL, NULL, '2025-04-24 16:01:21', '2025-05-12 23:53:48'),
(6, 'Phòng ngừa các bệnh hô hấp mùa nắng nóng', NULL, 'health', '<h2>Phòng ngừa các bệnh hô hấp mùa nắng nóng</h2><p>Mùa nắng nóng không chỉ là thời điểm gây khó chịu vì nhiệt độ cao mà còn tiềm ẩn nhiều nguy cơ mắc các bệnh về đường hô hấp.</p><p><br></p>', 'assets/img/hohap.webp', 'Phòng ngừa các bệnh hô hấp mùa nắng nóng - Bí quyết bảo vệ sức khỏe', 'Tìm hiểu các biện pháp phòng ngừa bệnh hô hấp hiệu quả trong thời tiết nắng nóng. Bảo vệ sức khỏe đường hô hấp với những lời khuyên từ chuyên gia.', 'hô hấp, nắng nóng, phòng bệnh, viêm phổi, hen suyễn', 'scheduled', 1, NULL, '2025-04-24 16:01:21', '2025-04-24 16:01:21', '2025-05-12 23:55:45'),
(7, 'Chế độ ăn cho người bệnh tim mạch', NULL, 'nutrition', '<h2>Chế độ ăn cho người bệnh tim mạch</h2><p>Bệnh tim mạch là một trong những nguyên nhân gây tử vong hàng đầu trên thế giới. Chế độ ăn uống đóng vai trò quan trọng trong việc kiểm soát và phòng ngừa các bệnh tim mạch.</p><p>Người bệnh tim mạch nên ăn gì và kiêng gì? Hãy cùng tìm hiểu trong bài viết này.</p>', 'assets/img/tintuc_timmach.jpg', 'Chế độ ăn cho người bệnh tim mạch - Lựa chọn thực phẩm tốt cho tim', 'Hướng dẫn chi tiết về chế độ ăn uống dành cho người mắc bệnh tim mạch.', 'tim mạch, dinh dưỡng, chế độ ăn, bệnh tim', 'published', 2, NULL, '2025-04-24 16:01:21', '2025-04-24 16:01:21', '2025-05-13 11:02:36'),
(8, 'Chăm sóc răng miệng đúng cách', NULL, 'health', '<h2>Chăm sóc răng miệng đúng cách</h2><p>Một nụ cười khỏe mạnh bắt đầu từ việc chăm sóc răng miệng đúng cách. Bài viết này sẽ hướng dẫn bạn các bước chăm sóc răng miệng hiệu quả tại nhà và khi nào bạn nên đến gặp nha sĩ.</p><ul class=\"wp-block-list\" style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; list-style-position: initial; list-style-image: initial; padding-left: 16px; color: rgb(51, 51, 51); font-family: Inter, sans-serif;\"><li style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit; font-weight: bolder;\">Bước 1 – Kiểm tra và đánh giá sức khỏe răng miệng:</span>&nbsp;Nha sĩ sẽ kiểm tra tình trạng răng của và đánh giá về mức độ thưa giữa các răng. Sau đó sẽ thảo luận về mong muốn hay nhu cầu cá nhân, từ đó tư vấn về phương pháp trám phù hợp.</li><li style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit; font-weight: bolder;\">Bước 2 – Vệ sinh răng miệng:&nbsp;</span>Nha sĩ sẽ làm sạch và chuẩn bị răng bằng cách loại bỏ mảng bám và chà răng để tạo một bề mặt sạch trước khi bắt đầu quá trình trám.</li><li style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit; font-weight: bolder;\">Bước 3 – Tiến hành trám răng thưa thẩm mỹ:</span>&nbsp;Nha sĩ sẽ sử dụng chất liệu trám (composite) vào các khu vực cần điều chỉnh. Nha sĩ sẽ tạo hình và mài nhẹ chất liệu trám để đảm bảo phù hợp với hàm răng tự nhiên và tạo ra một hàm răng đẹp.</li><li style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit; font-weight: bolder;\">Bước 4 – Điều chỉnh và hoàn thiện:</span>&nbsp;Sau khi áp dụng chất liệu trám, nha sĩ sẽ tiến hành điều chỉnh và hoàn thiện bằng cách kiểm tra sự khớp với các răng khác, kiểm tra hàm răng tổng thể và mài nhẹ chất liệu trám để đảm bảo sự thoải mái và thẩm mỹ.</li></ul>', 'assets/img/rang.jpg', 'Chăm sóc răng miệng đúng cách - Hướng dẫn từ chuyên gia', 'Một nụ cười khỏe mạnh và khám phá các phương pháp chăm sóc răng miệng hiệu quả và đúng cách. ', 'răng miệng, nha khoa, sức khỏe răng, chăm sóc răng', 'published', 2, NULL, '2025-04-24 16:01:21', '2025-04-24 16:01:21', '2025-05-13 11:03:31'),
(9, 'Chữa tủy răng cửa có đau không? Nên điều trị ở đâu?', NULL, 'health', '<p style=\"box-sizing: inherit; margin-bottom: 1.5em; color: rgb(51, 51, 51); font-family: Inter, sans-serif;\">Tủy răng là một phần quan trọng trong cấu trúc răng và nằm ở bên trong lõi răng. Nó chứa mạng lưới mạch máu và dây thần kinh, đảm nhận vai trò quan trọng trong việc cung cấp dưỡng chất và cảm nhận nhạy cảm đối với các tác động nhiệt độ, áp lực và hóa chất.&nbsp;<span style=\"box-sizing: inherit; font-weight: bolder;\">Tủy răng cửa</span>&nbsp;bao gồm một mô mềm, nhạy cảm và có khả năng phục hồi. Khi răng bị tổn thương do sâu răng, vi khuẩn hoặc tổn thương ngoại vi, tủy răng cửa có thể bị viêm nhiễm hoặc tổn thương, gây ra đau đớn và khó chịu cho người bệnh.</p><p style=\"box-sizing: inherit; margin-bottom: 1.5em; color: rgb(51, 51, 51); font-family: Inter, sans-serif;\">Vì tủy răng cửa đóng vai trò quan trọng trong sức khỏe răng miệng và chức năng của răng nên việc chữa trị tủy răng cửa luôn được nha sĩ khuyến nghị thực hiện từ ngay khi xuất hiện triệu chứng. Không những vậy, việc chữa tủy răng cửa từ sớm còn mang lại nhiều lợi ích khác, bao gồm:</p><ul class=\"wp-block-list\" style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; list-style-position: initial; list-style-image: initial; padding-left: 16px; color: rgb(51, 51, 51); font-family: Inter, sans-serif;\"><li style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit; font-weight: bolder;\">Cải thiện triệu chứng đau đớn:</span>&nbsp;Tủy răng cửa bị tổn thương hoặc viêm nhiễm có thể gây đau đớn lớn tạm thời hoặc kéo dài. Đau răng từ tủy răng cửa thường là một cảm giác nhức nhối và nhạy cảm, có thể tác động không hề nhỏ đến đời sống thường ngày.</li><li style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit; font-weight: bolder;\">Ngăn ngừa nhiễm trùng:</span>&nbsp;Khi tủy răng cửa bị tổn thương hoặc viêm nhiễm, vi khuẩn có thể xâm nhập và gây nhiễm trùng trong hệ thống mạch máu răng. Nếu không được chữa trị, nhiễm trùng có thể lan rộng và gây hại đến các cấu trúc xung quanh răng, gây viêm nhiễm và tổn thương nghiêm trọng.</li><li style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit; font-weight: bolder;\">Bảo vệ răng tự nhiên:&nbsp;</span>Tủy răng cửa là một phần quan trọng trong cấu trúc răng. Chữa trị tủy răng cửa giúp bảo vệ và bảo quản răng tự nhiên, giữ cho răng có thể thực hiện chức năng ăn nhai và nói chuyện một cách hiệu quả.</li><li style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit; font-weight: bolder;\">Ngăn ngừa biến chứng:&nbsp;</span>Nếu không điều trị kịp thời, tủy răng cửa bị tổn thương có thể dẫn đến các biến chứng nghiêm trọng. Các biến chứng có thể bao gồm viêm nhiễm xương xung quanh răng, phù nề, hủy hoại mô mềm xung quanh răng và thậm chí là mất răng.</li><li style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit; font-weight: bolder;\">Phòng ngừa hôi miệng:</span>&nbsp;Khi tủy răng cửa bị tổn thương đã tạo điều kiện cho vi khuẩn có khả năng xâm nhập vào bên trong gây viêm nhiễm, theo thời gian sẽ gây ra triệu chứng hôi miệng. Điều này sẽ khiến bạn mất điểm với đối phương.</li><li style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit; font-weight: bolder;\">Cải thiện chất lượng cuộc sống:</span>&nbsp;Chữa trị tủy răng cửa không chỉ giúp loại bỏ đau đớn và khó chịu, mà còn giúp cải thiện chất lượng cuộc sống. Khi bạn không còn bị ám ảnh bởi đau răng và khó chịu từ tủy răng cửa, bạn có thể ăn uống thoải mái và có giấc ngủ tốt hơn, hơn thế là tự tin hơn với nụ cười tự tin</li></ul>', 'assets/img/tintuc/1747108484_chua-tuy-rang-cua-2.jpg', 'Chữa tủy răng cửa có đau không? ', '', '', 'published', 0, NULL, '2025-05-13 10:54:44', '2025-05-13 10:54:44', NULL),
(10, 'Phẫu thuật cười hở lợi: Tổng hợp các thông tin quan trọng', NULL, 'health', '<h2 class=\"wp-block-heading\" style=\"box-sizing: inherit; font-family: Inter, sans-serif; font-weight: 700; letter-spacing: 0.96px; font-size: 32px; clear: both; color: rgb(51, 51, 51);\"><span id=\"Phau_thuat_cuoi_ho_loi_la_gi\" style=\"box-sizing: inherit;\">Phẫu thuật cười hở lợi là gì?</span></h2><p style=\"box-sizing: inherit; margin-bottom: 1.5em; color: rgb(51, 51, 51); font-family: Inter, sans-serif;\">Cười hở lợi không làm ảnh hưởng đến sức khỏe răng miệng cũng như không gây cản trở đến chức năng nhai nhưng lại khiến nhiều người cảm thấy tự ti. Đây là một khuyết tật bẩm sinh trong đó vòm miệng và/hoặc hàm mặt không đóng kín hoàn toàn. Cười hở lợi được chia thành nhiều giai đoạn khác nhau tương ứng với tình trạng hở lợi nhẹ đến hở lợi rất nặng, mộ nướu lộ hoàn toàn. Một trong những phương pháp khắc phục tình trạng này là phẫu thuật chỉnh hình cười hở lợi.</p><p style=\"box-sizing: inherit; margin-bottom: 1.5em; color: rgb(51, 51, 51); font-family: Inter, sans-serif;\">Phẫu thuật cười hở lợi là một loại phẫu thuật chỉnh hình thẩm mỹ nhằm sửa chữa các dị tật trong vùng miệng. Quy trình thực hiện được tiến hành bằng cách cắt bỏ một phần mô lợi bám trên thân răng, từ đó chỉnh hình để khắc phục khuyết điểm.</p><p style=\"box-sizing: inherit; margin-bottom: 1.5em; color: rgb(51, 51, 51); font-family: Inter, sans-serif;\">Phẫu thuật cười hở lợi không chỉ giúp cải thiện ngoại hình và chức năng, mà còn có tác động tích cực đến tâm lý và tư duy phát triển của người bệnh, mang lại sự tự tin và cải thiện chất lượng cuộc sống.</p>', 'assets/img/tintuc/1747108550_chua-tuy-rang-cua-5.jpg', 'Phẫu thuật cười hở lợi', '', '', 'published', 0, NULL, '2025-05-13 10:55:50', '2025-05-13 10:55:50', NULL),
(11, 'Trám răng thưa thẩm mỹ có nên không? Ở đâu trám răng giá rẻ?', NULL, 'medicine', '<h2 class=\"wp-block-heading\" style=\"box-sizing: inherit; font-family: Inter, sans-serif; font-weight: 700; letter-spacing: 0.96px; font-size: 32px; clear: both; color: rgb(51, 51, 51);\"><span id=\"Co_nen_tram_rang_thua_tham_my_khong\" style=\"box-sizing: inherit;\">Có nên trám răng thưa thẩm mỹ không?</span></h2><p style=\"box-sizing: inherit; margin-bottom: 1.5em; color: rgb(51, 51, 51); font-family: Inter, sans-serif;\"><a href=\"https://www.docosan.com/blog/nha-khoa/tram-rang-uy-tin/\" style=\"box-sizing: inherit; color: rgb(74, 192, 164); text-decoration-line: none; background-color: transparent;\">Trám răng</a>&nbsp;thưa thẩm mỹ là một quy trình nha khoa giúp cải thiện nụ cười được thực hiện nhằm điều chỉnh khoảng cách giữa các răng để tạo ra một hàm răng đều đặn và hài hòa hơn từ góc nhìn thẩm mỹ. Vì đây là phương pháp trám răng thẩm mỹ, không phải phương pháp điều trị xâm lấn nên phù hợp với hầu hết đối tượng.</p><p style=\"box-sizing: inherit; margin-bottom: 1.5em; color: rgb(51, 51, 51); font-family: Inter, sans-serif;\">Nụ cười của bạn không được đẹp bởi hàm răng thưa có nên trám răng thẩm mỹ không? Trên thực tế, việc trám răng thưa thẩm mỹ sẽ phần nào cải thiện thẩm mỹ của răng nhưng quyết định thực hiện còn phụ thuộc vào nhu cầu và tài chính của bạn.</p><p style=\"box-sizing: inherit; margin-bottom: 1.5em; color: rgb(51, 51, 51); font-family: Inter, sans-serif;\">Những lợi ích của việc trám thẩm mỹ răng thưa mà bạn có thể xem xét trước khi đưa ra quyết định thực hiện hay không:</p><ul class=\"wp-block-list\" style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; list-style-position: initial; list-style-image: initial; padding-left: 16px; color: rgb(51, 51, 51); font-family: Inter, sans-serif;\"><li style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit; font-weight: bolder;\">Không xâm lấn:</span>&nbsp;Trám răng thưa thẩm mỹ không yêu cầu mài hoặc đánh bóng răng tự nhiên, do đó, rất ít cấu trúc răng sẽ bị mất đi. Điều này làm cho quá trình trám răng thưa thẩm mỹ ít đau và ít gây phiền toái hơn so với các phương pháp khác như đặt sứ veneer hoặc mài răng.</li><li style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit; font-weight: bolder;\">Cải thiện thẩm mỹ nụ cười:</span>&nbsp;Trám răng thưa thẩm mỹ giúp lấp đầy khoảng cách giữa các răng thưa, tạo nên một hàm răng đều đặn hơn và một nụ cười đẹp tự nhiên hơn. Ngoài việc cải thiện nụ cười, trám răng thẩm mỹ còn giúp cải thiện ngoại hình tổng thể.</li><li style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit; font-weight: bolder;\">Quy trình đơn giản:&nbsp;</span>Composite là một loại vật liệu có thể dễ dàng điều chỉnh hình dạng và màu sắc để tạo ra kết quả tự nhiên và phù hợp với hàm răng tự nhiên. Nha sĩ có thể điều chỉnh kích thước, hình dạng và màu sắc của composite trong quá trình trám răng để đảm bảo kết quả tốt nhất.</li><li style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit; font-weight: bolder;\">Bảo vệ răng tự nhiên:</span>&nbsp;Việc trám răng thưa thẩm mỹ bảo vệ răng khỏi tổn thương và các vấn đề khác như vi khuẩn và mục tiêu. Composite (chất liệu trám) tạo ra một lớp bảo vệ mỏng trên bề mặt răng, giúp bảo vệ răng khỏi tác động môi trường và tăng tuổi thọ của răng.</li><li style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit; font-weight: bolder;\">Tiết kiệm thời gian:</span>&nbsp;Trám răng thưa thẩm mỹ thường chỉ mất một vài buổi điều trị ngắn. Quá trình này được thực hiện trực tiếp trong nha khoa bằng cách áp dụng vật liệu composite màu sắc phù hợp với răng tự nhiên của bạn. Bạn có thể nhìn thấy kết quả ngay lập tức và không cần phải đợi quá lâu.</li></ul>', 'assets/img/tintuc/1747108596_chua-tuy-rang-cua-3.jpg', 'Trám răng thưa thẩm mỹ có nên không?', '', '', 'published', 0, NULL, '2025-05-13 10:56:36', '2025-05-13 10:56:36', NULL),
(12, 'Có nên niềng răng mặt lưỡi không? Giá cả có đắt đỏ không?', NULL, '', '<h2 class=\"wp-block-heading\" style=\"box-sizing: inherit; font-family: Inter, sans-serif; font-weight: 700; letter-spacing: 0.96px; font-size: 32px; clear: both; color: rgb(51, 51, 51);\"><span id=\"Nieng_rang_mat_luoi_la_gi\" style=\"box-sizing: inherit;\">Niềng răng mặt lưỡi là gì?</span></h2><p style=\"box-sizing: inherit; margin-bottom: 1.5em; color: rgb(51, 51, 51); font-family: Inter, sans-serif;\">Nụ cười là một yếu tố quan trọng trong cuộc sống hàng ngày. Nó không chỉ tạo nên sự tự tin mà còn tác động tích cực đến sự giao tiếp và ảnh hưởng tới sự hài lòng cá nhân. Tuy nhiên, không phải ai cũng may mắn sở hữu một hàm răng hoàn hảo từ trước đến sau. Vấn đề về răng răng hô, hàm hô, hay răng không đều là những vấn đề phổ biến gặp phải.&nbsp;<span style=\"box-sizing: inherit; font-weight: bolder;\">Niềng răng mặt lưỡi</span>&nbsp;là một giải pháp tuyệt vời giúp bạn có thể có một nụ cười đẹp và tự tin hơn.</p><p style=\"box-sizing: inherit; margin-bottom: 1.5em; color: rgb(51, 51, 51); font-family: Inter, sans-serif;\"><a href=\"https://www.docosan.com/blog/nha-khoa/cac-loai-nieng-rang-va-gia/\" style=\"box-sizing: inherit; color: rgb(74, 192, 164); text-decoration-line: none; background-color: transparent;\">Niềng răng</a>&nbsp;mặt lưỡi còn được gọi là niềng răng mắc cài bên trong hay niềng răng mắc cài ẩn, là một phương pháp điều trị chỉnh nha tiên tiến và có tính thẩm mỹ cao. Phương pháp chỉnh nha này sử dụng các kẹp và sợi dây chỉnh nha được gắn lên phía sau các răng lưỡi. Điều này giúp giấu đi việc bạn đang điều trị chỉnh nha và tạo ra một nụ cười tự nhiên hơn.</p><div><br></div>', 'assets/img/tintuc/1747108685_nieng-rang-mat-luoi-4.jpg', 'Có nên niềng răng mặt lưỡi không?', '', '', 'published', 0, NULL, '2025-05-13 10:58:05', '2025-05-13 10:58:05', '2025-05-13 11:02:09'),
(13, 'Ưu Đãi Hấp Dẫn - Khám Răng Miễn Phí Tại Nha Khoa T&A!', NULL, 'medicine', '<p><span class=\"_fadeIn_m1hgl_8\">Đừng </span><span class=\"_fadeIn_m1hgl_8\">bỏ </span><span class=\"_fadeIn_m1hgl_8\">lỡ! </span><span class=\"_fadeIn_m1hgl_8\">Chỉ </span><span class=\"_fadeIn_m1hgl_8\">trong </span><span class=\"_fadeIn_m1hgl_8\">tháng </span><span class=\"_fadeIn_m1hgl_8\">này, </span><span class=\"_fadeIn_m1hgl_8\">Nha </span><span class=\"_fadeIn_m1hgl_8\">khoa </span><span class=\"_fadeIn_m1hgl_8\">T&amp;</span><span class=\"_fadeIn_m1hgl_8\">A </span><span class=\"_fadeIn_m1hgl_8\">dành </span><span class=\"_fadeIn_m1hgl_8\">tặng </span><strong data-start=\"277\" data-end=\"319\"><span class=\"_fadeIn_m1hgl_8\">phiếu </span><span class=\"_fadeIn_m1hgl_8\">giảm </span><span class=\"_fadeIn_m1hgl_8\">giá 5</span><span class=\"_fadeIn_m1hgl_8\">0% </span><span class=\"_fadeIn_m1hgl_8\">phí </span><span class=\"_fadeIn_m1hgl_8\">khám </span><span class=\"_fadeIn_m1hgl_8\">và </span><span class=\"_fadeIn_m1hgl_8\">tư </span><span class=\"_fadeIn_m1hgl_8\">vấn</span></strong><span class=\"_fadeIn_m1hgl_8\"> </span><span class=\"_fadeIn_m1hgl_8\">cho </span><span class=\"_fadeIn_m1hgl_8\">khách </span><span class=\"_fadeIn_m1hgl_8\">hàng </span><span class=\"_fadeIn_m1hgl_8\">mới!</span><br data-start=\"339\" data-end=\"342\">\r\n<span class=\"_fadeIn_m1hgl_8\">✅ </span><span class=\"_fadeIn_m1hgl_8\">Kiểm </span><span class=\"_fadeIn_m1hgl_8\">tra </span><span class=\"_fadeIn_m1hgl_8\">răng </span><span class=\"_fadeIn_m1hgl_8\">miệng </span><span class=\"_fadeIn_m1hgl_8\">tổng </span><span class=\"_fadeIn_m1hgl_8\">quát</span><br data-start=\"373\" data-end=\"376\">\r\n<span class=\"_fadeIn_m1hgl_8\">✅ </span><span class=\"_fadeIn_m1hgl_8\">Tư </span><span class=\"_fadeIn_m1hgl_8\">vấn </span><span class=\"_fadeIn_m1hgl_8\">điều </span><span class=\"_fadeIn_m1hgl_8\">trị </span><span class=\"_fadeIn_m1hgl_8\">bởi </span><span class=\"_fadeIn_m1hgl_8\">bác </span><span class=\"_fadeIn_m1hgl_8\">sĩ </span><span class=\"_fadeIn_m1hgl_8\">giàu </span><span class=\"_fadeIn_m1hgl_8\">kinh </span><span class=\"_fadeIn_m1hgl_8\">nghiệm</span><br data-start=\"421\" data-end=\"424\"><span class=\"_fadeIn_m1hgl_8\">✅&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">Số </span><span class=\"_fadeIn_m1hgl_8\">lượng </span><span class=\"_fadeIn_m1hgl_8\">có </span><span class=\"_fadeIn_m1hgl_8\">hạn – </span><span class=\"_fadeIn_m1hgl_8\">nhanh </span><span class=\"_fadeIn_m1hgl_8\">tay </span><span class=\"_fadeIn_m1hgl_8\">đăng </span><span class=\"_fadeIn_m1hgl_8\">ký </span><span class=\"_fadeIn_m1hgl_8\">ngay!</span><br data-start=\"468\" data-end=\"471\"><span class=\"_fadeIn_m1hgl_8\">✅&nbsp;</span><span class=\"_fadeIn_m1hgl_8\">Liên </span><span class=\"_fadeIn_m1hgl_8\">hệ: [</span><span class=\"_fadeIn_m1hgl_8\"><span style=\"color: rgb(51, 51, 51); font-family: &quot;Segoe UI&quot;, Tahoma, Geneva, Verdana, sans-serif; background-color: rgb(248, 249, 250);\">0944 492 947</span>]</span></p>', 'assets/img/tintuc/1747396335_Nha-trẻ-em-1.png', '', '', '', 'published', 1, NULL, '2025-05-16 18:52:15', '2025-05-16 18:52:15', '2025-05-16 18:54:05'),
(14, 'Tặng Ngay Phiếu Giảm Giá 30% Cho Dịch Vụ Tẩy Trắng Răng!', NULL, 'medicine', '<p><span class=\"_fadeIn_m1hgl_8\">Bạn </span><span class=\"_fadeIn_m1hgl_8\">muốn </span><span class=\"_fadeIn_m1hgl_8\">sở </span><span class=\"_fadeIn_m1hgl_8\">hữu </span><span class=\"_fadeIn_m1hgl_8\">nụ </span><span class=\"_fadeIn_m1hgl_8\">cười </span><span class=\"_fadeIn_m1hgl_8\">rạng </span><span class=\"_fadeIn_m1hgl_8\">rỡ? </span><span class=\"_fadeIn_m1hgl_8\">Đã </span><span class=\"_fadeIn_m1hgl_8\">có </span><span class=\"_fadeIn_m1hgl_8\">T&amp;</span><span class=\"_fadeIn_m1hgl_8\">A </span><span class=\"_fadeIn_m1hgl_8\">đồng </span><span class=\"_fadeIn_m1hgl_8\">hành!</span><br data-start=\"633\" data-end=\"636\"><span class=\"_fadeIn_m1hgl_8\">Nhận </span><strong data-start=\"644\" data-end=\"666\"><span class=\"_fadeIn_m1hgl_8\">phiếu </span><span class=\"_fadeIn_m1hgl_8\">giảm </span><span class=\"_fadeIn_m1hgl_8\">giá </span><span class=\"_fadeIn_m1hgl_8\">30%</span></strong><span class=\"_fadeIn_m1hgl_8\"> </span><span class=\"_fadeIn_m1hgl_8\">cho </span><span class=\"_fadeIn_m1hgl_8\">dịch </span><span class=\"_fadeIn_m1hgl_8\">vụ </span><span class=\"_fadeIn_m1hgl_8\">tẩy </span><span class=\"_fadeIn_m1hgl_8\">trắng </span><span class=\"_fadeIn_m1hgl_8\">răng </span><span class=\"_fadeIn_m1hgl_8\">khi </span><span class=\"_fadeIn_m1hgl_8\">đặt </span><span class=\"_fadeIn_m1hgl_8\">lịch </span><span class=\"_fadeIn_m1hgl_8\">hẹn </span><span class=\"_fadeIn_m1hgl_8\">trong </span><span class=\"_fadeIn_m1hgl_8\">tuần </span><span class=\"_fadeIn_m1hgl_8\">này.</span><br data-start=\"726\" data-end=\"729\"><span class=\"_fadeIn_m1hgl_8\">An </span><span class=\"_fadeIn_m1hgl_8\">toàn – </span><span class=\"_fadeIn_m1hgl_8\">Nhanh </span><span class=\"_fadeIn_m1hgl_8\">chóng – </span><span class=\"_fadeIn_m1hgl_8\">Hiệu </span><span class=\"_fadeIn_m1hgl_8\">quả </span><span class=\"_fadeIn_m1hgl_8\">tức </span><span class=\"_fadeIn_m1hgl_8\">thì!</span><br data-start=\"773\" data-end=\"776\"><span class=\"_fadeIn_m1hgl_8\">Inbox </span><span class=\"_fadeIn_m1hgl_8\">ngay </span><span class=\"_fadeIn_m1hgl_8\">để </span><span class=\"_fadeIn_m1hgl_8\">nhận </span><span class=\"_fadeIn_m1hgl_8\">ưu </span><span class=\"_fadeIn_m1hgl_8\">đãi!</span></p>', 'assets/img/tintuc/1747396388_rang.jpg', '', '', '', 'published', 0, NULL, '2025-05-16 18:53:08', '2025-05-16 18:53:08', '2025-05-16 18:53:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bacsi`
--
ALTER TABLE `bacsi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nguoidung_id` (`nguoidung_id`),
  ADD KEY `chuyenkhoa_id` (`chuyenkhoa_id`);

--
-- Indexes for table `benhnhan`
--
ALTER TABLE `benhnhan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nguoidung_id` (`nguoidung_id`);

--
-- Indexes for table `caidat_website`
--
ALTER TABLE `caidat_website`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ten_key` (`ten_key`);

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chitieu`
--
ALTER TABLE `chitieu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chuyenkhoa`
--
ALTER TABLE `chuyenkhoa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dichvu`
--
ALTER TABLE `dichvu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chuyenkhoa_id` (`chuyenkhoa_id`);

--
-- Indexes for table `don_thuoc`
--
ALTER TABLE `don_thuoc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lichhen_id` (`lichhen_id`),
  ADD KEY `thuoc_id` (`thuoc_id`);

--
-- Indexes for table `ketqua_kham`
--
ALTER TABLE `ketqua_kham`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lichhen_id` (`lichhen_id`);

--
-- Indexes for table `lichhen`
--
ALTER TABLE `lichhen`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ma_lichhen` (`ma_lichhen`),
  ADD KEY `benhnhan_id` (`benhnhan_id`),
  ADD KEY `bacsi_id` (`bacsi_id`),
  ADD KEY `dichvu_id` (`dichvu_id`);

--
-- Indexes for table `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nguoidung_id` (`nguoidung_id`);

--
-- Indexes for table `thuoc`
--
ALTER TABLE `thuoc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tintuc`
--
ALTER TABLE `tintuc`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bacsi`
--
ALTER TABLE `bacsi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `benhnhan`
--
ALTER TABLE `benhnhan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `caidat_website`
--
ALTER TABLE `caidat_website`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `chitieu`
--
ALTER TABLE `chitieu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `chuyenkhoa`
--
ALTER TABLE `chuyenkhoa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `dichvu`
--
ALTER TABLE `dichvu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `don_thuoc`
--
ALTER TABLE `don_thuoc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ketqua_kham`
--
ALTER TABLE `ketqua_kham`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `lichhen`
--
ALTER TABLE `lichhen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `nguoidung`
--
ALTER TABLE `nguoidung`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `nhanvien`
--
ALTER TABLE `nhanvien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `thuoc`
--
ALTER TABLE `thuoc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tintuc`
--
ALTER TABLE `tintuc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bacsi`
--
ALTER TABLE `bacsi`
  ADD CONSTRAINT `bacsi_ibfk_1` FOREIGN KEY (`nguoidung_id`) REFERENCES `nguoidung` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `bacsi_ibfk_2` FOREIGN KEY (`chuyenkhoa_id`) REFERENCES `chuyenkhoa` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `benhnhan`
--
ALTER TABLE `benhnhan`
  ADD CONSTRAINT `benhnhan_ibfk_1` FOREIGN KEY (`nguoidung_id`) REFERENCES `nguoidung` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `dichvu`
--
ALTER TABLE `dichvu`
  ADD CONSTRAINT `dichvu_ibfk_1` FOREIGN KEY (`chuyenkhoa_id`) REFERENCES `chuyenkhoa` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `don_thuoc`
--
ALTER TABLE `don_thuoc`
  ADD CONSTRAINT `don_thuoc_ibfk_1` FOREIGN KEY (`lichhen_id`) REFERENCES `lichhen` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `don_thuoc_ibfk_2` FOREIGN KEY (`thuoc_id`) REFERENCES `thuoc` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ketqua_kham`
--
ALTER TABLE `ketqua_kham`
  ADD CONSTRAINT `ketqua_kham_ibfk_1` FOREIGN KEY (`lichhen_id`) REFERENCES `lichhen` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lichhen`
--
ALTER TABLE `lichhen`
  ADD CONSTRAINT `lichhen_ibfk_1` FOREIGN KEY (`benhnhan_id`) REFERENCES `benhnhan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lichhen_ibfk_2` FOREIGN KEY (`bacsi_id`) REFERENCES `bacsi` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lichhen_ibfk_3` FOREIGN KEY (`dichvu_id`) REFERENCES `dichvu` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD CONSTRAINT `nhanvien_ibfk_1` FOREIGN KEY (`nguoidung_id`) REFERENCES `nguoidung` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

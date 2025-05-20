<?php
$conn = new mysqli("localhost", "root", "", "dat_lich_kham_db");
$conn->set_charset("utf8");

$sql = "SELECT thang, loai, ten, so_luong, gia, ngay FROM chitieu ORDER BY thang, ngay";
$result = $conn->query($sql);

echo "<table class='table table-bordered'>
        <thead>
          <tr>
            <th>Tháng</th>
            <th>Loại</th>
            <th>Tên</th>
            <th>Số lượng</th>
            <th>Giá</th>
            <th>Ngày</th>
          </tr>
        </thead>
        <tbody>";

while ($row = $result->fetch_assoc()) {
  echo "<tr>
          <td>Tháng " . $row['thang'] . "</td>
          <td>" . $row['loai'] . "</td>
          <td>" . $row['ten'] . "</td>
          <td>" . $row['so_luong'] . "</td>
          <td>" . number_format($row['gia']) . " đ</td>
          <td>" . $row['ngay'] . "</td>
        </tr>";
}

// Thêm dòng tổng tiền vào dưới cùng của bảng
echo "<tr>
        <td colspan='6' style='text-align: right; font-weight: bold; padding-top: 10px;'>
          TỔNG TIỀN: 508,920,000 đ
        </td>
      </tr>";

echo "</tbody></table>";
?>

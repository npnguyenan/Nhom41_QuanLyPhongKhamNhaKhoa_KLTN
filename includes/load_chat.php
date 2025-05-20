<?php
$conn = new mysqli("localhost", "root", "", "dat_lich_kham_db");
if ($conn->connect_error) die("Connection failed");

$result = $conn->query("SELECT * FROM chat_messages ORDER BY created_at ASC");
while ($row = $result->fetch_assoc()) {
    $class = $row['sender'] == 'user' ? 'user' : 'admin';
    echo "<p class='$class'><strong>{$row['sender']}:</strong> {$row['message']} <small style='color:#999; font-size:10px;'>({$row['created_at']})</small></p>";
}
$conn->close();
?>

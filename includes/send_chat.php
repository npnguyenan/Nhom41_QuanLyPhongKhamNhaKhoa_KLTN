<?php
$conn = new mysqli("localhost", "root", "", "dat_lich_kham_db");
if ($conn->connect_error) die("Connection failed");

$sender = $_POST['sender'];
$message = $_POST['message'];

$stmt = $conn->prepare("INSERT INTO chat_messages (sender, message) VALUES (?, ?)");
$stmt->bind_param("ss", $sender, $message);
$stmt->execute();
$stmt->close();
$conn->close();
?>

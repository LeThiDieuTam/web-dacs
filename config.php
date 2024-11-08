<?php
$host = 'localhost';
$db = 'user_registration';
$user = 'root';
$pass = '';

// Tạo kết nối
$conn = new mysqli($host, $user, $pass, $db);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
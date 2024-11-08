<?php
session_start(); // Bắt đầu session

// Kết nối cơ sở dữ liệu
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "user_registration";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die(json_encode(['error' => "Kết nối thất bại: " . $conn->connect_error]));
}

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo json_encode(['error' => "Vui lòng đăng nhập để xem giỏ hàng."]);
    exit;
}

// Lấy user_id từ session
$user_id = $_SESSION['id'];

// Truy vấn đếm số lượng sản phẩm trong giỏ hàng của người dùng
$sql_count = "SELECT SUM(quantity) AS cart_count FROM cart WHERE user_id = ?";
$stmt_count = $conn->prepare($sql_count);
$stmt_count->bind_param("i", $user_id);
$stmt_count->execute();
$result_count = $stmt_count->get_result();
$cart_count = $result_count->fetch_assoc()['cart_count'] ?? 0; // Mặc định là 0 nếu không có sản phẩm

// Trả về kết quả dưới dạng JSON
echo json_encode(['cart_count' => $cart_count]);

$stmt_count->close();
$conn->close();
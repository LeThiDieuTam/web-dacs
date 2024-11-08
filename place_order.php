<?php
session_start();

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "user_registration";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['id'];

// Lấy thông tin tổng giá và số lượng từ giỏ hàng
$sql_cart = "
    SELECT SUM(c.quantity) AS total_quantity, SUM(c.quantity * p.price) AS total_price
    FROM cart c
    JOIN products p ON c.product_id = p.product_id
    WHERE c.user_id = ?
";

$stmt_cart = $conn->prepare($sql_cart);
$stmt_cart->bind_param("i", $user_id);
$stmt_cart->execute();
$result_cart = $stmt_cart->get_result();
$row_cart = $result_cart->fetch_assoc();

$total_quantity = $row_cart['total_quantity'];
$total_price = $row_cart['total_price'];

// Tính điểm cộng tích lũy
$total_loyalty_points = floor($total_price / 1000); // 1 điểm cho mỗi 1000 VND

// Thêm đơn hàng vào bảng `orders`
$sql_order = "INSERT INTO orders (user_id, total_price, total_quantity, loyalty_points) VALUES (?, ?, ?, ?)";
$stmt_order = $conn->prepare($sql_order);
$stmt_order->bind_param("sdii", $user_id, $total_price, $total_quantity, $total_loyalty_points);

if ($stmt_order->execute()) {
    // Xóa giỏ hàng sau khi đặt hàng thành công
    $sql_delete_cart = "DELETE FROM cart WHERE user_id = ?";
    $stmt_delete_cart = $conn->prepare($sql_delete_cart);
    $stmt_delete_cart->bind_param("i", $user_id);
    $stmt_delete_cart->execute();

    // Chuyển hướng đến trang cảm ơn hoặc thông báo thành công
    header("Location: cart.php");
} else {
    echo "Có lỗi xảy ra khi đặt hàng. Vui lòng thử lại.";
}

$conn->close();
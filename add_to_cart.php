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
    die("Connection failed: " . $conn->connect_error);
}

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo "Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng.";
    exit;
}

// Kiểm tra và lấy thông tin sản phẩm từ POST
if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Lấy user_id từ session
    $user_id = $_SESSION['id'];

    // Thêm sản phẩm vào giỏ hàng
    $sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("iii", $user_id, $product_id, $quantity);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Sản phẩm đã được thêm vào giỏ hàng!";
        } else {
            $_SESSION['message'] = "Lỗi khi thêm sản phẩm vào giỏ hàng: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $_SESSION['message'] = "Lỗi chuẩn bị câu lệnh: " . $conn->error;
    }
} else {
    $_SESSION['message'] = "Vui lòng cung cấp thông tin sản phẩm hợp lệ.";
}

// Chuyển hướng về trang sản phẩm
header("Location: product.php");
exit;

$conn->close();

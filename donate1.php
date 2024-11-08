<?php
session_start(); // Bắt đầu session
include 'db.php'; // Kết nối cơ sở dữ liệu

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

$message = '';

// Kiểm tra và xử lý dữ liệu từ form quyên góp
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $amount = $_POST['amount'];
    $category = $_POST['category'];
    $message = isset($_POST['message']) ? $_POST['message'] : '';

    // Lấy user_id từ session
    $user_id = $_SESSION['user_id'];

    // Thêm quyên góp vào cơ sở dữ liệu
    $sql = "INSERT INTO donations (user_id, amount, category, message) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("iiss", $user_id, $amount, $category, $message);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Quyên góp thành công!";
            header("Location: donations.php"); // Chuyển hướng đến trang hiển thị quyên góp
            exit;
        } else {
            $_SESSION['message'] = "Lỗi khi thực hiện quyên góp: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $_SESSION['message'] = "Lỗi chuẩn bị câu lệnh: " . $conn->error;
    }
}

// Lấy sản phẩm từ cơ sở dữ liệu
$query = "SELECT product_id, product_name, price, image FROM products";
$result = $conn->query($query);

$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

// Kiểm tra và hiển thị thông báo
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); // Xóa thông báo sau khi hiển thị
}

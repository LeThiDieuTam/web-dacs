<?php
session_start(); // Khởi động phiên làm việc

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Bạn cần đăng nhập để đặt hàng.'); window.location.href = 'login.php';</script>";
    exit(); // Thoát khỏi script nếu người dùng chưa đăng nhập
}

// Kết nối đến cơ sở dữ liệu
include('db.php'); // Thay đổi đường dẫn nếu cần

// Khởi tạo biến
$userId = $_SESSION['user_id'];
$totalPrice = 0.0;
$totalQuantity = 0;
$loyaltyPoints = 0; // Có thể tính toán dựa trên giá trị đơn hàng

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy danh sách sản phẩm đã chọn từ biểu mẫu
    $selectedProducts = $_POST['selected_products'] ?? [];

    // Kiểm tra nếu có sản phẩm được chọn
    if (!empty($selectedProducts)) {
        // Tính toán tổng giá trị và số lượng
        foreach ($selectedProducts as $cartId) {
            // Lấy thông tin sản phẩm từ giỏ hàng
            $stmt = $conn->prepare("SELECT price, quantity FROM cart WHERE cart_id = ?");
            $stmt->bind_param("i", $cartId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                // Tính toán tổng giá trị và số lượng
                $totalPrice += $row['price'] * $row['quantity'];
                $totalQuantity += $row['quantity'];
            }
            $stmt->close();
        }

        // Kiểm tra tổng giá trị phải lớn hơn 0
        if ($totalPrice > 0) {
            // Thêm đơn hàng vào cơ sở dữ liệu
            $stmt = $conn->prepare("INSERT INTO orders (user_id, total_price, total_quantity, loyalty_points) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("idii", $userId, $totalPrice, $totalQuantity, $loyaltyPoints);
            $stmt->execute();
            $stmt->close();

            // Lấy ID đơn hàng vừa tạo
            $orderId = $conn->insert_id;

            // Xóa sản phẩm khỏi giỏ hàng
            foreach ($selectedProducts as $cartId) {
                $stmt = $conn->prepare("DELETE FROM cart WHERE cart_id = ?");
                $stmt->bind_param("i", $cartId);
                $stmt->execute();
                $stmt->close();
            }

            echo "<script>alert('Đặt hàng thành công!'); window.location.href = 'order_details.php?id=$orderId';</script>"; // Chuyển hướng đến trang chi tiết đơn hàng
        } else {
            echo "<script>alert('Tổng giá trị phải lớn hơn 0.');</script>";
        }
    } else {
        echo "<script>alert('Chưa chọn sản phẩm nào để đặt hàng.');</script>";
    }
} else {
    echo "<script>alert('Phương thức yêu cầu không hợp lệ.');</script>";
}

// Đóng kết nối
$conn->close();
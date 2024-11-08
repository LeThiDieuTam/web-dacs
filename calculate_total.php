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

$selected_ids = json_decode($_POST['selected_ids'], true);
$total = 0;
$subtotal = 0;

if (!empty($selected_ids)) {
    $ids = implode(",", array_map('intval', $selected_ids));
    $sql = "SELECT quantity, price FROM cart JOIN products ON cart.product_id = products.product_id WHERE cart.cart_id IN ($ids)";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        $item_total = $row['quantity'] * $row['price'];
        $subtotal += $item_total;
    }
}

// Tính điểm tích lũy, giả sử 1 điểm cho mỗi 100,000 VND
$loyalty_points = floor($subtotal / 100000);

$response = [
    'subtotal' => $subtotal,
    'total' => $subtotal,
    'loyalty_points' => $loyalty_points,
];

echo json_encode($response);
$conn->close();
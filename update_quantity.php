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

$cart_id = $_POST['cart_id'];
$quantity = $_POST['quantity'];

$sql_update = "UPDATE cart SET quantity = ? WHERE cart_id = ?";
$stmt_update = $conn->prepare($sql_update);
$stmt_update->bind_param("ii", $quantity, $cart_id);
$stmt_update->execute();

$sql_total = "SELECT (quantity * price) AS total_price FROM cart JOIN products ON cart.product_id = products.product_id WHERE cart_id = ?";
$stmt_total = $conn->prepare($sql_total);
$stmt_total->bind_param("i", $cart_id);
$stmt_total->execute();
$result_total = $stmt_total->get_result();
$total_price = $result_total->fetch_assoc()['total_price'];

echo json_encode([
    'total_price' => $total_price,
    'total_price_formatted' => number_format($total_price)
]);

$conn->close();
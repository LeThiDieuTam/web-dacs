<?php
session_start(); // Bắt đầu session
include 'db.php'; // Kết nối cơ sở dữ liệu

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['query'])) {
    $query = $_GET['query'];
    $sql = "SELECT * FROM products WHERE product_name LIKE '%$query%'";
    $result = $conn->query($sql);

    echo "<h1>Kết quả tìm kiếm</h1>";
    echo "<div class='products'>";

    if ($result->num_rows > 0) {
        // Hiển thị kết quả tìm kiếm
        while ($row = $result->fetch_assoc()) {
?>
            <div class="tab-content outer-top-xs">
                <div class="tab-pane in active" id="all">
                    <div class="product-slider">
                        <div class="owl-carousel home-owl-carousel custom-carousel owl-theme" data-item="4">
                            <div class="item item-carousel">
                                <div class="product">
                                    <div class="product-image">
                                        <?php if (!empty($row['image'])): ?>
                                            <a href="picture.php"><img
                                                    id="product-image-<?php echo htmlspecialchars($row['product_id']); ?>"
                                                    src="<?php echo htmlspecialchars($row['image']); ?>"
                                                    alt="<?php echo htmlspecialchars($row['product_name']); ?>"></a>
                                        <?php else: ?>
                                            <img id="product-image-<?php echo htmlspecialchars($row['product_id']); ?>"
                                                src="default_image.png" alt="No Image Available">
                                        <?php endif; ?>
                                        <div class="tag hot"><span>Hot</span></div>
                                    </div>
                                    <div class="product-info text-left">
                                        <h3 class="name"><?php echo htmlspecialchars($row['product_name']); ?></h3>
                                    </div>
                                    <div class="product-price">
                                        <strong class="price">
                                            Giá: <span class="current-price"><strong><?php echo htmlspecialchars($row['price']); ?>
                                                    VND</strong></span>
                                        </strong>
                                    </div>
                                    <div class="rating rateit-small"></div>

                                    <form action="add_to_cart.php" method="POST" class="add-to-cart-form">
                                        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">

                                        <div class="quantity-container">
                                            <div class="quant-input">
                                                <div class="arrow plus gradient">
                                                    <a
                                                        href="update_quantity.php?cart_id=<?php echo htmlspecialchars($row['product_id']); ?>&action=add">
                                                        <span class="ir"><i class="fa fa-sort-asc"></i></span>
                                                    </a>
                                                </div>
                                                <input type="number" name="quantity" value="1" min="1" class="quantity-input"
                                                    required>
                                                <div class="arrow minus gradient">
                                                    <a
                                                        href="update_quantity.php?cart_id=<?php echo htmlspecialchars($row['product_id']); ?>&action=sub">
                                                        <span class="ir"><i class="fa fa-sort-desc"></i></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-shopping-cart"></i> Thêm vào giỏ hàng
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
        <?php
        }
    } else {
        echo "Không tìm thấy kết quả nào.";
    }
    echo "</div>";
}

$conn->close(); // Đóng kết nối
        ?>
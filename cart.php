<?php
session_start();

// Kết nối cơ sở dữ liệu
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "user_registration";
$conn = new mysqli($servername, $username, $password, $dbname);

// Fixing connection error check
if ($conn->connect_error) { // Corrected the connection error check
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['id'];
$sql_cart = "SELECT c.cart_id, c.quantity, p.product_name, p.price, p.image, (c.quantity * p.price) AS total_price
             FROM cart c
             JOIN products p ON c.product_id = p.product_id
             WHERE c.user_id = ?";
$stmt_cart = $conn->prepare($sql_cart);
$stmt_cart->bind_param("i", $user_id);
$stmt_cart->execute();
$result_cart = $stmt_cart->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Hàng</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="./css/styles.css">
    <script src="js.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="shortcut icon" href="image/vietnam.png" type="image/x-icon">

    <!-- Icons/Glyphs -->
    <link rel="stylesheet" href="/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="/css/bootstrap.min.css">

    <!-- Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,600,600italic,700,700italic,800'
        rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <!-- Customizable CSS -->
    <link rel="stylesheet" href="/css/main1.css">
    <link rel="stylesheet" href="/css/blue.css">
    <link rel="stylesheet" href="/css/owl.carousel.css">
    <link rel="stylesheet" href="/css/owl.transitions.css">
    <link rel="stylesheet" href="/css/animate.min.css">
    <link rel="stylesheet" href="/css/rateit.css">
    <link rel="stylesheet" href="/css/bootstrap-select.min.css">
    <style>
        body {
            background-color: aliceblue !important;
        }


        .container {
            background-color: aliceblue;
            padding: 20px;
            border-radius: 10px;
            width: 100%;
            /* Đặt chiều rộng toàn màn hình */
            max-width: 2000px;
            /* Hoặc giới hạn tối đa chiều rộng */
            margin: auto;
            /* Căn giữa container */
        }


        .text-end {
            font-size: 20px;
        }

        form {
            padding: 100px;
        }
    </style>

</head>

<body>
    <header class="header">
        <div class="logo">
            <img src="image/vietnam.png" alt="Logo">
        </div>
        <div id="translate-wrapper">
            <div id="google_translate_element"></div>
        </div>

        <script type="text/javascript">
            function googleTranslateElementInit() {
                new google.translate.TranslateElement({
                    pageLanguage: 'vi',
                    layout: google.translate.TranslateElement.InlineLayout.SIMPLE
                }, 'google_translate_element');
            }
        </script>
        <script type="text/javascript"
            src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>


        <nav class="navbar">
            <a href="home.php" class="nav-link text-decoration-none">Trang chủ</a>
            <a href="history.php" class="nav-link text-decoration-none">Lịch Sử</a>
            <a href="product.php" class="nav-link text-decoration-none">Sản phẩm</a>
            <a href="donate.php" class="nav-link text-decoration-none">Quyên góp</a>
            <a href="#contact" class="nav-link text-decoration-none">Liên Hệ</a>
            <a href="#blogs" class="nav-link text-decoration-none">Blogs</a>
        </nav>
        </div>

        <div class="icons">

            <div class="fas fa-search" id="search-btn"></div>
            <a href="order_history.php">
                <div class="fas fa-user account-icon"></div>
            </a>
            <script>
                function updateCartCount() {
                    fetch("get_cart_count.php")
                        .then(response => response.json())
                        .then(data => {
                            if (data.error) {
                                console.error(data.error); // Hiển thị lỗi nếu có
                            } else {
                                // Cập nhật số lượng giỏ hàng trong giao diện
                                document.getElementById("cart-count").innerText = data.cart_count;
                            }
                        })
                        .catch(error => console.error("Lỗi:", error));
                }

                // Gọi hàm này khi tải trang để cập nhật số lượng giỏ hàng ban đầu
                window.onload = updateCartCount;

                function addToCart(productId, quantity) {
                    fetch("cart.php", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/x-www-form-urlencoded"
                            },
                            body: `product_id=${productId}&quantity=${quantity}`
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.error) {
                                alert(data.error);
                            } else {
                                alert(data.message);
                                updateCartCount(); // Cập nhật số lượng giỏ hàng
                            }
                        })
                        .catch(error => console.error("Lỗi:", error));
                }
            </script>
            <a href="cart.php">
                <div class="fas fa-shopping-cart" id="cart-btn">
                    <span id="cart-count">0</span> <!-- Số lượng sản phẩm -->
                </div>
            </a>
            <div class="fas fa-bars" id="menu-btn"></div>
            <div class="logout">
                <a href="login.php" class="btn btn-danger">Đăng xuất</a>
            </div>
            <div class="hello">
                <p style="font-size: 50%;">
                    <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>!
                </p>
            </div>
        </div>
        <div class="search-form">
            <input type="search" id="search-box" placeholder="search here...">
            <label for="search-box" class="fas fa-search"></label>
        </div>
        <div class="cart-items-container">
            <div class="cart-item">
                <span class="fas fa-times"></span>
                <img src="image/hinh-anh-xe-tang-tien-vao-dinh-doc-lap.jpg" alt="">
                <div class="content">
                    <h3>cart item 01</h3>
                    <div class="price">$15.99</div>
                </div>
            </div>
            <div class="cart-item">
                <span class="fas fa-times"></span>
                <img src="image/hinh-anh-xe-tang-tien-vao-dinh-doc-lap.jpg" alt="">
                <div class="content">
                    <h3>cart item 02</h3>
                    <div class="price">$15.99</div>
                </div>
            </div>
            <div class="cart-item">
                <span class="fas fa-times"></span>
                <img src="image/hinh-anh-xe-tang-tien-vao-dinh-doc-lap.jpg" alt="">
                <div class="content">
                    <h3>cart item 03</h3>
                    <div class="price">$15.99</div>
                </div>
            </div>
            <div class="cart-item">
                <span class="fas fa-times"></span>
                <img src="image/hinh-anh-xe-tang-tien-vao-dinh-doc-lap.jpg" alt="">
                <div class="content">
                    <h3>cart item 04</h3>
                    <div class="price">$15.99</div>
                </div>
            </div>
            <a href="#" class="btn">check out now</a>
        </div>
    </header>

    <form id="checkout-form" method="POST" action="place_order.php">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <?php if ($result_cart && $result_cart->num_rows > 0): ?>
                        <div class="row">
                            <div class="col-md-9">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Hình Ảnh</th>
                                            <th>Tên Sản Phẩm</th>
                                            <th>Số Lượng</th>
                                            <th>Giá</th>
                                            <th>Tổng Giá</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = $result_cart->fetch_assoc()): ?>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="selected_products[]" class="product-checkbox "
                                                        value="<?php echo htmlspecialchars($row['cart_id']); ?>"
                                                        data-price="<?php echo htmlspecialchars($row['total_price']); ?>"
                                                        onchange="calculateTotal()">
                                                </td>
                                                <td><img src="<?php echo htmlspecialchars($row['image']); ?>"
                                                        alt="Product Image" width="50" class="img-fluid"></td>
                                                <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <button type="button"
                                                            onclick="updateQuantity(<?php echo $row['cart_id']; ?>, -1)"
                                                            class="btn btn-sm btn-warning">-</button>
                                                        <input type="text"
                                                            value="<?php echo htmlspecialchars($row['quantity']); ?>"
                                                            id="quantity-<?php echo $row['cart_id']; ?>" readonly
                                                            class="form-control mx-2 text-center" style="width: 50px;">
                                                        <button type="button"
                                                            onclick="updateQuantity(<?php echo $row['cart_id']; ?>, 1)"
                                                            class="btn btn-sm btn-warning">+</button>
                                                    </div>
                                                </td>
                                                <td><?php echo number_format($row['price']); ?> VND</td>
                                                <td class="total-price text-danger"
                                                    id="total-price-<?php echo $row['cart_id']; ?>">
                                                    <?php echo number_format($row['total_price']); ?> VND</td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-3">
                                <h3 class="text-end">Thông Tin Thanh Toán</h3>
                                <div class="mb-3">
                                    <label for="subtotal" class="form-label">Số lượng:</label>
                                    <input type="text" id="subtotal" class="form-control" value="0.0" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="total" class="form-label">Tổng Cộng:</label>
                                    <input type="text" id="total" class="form-control" value="0.0" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="loyalty_points" class="form-label">Điểm Cộng Tích Lũy:</label>
                                    <input type="text" id="loyalty_points" class="form-control" value="0" readonly>
                                </div>
                                <h3 class="text-end">Tổng: <span id="total-value" class="text-success">0.0</span>
                                </h3>
                                <button type="submit" class="btn btn-danger " style="margin-left: 100px;">Thanh
                                    toán</button>
                            </div>
                        </div>
                    <?php else: ?>
                        <p class="text-center text-muted"><img src="image/cart.png"> Giỏ hàng của bạn hiện đang trống.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </form>


    <script>
        function calculateTotal() {
            const checkboxes = document.querySelectorAll('.product-checkbox');
            let selectedIds = [];
            let totalQuantity = 0;

            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    selectedIds.push(checkbox.value);
                    // Lấy số lượng từ ô input tương ứng
                    const quantity = parseInt(document.getElementById(`quantity-${checkbox.value}`).value);
                    totalQuantity += quantity; // Cộng dồn số lượng
                }
            });

            // Gửi yêu cầu AJAX để lấy tổng giá trị và số lượng của các sản phẩm đã chọn
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'calculate_total.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    // Cập nhật tổng số lượng và tổng giá trị từ phản hồi
                    document.getElementById('subtotal').value = totalQuantity; // Cập nhật tổng số lượng
                    document.getElementById('total').value = response.total.toFixed(2); // Tổng giá trị
                    document.getElementById('loyalty_points').value = response.loyalty_points;
                    document.getElementById('total-value').textContent = response.total.toFixed(2) + " VND";
                }
            };
            xhr.send(`selected_ids=${JSON.stringify(selectedIds)}`);
        }

        function updateQuantity(cartId, change) {
            const quantityInput = document.getElementById(`quantity-${cartId}`);
            let quantity = parseInt(quantityInput.value) + change;

            if (quantity < 1) quantity = 1;
            quantityInput.value = quantity;

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'update_quantity.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    document.getElementById(`total-price-${cartId}`).textContent = response.total_price_formatted +
                        ' VND';
                    calculateTotal();
                }
            };
            xhr.send(`cart_id=${cartId}&quantity=${quantity}`);
        }
    </script>
    <footer id="footer" class="footer color-bg">
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <div class="module-heading">
                            <h4 class="module-title">Contact Us</h4>
                        </div>
                        <!-- /.module-heading -->

                        <div class="module-body">
                            <ul class="toggle-footer" style="">
                                <li class="media">
                                    <div class="pull-left"> <span class="icon fa-stack fa-lg"> <i
                                                class="fa fa-map-marker fa-stack-1x fa-inverse"></i> </span> </div>
                                    <div class="media-body">
                                        <p>ThemesGround, 789 Main rd, Anytown, CA 12345 USA</p>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="pull-left"> <span class="icon fa-stack fa-lg"> <i
                                                class="fa fa-mobile fa-stack-1x fa-inverse"></i> </span> </div>
                                    <div class="media-body">
                                        <p>+(888) 123-4567<br>
                                            +(888) 456-7890</p>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="pull-left"> <span class="icon fa-stack fa-lg"> <i
                                                class="fa fa-envelope fa-stack-1x fa-inverse"></i> </span> </div>
                                    <div class="media-body"> <span><a href="#">flipmart@themesground.com</a></span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- /.module-body -->
                    </div>
                    <!-- /.col -->

                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <div class="module-heading">
                            <h4 class="module-title">Customer Service</h4>
                        </div>
                        <!-- /.module-heading -->

                        <div class="module-body">
                            <ul class='list-unstyled'>
                                <li class="first"><a href="#" title="Contact us">My Account</a></li>
                                <li><a href="#" title="About us">Order History</a></li>
                                <li><a href="#" title="faq">FAQ</a></li>
                                <li><a href="#" title="Popular Searches">Specials</a></li>
                                <li class="last"><a href="#" title="Where is my order?">Help Center</a></li>
                            </ul>
                        </div>
                        <!-- /.module-body -->
                    </div>
                    <!-- /.col -->

                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <div class="module-heading">
                            <h4 class="module-title">Corporation</h4>
                        </div>
                        <!-- /.module-heading -->

                        <div class="module-body">
                            <ul class='list-unstyled'>
                                <li class="first"><a title="Your Account" href="#">About us</a></li>
                                <li><a title="Information" href="#">Customer Service</a></li>
                                <li><a title="Addresses" href="#">Company</a></li>
                                <li><a title="Addresses" href="#">Investor Relations</a></li>
                                <li class="last"><a title="Orders History" href="#">Advanced Search</a></li>
                            </ul>
                        </div>
                        <!-- /.module-body -->
                    </div>
                    <!-- /.col -->

                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <div class="module-heading">
                            <h4 class="module-title">Why Choose Us</h4>
                        </div>
                        <!-- /.module-heading -->

                        <div class="module-body">
                            <ul class='list-unstyled'>
                                <li class="first"><a href="#" title="About us">Shopping Guide</a></li>
                                <li><a href="#" title="Blog">Blog</a></li>
                                <li><a href="#" title="Company">Company</a></li>
                                <li><a href="#" title="Investor Relations">Investor Relations</a></li>
                                <li class=" last"><a href="contact-us.html" title="Suppliers">Contact Us</a></li>
                            </ul>
                        </div>
                        <!-- /.module-body -->
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright-bar">
            <div class="container">
                <div class="col-xs-12 col-sm-6 no-padding social">
                    <ul class="link">
                        <li class="fb pull-left"><a target="_blank" rel="nofollow" href="#" title="Facebook"></a>
                        </li>
                        <li class="tw pull-left"><a target="_blank" rel="nofollow" href="#" title="Twitter"></a>
                        </li>
                        <li class="googleplus pull-left"><a target="_blank" rel="nofollow" href="#"
                                title="GooglePlus"></a></li>
                        <li class="rss pull-left"><a target="_blank" rel="nofollow" href="#" title="RSS"></a></li>
                        <li class="pintrest pull-left"><a target="_blank" rel="nofollow" href="#" title="PInterest"></a>
                        </li>
                        <li class="linkedin pull-left"><a target="_blank" rel="nofollow" href="#" title="Linkedin"></a>
                        </li>
                        <li class="youtube pull-left"><a target="_blank" rel="nofollow" href="#" title="Youtube"></a>
                        </li>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-6 no-padding">
                    <div class="clearfix payment-methods">
                        <ul>
                            <li><img src="assets\images\payments\1.png" alt=""></li>
                            <li><img src="assets\images\payments\2.png" alt=""></li>
                            <li><img src="assets\images\payments\3.png" alt=""></li>
                            <li><img src="assets\images\payments\4.png" alt=""></li>
                            <li><img src="assets\images\payments\5.png" alt=""></li>
                        </ul>
                    </div>
                    <!-- /.payment-methods -->
                </div>
            </div>
        </div>
    </footer>
</body>

</html>

<?php
$conn->close();
?>
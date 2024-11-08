<?php
// Bắt đầu session
session_start();

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['id'])) {
    die("Vui lòng đăng nhập để xem lịch sử đơn hàng.");
}

// Thông tin kết nối cơ sở dữ liệu
$servername = "localhost"; // Địa chỉ server của bạn
$username = "root";        // Tên người dùng MySQL
$password = "";            // Mật khẩu MySQL
$dbname = "user_registration"; // Tên cơ sở dữ liệu

// Kết nối cơ sở dữ liệu
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy ID người dùng từ session
$user_id = $_SESSION['id'];

// Truy vấn đơn hàng của người dùng và thông tin sản phẩm
$sql_orders = "SELECT o.order_id, o.total_price, o.total_quantity, o.loyalty_points, o.order_date,
               p.product_name, p.image, c.quantity
               FROM orders o
               JOIN cart c ON o.user_id = c.user_id
               JOIN products p ON c.product_id = p.product_id
               WHERE o.user_id = ?
               ORDER BY o.order_date DESC";

$stmt_orders = $conn->prepare($sql_orders);
$stmt_orders->bind_param("i", $user_id);
$stmt_orders->execute();
$result_orders = $stmt_orders->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quá Trình Đơn Hàng</title>
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
        .order {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #f9f9f9;
        }

        .product {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }

        .order-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            margin-right: 10px;
        }

        .nav-tabs .nav-link {
            border: 1px solid transparent;
            border-radius: 0.25rem;
        }

        .nav-tabs .nav-link.active {
            border-color: #007bff;
            background-color: #007bff;
            color: white;
        }

        .nav-tabs .nav-link:hover {
            border-color: #007bff;
            background-color: rgba(0, 123, 255, 0.1);
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
            <a href="#">
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
    <br><br><br><br><br>
    <div class="container mt-4">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="#">Tất cả</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Chờ xác nhận</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Đã xác nhận</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Chờ giao</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Đã giao</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Đã hủy</a>
            </li>
        </ul>
    </div>

    <div class="container">
        <h2 class="mt-4"></h2>
        <?php if ($result_orders && $result_orders->num_rows > 0): ?>
            <?php while ($order = $result_orders->fetch_assoc()): ?>
                <div class="order">
                    <h5>Mã đơn hàng: <strong><?php echo htmlspecialchars($order['order_id']); ?></strong></h5>
                    <p><strong>Ngày đặt hàng:</strong> <?php echo htmlspecialchars($order['order_date']); ?></p>
                    <p><strong>Tổng giá:</strong> <?php echo number_format($order['total_price'], 2); ?> VND</p>
                    <p><strong>Tổng số lượng:</strong> <?php echo htmlspecialchars($order['total_quantity']); ?></p>
                    <p><strong>Điểm cộng tích lũy:</strong> <?php echo htmlspecialchars($order['loyalty_points']); ?></p>

                    <!-- Hiển thị thông tin sản phẩm trong đơn hàng -->
                    <div class="product">
                        <img src="<?php echo htmlspecialchars($order['image']); ?>"
                            alt="<?php echo htmlspecialchars($order['product_name']); ?>" class="order-image">
                        <div>
                            <p><strong>Sản phẩm:</strong> <?php echo htmlspecialchars($order['product_name']); ?></p>
                            <p><strong>Số lượng:</strong> <?php echo htmlspecialchars($order['quantity']); ?></p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Chưa có đơn hàng nào.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
// Đóng kết nối
$conn->close();
?>
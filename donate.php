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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>

    <script src="donate.js" defer></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="./css/donate.css">
    <script src="donate.js" defer></script>
    <script src="js.js" defer></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="shortcut icon" href="image/vietnam.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="/css/bootstrap.min.css">

    <link rel="stylesheet" href="/css/main1.css">
    <link rel="stylesheet" href="/css/blue.css">
    <link rel="stylesheet" href="/css/owl.carousel.css">
    <link rel="stylesheet" href="/css/owl.transitions.css">
    <link rel="stylesheet" href="/css/animate.min.css">
    <link rel="stylesheet" href="/css/rateit.css">
    <link rel="stylesheet" href="/css/bootstrap-select.min.css">

    <!-- Icons/Glyphs -->
    <link rel="stylesheet" href="/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,600,600italic,700,700italic,800'
        rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <style>
        body {
            background-color: black !important;
        }

        .card-custom {
            width: 200px;
            /* Chỉnh kích thước card */
            margin: 10px auto;
            /* Thêm khoảng cách giữa các card */
        }

        .card-img-top,
        .card-img-bottom {
            width: 100%;
            height: auto;
        }

        .donation-form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-control,
        .btn {
            margin-top: 10px;
        }

        .btn-primary {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-primary:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .form-donate {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
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
            <a href="home.php" class="nav-link text-decoration-none ">Trang chủ</a>
            <a href="history.php" class="nav-link text-decoration-none ">Lịch Sử</a>
            <a href="product.php" class="nav-link text-decoration-none ">Sản phẩm</a>
            <a href="donate.php" class="nav-link text-decoration-none ">Quyên góp</a>
            <a href="contact.php" class="nav-link text-decoration-none ">Liên Hệ</a>
            <a href="blogs.php" class="nav-link text-decoration-none ">Blogs</a>
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

        <script>
            document.querySelector('.fas.fa-search').addEventListener('click', function() {
                var searchBox = document.getElementById('search-box');
                if (searchBox.style.display === 'none' || searchBox.style.display === '') {
                    searchBox.style.display = 'block';
                    searchBox.focus(); // Tự động đặt con trỏ vào ô nhập liệu
                } else {
                    searchBox.style.display = 'none';
                }
            });

            document.getElementById('search-box').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    var query = e.target.value;
                    window.location.href = 'search.php?query=' + query;
                }
            });
        </script>
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
    <br><br>
    </div>
    <div class="sec">
        <br><br><br>
        <section class="parallax-home">
            <img src="" alt="" id="">
            <img id="moon">
            <img>
            <img id="train">
            <div class="container">
                <div id="slide" class="slide">
                    <div class="item1" style="background-image: url(image/Treem/2.jpg);">
                        <div class="content">
                            <div class="name">LUNDEV</div>
                            <div class="des">Ghi vào....</div>
                            <button class="btn1">Read more</button>
                        </div>
                    </div>
                    <div class="item1" style="background-image: url(image/embe.png)">
                        <div class="content">
                            <div class="name">LUNDEV</div>
                            <div class="des">"Hãy cùng chúng tôi lan tỏa yêu thương và
                                chia sẻ gánh nặng với những nạn nhân chất độc da cam và
                                thân nhân của các liệt sĩ. Mỗi đồng quyên góp đều có giá trị,
                                hãy góp sức để mang lại niềm vui và hy
                                vọng cho họ!"</div>
                            <button class="btn1">Read more</button>
                        </div>
                    </div>
                    <div class="item1" style="background-image: url(image/Treem/3.jpg);">
                        <div class="content">
                            <div class="name">LUNDEV</div>
                            <div class="des">Ghi vào....</div>
                            <button class="btn1">Read more</button>
                        </div>
                    </div>
                    <div class="item1" style="background-image: url(image/Treem/4.jpg);">
                        <div class="content">
                            <div class="name">LUNDEV</div>
                            <div class="des">Ghi vào....</div>
                            <button class="btn1">Read more</button>
                        </div>
                    </div>
                    <div class="item1" style="background-image: url(image/Treem/5.jpg);">
                        <div class="content">
                            <div class="name">LUNDEV</div>
                            <div class="des">Ghi vào....</div>
                            <button class="btn1">Read more</button>
                        </div>
                    </div>
                    <div class="item1" style="background-image: url(image/Treem/6.jpg);">
                        <div class="content">
                            <div class="name">LUNDEV</div>
                            <div class="des">Ghi vào....</div>
                            <button class="btn1">Read more</button>
                        </div>
                    </div>
                </div>
                <div class="buttons">
                    <button id="prev"><i class="fas fa-angle-left"></i></button>
                    <button id="next"><i class="fas fa-angle-right"></i></button>
                </div>
            </div>

        </section>
    </div>

    <br><br><br>
    <div class="sec">
        <h2 style="color: aliceblue; text-align: center;"><strong>Dự án đang gây quỹ</strong></h2>
        <h3 style="color: antiquewhite; text-align: center;">Hãy lựa chọn đồng hành cùng dự án mà bạn quan tâm
        </h3>
        <div id="product-tabs-slider" class="scroll-tabs outer-top-vs wow fadeInUp">
            <div class="more-info-tab clearfix ">
                <h3 class="new-product-title pull-left"></h3>
                <ul class="nav nav-tabs nav-tab-line pull-right" id="new-products-1">
                    <li class="active"><a data-transition-type="backSlide" href="#all" data-toggle="tab">All</a>
                    </li>
                    <li><a data-transition-type="backSlide" href="#smartphone" data-toggle="tab">Trẻ em
                        </a></li>
                    <li><a data-transition-type="backSlide" href="#laptop" data-toggle="tab">Chất độc da cam</a>
                    </li>
                    <li><a data-transition-type="backSlide" href="#apple" data-toggle="tab">Thương binh liệt sĩ</a>
                    </li>
                </ul>
                <!-- /.nav-tabs -->
            </div>
            <div class="sec">
                <div class="tab-content outer-top-xs">
                    <div class="tab-pane in active" id="all">
                        <div class="product-slider">
                            <div class="owl-carousel home-owl-carousel custom-carousel owl-theme" data-item="4">
                                <div class="item item-carousel">
                                    <div class="products">
                                        <?php foreach ($products as $product): ?>
                                            <?php if ($product['product_id'] == 1): ?>
                                                <!-- Kiểm tra product_id -->
                                                <div class="product">
                                                    <div class="product-image">
                                                        <?php if (!empty($product['image'])): ?>
                                                            <a href="picture.php"><img
                                                                    id="product-image-<?php echo htmlspecialchars($product['product_id']); ?>"
                                                                    src="<?php echo htmlspecialchars($product['image']); ?>"
                                                                    alt="<?php echo htmlspecialchars($product['product_name']); ?>"></a>
                                                        <?php else: ?>
                                                            <img id="product-image-<?php echo htmlspecialchars($product['product_id']); ?>"
                                                                src="default_image.png" alt="No Image Available">
                                                        <?php endif; ?>
                                                        <div class="tag "><span>Trẻ em</span></div>
                                                    </div>
                                                    <div class="product-info text-left">
                                                        <h3 class="name">
                                                            <?php echo htmlspecialchars($product['product_name']); ?>
                                                        </h3>
                                                    </div>
                                                    <div class="product-price">
                                                        <strong class="price">
                                                            Giá: <span
                                                                class="current-price"><strong><?php echo htmlspecialchars($product['price']); ?>
                                                                    VND</strong></span>
                                                        </strong>
                                                    </div>
                                                    <div class="rating rateit-small"></div>

                                                    <form action="add_to_cart.php" method="POST" class="add-to-cart-form">
                                                        <input type="hidden" name="product_id"
                                                            value="<?php echo $product['product_id']; ?>">

                                                        <div class="quantity-container">
                                                            <div class="quant-input">
                                                                <div class="arrow plus gradient">
                                                                    <a
                                                                        href="update_quantity.php?cart_id=<?php echo $row['cart_id']; ?>&action=add">
                                                                        <span class="ir"><i class="fa fa-sort-asc"></i></span>
                                                                    </a>
                                                                </div>
                                                                <input type="number" name="quantity" value="1" min="1"
                                                                    class="quantity-input" required>
                                                                <div class="arrow minus gradient">
                                                                    <a
                                                                        href="update_quantity.php?cart_id=<?php echo $row['cart_id']; ?>&action=sub">
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
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <div class="item item-carousel">
                                    <div class="products">
                                        <?php foreach ($products as $product): ?>
                                            <?php if ($product['product_id'] == 3): ?>
                                                <!-- Kiểm tra product_id -->
                                                <div class="product">
                                                    <div class="product-image">
                                                        <?php if (!empty($product['image'])): ?>
                                                            <a href="picture.php"><img
                                                                    id="product-image-<?php echo htmlspecialchars($product['product_id']); ?>"
                                                                    src="<?php echo htmlspecialchars($product['image']); ?>"
                                                                    alt="<?php echo htmlspecialchars($product['product_name']); ?>"></a>
                                                        <?php else: ?>
                                                            <img id="product-image-<?php echo htmlspecialchars($product['product_id']); ?>"
                                                                src="default_image.png" alt="No Image Available">
                                                        <?php endif; ?>
                                                        <div class="tag "><span>Thiên tai</span></div>
                                                    </div>
                                                    <div class="product-info text-left">
                                                        <h3 class="name">
                                                            <?php echo htmlspecialchars($product['product_name']); ?>
                                                        </h3>
                                                    </div>
                                                    <div class="product-price">
                                                        <strong class="price">
                                                            Giá: <span
                                                                class="current-price"><strong><?php echo htmlspecialchars($product['price']); ?>
                                                                    VND</strong></span>
                                                        </strong>
                                                    </div>
                                                    <div class="rating rateit-small"></div>

                                                    <form action="add_to_cart.php" method="POST" class="add-to-cart-form">
                                                        <input type="hidden" name="product_id"
                                                            value="<?php echo $product['product_id']; ?>">
                                                        <div class="quantity-container">
                                                            <div class="quant-input">
                                                                <div class="arrow plus gradient">
                                                                    <a
                                                                        href="update_quantity.php?cart_id=<?php echo $row['cart_id']; ?>&action=add">
                                                                        <span class="ir"><i class="fa fa-sort-asc"></i></span>
                                                                    </a>
                                                                </div>
                                                                <input type="number" name="quantity" value="1" min="1"
                                                                    class="quantity-input" required>
                                                                <div class="arrow minus gradient">
                                                                    <a
                                                                        href="update_quantity.php?cart_id=<?php echo $row['cart_id']; ?>&action=sub">
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
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>


                                <div class="item item-carousel">
                                    <div class="products">
                                        <?php foreach ($products as $product): ?>
                                            <?php if ($product['product_id'] == 2): ?>
                                                <!-- Kiểm tra product_id -->
                                                <div class="product">
                                                    <div class="product-image">
                                                        <?php if (!empty($product['image'])): ?>
                                                            <a href="picture.php"><img
                                                                    id="product-image-<?php echo htmlspecialchars($product['product_id']); ?>"
                                                                    src="<?php echo htmlspecialchars($product['image']); ?>"
                                                                    alt="<?php echo htmlspecialchars($product['product_name']); ?>"></a>
                                                        <?php else: ?>
                                                            <img id="product-image-<?php echo htmlspecialchars($product['product_id']); ?>"
                                                                src="default_image.png" alt="No Image Available">
                                                        <?php endif; ?>
                                                        <div class="tag "><span>Thương binh liệt sĩ</span></div>
                                                    </div>
                                                    <div class="product-info text-left">
                                                        <h3 class="name">
                                                            <?php echo htmlspecialchars($product['product_name']); ?>
                                                        </h3>
                                                    </div>
                                                    <div class="product-price">
                                                        <strong class="price">
                                                            Giá: <span
                                                                class="current-price"><strong><?php echo htmlspecialchars($product['price']); ?>
                                                                    VND</strong></span>
                                                        </strong>
                                                    </div>
                                                    <div class="rating rateit-small"></div>

                                                    <form action="add_to_cart.php" method="POST" class="add-to-cart-form">
                                                        <input type="hidden" name="product_id"
                                                            value="<?php echo $product['product_id']; ?>">
                                                        <div class="quantity-container">
                                                            <div class="quant-input">
                                                                <div class="arrow plus gradient">
                                                                    <a
                                                                        href="update_quantity.php?cart_id=<?php echo $row['cart_id']; ?>&action=add">
                                                                        <span class="ir"><i class="fa fa-sort-asc"></i></span>
                                                                    </a>
                                                                </div>
                                                                <input type="number" name="quantity" value="1" min="1"
                                                                    class="quantity-input" required>
                                                                <div class="arrow minus gradient">
                                                                    <a
                                                                        href="update_quantity.php?cart_id=<?php echo $row['cart_id']; ?>&action=sub">
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
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <div class="item item-carousel">
                                    <div class="products">
                                        <?php foreach ($products as $product): ?>
                                            <?php if ($product['product_id'] == 4): ?>
                                                <!-- Kiểm tra product_id -->
                                                <div class="product">
                                                    <div class="product-image">
                                                        <?php if (!empty($product['image'])): ?>
                                                            <a href="picture.php"><img
                                                                    id="product-image-<?php echo htmlspecialchars($product['product_id']); ?>"
                                                                    src="<?php echo htmlspecialchars($product['image']); ?>"
                                                                    alt="<?php echo htmlspecialchars($product['product_name']); ?>"></a>
                                                        <?php else: ?>
                                                            <img id="product-image-<?php echo htmlspecialchars($product['product_id']); ?>"
                                                                src="default_image.png" alt="No Image Available">
                                                        <?php endif; ?>
                                                        <div class="tag "><span>Chất độc da cam</span></div>
                                                    </div>
                                                    <div class="product-info text-left">
                                                        <h3 class="name">
                                                            <?php echo htmlspecialchars($product['product_name']); ?>
                                                        </h3>
                                                    </div>
                                                    <div class="product-price">
                                                        <strong class="price">
                                                            Giá: <span
                                                                class="current-price"><strong><?php echo htmlspecialchars($product['price']); ?>
                                                                    VND</strong></span>
                                                        </strong>
                                                    </div>
                                                    <div class="rating rateit-small"></div>

                                                    <form action="add_to_cart.php" method="POST" class="add-to-cart-form">
                                                        <input type="hidden" name="product_id"
                                                            value="<?php echo $product['product_id']; ?>">
                                                        <div class="quantity-container">
                                                            <div class="quant-input">
                                                                <div class="arrow plus gradient">
                                                                    <a
                                                                        href="update_quantity.php?cart_id=<?php echo $row['cart_id']; ?>&action=add">
                                                                        <span class="ir"><i class="fa fa-sort-asc"></i></span>
                                                                    </a>
                                                                </div>
                                                                <input type="number" name="quantity" value="1" min="1"
                                                                    class="quantity-input" required>
                                                                <div class="arrow minus gradient">
                                                                    <a
                                                                        href="update_quantity.php?cart_id=<?php echo $row['cart_id']; ?>&action=sub">
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
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>


                                <div class="item item-carousel">
                                    <div class="products">
                                        <?php foreach ($products as $product): ?>
                                            <?php if ($product['product_id'] == 5): ?>
                                                <!-- Kiểm tra product_id -->
                                                <div class="product">
                                                    <div class="product-image">
                                                        <?php if (!empty($product['image'])): ?>
                                                            <a href="picture.php"><img
                                                                    id="product-image-<?php echo htmlspecialchars($product['product_id']); ?>"
                                                                    src="<?php echo htmlspecialchars($product['image']); ?>"
                                                                    alt="<?php echo htmlspecialchars($product['product_name']); ?>"></a>
                                                        <?php else: ?>
                                                            <img id="product-image-<?php echo htmlspecialchars($product['product_id']); ?>"
                                                                src="default_image.png" alt="No Image Available">
                                                        <?php endif; ?>
                                                        <div class="tag "><span>Trẻ em</span></div>
                                                    </div>
                                                    <div class="product-info text-left">
                                                        <h3 class="name">
                                                            <?php echo htmlspecialchars($product['product_name']); ?>
                                                        </h3>
                                                    </div>
                                                    <div class="product-price">
                                                        <strong class="price">
                                                            Giá: <span
                                                                class="current-price"><strong><?php echo htmlspecialchars($product['price']); ?>
                                                                    VND</strong></span>
                                                        </strong>
                                                    </div>
                                                    <div class="rating rateit-small"></div>

                                                    <form action="add_to_cart.php" method="POST" class="add-to-cart-form">
                                                        <input type="hidden" name="product_id"
                                                            value="<?php echo $product['product_id']; ?>">
                                                        <div class="quantity-container">
                                                            <div class="quant-input">
                                                                <div class="arrow plus gradient">
                                                                    <a
                                                                        href="update_quantity.php?cart_id=<?php echo $row['cart_id']; ?>&action=add">
                                                                        <span class="ir"><i class="fa fa-sort-asc"></i></span>
                                                                    </a>
                                                                </div>
                                                                <input type="number" name="quantity" value="1" min="1"
                                                                    class="quantity-input" required>
                                                                <div class="arrow minus gradient">
                                                                    <a
                                                                        href="update_quantity.php?cart_id=<?php echo $row['cart_id']; ?>&action=sub">
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
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <div class="item item-carousel">
                                    <div class="products">
                                        <?php foreach ($products as $product): ?>
                                            <?php if ($product['product_id'] == 6): ?>
                                                <!-- Kiểm tra product_id -->
                                                <div class="product">
                                                    <div class="product-image">
                                                        <?php if (!empty($product['image'])): ?>
                                                            <a href="picture.php"><img
                                                                    id="product-image-<?php echo htmlspecialchars($product['product_id']); ?>"
                                                                    src="<?php echo htmlspecialchars($product['image']); ?>"
                                                                    alt="<?php echo htmlspecialchars($product['product_name']); ?>"></a>
                                                        <?php else: ?>
                                                            <img id="product-image-<?php echo htmlspecialchars($product['product_id']); ?>"
                                                                src="default_image.png" alt="No Image Available">
                                                        <?php endif; ?>
                                                        <div class="tag "><span>Chất độc da cam</span></div>
                                                    </div>
                                                    <div class="product-info text-left">
                                                        <h3 class="name">
                                                            <?php echo htmlspecialchars($product['product_name']); ?>
                                                        </h3>
                                                    </div>
                                                    <div class="product-price">
                                                        <strong class="price">
                                                            Giá: <span
                                                                class="current-price"><strong><?php echo htmlspecialchars($product['price']); ?>
                                                                    VND</strong></span>
                                                        </strong>
                                                    </div>
                                                    <div class="rating rateit-small"></div>

                                                    <form action="add_to_cart.php" method="POST" class="add-to-cart-form">
                                                        <input type="hidden" name="product_id"
                                                            value="<?php echo $product['product_id']; ?>">
                                                        <div class="quantity-container">
                                                            <div class="quant-input">
                                                                <div class="arrow plus gradient">
                                                                    <a
                                                                        href="update_quantity.php?cart_id=<?php echo $row['cart_id']; ?>&action=add">
                                                                        <span class="ir"><i class="fa fa-sort-asc"></i></span>
                                                                    </a>
                                                                </div>
                                                                <input type="number" name="quantity" value="1" min="1"
                                                                    class="quantity-input" required>
                                                                <div class="arrow minus gradient">
                                                                    <a
                                                                        href="update_quantity.php?cart_id=<?php echo $row['cart_id']; ?>&action=sub">
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
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                            </div>
                            <!-- /.home-owl-carousel -->
                        </div>
                        <!-- /.product-slider -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <br><br><br><br><br>
    <div class="row">
        <div class="col-4">
            <div class="card"> <img class="card-img-top" " src=" image/chatdocdacam.png" alt="Card image">
                <div class="card-body">
                    <h4 class="card-title">John Doe</h4>
                    <p class="card-text">Some example text some example text. John Doe is an architect and engineer</p>
                    <a href="#" class="btn btn-primary">See Profile</a>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card" style="width:400px"> <img class="card-img-bottom" src="image/chatdocdacam.png"
                    alt="Card image" style="width:100%">
                <div class="card-body">
                    <h4 class="card-title">Jane Doe</h4>
                    <p class="card-text">Some example text some example text. Jane Doe is an architect and engineer</p>
                    <a href="#" class="btn btn-primary">See Profile</a>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card" style="width:400px"> <img class="card-img-bottom" src="image/chatdocdacam.png"
                    alt="Card image" style="width:100%">
                <div class="card-body">
                    <h4 class="card-title">Jane Doe</h4>
                    <p class="card-text">Some example text some example text. Jane Doe is an architect and engineer</p>
                    <a href="#" class="btn btn-primary">See Profile</a>
                </div>
            </div>
        </div>
    </div>
    <div class="form-donate">
        <div class="donation-form">
            <h1>Form Quyên Góp</h1>
            <form action="donate1.php" method="POST">
                <div class="form-group">
                    <label for="amount">Số tiền quyên góp</label>
                    <input type="number" id="amount" name="amount" class="form-control" placeholder="Số tiền quyên góp"
                        required>
                </div>
                <div class="form-group">
                    <label for="category">Chọn loại quyên góp</label>
                    <select id="category" name="category" class="form-control" required>
                        <option value="children">Trẻ em</option>
                        <option value="agent_orange">Chất độc da cam</option>
                        <option value="war_veterans">Thương binh liệt sĩ</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="message">Tin nhắn (không bắt buộc)</label>
                    <textarea id="message" name="message" class="form-control"
                        placeholder="Tin nhắn (không bắt buộc)"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Quyên góp</button>
            </form>
        </div>
    </div>
    </div>
    <script src="assets\js\jquery-1.11.1.min.js"></script>
    <script src="assets\js\bootstrap.min.js"></script>
    <script src="assets\js\bootstrap-hover-dropdown.min.js"></script>
    <script src="assets\js\owl.carousel.min.js"></script>
    <script src="assets\js\echo.min.js"></script>
    <script src="assets\js\jquery.easing-1.3.min.js"></script>
    <script src="assets\js\bootstrap-slider.min.js"></script>
    <script src="assets\js\jquery.rateit.min.js"></script>
    <script type="text/javascript" src="assets\js\lightbox.min.js"></script>
    <script src="assets\js\bootstrap-select.min.js"></script>
    <script src="assets\js\wow.min.js"></script>
    <script src="assets\js\scripts.js"></script>
</body>

</html>
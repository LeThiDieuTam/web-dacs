<?php
session_start(); // Bắt đầu session
include 'db.php'; // Kết nối cơ sở dữ liệu

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
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

// Khởi tạo biến thông báo
$message = '';

// Kiểm tra và hiển thị thông báo
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); // Xóa thông báo sau khi hiển thị
}
?>

<!-- Hiển thị thông báo nếu có -->
<?php if ($message): ?>
    <div id="notification" class="alert alert-success" role="alert">
        <?php echo htmlspecialchars($message); ?>
    </div>

    <script>
        // Tự động xóa thông báo sau 2 giây
        setTimeout(function() {
            document.getElementById('notification').style.display = 'none';
        }, 1000);
    </script>
<?php endif; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="MediaCenter, Template, eCommerce">
    <meta name="robots" content="all">
    <title>Flipmart premium HTML5 & CSS3 Template</title>
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
    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">

    <!-- Customizable CSS -->
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
</head>

<body class="cnt-home">

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

    </header><br> <br><br>
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="#">Home</a></li>
                    <li class='active'>Handbags</li>
                </ul>
            </div>
            <!-- /.breadcrumb-inner -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.breadcrumb -->
    <div class="body-content outer-top-xs">
        <div class='container'>
            <div class='row'>
                <div class='col-md-3 sidebar'>
                    <!-- ================================== TOP NAVIGATION ================================== -->
                    <div class="side-menu animate-dropdown outer-bottom-xs">
                        <div class="head"><i class="icon fa fa-align-justify fa-fw"></i> Categories</div>
                        <nav class="yamm megamenu-horizontal">
                            <ul class="nav">
                                <li class="dropdown menu-item"> <a href="#" class="dropdown-toggle"
                                        data-toggle="dropdown"><i class="icon fa fa-shopping-bag"
                                            aria-hidden="true"></i>Clothing</a>
                                    <ul class="dropdown-menu mega-menu">
                                        <li class="yamm-content">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-3">
                                                    <ul class="links list-unstyled">
                                                        <li><a href="#">Dresses</a></li>
                                                        <li><a href="#">Shoes </a></li>
                                                        <li><a href="#">Jackets</a></li>
                                                        <li><a href="#">Sunglasses</a></li>
                                                        <li><a href="#">Sport Wear</a></li>
                                                        <li><a href="#">Blazers</a></li>
                                                        <li><a href="#">Shirts</a></li>
                                                        <li><a href="#">Shorts</a></li>
                                                    </ul>
                                                </div>
                                                <!-- /.col -->
                                                <div class="col-sm-12 col-md-3">
                                                    <ul class="links list-unstyled">
                                                        <li><a href="#">Handbags</a></li>
                                                        <li><a href="#">Jwellery</a></li>
                                                        <li><a href="#">Swimwear </a></li>
                                                        <li><a href="#">Tops</a></li>
                                                        <li><a href="#">Flats</a></li>
                                                        <li><a href="#">Shoes</a></li>
                                                        <li><a href="#">Winter Wear</a></li>
                                                        <li><a href="#">Night Suits</a></li>
                                                    </ul>
                                                </div>
                                                <!-- /.col -->
                                                <div class="col-sm-12 col-md-3">
                                                    <ul class="links list-unstyled">
                                                        <li><a href="#">Toys &amp; Games</a></li>
                                                        <li><a href="#">Jeans</a></li>
                                                        <li><a href="#">Shirts</a></li>
                                                        <li><a href="#">Shoes</a></li>
                                                        <li><a href="#">School Bags</a></li>
                                                        <li><a href="#">Lunch Box</a></li>
                                                        <li><a href="#">Footwear</a></li>
                                                        <li><a href="#">Wipes</a></li>
                                                    </ul>
                                                </div>
                                                <!-- /.col -->
                                                <div class="col-sm-12 col-md-3">
                                                    <ul class="links list-unstyled">
                                                        <li><a href="#">Sandals </a></li>
                                                        <li><a href="#">Shorts</a></li>
                                                        <li><a href="#">Dresses</a></li>
                                                        <li><a href="#">Jwellery</a></li>
                                                        <li><a href="#">Bags</a></li>
                                                        <li><a href="#">Night Dress</a></li>
                                                        <li><a href="#">Swim Wear</a></li>
                                                        <li><a href="#">Toys</a></li>
                                                    </ul>
                                                </div>
                                                <!-- /.col -->
                                            </div>
                                            <!-- /.row -->
                                        </li>
                                        <!-- /.yamm-content -->
                                    </ul>
                                    <!-- /.dropdown-menu -->
                                </li>
                                <!-- /.menu-item -->

                                <li class="dropdown menu-item"> <a href="#" class="dropdown-toggle"
                                        data-toggle="dropdown"><i class="icon fa fa-laptop"
                                            aria-hidden="true"></i>Electronics</a>
                                    <!-- ================================== MEGAMENU VERTICAL ================================== -->
                                    <ul class="dropdown-menu mega-menu">
                                        <li class="yamm-content">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-lg-4">
                                                    <ul>
                                                        <li><a href="#">Gaming</a></li>
                                                        <li><a href="#">Laptop Skins</a></li>
                                                        <li><a href="#">Apple</a></li>
                                                        <li><a href="#">Dell</a></li>
                                                        <li><a href="#">Lenovo</a></li>
                                                        <li><a href="#">Microsoft</a></li>
                                                        <li><a href="#">Asus</a></li>
                                                        <li><a href="#">Adapters</a></li>
                                                        <li><a href="#">Batteries</a></li>
                                                        <li><a href="#">Cooling Pads</a></li>
                                                    </ul>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-lg-4">
                                                    <ul>
                                                        <li><a href="#">Routers &amp; Modems</a></li>
                                                        <li><a href="#">CPUs, Processors</a></li>
                                                        <li><a href="#">PC Gaming Store</a></li>
                                                        <li><a href="#">Graphics Cards</a></li>
                                                        <li><a href="#">Components</a></li>
                                                        <li><a href="#">Webcam</a></li>
                                                        <li><a href="#">Memory (RAM)</a></li>
                                                        <li><a href="#">Motherboards</a></li>
                                                        <li><a href="#">Keyboards</a></li>
                                                        <li><a href="#">Headphones</a></li>
                                                    </ul>
                                                </div>
                                                <div class="dropdown-banner-holder"> <a href="#"><img alt=""
                                                            src="assets\images\banners\banner-side.png"></a> </div>
                                            </div>
                                            <!-- /.row -->
                                        </li>
                                        <!-- /.yamm-content -->
                                    </ul>
                                    <!-- /.dropdown-menu -->
                                    <!-- ================================== MEGAMENU VERTICAL ================================== -->
                                </li>
                                <!-- /.menu-item -->

                                <li class="dropdown menu-item"> <a href="#" class="dropdown-toggle"
                                        data-toggle="dropdown"><i class="icon fa fa-paw"
                                            aria-hidden="true"></i>Shoes</a>
                                    <ul class="dropdown-menu mega-menu">
                                        <li class="yamm-content">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-3">
                                                    <ul class="links list-unstyled">
                                                        <li><a href="#">Dresses</a></li>
                                                        <li><a href="#">Shoes </a></li>
                                                        <li><a href="#">Jackets</a></li>
                                                        <li><a href="#">Sunglasses</a></li>
                                                        <li><a href="#">Sport Wear</a></li>
                                                        <li><a href="#">Blazers</a></li>
                                                        <li><a href="#">Shirts</a></li>
                                                        <li><a href="#">Shorts</a></li>
                                                    </ul>
                                                </div>
                                                <!-- /.col -->
                                                <div class="col-sm-12 col-md-3">
                                                    <ul class="links list-unstyled">
                                                        <li><a href="#">Handbags</a></li>
                                                        <li><a href="#">Jwellery</a></li>
                                                        <li><a href="#">Swimwear </a></li>
                                                        <li><a href="#">Tops</a></li>
                                                        <li><a href="#">Flats</a></li>
                                                        <li><a href="#">Shoes</a></li>
                                                        <li><a href="#">Winter Wear</a></li>
                                                        <li><a href="#">Night Suits</a></li>
                                                    </ul>
                                                </div>
                                                <!-- /.col -->
                                                <div class="col-sm-12 col-md-3">
                                                    <ul class="links list-unstyled">
                                                        <li><a href="#">Toys &amp; Games</a></li>
                                                        <li><a href="#">Jeans</a></li>
                                                        <li><a href="#">Shirts</a></li>
                                                        <li><a href="#">Shoes</a></li>
                                                        <li><a href="#">School Bags</a></li>
                                                        <li><a href="#">Lunch Box</a></li>
                                                        <li><a href="#">Footwear</a></li>
                                                        <li><a href="#">Wipes</a></li>
                                                    </ul>
                                                </div>
                                                <!-- /.col -->
                                                <div class="col-sm-12 col-md-3">
                                                    <ul class="links list-unstyled">
                                                        <li><a href="#">Sandals </a></li>
                                                        <li><a href="#">Shorts</a></li>
                                                        <li><a href="#">Dresses</a></li>
                                                        <li><a href="#">Jwellery</a></li>
                                                        <li><a href="#">Bags</a></li>
                                                        <li><a href="#">Night Dress</a></li>
                                                        <li><a href="#">Swim Wear</a></li>
                                                        <li><a href="#">Toys</a></li>
                                                    </ul>
                                                </div>
                                                <!-- /.col -->
                                            </div>
                                            <!-- /.row -->
                                        </li>
                                        <!-- /.yamm-content -->
                                    </ul>
                                    <!-- /.dropdown-menu -->
                                </li>
                                <!-- /.menu-item -->

                                <li class="dropdown menu-item"> <a href="#" class="dropdown-toggle"
                                        data-toggle="dropdown"><i class="icon fa fa-clock-o"></i>Watches</a>
                                    <ul class="dropdown-menu mega-menu">
                                        <li class="yamm-content">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-lg-4">
                                                    <ul>
                                                        <li><a href="#">Gaming</a></li>
                                                        <li><a href="#">Laptop Skins</a></li>
                                                        <li><a href="#">Apple</a></li>
                                                        <li><a href="#">Dell</a></li>
                                                        <li><a href="#">Lenovo</a></li>
                                                        <li><a href="#">Microsoft</a></li>
                                                        <li><a href="#">Asus</a></li>
                                                        <li><a href="#">Adapters</a></li>
                                                        <li><a href="#">Batteries</a></li>
                                                        <li><a href="#">Cooling Pads</a></li>
                                                    </ul>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-lg-4">
                                                    <ul>
                                                        <li><a href="#">Routers &amp; Modems</a></li>
                                                        <li><a href="#">CPUs, Processors</a></li>
                                                        <li><a href="#">PC Gaming Store</a></li>
                                                        <li><a href="#">Graphics Cards</a></li>
                                                        <li><a href="#">Components</a></li>
                                                        <li><a href="#">Webcam</a></li>
                                                        <li><a href="#">Memory (RAM)</a></li>
                                                        <li><a href="#">Motherboards</a></li>
                                                        <li><a href="#">Keyboards</a></li>
                                                        <li><a href="#">Headphones</a></li>
                                                    </ul>
                                                </div>
                                                <div class="dropdown-banner-holder"> <a href="#"><img alt=""
                                                            src="assets\images\banners\banner-side.png"></a> </div>
                                            </div>
                                            <!-- /.row -->
                                        </li>
                                        <!-- /.yamm-content -->
                                    </ul>
                                    <!-- /.dropdown-menu -->
                                </li>
                                <!-- /.menu-item -->

                                <li class="dropdown menu-item"> <a href="#" class="dropdown-toggle"
                                        data-toggle="dropdown"><i class="icon fa fa-diamond"></i>Jewellery</a>
                                    <ul class="dropdown-menu mega-menu">
                                        <li class="yamm-content">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-3">
                                                    <ul class="links list-unstyled">
                                                        <li><a href="#">Dresses</a></li>
                                                        <li><a href="#">Shoes </a></li>
                                                        <li><a href="#">Jackets</a></li>
                                                        <li><a href="#">Sunglasses</a></li>
                                                        <li><a href="#">Sport Wear</a></li>
                                                        <li><a href="#">Blazers</a></li>
                                                        <li><a href="#">Shirts</a></li>
                                                        <li><a href="#">Shorts</a></li>
                                                    </ul>
                                                </div>
                                                <!-- /.col -->
                                                <div class="col-sm-12 col-md-3">
                                                    <ul class="links list-unstyled">
                                                        <li><a href="#">Handbags</a></li>
                                                        <li><a href="#">Jwellery</a></li>
                                                        <li><a href="#">Swimwear </a></li>
                                                        <li><a href="#">Tops</a></li>
                                                        <li><a href="#">Flats</a></li>
                                                        <li><a href="#">Shoes</a></li>
                                                        <li><a href="#">Winter Wear</a></li>
                                                        <li><a href="#">Night Suits</a></li>
                                                    </ul>
                                                </div>
                                                <!-- /.col -->
                                                <div class="col-sm-12 col-md-3">
                                                    <ul class="links list-unstyled">
                                                        <li><a href="#">Toys &amp; Games</a></li>
                                                        <li><a href="#">Jeans</a></li>
                                                        <li><a href="#">Shirts</a></li>
                                                        <li><a href="#">Shoes</a></li>
                                                        <li><a href="#">School Bags</a></li>
                                                        <li><a href="#">Lunch Box</a></li>
                                                        <li><a href="#">Footwear</a></li>
                                                        <li><a href="#">Wipes</a></li>
                                                    </ul>
                                                </div>
                                                <!-- /.col -->
                                                <div class="col-sm-12 col-md-3">
                                                    <ul class="links list-unstyled">
                                                        <li><a href="#">Sandals </a></li>
                                                        <li><a href="#">Shorts</a></li>
                                                        <li><a href="#">Dresses</a></li>
                                                        <li><a href="#">Jwellery</a></li>
                                                        <li><a href="#">Bags</a></li>
                                                        <li><a href="#">Night Dress</a></li>
                                                        <li><a href="#">Swim Wear</a></li>
                                                        <li><a href="#">Toys</a></li>
                                                    </ul>
                                                </div>
                                                <!-- /.col -->
                                            </div>
                                            <!-- /.row -->
                                        </li>
                                        <!-- /.yamm-content -->
                                    </ul>
                                    <!-- /.dropdown-menu -->
                                </li>
                                <!-- /.menu-item -->

                                <li class="dropdown menu-item"> <a href="#" class="dropdown-toggle"
                                        data-toggle="dropdown"><i class="icon fa fa-heartbeat"></i>Health and Beauty</a>
                                    <ul class="dropdown-menu mega-menu">
                                        <li class="yamm-content">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-lg-4">
                                                    <ul>
                                                        <li><a href="#">Gaming</a></li>
                                                        <li><a href="#">Laptop Skins</a></li>
                                                        <li><a href="#">Apple</a></li>
                                                        <li><a href="#">Dell</a></li>
                                                        <li><a href="#">Lenovo</a></li>
                                                        <li><a href="#">Microsoft</a></li>
                                                        <li><a href="#">Asus</a></li>
                                                        <li><a href="#">Adapters</a></li>
                                                        <li><a href="#">Batteries</a></li>
                                                        <li><a href="#">Cooling Pads</a></li>
                                                    </ul>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-lg-4">
                                                    <ul>
                                                        <li><a href="#">Routers &amp; Modems</a></li>
                                                        <li><a href="#">CPUs, Processors</a></li>
                                                        <li><a href="#">PC Gaming Store</a></li>
                                                        <li><a href="#">Graphics Cards</a></li>
                                                        <li><a href="#">Components</a></li>
                                                        <li><a href="#">Webcam</a></li>
                                                        <li><a href="#">Memory (RAM)</a></li>
                                                        <li><a href="#">Motherboards</a></li>
                                                        <li><a href="#">Keyboards</a></li>
                                                        <li><a href="#">Headphones</a></li>
                                                    </ul>
                                                </div>
                                                <div class="dropdown-banner-holder"> <a href="#"><img alt=""
                                                            src="assets\images\banners\banner-side.png"></a> </div>
                                            </div>
                                            <!-- /.row -->
                                        </li>
                                        <!-- /.yamm-content -->
                                    </ul>
                                    <!-- /.dropdown-menu -->
                                </li>
                                <!-- /.menu-item -->

                                <li class="dropdown menu-item"> <a href="#" class="dropdown-toggle"
                                        data-toggle="dropdown"><i class="icon fa fa-paper-plane"></i>Kids and Babies</a>
                                    <!-- /.dropdown-menu -->
                                </li>
                                <!-- /.menu-item -->

                                <li class="dropdown menu-item"> <a href="#" class="dropdown-toggle"
                                        data-toggle="dropdown"><i class="icon fa fa-futbol-o"></i>Sports</a>
                                    <!-- ================================== MEGAMENU VERTICAL ================================== -->
                                    <!-- /.dropdown-menu -->
                                    <!-- ================================== MEGAMENU VERTICAL ================================== -->
                                </li>
                                <!-- /.menu-item -->

                                <li class="dropdown menu-item"> <a href="#" class="dropdown-toggle"
                                        data-toggle="dropdown"><i class="icon fa fa-envira"></i>Home and Garden</a>
                                    <!-- /.dropdown-menu -->
                                </li>
                                <!-- /.menu-item -->

                            </ul>
                            <!-- /.nav -->
                        </nav>
                        <!-- /.megamenu-horizontal -->
                    </div>
                    <!-- /.side-menu -->
                    <!-- ================================== TOP NAVIGATION : END ================================== -->
                    <div class="sidebar-module-container">
                        <div class="sidebar-filter">
                            <!-- ============================================== SIDEBAR CATEGORY ============================================== -->
                            <div class="sidebar-widget wow fadeInUp">
                                <h3 class="section-title">shop by</h3>
                                <div class="widget-header">
                                    <h4 class="widget-title">Category</h4>
                                </div>
                                <div class="sidebar-widget-body">
                                    <div class="accordion">
                                        <div class="accordion-group">
                                            <div class="accordion-heading"> <a href="#collapseOne"
                                                    data-toggle="collapse" class="accordion-toggle collapsed"> Camera
                                                </a> </div>
                                            <!-- /.accordion-heading -->
                                            <div class="accordion-body collapse" id="collapseOne" style="height: 0px;">
                                                <div class="accordion-inner">
                                                    <ul>
                                                        <li><a href="#">gaming</a></li>
                                                        <li><a href="#">office</a></li>
                                                        <li><a href="#">kids</a></li>
                                                        <li><a href="#">for women</a></li>
                                                    </ul>
                                                </div>
                                                <!-- /.accordion-inner -->
                                            </div>
                                            <!-- /.accordion-body -->
                                        </div>
                                        <!-- /.accordion-group -->

                                        <div class="accordion-group">
                                            <div class="accordion-heading"> <a href="#collapseTwo"
                                                    data-toggle="collapse" class="accordion-toggle collapsed"> Desktops
                                                </a> </div>
                                            <!-- /.accordion-heading -->
                                            <div class="accordion-body collapse" id="collapseTwo" style="height: 0px;">
                                                <div class="accordion-inner">
                                                    <ul>
                                                        <li><a href="#">gaming</a></li>
                                                        <li><a href="#">office</a></li>
                                                        <li><a href="#">kids</a></li>
                                                        <li><a href="#">for women</a></li>
                                                    </ul>
                                                </div>
                                                <!-- /.accordion-inner -->
                                            </div>
                                            <!-- /.accordion-body -->
                                        </div>
                                        <!-- /.accordion-group -->

                                        <div class="accordion-group">
                                            <div class="accordion-heading"> <a href="#collapseThree"
                                                    data-toggle="collapse" class="accordion-toggle collapsed"> Pants
                                                </a> </div>
                                            <!-- /.accordion-heading -->
                                            <div class="accordion-body collapse" id="collapseThree"
                                                style="height: 0px;">
                                                <div class="accordion-inner">
                                                    <ul>
                                                        <li><a href="#">gaming</a></li>
                                                        <li><a href="#">office</a></li>
                                                        <li><a href="#">kids</a></li>
                                                        <li><a href="#">for women</a></li>
                                                    </ul>
                                                </div>
                                                <!-- /.accordion-inner -->
                                            </div>
                                            <!-- /.accordion-body -->
                                        </div>
                                        <!-- /.accordion-group -->

                                        <div class="accordion-group">
                                            <div class="accordion-heading"> <a href="#collapseFour"
                                                    data-toggle="collapse" class="accordion-toggle collapsed"> Bags </a>
                                            </div>
                                            <!-- /.accordion-heading -->
                                            <div class="accordion-body collapse" id="collapseFour" style="height: 0px;">
                                                <div class="accordion-inner">
                                                    <ul>
                                                        <li><a href="#">gaming</a></li>
                                                        <li><a href="#">office</a></li>
                                                        <li><a href="#">kids</a></li>
                                                        <li><a href="#">for women</a></li>
                                                    </ul>
                                                </div>
                                                <!-- /.accordion-inner -->
                                            </div>
                                            <!-- /.accordion-body -->
                                        </div>
                                        <!-- /.accordion-group -->

                                        <div class="accordion-group">
                                            <div class="accordion-heading"> <a href="#collapseFive"
                                                    data-toggle="collapse" class="accordion-toggle collapsed"> Hats </a>
                                            </div>
                                            <!-- /.accordion-heading -->
                                            <div class="accordion-body collapse" id="collapseFive" style="height: 0px;">
                                                <div class="accordion-inner">
                                                    <ul>
                                                        <li><a href="#">gaming</a></li>
                                                        <li><a href="#">office</a></li>
                                                        <li><a href="#">kids</a></li>
                                                        <li><a href="#">for women</a></li>
                                                    </ul>
                                                </div>
                                                <!-- /.accordion-inner -->
                                            </div>
                                            <!-- /.accordion-body -->
                                        </div>
                                        <!-- /.accordion-group -->

                                        <div class="accordion-group">
                                            <div class="accordion-heading"> <a href="#collapseSix"
                                                    data-toggle="collapse" class="accordion-toggle collapsed">
                                                    Accessories </a> </div>
                                            <!-- /.accordion-heading -->
                                            <div class="accordion-body collapse" id="collapseSix" style="height: 0px;">
                                                <div class="accordion-inner">
                                                    <ul>
                                                        <li><a href="#">gaming</a></li>
                                                        <li><a href="#">office</a></li>
                                                        <li><a href="#">kids</a></li>
                                                        <li><a href="#">for women</a></li>
                                                    </ul>
                                                </div>
                                                <!-- /.accordion-inner -->
                                            </div>
                                            <!-- /.accordion-body -->
                                        </div>
                                        <!-- /.accordion-group -->

                                    </div>
                                    <!-- /.accordion -->
                                </div>
                                <!-- /.sidebar-widget-body -->
                            </div>
                            <!-- /.sidebar-widget -->
                            <!-- ============================================== SIDEBAR CATEGORY : END ============================================== -->

                            <!-- ============================================== PRICE SILDER============================================== -->
                            <div class="sidebar-widget wow fadeInUp">
                                <div class="widget-header">
                                    <h4 class="widget-title">Price Slider</h4>
                                </div>
                                <div class="sidebar-widget-body m-t-10">
                                    <div class="price-range-holder"> <span class="min-max"> <span
                                                class="pull-left">$200.00</span> <span class="pull-right">$800.00</span>
                                        </span>
                                        <input type="text" id="amount"
                                            style="border:0; color:#666666; font-weight:bold;text-align:center;">
                                        <input type="text" class="price-slider" value="">
                                    </div>
                                    <!-- /.price-range-holder -->
                                    <a href="#" class="lnk btn btn-primary">Show Now</a>
                                </div>
                                <!-- /.sidebar-widget-body -->
                            </div>
                            <!-- /.sidebar-widget -->
                            <!-- ============================================== PRICE SILDER : END ============================================== -->
                            <!-- ============================================== MANUFACTURES============================================== -->
                            <div class="sidebar-widget wow fadeInUp">
                                <div class="widget-header">
                                    <h4 class="widget-title">Manufactures</h4>
                                </div>
                                <div class="sidebar-widget-body">
                                    <ul class="list">
                                        <li><a href="#">Forever 18</a></li>
                                        <li><a href="#">Nike</a></li>
                                        <li><a href="#">Dolce & Gabbana</a></li>
                                        <li><a href="#">Alluare</a></li>
                                        <li><a href="#">Chanel</a></li>
                                        <li><a href="#">Other Brand</a></li>
                                    </ul>
                                    <!--<a href="#" class="lnk btn btn-primary">Show Now</a>-->
                                </div>
                                <!-- /.sidebar-widget-body -->
                            </div>
                            <!-- /.sidebar-widget -->
                            <!-- ============================================== MANUFACTURES: END ============================================== -->
                            <!-- ============================================== COLOR============================================== -->
                            <div class="sidebar-widget wow fadeInUp">
                                <div class="widget-header">
                                    <h4 class="widget-title">Colors</h4>
                                </div>
                                <div class="sidebar-widget-body">
                                    <ul class="list">
                                        <li><a href="#">Red</a></li>
                                        <li><a href="#">Blue</a></li>
                                        <li><a href="#">Yellow</a></li>
                                        <li><a href="#">Pink</a></li>
                                        <li><a href="#">Brown</a></li>
                                        <li><a href="#">Teal</a></li>
                                    </ul>
                                </div>
                                <!-- /.sidebar-widget-body -->
                            </div>
                            <!-- /.sidebar-widget -->
                            <!-- ============================================== COLOR: END ============================================== -->
                            <!-- ============================================== COMPARE============================================== -->
                            <div class="sidebar-widget wow fadeInUp outer-top-vs">
                                <h3 class="section-title">Compare products</h3>
                                <div class="sidebar-widget-body">
                                    <div class="compare-report">
                                        <p>You have no <span>item(s)</span> to compare</p>
                                    </div>
                                    <!-- /.compare-report -->
                                </div>
                                <!-- /.sidebar-widget-body -->
                            </div>
                            <!-- /.sidebar-widget -->
                            <!-- ============================================== COMPARE: END ============================================== -->
                            <!-- ============================================== PRODUCT TAGS ============================================== -->
                            <div class="sidebar-widget product-tag wow fadeInUp outer-top-vs">
                                <h3 class="section-title">Product tags</h3>
                                <div class="sidebar-widget-body outer-top-xs">
                                    <div class="tag-list"> <a class="item" title="Phone" href="category.html">Phone</a>
                                        <a class="item active" title="Vest" href="category.html">Vest</a> <a
                                            class="item" title="Smartphone" href="category.html">Smartphone</a> <a
                                            class="item" title="Furniture" href="category.html">Furniture</a> <a
                                            class="item" title="T-shirt" href="category.html">T-shirt</a> <a
                                            class="item" title="Sweatpants" href="category.html">Sweatpants</a> <a
                                            class="item" title="Sneaker" href="category.html">Sneaker</a> <a
                                            class="item" title="Toys" href="category.html">Toys</a> <a class="item"
                                            title="Rose" href="category.html">Rose</a>
                                    </div>
                                    <!-- /.tag-list -->
                                </div>
                                <!-- /.sidebar-widget-body -->
                            </div>
                            <!-- /.sidebar-widget -->
                            <!----------- Testimonials------------->
                            <div class="sidebar-widget  wow fadeInUp outer-top-vs ">
                                <div id="advertisement" class="advertisement">
                                    <div class="item">
                                        <div class="avatar"><img src="assets\images\testimonials\member1.png"
                                                alt="Image">
                                        </div>
                                        <div class="testimonials"><em>"</em> Vtae sodales aliq uam morbi non sem lacus
                                            port
                                            mollis. Nunc condime tum metus eud molest sed consectetuer.<em>"</em></div>
                                        <div class="clients_author">John Doe <span>Abc Company</span> </div>
                                        <!-- /.container-fluid -->
                                    </div>
                                    <!-- /.item -->

                                    <div class="item">
                                        <div class="avatar"><img src="assets\images\testimonials\member3.png"
                                                alt="Image">
                                        </div>
                                        <div class="testimonials"><em>"</em>Vtae sodales aliq uam morbi non sem lacus
                                            port
                                            mollis. Nunc condime tum metus eud molest sed consectetuer.<em>"</em></div>
                                        <div class="clients_author">Stephen Doe <span>Xperia Designs</span> </div>
                                    </div>
                                    <!-- /.item -->

                                    <div class="item">
                                        <div class="avatar"><img src="assets\images\testimonials\member2.png"
                                                alt="Image">
                                        </div>
                                        <div class="testimonials"><em>"</em> Vtae sodales aliq uam morbi non sem lacus
                                            port
                                            mollis. Nunc condime tum metus eud molest sed consectetuer.<em>"</em></div>
                                        <div class="clients_author">Saraha Smith <span>Datsun &amp; Co</span> </div>
                                        <!-- /.container-fluid -->
                                    </div>
                                    <!-- /.item -->

                                </div>
                                <!-- /.owl-carousel -->
                            </div>

                            <!-- ============================================== Testimonials: END ============================================== -->

                            <div class="home-banner"> <img src="assets\images\banners\LHS-banner.jpg" alt="Image">
                            </div>
                        </div>
                        <!-- /.sidebar-filter -->
                    </div>
                    <!-- /.sidebar-module-container -->
                </div>
                <!-- /.sidebar -->
                <div class='col-md-9'>
                    <!-- ========================================== SECTION – HERO ========================================= -->

                    <div id="category" class="category-carousel hidden-xs">
                        <div class="item">
                            <div class="image"> <img src="assets\images\banners\cat-banner-1.jpg" alt=""
                                    class="img-responsive"> </div>
                            <div class="container-fluid">
                                <div class="caption vertical-top text-left">
                                    <div class="big-text"> Big Sale </div>
                                    <div class="excerpt hidden-sm hidden-md"> Save up to 49% off </div>
                                    <div class="excerpt-normal hidden-sm hidden-md"> Lorem ipsum dolor sit amet,
                                        consectetur
                                        adipiscing elit </div>
                                </div>
                                <!-- /.caption -->
                            </div>
                            <!-- /.container-fluid -->
                        </div>
                    </div>


                    <div class="clearfix filters-container m-t-10">
                        <div class="row">
                            <div class="col col-sm-6 col-md-2">
                                <div class="filter-tabs">
                                    <ul id="filter-tabs" class="nav nav-tabs nav-tab-box nav-tab-fa-icon">
                                        <li class="active"> <a data-toggle="tab" href="#grid-container"><i
                                                    class="icon fa fa-th-large"></i>Grid</a> </li>
                                        <li><a data-toggle="tab" href="#list-container"><i
                                                    class="icon fa fa-th-list"></i>List</a></li>
                                    </ul>
                                </div>
                                <!-- /.filter-tabs -->
                            </div>
                            <!-- /.col -->
                            <div class="col col-sm-12 col-md-6">
                                <div class="col col-sm-3 col-md-6 no-padding">
                                    <div class="lbl-cnt"> <span class="lbl">Sort by</span>
                                        <div class="fld inline">
                                            <div class="dropdown dropdown-small dropdown-med dropdown-white inline">
                                                <button data-toggle="dropdown" type="button"
                                                    class="btn dropdown-toggle">
                                                    Position <span class="caret"></span> </button>
                                                <ul role="menu" class="dropdown-menu">
                                                    <li role="presentation"><a href="#">position</a></li>
                                                    <li role="presentation"><a href="#">Price:Lowest first</a></li>
                                                    <li role="presentation"><a href="#">Price:HIghest first</a></li>
                                                    <li role="presentation"><a href="#">Product Name:A to Z</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- /.fld -->
                                    </div>
                                    <!-- /.lbl-cnt -->
                                </div>
                                <!-- /.col -->
                                <div class="col col-sm-3 col-md-6 no-padding">
                                    <div class="lbl-cnt"> <span class="lbl">Show</span>
                                        <div class="fld inline">
                                            <div class="dropdown dropdown-small dropdown-med dropdown-white inline">
                                                <button data-toggle="dropdown" type="button"
                                                    class="btn dropdown-toggle"> 1
                                                    <span class="caret"></span> </button>
                                                <ul role="menu" class="dropdown-menu">
                                                    <li role="presentation"><a href="#">1</a></li>
                                                    <li role="presentation"><a href="#">2</a></li>
                                                    <li role="presentation"><a href="#">3</a></li>
                                                    <li role="presentation"><a href="#">4</a></li>
                                                    <li role="presentation"><a href="#">5</a></li>
                                                    <li role="presentation"><a href="#">6</a></li>
                                                    <li role="presentation"><a href="#">7</a></li>
                                                    <li role="presentation"><a href="#">8</a></li>
                                                    <li role="presentation"><a href="#">9</a></li>
                                                    <li role="presentation"><a href="#">10</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- /.fld -->
                                    </div>
                                    <!-- /.lbl-cnt -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.col -->
                            <div class="col col-sm-6 col-md-4 text-right">
                                <div class="pagination-container">
                                    <ul class="list-inline list-unstyled">
                                        <li class="prev"><a href="#"><i class="fa fa-angle-left"></i></a></li>
                                        <li><a href="#">1</a></li>
                                        <li class="active"><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li><a href="#">4</a></li>
                                        <li class="next"><a href="#"><i class="fa fa-angle-right"></i></a></li>
                                    </ul>
                                    <!-- /.list-inline -->
                                </div>
                                <!-- /.pagination-container -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <div class="search-result-container ">
                        <div id="myTabContent" class="tab-content category-list">
                            <div class="tab-pane active " id="grid-container">
                                <div class="category-product">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-4 wow fadeInUp">
                                            <div class="products">
                                                <div class="product">
                                                    <div class="product-image">
                                                        <div class="image"> <a href="detail.html"><img
                                                                    src="assets\images\products\p5.jpg" alt=""></a>
                                                        </div>
                                                        <!-- /.image -->

                                                        <div class="tag new"><span>new</span></div>
                                                    </div>
                                                    <!-- /.product-image -->

                                                    <div class="product-info text-left">
                                                        <h3 class="name"><a href="detail.html">Floral Print Buttoned</a>
                                                        </h3>
                                                        <div class="rating rateit-small"></div>
                                                        <div class="description"></div>
                                                        <div class="product-price"> <span class="price"> $450.99 </span>
                                                            <span class="price-before-discount">$ 800</span>
                                                        </div>
                                                        <!-- /.product-price -->

                                                    </div>
                                                    <!-- /.product-info -->
                                                    <div class="cart clearfix animate-effect">
                                                        <div class="action">
                                                            <ul class="list-unstyled">
                                                                <li class="add-cart-button btn-group">
                                                                    <button class="btn btn-primary icon"
                                                                        data-toggle="dropdown" type="button"> <i
                                                                            class="fa fa-shopping-cart"></i> </button>
                                                                    <button class="btn btn-primary cart-btn"
                                                                        type="button">Add to cart</button>
                                                                </li>
                                                                <li class="lnk wishlist"> <a class="add-to-cart"
                                                                        href="detail.html" title="Wishlist"> <i
                                                                            class="icon fa fa-heart"></i> </a> </li>
                                                                <li class="lnk"> <a class="add-to-cart"
                                                                        href="detail.html" title="Compare"> <i
                                                                            class="fa fa-signal"></i> </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <!-- /.action -->
                                                    </div>
                                                    <!-- /.cart -->
                                                </div>
                                                <!-- /.product -->

                                            </div>
                                            <!-- /.products -->
                                        </div>
                                        <!-- /.item -->

                                        <div class="col-sm-6 col-md-4 wow fadeInUp">
                                            <div class="products">
                                                <div class="product">
                                                    <div class="product-image">
                                                        <div class="image"> <a href="detail.html"><img
                                                                    src="assets\images\products\p1.jpg" alt=""></a>
                                                        </div>
                                                        <!-- /.image -->

                                                        <div class="tag sale"><span>sale</span></div>
                                                    </div>
                                                    <!-- /.product-image -->

                                                    <div class="product-info text-left">
                                                        <h3 class="name"><a href="detail.html">Floral Print Buttoned</a>
                                                        </h3>
                                                        <div class="rating rateit-small"></div>
                                                        <div class="description"></div>
                                                        <div class="product-price"> <span class="price"> $450.99 </span>
                                                            <span class="price-before-discount">$ 800</span>
                                                        </div>
                                                        <!-- /.product-price -->

                                                    </div>
                                                    <!-- /.product-info -->
                                                    <div class="cart clearfix animate-effect">
                                                        <div class="action">
                                                            <ul class="list-unstyled">
                                                                <li class="add-cart-button btn-group">
                                                                    <button class="btn btn-primary icon"
                                                                        data-toggle="dropdown" type="button"> <i
                                                                            class="fa fa-shopping-cart"></i> </button>
                                                                    <button class="btn btn-primary cart-btn"
                                                                        type="button">Add to cart</button>
                                                                </li>
                                                                <li class="lnk wishlist"> <a class="add-to-cart"
                                                                        href="detail.html" title="Wishlist"> <i
                                                                            class="icon fa fa-heart"></i> </a> </li>
                                                                <li class="lnk"> <a class="add-to-cart"
                                                                        href="detail.html" title="Compare"> <i
                                                                            class="fa fa-signal"></i> </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <!-- /.action -->
                                                    </div>
                                                    <!-- /.cart -->
                                                </div>
                                                <!-- /.product -->

                                            </div>
                                            <!-- /.products -->
                                        </div>
                                        <!-- /.item -->

                                        <div class="col-sm-6 col-md-4 wow fadeInUp">
                                            <div class="products">
                                                <div class="product">
                                                    <div class="product-image">
                                                        <div class="image"> <a href="detail.html"><img
                                                                    src="assets\images\products\p6.jpg" alt=""></a>
                                                        </div>
                                                        <!-- /.image -->

                                                        <div class="tag hot"><span>hot</span></div>
                                                    </div>
                                                    <!-- /.product-image -->

                                                    <div class="product-info text-left">
                                                        <h3 class="name"><a href="detail.html">Floral Print Buttoned</a>
                                                        </h3>
                                                        <div class="rating rateit-small"></div>
                                                        <div class="description"></div>
                                                        <div class="product-price"> <span class="price"> $450.99 </span>
                                                            <span class="price-before-discount">$ 800</span>
                                                        </div>
                                                        <!-- /.product-price -->

                                                    </div>
                                                    <!-- /.product-info -->
                                                    <div class="cart clearfix animate-effect">
                                                        <div class="action">
                                                            <ul class="list-unstyled">
                                                                <li class="add-cart-button btn-group">
                                                                    <button class="btn btn-primary icon"
                                                                        data-toggle="dropdown" type="button"> <i
                                                                            class="fa fa-shopping-cart"></i> </button>
                                                                    <button class="btn btn-primary cart-btn"
                                                                        type="button">Add to cart</button>
                                                                </li>
                                                                <li class="lnk wishlist"> <a class="add-to-cart"
                                                                        href="detail.html" title="Wishlist"> <i
                                                                            class="icon fa fa-heart"></i> </a> </li>
                                                                <li class="lnk"> <a class="add-to-cart"
                                                                        href="detail.html" title="Compare"> <i
                                                                            class="fa fa-signal"></i> </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <!-- /.action -->
                                                    </div>
                                                    <!-- /.cart -->
                                                </div>
                                                <!-- /.product -->

                                            </div>
                                            <!-- /.products -->
                                        </div>
                                        <!-- /.item -->

                                        <div class="col-sm-6 col-md-4 wow fadeInUp">
                                            <div class="products">
                                                <div class="product">
                                                    <div class="product-image">
                                                        <div class="image"> <a href="detail.html"><img
                                                                    src="assets\images\products\p6.jpg" alt=""></a>
                                                        </div>
                                                        <!-- /.image -->

                                                        <div class="tag hot"><span>hot</span></div>
                                                    </div>
                                                    <!-- /.product-image -->

                                                    <div class="product-info text-left">
                                                        <h3 class="name"><a href="detail.html">Floral Print Buttoned</a>
                                                        </h3>
                                                        <div class="rating rateit-small"></div>
                                                        <div class="description"></div>
                                                        <div class="product-price"> <span class="price"> $450.99 </span>
                                                            <span class="price-before-discount">$ 800</span>
                                                        </div>
                                                        <!-- /.product-price -->

                                                    </div>
                                                    <!-- /.product-info -->
                                                    <div class="cart clearfix animate-effect">
                                                        <div class="action">
                                                            <ul class="list-unstyled">
                                                                <li class="add-cart-button btn-group">
                                                                    <button class="btn btn-primary icon"
                                                                        data-toggle="dropdown" type="button"> <i
                                                                            class="fa fa-shopping-cart"></i> </button>
                                                                    <button class="btn btn-primary cart-btn"
                                                                        type="button">Add to cart</button>
                                                                </li>
                                                                <li class="lnk wishlist"> <a class="add-to-cart"
                                                                        href="detail.html" title="Wishlist"> <i
                                                                            class="icon fa fa-heart"></i> </a> </li>
                                                                <li class="lnk"> <a class="add-to-cart"
                                                                        href="detail.html" title="Compare"> <i
                                                                            class="fa fa-signal"></i> </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <!-- /.action -->
                                                    </div>
                                                    <!-- /.cart -->
                                                </div>
                                                <!-- /.product -->

                                            </div>
                                            <!-- /.products -->
                                        </div>
                                        <!-- /.item -->

                                        <div class="col-sm-6 col-md-4 wow fadeInUp">
                                            <div class="products">
                                                <div class="product">
                                                    <div class="product-image">
                                                        <div class="image"> <a href="detail.html"><img
                                                                    src="assets\images\products\p7.jpg" alt=""></a>
                                                        </div>
                                                        <!-- /.image -->

                                                        <div class="tag sale"><span>sale</span></div>
                                                    </div>
                                                    <!-- /.product-image -->

                                                    <div class="product-info text-left">
                                                        <h3 class="name"><a href="detail.html">Floral Print Buttoned</a>
                                                        </h3>
                                                        <div class="rating rateit-small"></div>
                                                        <div class="description"></div>
                                                        <div class="product-price"> <span class="price"> $450.99 </span>
                                                            <span class="price-before-discount">$ 800</span>
                                                        </div>
                                                        <!-- /.product-price -->

                                                    </div>
                                                    <!-- /.product-info -->
                                                    <div class="cart clearfix animate-effect">
                                                        <div class="action">
                                                            <ul class="list-unstyled">
                                                                <li class="add-cart-button btn-group">
                                                                    <button class="btn btn-primary icon"
                                                                        data-toggle="dropdown" type="button"> <i
                                                                            class="fa fa-shopping-cart"></i> </button>
                                                                    <button class="btn btn-primary cart-btn"
                                                                        type="button">Add to cart</button>
                                                                </li>
                                                                <li class="lnk wishlist"> <a class="add-to-cart"
                                                                        href="detail.html" title="Wishlist"> <i
                                                                            class="icon fa fa-heart"></i> </a> </li>
                                                                <li class="lnk"> <a class="add-to-cart"
                                                                        href="detail.html" title="Compare"> <i
                                                                            class="fa fa-signal"></i> </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <!-- /.action -->
                                                    </div>
                                                    <!-- /.cart -->
                                                </div>
                                                <!-- /.product -->

                                            </div>
                                            <!-- /.products -->
                                        </div>
                                        <!-- /.item -->

                                        <div class="col-sm-6 col-md-4 wow fadeInUp">
                                            <div class="products">
                                                <div class="product">
                                                    <div class="product-image">
                                                        <div class="image"> <a href="detail.html"><img
                                                                    src="assets\images\products\p8.jpg" alt=""></a>
                                                        </div>
                                                        <!-- /.image -->

                                                        <div class="tag new"><span>new</span></div>
                                                    </div>
                                                    <!-- /.product-image -->

                                                    <div class="product-info text-left">
                                                        <h3 class="name"><a href="detail.html">Floral Print Buttoned</a>
                                                        </h3>
                                                        <div class="rating rateit-small"></div>
                                                        <div class="description"></div>
                                                        <div class="product-price"> <span class="price"> $450.99 </span>
                                                            <span class="price-before-discount">$ 800</span>
                                                        </div>
                                                        <!-- /.product-price -->

                                                    </div>
                                                    <!-- /.product-info -->
                                                    <div class="cart clearfix animate-effect">
                                                        <div class="action">
                                                            <ul class="list-unstyled">
                                                                <li class="add-cart-button btn-group">
                                                                    <button class="btn btn-primary icon"
                                                                        data-toggle="dropdown" type="button"> <i
                                                                            class="fa fa-shopping-cart"></i> </button>
                                                                    <button class="btn btn-primary cart-btn"
                                                                        type="button">Add to cart</button>
                                                                </li>
                                                                <li class="lnk wishlist"> <a class="add-to-cart"
                                                                        href="detail.html" title="Wishlist"> <i
                                                                            class="icon fa fa-heart"></i> </a> </li>
                                                                <li class="lnk"> <a class="add-to-cart"
                                                                        href="detail.html" title="Compare"> <i
                                                                            class="fa fa-signal"></i> </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <!-- /.action -->
                                                    </div>
                                                    <!-- /.cart -->
                                                </div>
                                                <!-- /.product -->

                                            </div>
                                            <!-- /.products -->
                                        </div>
                                        <!-- /.item -->

                                        <div class="col-sm-6 col-md-4 wow fadeInUp">
                                            <div class="products">
                                                <div class="product">
                                                    <div class="product-image">
                                                        <div class="image"> <a href="detail.html"><img
                                                                    src="assets\images\products\p9.jpg" alt=""></a>
                                                        </div>
                                                        <!-- /.image -->

                                                        <div class="tag new"><span>new</span></div>
                                                    </div>
                                                    <!-- /.product-image -->

                                                    <div class="product-info text-left">
                                                        <h3 class="name"><a href="detail.html">Floral Print Buttoned</a>
                                                        </h3>
                                                        <div class="rating rateit-small"></div>
                                                        <div class="description"></div>
                                                        <div class="product-price"> <span class="price"> $450.99 </span>
                                                            <span class="price-before-discount">$ 800</span>
                                                        </div>
                                                        <!-- /.product-price -->

                                                    </div>
                                                    <!-- /.product-info -->
                                                    <div class="cart clearfix animate-effect">
                                                        <div class="action">
                                                            <ul class="list-unstyled">
                                                                <li class="add-cart-button btn-group">
                                                                    <button class="btn btn-primary icon"
                                                                        data-toggle="dropdown" type="button"> <i
                                                                            class="fa fa-shopping-cart"></i> </button>
                                                                    <button class="btn btn-primary cart-btn"
                                                                        type="button">Add to cart</button>
                                                                </li>
                                                                <li class="lnk wishlist"> <a class="add-to-cart"
                                                                        href="detail.html" title="Wishlist"> <i
                                                                            class="icon fa fa-heart"></i> </a> </li>
                                                                <li class="lnk"> <a class="add-to-cart"
                                                                        href="detail.html" title="Compare"> <i
                                                                            class="fa fa-signal"></i> </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <!-- /.action -->
                                                    </div>
                                                    <!-- /.cart -->
                                                </div>
                                                <!-- /.product -->

                                            </div>
                                            <!-- /.products -->
                                        </div>
                                        <!-- /.item -->

                                        <div class="col-sm-6 col-md-4 wow fadeInUp">
                                            <div class="products">
                                                <div class="product">
                                                    <div class="product-image">
                                                        <div class="image"> <a href="detail.html"><img
                                                                    src="assets\images\products\p10.jpg" alt=""></a>
                                                        </div>
                                                        <!-- /.image -->

                                                        <div class="tag sale"><span>sale</span></div>
                                                    </div>
                                                    <!-- /.product-image -->

                                                    <div class="product-info text-left">
                                                        <h3 class="name"><a href="detail.html">Floral Print Buttoned</a>
                                                        </h3>
                                                        <div class="rating rateit-small"></div>
                                                        <div class="description"></div>
                                                        <div class="product-price"> <span class="price"> $450.99 </span>
                                                            <span class="price-before-discount">$ 800</span>
                                                        </div>
                                                        <!-- /.product-price -->

                                                    </div>
                                                    <!-- /.product-info -->
                                                    <div class="cart clearfix animate-effect">
                                                        <div class="action">
                                                            <ul class="list-unstyled">
                                                                <li class="add-cart-button btn-group">
                                                                    <button class="btn btn-primary icon"
                                                                        data-toggle="dropdown" type="button"> <i
                                                                            class="fa fa-shopping-cart"></i> </button>
                                                                    <button class="btn btn-primary cart-btn"
                                                                        type="button">Add to cart</button>
                                                                </li>
                                                                <li class="lnk wishlist"> <a class="add-to-cart"
                                                                        href="detail.html" title="Wishlist"> <i
                                                                            class="icon fa fa-heart"></i> </a> </li>
                                                                <li class="lnk"> <a class="add-to-cart"
                                                                        href="detail.html" title="Compare"> <i
                                                                            class="fa fa-signal"></i> </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <!-- /.action -->
                                                    </div>
                                                    <!-- /.cart -->
                                                </div>
                                                <!-- /.product -->

                                            </div>
                                            <!-- /.products -->
                                        </div>
                                        <!-- /.item -->

                                        <div class="col-sm-6 col-md-4 wow fadeInUp">
                                            <div class="products">
                                                <div class="product">
                                                    <div class="product-image">
                                                        <div class="image"> <a href="detail.html"><img
                                                                    src="assets\images\products\p2.jpg" alt=""></a>
                                                        </div>
                                                        <!-- /.image -->

                                                        <div class="tag hot"><span>hot</span></div>
                                                    </div>
                                                    <!-- /.product-image -->

                                                    <div class="product-info text-left">
                                                        <h3 class="name"><a href="detail.html">Floral Print Buttoned</a>
                                                        </h3>
                                                        <div class="rating rateit-small"></div>
                                                        <div class="description"></div>
                                                        <div class="product-price"> <span class="price"> $450.99 </span>
                                                            <span class="price-before-discount">$ 800</span>
                                                        </div>
                                                        <!-- /.product-price -->

                                                    </div>
                                                    <!-- /.product-info -->
                                                    <div class="cart clearfix animate-effect">
                                                        <div class="action">
                                                            <ul class="list-unstyled">
                                                                <li class="add-cart-button btn-group">
                                                                    <button class="btn btn-primary icon"
                                                                        data-toggle="dropdown" type="button"> <i
                                                                            class="fa fa-shopping-cart"></i> </button>
                                                                    <button class="btn btn-primary cart-btn"
                                                                        type="button">Add to cart</button>
                                                                </li>
                                                                <li class="lnk wishlist"> <a class="add-to-cart"
                                                                        href="detail.html" title="Wishlist"> <i
                                                                            class="icon fa fa-heart"></i> </a> </li>
                                                                <li class="lnk"> <a class="add-to-cart"
                                                                        href="detail.html" title="Compare"> <i
                                                                            class="fa fa-signal"></i> </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <!-- /.action -->
                                                    </div>
                                                    <!-- /.cart -->
                                                </div>
                                                <!-- /.product -->

                                            </div>
                                            <!-- /.products -->
                                        </div>
                                        <!-- /.item -->

                                        <div class="col-sm-6 col-md-4 wow fadeInUp">
                                            <div class="products">
                                                <div class="product">
                                                    <div class="product-image">
                                                        <div class="image"> <a href="detail.html"><img
                                                                    src="assets\images\products\p11.jpg" alt=""></a>
                                                        </div>
                                                        <!-- /.image -->

                                                        <div class="tag new"><span>new</span></div>
                                                    </div>
                                                    <!-- /.product-image -->

                                                    <div class="product-info text-left">
                                                        <h3 class="name"><a href="detail.html">Floral Print Buttoned</a>
                                                        </h3>
                                                        <div class="rating rateit-small"></div>
                                                        <div class="description"></div>
                                                        <div class="product-price"> <span class="price"> $450.99 </span>
                                                            <span class="price-before-discount">$ 800</span>
                                                        </div>
                                                        <!-- /.product-price -->

                                                    </div>
                                                    <!-- /.product-info -->
                                                    <div class="cart clearfix animate-effect">
                                                        <div class="action">
                                                            <ul class="list-unstyled">
                                                                <li class="add-cart-button btn-group">
                                                                    <button class="btn btn-primary icon"
                                                                        data-toggle="dropdown" type="button"> <i
                                                                            class="fa fa-shopping-cart"></i> </button>
                                                                    <button class="btn btn-primary cart-btn"
                                                                        type="button">Add to cart</button>
                                                                </li>
                                                                <li class="lnk wishlist"> <a class="add-to-cart"
                                                                        href="detail.html" title="Wishlist"> <i
                                                                            class="icon fa fa-heart"></i> </a> </li>
                                                                <li class="lnk"> <a class="add-to-cart"
                                                                        href="detail.html" title="Compare"> <i
                                                                            class="fa fa-signal"></i> </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <!-- /.action -->
                                                    </div>
                                                    <!-- /.cart -->
                                                </div>
                                                <!-- /.product -->

                                            </div>
                                            <!-- /.products -->
                                        </div>
                                        <!-- /.item -->

                                        <div class="col-sm-6 col-md-4 wow fadeInUp">
                                            <div class="products">
                                                <div class="product">
                                                    <div class="product-image">
                                                        <div class="image"> <a href="detail.html"><img
                                                                    src="assets\images\products\p12.jpg" alt=""></a>
                                                        </div>
                                                        <!-- /.image -->

                                                        <div class="tag sale"><span>sale</span></div>
                                                    </div>
                                                    <!-- /.product-image -->

                                                    <div class="product-info text-left">
                                                        <h3 class="name"><a href="detail.html">Floral Print Buttoned</a>
                                                        </h3>
                                                        <div class="rating rateit-small"></div>
                                                        <div class="description"></div>
                                                        <div class="product-price"> <span class="price"> $450.99 </span>
                                                            <span class="price-before-discount">$ 800</span>
                                                        </div>
                                                        <!-- /.product-price -->

                                                    </div>
                                                    <!-- /.product-info -->
                                                    <div class="cart clearfix animate-effect">
                                                        <div class="action">
                                                            <ul class="list-unstyled">
                                                                <li class="add-cart-button btn-group">
                                                                    <button class="btn btn-primary icon"
                                                                        data-toggle="dropdown" type="button"> <i
                                                                            class="fa fa-shopping-cart"></i> </button>
                                                                    <button class="btn btn-primary cart-btn"
                                                                        type="button">Add to cart</button>
                                                                </li>
                                                                <li class="lnk wishlist"> <a class="add-to-cart"
                                                                        href="detail.html" title="Wishlist"> <i
                                                                            class="icon fa fa-heart"></i> </a> </li>
                                                                <li class="lnk"> <a class="add-to-cart"
                                                                        href="detail.html" title="Compare"> <i
                                                                            class="fa fa-signal"></i> </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <!-- /.action -->
                                                    </div>
                                                    <!-- /.cart -->
                                                </div>
                                                <!-- /.product -->

                                            </div>
                                            <!-- /.products -->
                                        </div>
                                        <!-- /.item -->

                                        <div class="col-sm-6 col-md-4 wow fadeInUp">
                                            <div class="products">
                                                <div class="product">
                                                    <div class="product-image">
                                                        <div class="image"> <a href="detail.html"><img
                                                                    src="assets\images\products\p14.jpg" alt=""></a>
                                                        </div>
                                                        <!-- /.image -->

                                                        <div class="tag hot"><span>hot</span></div>
                                                    </div>
                                                    <!-- /.product-image -->

                                                    <div class="product-info text-left">
                                                        <h3 class="name"><a href="detail.html">Floral Print Buttoned</a>
                                                        </h3>
                                                        <div class="rating rateit-small"></div>
                                                        <div class="description"></div>
                                                        <div class="product-price"> <span class="price"> $450.99 </span>
                                                            <span class="price-before-discount">$ 800</span>
                                                        </div>
                                                        <!-- /.product-price -->

                                                    </div>
                                                    <!-- /.product-info -->
                                                    <div class="cart clearfix animate-effect">
                                                        <div class="action">
                                                            <ul class="list-unstyled">
                                                                <li class="add-cart-button btn-group">
                                                                    <button class="btn btn-primary icon"
                                                                        data-toggle="dropdown" type="button"> <i
                                                                            class="fa fa-shopping-cart"></i> </button>
                                                                    <button class="btn btn-primary cart-btn"
                                                                        type="button">Add to cart</button>
                                                                </li>
                                                                <li class="lnk wishlist"> <a class="add-to-cart"
                                                                        href="detail.html" title="Wishlist"> <i
                                                                            class="icon fa fa-heart"></i> </a> </li>
                                                                <li class="lnk"> <a class="add-to-cart"
                                                                        href="detail.html" title="Compare"> <i
                                                                            class="fa fa-signal"></i> </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <!-- /.action -->
                                                    </div>
                                                    <!-- /.cart -->
                                                </div>
                                                <!-- /.product -->

                                            </div>
                                            <!-- /.products -->
                                        </div>
                                        <!-- /.item -->
                                    </div>
                                    <!-- /.row -->
                                </div>
                                <!-- /.category-product -->

                            </div>
                            <!-- /.tab-pane -->

                            <div class="tab-pane " id="list-container">
                                <div class="category-product">
                                    <div class="category-product-inner wow fadeInUp">
                                        <div class="products">
                                            <div class="product-list product">
                                                <div class="row product-list-row">
                                                    <div class="col col-sm-4 col-lg-4">
                                                        <div class="product-image">
                                                            <div class="image"> <img src="assets\images\products\p3.jpg"
                                                                    alt=""> </div>
                                                        </div>
                                                        <!-- /.product-image -->
                                                    </div>
                                                    <!-- /.col -->
                                                    <div class="col col-sm-8 col-lg-8">
                                                        <div class="product-info">
                                                            <h3 class="name"><a href="detail.html">Floral Print
                                                                    Buttoned</a>
                                                            </h3>
                                                            <div class="rating rateit-small"></div>
                                                            <div class="product-price"> <span class="price"> $450.99
                                                                </span>
                                                                <span class="price-before-discount">$ 800</span>
                                                            </div>
                                                            <!-- /.product-price -->
                                                            <div class="description m-t-10">Suspendisse posuere arcu
                                                                diam,
                                                                id accumsan eros pharetra ac. Nulla enim risus,
                                                                facilisis
                                                                bibendum gravida eget, lacinia id purus. Suspendisse
                                                                posuere
                                                                arcu diam, id accumsan eros pharetra ac. Nulla enim
                                                                risus,
                                                                facilisis bibendum gravida eget.</div>
                                                            <div class="cart clearfix animate-effect">
                                                                <div class="action">
                                                                    <ul class="list-unstyled">
                                                                        <li class="add-cart-button btn-group">
                                                                            <button class="btn btn-primary icon"
                                                                                data-toggle="dropdown" type="button"> <i
                                                                                    class="fa fa-shopping-cart"></i>
                                                                            </button>
                                                                            <button class="btn btn-primary cart-btn"
                                                                                type="button">Add to cart</button>
                                                                        </li>
                                                                        <li class="lnk wishlist"> <a class="add-to-cart"
                                                                                href="detail.html" title="Wishlist"> <i
                                                                                    class="icon fa fa-heart"></i> </a>
                                                                        </li>
                                                                        <li class="lnk"> <a class="add-to-cart"
                                                                                href="detail.html" title="Compare"> <i
                                                                                    class="fa fa-signal"></i> </a> </li>
                                                                    </ul>
                                                                </div>
                                                                <!-- /.action -->
                                                            </div>
                                                            <!-- /.cart -->

                                                        </div>
                                                        <!-- /.product-info -->
                                                    </div>
                                                    <!-- /.col -->
                                                </div>
                                                <!-- /.product-list-row -->
                                                <div class="tag new"><span>new</span></div>
                                            </div>
                                            <!-- /.product-list -->
                                        </div>
                                        <!-- /.products -->
                                    </div>
                                    <!-- /.category-product-inner -->

                                    <div class="category-product-inner wow fadeInUp">
                                        <div class="products">
                                            <div class="product-list product">
                                                <div class="row product-list-row">
                                                    <div class="col col-sm-4 col-lg-4">
                                                        <div class="product-image">
                                                            <div class="image"> <img src="assets\images\products\p4.jpg"
                                                                    alt=""> </div>
                                                        </div>
                                                        <!-- /.product-image -->
                                                    </div>
                                                    <!-- /.col -->
                                                    <div class="col col-sm-8 col-lg-8">
                                                        <div class="product-info">
                                                            <h3 class="name"><a href="detail.html">Floral Print
                                                                    Buttoned</a>
                                                            </h3>
                                                            <div class="rating rateit-small"></div>
                                                            <div class="product-price"> <span class="price"> $450.99
                                                                </span>
                                                                <span class="price-before-discount">$ 800</span>
                                                            </div>
                                                            <!-- /.product-price -->
                                                            <div class="description m-t-10">Suspendisse posuere arcu
                                                                diam,
                                                                id accumsan eros pharetra ac. Nulla enim risus,
                                                                facilisis
                                                                bibendum gravida eget, lacinia id purus. Suspendisse
                                                                posuere
                                                                arcu diam, id accumsan eros pharetra ac. Nulla enim
                                                                risus,
                                                                facilisis bibendum gravida eget.</div>
                                                            <div class="cart clearfix animate-effect">
                                                                <div class="action">
                                                                    <ul class="list-unstyled">
                                                                        <li class="add-cart-button btn-group">
                                                                            <button class="btn btn-primary icon"
                                                                                data-toggle="dropdown" type="button"> <i
                                                                                    class="fa fa-shopping-cart"></i>
                                                                            </button>
                                                                            <button class="btn btn-primary cart-btn"
                                                                                type="button">Add to cart</button>
                                                                        </li>
                                                                        <li class="lnk wishlist"> <a class="add-to-cart"
                                                                                href="detail.html" title="Wishlist"> <i
                                                                                    class="icon fa fa-heart"></i> </a>
                                                                        </li>
                                                                        <li class="lnk"> <a class="add-to-cart"
                                                                                href="detail.html" title="Compare"> <i
                                                                                    class="fa fa-signal"></i> </a> </li>
                                                                    </ul>
                                                                </div>
                                                                <!-- /.action -->
                                                            </div>
                                                            <!-- /.cart -->

                                                        </div>
                                                        <!-- /.product-info -->
                                                    </div>
                                                    <!-- /.col -->
                                                </div>
                                                <!-- /.product-list-row -->
                                                <div class="tag sale"><span>sale</span></div>
                                            </div>
                                            <!-- /.product-list -->
                                        </div>
                                        <!-- /.products -->
                                    </div>
                                    <!-- /.category-product-inner -->

                                    <div class="category-product-inner wow fadeInUp">
                                        <div class="products">
                                            <div class="product-list product">
                                                <div class="row product-list-row">
                                                    <div class="col col-sm-4 col-lg-4">
                                                        <div class="product-image">
                                                            <div class="image"> <img src="assets\images\products\p5.jpg"
                                                                    alt=""> </div>
                                                        </div>
                                                        <!-- /.product-image -->
                                                    </div>
                                                    <!-- /.col -->
                                                    <div class="col col-sm-8 col-lg-8">
                                                        <div class="product-info">
                                                            <h3 class="name"><a href="detail.html">Floral Print
                                                                    Buttoned</a>
                                                            </h3>
                                                            <div class="rating rateit-small"></div>
                                                            <div class="product-price"> <span class="price"> $450.99
                                                                </span>
                                                                <span class="price-before-discount">$ 800</span>
                                                            </div>
                                                            <!-- /.product-price -->
                                                            <div class="description m-t-10">Suspendisse posuere arcu
                                                                diam,
                                                                id accumsan eros pharetra ac. Nulla enim risus,
                                                                facilisis
                                                                bibendum gravida eget, lacinia id purus. Suspendisse
                                                                posuere
                                                                arcu diam, id accumsan eros pharetra ac. Nulla enim
                                                                risus,
                                                                facilisis bibendum gravida eget.</div>
                                                            <div class="cart clearfix animate-effect">
                                                                <div class="action">
                                                                    <ul class="list-unstyled">
                                                                        <li class="add-cart-button btn-group">
                                                                            <button class="btn btn-primary icon"
                                                                                data-toggle="dropdown" type="button"> <i
                                                                                    class="fa fa-shopping-cart"></i>
                                                                            </button>
                                                                            <button class="btn btn-primary cart-btn"
                                                                                type="button">Add to cart</button>
                                                                        </li>
                                                                        <li class="lnk wishlist"> <a class="add-to-cart"
                                                                                href="detail.html" title="Wishlist"> <i
                                                                                    class="icon fa fa-heart"></i> </a>
                                                                        </li>
                                                                        <li class="lnk"> <a class="add-to-cart"
                                                                                href="detail.html" title="Compare"> <i
                                                                                    class="fa fa-signal"></i> </a> </li>
                                                                    </ul>
                                                                </div>
                                                                <!-- /.action -->
                                                            </div>
                                                            <!-- /.cart -->

                                                        </div>
                                                        <!-- /.product-info -->
                                                    </div>
                                                    <!-- /.col -->
                                                </div>
                                                <!-- /.product-list-row -->
                                                <div class="tag hot"><span>hot</span></div>
                                            </div>
                                            <!-- /.product-list -->
                                        </div>
                                        <!-- /.products -->
                                    </div>
                                    <!-- /.category-product-inner -->

                                    <div class="category-product-inner wow fadeInUp">
                                        <div class="products">
                                            <div class="product-list product">
                                                <div class="row product-list-row">
                                                    <div class="col col-sm-4 col-lg-4">
                                                        <div class="product-image">
                                                            <div class="image"> <img src="assets\images\products\p6.jpg"
                                                                    alt=""> </div>
                                                        </div>
                                                        <!-- /.product-image -->
                                                    </div>
                                                    <!-- /.col -->
                                                    <div class="col col-sm-8 col-lg-8">
                                                        <div class="product-info">
                                                            <h3 class="name"><a href="detail.html">Floral Print
                                                                    Buttoned</a>
                                                            </h3>
                                                            <div class="rating rateit-small"></div>
                                                            <div class="product-price"> <span class="price"> $450.99
                                                                </span>
                                                                <span class="price-before-discount">$ 800</span>
                                                            </div>
                                                            <!-- /.product-price -->
                                                            <div class="description m-t-10">Suspendisse posuere arcu
                                                                diam,
                                                                id accumsan eros pharetra ac. Nulla enim risus,
                                                                facilisis
                                                                bibendum gravida eget, lacinia id purus. Suspendisse
                                                                posuere
                                                                arcu diam, id accumsan eros pharetra ac. Nulla enim
                                                                risus,
                                                                facilisis bibendum gravida eget.</div>
                                                            <div class="cart clearfix animate-effect">
                                                                <div class="action">
                                                                    <ul class="list-unstyled">
                                                                        <li class="add-cart-button btn-group">
                                                                            <button class="btn btn-primary icon"
                                                                                data-toggle="dropdown" type="button"> <i
                                                                                    class="fa fa-shopping-cart"></i>
                                                                            </button>
                                                                            <button class="btn btn-primary cart-btn"
                                                                                type="button">Add to cart</button>
                                                                        </li>
                                                                        <li class="lnk wishlist"> <a class="add-to-cart"
                                                                                href="detail.html" title="Wishlist"> <i
                                                                                    class="icon fa fa-heart"></i> </a>
                                                                        </li>
                                                                        <li class="lnk"> <a class="add-to-cart"
                                                                                href="detail.html" title="Compare"> <i
                                                                                    class="fa fa-signal"></i> </a> </li>
                                                                    </ul>
                                                                </div>
                                                                <!-- /.action -->
                                                            </div>
                                                            <!-- /.cart -->

                                                        </div>
                                                        <!-- /.product-info -->
                                                    </div>
                                                    <!-- /.col -->
                                                </div>
                                                <!-- /.product-list-row -->
                                                <div class="tag hot"><span>hot</span></div>
                                            </div>
                                            <!-- /.product-list -->
                                        </div>
                                        <!-- /.products -->
                                    </div>
                                    <!-- /.category-product-inner -->

                                    <div class="category-product-inner wow fadeInUp">
                                        <div class="products">
                                            <div class="product-list product">
                                                <div class="row product-list-row">
                                                    <div class="col col-sm-4 col-lg-4">
                                                        <div class="product-image">
                                                            <div class="image"> <img src="assets\images\products\p7.jpg"
                                                                    alt=""> </div>
                                                        </div>
                                                        <!-- /.product-image -->
                                                    </div>
                                                    <!-- /.col -->
                                                    <div class="col col-sm-8 col-lg-8">
                                                        <div class="product-info">
                                                            <h3 class="name"><a href="detail.html">Floral Print
                                                                    Buttoned</a>
                                                            </h3>
                                                            <div class="rating rateit-small"></div>
                                                            <div class="product-price"> <span class="price"> $450.99
                                                                </span>
                                                                <span class="price-before-discount">$ 800</span>
                                                            </div>
                                                            <!-- /.product-price -->
                                                            <div class="description m-t-10">Suspendisse posuere arcu
                                                                diam,
                                                                id accumsan eros pharetra ac. Nulla enim risus,
                                                                facilisis
                                                                bibendum gravida eget, lacinia id purus. Suspendisse
                                                                posuere
                                                                arcu diam, id accumsan eros pharetra ac. Nulla enim
                                                                risus,
                                                                facilisis bibendum gravida eget.</div>
                                                            <div class="cart clearfix animate-effect">
                                                                <div class="action">
                                                                    <ul class="list-unstyled">
                                                                        <li class="add-cart-button btn-group">
                                                                            <button class="btn btn-primary icon"
                                                                                data-toggle="dropdown" type="button"> <i
                                                                                    class="fa fa-shopping-cart"></i>
                                                                            </button>
                                                                            <button class="btn btn-primary cart-btn"
                                                                                type="button">Add to cart</button>
                                                                        </li>
                                                                        <li class="lnk wishlist"> <a class="add-to-cart"
                                                                                href="detail.html" title="Wishlist"> <i
                                                                                    class="icon fa fa-heart"></i> </a>
                                                                        </li>
                                                                        <li class="lnk"> <a class="add-to-cart"
                                                                                href="detail.html" title="Compare"> <i
                                                                                    class="fa fa-signal"></i> </a> </li>
                                                                    </ul>
                                                                </div>
                                                                <!-- /.action -->
                                                            </div>
                                                            <!-- /.cart -->

                                                        </div>
                                                        <!-- /.product-info -->
                                                    </div>
                                                    <!-- /.col -->
                                                </div>
                                                <!-- /.product-list-row -->
                                                <div class="tag sale"><span>sale</span></div>
                                            </div>
                                            <!-- /.product-list -->
                                        </div>
                                        <!-- /.products -->
                                    </div>
                                    <!-- /.category-product-inner -->

                                    <div class="category-product-inner wow fadeInUp">
                                        <div class="products">
                                            <div class="product-list product">
                                                <div class="row product-list-row">
                                                    <div class="col col-sm-4 col-lg-4">
                                                        <div class="product-image">
                                                            <div class="image"> <img src="assets\images\products\p8.jpg"
                                                                    alt=""> </div>
                                                        </div>
                                                        <!-- /.product-image -->
                                                    </div>
                                                    <!-- /.col -->
                                                    <div class="col col-sm-8 col-lg-8">
                                                        <div class="product-info">
                                                            <h3 class="name"><a href="detail.html">Floral Print
                                                                    Buttoned</a>
                                                            </h3>
                                                            <div class="rating rateit-small"></div>
                                                            <div class="product-price"> <span class="price"> $450.99
                                                                </span>
                                                                <span class="price-before-discount">$ 800</span>
                                                            </div>
                                                            <!-- /.product-price -->
                                                            <div class="description m-t-10">Suspendisse posuere arcu
                                                                diam,
                                                                id accumsan eros pharetra ac. Nulla enim risus,
                                                                facilisis
                                                                bibendum gravida eget, lacinia id purus. Suspendisse
                                                                posuere
                                                                arcu diam, id accumsan eros pharetra ac. Nulla enim
                                                                risus,
                                                                facilisis bibendum gravida eget.</div>
                                                            <div class="cart clearfix animate-effect">
                                                                <div class="action">
                                                                    <ul class="list-unstyled">
                                                                        <li class="add-cart-button btn-group">
                                                                            <button class="btn btn-primary icon"
                                                                                data-toggle="dropdown" type="button"> <i
                                                                                    class="fa fa-shopping-cart"></i>
                                                                            </button>
                                                                            <button class="btn btn-primary cart-btn"
                                                                                type="button">Add to cart</button>
                                                                        </li>
                                                                        <li class="lnk wishlist"> <a class="add-to-cart"
                                                                                href="detail.html" title="Wishlist"> <i
                                                                                    class="icon fa fa-heart"></i> </a>
                                                                        </li>
                                                                        <li class="lnk"> <a class="add-to-cart"
                                                                                href="detail.html" title="Compare"> <i
                                                                                    class="fa fa-signal"></i> </a> </li>
                                                                    </ul>
                                                                </div>
                                                                <!-- /.action -->
                                                            </div>
                                                            <!-- /.cart -->

                                                        </div>
                                                        <!-- /.product-info -->
                                                    </div>
                                                    <!-- /.col -->
                                                </div>
                                                <!-- /.product-list-row -->
                                                <div class="tag new"><span>new</span></div>
                                            </div>
                                            <!-- /.product-list -->
                                        </div>
                                        <!-- /.products -->
                                    </div>
                                    <!-- /.category-product-inner -->

                                    <div class="category-product-inner wow fadeInUp">
                                        <div class="products">
                                            <div class="product-list product">
                                                <div class="row product-list-row">
                                                    <div class="col col-sm-4 col-lg-4">
                                                        <div class="product-image">
                                                            <div class="image"> <img src="assets\images\products\p9.jpg"
                                                                    alt=""> </div>
                                                        </div>
                                                        <!-- /.product-image -->
                                                    </div>
                                                    <!-- /.col -->
                                                    <div class="col col-sm-8 col-lg-8">
                                                        <div class="product-info">
                                                            <h3 class="name"><a href="detail.html">Floral Print
                                                                    Buttoned</a>
                                                            </h3>
                                                            <div class="rating rateit-small"></div>
                                                            <div class="product-price"> <span class="price"> $450.99
                                                                </span>
                                                                <span class="price-before-discount">$ 800</span>
                                                            </div>
                                                            <!-- /.product-price -->
                                                            <div class="description m-t-10">Suspendisse posuere arcu
                                                                diam,
                                                                id accumsan eros pharetra ac. Nulla enim risus,
                                                                facilisis
                                                                bibendum gravida eget, lacinia id purus. Suspendisse
                                                                posuere
                                                                arcu diam, id accumsan eros pharetra ac. Nulla enim
                                                                risus,
                                                                facilisis bibendum gravida eget.</div>
                                                            <div class="cart clearfix animate-effect">
                                                                <div class="action">
                                                                    <ul class="list-unstyled">
                                                                        <li class="add-cart-button btn-group">
                                                                            <button class="btn btn-primary icon"
                                                                                data-toggle="dropdown" type="button"> <i
                                                                                    class="fa fa-shopping-cart"></i>
                                                                            </button>
                                                                            <button class="btn btn-primary cart-btn"
                                                                                type="button">Add to cart</button>
                                                                        </li>
                                                                        <li class="lnk wishlist"> <a class="add-to-cart"
                                                                                href="detail.html" title="Wishlist"> <i
                                                                                    class="icon fa fa-heart"></i> </a>
                                                                        </li>
                                                                        <li class="lnk"> <a class="add-to-cart"
                                                                                href="detail.html" title="Compare"> <i
                                                                                    class="fa fa-signal"></i> </a> </li>
                                                                    </ul>
                                                                </div>
                                                                <!-- /.action -->
                                                            </div>
                                                            <!-- /.cart -->

                                                        </div>
                                                        <!-- /.product-info -->
                                                    </div>
                                                    <!-- /.col -->
                                                </div>
                                                <!-- /.product-list-row -->
                                                <div class="tag new"><span>new</span></div>
                                            </div>
                                            <!-- /.product-list -->
                                        </div>
                                        <!-- /.products -->
                                    </div>
                                    <!-- /.category-product-inner -->

                                    <div class="category-product-inner wow fadeInUp">
                                        <div class="products">
                                            <div class="product-list product">
                                                <div class="row product-list-row">
                                                    <div class="col col-sm-4 col-lg-4">
                                                        <div class="product-image">
                                                            <div class="image"> <img
                                                                    src="assets\images\products\p10.jpg" alt=""> </div>
                                                        </div>
                                                        <!-- /.product-image -->
                                                    </div>
                                                    <!-- /.col -->
                                                    <div class="col col-sm-8 col-lg-8">
                                                        <div class="product-info">
                                                            <h3 class="name"><a href="detail.html">Floral Print
                                                                    Buttoned</a>
                                                            </h3>
                                                            <div class="rating rateit-small"></div>
                                                            <div class="product-price"> <span class="price"> $450.99
                                                                </span>
                                                                <span class="price-before-discount">$ 800</span>
                                                            </div>
                                                            <!-- /.product-price -->
                                                            <div class="description m-t-10">Suspendisse posuere arcu
                                                                diam,
                                                                id accumsan eros pharetra ac. Nulla enim risus,
                                                                facilisis
                                                                bibendum gravida eget, lacinia id purus. Suspendisse
                                                                posuere
                                                                arcu diam, id accumsan eros pharetra ac. Nulla enim
                                                                risus,
                                                                facilisis bibendum gravida eget.</div>
                                                            <div class="cart clearfix animate-effect">
                                                                <div class="action">
                                                                    <ul class="list-unstyled">
                                                                        <li class="add-cart-button btn-group">
                                                                            <button class="btn btn-primary icon"
                                                                                data-toggle="dropdown" type="button"> <i
                                                                                    class="fa fa-shopping-cart"></i>
                                                                            </button>
                                                                            <button class="btn btn-primary cart-btn"
                                                                                type="button">Add to cart</button>
                                                                        </li>
                                                                        <li class="lnk wishlist"> <a class="add-to-cart"
                                                                                href="detail.html" title="Wishlist"> <i
                                                                                    class="icon fa fa-heart"></i> </a>
                                                                        </li>
                                                                        <li class="lnk"> <a class="add-to-cart"
                                                                                href="detail.html" title="Compare"> <i
                                                                                    class="fa fa-signal"></i> </a> </li>
                                                                    </ul>
                                                                </div>
                                                                <!-- /.action -->
                                                            </div>
                                                            <!-- /.cart -->

                                                        </div>
                                                        <!-- /.product-info -->
                                                    </div>
                                                    <!-- /.col -->
                                                </div>
                                                <!-- /.product-list-row -->
                                                <div class="tag sale"><span>sale</span></div>
                                            </div>
                                            <!-- /.product-list -->
                                        </div>
                                        <!-- /.products -->
                                    </div>
                                    <!-- /.category-product-inner -->

                                    <div class="category-product-inner wow fadeInUp">
                                        <div class="products">
                                            <div class="product-list product">
                                                <div class="row product-list-row">
                                                    <div class="col col-sm-4 col-lg-4">
                                                        <div class="product-image">
                                                            <div class="image"> <img
                                                                    src="assets\images\products\p11.jpg" alt=""> </div>
                                                        </div>
                                                        <!-- /.product-image -->
                                                    </div>
                                                    <!-- /.col -->
                                                    <div class="col col-sm-8 col-lg-8">
                                                        <div class="product-info">
                                                            <h3 class="name"><a href="detail.html">Floral Print
                                                                    Buttoned</a>
                                                            </h3>
                                                            <div class="rating rateit-small"></div>
                                                            <div class="product-price"> <span class="price"> $450.99
                                                                </span>
                                                                <span class="price-before-discount">$ 800</span>
                                                            </div>
                                                            <!-- /.product-price -->
                                                            <div class="description m-t-10">Suspendisse posuere arcu
                                                                diam,
                                                                id accumsan eros pharetra ac. Nulla enim risus,
                                                                facilisis
                                                                bibendum gravida eget, lacinia id purus. Suspendisse
                                                                posuere
                                                                arcu diam, id accumsan eros pharetra ac. Nulla enim
                                                                risus,
                                                                facilisis bibendum gravida eget.</div>
                                                            <div class="cart clearfix animate-effect">
                                                                <div class="action">
                                                                    <ul class="list-unstyled">
                                                                        <li class="add-cart-button btn-group">
                                                                            <button class="btn btn-primary icon"
                                                                                data-toggle="dropdown" type="button"> <i
                                                                                    class="fa fa-shopping-cart"></i>
                                                                            </button>
                                                                            <button class="btn btn-primary cart-btn"
                                                                                type="button">Add to cart</button>
                                                                        </li>
                                                                        <li class="lnk wishlist"> <a class="add-to-cart"
                                                                                href="detail.html" title="Wishlist"> <i
                                                                                    class="icon fa fa-heart"></i> </a>
                                                                        </li>
                                                                        <li class="lnk"> <a class="add-to-cart"
                                                                                href="detail.html" title="Compare"> <i
                                                                                    class="fa fa-signal"></i> </a> </li>
                                                                    </ul>
                                                                </div>
                                                                <!-- /.action -->
                                                            </div>
                                                            <!-- /.cart -->

                                                        </div>
                                                        <!-- /.product-info -->
                                                    </div>
                                                    <!-- /.col -->
                                                </div>
                                                <!-- /.product-list-row -->
                                                <div class="tag hot"><span>hot</span></div>
                                            </div>
                                            <!-- /.product-list -->
                                        </div>
                                        <!-- /.products -->
                                    </div>
                                    <!-- /.category-product-inner -->

                                    <div class="category-product-inner wow fadeInUp">
                                        <div class="products">
                                            <div class="product-list product">
                                                <div class="row product-list-row">
                                                    <div class="col col-sm-4 col-lg-4">
                                                        <div class="product-image">
                                                            <div class="image"> <img
                                                                    src="assets\images\products\p12.jpg" alt=""> </div>
                                                        </div>
                                                        <!-- /.product-image -->
                                                    </div>
                                                    <!-- /.col -->
                                                    <div class="col col-sm-8 col-lg-8">
                                                        <div class="product-info">
                                                            <h3 class="name"><a href="detail.html">Floral Print
                                                                    Buttoned</a>
                                                            </h3>
                                                            <div class="rating rateit-small"></div>
                                                            <div class="product-price"> <span class="price"> $450.99
                                                                </span>
                                                                <span class="price-before-discount">$ 800</span>
                                                            </div>
                                                            <!-- /.product-price -->
                                                            <div class="description m-t-10">Suspendisse posuere arcu
                                                                diam,
                                                                id accumsan eros pharetra ac. Nulla enim risus,
                                                                facilisis
                                                                bibendum gravida eget, lacinia id purus. Suspendisse
                                                                posuere
                                                                arcu diam, id accumsan eros pharetra ac. Nulla enim
                                                                risus,
                                                                facilisis bibendum gravida eget.</div>
                                                            <div class="cart clearfix animate-effect">
                                                                <div class="action">
                                                                    <ul class="list-unstyled">
                                                                        <li class="add-cart-button btn-group">
                                                                            <button class="btn btn-primary icon"
                                                                                data-toggle="dropdown" type="button"> <i
                                                                                    class="fa fa-shopping-cart"></i>
                                                                            </button>
                                                                            <button class="btn btn-primary cart-btn"
                                                                                type="button">Add to cart</button>
                                                                        </li>
                                                                        <li class="lnk wishlist"> <a class="add-to-cart"
                                                                                href="detail.html" title="Wishlist"> <i
                                                                                    class="icon fa fa-heart"></i> </a>
                                                                        </li>
                                                                        <li class="lnk"> <a class="add-to-cart"
                                                                                href="detail.html" title="Compare"> <i
                                                                                    class="fa fa-signal"></i> </a> </li>
                                                                    </ul>
                                                                </div>
                                                                <!-- /.action -->
                                                            </div>
                                                            <!-- /.cart -->

                                                        </div>
                                                        <!-- /.product-info -->
                                                    </div>
                                                    <!-- /.col -->
                                                </div>
                                                <!-- /.product-list-row -->
                                                <div class="tag new"><span>new</span></div>
                                            </div>
                                            <!-- /.product-list -->
                                        </div>
                                        <!-- /.products -->
                                    </div>
                                    <!-- /.category-product-inner -->

                                    <div class="category-product-inner wow fadeInUp">
                                        <div class="products">
                                            <div class="product-list product">
                                                <div class="row product-list-row">
                                                    <div class="col col-sm-4 col-lg-4">
                                                        <div class="product-image">
                                                            <div class="image"> <img
                                                                    src="assets\images\products\p13.jpg" alt=""> </div>
                                                        </div>
                                                        <!-- /.product-image -->
                                                    </div>
                                                    <!-- /.col -->
                                                    <div class="col col-sm-8 col-lg-8">
                                                        <div class="product-info">
                                                            <h3 class="name"><a href="detail.html">Floral Print
                                                                    Buttoned</a>
                                                            </h3>
                                                            <div class="rating rateit-small"></div>
                                                            <div class="product-price"> <span class="price"> $450.99
                                                                </span>
                                                                <span class="price-before-discount">$ 800</span>
                                                            </div>
                                                            <!-- /.product-price -->
                                                            <div class="description m-t-10">Suspendisse posuere arcu
                                                                diam,
                                                                id accumsan eros pharetra ac. Nulla enim risus,
                                                                facilisis
                                                                bibendum gravida eget, lacinia id purus. Suspendisse
                                                                posuere
                                                                arcu diam, id accumsan eros pharetra ac. Nulla enim
                                                                risus,
                                                                facilisis bibendum gravida eget.</div>
                                                            <div class="cart clearfix animate-effect">
                                                                <div class="action">
                                                                    <ul class="list-unstyled">
                                                                        <li class="add-cart-button btn-group">
                                                                            <button class="btn btn-primary icon"
                                                                                data-toggle="dropdown" type="button"> <i
                                                                                    class="fa fa-shopping-cart"></i>
                                                                            </button>
                                                                            <button class="btn btn-primary cart-btn"
                                                                                type="button">Add to cart</button>
                                                                        </li>
                                                                        <li class="lnk wishlist"> <a class="add-to-cart"
                                                                                href="detail.html" title="Wishlist"> <i
                                                                                    class="icon fa fa-heart"></i> </a>
                                                                        </li>
                                                                        <li class="lnk"> <a class="add-to-cart"
                                                                                href="detail.html" title="Compare"> <i
                                                                                    class="fa fa-signal"></i> </a> </li>
                                                                    </ul>
                                                                </div>
                                                                <!-- /.action -->
                                                            </div>
                                                            <!-- /.cart -->

                                                        </div>
                                                        <!-- /.product-info -->
                                                    </div>
                                                    <!-- /.col -->
                                                </div>
                                                <!-- /.product-list-row -->
                                                <div class="tag sale"><span>sale</span></div>
                                            </div>
                                            <!-- /.product-list -->
                                        </div>
                                        <!-- /.products -->
                                    </div>
                                    <!-- /.category-product-inner -->

                                    <div class="category-product-inner wow fadeInUp">
                                        <div class="products">
                                            <div class="product-list product">
                                                <div class="row product-list-row">
                                                    <div class="col col-sm-4 col-lg-4">
                                                        <div class="product-image">
                                                            <div class="image"> <img
                                                                    src="assets\images\products\p14.jpg" alt=""> </div>
                                                        </div>
                                                        <!-- /.product-image -->
                                                    </div>
                                                    <!-- /.col -->
                                                    <div class="col col-sm-8 col-lg-8">
                                                        <div class="product-info">
                                                            <h3 class="name"><a href="detail.html">Floral Print
                                                                    Buttoned</a>
                                                            </h3>
                                                            <div class="rating rateit-small"></div>
                                                            <div class="product-price"> <span class="price"> $450.99
                                                                </span>
                                                                <span class="price-before-discount">$ 800</span>
                                                            </div>
                                                            <!-- /.product-price -->
                                                            <div class="description m-t-10">Suspendisse posuere arcu
                                                                diam,
                                                                id accumsan eros pharetra ac. Nulla enim risus,
                                                                facilisis
                                                                bibendum gravida eget, lacinia id purus. Suspendisse
                                                                posuere
                                                                arcu diam, id accumsan eros pharetra ac. Nulla enim
                                                                risus,
                                                                facilisis bibendum gravida eget.</div>
                                                            <div class="cart clearfix animate-effect">
                                                                <div class="action">
                                                                    <ul class="list-unstyled">
                                                                        <li class="add-cart-button btn-group">
                                                                            <button class="btn btn-primary icon"
                                                                                data-toggle="dropdown" type="button"> <i
                                                                                    class="fa fa-shopping-cart"></i>
                                                                            </button>
                                                                            <button class="btn btn-primary cart-btn"
                                                                                type="button">Add to cart</button>
                                                                        </li>
                                                                        <li class="lnk wishlist"> <a class="add-to-cart"
                                                                                href="detail.html" title="Wishlist"> <i
                                                                                    class="icon fa fa-heart"></i> </a>
                                                                        </li>
                                                                        <li class="lnk"> <a class="add-to-cart"
                                                                                href="detail.html" title="Compare"> <i
                                                                                    class="fa fa-signal"></i> </a> </li>
                                                                    </ul>
                                                                </div>
                                                                <!-- /.action -->
                                                            </div>
                                                            <!-- /.cart -->

                                                        </div>
                                                        <!-- /.product-info -->
                                                    </div>
                                                    <!-- /.col -->
                                                </div>
                                                <!-- /.product-list-row -->
                                                <div class="tag hot"><span>hot</span></div>
                                            </div>
                                            <!-- /.product-list -->
                                        </div>
                                        <!-- /.products -->
                                    </div>
                                    <!-- /.category-product-inner -->

                                </div>
                                <!-- /.category-product -->
                            </div>
                            <!-- /.tab-pane #list-container -->
                        </div>
                        <!-- /.tab-content -->
                        <div class="clearfix filters-container">
                            <div class="text-right">
                                <div class="pagination-container">
                                    <ul class="list-inline list-unstyled">
                                        <li class="prev"><a href="#"><i class="fa fa-angle-left"></i></a></li>
                                        <li><a href="#">1</a></li>
                                        <li class="active"><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li><a href="#">4</a></li>
                                        <li class="next"><a href="#"><i class="fa fa-angle-right"></i></a></li>
                                    </ul>
                                    <!-- /.list-inline -->
                                </div>
                                <!-- /.pagination-container -->
                            </div>
                            <!-- /.text-right -->

                        </div>
                        <!-- /.filters-container -->

                    </div>
                    <!-- /.search-result-container -->

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
            <!-- ============================================== BRANDS CAROUSEL ============================================== -->
            <div id="brands-carousel" class="logo-slider wow fadeInUp">
                <div class="logo-slider-inner">
                    <div id="brand-slider" class="owl-carousel brand-slider custom-carousel owl-theme">
                        <div class="item m-t-15"> <a href="#" class="image"> <img
                                    data-echo="assets/images/brands/brand1.png" src="assets\images\blank.gif" alt="">
                            </a>
                        </div>
                        <!--/.item-->

                        <div class="item m-t-10"> <a href="#" class="image"> <img
                                    data-echo="assets/images/brands/brand2.png" src="assets\images\blank.gif" alt="">
                            </a>
                        </div>
                        <!--/.item-->

                        <div class="item"> <a href="#" class="image"> <img data-echo="assets/images/brands/brand3.png"
                                    src="assets\images\blank.gif" alt=""> </a> </div>
                        <!--/.item-->

                        <div class="item"> <a href="#" class="image"> <img data-echo="assets/images/brands/brand4.png"
                                    src="assets\images\blank.gif" alt=""> </a> </div>
                        <!--/.item-->

                        <div class="item"> <a href="#" class="image"> <img data-echo="assets/images/brands/brand5.png"
                                    src="assets\images\blank.gif" alt=""> </a> </div>
                        <!--/.item-->

                        <div class="item"> <a href="#" class="image"> <img data-echo="assets/images/brands/brand6.png"
                                    src="assets\images\blank.gif" alt=""> </a> </div>
                        <!--/.item-->

                        <div class="item"> <a href="#" class="image"> <img data-echo="assets/images/brands/brand2.png"
                                    src="assets\images\blank.gif" alt=""> </a> </div>
                        <!--/.item-->

                        <div class="item"> <a href="#" class="image"> <img data-echo="assets/images/brands/brand4.png"
                                    src="assets\images\blank.gif" alt=""> </a> </div>
                        <!--/.item-->

                        <div class="item"> <a href="#" class="image"> <img data-echo="assets/images/brands/brand1.png"
                                    src="assets\images\blank.gif" alt=""> </a> </div>
                        <!--/.item-->

                        <div class="item"> <a href="#" class="image"> <img data-echo="assets/images/brands/brand5.png"
                                    src="assets\images\blank.gif" alt=""> </a> </div>
                        <!--/.item-->
                    </div>
                    <!-- /.owl-carousel #logo-slider -->
                </div>
                <!-- /.logo-slider-inner -->

            </div>
            <!-- /.logo-slider -->
            <!-- ============================================== BRANDS CAROUSEL : END ============================================== -->
        </div>
        <!-- /.container -->

    </div>
    <!-- /.body-content -->
    <!-- ============================================================= FOOTER ============================================================= -->
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
                        <li class="fb pull-left"><a target="_blank" rel="nofollow" href="#" title="Facebook"></a></li>
                        <li class="tw pull-left"><a target="_blank" rel="nofollow" href="#" title="Twitter"></a></li>
                        <li class="googleplus pull-left"><a target="_blank" rel="nofollow" href="#"
                                title="GooglePlus"></a>
                        </li>
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
    <!-- ============================================================= FOOTER : END============================================================= -->

    <!-- For demo purposes – can be removed on production -->

    <!-- For demo purposes – can be removed on production : End -->

    <!-- JavaScripts placed at the end of the document so the pages load faster -->
    <script src="assets\js\jquery-1.11.1.min.js"></script>
    <script src="assets\js\bootstrap.min.js"></script>
    <script src="assets\js\bootstrap-hover-dropdown.min.js"></script>
    <script src="assets\js\owl.carousel.min.js"></script>
    <script src="assets\js\echo.min.js"></script>
    <script src="assets\js\jquery.easing-1.3.min.js"></script>
    <script src="assets\js\bootstrap-slider.min.js"></script>
    <script src="assets\js\jquery.rateit.min.js"></script>
    <script src="assets\js\bootstrap-select.min.js"></script>
    <script src="assets\js\wow.min.js"></script>
    <script src="assets\js\scripts.js"></script>
</body>

</html>
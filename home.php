<?php
session_start(); // Bắt đầu session

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Nếu chưa đăng nhập, chuyển hướng về trang đăng nhập
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="./css/styles.css">
    <script src="js.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="shortcut icon" href="image/vietnam.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
            <a href="contact.php" class="nav-link text-decoration-none">Liên Hệ</a>
            <a href="blogs.php" class="nav-link text-decoration-none">Blogs</a>
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
    <div id="home" class="  text-white">
        <div class="video-background">
            <video autoplay muted loop id="background-video">
                <source src="audio/Untitled video - Made with Clipchamp (1).mp4" type="video/mp4">
            </video>
        </div>
        <br><br>
        <section class="home" id="home">
            <div class="content">
                <h3>Number1</h3>
                <p>Description</p>
                <a href="#" class="btn1">Get Your Now</a>
            </div>
        </section>

        <div class="typewriter text-center block ">
            <h1>Bảng Thống Kê Về Tổng số liệt sĩ và bệnh nhân chất độc màu da cam</h1>
        </div>
        <div class="container fade-in block">
            <div class="image-scroll">
                <button class="scroll-btn left" onclick="scrollLeft()">❮</button>
                <div class="row" id="imageRow">
                    <div class="col-3">
                        <div class="fade-in-image">
                            <img src="image/info 13 can bo.jpg" height="320px" alt="Image Description">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="fade-in-image">
                            <img src="image/t76771.jpg" height="320px" alt="Image Description">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="fade-in-image">
                            <img src="image/XoaDiuNoiDauDaCam.jpg" height="320px" alt="Image Description">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="fade-in-image">
                            <img src="image/NGOC- HAU QUA LAU DAI TU CHAT DOC DA CAM_NGOC.jpg" height="320px"
                                alt="Image Description">
                        </div>
                    </div>

                </div>
                <button class="scroll-btn right" onclick="scrollRight()">❯</button>
            </div>
        </div>


        <div class="canvas fade-in">
            <div class="row">
                <div class="col-4">
                    <canvas id="canvas1"></canvas>
                    <script>
                        var DoughnutChart1 = [{
                            value: 40,
                            color: "#fcc79e"
                        }, {
                            value: 20,
                            color: "#beefd2"
                        }, {
                            value: 50,
                            color: "#ffddfb"
                        }];

                        var ctx1 = document.getElementById("canvas1").getContext("2d");
                        var myDoughnutChart1 = new Chart(ctx1, {
                            type: 'doughnut',
                            data: {
                                datasets: [{
                                    data: DoughnutChart1.map(item => item.value),
                                    backgroundColor: DoughnutChart1.map(item => item.color)
                                }],
                                labels: ['Segment 1', 'Segment 2', 'Segment 3']
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'top',
                                    },
                                    title: {
                                        display: true,
                                        text: 'Updated Doughnut Chart 1'
                                    }
                                }
                            }
                        });
                    </script>
                </div>
                <div class="col-4">
                    <canvas id="canvas2"></canvas>
                    <script>
                        var DoughnutChart2 = [{
                            value: 60,
                            color: "#fcc79e"
                        }, {
                            value: 30,
                            color: "#beefd2"
                        }, {
                            value: 50,
                            color: "#ffddfb"
                        }];

                        var ctx2 = document.getElementById("canvas2").getContext("2d");
                        var myDoughnutChart2 = new Chart(ctx2, {
                            type: 'doughnut',
                            data: {
                                datasets: [{
                                    data: DoughnutChart2.map(item => item.value),
                                    backgroundColor: DoughnutChart2.map(item => item.color)
                                }],
                                labels: ['Segment 4', 'Segment 5', 'Segment 6']
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'top',
                                    },
                                    title: {
                                        display: true,
                                        text: 'Updated Doughnut Chart 2'
                                    }
                                }
                            }
                        });
                    </script>
                </div>

                <div class="col-4">
                    <canvas id="canvas3"></canvas>
                    <script>
                        var BarChart = {
                            labels: ["Ruby", "jQuery", "Java", "ASP.Net", "PHP"],
                            datasets: [{
                                backgroundColor: "rgba(255, 0, 0, 0.5)", // Màu nền nhạt (đỏ)
                                borderColor: "rgba(255, 255, 255, 1)", // Màu viền trắng
                                data: [13, 20, 30, 40, 50]
                            }, {
                                backgroundColor: "rgba(0, 128, 0, 0.5)", // Màu nền nhạt (xanh lá)
                                borderColor: "rgba(0, 128, 0, 1)", // Màu viền xanh lá
                                data: [28, 68, 40, 19, 96]
                            }]
                        };


                        var ctx3 = document.getElementById("canvas3").getContext("2d");
                        var myBarChart = new Chart(ctx3, {
                            type: 'bar',
                            data: BarChart,
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                },
                                plugins: {
                                    legend: {
                                        display: true,
                                    },
                                    title: {
                                        display: true,
                                        text: 'Bar Chart Example'
                                    }
                                }
                            }
                        });
                    </script>
                </div>

            </div>

            <div class="col-4">
                <canvas id="canvas3">
                    <script>
                        var myBarChart = new Chart(document.getElementById("canvas3").getContext("2d")).Bar(BarChart, {
                            scaleFontSize: 14,
                            scaleFontColor: "#ff8540"
                        });
                        var BarChart = {
                            labels: ["Ruby", "jQuery", "Java", "ASP.Net", "PHP"],
                            datasets: [{
                                fillColor: "rgba(151,249,190,0.5)",
                                strokeColor: "rgba(255,255,255,1)",
                                data: [13, 20, 30, 40, 50]
                            }, {
                                fillColor: "rgba(252,147,65,0.5)",
                                strokeColor: "rgba(255,255,255,1)",
                                data: [28, 68, 40, 19, 96]
                            }]
                        }
                    </script>
                </canvas>
            </div>
        </div>

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
                            <li class="pintrest pull-left"><a target="_blank" rel="nofollow" href="#"
                                    title="PInterest"></a>
                            </li>
                            <li class="linkedin pull-left"><a target="_blank" rel="nofollow" href="#"
                                    title="Linkedin"></a>
                            </li>
                            <li class="youtube pull-left"><a target="_blank" rel="nofollow" href="#"
                                    title="Youtube"></a>
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
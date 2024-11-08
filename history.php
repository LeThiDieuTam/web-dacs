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
    <link rel="stylesheet" href="./css/history.css">\

    <script src="script.js" defer></script>
    <script src="js.js" defer></script>
    <script src="history.js" defer></script>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="shortcut icon" href="image/vietnam.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <meta charset="UTF-8">
    <title>Trang của Bạn</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Forum&family=Inter:wght@100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
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
                <div class="fas fa-heart"></div>
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

    </header>
    <br><br>
    </div>
    <section class="parallax">
        <img src="image/hill1.png" id="hill1">
        <img src="image/hill2.png" id="hill2">
        <img src="image/hill3.png" id="hill3">
        <img src="image/hill4.png" id="hill4">
        <img src="image/nguoilinh3.png" id="nguoilinh3" width="50%">
        <img src="image/hill5.png" id="hill5">
        <img src="image/tree.png" id="tree">
        <img src="image/leaf.png" id="leaf">
        <img src="image/plant.png" id="plant">
        <h2 id="text">LỊCH SỬ VIỆT NAM</h2>
        <img src="image/plant.png" id="plant">

    </section>
    <br><br><br>

    <div class="sec">
        <div class="typewriter">
            <h1>Cột mốc quan trọng về lịch sử Việt Nam</h1>
        </div>
        <br><br><br>
        <div class="form-timeline">
            <div class="timeline-items">
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-date">
                        258 TCN - 257 TCN
                    </div>
                    <div class="timeline-content">
                        <h3>Chiến tranh Lạc Việt-Âu Việt</h3>
                        <p>Văn Lang (Lạc Việt) thời Hùng Vương</p>

                    </div>

                </div>
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-date">Nhà Thục (257 TCN - 207 TCN)
                    </div>
                    <div class="timeline-content">
                        <h3>Chiến tranh Bách Việt-Tần
                            (221 TCN - 214 TCN.Chiến tranh Âu Lạc-Nam Việt
                            (207 TCN hoặc 179 TCN)</h3>

                    </div>

                </div>
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-date">
                        258 TCN - 257 TCN
                    </div>
                    <div class="timeline-content">
                        <h3>Chiến tranh Lạc Việt-Âu Việt</h3>

                    </div>

                </div>
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-date">
                        258 TCN - 257 TCN
                    </div>
                    <div class="timeline-content">
                        <h3>Chiến tranh Lạc Việt-Âu Việt</h3>

                    </div>

                </div>
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-date">
                        258 TCN - 257 TCN
                    </div>
                    <div class="timeline-content">
                        <h3>Chiến tranh Lạc Việt-Âu Việt</h3>
                    </div>

                </div>
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-date">
                        258 TCN - 257 TCN
                    </div>
                    <div class="timeline-content">
                        <h3>Chiến tranh Lạc Việt-Âu Việt</h3>

                    </div>

                </div>
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-date">
                        258 TCN - 257 TCN
                    </div>
                    <div class="timeline-content">
                        <h3>Chiến tranh Lạc Việt-Âu Việt</h3>

                    </div>

                </div>
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-date">
                        258 TCN - 257 TCN
                    </div>
                    <div class="timeline-content">
                        <h3>Chiến tranh Lạc Việt-Âu Việt</h3>

                    </div>

                </div>
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-date">
                        258 TCN - 257 TCN
                    </div>
                    <div class="timeline-content">
                        <h3>Chiến tranh Lạc Việt-Âu Việt</h3>

                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-date">
                        258 TCN - 257 TCN
                    </div>
                    <div class="timeline-content">
                        <h3>Chiến tranh Lạc Việt-Âu Việt</h3>

                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-date">
                        258 TCN - 257 TCN
                    </div>
                    <div class="timeline-content">
                        <h3>Chiến tranh Lạc Việt-Âu Việt</h3>

                    </div>

                </div>
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-date">
                        258 TCN - 257 TCN
                    </div>
                    <div class="timeline-content">
                        <h3>Chiến tranh Lạc Việt-Âu Việt</h3>

                    </div>

                </div>
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-date">
                        258 TCN - 257 TCN
                    </div>
                    <div class="timeline-content">
                        <h3>Chiến tranh Lạc Việt-Âu Việt</h3>

                    </div>

                </div>
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-date">
                        258 TCN - 257 TCN
                    </div>
                    <div class="timeline-content">
                        <h3>Chiến tranh Lạc Việt-Âu Việt</h3>

                    </div>

                </div>
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-date">
                        258 TCN - 257 TCN
                    </div>
                    <div class="timeline-content">
                        <h3>Chiến tranh Lạc Việt-Âu Việt</h3>

                    </div>

                </div>
            </div>
        </div>
        <br><br>
        <h2> Chủ tịch vị lãnh tụ vĩ đại Việt Nam</h2>
        <section1 class="home " id="home">
            <div class="home-text" data-aos="fade-up" data-aos-duration="1400">
                <h4>Chủ tịch Hồ Chí Minh</h4>
                <h1>Ghi năm</h1>
                <p>Cột mốc quan trọng về lịch sử Việt Nam</p>
                <a href="#" class="btn2">Read more</a>
            </div>

            <div class="home-img " data-aos="zoom-in" data-aos-duration="1400">
                <img src="image/Treem/8.png" alt="">
            </div>

        </section1>
        <h2>Đại tướng vĩ đại Việt Nam</h2>
        <section1 class="about " id="about">
            <div class="about-img" data-aos="zoom-in" data-aos-duration="1400">
                <img src="image/Treem/9.png" alt="">

            </div>
            <div class="image-scroll">
                <div class="about-text" data-aos="fade-up" data-aos-duration="1400">
                    <h2>Võ Nguyên Giáp</h2>
                    <h4>....</h4>
                    <p>Ghi cột mốc</p>
                    <a href="#" class="btn2">Read more</a>
                </div>
            </div>
        </section1>
        <br><br><br>
        <h2>Thủ tướng vĩ đại Việt Nam</h2>
        <section1 class="home " id="home">
            <div class="home-text" data-aos="fade-up" data-aos-duration="1400">
                <h4>Phạm Văn Đồng</h4>
                <h1>Ghi năm</h1>
                <p>Cột mốc quan trọng về lịch sử Việt Nam</p>
                <a href="#" class="btn2">Read more</a>

            </div>

            <div class="home-img " data-aos="zoom-in" data-aos-duration="1400">
                <img src="image/Treem/11.png" alt="">
            </div>

        </section1>
        <br><br><br>
        <h2>Danh sách Anh hùng Lực lượng vũ trang nhân dân</h2>
        </section1>
        <section1 class="about " id="about">
            <div class="about-img" data-aos="zoom-in" data-aos-duration="1400">
                <img src="image/Treem/12.png" alt="">

            </div>
            <div class="image-scroll">
                <div class="about-text" data-aos="fade-up" data-aos-duration="1400">
                    <h2>Phan Đăng Lưu</h2>
                    <h4>....</h4>
                    <p>Ghi cột mốc</p>
                    <a href="#" class="btn2">Read more</a>
                </div>
            </div>
        </section1>
        <section1 class="home " id="home">
            <div class="home-text" data-aos="fade-up" data-aos-duration="1400">
                <h4>Cù Chính Lan</h4>
                <h1>Ghi năm</h1>
                <p>Cột mốc quan trọng về lịch sử Việt Nam</p>
                <a href="#" class="btn2">Read more</a>

            </div>

            <div class="home-img " data-aos="zoom-in" data-aos-duration="1400">
                <img src="image/Treem/14.png" alt="">
            </div>

        </section1>
        <section1 class="about " id="about">
            <div class="about-img" data-aos="zoom-in" data-aos-duration="1400">
                <img src="image/Treem/15.png" alt="">

            </div>
            <div class="image-scroll">
                <div class="about-text" data-aos="fade-up" data-aos-duration="1400">
                    <h2>La Văn Cầu</h2>
                    <h4>....</h4>
                    <p>Ghi cột mốc</p>
                    <a href="#" class="btn2">Read more</a>
                </div>
            </div>
        </section1>
        <section1 class="home " id="home">
            <div class="home-text" data-aos="fade-up" data-aos-duration="1400">
                <h4>Nguyễn Thị Chiên</h4>
                <h1>Ghi năm</h1>
                <p>Cột mốc quan trọng về lịch sử Việt Nam</p>
                <a href="#" class="btn2">Read more</a>
            </div>

            <div class="home-img " data-aos="zoom-in" data-aos-duration="1400">
                <img src="image/Treem/16.png" alt="">
            </div>

        </section1>
        <section1 class="about " id="about">
            <div class="about-img" data-aos="zoom-in" data-aos-duration="1400">
                <img src="image/Treem/17.png" alt="">

            </div>
            <div class="image-scroll">
                <div class="about-text" data-aos="fade-up" data-aos-duration="1400">
                    <h2>Nguyễn Quốc Trị</h2>
                    <h4>....</h4>
                    <p>Ghi cột mốc</p>
                    <a href="#" class="btn2">Read more</a>
                </div>
            </div>
        </section1>
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
    </footer>
    <script src=" https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            offset: 1,
        });
    </script>
</body>

</html>
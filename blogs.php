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
    <link rel="stylesheet" href="./css/donate.css">
    <script src="donate.js" defer></script>
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
            <div class="fas fa-shopping-cart" id="cart-btn"></div>
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
    <br><br>
    </div>

    <div class="sec">
        <h2>Nội dung khác</h2>
        <p>Đây là phần nội dung khác nằm bên dưới phần parallax.</p>

        <section class="parallax-home">
            <img src="image/sky.png" alt="" id="">
            <img src="image/moon.png" alt=" " id="moon">
            <img style="position: relative; top:20%" src="image/toanhavn7.png" alt=" " id="">
            <img src="image/left-city.png" alt=" " id="">
            <img src="image/water.png" alt=" " id="">
            <img src="image/right-city.png" alt=" " id="">
            <img src="image/train.png" alt="" id="train">
            <img src="image/rail.png" alt=" " id="">

            <img src="image/hill-left-1.png" alt="" id="">
            <img src="image/hill-right-1.png" alt="" id="">

        </section>
        <section class="about" id="about">
            <div class="info-box">
                <h2>Quyên góp </h2>
                <p style="font-size: 13px;"> "Hãy cùng chúng tôi lan tỏa yêu thương và
                    chia sẻ gánh nặng với những nạn nhân chất độc da cam và
                    thân nhân của các liệt sĩ. Mỗi đồng quyên góp đều có giá trị,
                    hãy góp sức để mang lại niềm vui và hy
                    vọng cho họ!</p>
                <a href="" class="btn1">Read More</a>
            </div>


            <img src="image/desert-sky.png " alt="">
            <img src="image/desert-moon.png " alt="" id="moon1">

            <img src="image/desert-rock.png " alt="desert-rock">
            <img src="image/waterfall.png" alt="" id="waterfall" class="about-waterfall">
            <img src="image/water.png" alt="">
            <img src="image/man.png" alt="" id="man">
            <img src="image/grass.png" alt="">

        </section>

    </div>
    </div>
</body>

</html>
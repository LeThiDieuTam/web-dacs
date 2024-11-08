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
    <title>Trang Chủ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="image/flag.png" type="image/x-icon">
    <link rel="stylesheet" href="style1trangchu.css">

    <!-- Bao gồm jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    // Chuyển đổi giữa chế độ ngày và đêm
    $(document).ready(function() {
        $("#switch").click(function() {
            if ($("#fullpage").hasClass("night")) {
                $("#fullpage").removeClass("night");
                $("#switch").removeClass("switched");
            } else {
                $("#fullpage").addClass("night");
                $("#switch").addClass("switched");
                // Thực hiện chuyển trang khi chuyển sang chế độ night
                setTimeout(function() {
                    document.body.classList.add('fade-out');
                    setTimeout(function() {
                        window.location.href =
                            "home.php"; // Đổi trang khi ở chế độ night
                    }, 1000); // Thời gian chờ cho hiệu ứng mờ dần (1 giây)
                }, 100); // Thời gian chờ ngắn trước khi bắt đầu hiệu ứng (100ms)
            }
        });
    });
    </script>

</head>

<body>
    <header>
        <div class="logout">
            <a href="login.php" class="btn btn-danger">Đăng xuất</a>
        </div>
    </header>
    <div id="fullpage">
        <div class="section">
            <div class="time-circle">
                <div class="sun"></div>
                <div class="moon">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                <div class="stars">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                <div class="water"></div>
            </div>
            <div class="slide-container">
                <div class="slide active">
                    <div id="intro-text">
                        <h1>Chào mừng đến HISTORY VIETNAM!</h1>
                        <p>Xin chào, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>!</p>
                        <p>Bạn đã đăng nhập thành công.</p>
                    </div>
                </div>
                <!-- Nút bấm -->
                <div id="switch">
                    <div id="circle"></div>
                </div>
            </div>
        </div>


    </div>
</body>

</html>
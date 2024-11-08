<?php
session_start();

// Kết nối cơ sở dữ liệu
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "user_registration";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST["username"]);
    $email = $conn->real_escape_string($_POST["email"]);
    $password = $_POST["password"];

    // Kiểm tra định dạng email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email không hợp lệ!";
    }
    // Kiểm tra độ dài mật khẩu (ví dụ: ít nhất 8 ký tự)
    elseif (strlen($password) < 8) {
        $error = "Mật khẩu phải có ít nhất 8 ký tự!";
    } else {
        // Kiểm tra xem email đã tồn tại chưa
        $checkEmailSql = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($checkEmailSql);

        if ($result && $result->num_rows > 0) {
            $error = "Email đã tồn tại!";
        } else {
            // Mã hóa mật khẩu trước khi lưu
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Chèn thông tin vào bảng users
            $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashedPassword')";

            if ($conn->query($sql) === TRUE) {
                $success = "Đăng ký thành công! Bạn có thể đăng nhập ngay bây giờ.";
            } else {
                $error = "Lỗi: " . $conn->error;
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="image/flag.png" type="image/x-icon">
    <link rel="stylesheet" href="./css/style.css" type="text/css">
    <style>
    html,
    body {
        height: 100%;
        margin: 0;
        overflow: hidden;
        /* Ẩn thanh cuộn */
    }

    body {
        font-family: Arial, sans-serif;
        background-image: url('image/hinh-anh-xe-tang-tien-vao-dinh-doc-lap.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 0;
        margin: 0;
    }

    /* Các quy tắc khác cho các phần tử khác */

    .container {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        width: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #ccc;
    }



    button[type="submit"] {
        width: 100%;
        background-color: #4CAF50;
        color: white;
        padding: 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    button[type="submit"]:hover {
        background-color: #45a049;
    }

    .error-message {
        color: red;
        text-align: center;
        margin-bottom: 15px;
    }

    .social-login {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }

    .social-login button {
        width: 48%;
        padding: 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .social-login button img {
        margin-right: 8px;
        width: 24px;
        height: 24px;
    }

    .facebook-btn {
        background-color: #3b5998;
        color: white;
    }

    .google-btn {
        background-color: #db4437;
        color: white;
    }

    @media screen and (max-width: 1200px) {
        .container {
            max-width: 90%;
        }
    }

    @media screen and (max-width: 992px) {
        .container {
            max-width: 80%;
        }

        .social-login button {
            width: 100%;
            margin-bottom: 10px;
        }
    }

    @media screen and (max-width: 768px) {
        body {
            padding: 20px;
            background-attachment: scroll;
        }

        h2 {
            font-size: 1.8em;
        }

        button[type="submit"] {
            font-size: 14px;
        }

        .social-login {
            flex-direction: column;
        }

        .row {
            flex-direction: column;
        }

        .col-7,
        .col-5 {
            width: 100%;
            text-align: center;
        }

        .col-5 img {
            width: 40px;
        }
    }

    @media screen and (max-width: 576px) {
        .container {
            padding: 15px;
            margin-left: 70px;
        }

        h2 {
            font-size: 1.5em;
        }


        button[type="submit"] {
            font-size: 14px;
            padding: 10px;
        }

        .social-login img {
            width: 20px;
            height: 20px;
        }
    }

    @media screen and (max-width: 480px) {
        .container {
            max-width: 100%;
            padding: 20px;
        }

        h2 {
            font-size: 1.2em;
        }

        .row {
            flex-direction: column;
        }

        input[type="email"],
        input[type="password"] {
            padding: 8px;
        }

        button[type="submit"] {
            font-size: 14px;
            padding: 8px;
        }

        .social-login img {
            width: 16px;
            height: 16px;
        }
    }

    .fruit {
        position: absolute;
        width: 60px;
        height: 60px;
        background-repeat: no-repeat;
        background-size: contain;
        pointer-events: none;
        animation: fruitAnimation 10s infinite linear;
    }

    .fruit1 {
        background-image: url('image/travel.png');
    }

    .fruit2 {
        background-image: url('image/ho-chi-minh-mausoleum.png');
    }

    .fruit3 {
        background-image: url('image/rice.png');
    }

    .fruit4 {
        background-image: url('image/vietnamese.png');
    }

    @keyframes fruitAnimation {
        0% {
            transform: translate(0, 0);
        }

        50% {
            transform: translate(100vw, -100vh);
        }

        100% {
            transform: translate(0, 0);
        }

        150% {
            transform: translate(0, 0);
        }
    }

    html,
    body {
        cursor: url("https://1.bp.blogspot.com/-qbWo9mPKO2Y/YL9utYdQBdI/AAAAAAAAFs4/mtjGu6u2uGwtJsT4gZG4lbhLV1a5lG6OQCLcBGAsYHQ/s0/mouse-f1.png"), auto;
    }

    a:hover {
        cursor: url("https://1.bp.blogspot.com/-nYv2dLl3oXY/YL9utYBCh8I/AAAAAAAAFtA/wII4lVw5w4k-4isGMY41heTqk8U4TJujgCLcBGAsYHQ/s0/mouse-f2.png"), auto;
    }
    </style>
</head>

<body>
    <div class="background-animation">
        <div class="fruit fruit1"></div>
        <div class="fruit fruit2"></div>
        <div class="fruit fruit3"></div>
        <div class="fruit fruit4"></div>
    </div>
    <div class="container">
        <h2><strong>Signup Here!!!</strong></h2>
        <?php if ($error): ?>
        <div class="error-message"><?php echo $error; ?></div>
        <?php elseif ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
        <script>
        setTimeout(function() {
            window.location.href = "login.php";
        }, 2000);
        </script>
        <?php endif; ?>

        <form method="post" action="">
            <div class="mb-3 inputBox">
                <input type="text" id="username" name="username" required="required"
                    value="<?php echo htmlspecialchars($_POST['username'] ?? '', ENT_QUOTES); ?>">
                <span>Username</span>
            </div>
            <div class="mb-3 inputBox">
                <input type="email" id="email" name="email" required="required"
                    value="<?php echo htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES); ?>">
                <span>Email</span>
            </div>
            <div class="mb-3 inputBox">
                <input type="password" id="password" name="password" required="required">
                <span>Password</span>
            </div>
            <button class="button signup-btn" type="submit" style="--clr:#28a745">
                <span>Đăng kí</span><i></i>
            </button>
        </form>


        <div class="social-login">
            <button class="facebook-btn button" onclick="window.location.href='https://www.facebook.com/'">
                <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg"
                    alt="Facebook">
                Facebook
            </button>
            <button class="google-btn button"
                onclick="window.location.href='https://www.google.com/intl/vi/gmail/about/'">
                <img src="image/google.png" alt="Google">
                Google
            </button>
        </div>
        <div class="row">
            <div class="col-8 my-3">
                <p style="color: #ccc;">Bạn chưa có tài khoản?</p>
            </div>
            <div class="col-3">
                <a href="login.php"><img style="width: 50px;" src="image/right-arrow.png"></a>
            </div>
        </div>
</body>

</html>
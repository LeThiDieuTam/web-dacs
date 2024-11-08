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
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quyên Góp</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .form-donate {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .donation-form h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .btn-primary {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-primary:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Hiển thị thông báo nếu có -->
        <?php if ($message): ?>
            <div id="notification" class="alert alert-success" role="alert">
                <?php echo htmlspecialchars($message); ?>
            </div>
            <script>
                // Tự động xóa thông báo sau 2 giây
                setTimeout(function() {
                    document.getElementById('notification').style.display = 'none';
                }, 2000);
            </script>
        <?php endif; ?>

        <div class="form-donate">
            <div class="donation-form">
                <h1>Form Quyên Góp</h1>
                <form action="donate1.php" method="POST">
                    <div class="form-group">
                        <label for="amount">Số tiền quyên góp</label>
                        <input type="number" id="amount" name="amount" class="form-control"
                            placeholder="Số tiền quyên góp" required>
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
</body>

</html>
div class="timeline-items">
<div class="timeline-item">
    <div class="timeline-dot">
        <div class="timeline-data">1980
        </div>
        <div class="timeline-content">
            <h3>Chủ tịch Hồ Chí Minh</h3>
            <p>bác Hồ ra đi tìm đường cứu nước</p>
        </div>
    </div>
</div>
<div class="banner ">
    <div class="slider" style="--quantity:10">
        <div class="item" style="--position: 1"><img src="image/hinh-anh-xe-tang-tien-vao-dinh-doc-lap.jpg"
                alt="Image 1">
            <div class="caption">Chiến thắng 30/4/1975.<p>Victory on April 30, 1975.</p>
            </div>
        </div>
        <div class="item" style="--position: 2"><img
                src="https://vienkiemsat.haiduong.gov.vn/uploads/news/2023_09/img_697_0_1693534557.png" alt="Image 2">
            <div class="caption">Chủ tịch Hồ Chí Minh đọc bản Tuyên Ngôn độc lập 2/9/1945. <p>President Ho
                    Chi
                    Minh
                    read the Declaration of Independence September 2, 1945.</p>
            </div>
        </div>
        <div class="item" style="--position: 3"><img
                src="https://icdn.dantri.com.vn/oYFp4wxLk7Q3Y2XcWsQ4489qiYdFDF/Image/2015/04/2.-vietnam-woman-flees-children-burning-village-1429569495-af683.jpg"
                alt="Image 3">
            <div class="caption">Lính chính quyền Sài Gòn đốt cháy tháng 7/1963.<p>Saigon government
                    soldiers
                    burned
                    it in July 1963.</p>
            </div>
        </div>
        <div class="item" style="--position: 4"><img
                src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRaI5f0ga_y4YD5hSrrYSZIvF8tl8X__BhHag&s"
                alt="Image 4">
            <div class="caption">Hoạt động quân sự của đồng minh Mỹ trong chiến tranh Việt Nam.<p>Military
                    operations of American allies during the Vietnam War.</p>
            </div>
        </div>
        <div class="item" style="--position: 5"><img
                src="https://baohaiquanvietnam.vn/storage/users/user_8/Nam%202019/Cuu%20ngu%20dan%20PLP/chien-tranh-bien-gioi-5-4fa4b-0-0-255-500-crop-1406570348787-1548824325963307103077.jpg"
                alt="Image 5">
            <div class="caption">Chiến tranh Tháng 2 năm 1979: Một cuộc chiến vô nghĩa, trái đạo lý và thảm
                bại.
                <p>
                    War in February 1979: A meaningless, immoral and disastrous war.
                </p>
            </div>
        </div>
        <div class="item" style="--position: 6"><img
                src="https://cdn.tuyengiao.vn/uploads/2024/04/21/22/cq-259-1713677829.jpeg?s=jwpg0qc-4xq" alt="Image 6">
            <div class="caption">Chiến thắng Điện Biên Phủ: Sức mạnh đại đoàn kết toàn dân tộc thời đại Hồ
                Chí
                Minh.Dien Bien Phu Victory: The strength of great national unity in the Ho Chi Minh era.
                <p></p>
            </div>
        </div>
        <div class="item" style="--position: 7"><img
                src="https://photo.znews.vn/w660/Uploaded/lce_cqdjw/2019_07_10/ezgifcomwebptojpg_14.jpg" alt="Image 7">
            <div class="caption">Bức ảnh năm 1968 được chụp, hàng hoạt tiếng súng.<p>In this 1968 photo, a
                    series of
                    gunshots are heard.</p>
            </div>
        </div>
        <div class="item" style="--position: 8"><img
                src="https://redsvn.net/wp-content/uploads/2018/02/China-invade-Vietnam-1979.jpg" alt="Image 8">
            <div class="caption">Cuộc chiến phi nghĩa do Trung Quốc khởi xướng năm 1979.<p>Unjust war
                    initiated
                    by
                    China in 1979.</p>
            </div>
        </div>
        <div class="item" style="--position: 9"><img
                src="https://redsvn.net/wp-content/uploads/2017/05/Vietnam-War-01.jpg" alt="Image 9">
            <div class="caption">Trực thăng Mỹ nã đạn vào những bụi cây để ểm trợ cho bộ binh VNCH.<p>
                    American
                    helicopters fired into the bushes to support the ARVN infantry.</p>
            </div>
        </div>
        <div class="item" style="--position: 10"><img
                src="https://cdn-i.vtcnews.vn/files/phamthinh/2019/07/22/chien-si-cam-b41-lang-son-8-0754065.jpg"
                alt="Image 10">
            <div class="caption">Người lính trong bức ảnh ‘biểu tượng nhất’ cuộc chiến chống Trung Quốc.<p>
                    The
                    soldier in the 'most iconic' photo of the war against Chinese.</p>
            </div>
        </div>

    </div>
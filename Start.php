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
    <title>Slider</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="banner">
        <div class="slider" style="--quantity:10">
            <div class="item" style="--position: 1"><img src="image/hinh-anh-xe-tang-tien-vao-dinh-doc-lap.jpg"
                    alt="Image 1">
                <div class="caption">Chiến thắng 30/4/1975.<p>Victory on April 30, 1975.</p>
                </div>
            </div>
            <div class="item" style="--position: 2"><img
                    src="https://vienkiemsat.haiduong.gov.vn/uploads/news/2023_09/img_697_0_1693534557.png"
                    alt="Image 2">
                <div class="caption">Chủ tịch Hồ Chí Minh đọc bản Tuyên Ngôn độc lập 2/9/1945. <p>President Ho Chi Minh
                        read the Declaration of Independence September 2, 1945.</p>
                </div>
            </div>
            <div class="item" style="--position: 3"><img
                    src="https://icdn.dantri.com.vn/oYFp4wxLk7Q3Y2XcWsQ4489qiYdFDF/Image/2015/04/2.-vietnam-woman-flees-children-burning-village-1429569495-af683.jpg"
                    alt="Image 3">
                <div class="caption">Lính chính quyền Sài Gòn đốt cháy tháng 7/1963.<p>Saigon government soldiers burned
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
                <div class="caption">Chiến tranh Tháng 2 năm 1979: Một cuộc chiến vô nghĩa, trái đạo lý và thảm bại.<p>
                        War in February 1979: A meaningless, immoral and disastrous war.
                    </p>
                </div>
            </div>
            <div class="item" style="--position: 6"><img
                    src="https://cdn.tuyengiao.vn/uploads/2024/04/21/22/cq-259-1713677829.jpeg?s=jwpg0qc-4xq"
                    alt="Image 6">
                <div class="caption">Chiến thắng Điện Biên Phủ: Sức mạnh đại đoàn kết toàn dân tộc thời đại Hồ Chí
                    Minh.Dien Bien Phu Victory: The strength of great national unity in the Ho Chi Minh era.
                    <p></p>
                </div>
            </div>
            <div class="item" style="--position: 7"><img
                    src="https://photo.znews.vn/w660/Uploaded/lce_cqdjw/2019_07_10/ezgifcomwebptojpg_14.jpg"
                    alt="Image 7">
                <div class="caption">Bức ảnh năm 1968 được chụp, hàng hoạt tiếng súng.<p>In this 1968 photo, a series of
                        gunshots are heard.</p>
                </div>
            </div>
            <div class="item" style="--position: 8"><img
                    src="https://redsvn.net/wp-content/uploads/2018/02/China-invade-Vietnam-1979.jpg" alt="Image 8">
                <div class="caption">Cuộc chiến phi nghĩa do Trung Quốc khởi xướng năm 1979.<p>Unjust war initiated by
                        China in 1979.</p>
                </div>
            </div>
            <div class="item" style="--position: 9"><img
                    src="https://redsvn.net/wp-content/uploads/2017/05/Vietnam-War-01.jpg" alt="Image 9">
                <div class="caption">Trực thăng Mỹ nã đạn vào những bụi cây để ểm trợ cho bộ binh VNCH.<p>American
                        helicopters fired into the bushes to support the ARVN infantry.</p>
                </div>
            </div>
            <div class="item" style="--position: 10"><img
                    src="https://cdn-i.vtcnews.vn/files/phamthinh/2019/07/22/chien-si-cam-b41-lang-son-8-0754065.jpg"
                    alt="Image 10">
                <div class="caption">Người lính trong bức ảnh ‘biểu tượng nhất’ cuộc chiến chống Trung Quốc.<p>The
                        soldier in the 'most iconic' photo of the war against Chinese.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const animatedText = document.getElementById('animatedText');

        // Lắng nghe khi animation kết thúc
        animatedText.addEventListener('animationend', function(event) {
            if (event.animationName === 'typewriter') { // Kiểm tra xem animation nào đã kết thúc
                // Chuyển hướng đến trang video.php
                window.location.href = 'video.php';
            }
        });
    });
    </script>

</body>

</html>
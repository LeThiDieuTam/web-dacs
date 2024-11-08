<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .content {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 50px 0;
        }

        .fade-in {
            opacity: 0;
            transition: opacity 0.8s ease-in-out, transform 0.8s ease-in-out;
            /* Tăng thời gian chuyển tiếp */
            transform: translateY(30px);
            /* Dịch xuống nhiều hơn */
            text-align: center;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            /* Bo góc hình ảnh để đẹp hơn */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            /* Thêm bóng cho hình ảnh */
        }

        p {
            margin-top: 10px;
            /* Tăng khoảng cách giữa hình ảnh và văn bản */
            font-size: 18px;
            /* Điều chỉnh kích thước chữ */
            color: #333;
            /* Màu chữ */
        }
    </style>
</head>

<body>
    <div class="content">
        <div class="fade-in">
            <img src="image/fef79bb1-9c30-4a5c-928b-069cac81541c.jpg" alt="Hình 1">
            <p>Văn bản cho hình 1</p>
        </div>
        <div class="fade-in">
            <img src="image/f-1629623759158.png" alt="Hình 2">
            <p>Văn bản cho hình 2</p>
        </div>
        <div class="fade-in">
            <img src="image/f-1629623759158.png" alt="Hình 3">
            <p>Văn bản cho hình 3</p>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const fadeIns = document.querySelectorAll('.fade-in');

            const checkScroll = () => {
                fadeIns.forEach(fadeIn => {
                    const rect = fadeIn.getBoundingClientRect();
                    if (rect.top < window.innerHeight && rect.bottom >= 0) {
                        fadeIn.classList.add('visible');
                    } else {
                        fadeIn.classList.remove('visible'); // Xóa lớp khi không còn trong viewport
                    }
                });
            };

            window.addEventListener('scroll', checkScroll);
            checkScroll(); // Kiểm tra ngay từ đầu
        });
    </script>
</body>

</html>
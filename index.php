<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Form Quyên Góp</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
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
    </style>
</head>

<body>
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
</body>

</html>
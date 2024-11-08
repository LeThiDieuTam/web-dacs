<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Trang Yêu Thích</title>
</head>

<body>

    <h2>Sản phẩm yêu thích</h2>
    <ul id="favorites-list"></ul>

    <script>
        const favorites = JSON.parse(localStorage.getItem('favorites')) || [];

        function updateFavoritesList() {
            const favoritesList = document.getElementById('favorites-list');
            favoritesList.innerHTML = '';

            favorites.forEach(id => {
                const listItem = document.createElement('li');
                listItem.textContent = `Sản phẩm ID: ${id}`;
                favoritesList.appendChild(listItem);
            });
        }

        updateFavoritesList();
    </script>

</body>

</html>
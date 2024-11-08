document.addEventListener('DOMContentLoaded', () => {
    let menuBtn = document.querySelector('#menu-btn');
    let cartBtn = document.querySelector('#cart-btn');
    let searchBtn = document.querySelector('#search-btn');
    
    let navbar = document.querySelector('.navbar');
    let searchFormContainer = document.querySelector('.search-form');
    let cartItemsContainer = document.querySelector('.cart-items-container');

    // Khởi tạo trạng thái
    navbar.classList.remove('active');
    searchFormContainer.classList.remove('active');
    cartItemsContainer.classList.remove('active');

    // Xử lý nhấn nút menu
    menuBtn.onclick = () => {
        navbar.classList.toggle('active'); // Thêm hoặc xóa class active
        searchFormContainer.classList.remove('active'); // Ẩn ô tìm kiếm
        cartItemsContainer.classList.remove('active'); // Ẩn giỏ hàng
    };

    // Xử lý nhấn nút giỏ hàng
    cartBtn.onclick = () => {
        cartItemsContainer.classList.toggle('active'); // Thêm hoặc xóa class active
        navbar.classList.remove('active'); // Ẩn navbar
        searchFormContainer.classList.remove('active'); // Ẩn ô tìm kiếm
    };

    // Xử lý nhấn nút tìm kiếm
    searchBtn.onclick = () => {
        searchFormContainer.classList.toggle('active'); // Thêm hoặc xóa class active
        navbar.classList.remove('active'); // Ẩn navbar
        cartItemsContainer.classList.remove('active'); // Ẩn giỏ hàng
    };
});

// Ẩn các phần tử khi cuộn
window.onscroll = () => {
    let navbar = document.querySelector('.navbar');
    let searchFormContainer = document.querySelector('.search-form');
    let cartItemsContainer = document.querySelector('.cart-items-container');

    navbar.classList.remove('active');
    searchFormContainer.classList.remove('active');
    cartItemsContainer.classList.remove('active');
};
// Lấy nút ngôn ngữ
    // Hàm này kiểm tra chiều cao của banner và phát hiện khi người dùng cuộn vượt qua banner
    let lastScrollPosition = 0;
    const video = document.getElementById('background-video');
    let hasMutedAfter5Minutes = false; // Biến để kiểm soát việc tắt âm thanh sau 5 phút
    
    // Bắt sự kiện cuộn trang
    window.addEventListener('scroll', function() {
        const currentScrollPosition = window.pageYOffset || document.documentElement.scrollTop;
    
        if (currentScrollPosition > lastScrollPosition) {
            // Người dùng đang cuộn xuống, tắt âm thanh
            video.muted = true;
        } else {
            // Người dùng cuộn lên, bật lại âm thanh nếu chưa qua 5 phút
            if (!hasMutedAfter5Minutes) {
                video.muted = false;
            }
        }
    
        // Cập nhật vị trí cuộn
        lastScrollPosition = currentScrollPosition <= 0 ? 0 : currentScrollPosition;
    });
    
    // Kiểm tra thời gian phát video và tắt âm thanh sau 5 phút
    video.addEventListener('timeupdate', function() {
        const audioDurationLimit = 250; // Thời gian giới hạn phát âm thanh (300 giây = 5 phút)
    
        if (video.currentTime >= audioDurationLimit && !hasMutedAfter5Minutes) {
            video.muted = true; // Tắt âm thanh sau 5 phút
            hasMutedAfter5Minutes = true; // Đánh dấu rằng âm thanh đã bị tắt
        }
    });
    
   // Chọn tất cả các phần tử có lớp "fade-in-image"
const fadeInImages = document.querySelectorAll('.fade-in-image');

// Hàm kiểm tra nếu phần tử ở trong khung nhìn
function checkVisibility() {
    fadeInImages.forEach(image => {
        const rect = image.getBoundingClientRect();
        if (rect.top < window.innerHeight && rect.bottom > 0) {
            // Chỉ thêm lớp 'show' nếu nó chưa có, để không bị lặp lại
            if (!image.classList.contains('show')) {
                image.classList.add('show');
            }
        }
    });
}

// Lắng nghe sự kiện cuộn và kiểm tra hiển thị
window.addEventListener('scroll', checkVisibility);

// Kiểm tra hiển thị ngay khi tải trang
checkVisibility();
document.addEventListener("DOMContentLoaded", function() {
    const fadeIns = document.querySelectorAll('.fade-in');

    const checkScroll = () => {
        fadeIns.forEach(fadeIn => {
            const rect = fadeIn.getBoundingClientRect();
            if (rect.top < window.innerHeight && rect.bottom >= 0) {
                fadeIn.classList.add('visible');
            } else {
                fadeIn.classList.remove('visible');
            }
        });
    };

    window.addEventListener('scroll', checkScroll);
    checkScroll(); // Kiểm tra ngay từ đầu
});
let currentIndex = 0; // Để theo dõi chỉ số hiện tại
const itemsToShow = 3; // Số lượng hình ảnh hiển thị trên mỗi lần cuộn
const totalItems = document.querySelectorAll('.fade-in-image').length; // Tổng số hình ảnh

function scrollLeft() {
    const row = document.getElementById("imageRow");
    if (currentIndex > 0) {
        currentIndex--;
        row.style.transform = `translateX(-${(currentIndex * (100 / itemsToShow))}%)`;
    }
}

function scrollRight() {
    const row = document.getElementById("imageRow");
    if (currentIndex < totalItems - itemsToShow) {
        currentIndex++;
        row.style.transform = `translateX(-${(currentIndex * (100 / itemsToShow))}%)`;
    }
}

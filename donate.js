let moon = document.getElementById("moon");
let text = document.getElementById("text");
let train = document.getElementById("train");
let man = document.getElementById("man");
let moon1 = document.getElementById("moon1");

window.addEventListener("scroll", () => {
    let value = window.scrollY;

    // Di chuyển moon lên xuống
    moon.style.marginTop = (100 + value * 0.5) + "px"; 

    // Di chuyển waterfall (thay đổi vị trí nếu cần)

    // Di chuyển man
    man.style.transform = `translate(${value * .3}px, 0)`; // Điều chỉnh giá trị để thay đổi tốc độ di chuyển

    // Di chuyển train nếu có
    if (train) {
        train.style.left = value * 1.5 + 'px'; 
        moon1.style.marginTop = (100 + value * 0.5) + "px"; 

        // Điều chỉnh tỷ lệ di chuyển

    }
});
let lists = document.querySelectorAll('.item1'); // Lấy tất cả các phần tử .item

document.getElementById('next').onclick = function() {
    if (lists.length > 0) { // Kiểm tra xem có phần tử nào không
        document.getElementById('slide').appendChild(lists[0]); // Di chuyển phần tử đầu tiên vào cuối
        lists = document.querySelectorAll('.item1'); // Cập nhật lại danh sách sau khi thay đổi
    }
};

document.getElementById('prev').onclick = function() {
    if (lists.length > 0) { // Kiểm tra xem có phần tử nào không
        document.getElementById('slide').prepend(lists[lists.length - 1]); // Di chuyển phần tử cuối cùng lên đầu
        lists = document.querySelectorAll('.item1'); // Cập nhật lại danh sách sau khi thay đổi
    }
};

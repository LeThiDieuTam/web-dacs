let text = document.getElementById('text');
let leaf = document.getElementById('leaf');
let hill1 = document.getElementById('hill1');
let hill4 = document.getElementById('hill4');
let hill5 = document.getElementById('hill5');
let tree = document.getElementById('tree');

window.addEventListener('scroll', () => {
  let value = window.scrollY;

  // Giới hạn di chuyển để không tràn vào phần header
  let maxScroll = 200; // Bạn có thể điều chỉnh giá trị này
  
  // Kiểm soát việc di chuyển của text và hill1
  if (value <= maxScroll) {
    text.style.marginTop = value * 2.5 + 'px';
    hill1.style.top = value * 1 + 'px';
  }

  // Các hiệu ứng khác
  leaf.style.top = value * -1.5 + 'px';
  leaf.style.left = value * 1.5 + 'px';
  hill5.style.left = value * 1.5 + 'px';
  hill4.style.left = value * -1.5 + 'px';
   tree.style.left= value * 1.5 + 'px';


});

window.addEventListener('scroll', function() {
  let scrollPosition = window.pageYOffset;
  document.querySelector('.water-background').style.transform = 'translateY(' + scrollPosition * 0.5 + 'px)';
});
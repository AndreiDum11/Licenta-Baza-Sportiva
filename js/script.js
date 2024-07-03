let menu = document.querySelector('#btn-meniu');
let navbar = document.querySelector('.header .navbar');
menu.onclick =()=>{
    menu.classList.toggle('fa-times');
    navbar.classList.toggle('active');
};
menu.onscroll =()=>{
    menu.classList.remove('fa-times');
    navbar.classList.remove('active');
};
var swiper = new Swiper(".home-slider", {
    loop:true,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
  });
let loadMoreBtn = document.querySelector('.evenimente .load-more .btn');
let currentItem =0;
loadMoreBtn.onclick=()=>{
    let boxes = [...document.querySelectorAll('.evenimente .box-container .box')];
    for( var i = currentItem; i < currentItem + 3;i++){
        boxes[i].style.display = 'inline-block';
    }
    currentItem+=3;
    if(currentItem>=boxes.length){
        loadMoreBtn.style.display = 'none';
    }
};
function openModal() {
    document.getElementById("myModal").style.display = "block";
  }
  
  function closeModal() {
    document.getElementById("myModal").style.display = "none";
  }
  
  var slideIndex = 1;
  showSlides(slideIndex);
  
  function plusSlides(n) {
    showSlides(slideIndex += n);
  }
  
  function currentSlide(n) {
    showSlides(slideIndex = n);
  }
  
  function showSlides(n) {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    var dots = document.getElementsByClassName("demo");
    var captionText = document.getElementById("caption");
    if (n > slides.length) {
      slideIndex = 1
    }
    if (n < 1) {slideIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex-1].style.display = "block";
    dots[slideIndex-1].className += " active";
    captionText.innerHTML = dots[slideIndex-1].alt;
  };

//javascript for navigation bar effect on scroll
window.addEventListener("scroll", function(){
	var header = document.querySelector("header");
	header.classList.toggle('sticky', window.scrollY > 0);
});

//javascript for responsive navigation sidebar menu
var menu = document.querySelector('.menu');
var menuBtn = document.querySelector('.menu-btn');
var closeBtn = document.querySelector('.close-btn');

menuBtn.addEventListener("click", () => {
    menu.classList.add('active');
});

closeBtn.addEventListener("click", () => {
    menu.classList.remove('active');
});


//char count
var myText = document.getElementById("message");
var current_count = document.getElementById("current_count");

myText.addEventListener("keyup", function() {
    var characters = myText.value.split('');
    current_count.innerText = characters.length;
});
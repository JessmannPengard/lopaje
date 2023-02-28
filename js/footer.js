window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    document.getElementById("scroll-top-button").style.display = "block";
  } else {
    document.getElementById("scroll-top-button").style.display = "none";
  }
}

document.getElementById("scroll-top-button").onclick = function() {
  scrollToTop();
};

function scrollToTop() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}
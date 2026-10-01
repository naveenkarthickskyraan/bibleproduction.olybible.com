window.onscroll = function(ev) {
    lazyload();
}
function lazyload() {
    var lazyImage = document.getElementsByClassName("lazyload");
    for(var i=0; i< lazyImage.length;i++) {
        if(elementInViewport(lazyImage[i])) {
            lazyImage[i].setAttribute('src',lazyImage[i].getAttribute('data-src'));
        }
    }
}
function elementInViewport(el) {
    var rect = el.getBoundingClientRect ();
    return (
        rect.top >=0 &&
        rect.left >=0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)

    );
}
function myFunction() {
       document.getElementById('loadmore').style.display = 'none';
       document.getElementById('mybtn').style.display = 'none';
       document.getElementById('loadmore').style.display = 'block';
    //   document.getElementById('myBtn').style.display = 'none';
     }
    
// document.getElementById('myBtn').addEventListener('click', myFunction);



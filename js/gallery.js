let displayedImg = document.querySelector('.displayed-img')
let thumbBar = document.querySelector('.thumb-bar');

let images = document.querySelectorAll('.imgs img');

displayedImg.src = images[0].src;

thumbBar.addEventListener('click', ev => {
    target = ev.target;
    if (target.classList.contains('private')) {
        console.log('PRIVATE');
    } else if (target.tagName === 'IMG') {
        displayedImg.src = target.src;
    }
})

if (document.cookie.includes('presence')) {
    for (img of images) {
        img.classList.remove('private');
    }
}

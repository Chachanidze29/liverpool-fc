let displayedImg = document.querySelector('.displayed-img')
let thumbBar = document.querySelector('.thumb-bar');

thumbBar.addEventListener('click', ev => {
    target = ev.target;
    if (target.classList.contains('private')) {
        console.log('PRIVATE');
    } else if (target.tagName === 'IMG') {
        displayedImg.src = target.src;
    }
})

if (document.cookie.includes('presence')) {
    for (item of thumbBar.children) {
        if (item.tagName === 'IMG') {
            item.classList.remove('private');
        }
    }
}

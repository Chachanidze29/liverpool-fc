let exitBtn = document.querySelector('.message button');
let exitCont = document.querySelector('.message');

if (exitBtn) {
    exitBtn.addEventListener('click', () => {
        exitCont.style.display = 'none';
        document.location.href = document.location.href.substring(0, document.location.href.lastIndexOf('?'));
    })
}